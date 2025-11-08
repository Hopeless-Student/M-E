<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../../config/config.php';

// Require admin session
session_start();
if (!isset($_SESSION['admin_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

try {
    $adminId = $_SESSION['admin_id'];
    
    // Fetch admin account information
    $sql = "SELECT admin_id, username, email, created_at 
            FROM admin_user 
            WHERE admin_id = :admin_id";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':admin_id' => $adminId]);
    
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($admin) {
        echo json_encode([
            'success' => true,
            'admin' => [
                'admin_id' => $admin['admin_id'],
                'username' => $admin['username'],
                'email' => $admin['email'],
                'created_at' => $admin['created_at']
            ]
        ]);
    } else {
        http_response_code(404);
        echo json_encode([
            'success' => false,
            'error' => 'Admin account not found'
        ]);
    }
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Database error',
        'message' => 'Failed to fetch admin account',
        'details' => $e->getMessage()
    ]);
    error_log("Get account error: " . $e->getMessage());
}
