<?php
require_once __DIR__ .'/includes/database.php';
echo "hehe";
$user_id = 100;
$pdo = connect();

echo " Testing cart: 9/12/2025";
try {
  $sql = "SELECT c.cart_id,
            u.user_id AS user_id,
            u.username,
            p.product_name,
            p.price,
            c.quantity,
            (p.price * c.quantity) AS subtotal,
            c.added_at
        FROM shopping_cart c
        JOIN users u ON c.user_id = u.user_id
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
<html>
<head>
    <title>My Cart</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h2 class="mb-4">My Shopping Cart</h2>
        <table class="table table-bordered table-striped align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                    <th>Buyer</th>
                    <th>Added At</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $grandTotal = 0;
                foreach ($cartItems as $item):
                    $grandTotal += $item['subtotal'];
                ?>
                <tr>
                    <td><?= htmlspecialchars($item['product_name']) ?></td>
                    <td>₱<?= number_format($item['price'], 2) ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td>₱<?= number_format($item['subtotal'], 2) ?></td>
                    <td><?= htmlspecialchars($item['username']) ?></td>
                    <td><?= $item['added_at'] ?></td>
                </tr>
                <?php endforeach; ?>
                <tr class="fw-bold table-info">
                    <td colspan="3" class="text-end">Total:</td>
                    <td colspan="3">₱<?= number_format($grandTotal, 2) ?></td>
                </tr>
            </tbody>
        </table>
        <input type="submit" name="checkout" value="Check out orders">
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
