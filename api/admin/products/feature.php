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

$featured = isset($input['featured']) ? (int)(bool)$input['featured'] : 1;
$placeholders = implode(',', array_fill(0, count($ids), '?'));
$sql = "UPDATE products SET is_featured = :f WHERE product_id IN ($placeholders)";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':f', $featured, PDO::PARAM_INT);
$pos = 1;
foreach ($ids as $id) { $stmt->bindValue($pos++, $id, PDO::PARAM_INT); }
$stmt->execute();

echo json_encode(['success' => true, 'updated' => count($ids)]);
?>


