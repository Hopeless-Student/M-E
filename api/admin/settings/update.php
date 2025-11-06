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

// Validate required fields
if (!isset($input['category']) || !isset($input['settings'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Category and settings are required']);
    exit;
}

$category = trim($input['category']);
$settings = $input['settings'];

// Validate category
$allowedCategories = ['business', 'shipping', 'notifications', 'users', 'security', 'backup'];
if (!in_array($category, $allowedCategories)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid category']);
    exit;
}

try {
    $pdo->beginTransaction();
    
    $updatedSettings = [];
    
    foreach ($settings as $key => $value) {
        // Convert arrays/objects to JSON
        if (is_array($value) || is_object($value)) {
            $value = json_encode($value);
            $type = 'json';
        } elseif (is_bool($value)) {
            $value = $value ? '1' : '0';
            $type = 'boolean';
        } elseif (is_numeric($value)) {
            $type = 'number';
        } else {
            $type = 'string';
        }
        
        // Check if setting exists
        $checkSql = "SELECT setting_id FROM system_settings 
                     WHERE setting_category = :category AND setting_key = :key";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->execute([
            ':category' => $category,
            ':key' => $key
        ]);
        
        if ($checkStmt->fetch()) {
            // Update existing setting
            $updateSql = "UPDATE system_settings 
                         SET setting_value = :value, 
                             setting_type = :type,
                             updated_at = NOW()
                         WHERE setting_category = :category AND setting_key = :key";
            $updateStmt = $pdo->prepare($updateSql);
            $updateStmt->execute([
                ':value' => $value,
                ':type' => $type,
                ':category' => $category,
                ':key' => $key
            ]);
        } else {
            // Insert new setting
            $insertSql = "INSERT INTO system_settings 
                         (setting_category, setting_key, setting_value, setting_type, created_at, updated_at)
                         VALUES (:category, :key, :value, :type, NOW(), NOW())";
            $insertStmt = $pdo->prepare($insertSql);
            $insertStmt->execute([
                ':category' => $category,
                ':key' => $key,
                ':value' => $value,
                ':type' => $type
            ]);
        }
        
        $updatedSettings[$key] = $value;
    }
    
    $pdo->commit();
    
    echo json_encode([
        'success' => true,
        'message' => ucfirst($category) . ' settings updated successfully',
        'category' => $category,
        'updated' => $updatedSettings
    ]);
    
} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Database error',
        'message' => 'Failed to update settings',
        'details' => $e->getMessage()
    ]);
    error_log("Settings update error: " . $e->getMessage());
}
