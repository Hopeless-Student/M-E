<?php
require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ .'/../includes/database.php';
require_once __DIR__ .'/../auth/auth.php';
require_once __DIR__ .'/paymongo.php';

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header("Location: checkout.php");
    exit;
}

$pdo = connect();
$user_id = $user['user_id'];
$payment_method = $_POST['payment_method'];
$special_instructions = $_POST['instructions'] ?? '';
$final_amount = (float) $_POST['final_amount'];
$selectedItems = json_decode($_POST['selectedItems'], true);

if(empty($selectedItems)){
    die("No items selected for checkout.");
}

$orderNumber = 'ORD-' . date("ymd") . '-' . substr(uniqid(), -3);

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("INSERT INTO orders(
        user_id, order_number, total_amount, shipping_fee, final_amount,
        payment_method, order_status, delivery_address, contact_number,
        special_instructions, confirmed_at, admin_notes
    ) VALUES (
        :user_id, :order_number, :total_amount, :shipping_fee, :final_amount,
        :payment_method, :order_status, :delivery_address, :contact_number,
        :special_instructions, :confirmed_at, :admin_notes
    )");

    $stmt->execute([
        ':user_id' => $user_id,
        ':order_number' => $orderNumber,
        ':total_amount' => $final_amount - 75,
        ':shipping_fee' => 75.00,
        ':final_amount' => $final_amount,
        ':payment_method' => $payment_method,
        ':order_status' => 'Pending',
        ':delivery_address' => $user['address'],
        ':contact_number' => $user['contact_number'],
        ':special_instructions' => $special_instructions,
        ':confirmed_at' => null,
        ':admin_notes' => 'Checkout created'
    ]);

    $orderId = $pdo->lastInsertId();

    $itemStmt = $pdo->prepare("INSERT INTO order_items(order_id, product_id, product_name, product_price, quantity, subtotal)
                               VALUES (:order_id, :product_id, :product_name, :product_price, :quantity, :subtotal)");
    $stockStmt = $pdo->prepare("UPDATE products SET stock_quantity = stock_quantity - ?
                                WHERE product_id = ? AND stock_quantity >= ?");

    foreach($selectedItems as $item){
        $itemStmt->execute([
            ':order_id' => $orderId,
            ':product_id' => $item['product_id'],
            ':product_name' => $item['product_name'],
            ':product_price' => $item['price'],
            ':quantity' => $item['quantity'],
            ':subtotal' => $item['price'] * $item['quantity']
        ]);

        $stockStmt->execute([$item['quantity'], $item['product_id'], $item['quantity']]);
        if($stockStmt->rowCount() === 0){
            throw new Exception("Not enough stock for product ID {$item['product_id']}");
        }
    }

    $calculatedTotal = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $selectedItems)) + 75;
    if(abs($calculatedTotal - $final_amount) > 0.01){
        throw new Exception("Final amount mismatch.");
    }

    switch($payment_method){
        case 'GCash':
        case 'Card':
            $successUrl = $_ENV['APP_URL'] . "/pages/thank-you.php?order_id=$orderId";
            $link = createPaymentLink($final_amount, "Order #$orderNumber", "Checkout for Order #$orderNumber", $orderId, $orderNumber, $successUrl);

            if(!empty($link['data']['attributes']['checkout_url'])){
                $pdo->commit();
                header("Location: " . $link['data']['attributes']['checkout_url']);
                exit;
            }
            throw new Exception("Failed to create payment link.");

        case 'COD':
            $codToken = bin2hex(random_bytes(16));
            $pdo->prepare("UPDATE orders SET cod_token=? WHERE order_id=?")->execute([$codToken, $orderId]);

            $ids = array_column($selectedItems, 'product_id');
            $placeholders = implode(',', array_fill(0, count($ids), '?'));
            $stmt = $pdo->prepare("DELETE FROM shopping_cart WHERE user_id=? AND product_id IN ($placeholders)");
            $stmt->execute(array_merge([$user_id], $ids));

            $pdo->commit();
            header("Location: cod.php?order_id=$orderId&token=$codToken");
            exit;

        default:
            throw new Exception("Invalid payment method.");
    }

} catch(Exception $e){
    $pdo->rollBack();
    die("Checkout failed: " . $e->getMessage());
}
