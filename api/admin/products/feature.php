<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../../config/config.php';
// require_once __DIR__ . '/../../../includes/api_auth.php'; // Uncomment to enable authentication

if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $_SERVER['REQUEST_METHOD'] !== 'PATCH') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$raw = file_get_contents('php://input');
$input = $_POST;
if (empty($input) && $raw) {
    $json = json_decode($raw, true);
    if (is_array($json)) { $input = $json; }
}

$ids = isset($input['ids']) && is_array($input['ids']) ? array_map('intval', $input['ids']) : [];
$ids = array_values(array_filter($ids, fn($v) => $v > 0));
if (count($ids) === 0) {
    http_response_code(400);
    echo json_encode(['error' => 'ids array is required']);
    exit;
}

$featured = isset($input['featured']) ? (int)(bool)$input['featured'] : 1;

try {
    // Ensure column exists
    $checkColumn = $pdo->query("SHOW COLUMNS FROM products LIKE 'is_featured'");
    if ($checkColumn->rowCount() === 0) {
        $pdo->exec("ALTER TABLE products ADD COLUMN is_featured TINYINT(1) NOT NULL DEFAULT 0 AFTER isActive");
        $pdo->exec("ALTER TABLE products ADD INDEX idx_is_featured (is_featured)");
    }

    // ✅ Use positional parameters only
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $sql = "UPDATE products SET is_featured = ? WHERE product_id IN ($placeholders)";
    $stmt = $pdo->prepare($sql);

    // Merge the featured value with the list of IDs
    $params = array_merge([$featured], $ids);
    $stmt->execute($params);

    $updatedCount = $stmt->rowCount();
    $action = $featured ? 'featured' : 'unfeatured';

    echo json_encode([
        'success' => true,
        'updated' => count($ids),
        'affected' => $updatedCount,
        'message' => "Successfully $action $updatedCount product(s)"
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Failed to update featured status',
        'details' => $e->getMessage(),
        'code' => $e->getCode()
    ]);
    exit;
}
?>
