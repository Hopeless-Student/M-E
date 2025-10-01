<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../config/config.php';

$orderId = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;
if ($orderId <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid order_id']);
    exit;
}

$sql = "SELECT oi.order_item_id, oi.product_id, oi.product_name, oi.product_price, oi.quantity, oi.subtotal
        FROM order_items oi WHERE oi.order_id = :order_id ORDER BY oi.order_item_id ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute([':order_id' => $orderId]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['items' => $items]);
?>


