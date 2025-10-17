<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../../config/config.php';

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

$category = isset($input['category']) ? trim($input['category']) : '';
$priceAdjustment = isset($input['priceAdjustment']) ? (float)$input['priceAdjustment'] : null; // percent

$sets = [];
$params = [];

if ($category !== '') {
    if (ctype_digit($category)) {
        $catId = (int)$category;
    } else {
        $sqlCat = "SELECT category_id FROM categories WHERE category_slug = :c OR category_name = :c LIMIT 1";
        $stmt = $pdo->prepare($sqlCat);
        $stmt->execute([':c' => $category]);
        $catId = (int)($stmt->fetchColumn() ?: 0);
    }
    if ($catId > 0) {
        $sets[] = 'category_id = :catId';
        $params[':catId'] = $catId;
    }
}

if ($priceAdjustment !== null && $priceAdjustment != 0.0) {
    // price = price * (1 + priceAdjustment/100)
    $sets[] = 'price = ROUND(price * (1 + :pct), 2)';
    $params[':pct'] = $priceAdjustment / 100.0;
}

if (count($sets) === 0) {
    echo json_encode(['success' => true, 'updated' => 0]);
    exit;
}

$placeholders = implode(',', array_fill(0, count($ids), '?'));
$sql = 'UPDATE products SET ' . implode(', ', $sets) . " WHERE product_id IN ($placeholders)";
$stmt = $pdo->prepare($sql);
foreach ($params as $k => $v) { $stmt->bindValue($k, $v); }
$pos = 1;
foreach ($ids as $id) { $stmt->bindValue($pos++, $id, PDO::PARAM_INT); }
$stmt->execute();

echo json_encode(['success' => true, 'updated' => count($ids)]);
?>


