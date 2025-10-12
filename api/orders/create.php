<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../config/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Accept JSON or form
$input = $_POST;
if (empty($input)) {
    $raw = file_get_contents('php://input');
    $asJson = json_decode($raw, true);
    if (is_array($asJson)) { $input = $asJson; }
}

$userId = isset($input['user_id']) ? (int)$input['user_id'] : 0;
$items = isset($input['items']) && is_array($input['items']) ? $input['items'] : [];
$paymentMethod = isset($input['payment_method']) ? trim($input['payment_method']) : 'COD';
$shippingFee = isset($input['shipping_fee']) ? (float)$input['shipping_fee'] : 0.00;
$deliveryAddress = isset($input['delivery_address']) ? trim($input['delivery_address']) : '';
$contactNumber = isset($input['contact_number']) ? trim($input['contact_number']) : '';
$specialInstructions = isset($input['special_instructions']) ? trim($input['special_instructions']) : null;

if ($userId <= 0 || empty($items) || $deliveryAddress === '' || $contactNumber === '') {
    http_response_code(400);
    echo json_encode(['error' => 'user_id, items, delivery_address, contact_number are required']);
    exit;
}

try {
    $pdo->beginTransaction();

    // Compute totals using product current price
    $totalAmount = 0.0;
    $normalizedItems = [];
    foreach ($items as $it) {
        $productId = (int)($it['product_id'] ?? 0);
        $quantity = max(1, (int)($it['quantity'] ?? 1));
        if ($productId <= 0) { throw new Exception('Invalid product_id'); }

        $ps = $pdo->prepare('SELECT product_name, price FROM products WHERE product_id = :pid');
        $ps->execute([':pid' => $productId]);
        $p = $ps->fetch(PDO::FETCH_ASSOC);
        if (!$p) { throw new Exception('Product not found: ' . $productId); }

        $productName = $p['product_name'];
        $productPrice = (float)$p['price'];
        $lineTotal = $productPrice * $quantity;
        $totalAmount += $lineTotal;
        $normalizedItems[] = [
            'product_id' => $productId,
            'product_name' => $productName,
            'product_price' => $productPrice,
            'quantity' => $quantity,
            'subtotal' => $lineTotal,
        ];
    }

    $finalAmount = $totalAmount + $shippingFee;
    $orderNumber = 'ORD-' . date('YmdHis') . '-' . uniqid();

    $insertOrder = "INSERT INTO orders (user_id, order_number, total_amount, shipping_fee, final_amount,
                    payment_method, order_status, delivery_address, contact_number, special_instructions, admin_notes)
                   VALUES (:user_id, :order_number, :total_amount, :shipping_fee, :final_amount,
                    :payment_method, :order_status, :delivery_address, :contact_number, :special_instructions, :admin_notes)";
    $stmt = $pdo->prepare($insertOrder);
    $stmt->execute([
        ':user_id' => $userId,
        ':order_number' => $orderNumber,
        ':total_amount' => $totalAmount,
        ':shipping_fee' => $shippingFee,
        ':final_amount' => $finalAmount,
        ':payment_method' => $paymentMethod,
        ':order_status' => 'Pending',
        ':delivery_address' => $deliveryAddress,
        ':contact_number' => $contactNumber,
        ':special_instructions' => $specialInstructions,
        ':admin_notes' => 'API order creation',
    ]);

    $orderId = (int)$pdo->lastInsertId();

    $insertItem = $pdo->prepare("INSERT INTO order_items (order_id, product_id, product_name, product_price, quantity) VALUES 
                                 (:order_id, :product_id, :product_name, :product_price, :quantity)");
    foreach ($normalizedItems as $ni) {
        $insertItem->execute([
            ':order_id' => $orderId,
            ':product_id' => $ni['product_id'],
            ':product_name' => $ni['product_name'],
            ':product_price' => $ni['product_price'],
            ':quantity' => $ni['quantity'],
        ]);
    }

    $pdo->commit();
    echo json_encode(['success' => true, 'order_id' => $orderId, 'order_number' => $orderNumber]);
} catch (Exception $e) {
    if ($pdo->inTransaction()) { $pdo->rollBack(); }
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}
?>


