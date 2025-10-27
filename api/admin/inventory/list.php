<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../../config/config.php';

$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$pageSize = isset($_GET['pageSize']) ? min(100, max(1, (int)$_GET['pageSize'])) : 12;
$q = trim($_GET['q'] ?? '');
$category = trim($_GET['category'] ?? '');
$stockStatus = trim($_GET['stockStatus'] ?? ''); // in-stock|low-stock|out-of-stock
$sortBy = trim($_GET['sortBy'] ?? 'name'); // name|price|stock|category|created_at

$offset = ($page - 1) * $pageSize;

$where = ['p.isActive = 1'];
$params = [];

if ($q !== '') {
    $where[] = '(p.product_name LIKE :q OR p.description LIKE :q OR p.product_code LIKE :q)';
    $params[':q'] = "%$q%";
}

if ($category !== '') {
    $where[] = '(c.category_slug = :catSlug OR c.category_name = :catName)';
    $params[':catSlug'] = $category;
    $params[':catName'] = $category;
}

if ($stockStatus !== '') {
    if ($stockStatus === 'out-of-stock') {
        $where[] = 'p.stock_quantity = 0';
    } else if ($stockStatus === 'low-stock') {
        $where[] = 'p.stock_quantity > 0 AND p.stock_quantity <= COALESCE(NULLIF(p.min_stock_level,0), 15)';
    } else if ($stockStatus === 'in-stock') {
        $where[] = 'p.stock_quantity > 15';
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
$sql = "SELECT p.product_id, p.product_name, p.product_code, p.description, p.price, 
               p.stock_quantity, p.min_stock_level, p.product_image, p.is_featured,
               p.created_at, p.updated_at,
               c.category_name, c.category_slug
        FROM products p
        INNER JOIN categories c ON c.category_id = p.category_id
        $whereSql
        ORDER BY ";

// Apply sorting
switch ($sortBy) {
    case 'price':
        $sql .= "p.price DESC";
        break;
    case 'stock':
        $sql .= "p.stock_quantity DESC";
        break;
    case 'category':
        $sql .= "c.category_name ASC";
        break;
    case 'created_at':
        $sql .= "p.created_at DESC";
        break;
    default:
        $sql .= "p.product_name ASC";
        break;
}

$sql .= " LIMIT :limit OFFSET :offset";

$stmt = $pdo->prepare($sql);
foreach ($params as $k => $v) { $stmt->bindValue($k, $v); }
$stmt->bindValue(':limit', $pageSize, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$baseImg = '../../assets/images/products/';
$items = array_map(function ($r) use ($baseImg) {
    $img = $r['product_image'] ? ($baseImg . $r['product_image']) : null;
    $stock = (int)$r['stock_quantity'];
    $minStock = (int)($r['min_stock_level'] ?? 15);
    
    // Determine stock status
    $stockStatus = 'in-stock';
    if ($stock === 0) {
        $stockStatus = 'out-of-stock';
    } else if ($stock <= $minStock) {
        $stockStatus = 'low-stock';
    }
    
    return [
        'id' => (int)$r['product_id'],
        'name' => $r['product_name'],
        'code' => $r['product_code'],
        'description' => $r['description'] ?? '',
        'price' => (float)$r['price'],
        'stock' => $stock,
        'minStock' => $minStock,
        'stockStatus' => $stockStatus,
        'category' => $r['category_slug'] ?? $r['category_name'],
        'categoryLabel' => $r['category_name'] ?? $r['category_slug'],
        'featured' => (int)($r['is_featured'] ?? 0) === 1,
        'image' => $img,
        'createdAt' => $r['created_at'],
        'updatedAt' => $r['updated_at'],
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
