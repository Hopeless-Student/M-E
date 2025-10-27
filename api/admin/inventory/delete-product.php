<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../../config/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$productId = (int)($input['productId'] ?? 0);

if ($productId <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid product ID']);
    exit;
}

try {
    // Soft delete - set isActive to 0
    $stmt = $pdo->prepare("UPDATE products SET isActive = 0, updated_at = NOW() WHERE product_id = :id");
    $stmt->execute([':id' => $productId]);

    if ($stmt->rowCount() === 0) {
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Product not found']);
        exit;
    }

    echo json_encode([
        'success' => true,
        'message' => 'Product deleted successfully'
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

?>
