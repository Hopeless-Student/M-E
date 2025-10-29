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
$final_amount = $_POST['final_amount'];


// Decode the selected items from checkout.php
$selectedItems = json_decode($_POST['selectedItems'], true);
if(empty($selectedItems)){
    echo "No items selected for checkout.";
    exit;
}

$orderNumber = 'ORD-' . date("ymd"). '-' . substr(uniqid(), -3);

try {
    $pdo->beginTransaction();

    // insert sa orde
    $insertOrderSQL = "INSERT INTO orders(
        user_id, order_number, total_amount, shipping_fee, final_amount,
        payment_method, order_status, delivery_address, contact_number,
        special_instructions, confirmed_at, admin_notes
    ) VALUES(
        :user_id, :order_number, :total_amount, :shipping_fee, :final_amount,
        :payment_method, :order_status, :delivery_address, :contact_number,
        :special_instructions, :confirmed_at, :admin_notes
    )";

    $stmt = $pdo->prepare($insertOrderSQL);
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

    // Insert order items na selected items only
    $insertItemSQL = "INSERT INTO order_items(order_id, product_id, product_name, product_price, quantity, subtotal)
                      VALUES (:order_id, :product_id, :product_name, :product_price, :quantity, :subtotal)";
    $itemStmt = $pdo->prepare($insertItemSQL);

    foreach($selectedItems as $item){
        $itemStmt->execute([
            ':order_id' => $orderId,
            ':product_id' => $item['product_id'],
            ':product_name' => $item['product_name'],
            ':product_price' => $item['price'],
            ':quantity' => $item['quantity'],
            ':subtotal' => $item['price'] * $item['quantity']
        ]);
    }
    $calculatedTotal = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $selectedItems)) + 75;
    if(abs($calculatedTotal - $final_amount) > 0.01){
        throw new Exception("Final amount mismatch.");
    }
    // Payment
    switch($payment_method){
        case 'GCash':
        case 'Card':
            $link = createPaymentLink($final_amount, "Order ID: $orderId", "Checkout for Order ID: $orderId", $orderId, $orderNumber);
            if(!empty($link['data']['attributes']['checkout_url'])){
                $checkoutUrl = $link['data']['attributes']['checkout_url'];
                $pdo->commit();
                header("Location: $checkoutUrl");
                exit;
            } else {
                throw new Exception("Failed to create payment link: " . print_r($link, true));
            }
            break;

        case 'COD':
              $codToken = bin2hex(random_bytes(16));
              $pdo->prepare("UPDATE orders SET cod_token=? WHERE order_id=?")
              ->execute([$codToken, $orderId]);

            // Remove only mga selected items sa cart
            $placeholders = implode(',', array_fill(0, count($selectedItems), '?'));
            $ids = array_column($selectedItems, 'product_id');
            $clearCartSQL = "DELETE FROM shopping_cart WHERE user_id = ? AND product_id IN ($placeholders)";
            $stmt = $pdo->prepare($clearCartSQL);
            $stmt->execute(array_merge([$user_id], $ids));

            $pdo->commit();
            header("Location: cod.php?order_id=$orderId&token=$codToken");
            exit;

        default:
            throw new Exception("Invalid payment method selected.");
    }

} catch (Exception $e){
    $pdo->rollBack();
    echo "Checkout failed: " . $e->getMessage();
}
