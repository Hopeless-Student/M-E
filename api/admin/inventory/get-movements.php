<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../../config/config.php';

$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$pageSize = isset($_GET['pageSize']) ? min(100, max(1, (int)$_GET['pageSize'])) : 10;
$productId = isset($_GET['productId']) ? (int)$_GET['productId'] : 0;
$type = trim($_GET['type'] ?? '');
$reason = trim($_GET['reason'] ?? '');
$startDate = trim($_GET['startDate'] ?? '');
$endDate = trim($_GET['endDate'] ?? '');

$offset = ($page - 1) * $pageSize;

$where = ['1=1'];
$params = [];

if ($productId > 0) {
    $where[] = 'sm.product_id = :productId';
    $params[':productId'] = $productId;
}

if ($type !== '') {
    $where[] = 'sm.movement_type = :type';
    $params[':type'] = $type;
}

if ($reason !== '') {
    $where[] = 'sm.reason LIKE :reason';
    $params[':reason'] = "%$reason%";
}

if ($startDate !== '') {
    $where[] = 'sm.created_at >= :startDate';
    $params[':startDate'] = $startDate . ' 00:00:00';
}

if ($endDate !== '') {
    $where[] = 'sm.created_at <= :endDate';
    $params[':endDate'] = $endDate . ' 23:59:59';
}

$whereSql = 'WHERE ' . implode(' AND ', $where);

// Count total
$countSql = "SELECT COUNT(*) FROM stock_movements sm $whereSql";
$stmt = $pdo->prepare($countSql);
foreach ($params as $k => $v) { $stmt->bindValue($k, $v); }
$stmt->execute();
$total = (int)$stmt->fetchColumn();

// Get movements
$sql = "SELECT sm.movement_id, sm.product_id, sm.movement_type, sm.quantity,
               sm.previous_stock, sm.new_stock, sm.reason, sm.user_name, sm.created_at,
               p.product_name, p.product_code
        FROM stock_movements sm
        INNER JOIN products p ON p.product_id = sm.product_id
        $whereSql
        ORDER BY sm.created_at DESC
        LIMIT :limit OFFSET :offset";

$stmt = $pdo->prepare($sql);
foreach ($params as $k => $v) { $stmt->bindValue($k, $v); }
$stmt->bindValue(':limit', $pageSize, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$movements = array_map(function ($r) {
    return [
        'id' => (int)$r['movement_id'],
        'productId' => (int)$r['product_id'],
        'productName' => $r['product_name'],
        'productSKU' => $r['product_code'],
        'type' => $r['movement_type'],
        'quantity' => (int)$r['quantity'],
        'previousStock' => (int)$r['previous_stock'],
        'newStock' => (int)$r['new_stock'],
        'reason' => $r['reason'],
        'user' => $r['user_name'],
        'timestamp' => date('m/d/Y h:i A', strtotime($r['created_at']))
    ];
}, $rows);

// Calculate summary statistics
$summaryStats = [
    'totalAdditions' => 0,
    'totalRemovals' => 0,
    'totalAdjustments' => 0,
    'netChange' => 0
];

$statsSql = "SELECT
                SUM(CASE WHEN movement_type = 'add' THEN quantity ELSE 0 END) as additions,
                SUM(CASE WHEN movement_type = 'remove' THEN quantity ELSE 0 END) as removals,
                SUM(CASE WHEN movement_type = 'adjust' THEN ABS(quantity) ELSE 0 END) as adjustments,
                SUM(CASE WHEN movement_type = 'add' THEN quantity WHEN movement_type = 'remove' THEN -quantity ELSE 0 END) as net
             FROM stock_movements sm
             $whereSql";

$stmt = $pdo->prepare($statsSql);
foreach ($params as $k => $v) { $stmt->bindValue($k, $v); }
$stmt->execute();
$stats = $stmt->fetch(PDO::FETCH_ASSOC);

if ($stats) {
    $summaryStats['totalAdditions'] = (int)($stats['additions'] ?? 0);
    $summaryStats['totalRemovals'] = (int)($stats['removals'] ?? 0);
    $summaryStats['totalAdjustments'] = (int)($stats['adjustments'] ?? 0);
    $summaryStats['netChange'] = (int)($stats['net'] ?? 0);
}

echo json_encode([
    'success' => true,
    'movements' => $movements,
    'summary' => $summaryStats,
    'total' => $total,
    'page' => $page,
    'pageSize' => $pageSize,
    'totalPages' => max(1, (int)ceil($total / $pageSize)),
]);

?>
