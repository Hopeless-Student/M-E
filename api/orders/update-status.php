<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../config/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $_SERVER['REQUEST_METHOD'] !== 'PATCH') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$input = $_POST;
if (empty($input)) {
    $raw = file_get_contents('php://input');
    $asJson = json_decode($raw, true);
    if (is_array($asJson)) { $input = $asJson; }
}

$orderId = isset($input['order_id']) ? (int)$input['order_id'] : 0;
$status = isset($input['order_status']) ? trim($input['order_status']) : '';
$paymentStatus = isset($input['payment_status']) ? trim($input['payment_status']) : null;

if ($orderId <= 0 || $status === '') {
    http_response_code(400);
    echo json_encode(['error' => 'order_id and order_status are required']);
    exit;
}

// Build SQL dynamically if payment_status column exists
$hasPayment = false;
$stmt = $pdo->query("SHOW COLUMNS FROM orders LIKE 'payment_status'");
if ($stmt && $stmt->fetch()) { $hasPayment = true; }

$sets = ['order_status = :status'];
$params = [':status' => $status, ':id' => $orderId];
if ($hasPayment && $paymentStatus !== null) {
    $sets[] = 'payment_status = :payment_status';
    $params[':payment_status'] = $paymentStatus;
}

$sql = 'UPDATE orders SET ' . implode(', ', $sets) . ' WHERE order_id = :id';
$stmt = $pdo->prepare($sql);
$stmt->execute($params);

echo json_encode(['success' => true]);
?>


