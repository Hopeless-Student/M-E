<?php
require_once __DIR__ . '/../includes/database.php';
$pdo = connect();

$q = isset($_GET['q']) ? trim($_GET['q']) : '';

if ($q === '') {
    echo json_encode([]);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT product_name FROM products WHERE product_name LIKE ? AND isActive = 1 LIMIT 10");
    $stmt->execute(["%$q%"]);
    $results = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo json_encode($results);
} catch (PDOException $e) {
    echo json_encode([]);
}
?>
