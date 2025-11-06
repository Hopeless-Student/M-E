<?php
require_once __DIR__ . '/../../../config/config.php';

// Require admin session
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Content-Type: application/json');
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

// Get export type
$type = isset($_GET['type']) ? trim($_GET['type']) : '';

if (!$type) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Export type is required']);
    exit;
}

// Validate export type
$allowedTypes = ['orders', 'customers', 'products', 'inventory'];
if (!in_array($type, $allowedTypes)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid export type']);
    exit;
}

try {
    $filename = $type . '_export_' . date('Y-m-d_H-i-s') . '.csv';
    
    // Set headers for CSV download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Pragma: no-cache');
    header('Expires: 0');
    
    $output = fopen('php://output', 'w');
    
    switch ($type) {
        case 'orders':
            // Export orders
            fputcsv($output, ['Order ID', 'Order Number', 'Customer', 'Date', 'Total', 'Status', 'Payment Method']);
            
            $sql = "SELECT o.order_id, o.order_number, 
                           CONCAT(u.first_name, ' ', u.last_name) as customer_name,
                           o.order_date, o.final_amount, o.order_status, o.payment_method
                    FROM orders o
                    LEFT JOIN users u ON u.user_id = o.user_id
                    ORDER BY o.order_date DESC";
            
            $stmt = $pdo->query($sql);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                fputcsv($output, $row);
            }
            break;
            
        case 'customers':
            // Export customers
            fputcsv($output, ['Customer ID', 'Name', 'Email', 'Phone', 'Location', 'Total Orders', 'Total Spent', 'Status', 'Member Since']);
            
            $sql = "SELECT u.user_id,
                           CONCAT(u.first_name, ' ', u.last_name) as name,
                           u.email, u.contact_number,
                           CONCAT(c.city_name, ', ', p.province_name) as location,
                           COUNT(DISTINCT o.order_id) as total_orders,
                           COALESCE(SUM(o.final_amount), 0) as total_spent,
                           IF(u.isActive = 1, 'Active', 'Inactive') as status,
                           DATE_FORMAT(u.created_at, '%Y-%m-%d') as member_since
                    FROM users u
                    LEFT JOIN provinces p ON p.province_id = u.province_id
                    LEFT JOIN cities c ON c.city_id = u.city_id
                    LEFT JOIN orders o ON o.user_id = u.user_id
                    GROUP BY u.user_id
                    ORDER BY u.created_at DESC";
            
            $stmt = $pdo->query($sql);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                fputcsv($output, $row);
            }
            break;
            
        case 'products':
            // Export products
            fputcsv($output, ['Product ID', 'Name', 'Category', 'Price', 'Stock', 'Status', 'Created Date']);
            
            $sql = "SELECT p.product_id, p.product_name, c.category_name,
                           p.price, p.stock_quantity,
                           IF(p.is_active = 1, 'Active', 'Inactive') as status,
                           DATE_FORMAT(p.created_at, '%Y-%m-%d') as created_date
                    FROM products p
                    LEFT JOIN categories c ON c.category_id = p.category_id
                    ORDER BY p.created_at DESC";
            
            $stmt = $pdo->query($sql);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                fputcsv($output, $row);
            }
            break;
            
        case 'inventory':
            // Export inventory
            fputcsv($output, ['Product ID', 'Product Name', 'Category', 'Current Stock', 'Reserved', 'Available', 'Reorder Level', 'Status']);
            
            $sql = "SELECT p.product_id, p.product_name, c.category_name,
                           p.stock_quantity as current_stock,
                           COALESCE(SUM(oi.quantity), 0) as reserved,
                           (p.stock_quantity - COALESCE(SUM(oi.quantity), 0)) as available,
                           p.reorder_level,
                           CASE 
                               WHEN p.stock_quantity <= 0 THEN 'Out of Stock'
                               WHEN p.stock_quantity <= p.reorder_level THEN 'Low Stock'
                               ELSE 'In Stock'
                           END as status
                    FROM products p
                    LEFT JOIN categories c ON c.category_id = p.category_id
                    LEFT JOIN order_items oi ON oi.product_id = p.product_id
                    LEFT JOIN orders o ON o.order_id = oi.order_id AND o.order_status = 'pending'
                    WHERE p.is_active = 1
                    GROUP BY p.product_id
                    ORDER BY p.product_name";
            
            $stmt = $pdo->query($sql);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                fputcsv($output, $row);
            }
            break;
    }
    
    fclose($output);
    exit;
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Export error',
        'message' => 'Failed to export data',
        'details' => $e->getMessage()
    ]);
    error_log("Export error: " . $e->getMessage());
}
