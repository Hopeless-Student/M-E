<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../config/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE' && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed. Use DELETE or POST.']);
    exit;
}

// Get order ID from query string or request body
$orderId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($orderId <= 0) {
    $input = $_POST;
    if (empty($input)) {
        $raw = file_get_contents('php://input');
        $asJson = json_decode($raw, true);
        if (is_array($asJson)) {
            $input = $asJson;
        }
    }
    $orderId = isset($input['order_id']) ? (int)$input['order_id'] : 0;
}

if ($orderId <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid order_id']);
    exit;
}

try {
    $pdo->beginTransaction();

    // Check if order exists
    $checkStmt = $pdo->prepare('SELECT order_id FROM orders WHERE order_id = :id');
    $checkStmt->execute([':id' => $orderId]);
    $order = $checkStmt->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        $pdo->rollBack();
        http_response_code(404);
        echo json_encode(['error' => 'Order not found']);
        exit;
    }

    // Delete order items first (foreign key constraint)
    $deleteItems = $pdo->prepare('DELETE FROM order_items WHERE order_id = :id');
    $deleteItems->execute([':id' => $orderId]);

    // Delete the order
    $deleteOrder = $pdo->prepare('DELETE FROM orders WHERE order_id = :id');
    $deleteOrder->execute([':id' => $orderId]);

    $pdo->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Order deleted successfully',
        'order_id' => $orderId
    ]);

} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    http_response_code(500);
    echo json_encode(['error' => 'Failed to delete order: ' . $e->getMessage()]);
}
?>
