<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../../config/config.php';
// require_once __DIR__ . '/../../../includes/api_auth.php'; // Uncomment to enable authentication

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$name = trim($_POST['product_name'] ?? '');
$sku = trim($_POST['product_code'] ?? '');
$category = trim($_POST['category'] ?? '');
$price = isset($_POST['price']) ? (float)$_POST['price'] : null;
$stock = isset($_POST['stock']) ? (int)$_POST['stock'] : null;
$description = trim($_POST['description'] ?? '');
$unit = trim($_POST['unit'] ?? '');

// Validate required fields
if ($name === '' || $category === '' || $price === null || $stock === null || $sku === '' || $unit === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Missing required fields']);
    exit;
}

// Validate unit
$allowedUnits = ['box', 'pieces', 'reams', 'rolls', 'gallon', 'pack', 'pads'];
if (!in_array(strtolower($unit), $allowedUnits)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid unit. Allowed values: ' . implode(', ', $allowedUnits)]);
    exit;
}

// Validate name length
if (strlen($name) > 255) {
    http_response_code(400);
    echo json_encode(['error' => 'Product name too long (max 255 characters)']);
    exit;
}

// Validate description length
if (strlen($description) > 1000) {
    http_response_code(400);
    echo json_encode(['error' => 'Description too long (max 1000 characters)']);
    exit;
}

// Translate category from simple key/slug/name to id
$catId = null;
$catMap = [
    'office' => ['office-supplies', 'Office Supplies'],
    'school' => ['school-supplies', 'School Supplies'],
    'sanitary' => ['sanitary', 'Sanitary', 'Hygiene Products', 'Sanitary Supplies']
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

// Handle image upload
$imageFilename = null;
if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
    $tmp = $_FILES['product_image']['tmp_name'];
    $orig = basename($_FILES['product_image']['name']);
    $ext = strtolower(pathinfo($orig, PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (!in_array($ext, $allowed)) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid image format. Allowed: JPG, PNG, GIF, WebP']);
        exit;
    }

    // Validate file size (5MB)
    $maxSize = 5 * 1024 * 1024;
    if (@filesize($tmp) > $maxSize) {
        http_response_code(400);
        echo json_encode(['error' => 'Image too large (max 5MB)']);
        exit;
    }

    // Validate image dimensions and type
    $imageInfo = @getimagesize($tmp);
    if ($imageInfo === false) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid image file']);
        exit;
    }

    // Generate unique filename
    $imageFilename = 'prod_' . time() . '_' . mt_rand(1000, 9999) . '.' . $ext;
    $destDir = __DIR__ . '/../../../assets/images/products/';

    // Create directory if it doesn't exist
    if (!is_dir($destDir)) {
        @mkdir($destDir, 0775, true);
    }

    // Move uploaded file
    if (!move_uploaded_file($tmp, $destDir . $imageFilename)) {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to save image']);
        exit;
    }
}

try {
    $sql = "INSERT INTO products (category_id, product_name, description, product_code, price, stock_quantity, unit, product_image, isActive, is_featured, created_at)
            VALUES (:cat, :name, :desc, :sku, :price, :stock, :unit, :img, 1, 0, NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':cat' => $catId,
        ':name' => $name,
        ':desc' => $description,
        ':sku' => $sku,
        ':price' => $price,
        ':stock' => $stock,
        ':unit' => $unit,
        ':img' => $imageFilename,
    ]);

    $newId = (int)$pdo->lastInsertId();

    echo json_encode([
        'success' => true,
        'id' => $newId,
        'message' => 'Product created successfully'
    ]);

} catch (PDOException $e) {
    // If database insert fails, delete the uploaded image
    if ($imageFilename && file_exists($destDir . $imageFilename)) {
        @unlink($destDir . $imageFilename);
    }

    // Check for duplicate SKU
    if ($e->getCode() == 23000) {
        http_response_code(400);
        echo json_encode(['error' => 'Product code already exists']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Database error occurred']);
    }
    exit;
}
?>
