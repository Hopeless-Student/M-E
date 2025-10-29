<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../../config/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$name = trim($_POST['product_name'] ?? '');
$sku = trim($_POST['product_code']);
$category = trim($_POST['category'] ?? '');
$price = isset($_POST['price']) ? (float)$_POST['price'] : null;
$stock = isset($_POST['stock']) ? (int)$_POST['stock'] : null;
$description = trim($_POST['description'] ?? '');

if ($name === '' || $category === '' || $price === null || $stock === null || $sku === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required fields']);
    exit;
}

// Translate category from simple key/slug/name to id
$catId = null;
$catMap = [
    'office' => ['office-supplies', 'Office Supplies'],
    'school' => ['school-supplies', 'School Supplies'],
    'sanitary' => ['sanitary', 'Sanitary', 'Hygiene Products']
];
if (ctype_digit($category)) {
    $catId = (int)$category;
} else {
    $searches = [];
    if (isset($catMap[strtolower($category)])) {
        foreach ($catMap[strtolower($category)] as $v) { $searches[] = $v; }
    } else {
        $searches[] = $category;
    }
    $catId = 0;
    foreach ($searches as $val) {
        $sqlCat = "SELECT category_id FROM categories WHERE category_slug = :c OR category_name = :c LIMIT 1";
        $stmt = $pdo->prepare($sqlCat);
        $stmt->execute([':c' => $val]);
        $cid = (int)($stmt->fetchColumn() ?: 0);
        if ($cid > 0) { $catId = $cid; break; }
    }
}
if ($catId <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid category']);
    exit;
}

$imageFilename = null;
if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
    $tmp = $_FILES['product_image']['tmp_name'];
    $orig = basename($_FILES['product_image']['name']);
    $ext = strtolower(pathinfo($orig, PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($ext, $allowed)) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid image format']);
        exit;
    }
    $maxSize = 5 * 1024 * 1024; // 5MB
    if (@filesize($tmp) > $maxSize) {
        http_response_code(400);
        echo json_encode(['error' => 'Image too large (max 5MB)']);
        exit;
    }
    $imageFilename = 'prod_' . time() . '_' . mt_rand(1000,9999) . '.' . $ext;
    $destDir = __DIR__ . '/../../../assets/images/products/';
    if (!is_dir($destDir)) { @mkdir($destDir, 0775, true); }
    if (!move_uploaded_file($tmp, $destDir . $imageFilename)) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to save image']);
        exit;
    }
}

$sql = "INSERT INTO products (category_id, product_name, description, product_code, price, stock_quantity, product_image, isActive, created_at)
        VALUES (:cat, :name, :desc, :sku, :price, :stock, :img, 1, NOW())";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':cat' => $catId,
    ':name' => $name,
    ':desc' => $description,
    ':sku' => $sku,
    ':price' => $price,
    ':stock' => $stock,
    ':img' => $imageFilename,
]);

echo json_encode(['success' => true, 'id' => (int)$pdo->lastInsertId()]);
?>
