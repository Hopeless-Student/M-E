<?php
session_start();
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
$product_id = $_POST['product_id'] ?? null;

if ($product_id) {
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity']++;
    } else {
        $_SESSION['cart'][$product_id] = [
            'quantity' => 1
        ];
    }
}

header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
 ?>
