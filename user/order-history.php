<?php
require_once __DIR__ . '/../includes/database.php';
include('../includes/user-sidebar.php');

$user_id = $_SESSION['user_id'];
$status = isset($_GET['status']) ? trim($_GET['status']) : 'All';


$pdo = connect();
  try {

    $user_id = $user['user_id'];

     $status = isset($_GET['status']) ? trim($_GET['status']) : 'All';

    $sql = "
    SELECT o.order_id,
    o.order_number, o.final_amount,
    o.order_status, o.payment_method,
    o.order_date,
    oi.product_name, oi.product_price, p.product_image,
    oi.quantity, oi.subtotal
    FROM orders o
    JOIN order_items oi
    ON o.order_id = oi.order_id
    JOIN products p
    ON oi.product_id = p.product_id
    WHERE o.user_id = :user_id
    ";
    // ORDER BY o.order_date DESC, o.order_id DESC;

        $filter = [':user_id' => $user_id];
    if ($status !== 'All') {
        $sql .= " AND o.order_status = :status";
        $filter[':status'] = $status;
    }
    $sql .= " ORDER BY o.order_date DESC, o.order_id DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($filter);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $order_history = [];
      foreach ($result as $items) {
        $orderId = $items['order_id'];

        if (!isset($order_history[$orderId])) {
        $order_history[$orderId] = [
            'order_number' => $items['order_number'],
            'final_amount' => $items['final_amount'],
            'order_status' => $items['order_status'],
            'payment_method' => $items['payment_method'],
            'order_date' => $items['order_date'],
            'items' => []
        ];
    }

    $order_history[$orderId]['items'][] = [
        'product_name' => $items['product_name'],
        'product_image' => $items['product_image'],
        'price' => $items['product_price'],
        'qty' => $items['quantity'],
        'subtotal' => $items['subtotal']
    ];
      }
  } catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage();
  }

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Order History</title>
  <link href="../bootstrap-5.3.8-dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/user-sidebar.css">
  <link rel="stylesheet" href="../assets/css/order-history.css">
</head>
<body>
  <div class="container py-4">
    <div class="order-content">
      <h2 class="order-title">Order History</h2>
      <hr>
      <div class="status">
        <a href="?status=All" class="<?= $status === 'All' ? 'active' : '' ?>">All</a> |
        <a href="?status=Pending" class="<?= $status === 'Pending' ? 'active' : '' ?>">Pending</a> |
        <a href="?status=Delivered" class="<?= $status === 'Delivered' ? 'active' : '' ?>">Delivered</a> |
        <a href="?status=Shipped" class="<?= $status === 'Shipped' ? 'active' : '' ?>">Shipped</a> |
        <a href="?status=Confirmed" class="<?= $status === 'Confirmed' ? 'active' : '' ?>">Confirmed</a>
      </div>

      <div id="order-list">
        <div id="order-container">
          <?php if (!empty($order_history)): ?>

            <?php foreach ($order_history as $orders): ?>
              <div class="items-container">
                <div class="order-header">
                  <p><?= date("m/d/Y", strtotime($orders['order_date'])) ?> | Order No: <?= htmlspecialchars($orders['order_number']) ?></p>
                  <p>Total: ₱ <strong><?= number_format($orders['final_amount'], 2) ?></strong></p>
                </div>
                <span class="order-status
                <?= $orders['order_status'] === 'Pending' ? 'status-pending' : (
                  $orders['order_status'] === 'Delivered' ? 'status-delivered' : (
                    $orders['order_status'] === 'Confirmed' ? 'status-confirmed' : (
                      $orders['order_status'] === 'Shipped' ? 'status-shipped' :
                      'status-cancelled'))) ?>">
                      <?= $orders['order_status'] ?>
                    </span>

                    <hr>
                    <?php foreach ($orders['items'] as $item): ?>

                      <div class="item">
                        <?php
                        $imagePath = '../assets/images/products/' .$item['product_image'];
                         if (empty($item['product_image']) || !file_exists($imagePath)) {
                             $imagePath = '../assets/images/products/default.png';
                         }
                         ?>
                        <img src="<?= $imagePath ?>" alt="item sample">
                        <div class="item-text">
                          <p class="mb-2"><?= htmlspecialchars($item['product_name']) ?></p>
                          <sub>₱ <?= number_format($item['price'], 2) ?> × <?= htmlspecialchars($item['qty']) ?></sub>
                        </div>
                        <!-- <button class="btn-details">Order Details</button> -->
                      </div>
                    <?php endforeach; ?>
                    <div class="text-end mt-3">
                      <a href="order-details.php?order_id=<?= urlencode($orders['order_number']) ?>" class="btn btn-details">Order Details</a>
                    </div>
                  </div>
                <?php endforeach; ?>
        </div>
            <?php elseif ($status === 'All'): ?>
              <div class="text-center">
                <img src="../assets/images/order-history.png" class="img-fluid" style="max-height:250px;" alt="order history">
                <p class="fs-3 fw-bold" style="color: #002366;">You Have No Order History</p>
                <small>You haven't order anything yet. <br>Your Order History will appear here once you have!</small>
              </div>

            <?php else: ?>
              <div class="text-center">
                <img src="../assets/images/order-history.png" class="img-fluid" style="max-height:250px;" alt="order history">
                <p class="fs-3 fw-bold" style="color: #002366;">No Orders Found for this Status</p>
              </div>
            <?php endif; ?>
      </div>
    <!-- Modal Structure -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content rounded-4 shadow">
      <div class="modal-header" style="background-color:#002366; color:white;">
        <h5 class="modal-title" id="orderDetailsLabel">Order Details</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="orderDetailsContent">
          <p class="text-center text-muted">Loading details...</p>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

  <script src="../assets/js/order-history.js"></script>
  <script src="../bootstrap-5.3.8-dist/js/bootstrap.min.js"></script>
</body>
</html>
