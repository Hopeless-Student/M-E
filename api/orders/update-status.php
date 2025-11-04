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
$adminNotes = isset($input['admin_notes']) ? trim($input['admin_notes']) : null;

if ($orderId <= 0 || $status === '') {
    http_response_code(400);
    echo json_encode(['error' => 'order_id and order_status are required']);
    exit;
}

// Validate status values
$validStatuses = ['pending', 'confirmed', 'shipped', 'delivered', 'cancelled'];
if (!in_array(strtolower($status), $validStatuses)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid order_status. Must be one of: ' . implode(', ', $validStatuses)]);
    exit;
}

try {
    // Check if order exists and current status
    $checkStmt = $pdo->prepare('SELECT order_status FROM orders WHERE order_id = :id');
    $checkStmt->execute([':id' => $orderId]);
    $currentOrder = $checkStmt->fetch(PDO::FETCH_ASSOC);

    if (!$currentOrder) {
        http_response_code(404);
        echo json_encode(['error' => 'Order not found']);
        exit;
    }

    // Prevent updating delivered orders
    if (strtolower($currentOrder['order_status']) === 'delivered') {
        http_response_code(400);
        echo json_encode(['error' => 'Cannot update status of delivered orders']);
        exit;
    }

    // Check if payment_status column exists
    $hasPayment = false;
    $stmt = $pdo->query("SHOW COLUMNS FROM orders LIKE 'payment_status'");
    if ($stmt && $stmt->fetch()) {
        $hasPayment = true;
    }

    // Build SQL dynamically
    $sets = ['order_status = :status'];
    $params = [':status' => $status, ':id' => $orderId];

    if ($hasPayment && $paymentStatus !== null) {
        $sets[] = 'payment_status = :payment_status';
        $params[':payment_status'] = $paymentStatus;
    }

    if ($adminNotes !== null) {
        $sets[] = 'admin_notes = :admin_notes';
        $params[':admin_notes'] = $adminNotes;
    }

    // Update timestamp columns based on status
    $statusLower = strtolower($status);
    if ($statusLower === 'confirmed') {
        $sets[] = 'confirmed_at = NOW()';
    } elseif ($statusLower === 'delivered') {
        $sets[] = 'delivered_at = NOW()';
    }

    $sql = 'UPDATE orders SET ' . implode(', ', $sets) . ' WHERE order_id = :id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    if ($stmt->rowCount() === 0) {
        echo json_encode([
            'success' => true,
            'message' => 'No changes made (status might be the same)'
        ]);
    } else {
        echo json_encode([
            'success' => true,
            'message' => 'Order status updated successfully'
        ]);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to update order: ' . $e->getMessage()]);
}
?>
