<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../../config/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $_SERVER['REQUEST_METHOD'] !== 'PATCH') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Support form-data and JSON
$input = $_POST;
if (empty($input)) {
    $raw = file_get_contents('php://input');
    $json = json_decode($raw, true);
    if (is_array($json)) { $input = $json; }
}

$id = isset($input['id']) ? (int)$input['id'] : 0;
if ($id <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid product id']);
    exit;
}

$fields = [];
$params = [':id' => $id];

if (isset($input['product_name'])) { $fields[] = 'product_name = :name'; $params[':name'] = trim($input['product_name']); }
if (isset($input['description'])) { $fields[] = 'description = :desc'; $params[':desc'] = trim($input['description']); }
if (isset($input['price'])) { $fields[] = 'price = :price'; $params[':price'] = (float)$input['price']; }
if (isset($input['stock'])) { $fields[] = 'stock_quantity = :stock'; $params[':stock'] = (int)$input['stock']; }
if (isset($input['category'])) {
    $cat = trim($input['category']);
    if (ctype_digit($cat)) {
        $fields[] = 'category_id = :catId';
        $params[':catId'] = (int)$cat;
    } else {
        $sqlCat = "SELECT category_id FROM categories WHERE category_slug = :c OR category_name = :c LIMIT 1";
        $stmt = $pdo->prepare($sqlCat);
        $stmt->execute([':c' => $cat]);
        $catId = (int)($stmt->fetchColumn() ?: 0);
        if ($catId > 0) { $fields[] = 'category_id = :catId'; $params[':catId'] = $catId; }
    }
}

// Handle new image if provided via multipart
if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
    $tmp = $_FILES['product_image']['tmp_name'];
    $orig = basename($_FILES['product_image']['name']);
    $ext = strtolower(pathinfo($orig, PATHINFO_EXTENSION));
    if (!in_array($ext, ['jpg','jpeg','png','gif'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid image format']);
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
    $fields[] = 'product_image = :img';
    $params[':img'] = $imageFilename;
}

if (count($fields) === 0) {
    echo json_encode(['success' => true]);
    exit;
}

$sql = 'UPDATE products SET ' . implode(', ', $fields) . ' WHERE product_id = :id';
$stmt = $pdo->prepare($sql);
$stmt->execute($params);

echo json_encode(['success' => true]);
?>


