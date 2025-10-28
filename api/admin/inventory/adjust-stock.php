<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../../config/config.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

$productId = (int)($input['productId'] ?? 0);
$adjustmentType = trim($input['type'] ?? ''); // add, remove, set
$quantity = (int)($input['quantity'] ?? 0);
$reason = trim($input['reason'] ?? '');
$user = trim($input['user'] ?? 'Admin'); // In production, get from session

// Validation
if ($productId <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid product ID']);
    exit;
}

if (!in_array($adjustmentType, ['add', 'remove', 'set'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid adjustment type']);
    exit;
}

if ($quantity < 0) {
    echo json_encode(['success' => false, 'message' => 'Quantity must be positive']);
    exit;
}

if (empty($reason)) {
    echo json_encode(['success' => false, 'message' => 'Reason is required']);
    exit;
}

try {
    $pdo->beginTransaction();

    // Get current stock
    $stmt = $pdo->prepare("SELECT product_name, product_code, stock_quantity FROM products WHERE product_id = :id AND isActive = 1");
    $stmt->execute([':id' => $productId]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        throw new Exception('Product not found');
    }

    $previousStock = (int)$product['stock_quantity'];
    $newStock = $previousStock;

    // Calculate new stock based on adjustment type
    switch ($adjustmentType) {
        case 'add':
            $newStock = $previousStock + $quantity;
            break;
        case 'remove':
            $newStock = max(0, $previousStock - $quantity);
            break;
        case 'set':
            $newStock = $quantity;
            break;
    }

    // Update product stock
    $stmt = $pdo->prepare("UPDATE products SET stock_quantity = :stock, updated_at = NOW() WHERE product_id = :id");
    $stmt->execute([':stock' => $newStock, ':id' => $productId]);

    // Log stock movement
    $stmt = $pdo->prepare("
        INSERT INTO stock_movements
        (product_id, movement_type, quantity, previous_stock, new_stock, reason, user_name, created_at)
        VALUES
        (:product_id, :type, :quantity, :prev, :new, :reason, :user, NOW())
    ");

    $stmt->execute([
        ':product_id' => $productId,
        ':type' => $adjustmentType,
        ':quantity' => $quantity,
        ':prev' => $previousStock,
        ':new' => $newStock,
        ':reason' => $reason,
        ':user' => $user
    ]);

    $movementId = $pdo->lastInsertId();

    $pdo->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Stock adjusted successfully',
        'data' => [
            'productId' => $productId,
            'productName' => $product['product_name'],
            'productCode' => $product['product_code'],
            'previousStock' => $previousStock,
            'newStock' => $newStock,
            'adjustmentType' => $adjustmentType,
            'quantity' => $quantity,
            'reason' => $reason,
            'movementId' => $movementId,
            'timestamp' => date('Y-m-d H:i:s')
        ]
    ]);

} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

?>
