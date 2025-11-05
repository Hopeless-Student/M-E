<?php
session_start();
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../auth/auth.php';

$pdo = connect();

$orderId = $_GET['order_id'] ?? null;

if (!$orderId) {
    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare("SELECT order_number, final_amount, payment_method, order_status
                       FROM orders WHERE order_id=? AND user_id=? LIMIT 1");
$stmt->execute([$orderId, $user['user_id']]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare("DELETE FROM shopping_cart WHERE user_id=?");
$stmt->execute([$user['user_id']]);

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Thank You</title>
<link href="../bootstrap-5.3.8-dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    background: linear-gradient(135deg, #e0f0ff, #f1f3f5);
    font-family: 'Segoe UI', sans-serif;
}
.card {
    max-width: 480px;
    width: 100%;
    padding: 2rem;
    border-radius: 16px;
    box-shadow: 0 12px 30px rgba(0,0,0,0.12);
    background: #fff;
    text-align: center;
}
.card h3 {
    color: #0d47a1;
    margin-bottom: 1rem;
}
.card p {
    margin-bottom: 0.5rem;
}
.btn-home {
    margin-top: 1.5rem;
}
</style>
</head>
<body>

<div class="card">
    <h3>Thank You!</h3>
    <p>Your payment has been successfully processed.</p>
    <p><strong>Order Number:</strong> <?php echo htmlspecialchars($order['order_number']); ?></p>
    <p><strong>Amount:</strong> ₱<?php echo number_format($order['final_amount'], 2); ?></p>
    <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($order['payment_method']); ?></p>
    <p><strong>Status:</strong> <?php echo htmlspecialchars($order['order_status']); ?></p>
    <a href="../pages/index.php" class="btn btn-primary btn-home w-100">Back to Home</a>
</div>

</body>
</html>
