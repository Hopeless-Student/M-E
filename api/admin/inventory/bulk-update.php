<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../../config/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

$category = trim($input['category'] ?? '');
$action = trim($input['action'] ?? '');
$value = floatval($input['value'] ?? 0);
$user = trim($input['user'] ?? 'Admin');

// Validation
if (empty($category)) {
    echo json_encode(['success' => false, 'message' => 'Category is required']);
    exit;
}

if (!in_array($action, ['increase', 'decrease', 'setMin'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid action']);
    exit;
}

if ($value <= 0) {
    echo json_encode(['success' => false, 'message' => 'Value must be positive']);
    exit;
}

try {
    $pdo->beginTransaction();

    // Get category ID
    $stmt = $pdo->prepare("SELECT category_id FROM categories WHERE category_slug = :slug");
    $stmt->execute([':slug' => $category]);
    $categoryData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$categoryData) {
        throw new Exception('Category not found');
    }

    $categoryId = $categoryData['category_id'];

    // Get all products in this category
    $stmt = $pdo->prepare("SELECT product_id, product_name, product_code, stock_quantity, min_stock_level FROM products WHERE category_id = :catId AND isActive = 1");
    $stmt->execute([':catId' => $categoryId]);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($products)) {
        throw new Exception('No products found in this category');
    }

    $updatedCount = 0;

    foreach ($products as $product) {
        $productId = $product['product_id'];
        $currentStock = (int)$product['stock_quantity'];
        $currentMinStock = (int)$product['min_stock_level'];

        if ($action === 'increase') {
            $newStock = (int)round($currentStock * (1 + $value / 100));

            $stmt = $pdo->prepare("UPDATE products SET stock_quantity = :stock, updated_at = NOW() WHERE product_id = :id");
            $stmt->execute([':stock' => $newStock, ':id' => $productId]);

            // Log movement
            $stmt = $pdo->prepare("INSERT INTO stock_movements (product_id, movement_type, quantity, previous_stock, new_stock, reason, user_name, created_at) VALUES (:pid, 'add', :qty, :prev, :new, :reason, :user, NOW())");
            $stmt->execute([
                ':pid' => $productId,
                ':qty' => $newStock - $currentStock,
                ':prev' => $currentStock,
                ':new' => $newStock,
                ':reason' => "Bulk increase by {$value}%",
                ':user' => $user
            ]);

            $updatedCount++;

        } else if ($action === 'decrease') {
            $newStock = max(0, (int)round($currentStock * (1 - $value / 100)));

            $stmt = $pdo->prepare("UPDATE products SET stock_quantity = :stock, updated_at = NOW() WHERE product_id = :id");
            $stmt->execute([':stock' => $newStock, ':id' => $productId]);

            // Log movement
            $stmt = $pdo->prepare("INSERT INTO stock_movements (product_id, movement_type, quantity, previous_stock, new_stock, reason, user_name, created_at) VALUES (:pid, 'remove', :qty, :prev, :new, :reason, :user, NOW())");
            $stmt->execute([
                ':pid' => $productId,
                ':qty' => $currentStock - $newStock,
                ':prev' => $currentStock,
                ':new' => $newStock,
                ':reason' => "Bulk decrease by {$value}%",
                ':user' => $user
            ]);

            $updatedCount++;

        } else if ($action === 'setMin') {
            $newMinStock = (int)$value;

            $stmt = $pdo->prepare("UPDATE products SET min_stock_level = :minStock, updated_at = NOW() WHERE product_id = :id");
            $stmt->execute([':minStock' => $newMinStock, ':id' => $productId]);

            $updatedCount++;
        }
    }

    $pdo->commit();

    echo json_encode([
        'success' => true,
        'message' => "Bulk update completed! $updatedCount items updated successfully.",
        'updatedCount' => $updatedCount
    ]);

} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
