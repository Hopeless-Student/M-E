<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../../config/config.php';

function safeJson($data) {
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    // Time ranges
    $sixMonthsAgo = (new DateTime('first day of -5 months'))->setTime(0, 0, 0);
    $thirtyDaysAgo = (new DateTime('-30 days'))->setTime(0, 0, 0);

    // Stats
    // Total revenue = SUM(final_amount) last 30 days
    $stmt = $pdo->prepare("SELECT COALESCE(SUM(final_amount),0) AS total_revenue FROM orders WHERE order_date >= :d");
    $stmt->execute([':d' => $thirtyDaysAgo->format('Y-m-d H:i:s')]);
    $totalRevenue = (float)$stmt->fetchColumn();

    // Active customers = distinct users with orders last 30 days
    $stmt = $pdo->prepare("SELECT COUNT(DISTINCT user_id) FROM orders WHERE order_date >= :d");
    $stmt->execute([':d' => $thirtyDaysAgo->format('Y-m-d H:i:s')]);
    $activeCustomers = (int)$stmt->fetchColumn();

    // Average order value last 30 days
    $stmt = $pdo->prepare("SELECT COALESCE(AVG(final_amount),0) FROM orders WHERE order_date >= :d");
    $stmt->execute([':d' => $thirtyDaysAgo->format('Y-m-d H:i:s')]);
    $avgOrderValue = (float)$stmt->fetchColumn();

    // Month-over-month revenue change (compare last 30 days vs previous 30 days)
    $stmt = $pdo->prepare("SELECT COALESCE(SUM(final_amount),0) FROM orders WHERE order_date >= :start AND order_date < :end");
    $startPrev = (new DateTime('-60 days'))->setTime(0, 0, 0);
    $endPrev = $thirtyDaysAgo;
    $stmt->execute([':start' => $startPrev->format('Y-m-d H:i:s'), ':end' => $endPrev->format('Y-m-d H:i:s')]);
    $prevRevenue = (float)$stmt->fetchColumn();

    $revenueChange = $prevRevenue > 0 ? (($totalRevenue - $prevRevenue) / $prevRevenue) * 100.0 : 100.0;

    // Month-over-month active customers change
    $stmt = $pdo->prepare("SELECT COUNT(DISTINCT user_id) FROM orders WHERE order_date >= :start AND order_date < :end");
    $stmt->execute([':start' => $startPrev->format('Y-m-d H:i:s'), ':end' => $endPrev->format('Y-m-d H:i:s')]);
    $prevActiveCustomers = (int)$stmt->fetchColumn();
    $customersChange = $prevActiveCustomers > 0 ? (($activeCustomers - $prevActiveCustomers) / $prevActiveCustomers) * 100.0 : 100.0;

    // Sales last 6 months (labels, revenue sum, order count per month)
    $stmt = $pdo->prepare(
        "SELECT DATE_FORMAT(order_date, '%Y-%m') ym,
                DATE_FORMAT(order_date, '%M') mlabel,
                SUM(final_amount) revenue,
                COUNT(*) orders
         FROM orders
         WHERE order_date >= :d
         GROUP BY ym, mlabel
         ORDER BY ym ASC"
    );
    $stmt->execute([':d' => $sixMonthsAgo->format('Y-m-d H:i:s')]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Build 6-month sequence
    $labels = [];
    $revenueSeries = [];
    $ordersSeries = [];
    $monthIndex = [];
    foreach ($rows as $r) { $monthIndex[$r['ym']] = $r; }

    $cursor = clone $sixMonthsAgo;
    for ($i = 0; $i < 6; $i++) {
        $ym = $cursor->format('Y-m');
        $labels[] = $cursor->format('F');
        if (isset($monthIndex[$ym])) {
            $revenueSeries[] = (float)$monthIndex[$ym]['revenue'];
            $ordersSeries[] = (int)$monthIndex[$ym]['orders'];
        } else {
            $revenueSeries[] = 0;
            $ordersSeries[] = 0;
        }
        $cursor->modify('+1 month');
    }

    // Category distribution last 6 months based on ordered quantities per category
    $stmt = $pdo->prepare(
        "SELECT c.category_name, SUM(oi.quantity) qty
         FROM order_items oi
         INNER JOIN orders o ON o.order_id = oi.order_id
         INNER JOIN products p ON p.product_id = oi.product_id
         INNER JOIN categories c ON c.category_id = p.category_id
         WHERE o.order_date >= :d
         GROUP BY c.category_id, c.category_name
         ORDER BY qty DESC"
    );
    $stmt->execute([':d' => $sixMonthsAgo->format('Y-m-d H:i:s')]);
    $catRows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $catLabels = array_map(fn($r) => $r['category_name'], $catRows);
    $catData = array_map(fn($r) => (int)$r['qty'], $catRows);

    // Order status distribution last 30 days
    $stmt = $pdo->prepare(
        "SELECT order_status, COUNT(*) cnt
         FROM orders
         WHERE order_date >= :d
         GROUP BY order_status"
    );
    $stmt->execute([':d' => $thirtyDaysAgo->format('Y-m-d H:i:s')]);
    $statusRows = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

    $statusOrder = ['Pending','Confirmed','Shipped','Delivered','Cancelled'];
    $statusLabels = [];
    $statusData = [];
    $statusColors = ['#f59e0b', '#1d4ed8', '#5b21b6', '#059669', '#ef4444'];
    foreach ($statusOrder as $status) {
        $statusLabels[] = $status;
        $statusData[] = isset($statusRows[$status]) ? (int)$statusRows[$status] : 0;
    }

    // Recent orders (5) with user name, dominant/first category, item count, amount, date, status
    // Pick category of the first order item by MIN(order_item_id)
    $sql = "
        SELECT o.order_number,
               CONCAT(u.first_name, ' ', u.last_name) AS customer_name,
               (
                   SELECT c.category_name
                   FROM order_items oi2
                   INNER JOIN products p2 ON p2.product_id = oi2.product_id
                   INNER JOIN categories c ON c.category_id = p2.category_id
                   WHERE oi2.order_id = o.order_id
                   ORDER BY oi2.order_item_id ASC
                   LIMIT 1
               ) AS category_name,
               (
                   SELECT COALESCE(SUM(quantity),0) FROM order_items oi3 WHERE oi3.order_id = o.order_id
               ) AS item_count,
               o.final_amount,
               o.order_date,
               o.order_status
        FROM orders o
        INNER JOIN users u ON u.user_id = o.user_id
        ORDER BY o.order_date DESC
        LIMIT 5
    ";
    $stmt = $pdo->query($sql);
    $recent = [];
    while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $recent[] = [
            'order_number' => $r['order_number'],
            'customer_name' => trim($r['customer_name']) !== '' ? $r['customer_name'] : 'Customer',
            'category' => $r['category_name'] ?? 'Misc',
            'item_count' => (string) ((int)$r['item_count']),
            'amount' => number_format((float)$r['final_amount'], 2),
            'date' => (new DateTime($r['order_date']))->format('Y-m-d'),
            'status' => strtolower($r['order_status'])
        ];
    }

    safeJson([
        'success' => true,
        'data' => [
            'stats' => [
                'total_revenue' => number_format($totalRevenue, 2),
                'revenue_change' => number_format($revenueChange, 1),
                'active_customers' => (string)$activeCustomers,
                'customers_change' => number_format($customersChange, 1),
                'avg_order_value' => number_format($avgOrderValue, 2)
            ],
            'charts' => [
                'sales' => [
                    'labels' => $labels,
                    'revenue' => $revenueSeries,
                    'orders' => $ordersSeries
                ],
                'categories' => [
                    'labels' => $catLabels,
                    'data' => $catData
                ],
                'order_status' => [
                    'labels' => $statusLabels,
                    'data' => $statusData,
                    'colors' => $statusColors
                ]
            ],
            'recent_orders' => $recent
        ]
    ]);
} catch (Throwable $e) {
    http_response_code(500);
    safeJson([
        'success' => false,
        'error' => 'Server error',
        'message' => $e->getMessage()
    ]);
}
?>


