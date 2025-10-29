<?php
require_once __DIR__ . '/../includes/database.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

$product_id = $_POST['product_id'] ?? null;
$quantity   = $_POST['quantity'] ?? null;

if (!$product_id || !$quantity) {
    echo json_encode(['success' => false, 'message' => 'Missing parameters']);
    exit;
}

try {
    $pdo = connect();
    $user_id = $_SESSION['user_id'];

    // Update the quantity for that user's item
    $stmt = $pdo->prepare("UPDATE shopping_cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$quantity, $user_id, $product_id]);

    echo json_encode(['success' => true, 'new_quantity' => $quantity]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
