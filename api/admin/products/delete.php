<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../../config/config.php';

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

$placeholders = implode(',', array_fill(0, count($ids), '?'));
$sql = "DELETE FROM products WHERE product_id IN ($placeholders)";
$stmt = $pdo->prepare($sql);
$i = 1;
foreach ($ids as $id) { $stmt->bindValue($i++, $id, PDO::PARAM_INT); }
$stmt->execute();

echo json_encode(['success' => true, 'deleted' => count($ids)]);
?>


