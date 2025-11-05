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

// Validate input
$userId = isset($input['userId']) ? (int)$input['userId'] : 0;
$reason = isset($input['reason']) ? trim($input['reason']) : '';
$confirmation = isset($input['confirmation']) ? trim($input['confirmation']) : '';

// Validation
if ($userId <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid user ID']);
    exit;
}

$allowedReasons = ['customer_request', 'duplicate_account', 'fraudulent', 'inactive', 'gdpr'];
if (!in_array($reason, $allowedReasons)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid reason', 'allowedReasons' => $allowedReasons]);
    exit;
}

// Check confirmation
if ($confirmation !== 'DELETE') {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid confirmation. Type "DELETE" to confirm']);
    exit;
}

try {
    // Check if user exists
    $checkSql = "SELECT user_id, email, first_name, middle_name, last_name, isActive FROM users WHERE user_id = :userId";
    $checkStmt = $pdo->prepare($checkSql);
    $checkStmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $checkStmt->execute();
    $user = $checkStmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        http_response_code(404);
        echo json_encode(['error' => 'User not found']);
        exit;
    }

    // Check if user is already deactivated
    if (!(int)$user['isActive']) {
        http_response_code(400);
        echo json_encode(['error' => 'User is already deactivated']);
        exit;
    }

    // Start transaction
    $pdo->beginTransaction();

    // Soft delete (recommended) - Set isActive to 0
    $softDeleteSql = "UPDATE users
                      SET isActive = 0,
                          updated_at = NOW()
                      WHERE user_id = :userId";
    $softDeleteStmt = $pdo->prepare($softDeleteSql);
    $softDeleteStmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $softDeleteStmt->execute();

    // Check if customer_requests table exists, if not, skip logging
    try {
        $tableCheckSql = "SHOW TABLES LIKE 'customer_requests'";
        $tableCheckStmt = $pdo->query($tableCheckSql);
        $tableExists = $tableCheckStmt->rowCount() > 0;

        if ($tableExists) {
            // Log deletion reason
            $logSql = "INSERT INTO customer_requests (user_id, request_type, message, status, created_at)
                       VALUES (:userId, 'account_deletion', :reason, 'completed', NOW())";
            $logStmt = $pdo->prepare($logSql);
            $logStmt->execute([':userId' => $userId, ':reason' => $reason]);
        }
    } catch (PDOException $e) {
        // Table doesn't exist, continue without logging
        error_log("customer_requests table not found, skipping deletion log: " . $e->getMessage());
    }

    // Commit transaction
    $pdo->commit();

    $fullName = trim(implode(' ', array_filter([
        $user['first_name'],
        $user['middle_name'],
        $user['last_name']
    ])));

    $response = [
        'success' => true,
        'message' => 'User account deactivated successfully',
        'deletedUser' => [
            'id' => (int)$user['user_id'],
            'email' => $user['email'],
            'name' => $fullName
        ],
        'reason' => $reason,
        'action' => 'soft_delete'
    ];

    echo json_encode($response);

} catch (PDOException $e) {
    // Rollback transaction on error
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    http_response_code(500);
    echo json_encode([
        'error' => 'Database error',
        'message' => 'Failed to delete customer',
        'details' => $e->getMessage()
    ]);
    error_log("Customer delete error: " . $e->getMessage());
} catch (Exception $e) {
    // Rollback transaction on any error
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    http_response_code(500);
    echo json_encode([
        'error' => 'Server error',
        'message' => 'An unexpected error occurred',
        'details' => $e->getMessage()
    ]);
    error_log("Customer delete error: " . $e->getMessage());
}
