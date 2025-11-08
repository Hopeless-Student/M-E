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

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid JSON input']);
    exit;
}

try {
    $adminId = $_SESSION['admin_id'];
    $updates = [];
    $params = [':admin_id' => $adminId];
    
    // Validate and prepare username update
    if (isset($input['username']) && !empty(trim($input['username']))) {
        $username = trim($input['username']);
        
        // Check if username is already taken by another admin
        $checkSql = "SELECT admin_id FROM admin_user WHERE username = :username AND admin_id != :admin_id";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->execute([':username' => $username, ':admin_id' => $adminId]);
        
        if ($checkStmt->fetch()) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Username already taken']);
            exit;
        }
        
        $updates[] = "username = :username";
        $params[':username'] = $username;
    }
    
    // Validate and prepare email update
    if (isset($input['email']) && !empty(trim($input['email']))) {
        $email = trim($input['email']);
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Invalid email format']);
            exit;
        }
        
        // Check if email is already taken by another admin
        $checkSql = "SELECT admin_id FROM admin_user WHERE email = :email AND admin_id != :admin_id";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->execute([':email' => $email, ':admin_id' => $adminId]);
        
        if ($checkStmt->fetch()) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Email already taken']);
            exit;
        }
        
        $updates[] = "email = :email";
        $params[':email'] = $email;
    }
    
    // Validate and prepare password update
    if (isset($input['password']) && !empty($input['password'])) {
        $password = $input['password'];
        $confirmPassword = isset($input['confirm_password']) ? $input['confirm_password'] : '';
        
        if ($password !== $confirmPassword) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Passwords do not match']);
            exit;
        }
        
        if (strlen($password) < 6) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Password must be at least 6 characters long']);
            exit;
        }
        
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $updates[] = "password_hash = :password";
        $params[':password'] = $hashedPassword;
    }
    
    // If no updates, return error
    if (empty($updates)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'No valid updates provided']);
        exit;
    }
    
    // Update admin account
    $sql = "UPDATE admin_user SET " . implode(', ', $updates) . " WHERE admin_id = :admin_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    
    // Update session if username changed
    if (isset($input['username'])) {
        $_SESSION['admin_username'] = $input['username'];
    }
    
    // Log the activity
    if (isset($params[':username']) || isset($params[':email']) || isset($params[':password'])) {
        $activitySql = "INSERT INTO admin_activity_log (admin_id, activity_type, activity_description, created_at) 
                       VALUES (:admin_id, 'account_update', :description, NOW())";
        $activityStmt = $pdo->prepare($activitySql);
        
        $changes = [];
        if (isset($params[':username'])) $changes[] = 'username';
        if (isset($params[':email'])) $changes[] = 'email';
        if (isset($params[':password'])) $changes[] = 'password';
        
        $description = 'Updated account: ' . implode(', ', $changes);
        
        try {
            $activityStmt->execute([
                ':admin_id' => $adminId,
                ':description' => $description
            ]);
        } catch (PDOException $e) {
            // Log activity table might not exist, continue anyway
            error_log("Activity log error: " . $e->getMessage());
        }
    }
    
    echo json_encode([
        'success' => true,
        'message' => 'Account updated successfully',
        'updated_fields' => array_keys($params)
    ]);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Database error',
        'message' => 'Failed to update account',
        'details' => $e->getMessage()
    ]);
    error_log("Account update error: " . $e->getMessage());
}
