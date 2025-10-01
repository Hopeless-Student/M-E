<?php
require_once __DIR__ . '/../includes/database.php';
include('auth.php');

$pdo = connect();
$user_id = $user['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cart_id = $_POST['cart_id'] ?? null;
    $action  = $_POST['action'] ?? null;

    if (!$cart_id || !$action) {
        die("Invalid request.");
    }

    try {
        if ($action === 'increase') {
            $sql = "UPDATE shopping_cart
                    SET quantity = quantity + 1
                    WHERE cart_id = ? AND user_id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$cart_id, $user_id]);

        } elseif ($action === 'decrease') {
            $sql = "UPDATE shopping_cart
                    SET quantity = GREATEST(quantity - 1, 1)
                    WHERE cart_id = ? AND user_id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$cart_id, $user_id]);

        } elseif ($action === 'remove') {
            $sql = "DELETE FROM shopping_cart
                    WHERE cart_id = ? AND user_id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$cart_id, $user_id]);
        }

        header("Location: ../pages/order-history-test.php");
        exit;

    } catch (PDOException $e) {
        echo "Database Error: " . $e->getMessage();
    }
}
?>
