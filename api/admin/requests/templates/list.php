<?php
/**
 * List Response Templates
 * Returns all templates with optional filtering
 */

session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../../../../config/config.php';

// Check admin authentication
if (!isset($_SESSION['admin_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

try {
    $category = trim($_GET['category'] ?? '');
    $q = trim($_GET['q'] ?? '');

    $where = [];
    $params = [];

    if ($category !== '' && $category !== 'all') {
        $where[] = 'category = :category';
        $params[':category'] = $category;
    }

    if ($q !== '') {
        $where[] = '(name LIKE :q OR content LIKE :q OR notes LIKE :q)';
        $params[':q'] = "%$q%";
    }

    $whereSql = count($where) ? ('WHERE ' . implode(' AND ', $where)) : '';

    $sql = "SELECT * FROM response_templates $whereSql ORDER BY usage_count DESC, name ASC";
    $stmt = $pdo->prepare($sql);

    foreach ($params as $k => $v) {
        $stmt->bindValue($k, $v);
    }

    $stmt->execute();
    $templates = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get category counts
    $countSql = "SELECT category, COUNT(*) as count FROM response_templates GROUP BY category";
    $countStmt = $pdo->query($countSql);
    $categoryCounts = [];

    while ($row = $countStmt->fetch(PDO::FETCH_ASSOC)) {
        $categoryCounts[$row['category']] = (int)$row['count'];
    }

    // Total count
    $totalSql = "SELECT COUNT(*) FROM response_templates";
    $totalStmt = $pdo->query($totalSql);
    $totalCount = (int)$totalStmt->fetchColumn();

    $categoryCounts['all'] = $totalCount;

    // Get most used template
    $mostUsedSql = "SELECT name FROM response_templates ORDER BY usage_count DESC LIMIT 1";
    $mostUsedStmt = $pdo->query($mostUsedSql);
    $mostUsed = $mostUsedStmt->fetchColumn() ?: 'N/A';

    // Get this month usage
    $usageSql = "SELECT SUM(usage_count) FROM response_templates";
    $usageStmt = $pdo->query($usageSql);
    $thisMonthUsage = (int)$usageStmt->fetchColumn();

    $items = array_map(function($t) {
        return [
            'id' => $t['template_id'],
            'name' => $t['name'],
            'category' => $t['category'],
            'subject' => $t['subject'],
            'content' => $t['content'],
            'notes' => $t['notes'],
            'usageCount' => (int)$t['usage_count'],
            'createdAt' => $t['created_at'],
            'updatedAt' => $t['updated_at']
        ];
    }, $templates);

    echo json_encode([
        'success' => true,
        'templates' => $items,
        'categoryCounts' => $categoryCounts,
        'stats' => [
            'total' => $totalCount,
            'mostUsed' => $mostUsed,
            'thisMonthUsage' => $thisMonthUsage
        ]
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Failed to fetch templates',
        'message' => $e->getMessage()
    ]);
}
