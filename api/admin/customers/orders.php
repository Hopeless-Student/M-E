<?php


header('Content-Type: application/json');
require_once __DIR__ . '/../../../config/config.php';
// require_once __DIR__ . '/../auth_check.php';
// $admin = requireAdminAuth();

// Validate parameters - SIMPLIFIED VERSION
$userId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$pageSize = isset($_GET['pageSize']) ? min(50, max(1, (int)$_GET['pageSize'])) : 10;
$status = isset($_GET['status']) ? trim($_GET['status']) : '';
$startDate = isset($_GET['startDate']) ? trim($_GET['startDate']) : '';
$endDate = isset($_GET['endDate']) ? trim($_GET['endDate']) : '';

// Validate user ID
if ($userId <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid user ID']);
    exit;
}

// Validate status if provided
if ($status !== '' && !in_array($status, ['completed', 'pending', 'processing', 'cancelled'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid status']);
    exit;
}

try {
    // Get user basic info
    $userSql = "SELECT user_id, first_name, middle_name, last_name, email, created_at
                FROM users
                WHERE user_id = :userId";
    $userStmt = $pdo->prepare($userSql);
    $userStmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $userStmt->execute();
    $user = $userStmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        http_response_code(404);
        echo json_encode(['error' => 'User not found']);
        exit;
    }

    // Build WHERE clause
    $where = ['o.user_id = :userId'];
    $params = [':userId' => $userId];

    if ($status !== '') {
        $where[] = 'o.order_status = :status';
        $params[':status'] = $status;
    }

    if ($startDate !== '') {
        $where[] = 'DATE(o.order_date) >= :startDate';
        $params[':startDate'] = $startDate;
    }

    if ($endDate !== '') {
        $where[] = 'DATE(o.order_date) <= :endDate';
        $params[':endDate'] = $endDate;
    }

    $whereSql = implode(' AND ', $where);
    $offset = ($page - 1) * $pageSize;

    // Count total orders
    $countSql = "SELECT COUNT(*) FROM orders o WHERE $whereSql";
    $countStmt = $pdo->prepare($countSql);
    foreach ($params as $k => $v) {
        $countStmt->bindValue($k, $v);
    }
    $countStmt->execute();
    $totalOrders = (int)$countStmt->fetchColumn();

    // Get order statistics by status
    $statsSql = "SELECT
                    o.order_status,
                    COUNT(*) as count,
                    COALESCE(SUM(o.final_amount), 0) as total_amount
                 FROM orders o
                 WHERE o.user_id = :userId
                 GROUP BY o.order_status";
    $statsStmt = $pdo->prepare($statsSql);
    $statsStmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $statsStmt->execute();
    $stats = $statsStmt->fetchAll(PDO::FETCH_ASSOC);

    // Initialize statistics for all possible statuses
    $orderStats = [
        'completed' => ['count' => 0, 'amount' => 0],
        'pending' => ['count' => 0, 'amount' => 0],
        'processing' => ['count' => 0, 'amount' => 0],
        'cancelled' => ['count' => 0, 'amount' => 0]
    ];

    foreach ($stats as $stat) {
        $statusKey = strtolower($stat['order_status']);
        if (isset($orderStats[$statusKey])) {
            $orderStats[$statusKey] = [
                'count' => (int)$stat['count'],
                'amount' => (float)$stat['total_amount']
            ];
        }
    }

    // Fetch orders with items
    $ordersSql = "SELECT
                    o.order_id,
                    o.order_number,
                    o.order_date,
                    o.total_amount,
                    o.shipping_fee,
                    o.final_amount,
                    o.order_status,
                    o.payment_method,
                    o.delivery_address,
                    COUNT(DISTINCT oi.order_item_id) as item_count,
                    GROUP_CONCAT(DISTINCT p.product_name ORDER BY p.product_name SEPARATOR ', ') as item_names
                  FROM orders o
                  LEFT JOIN order_items oi ON oi.order_id = o.order_id
                  LEFT JOIN products p ON p.product_id = oi.product_id
                  WHERE $whereSql
                  GROUP BY o.order_id, o.order_number, o.order_date, o.total_amount,
                           o.shipping_fee, o.final_amount, o.order_status, o.payment_method,
                           o.delivery_address
                  ORDER BY o.order_date DESC
                  LIMIT :limit OFFSET :offset";

    $ordersStmt = $pdo->prepare($ordersSql);
    foreach ($params as $k => $v) {
        $ordersStmt->bindValue($k, $v);
    }
    $ordersStmt->bindValue(':limit', $pageSize, PDO::PARAM_INT);
    $ordersStmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $ordersStmt->execute();
    $orders = $ordersStmt->fetchAll(PDO::FETCH_ASSOC);

    // Format orders
    $formattedOrders = array_map(function($order) {
        // Truncate item names if too long
        $itemNames = $order['item_names'] ?? 'No items';
        if (strlen($itemNames) > 50) {
            $itemNames = substr($itemNames, 0, 47) . '...';
        }

        return [
            'orderId' => (int)$order['order_id'],
            'orderNumber' => $order['order_number'],
            'orderDate' => $order['order_date'],
            'orderDateFormatted' => date('M d, Y', strtotime($order['order_date'])),
            'totalAmount' => (float)$order['total_amount'],
            'shippingFee' => (float)$order['shipping_fee'],
            'finalAmount' => (float)$order['final_amount'],
            'orderStatus' => $order['order_status'],
            'paymentMethod' => $order['payment_method'],
            'deliveryAddress' => $order['delivery_address'],
            'itemCount' => (int)$order['item_count'],
            'itemNames' => $itemNames
        ];
    }, $orders);

    // Format user info
    $fullName = trim(implode(' ', array_filter([
        $user['first_name'],
        $user['middle_name'] ?? '',
        $user['last_name']
    ])));

    $createdDate = new DateTime($user['created_at']);
    $memberSince = $createdDate->format('F Y');

    $response = [
        'user' => [
            'id' => (int)$user['user_id'],
            'name' => $fullName,
            'email' => $user['email'],
            'memberSince' => $memberSince
        ],
        'statistics' => $orderStats,
        'orders' => $formattedOrders,
        'pagination' => [
            'page' => $page,
            'pageSize' => $pageSize,
            'total' => $totalOrders,
            'totalPages' => max(1, (int)ceil($totalOrders / $pageSize))
        ]
    ];

    echo json_encode($response);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Database error',
        'message' => 'Failed to fetch customer orders',
        'sqlError' => $e->getMessage()
    ]);
    error_log("Customer orders error: " . $e->getMessage());
}
?>
