<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../../config/config.php';

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

try {
    // Database configuration
    $dbHost = DB_HOST;
    $dbName = DB_NAME;
    $dbUser = DB_USER;
    $dbPass = DB_PASS;
    
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
        
        // Log backup in database
        $logSql = "INSERT INTO backup_logs (backup_file, backup_size, backup_date, status)
                   VALUES (:file, :size, NOW(), 'success')";
        $logStmt = $pdo->prepare($logSql);
        $logStmt->execute([
            ':file' => basename($backupFile),
            ':size' => $fileSize
        ]);
        
        echo json_encode([
            'success' => true,
            'message' => 'Database backup created successfully',
            'backup' => [
                'filename' => basename($backupFile),
                'size' => $fileSizeFormatted,
                'date' => date('F j, Y - g:i A'),
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
