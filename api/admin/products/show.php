<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../../config/config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid product id']);
    exit;
}

$sql = "SELECT p.product_id, p.product_name, p.description, p.price, p.product_image, p.stock_quantity,
               p.category_id, c.category_name, c.category_slug
        FROM products p
        INNER JOIN categories c ON c.category_id = p.category_id
        WHERE p.product_id = :id
        LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$row) {
    http_response_code(404);
    echo json_encode(['error' => 'Product not found']);
    exit;
}

$baseImg = '../../assets/images/products/';
$img = $row['product_image'] ? ($baseImg . $row['product_image']) : null;

echo json_encode([
    'id' => (int)$row['product_id'],
    'name' => $row['product_name'],
    'description' => $row['description'] ?? '',
    'price' => (float)$row['price'],
    'categoryId' => (int)$row['category_id'],
    'category' => $row['category_slug'] ?? $row['category_name'],
    'categoryLabel' => $row['category_name'] ?? $row['category_slug'],
    'stock' => (int)$row['stock_quantity'],
    'image' => $img,
]);
?>


