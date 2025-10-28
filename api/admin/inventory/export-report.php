<?php
require_once __DIR__ . '/../../../config/config.php';

$type = trim($_GET['type'] ?? 'inventory'); // inventory, low-stock, movements
$format = trim($_GET['format'] ?? 'csv'); // csv, json

// Filters (same as list.php)
$q = trim($_GET['q'] ?? '');
$category = trim($_GET['category'] ?? '');
$stockStatus = trim($_GET['stockStatus'] ?? '');

$where = ['p.isActive = 1'];
$params = [];

if ($q !== '') {
    $where[] = '(p.product_name LIKE :q OR p.description LIKE :q OR p.product_code LIKE :q)';
    $params[':q'] = "%$q%";
}

if ($category !== '') {
    $where[] = 'c.category_slug = :catSlug';
    $params[':catSlug'] = $category;
}

if ($stockStatus !== '') {
    if ($stockStatus === 'out-of-stock') {
        $where[] = 'p.stock_quantity = 0';
    } else if ($stockStatus === 'low-stock') {
        $where[] = 'p.stock_quantity > 0 AND p.stock_quantity <= COALESCE(NULLIF(p.min_stock_level, 0), 15)';
    } else if ($stockStatus === 'in-stock') {
        $where[] = 'p.stock_quantity > COALESCE(NULLIF(p.min_stock_level, 0), 15)';
    }
}

$whereSql = count($where) ? ('WHERE ' . implode(' AND ', $where)) : '';

try {
    if ($type === 'inventory') {
        // Export inventory
        $sql = "SELECT p.product_name, p.product_code, c.category_name, p.stock_quantity,
                       p.min_stock_level, p.price, (p.stock_quantity * p.price) as total_value
                FROM products p
                INNER JOIN categories c ON c.category_id = p.category_id
                $whereSql
                ORDER BY p.product_name ASC";

        $stmt = $pdo->prepare($sql);
        foreach ($params as $k => $v) { $stmt->bindValue($k, $v); }
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($format === 'csv') {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="inventory_report_' . date('Y-m-d') . '.csv"');

            $output = fopen('php://output', 'w');
            fputcsv($output, ['Product Name', 'SKU', 'Category', 'Current Stock', 'Min Stock', 'Unit Price', 'Total Value']);

            foreach ($rows as $row) {
                fputcsv($output, [
                    $row['product_name'],
                    $row['product_code'],
                    $row['category_name'],
                    $row['stock_quantity'],
                    $row['min_stock_level'] ?? 15,
                    number_format($row['price'], 2),
                    number_format($row['total_value'], 2)
                ]);
            }

            fclose($output);
        } else {
            header('Content-Type: application/json');
            header('Content-Disposition: attachment; filename="inventory_report_' . date('Y-m-d') . '.json"');
            echo json_encode($rows, JSON_PRETTY_PRINT);
        }

    } else if ($type === 'low-stock') {
        // Export low stock items
        $sql = "SELECT p.product_name, p.product_code, c.category_name, p.stock_quantity,
                       p.min_stock_level,
                       CASE
                           WHEN p.stock_quantity = 0 THEN 'Critical'
                           WHEN p.stock_quantity <= COALESCE(NULLIF(p.min_stock_level, 0), 15) * 0.5 THEN 'Critical'
                           ELSE 'Warning'
                       END as alert_level
                FROM products p
                INNER JOIN categories c ON c.category_id = p.category_id
                WHERE p.isActive = 1 AND p.stock_quantity <= COALESCE(NULLIF(p.min_stock_level, 0), 15)
                ORDER BY p.stock_quantity ASC";

        $stmt = $pdo->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($format === 'csv') {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="low_stock_report_' . date('Y-m-d') . '.csv"');

            $output = fopen('php://output', 'w');
            fputcsv($output, ['Product Name', 'SKU', 'Category', 'Current Stock', 'Min Stock', 'Alert Level']);

            foreach ($rows as $row) {
                fputcsv($output, [
                    $row['product_name'],
                    $row['product_code'],
                    $row['category_name'],
                    $row['stock_quantity'],
                    $row['min_stock_level'] ?? 15,
                    $row['alert_level']
                ]);
            }

            fclose($output);
        } else {
            header('Content-Type: application/json');
            header('Content-Disposition: attachment; filename="low_stock_report_' . date('Y-m-d') . '.json"');
            echo json_encode($rows, JSON_PRETTY_PRINT);
        }

    } else if ($type === 'movements') {
        // Export stock movements
        $sql = "SELECT sm.created_at as timestamp, p.product_name, p.product_code,
                       sm.movement_type, sm.quantity, sm.previous_stock, sm.new_stock,
                       sm.reason, sm.user_name
                FROM stock_movements sm
                INNER JOIN products p ON p.product_id = sm.product_id
                ORDER BY sm.created_at DESC
                LIMIT 1000";

        $stmt = $pdo->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($format === 'csv') {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="stock_movements_report_' . date('Y-m-d') . '.csv"');

            $output = fopen('php://output', 'w');
            fputcsv($output, ['Timestamp', 'Product Name', 'SKU', 'Type', 'Quantity', 'Previous Stock', 'New Stock', 'Reason', 'User']);

            foreach ($rows as $row) {
                fputcsv($output, [
                    $row['timestamp'],
                    $row['product_name'],
                    $row['product_code'],
                    ucfirst($row['movement_type']),
                    $row['quantity'],
                    $row['previous_stock'],
                    $row['new_stock'],
                    $row['reason'],
                    $row['user_name']
                ]);
            }

            fclose($output);
        } else {
            header('Content-Type: application/json');
            header('Content-Disposition: attachment; filename="stock_movements_report_' . date('Y-m-d') . '.json"');
            echo json_encode($rows, JSON_PRETTY_PRINT);
        }
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
