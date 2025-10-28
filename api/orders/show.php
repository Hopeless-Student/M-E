<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../config/config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid order id']);
    exit;
}

// Order
$sql = "SELECT
            o.*,
            COALESCE(CONCAT(u.first_name, ' ', u.last_name), u.username, u.email, '') AS customer_name,
            (
              SELECT c.category_name
                FROM order_items oi
                INNER JOIN products p ON p.product_id = oi.product_id
                INNER JOIN categories c ON c.category_id = p.category_id
               WHERE oi.order_id = o.order_id
               GROUP BY c.category_id, c.category_name
               ORDER BY SUM(oi.quantity) DESC, c.category_name ASC
               LIMIT 1
            ) AS category
         FROM orders o
         LEFT JOIN users u ON u.user_id = o.user_id
         WHERE o.order_id = :id
         LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$order) {
    http_response_code(404);
    echo json_encode(['error' => 'Order not found']);
    exit;
}

// Items
$itemsSql = "SELECT oi.order_item_id, oi.product_id, oi.product_name, oi.product_price, oi.quantity, oi.subtotal
             FROM order_items oi
             WHERE oi.order_id = :id
             ORDER BY oi.order_item_id ASC";
$stmt = $pdo->prepare($itemsSql);
$stmt->execute([':id' => $id]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['order' => $order, 'items' => $items]);
?>
