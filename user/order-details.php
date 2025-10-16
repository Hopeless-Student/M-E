<?php
require_once __DIR__ . '/../includes/database.php';
$pdo = connect();

if (!isset($_GET['order_id'])) {
    echo "<p class='text-danger'>Invalid order request.</p>";
    header("Location: ../pages/index.php");
    exit;
}

$order_number = $_GET['order_id'];

try {
    // Fetch main order info
    $stmt = $pdo->prepare("
        SELECT o.order_id, o.order_number, o.final_amount, o.order_status,
               o.payment_method, o.order_date, o.delivery_address
        FROM orders o
        WHERE o.order_number = :order_number
    ");
    $stmt->execute([':order_number' => $order_number]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        echo "<p class='text-muted text-center'>Order not found.</p>";
        exit;
    }

    // Fetch order items
    $stmtItems = $pdo->prepare("
        SELECT product_name, product_price, quantity, subtotal
        FROM order_items
        WHERE order_id = :order_id
    ");
    $stmtItems->execute([':order_id' => $order['order_id']]);
    $items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "<p class='text-danger'>Database error: " . htmlspecialchars($e->getMessage()) . "</p>";
    exit;
}
?>

<div class="p-3">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold text-primary">Order #<?= htmlspecialchars($order['order_number']) ?></h5>
    <span class="badge
      <?= $order['order_status'] === 'Pending' ? 'bg-warning text-dark' : (
          $order['order_status'] === 'Delivered' ? 'bg-success' : (
          $order['order_status'] === 'Shipped' ? 'bg-primary' : 'bg-secondary')) ?>">
      <?= htmlspecialchars($order['order_status']) ?>
    </span>
  </div>

  <p class="mb-1"><strong>Order Date:</strong> <?= date("F d, Y", strtotime($order['order_date'])) ?></p>
  <p class="mb-1"><strong>Payment Method:</strong> <?= htmlspecialchars($order['payment_method']) ?></p>
  <?php if (!empty($order['delivery_address'])): ?>
    <p class="mb-3"><strong>Delivery Address:</strong> <?= htmlspecialchars($order['delivery_address']) ?></p>
  <?php endif; ?>

  <hr>

  <h6 class="fw-bold text-secondary mb-3">Ordered Items</h6>

  <?php foreach ($items as $item): ?>
    <div class="d-flex justify-content-between align-items-center border-bottom py-2">
      <div>
        <p class="m-0 fw-semibold"><?= htmlspecialchars($item['product_name']) ?></p>
        <small class="text-muted">₱<?= number_format($item['product_price'], 2) ?> × <?= $item['quantity'] ?></small>
      </div>
      <p class="m-0 fw-bold">₱<?= number_format($item['subtotal'], 2) ?></p>
    </div>
  <?php endforeach; ?>

  <div class="text-end mt-4">
    <h5>Total Amount: <span class="text-success">₱<?= number_format($order['final_amount'], 2) ?></span></h5>
  </div>
</div>
