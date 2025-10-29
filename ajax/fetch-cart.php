<?php
require_once __DIR__ . '/../includes/database.php';
session_start();

$cartItems = [];
header('Content-Type: application/json');

try {
    // if user is logged in select sa shopping_cart table
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $pdo = connect();

        $stmt = $pdo->prepare("
            SELECT c.product_id, c.quantity, p.product_name, p.price, p.product_image, p.unit, p.category_id, cat.category_name
            FROM shopping_cart c
            JOIN products p ON p.product_id = c.product_id
            LEFT JOIN categories cat ON cat.category_id = p.category_id
            WHERE c.user_id = ?
        ");
        $stmt->execute([$user_id]);
        $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // if not logged in session cartlang ulit
    elseif (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        $pdo = connect();
        foreach ($_SESSION['cart'] as $product_id => $data) {
          $stmt = $pdo->prepare("
              SELECT p.product_id, p.product_name, p.price, p.product_image, p.unit, p.category_id, cat.category_name
              FROM products p
              LEFT JOIN categories cat ON cat.category_id = p.category_id
              WHERE p.product_id = ?
            ");
            $stmt->execute([$product_id]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($product) {
                $cartItems[] = [
                    'product_id' => $product['product_id'],
                    'product_name' => $product['product_name'],
                    'price' => $product['price'],
                    'product_image' => $product['product_image'],
                    'quantity' => $data['quantity'],
                    'unit' => $product['unit'] ?? 'piece',
                    'category' => $product['category_name'] ?? 'Uncategorized'
                ];
            }
        }
    }

    echo json_encode([
        'cart' => $cartItems,
        'count' => array_sum(array_column($cartItems, 'quantity'))
    ]);

} catch (Exception $e) {
    echo json_encode([
        'cart' => [],
        'count' => 0,
        'error' => $e->getMessage()
    ]);
}
?>
