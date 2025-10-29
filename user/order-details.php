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
  // para sa main order info
    $stmt = $pdo->prepare("
        SELECT o.order_id, o.order_number, o.final_amount, o.order_status,
               o.payment_method, o.order_date, o.delivery_address, o.shipping_fee
        FROM orders o
        WHERE o.order_number = :order_number
    ");
    $stmt->execute([':order_number' => $order_number]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        echo "<p class='text-muted text-center'>Order not found.</p>";
        exit;
    }

    // fetch ng item
    $stmtItems = $pdo->prepare("
        SELECT oi.product_name, oi.product_price, oi.quantity, oi.subtotal, p.product_image, p.unit, p.product_code
        FROM order_items oi
        JOIN products p ON oi.product_id = p.product_id
        WHERE oi.order_id = :order_id
    ");
    $stmtItems->execute([':order_id' => $order['order_id']]);
    $items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "<p class='text-danger'>Database error: " . htmlspecialchars($e->getMessage()) . "</p>";
    exit;
}
?>

<div class="p-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold text-primary"> <img src="../assets/svg/receipt.svg" alt="receipt" width="20" class="me-1"> Order #<?= htmlspecialchars($order['order_number']) ?></h5>


    <span class="badge px-3 py-2 fs-6 order-status
     <?= match ($order['order_status']) {
         'Pending' => 'status-pending',
         'Delivered' => 'status-delivered',
         'Shipped' => 'status-shipped',
         'Confirmed' => 'status-confirmed',
         default => 'status-default'
     } ?>">
     <?= htmlspecialchars($order['order_status']) ?>
   </span>
  </div>

  <div class="mb-3">
    <p class="mb-1">
      <img src="../assets/svg/calendar.svg" alt="calendar" width="18" class="me-1">
      <strong>Order Date:</strong> <?= date("F d, Y", strtotime($order['order_date'])) ?>
    </p>

    <p class="mb-1">
      <img src="../assets/svg/payment.svg" alt="payment" width="18" class="me-1">
      <strong>Payment Method:</strong> <?= htmlspecialchars($order['payment_method']) ?>
    </p>

    <?php if (!empty($order['delivery_address'])): ?>
      <p class="mb-0">
        <img src="../assets/svg/delivery-address.svg" alt="location" width="18" class="me-1">
        <strong>Delivery Address:</strong> <?= htmlspecialchars($order['delivery_address']) ?>
      </p>
    <?php endif; ?>
  </div>

  <hr>

  <h6 class="fw-bold text-secondary mb-3">
    <img src="../assets/icons/bag.svg" alt="cart" width="18" class="me-1">
    Ordered Items
  </h6>

  <div class="list-group">
    <?php if (!empty($items)): ?>
        <div class="table-responsive">
          <table class="table align-middle">
            <thead class="table-light">
              <tr>
                <th>Product</th>
                <th class="text-center">Price</th>
                <th class="text-center">Qty</th>
                <th class="text-center">Unit</th>
                <th class="text-end">Subtotal</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($items as $item): ?>
                <?php
                  $imagePath = '../assets/images/products/' . $item['product_image'];
                  if (empty($item['product_image']) || !file_exists($imagePath)) {
                      $imagePath = '../assets/images/products/default.png';
                  }
                ?>
                <tr>
                  <td class="d-flex align-items-center">
                    <img src="<?= $imagePath ?>" alt="<?= $imagePath ?>" class="me-3 rounded" style="width:50px; height:50px; object-fit:cover;">
                    <div>
                      <p class="fw-semibold mb-0"><?= htmlspecialchars($item['product_name']) ?></p>
                      <small class="text-muted">Product Code: <?= htmlspecialchars($item['product_code']) ?></small>
                    </div>
                  </td>
                  <td class="text-center">₱<?= number_format($item['product_price'], 2) ?></td>
                  <td class="text-center"><?= $item['quantity'] ?></td>
                  <td class="text-center"><?= $item['unit'] ?></td>
                  <td class="text-end fw-bold">₱<?= number_format($item['subtotal'], 2) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <p class="text-center text-muted">No items found for this order.</p>
      <?php endif; ?>
  </div>

   <?php
    $shipping = $order['shipping_fee'] ?? 75.00;
    $subtotal = $order['final_amount'] - $shipping;
  ?>

  <div class="text-end">
    <p class="mb-1">Subtotal ₱<?= number_format($subtotal, 2) ?></p>
    <p class="mb-1">Shipping Fee: ₱<?= number_format($shipping, 2) ?></p>
  <h5 class="fw-bold mt-2">Total Amount:</h5>
  <h4> <span class="text-success">₱<?= number_format($order['final_amount'], 2) ?></span> </h4>
  </div>

  <a href="../includes/receipt.php?order_id=<?= $order['order_id'] ?>"
     target="_blank"
     class="btn btn-sm btn-outline-success mt-3 d-flex align-items-center justify-content-center gap-2">
    <img src="../assets/svg/receipt.svg" alt="PDF" width="18">
    <span>Download Receipt</span>
  </a>

</div>
