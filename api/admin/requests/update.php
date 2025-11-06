<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../../../config/config.php';

// Check admin authentication
if (!isset($_SESSION['admin_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['id']) || !isset($input['status'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Missing required fields']);
    exit;
}

$requestId = (int)$input['id'];
$status = trim($input['status']);
$adminResponse = trim($input['adminResponse'] ?? '');
$adminId = (int)$_SESSION['admin_id'];

// Validate status
$validStatuses = ['pending', 'in-progress', 'resolved', 'closed'];
if (!in_array($status, $validStatuses)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid status']);
    exit;
}

try {
    $pdo->beginTransaction();
    
    // Update the request
    $sql = "UPDATE customer_request 
            SET status = :status, 
                admin_response = :adminResponse, 
                responded_by = :adminId,
                responded_at = CASE 
                    WHEN :status IN ('resolved', 'closed') AND responded_at IS NULL 
                    THEN NOW() 
                    ELSE responded_at 
                END
            WHERE request_id = :requestId";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':status', $status);
    $stmt->bindValue(':adminResponse', $adminResponse);
    $stmt->bindValue(':adminId', $adminId);
    $stmt->bindValue(':requestId', $requestId);
    
    if (!$stmt->execute()) {
        throw new Exception('Failed to update request');
    }
    
    if ($stmt->rowCount() === 0) {
        throw new Exception('Request not found');
    }
    
    $pdo->commit();
    
    echo json_encode([
        'success' => true,
        'message' => 'Request updated successfully'
    ]);
    
} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
