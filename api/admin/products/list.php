<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../../config/config.php';
// require_once __DIR__ . '/../../../includes/api_auth.php'; // Uncomment to enable authentication

$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$pageSize = isset($_GET['pageSize']) ? min(100, max(1, (int)$_GET['pageSize'])) : 12;
$q = trim($_GET['q'] ?? '');
$featured = isset($_GET['featured']) ? trim($_GET['featured']) : '';
$category = trim($_GET['category'] ?? ''); // can be slug or simple key like office/school/sanitary
$stock = trim($_GET['stock'] ?? ''); // in-stock|low-stock|out-of-stock

$offset = ($page - 1) * $pageSize;

// Map admin simple categories to real slugs/names
$catMap = [
    'office' => ['office-supplies', 'Office Supplies'],
    'school' => ['school-supplies', 'School Supplies'],
    'sanitary' => ['sanitary', 'Sanitary', 'Hygiene Products', 'Sanitary Supplies'],
];

$where = ['p.isActive = 1'];
$params = [];

if ($q !== '') {
    $where[] = '(p.product_name LIKE :q OR p.description LIKE :q OR p.product_code LIKE :q)';
    $params[':q'] = "%$q%";
}

if ($category !== '') {
    $catLower = strtolower($category);
    if (isset($catMap[$catLower])) {
        $searches = $catMap[$catLower];
        $orConditions = [];
        foreach ($searches as $idx => $searchTerm) {
            $paramKey = ":catSearch$idx";
            $orConditions[] = "(c.category_slug = $paramKey OR c.category_name = $paramKey)";
            $params[$paramKey] = $searchTerm;
        }
        $where[] = '(' . implode(' OR ', $orConditions) . ')';
    } else if (ctype_digit($category)) {
        $where[] = 'p.category_id = :catId';
        $params[':catId'] = (int)$category;
    } else {
        $where[] = '(c.category_slug = :catSlug OR c.category_name = :catName)';
        $params[':catSlug'] = $category;
        $params[':catName'] = $category;
    }
}

if ($stock !== '') {
    if ($stock === 'out-of-stock') {
        $where[] = 'p.stock_quantity = 0';
    } else if ($stock === 'low-stock') {
        $where[] = 'p.stock_quantity > 0 AND p.stock_quantity <= COALESCE(NULLIF(p.min_stock_level,0), 15)';
    } else if ($stock === 'in-stock') {
        $where[] = 'p.stock_quantity > 15';
    }
}

if ($featured !== '') {
    if ($featured === '1' || strtolower($featured) === 'true') {
        $where[] = 'p.is_featured = 1';
    } else if ($featured === '0' || strtolower($featured) === 'false') {
        $where[] = 'p.is_featured = 0';
    }
}

$whereSql = count($where) ? ('WHERE ' . implode(' AND ', $where)) : '';

// Count
$countSql = "SELECT COUNT(*) FROM products p INNER JOIN categories c ON c.category_id = p.category_id $whereSql";
$stmt = $pdo->prepare($countSql);
foreach ($params as $k => $v) { $stmt->bindValue($k, $v); }
$stmt->execute();
$total = (int)$stmt->fetchColumn();

// Data
$sql = "SELECT p.product_id, p.product_name, p.description, p.price, p.product_image, p.stock_quantity,
               p.is_featured, p.unit, p.product_code,
               c.category_name, c.category_slug
        FROM products p
        INNER JOIN categories c ON c.category_id = p.category_id
        $whereSql
        ORDER BY p.created_at DESC
        LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($sql);
foreach ($params as $k => $v) { $stmt->bindValue($k, $v); }
$stmt->bindValue(':limit', $pageSize, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$baseImg = '../../assets/images/products/';
$items = array_map(function ($r) use ($baseImg) {
    $img = $r['product_image'] ? ($baseImg . $r['product_image']) : null;
    return [
        'id' => (int)$r['product_id'],
        'name' => $r['product_name'],
        'description' => $r['description'] ?? '',
        'price' => (float)$r['price'],
        'category' => $r['category_slug'] ?? $r['category_name'],
        'categoryLabel' => $r['category_name'] ?? $r['category_slug'],
        'stock' => (int)$r['stock_quantity'],
        'unit' => $r['unit'] ?? 'pieces',
        'productCode' => $r['product_code'] ?? '',
        'featured' => (int)($r['is_featured'] ?? 0) === 1,
        'image' => $img,
    ];
}, $rows);

echo json_encode([
    'items' => $items,
    'total' => $total,
    'page' => $page,
    'pageSize' => $pageSize,
    'totalPages' => max(1, (int)ceil($total / $pageSize)),
]);
?>
