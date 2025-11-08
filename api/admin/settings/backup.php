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

try {
    // Database configuration (from config.php)
    // Variables defined in config.php: $host, $dbname, $user, $password
    $dbHost = $host;
    $dbName = $dbname;
    $dbUser = $user;
    $dbPass = $password;
    
    // Create backup directory if it doesn't exist
    $backupDir = __DIR__ . '/../../../database/backups';
    if (!file_exists($backupDir)) {
        mkdir($backupDir, 0755, true);
    }
    
    // Generate backup filename with timestamp
    $timestamp = date('Y-m-d_H-i-s');
    $backupFile = $backupDir . '/backup_' . $timestamp . '.sql';
    
    // mysqldump command
    $command = sprintf(
        'mysqldump --user=%s --password=%s --host=%s %s > %s 2>&1',
        escapeshellarg($dbUser),
        escapeshellarg($dbPass),
        escapeshellarg($dbHost),
        escapeshellarg($dbName),
        escapeshellarg($backupFile)
    );
    
    // Execute backup
    exec($command, $output, $returnCode);
    
    if ($returnCode === 0 && file_exists($backupFile)) {
        // Get file size
        $fileSize = filesize($backupFile);
        $fileSizeFormatted = number_format($fileSize / 1024 / 1024, 2) . ' MB';
        
        // Log backup in database (optional - table may not exist)
        try {
            $logSql = "INSERT INTO backup_logs (backup_file, backup_size, backup_date, status)
                       VALUES (:file, :size, NOW(), 'success')";
            $logStmt = $pdo->prepare($logSql);
            $logStmt->execute([
                ':file' => basename($backupFile),
                ':size' => $fileSize
            ]);
        } catch (PDOException $e) {
            // Table doesn't exist, continue anyway
            error_log("Backup log table doesn't exist: " . $e->getMessage());
        }
        
        // Update last_backup_date setting so UI can show latest backup time
        $humanDate = date('F j, Y - g:i A');
        try {
            $checkStmt = $pdo->prepare("SELECT setting_id FROM system_settings WHERE setting_category = 'backup' AND setting_key = 'last_backup_date'");
            $checkStmt->execute();
            if ($checkStmt->fetch()) {
                $updStmt = $pdo->prepare("UPDATE system_settings SET setting_value = :val, setting_type = 'string', updated_at = NOW() WHERE setting_category = 'backup' AND setting_key = 'last_backup_date'");
                $updStmt->execute([':val' => $humanDate]);
            } else {
                $insStmt = $pdo->prepare("INSERT INTO system_settings (setting_category, setting_key, setting_value, setting_type, created_at, updated_at) VALUES ('backup', 'last_backup_date', :val, 'string', NOW(), NOW())");
                $insStmt->execute([':val' => $humanDate]);
            }
        } catch (PDOException $e) {
            // Settings table doesn't exist, continue anyway
            error_log("System settings table doesn't exist: " . $e->getMessage());
        }

        echo json_encode([
            'success' => true,
            'message' => 'Database backup created successfully',
            'backup' => [
                'filename' => basename($backupFile),
                'size' => $fileSizeFormatted,
                'date' => $humanDate,
                'path' => $backupFile
            ]
        ]);
    } else {
        throw new Exception('Backup failed: ' . implode("\n", $output));
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Backup error',
        'message' => 'Failed to create backup',
        'details' => $e->getMessage()
    ]);
    error_log("Backup error: " . $e->getMessage());
}
