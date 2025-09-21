<?php
require_once __DIR__ .'/../includes/database.php';
require_once __DIR__ .'/../auth/auth.php';

$pdo = connect();
$user_id = $user['user_id'];

try {
    $sql = "SELECT c.cart_id,
                p.product_name,
                p.price,
                c.quantity,
                (p.price * c.quantity) AS subtotal
            FROM shopping_cart c
            JOIN products p ON c.product_id = p.product_id
            WHERE c.user_id = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link href="../bootstrap-5.3.8-dist/css/bootstrap.css" rel="stylesheet">
    <link href="../ui/homepage.css" rel="stylesheet"/>
    <style>
        body {
            background-color: #f4f7fa;
            font-family: 'Segoe UI', sans-serif;
        }

        h2, h4 {
            color: #002366;
        }

        .checkout-container {
            display: flex;
            justify-content: space-between;
            gap: 30px;
            margin-top: 50px;
        }

        .order-summary, .billing-info {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.05);
        }

        .order-summary {
            flex: 0 0 55%;
        }

        .billing-info {
            flex: 0 0 40%;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .total {
            font-weight: bold;
            font-size: 18px;
        }

        .form-control:focus {
            border-color: #002366;
            box-shadow: none;
        }

        .btn-pay {
            background-color: #002366;
            color: white;
            font-weight: 500;
            padding: 12px;
            border: none;
            width: 100%;
            border-radius: 8px;
            margin-top: 20px;
        }

        .btn-pay:hover {
            background-color: #001f4d;
        }
    </style>
</head>
<body>

<div class="container checkout-container">
    <!-- Order Summary -->
    <div class="order-summary">
        <h2>Order Summary</h2>
        <?php $grandTotal = 0; ?>
        <?php foreach ($cartItems as $item): ?>
            <?php $grandTotal += $item['subtotal']; ?>
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
            <span>₱<?= number_format($grandTotal, 2) ?></span>
        </div>
        <p class="mt-3 text-muted">Delivery: <strong>Free</strong> (Standard 3-5 days)</p>
    </div>

    <!-- Billing & Payment Info -->
    <div class="billing-info">
        <h4>Billing Information</h4>
        <form action="process-payment.php" method="POST">
            <div class="mb-3">
                <label for="fullname" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="fullname" name="fullname" required>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Shipping Address</label>
                <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label for="paymentMethod" class="form-label">Payment Method</label>
                <select class="form-control" id="paymentMethod" name="paymentMethod" required>
                    <option value="">Select...</option>
                    <option value="credit_card">Credit Card</option>
                    <option value="paypal">PayPal</option>
                    <option value="gcash">GCash</option>
                </select>
            </div>

            <button type="submit" class="btn-pay">Confirm & Pay ₱<?= number_format($grandTotal, 2) ?></button>
        </form>
    </div>
</div>

<script src="../bootstrap-5.3.8-dist/js/bootstrap.min.js"></script>
</body>
</html>
