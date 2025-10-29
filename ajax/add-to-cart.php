<?php
require_once __DIR__ . '/../includes/database.php';
session_start();

$product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

if ($product_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Missing or invalid product_id']);
    exit;
}

try {
    $pdo = connect();

    // check if merong ganito sa product
    $check = $pdo->prepare("SELECT product_id, unit FROM products WHERE product_id = ?");
    $check->execute([$product_id]);
    $product = $check->fetch(PDO::FETCH_ASSOC);
    if (!$product) {
        echo json_encode(['success' => false, 'message' => 'Invalid product']);
        exit;
    }
    $unit = $product['unit'] ?? 'piece';
    // if logged store agad sa db
    if (isset($_SESSION['user_id'])) {
        $user_id = (int)$_SESSION['user_id'];

        $stmt = $pdo->prepare("SELECT * FROM shopping_cart WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$user_id, $product_id]);
        $existing = $stmt->fetch();

        if ($existing) {
            $pdo->prepare("UPDATE shopping_cart SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?")
                ->execute([$quantity, $user_id, $product_id]);
        } else {
            $pdo->prepare("INSERT INTO shopping_cart (user_id, product_id, quantity) VALUES (?, ?, ?)")
                ->execute([$user_id, $product_id, $quantity]);
        }

        echo json_encode(['success' => true, 'message' => 'Added to cart']);
        exit;
    }

    // ifnot logged in session cart lanh
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = [
            'quantity' => $quantity,
            'unit' => $unit
        ];
    }

    echo json_encode(['success' => true, 'message' => 'Added to temporary cart']);
    exit;

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    exit;
}
?>
