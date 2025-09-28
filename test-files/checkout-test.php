<?php
require_once __DIR__ .'/../includes/database.php';
require_once __DIR__ .'/../auth/auth.php';

$pdo = connect();
$user_id = $user['user_id'];

// Get cart items
$getCart = "SELECT
                c.cart_id,
                c.product_id,
                p.product_name,
                p.price,
                c.quantity,
                (p.price * c.quantity) AS subtotal
            FROM shopping_cart c
            JOIN products p ON c.product_id = p.product_id
            WHERE c.user_id = ?";
$stmt = $pdo->prepare($getCart);
$stmt->execute([$user_id]);
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total_amount = array_sum(array_column($cartItems, 'subtotal'));
$shipping_fee = 75.00;
$final_amount = $total_amount + $shipping_fee;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link href="../bootstrap-5.3.8-dist/css/bootstrap.css" rel="stylesheet">
    <link href="../ui/homepage.css" rel="stylesheet"/>
</head>
<body>
<div class="container checkout-container">
    <!-- Order Summary -->
    <div class="order-summary">
        <h2>Order Summary</h2>
        <?php foreach ($cartItems as $item): ?>
            <div class="summary-item">
                <div>
                    <strong><?= htmlspecialchars($item['product_name']) ?></strong><br>
                    <small>₱<?= number_format($item['price'], 2) ?> x <?= $item['quantity'] ?></small>
                </div>
                <div>
                    ₱<?= number_format($item['subtotal'], 2) ?>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="summary-item total">
            <span>Total:</span>
            <span>₱<?= number_format($final_amount, 2) ?></span>
        </div>
        <p class="mt-3 text-muted">Delivery Fee: ₱<?= number_format($shipping_fee, 2) ?></p>
    </div>

    <!-- Billing & Payment Info -->
    <div class="billing-info">
        <h4>Billing Information</h4>
        <form action="process-payment.php" method="POST">
            <input type="hidden" name="final_amount" value="<?= $final_amount ?>">
            <input type="hidden" name="user_id" value="<?= $user_id ?>">

            <div class="mb-3">
                <label for="fullname" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="fullname"
                       value="<?= htmlspecialchars($user['first_name'].' '.$user['last_name']); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address"
                       value="<?= htmlspecialchars($user['address']); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="instructions" class="form-label">Special Instructions</label>
                <textarea class="form-control" id="instructions" name="instructions" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label><input type="radio" name="payment_method" value="GCash" required> GCash</label><br>
                <label><input type="radio" name="payment_method" value="Card"> Credit/Debit Card</label><br>
                <label><input type="radio" name="payment_method" value="COD"> Cash on Delivery</label>
            </div>

            <button type="submit" class="btn-pay">
                Confirm & Pay ₱<?= number_format($final_amount, 2) ?>
            </button>
        </form>
        <h6>conflict test in test-files</h6>
    </div>
</div>
<script src="../bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
