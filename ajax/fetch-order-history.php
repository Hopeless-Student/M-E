<?php
require_once __DIR__ . '/../includes/database.php';
session_start();
header('Content-Type: application/json');
if (!isset($_SESSION['user_id'])) {
  echo json_encode(['success' => false, 'message' => 'Not logged in']);
  exit;
}

$user_id = $_SESSION['user_id'];
$status = isset($_GET['status']) ? trim($_GET['status']) : 'All';


  try {
    $pdo = connect();

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
        'product_image'=> $items['product_image'],
        'price' => $items['product_price'],
        'qty' => $items['quantity'],
        'subtotal' => $items['subtotal']
    ];
      }
      echo json_encode(['success' => true, 'orders' => array_values($order_history)]);
  } catch (PDOException $e) {
  header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
  }

 ?>
