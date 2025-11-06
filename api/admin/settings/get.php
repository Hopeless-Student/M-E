<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../../config/config.php';

// Get settings type
$type = isset($_GET['type']) ? trim($_GET['type']) : 'all';

try {
    // Fetch settings from database
    $sql = "SELECT * FROM system_settings WHERE 1=1";
    
    if ($type !== 'all') {
        $sql .= " AND setting_category = :category";
    }
    
    $stmt = $pdo->prepare($sql);
    
    if ($type !== 'all') {
        $stmt->bindValue(':category', $type, PDO::PARAM_STR);
    }
    
    $stmt->execute();
    $settings = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Organize settings by category
    $organized = [];
    foreach ($settings as $setting) {
        $category = $setting['setting_category'];
        $key = $setting['setting_key'];
        $value = $setting['setting_value'];
        
        // Try to decode JSON values
        $decoded = json_decode($value, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            $value = $decoded;
        }
        
        if (!isset($organized[$category])) {
            $organized[$category] = [];
        }
        
        $organized[$category][$key] = [
            'value' => $value,
            'type' => $setting['setting_type'],
            'updated_at' => $setting['updated_at']
        ];
    }
    
    // If specific type requested, return only that category
    if ($type !== 'all' && isset($organized[$type])) {
        echo json_encode([
            'success' => true,
            'category' => $type,
            'settings' => $organized[$type]
        ]);
    } else {
        echo json_encode([
            'success' => true,
            'settings' => $organized
        ]);
    }
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Database error',
        'message' => 'Failed to fetch settings',
        'details' => $e->getMessage()
    ]);
    error_log("Settings get error: " . $e->getMessage());
}
