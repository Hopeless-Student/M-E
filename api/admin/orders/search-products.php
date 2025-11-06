<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../../config/config.php';

// Require admin session
session_start();
if (!isset($_SESSION['admin_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

$query = isset($_GET['q']) ? trim($_GET['q']) : '';
$limit = isset($_GET['limit']) ? min(50, max(1, (int)$_GET['limit'])) : 20;

if (empty($query)) {
    echo json_encode(['success' => true, 'products' => []]);
    exit;
}

try {
    $sql = "SELECT p.product_id, p.product_name, p.product_code, p.price, 
                   p.stock_quantity, p.product_image,
                   c.category_name
            FROM products p
            INNER JOIN categories c ON c.category_id = p.category_id
            WHERE p.isActive = 1
              AND (p.product_name LIKE :query 
                   OR p.product_code LIKE :query
                   OR p.description LIKE :query)
            ORDER BY p.product_name
            LIMIT :limit";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':query', "%$query%", PDO::PARAM_STR);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $products = array_map(function($r) {
        $image = null;
        if (!empty($r['product_image'])) {
            $image = '../../assets/images/products/' . $r['product_image'];
        }

        return [
            'id' => (int)$r['product_id'],
            'name' => $r['product_name'],
            'code' => $r['product_code'] ?? '',
            'price' => (float)$r['price'],
            'stock' => (int)$r['stock_quantity'],
            'category' => $r['category_name'],
            'image' => $image,
            'available' => (int)$r['stock_quantity'] > 0
        ];
    }, $rows);

    echo json_encode([
        'success' => true,
        'products' => $products
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Error searching products'
    ]);
}
