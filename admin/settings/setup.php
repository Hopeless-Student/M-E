<?php
/**
 * Settings Module Setup Script
 * This script ensures all required database tables and default settings are created
 */

require_once __DIR__ . '/../../config/config.php';

// Require admin session
session_start();
if (!isset($_SESSION['admin_id'])) {
    die('Unauthorized access. Please login as admin.');
}

$setupResults = [];
$errors = [];

try {
    // 1. Create system_settings table
    $createSettingsTable = "
    CREATE TABLE IF NOT EXISTS `system_settings` (
      `setting_id` int(11) NOT NULL AUTO_INCREMENT,
      `setting_category` varchar(50) NOT NULL,
      `setting_key` varchar(100) NOT NULL,
      `setting_value` text,
      `setting_type` enum('string','number','boolean','json') DEFAULT 'string',
      `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`setting_id`),
      UNIQUE KEY `unique_setting` (`setting_category`,`setting_key`),
      KEY `idx_category` (`setting_category`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ";
    
    $pdo->exec($createSettingsTable);
    $setupResults[] = "✓ system_settings table created/verified";
    
    // 2. Create backup_logs table
    $createBackupLogsTable = "
    CREATE TABLE IF NOT EXISTS `backup_logs` (
      `backup_id` int(11) NOT NULL AUTO_INCREMENT,
      `backup_file` varchar(255) NOT NULL,
      `backup_size` bigint(20) DEFAULT NULL,
      `backup_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `status` enum('success','failed') DEFAULT 'success',
      `error_message` text,
      PRIMARY KEY (`backup_id`),
      KEY `idx_backup_date` (`backup_date`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ";
    
    $pdo->exec($createBackupLogsTable);
    $setupResults[] = "✓ backup_logs table created/verified";
    
    // 3. Create admin_activity_log table (optional, for logging admin activities)
    $createActivityLogTable = "
    CREATE TABLE IF NOT EXISTS `admin_activity_log` (
      `log_id` int(11) NOT NULL AUTO_INCREMENT,
      `admin_id` int(11) NOT NULL,
      `activity_type` varchar(50) NOT NULL,
      `activity_description` text,
      `ip_address` varchar(45) DEFAULT NULL,
      `user_agent` varchar(255) DEFAULT NULL,
      `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`log_id`),
      KEY `idx_admin_id` (`admin_id`),
      KEY `idx_activity_type` (`activity_type`),
      KEY `idx_created_at` (`created_at`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ";
    
    $pdo->exec($createActivityLogTable);
    $setupResults[] = "✓ admin_activity_log table created/verified";
    
    // 4. Insert default settings (only if they don't exist)
    $defaultSettings = [
        // Business Info
        ['business', 'business_name', 'M & E Interior Supplies Trading', 'string'],
        ['business', 'contact_email', 'info@me-supplies.com', 'string'],
        ['business', 'contact_phone', '+63 47 222 3456', 'string'],
        ['business', 'business_address', '123 Rizal Avenue, Olongapo City, Zambales, Philippines', 'string'],
        ['business', 'business_description', 'Your trusted supplier for office, school, and sanitary supplies in Olongapo City. We provide quality products with fast and reliable delivery service.', 'string'],
        
        // Shipping & Delivery
        ['shipping', 'primary_delivery_area', 'Olongapo City, Zambales', 'string'],
        ['shipping', 'standard_delivery_fee', '70', 'number'],
        ['shipping', 'extended_area_fee', '100', 'number'],
        ['shipping', 'processing_time_hours', '24', 'number'],
        ['shipping', 'delivery_time_hours', '48', 'number'],
        ['shipping', 'auto_confirm_orders', '1', 'boolean'],
        
        // Notifications
        ['notifications', 'email_new_orders', '1', 'boolean'],
        ['notifications', 'email_low_stock', '1', 'boolean'],
        ['notifications', 'email_new_messages', '1', 'boolean'],
        ['notifications', 'system_order_updates', '0', 'boolean'],
        ['notifications', 'system_daily_reports', '1', 'boolean'],
        
        // Security
        ['security', 'session_timeout_minutes', '60', 'number'],
        ['security', 'allow_remember_me', '0', 'boolean'],
        ['security', 'encrypt_customer_data', '1', 'boolean'],
        ['security', 'log_admin_activities', '1', 'boolean'],
        
        // Backup
        ['backup', 'auto_backup_frequency', 'daily', 'string'],
        ['backup', 'last_backup_date', NULL, 'string']
    ];
    
    $insertedCount = 0;
    $skippedCount = 0;
    
    foreach ($defaultSettings as $setting) {
        list($category, $key, $value, $type) = $setting;
        
        // Check if setting already exists
        $checkSql = "SELECT setting_id FROM system_settings WHERE setting_category = :category AND setting_key = :key";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->execute([':category' => $category, ':key' => $key]);
        
        if (!$checkStmt->fetch()) {
            // Insert new setting
            $insertSql = "INSERT INTO system_settings (setting_category, setting_key, setting_value, setting_type, created_at, updated_at)
                         VALUES (:category, :key, :value, :type, NOW(), NOW())";
            $insertStmt = $pdo->prepare($insertSql);
            $insertStmt->execute([
                ':category' => $category,
                ':key' => $key,
                ':value' => $value,
                ':type' => $type
            ]);
            $insertedCount++;
        } else {
            $skippedCount++;
        }
    }
    
    $setupResults[] = "✓ Default settings: {$insertedCount} inserted, {$skippedCount} already exist";
    
    // 5. Create backup directory
    $backupDir = __DIR__ . '/../../database/backups';
    if (!file_exists($backupDir)) {
        mkdir($backupDir, 0755, true);
        $setupResults[] = "✓ Backup directory created: {$backupDir}";
    } else {
        $setupResults[] = "✓ Backup directory exists: {$backupDir}";
    }
    
    // 6. Verify admin_user table exists and has required columns
    $checkAdminTable = "SHOW TABLES LIKE 'admin_user'";
    $stmt = $pdo->query($checkAdminTable);
    if ($stmt->rowCount() > 0) {
        $setupResults[] = "✓ admin_user table verified";
        
        // Check if email column exists
        $checkEmailColumn = "SHOW COLUMNS FROM admin_user LIKE 'email'";
        $stmt = $pdo->query($checkEmailColumn);
        if ($stmt->rowCount() > 0) {
            $setupResults[] = "✓ admin_user email column verified";
        } else {
            $setupResults[] = "⚠ admin_user table missing email column (may need manual fix)";
        }
    } else {
        $setupResults[] = "⚠ admin_user table not found (please import database schema)";
    }
    
} catch (PDOException $e) {
    $errors[] = "Database error: " . $e->getMessage();
    error_log("Settings setup error: " . $e->getMessage());
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings Setup - M & E Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        
        .container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 700px;
            width: 100%;
            padding: 3rem;
        }
        
        h1 {
            color: #333;
            margin-bottom: 0.5rem;
            font-size: 2rem;
        }
        
        .subtitle {
            color: #666;
            margin-bottom: 2rem;
            font-size: 0.95rem;
        }
        
        .results {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .result-item {
            padding: 0.75rem;
            margin-bottom: 0.5rem;
            background: white;
            border-radius: 6px;
            border-left: 4px solid #10b981;
            font-size: 0.9rem;
            color: #333;
        }
        
        .result-item:last-child {
            margin-bottom: 0;
        }
        
        .error-item {
            padding: 0.75rem;
            margin-bottom: 0.5rem;
            background: #fee;
            border-radius: 6px;
            border-left: 4px solid #ef4444;
            font-size: 0.9rem;
            color: #991b1b;
        }
        
        .success-badge {
            display: inline-block;
            background: #10b981;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .error-badge {
            display: inline-block;
            background: #ef4444;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        
        .actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }
        
        .btn {
            flex: 1;
            padding: 0.875rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: all 0.2s;
        }
        
        .btn-primary {
            background: #667eea;
            color: white;
        }
        
        .btn-primary:hover {
            background: #5568d3;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
        
        .btn-secondary {
            background: #e5e7eb;
            color: #374151;
        }
        
        .btn-secondary:hover {
            background: #d1d5db;
        }
        
        .info-box {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 8px;
            padding: 1rem;
            margin-top: 1.5rem;
            font-size: 0.9rem;
            color: #1e40af;
        }
        
        .info-box strong {
            display: block;
            margin-bottom: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>⚙️ Settings Module Setup</h1>
        <p class="subtitle">Database tables and configuration initialization</p>
        
        <?php if (empty($errors)): ?>
            <div class="success-badge">✓ Setup Completed Successfully</div>
        <?php else: ?>
            <div class="error-badge">⚠ Setup Completed with Errors</div>
        <?php endif; ?>
        
        <?php if (!empty($setupResults)): ?>
            <div class="results">
                <h3 style="margin-bottom: 1rem; color: #333; font-size: 1.1rem;">Setup Results:</h3>
                <?php foreach ($setupResults as $result): ?>
                    <div class="result-item"><?php echo htmlspecialchars($result); ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($errors)): ?>
            <div class="results">
                <h3 style="margin-bottom: 1rem; color: #991b1b; font-size: 1.1rem;">Errors:</h3>
                <?php foreach ($errors as $error): ?>
                    <div class="error-item"><?php echo htmlspecialchars($error); ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <div class="info-box">
            <strong>📋 What was set up:</strong>
            <ul style="margin-left: 1.5rem; margin-top: 0.5rem;">
                <li>System settings database table</li>
                <li>Backup logs database table</li>
                <li>Admin activity log table</li>
                <li>Default configuration values</li>
                <li>Backup directory structure</li>
            </ul>
        </div>
        
        <div class="actions">
            <a href="index.php" class="btn btn-primary">Go to Settings</a>
            <a href="../index.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
