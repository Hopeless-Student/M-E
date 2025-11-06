<?php
/**
 * Get Dashboard Statistics
 * Returns counts for total, unread, custom orders, and average response time
 */

session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../../../config/config.php';

// Check admin authentication
if (!isset($_SESSION['admin_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

try {
    // Total messages (active, not archived)
    $totalSql = "SELECT COUNT(*) FROM customer_request";
    $totalStmt = $pdo->query($totalSql);
    $total = (int)$totalStmt->fetchColumn();

    // Unread messages (status = pending)
    $unreadSql = "SELECT COUNT(*) FROM customer_request WHERE status = 'pending'";
    $unreadStmt = $pdo->query($unreadSql);
    $unread = (int)$unreadStmt->fetchColumn();

    // Custom orders
    $customSql = "SELECT COUNT(*) FROM customer_request WHERE request_type = 'custom_order'";
    $customStmt = $pdo->query($customSql);
    $customOrders = (int)$customStmt->fetchColumn();

    // Average response time (in hours)
    $avgTimeSql = "SELECT AVG(TIMESTAMPDIFF(HOUR, created_at, responded_at)) as avg_hours
                   FROM customer_request
                   WHERE responded_at IS NOT NULL";
    $avgTimeStmt = $pdo->query($avgTimeSql);
    $avgHours = $avgTimeStmt->fetchColumn();
    $avgResponseTime = $avgHours ? round($avgHours, 1) . 'h' : '0h';

    // Archive statistics
    $archiveStats = [
        'total' => 0,
        'thisMonth' => 0,
        'autoArchived' => 0
    ];

    $archiveTotalSql = "SELECT COUNT(*) FROM customer_request_archive";
    $archiveTotalStmt = $pdo->query($archiveTotalSql);
    $archiveStats['total'] = (int)$archiveTotalStmt->fetchColumn();

    $archiveMonthSql = "SELECT COUNT(*) FROM customer_request_archive
                        WHERE MONTH(archived_at) = MONTH(CURRENT_DATE())
                        AND YEAR(archived_at) = YEAR(CURRENT_DATE())";
    $archiveMonthStmt = $pdo->query($archiveMonthSql);
    $archiveStats['thisMonth'] = (int)$archiveMonthStmt->fetchColumn();

    $archiveAutoSql = "SELECT COUNT(*) FROM customer_request_archive
                       WHERE archive_reason = 'auto'";
    $archiveAutoStmt = $pdo->query($archiveAutoSql);
    $archiveStats['autoArchived'] = (int)$archiveAutoStmt->fetchColumn();

    echo json_encode([
        'success' => true,
        'stats' => [
            'totalMessages' => $total,
            'unreadMessages' => $unread,
            'customOrders' => $customOrders,
            'avgResponseTime' => $avgResponseTime
        ],
        'archiveStats' => $archiveStats
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Failed to fetch statistics',
        'message' => $e->getMessage()
    ]);
}
