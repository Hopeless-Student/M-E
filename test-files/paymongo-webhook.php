<?php
require_once __DIR__ . '/../includes/database.php';
$pdo = connect();

// Read the raw POST body
$payload = file_get_contents('php://input');
$data = json_decode($payload, true);

$orderId = $data['data']['attributes']['metadata']['order_id'] ?? null;
$status = $data['data']['attributes']['status'] ?? null;

if ($orderId && $status === 'paid') {
    $stmt = $pdo->prepare("UPDATE orders
                           SET payment_status = 'Paid', order_status = 'Confirmed'
                           WHERE order_id = ?");
    $stmt->execute([$orderId]);

    // Optional: clear cart
    // $stmt = $pdo->prepare("DELETE FROM shopping_cart WHERE user_id = (SELECT user_id FROM orders WHERE order_id = ?)");
    // $stmt->execute([$orderId]);

    http_response_code(200); // respond 200 OK to PayMongo
    exit;
} else {
    http_response_code(400);
    exit;
}
?>
