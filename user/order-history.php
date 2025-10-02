<?php
require_once __DIR__ . '/../includes/database.php';
include('../includes/user-sidebar.php');

$pdo = connect();
  try {

    $user_id = $user['user_id'];

     $status = isset($_GET['status']) ? trim($_GET['status']) : 'All';

    $sql = "
    SELECT o.order_id,
    o.order_number, o.final_amount,
    o.order_status, o.payment_method,
    o.order_date,
    oi.product_name, oi.product_price,
    oi.quantity, oi.subtotal
    FROM orders o
    JOIN order_items oi
    ON o.order_id = oi.order_id
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
  <style>
    body {
      background-color: #f4f7fa;
      font-family: 'Segoe UI', sans-serif;
    }

    .order-content {
      margin-left: 240px;
      padding: 40px 20px;
    }

    .order-title {
      font-weight: 700;
      color: #002366;
      margin-bottom: 15px;
    }

    .status {
      margin-bottom: 25px;
    }

    .status a {
      text-decoration: none;
      color: #444;
      font-weight: 500;
      margin-right: 12px;
      transition: 0.2s;
    }

    .status a:hover {
      color: #002366;
    }

    .items-container {
      background-color: #ffffff;
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 25px;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
      transition: all 0.2s ease-in-out;
    }

    .items-container:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.08);
    }

    .order-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 15px;
    }

    .order-header p {
      margin: 0;
      font-size: 0.95rem;
      color: #555;
    }

    .order-status {
      font-size: 0.85rem;
      font-weight: 600;
      padding: 6px 12px;
      border-radius: 30px;
      color: white;
    }

    .status-pending { background-color: #ffc107; }
    .status-delivered { background-color: #28a745; }
    .status-shipped { background-color: #4169E1; }
    .status-confirmed { background-color: #8AFF8A; }
    .status a.active {
      color: #002366;
      font-weight: 700;
    }
    .item {
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .item img {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border-radius: 8px;
      margin-right: 20px;
    }

    .item-text {
      flex-grow: 1;
    }

    .item-text p {
      margin: 0;
      font-weight: 600;
      color: #222;
    }

    .item-text sub {
      color: #666;
    }

    .btn-details {
      background-color: #002366;
      border: none;
      color: white;
      padding: 8px 14px;
      border-radius: 8px;
      transition: background 0.2s;
    }

    .btn-details:hover {
      background-color: #001c4d;
      color: white;
    }
  </style>
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
          <img src="../assets/images/Hard-Copy.jpg" alt="item sample">
          <div class="item-text">
            <p><?= htmlspecialchars($item['product_name']) ?></p>
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
  <script src="../bootstrap-5.3.8-dist/js/bootstrap.min.js"></script>
</body>
</html>
