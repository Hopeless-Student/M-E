<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../../config/config.php';

$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$pageSize = isset($_GET['pageSize']) ? min(100, max(1, (int)$_GET['pageSize'])) : 10;
$category = trim($_GET['category'] ?? '');
$alertLevel = trim($_GET['alertLevel'] ?? '');
$q = trim($_GET['q'] ?? '');

$offset = ($page - 1) * $pageSize;

$where = ['p.isActive = 1'];
$params = [];

// Only get products that are low stock or out of stock
$where[] = 'p.stock_quantity <= COALESCE(NULLIF(p.min_stock_level, 0), 15)';

if ($category !== '') {
    $where[] = 'c.category_slug = :category';
    $params[':category'] = $category;
}

if ($q !== '') {
    $where[] = '(p.product_name LIKE :q OR p.product_code LIKE :q)';
    $params[':q'] = "%$q%";
}

// Alert level filtering
if ($alertLevel === 'critical') {
    $where[] = '(p.stock_quantity = 0 OR p.stock_quantity <= COALESCE(NULLIF(p.min_stock_level, 0), 15) * 0.5)';
} else if ($alertLevel === 'warning') {
    $where[] = 'p.stock_quantity > COALESCE(NULLIF(p.min_stock_level, 0), 15) * 0.5 AND p.stock_quantity <= COALESCE(NULLIF(p.min_stock_level, 0), 15)';
}

$whereSql = 'WHERE ' . implode(' AND ', $where);

// Count
$countSql = "SELECT COUNT(*) FROM products p INNER JOIN categories c ON c.category_id = p.category_id $whereSql";
$stmt = $pdo->prepare($countSql);
foreach ($params as $k => $v) { $stmt->bindValue($k, $v); }
$stmt->execute();
$total = (int)$stmt->fetchColumn();

// Get low stock items
$sql = "SELECT p.product_id, p.product_name, p.product_code, p.stock_quantity,
               p.min_stock_level, p.created_at, p.updated_at,
               c.category_name, c.category_slug,
               COALESCE(
                   (SELECT sm.created_at FROM stock_movements sm
                    WHERE sm.product_id = p.product_id AND sm.movement_type = 'add'
                    ORDER BY sm.created_at DESC LIMIT 1),
                   p.created_at
               ) as last_restock
        FROM products p
        INNER JOIN categories c ON c.category_id = p.category_id
        $whereSql
        ORDER BY
            CASE
                WHEN p.stock_quantity = 0 THEN 0
                WHEN p.stock_quantity <= COALESCE(NULLIF(p.min_stock_level, 0), 15) * 0.5 THEN 1
                ELSE 2
            END,
            p.stock_quantity ASC
        LIMIT :limit OFFSET :offset";

$stmt = $pdo->prepare($sql);
foreach ($params as $k => $v) { $stmt->bindValue($k, $v); }
$stmt->bindValue(':limit', $pageSize, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$items = array_map(function ($r) {
    $stock = (int)$r['stock_quantity'];
    $minStock = (int)($r['min_stock_level'] ?? 15);

    // Determine alert level
    $alertLevel = 'warning';
    if ($stock === 0 || $stock <= $minStock * 0.5) {
        $alertLevel = 'critical';
    }

    // Calculate days supply (assume 2.5 units per day average)
    $avgDailyUsage = 2.5;
    $daysSupply = $stock > 0 ? (int)ceil($stock / $avgDailyUsage) : 0;

    return [
        'id' => (int)$r['product_id'],
        'name' => $r['product_name'],
        'sku' => $r['product_code'],
        'category' => $r['category_slug'],
        'currentStock' => $stock,
        'minStock' => $minStock,
        'alertLevel' => $alertLevel,
        'daysSupply' => $daysSupply,
        'lastRestock' => date('Y-m-d', strtotime($r['last_restock'])),
        'avgDailyUsage' => $avgDailyUsage,
        'icon' => '📦'
    ];
}, $rows);

// Summary counts
$summarySql = "SELECT
                COUNT(CASE WHEN p.stock_quantity = 0 OR p.stock_quantity <= COALESCE(NULLIF(p.min_stock_level, 0), 15) * 0.5 THEN 1 END) as critical,
                COUNT(CASE WHEN p.stock_quantity > COALESCE(NULLIF(p.min_stock_level, 0), 15) * 0.5 AND p.stock_quantity <= COALESCE(NULLIF(p.min_stock_level, 0), 15) THEN 1 END) as warning,
                COUNT(*) as total
               FROM products p
               INNER JOIN categories c ON c.category_id = p.category_id
               WHERE p.isActive = 1 AND p.stock_quantity <= COALESCE(NULLIF(p.min_stock_level, 0), 15)";

$stmt = $pdo->query($summarySql);
$summary = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode([
    'success' => true,
    'items' => $items,
    'summary' => [
        'critical' => (int)($summary['critical'] ?? 0),
        'warning' => (int)($summary['warning'] ?? 0),
        'total' => (int)($summary['total'] ?? 0)
    ],
    'total' => $total,
    'page' => $page,
    'pageSize' => $pageSize,
    'totalPages' => max(1, (int)ceil($total / $pageSize)),
]);
?>
