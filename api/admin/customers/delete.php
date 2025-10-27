<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../../config/config.php';

// Only accept DELETE or POST requests
if (!in_array($_SERVER['REQUEST_METHOD'], ['DELETE', 'POST'])) {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON input']);
    exit;
}

$userId = isset($input['userId']) ? (int)$input['userId'] : 0;
$reason = trim($input['reason'] ?? '');
$confirmation = trim($input['confirmation'] ?? '');

if ($userId <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid user ID']);
    exit;
}

if ($confirmation !== 'DELETE') {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid confirmation. Type "DELETE" to confirm']);
    exit;
}

if (empty($reason)) {
    http_response_code(400);
    echo json_encode(['error' => 'Deletion reason is required']);
    exit;
}

try {
    // Check if user exists
    $checkSql = "SELECT user_id, email, first_name, last_name FROM users WHERE user_id = :userId";
    $checkStmt = $pdo->prepare($checkSql);
    $checkStmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $checkStmt->execute();
    $user = $checkStmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        http_response_code(404);
        echo json_encode(['error' => 'User not found']);
        exit;
    }

    // Start transaction
    $pdo->beginTransaction();

    // Option 1: Soft delete (recommended) - Set is_active to 0
    $softDeleteSql = "UPDATE users
                      SET is_active = 0,
                          updated_at = NOW()
                      WHERE user_id = :userId";
    $softDeleteStmt = $pdo->prepare($softDeleteSql);
    $softDeleteStmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $softDeleteStmt->execute();

    // Optional: Log deletion reason in customer_requests table (as a deletion request)
    // This assumes you want to track deletions
    $logSql = "INSERT INTO customer_requests (user_id, request_type, message, status, created_at)
               VALUES (:userId, 'account_deletion', :reason, 'completed', NOW())";
    $logStmt = $pdo->prepare($logSql);
    $logStmt->execute([':userId' => $userId, ':reason' => $reason]);

    // Option 2: Hard delete (use with extreme caution)
    // Uncomment if you want permanent deletion instead of soft delete
    /*
    // Delete from shopping_cart first (foreign key constraint)
    $deleteCartSql = "DELETE FROM shopping_cart WHERE user_id = :userId";
    $deleteCartStmt = $pdo->prepare($deleteCartSql);
    $deleteCartStmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $deleteCartStmt->execute();

    // Delete from customer_requests (foreign key constraint)
    $deleteRequestsSql = "DELETE FROM customer_requests WHERE user_id = :userId";
    $deleteRequestsStmt = $pdo->prepare($deleteRequestsSql);
    $deleteRequestsStmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $deleteRequestsStmt->execute();

    // Note: Orders should probably be kept for record-keeping
    // But if you need to delete them:
    // First delete order_items, then orders
    $deleteOrderItemsSql = "DELETE oi FROM order_items oi
                            INNER JOIN orders o ON oi.order_id = o.order_id
                            WHERE o.user_id = :userId";
    $deleteOrderItemsStmt = $pdo->prepare($deleteOrderItemsSql);
    $deleteOrderItemsStmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $deleteOrderItemsStmt->execute();

    $deleteOrdersSql = "DELETE FROM orders WHERE user_id = :userId";
    $deleteOrdersStmt = $pdo->prepare($deleteOrdersSql);
    $deleteOrdersStmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $deleteOrdersStmt->execute();

    // Finally delete user
    $deleteUserSql = "DELETE FROM users WHERE user_id = :userId";
    $deleteUserStmt = $pdo->prepare($deleteUserSql);
    $deleteUserStmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $deleteUserStmt->execute();
    */

    // Commit transaction
    $pdo->commit();

    $response = [
        'success' => true,
        'message' => 'User account deactivated successfully',
        'deletedUser' => [
            'id' => (int)$user['user_id'],
            'email' => $user['email'],
            'name' => $user['first_name'] . ' ' . $user['last_name']
        ],
        'reason' => $reason,
        'action' => 'soft_delete' // Change to 'hard_delete' if using hard delete
    ];

    echo json_encode($response);

} catch (PDOException $e) {
    // Rollback transaction on error
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
