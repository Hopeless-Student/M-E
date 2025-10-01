<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../config/config.php';

$userId = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;
if ($userId <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid user_id']);
    exit;
}

$sql = "SELECT o.order_id, o.order_number, o.total_amount, o.shipping_fee, o.final_amount, o.payment_method,
               o.order_status, o.order_date
        FROM orders o WHERE o.user_id = :user_id
        ORDER BY o.order_date DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute([':user_id' => $userId]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['items' => $orders]);
?>


