<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../../config/config.php';
// require_once __DIR__ . '/../../../includes/api_auth.php'; // Uncomment to enable authentication

if ($_SERVER['REQUEST_METHOD'] !== 'POST' && $_SERVER['REQUEST_METHOD'] !== 'DELETE') {
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

// Accept single id or array of ids
$ids = [];
if (isset($input['id'])) { $ids = [(int)$input['id']]; }
if (isset($input['ids']) && is_array($input['ids'])) { $ids = array_map('intval', $input['ids']); }
$ids = array_values(array_filter($ids, fn($v) => $v > 0));

if (count($ids) === 0) {
    http_response_code(400);
    echo json_encode(['error' => 'No product ids provided']);
    exit;
}

try {
    // First, get all image filenames for products to be deleted
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $sqlImages = "SELECT product_image FROM products WHERE product_id IN ($placeholders)";
    $stmtImages = $pdo->prepare($sqlImages);
    $pos = 1;
    foreach ($ids as $id) {
        $stmtImages->bindValue($pos++, $id, PDO::PARAM_INT);
    }
    $stmtImages->execute();
    $images = $stmtImages->fetchAll(PDO::FETCH_COLUMN);

    // Delete products from database
    $sql = "DELETE FROM products WHERE product_id IN ($placeholders)";
    $stmt = $pdo->prepare($sql);
    $i = 1;
    foreach ($ids as $id) {
        $stmt->bindValue($i++, $id, PDO::PARAM_INT);
    }
    $stmt->execute();

    $deletedCount = $stmt->rowCount();

    // Delete associated images from filesystem
    $imageDir = __DIR__ . '/../../../assets/images/products/';
    $deletedImages = 0;
    foreach ($images as $imageFile) {
        if ($imageFile && $imageFile !== '') {
            $imagePath = $imageDir . $imageFile;
            if (file_exists($imagePath)) {
                if (@unlink($imagePath)) {
                    $deletedImages++;
                }
            }
        }
    }

    echo json_encode([
        'success' => true,
        'deleted' => $deletedCount,
        'images_deleted' => $deletedImages,
        'message' => "Successfully deleted $deletedCount product(s)"
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to delete product(s)']);
    exit;
}
?>
