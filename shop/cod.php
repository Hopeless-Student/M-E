  <?php
  require_once __DIR__ . '/../includes/database.php';
  require_once __DIR__ . '/../auth/auth.php';

  $pdo = connect();
  $user_id = $_SESSION['user_id'] ?? null;

  $orderId = $_GET['order_id'] ?? null;
  $token = $_GET['token'] ?? null;
  if (!$orderId || !$token) {
      header("Location: ../pages/index.php");
      exit;
  }

  $stmt = $pdo->prepare("SELECT o.*, oi.product_id, oi.quantity, p.product_name, p.price, p.unit
                         FROM orders o
                         JOIN order_items oi ON o.order_id = oi.order_id
                         JOIN products p ON p.product_id = oi.product_id
                         WHERE o.order_id = ? AND o.user_id = ? AND o.payment_method= 'COD' AND o.cod_token=? ");
  $stmt->execute([$orderId, $user_id, $token]);
  $orderItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if (!$orderItems) {
      header("Location: ../pages/index.php");
      exit;
  }

  $total = 0;
  foreach ($orderItems as $item) {
      $total += $item['quantity'] * $item['price'];
  }
  $pdo->prepare("UPDATE orders SET cod_token=NULL WHERE order_id=?")->execute([$orderId]);
  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Confirmation</title>
  <link href="../bootstrap-5.3.8-dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/cod.css">
  </head>
  <body>
  <div class="background-shapes"></div>
  <div class="confirmation-card">
      <i class="bi bi-check-circle-fill icon-check"></i>
      <h2>Thank you! Your order has been placed.</h2>
      <p>Order ID: <strong><?= htmlspecialchars($orderId) ?></strong></p>

      <div class="progress">
          <div class="progress-bar bg-success" role="progressbar" style="width:25%;">Pending</div>
          <div class="progress-bar bg-secondary" role="progressbar" style="width:25%;">Confirmed</div>
          <div class="progress-bar bg-secondary" role="progressbar" style="width:25%;">Shipped</div>
          <div class="progress-bar bg-secondary" role="progressbar" style="width:25%;">Delivered</div>
      </div>

      <div class="table-responsive">
          <table class="table table-borderless text-start">
              <thead>
                  <tr>
                      <th>Product</th>
                      <th class="text-center">Qty</th>
                      <th class="text-center">Unit</th>
                      <th class="text-end">Price</th>
                  </tr>
              </thead>
              <tbody>
                  <?php foreach ($orderItems as $item): ?>
                  <tr>
                      <td><?= htmlspecialchars($item['product_name']) ?></td>
                      <td class="text-center"><?= $item['quantity'] ?></td>
                      <td class="text-center"><?= $item['unit'] ?></td>
                      <td class="text-end">₱<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                  </tr>
                  <?php endforeach; ?>
              </tbody>
          </table>
      </div>

      <p class="total">Total: ₱<?= number_format($total, 2) ?></p>
      <p class="payment-method"> <img src="../assets/svg/wallet.svg" alt=""> </i> Payment method: Cash on Delivery</p>
      <p class="estimated-delivery"> Expect delivery within 3–5 business days.</p>

      <a href="../user/order-history.php" class="btn btn-success btn-home w-100">
          <i class="bi bi-clock-history"></i>
          <!-- <img src="../assets/svg/clock-history.svg" alt=""> -->
           View Order History
      </a>
      <a href="../pages/index.php" class="btn btn-outline-primary btn-shop w-100">
          <i class="bi bi-house-door"></i> Back to Shop
      </a>
  </div>

  <script src="../bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
  <footer class="mt-5 py-3 text-center text-muted">
      &copy; <?= date('Y') ?> M&E: Interior Supplies Trading. All Rights Reserved.
  </footer>
  </body>
  </html>
