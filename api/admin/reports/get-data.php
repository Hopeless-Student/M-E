<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../../config/config.php';

// Require admin session
session_start();
if (!isset($_SESSION['admin_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

$type = isset($_GET['type']) ? $_GET['type'] : 'sales';
$startDate = isset($_GET['start']) ? $_GET['start'] : date('Y-m-01');
$endDate = isset($_GET['end']) ? $_GET['end'] : date('Y-m-d');
$groupBy = isset($_GET['group']) ? $_GET['group'] : 'month';

try {
    $report = [];

    switch ($type) {
        case 'sales':
            $report = generateSalesReport($pdo, $startDate, $endDate, $groupBy);
            break;
        case 'inventory':
            $report = generateInventoryReport($pdo);
            break;
        case 'customers':
            $report = generateCustomersReport($pdo, $startDate, $endDate);
            break;
        case 'orders':
            $report = generateOrdersReport($pdo, $startDate, $endDate);
            break;
        case 'financial':
            $report = generateFinancialReport($pdo, $startDate, $endDate);
            break;
        default:
            throw new Exception('Invalid report type');
    }

    echo json_encode([
        'success' => true,
        'report' => $report
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}

function generateSalesReport($pdo, $startDate, $endDate, $groupBy) {
    // Summary
    $summarySql = "SELECT 
                    COUNT(DISTINCT order_id) as total_orders,
                    SUM(final_amount) as total_revenue,
                    AVG(final_amount) as average_order_value,
                    COUNT(DISTINCT user_id) as unique_customers
                   FROM orders
                   WHERE order_date BETWEEN :start AND :end
                   AND order_status != 'Cancelled'";
    $summaryStmt = $pdo->prepare($summarySql);
    $summaryStmt->execute([':start' => $startDate, ':end' => $endDate]);
    $summary = $summaryStmt->fetch(PDO::FETCH_ASSOC);

    // Top Products
    $topProductsSql = "SELECT p.product_name, SUM(oi.quantity) as total_sold, SUM(oi.subtotal) as revenue
                       FROM order_items oi
                       INNER JOIN orders o ON o.order_id = oi.order_id
                       INNER JOIN products p ON p.product_id = oi.product_id
                       WHERE o.order_date BETWEEN :start AND :end
                       AND o.order_status != 'Cancelled'
                       GROUP BY p.product_id, p.product_name
                       ORDER BY total_sold DESC
                       LIMIT 10";
    $topProductsStmt = $pdo->prepare($topProductsSql);
    $topProductsStmt->execute([':start' => $startDate, ':end' => $endDate]);
    $topProducts = $topProductsStmt->fetchAll(PDO::FETCH_ASSOC);

    // Trend data
    $trendSql = "SELECT DATE(order_date) as date, SUM(final_amount) as revenue
                 FROM orders
                 WHERE order_date BETWEEN :start AND :end
                 AND order_status != 'Cancelled'
                 GROUP BY DATE(order_date)
                 ORDER BY date";
    $trendStmt = $pdo->prepare($trendSql);
    $trendStmt->execute([':start' => $startDate, ':end' => $endDate]);
    $trendData = $trendStmt->fetchAll(PDO::FETCH_ASSOC);

    return [
        'summary' => [
            'total_orders' => (int)$summary['total_orders'],
            'total_revenue' => (float)$summary['total_revenue'],
            'average_order_value' => (float)$summary['average_order_value'],
            'unique_customers' => (int)$summary['unique_customers']
        ],
        'chartData' => [
            'labels' => array_column($trendData, 'date'),
            'values' => array_column($trendData, 'revenue'),
            'label' => 'Daily Revenue'
        ],
        'columns' => ['Product Name', 'Units Sold', 'Revenue'],
        'tableData' => array_map(function($row) {
            return [
                $row['product_name'],
                number_format($row['total_sold']),
                '₱' . number_format($row['revenue'], 2)
            ];
        }, $topProducts)
    ];
}

function generateInventoryReport($pdo) {
    // Summary
    $summarySql = "SELECT 
                    COUNT(*) as total_products,
                    SUM(stock_quantity) as total_stock,
                    SUM(stock_quantity * price) as total_value,
                    SUM(CASE WHEN stock_quantity = 0 THEN 1 ELSE 0 END) as out_of_stock,
                    SUM(CASE WHEN stock_quantity <= COALESCE(NULLIF(min_stock_level, 0), 15) THEN 1 ELSE 0 END) as low_stock
                   FROM products
                   WHERE isActive = 1";
    $summaryStmt = $pdo->query($summarySql);
    $summary = $summaryStmt->fetch(PDO::FETCH_ASSOC);

    // Products by category
    $categorySql = "SELECT c.category_name, COUNT(*) as product_count, 
                           SUM(p.stock_quantity) as total_stock,
                           SUM(p.stock_quantity * p.price) as category_value
                    FROM products p
                    INNER JOIN categories c ON c.category_id = p.category_id
                    WHERE p.isActive = 1
                    GROUP BY c.category_id, c.category_name
                    ORDER BY category_value DESC";
    $categoryStmt = $pdo->query($categorySql);
    $categories = $categoryStmt->fetchAll(PDO::FETCH_ASSOC);

    return [
        'summary' => [
            'total_products' => (int)$summary['total_products'],
            'total_stock_units' => (int)$summary['total_stock'],
            'total_inventory_value' => (float)$summary['total_value'],
            'out_of_stock_items' => (int)$summary['out_of_stock'],
            'low_stock_items' => (int)$summary['low_stock']
        ],
        'chartData' => [
            'labels' => array_column($categories, 'category_name'),
            'values' => array_column($categories, 'category_value'),
            'label' => 'Inventory Value by Category'
        ],
        'columns' => ['Category', 'Products', 'Stock Units', 'Total Value'],
        'tableData' => array_map(function($row) {
            return [
                $row['category_name'],
                number_format($row['product_count']),
                number_format($row['total_stock']),
                '₱' . number_format($row['category_value'], 2)
            ];
        }, $categories)
    ];
}

function generateCustomersReport($pdo, $startDate, $endDate) {
    // Summary
    $summarySql = "SELECT 
                    COUNT(*) as total_customers,
                    SUM(CASE WHEN created_at BETWEEN :start AND :end THEN 1 ELSE 0 END) as new_customers,
                    COUNT(DISTINCT o.user_id) as active_customers
                   FROM users u
                   LEFT JOIN orders o ON o.user_id = u.user_id AND o.order_date BETWEEN :start AND :end
                   WHERE u.isActive = 1";
    $summaryStmt = $pdo->prepare($summarySql);
    $summaryStmt->execute([':start' => $startDate, ':end' => $endDate]);
    $summary = $summaryStmt->fetch(PDO::FETCH_ASSOC);

    // Top customers
    $topCustomersSql = "SELECT 
                         CONCAT(u.first_name, ' ', u.last_name) as customer_name,
                         COUNT(o.order_id) as total_orders,
                         SUM(o.final_amount) as total_spent
                        FROM users u
                        INNER JOIN orders o ON o.user_id = u.user_id
                        WHERE o.order_date BETWEEN :start AND :end
                        AND o.order_status != 'Cancelled'
                        GROUP BY u.user_id, customer_name
                        ORDER BY total_spent DESC
                        LIMIT 10";
    $topCustomersStmt = $pdo->prepare($topCustomersSql);
    $topCustomersStmt->execute([':start' => $startDate, ':end' => $endDate]);
    $topCustomers = $topCustomersStmt->fetchAll(PDO::FETCH_ASSOC);

    return [
        'summary' => [
            'total_customers' => (int)$summary['total_customers'],
            'new_customers' => (int)$summary['new_customers'],
            'active_customers' => (int)$summary['active_customers']
        ],
        'columns' => ['Customer Name', 'Total Orders', 'Total Spent'],
        'tableData' => array_map(function($row) {
            return [
                $row['customer_name'],
                number_format($row['total_orders']),
                '₱' . number_format($row['total_spent'], 2)
            ];
        }, $topCustomers)
    ];
}

function generateOrdersReport($pdo, $startDate, $endDate) {
    // Summary
    $summarySql = "SELECT 
                    COUNT(*) as total_orders,
                    SUM(CASE WHEN order_status = 'Delivered' THEN 1 ELSE 0 END) as delivered,
                    SUM(CASE WHEN order_status = 'Pending' THEN 1 ELSE 0 END) as pending,
                    SUM(CASE WHEN order_status = 'Cancelled' THEN 1 ELSE 0 END) as cancelled
                   FROM orders
                   WHERE order_date BETWEEN :start AND :end";
    $summaryStmt = $pdo->prepare($summarySql);
    $summaryStmt->execute([':start' => $startDate, ':end' => $endDate]);
    $summary = $summaryStmt->fetch(PDO::FETCH_ASSOC);

    // Orders by status
    $statusSql = "SELECT order_status, COUNT(*) as count
                  FROM orders
                  WHERE order_date BETWEEN :start AND :end
                  GROUP BY order_status";
    $statusStmt = $pdo->prepare($statusSql);
    $statusStmt->execute([':start' => $startDate, ':end' => $endDate]);
    $statusData = $statusStmt->fetchAll(PDO::FETCH_ASSOC);

    return [
        'summary' => [
            'total_orders' => (int)$summary['total_orders'],
            'delivered_orders' => (int)$summary['delivered'],
            'pending_orders' => (int)$summary['pending'],
            'cancelled_orders' => (int)$summary['cancelled']
        ],
        'chartData' => [
            'labels' => array_column($statusData, 'order_status'),
            'values' => array_column($statusData, 'count'),
            'label' => 'Orders by Status'
        ],
        'columns' => ['Status', 'Count'],
        'tableData' => array_map(function($row) {
            return [
                $row['order_status'],
                number_format($row['count'])
            ];
        }, $statusData)
    ];
}

function generateFinancialReport($pdo, $startDate, $endDate) {
    // Summary
    $summarySql = "SELECT 
                    SUM(final_amount) as total_revenue,
                    SUM(shipping_fee) as shipping_revenue,
                    SUM(total_amount) as product_revenue
                   FROM orders
                   WHERE order_date BETWEEN :start AND :end
                   AND order_status != 'Cancelled'";
    $summaryStmt = $pdo->prepare($summarySql);
    $summaryStmt->execute([':start' => $startDate, ':end' => $endDate]);
    $summary = $summaryStmt->fetch(PDO::FETCH_ASSOC);

    return [
        'summary' => [
            'total_revenue' => (float)$summary['total_revenue'],
            'product_revenue' => (float)$summary['product_revenue'],
            'shipping_revenue' => (float)$summary['shipping_revenue']
        ],
        'columns' => ['Metric', 'Amount'],
        'tableData' => [
            ['Total Revenue', '₱' . number_format($summary['total_revenue'], 2)],
            ['Product Sales', '₱' . number_format($summary['product_revenue'], 2)],
            ['Shipping Fees', '₱' . number_format($summary['shipping_revenue'], 2)]
        ]
    ];
}
