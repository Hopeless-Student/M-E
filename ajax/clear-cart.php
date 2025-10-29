<?php
require_once __DIR__ . '/../includes/database.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

try {
    $pdo = connect();
    $user_id = $_SESSION['user_id'];
    $pdo->prepare("DELETE FROM shopping_cart WHERE user_id = ?")->execute([$user_id]);

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
