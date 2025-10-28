<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../config/config.php';

$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$pageSize = isset($_GET['pageSize']) ? min(100, max(1, (int)$_GET['pageSize'])) : 20;
$status = isset($_GET['status']) ? trim($_GET['status']) : '';
$paymentStatus = isset($_GET['payment_status']) ? trim($_GET['payment_status']) : '';
$userId = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;
$q = isset($_GET['q']) ? trim($_GET['q']) : '';

$offset = ($page - 1) * $pageSize;

$where = [];
$params = [];

if ($status !== '') {
    $where[] = 'o.order_status = :status';
    $params[':status'] = $status;
}
if ($paymentStatus !== '') {
    // if column exists in db
    $stmt = $pdo->query("SHOW COLUMNS FROM orders LIKE 'payment_status'");
    if ($stmt && $stmt->fetch()) {
        $where[] = 'o.payment_status = :payment_status';
        $params[':payment_status'] = $paymentStatus;
    }
}
if ($userId > 0) {
    $where[] = 'o.user_id = :user_id';
    $params[':user_id'] = $userId;
}
if ($q !== '') {
    $where[] = '(o.order_number LIKE :q OR o.delivery_address LIKE :q OR o.contact_number LIKE :q)';
    $params[':q'] = "%$q%";
}

$whereSql = count($where) ? ('WHERE ' . implode(' AND ', $where)) : '';

$countSql = "SELECT COUNT(*) FROM orders o $whereSql";
$stmt = $pdo->prepare($countSql);
foreach ($params as $k => $v) { $stmt->bindValue($k, $v); }
$stmt->execute();
$total = (int)$stmt->fetchColumn();

$sql = "SELECT
               o.order_id,
               o.user_id,
               o.order_number,
               o.total_amount,
               o.shipping_fee,
               o.final_amount,
               o.payment_method,
               o.order_status,
               o.delivery_address,
               o.contact_number,
               o.special_instructions,
               o.order_date,
               o.confirmed_at,
               o.delivered_at,
               o.admin_notes,
               -- customer full name (fallbacks: username/email if names missing)
               COALESCE(CONCAT(u.first_name, ' ', u.last_name), u.username, u.email, '') AS customer_name,
               -- item count (sum of quantities)
               (SELECT COALESCE(SUM(oi.quantity), 0)
                  FROM order_items oi
                 WHERE oi.order_id = o.order_id) AS item_count,
               -- majority category (category with highest total quantity)
               (
                 SELECT c.category_name
                   FROM order_items oi2
                   INNER JOIN products p2 ON p2.product_id = oi2.product_id
                   INNER JOIN categories c ON c.category_id = p2.category_id
                  WHERE oi2.order_id = o.order_id
                  GROUP BY c.category_id, c.category_name
                  ORDER BY SUM(oi2.quantity) DESC, c.category_name ASC
                  LIMIT 1
               ) AS category
        FROM orders o
        LEFT JOIN users u ON u.user_id = o.user_id
        $whereSql
        ORDER BY o.order_date DESC
        LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($sql);
foreach ($params as $k => $v) { $stmt->bindValue($k, $v); }
$stmt->bindValue(':limit', $pageSize, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    'items' => $orders,
    'total' => $total,
    'page' => $page,
    'pageSize' => $pageSize,
    'totalPages' => max(1, (int)ceil($total / $pageSize)),
]);
?>
