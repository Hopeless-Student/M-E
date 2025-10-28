<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../../config/config.php';

$productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($productId <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid product ID']);
    exit;
}

try {
    $stmt = $pdo->prepare("
        SELECT p.product_id, p.product_name, p.product_code, p.description, p.price,
               p.stock_quantity, p.min_stock_level, p.product_image, p.is_featured,
               p.created_at, p.updated_at,
               c.category_name, c.category_slug
        FROM products p
        INNER JOIN categories c ON c.category_id = p.category_id
        WHERE p.product_id = :id AND p.isActive = 1
    ");

    $stmt->execute([':id' => $productId]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Product not found']);
        exit;
    }

    $stock = (int)$product['stock_quantity'];
    $minStock = (int)($product['min_stock_level'] ?? 15);
    $totalValue = $stock * (float)$product['price'];

    echo json_encode([
        'success' => true,
        'product' => [
            'id' => (int)$product['product_id'],
            'name' => $product['product_name'],
            'sku' => $product['product_code'],
            'description' => $product['description'] ?? '',
            'price' => (float)$product['price'],
            'stock' => $stock,
            'minStock' => $minStock,
            'totalValue' => $totalValue,
            'categoryName' => $product['category_name'],
            'categorySlug' => $product['category_slug'],
            'featured' => (int)($product['is_featured'] ?? 0) === 1,
            'image' => $product['product_image'] ? ('/assets/images/products/' . $product['product_image']) : null,
            'createdAt' => $product['created_at'],
            'updatedAt' => $product['updated_at']
        ]
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

?>
