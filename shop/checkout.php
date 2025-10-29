<?php
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../auth/mainpage-auth.php';

if($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['selectedItems'])){
    header("Location: cart.php");
    exit;
}

$selectedItems = json_decode($_POST['selectedItems'], true);

if(empty($selectedItems)){
    echo "<script>alert('No items selected. Redirecting to cart.'); window.location.href='cart.php';</script>";
    exit;
}

$pdo = connect();
$totalAmount = 0;

// Fetch full product info from database for selected items
$productIds = array_column($selectedItems, 'id');
$placeholders = implode(',', array_fill(0, count($productIds), '?'));
$stmt = $pdo->prepare("SELECT * FROM products WHERE product_id IN ($placeholders)");
$stmt->execute($productIds);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Merge quantity info
$cartItems = [];
foreach($products as $prod){
    foreach($selectedItems as $sel){
        if($sel['id'] == $prod['product_id']){
            $prod['quantity'] = $sel['quantity'];
            $prod['subtotal'] = $prod['price'] * $sel['quantity'];
            $totalAmount += $prod['subtotal'];
            $cartItems[] = $prod;
        }
    }
}

$shippingFee = 75.00;
$finalAmount = $totalAmount + $shippingFee;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="../bootstrap-5.3.8-dist/css/bootstrap.css" rel="stylesheet">
    <link href="../assets/css/homepage.css" rel="stylesheet"/>
    <style>
        .checkout-table img { width: 60px; height: 60px; object-fit: cover; }
        .checkout-summary { margin-top: 2rem; }
        .checkout-summary div { margin-bottom: 0.5rem; }
        .btn-back { margin-bottom: 1rem; }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2>Checkout</h2>

    <a href="cart.php" class="btn btn-secondary btn-back">&larr; Back to Cart</a>

    <h4 class="mt-4">Order Summary</h4>
    <table class="table table-bordered checkout-table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($cartItems as $item): ?>
            <tr>
                <td>
                    <img src="../assets/images/products/<?= htmlspecialchars($item['product_image'] ?? 'default.png') ?>" alt="<?= htmlspecialchars($item['product_name']) ?>">
                    <?= htmlspecialchars($item['product_name']) ?>
                </td>
                <td>₱<?= number_format($item['price'], 2) ?></td>
                <td><?= $item['quantity'] ?></td>
                <td>₱<?= number_format($item['subtotal'], 2) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="checkout-summary">
        <div><strong>Subtotal:</strong> ₱<?= number_format($totalAmount, 2) ?></div>
        <div><strong>Shipping Fee:</strong> ₱<?= number_format($shippingFee, 2) ?></div>
        <div><strong>Total Amount:</strong> ₱<?= number_format($finalAmount, 2) ?></div>
    </div>

    <h4 class="mt-4">Payment & Delivery Information</h4>
    <form action="process-payment.php" method="POST">
        <input type="hidden" name="final_amount" value="<?= $finalAmount ?>">
        <input type="hidden" name="selectedItems" value='<?= json_encode($cartItems) ?>'>

        <div class="mb-3">
            <label>Full Name</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($user['first_name'].' '.$user['last_name']) ?>" readonly>
        </div>

        <div class="mb-3">
            <label>Address</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($user['address']) ?>" readonly>
        </div>

        <div class="mb-3">
            <label>Special Instructions</label>
            <textarea class="form-control" name="instructions" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label>Payment Method</label><br>
            <input type="radio" name="payment_method" value="GCash" required> GCash<br>
            <input type="radio" name="payment_method" value="Card"> Credit/Debit Card<br>
            <input type="radio" name="payment_method" value="COD"> Cash on Delivery
        </div>

        <button type="submit" class="btn btn-primary btn-lg">
            Confirm & Pay ₱<?= number_format($finalAmount, 2) ?>
        </button>
    </form>
</div>
</body>
</html>
