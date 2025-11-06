<?php
require_once __DIR__ . '/../../../includes/fpdf/fpdf.php';
require_once __DIR__ . '/../../../config/config.php';

// Require admin session
session_start();
if (!isset($_SESSION['admin_id'])) {
    die('Unauthorized access');
}

try {
    // Fetch inventory summary
    $summarySql = "SELECT 
                    COUNT(*) as total_products,
                    SUM(stock_quantity) as total_stock,
                    SUM(stock_quantity * price) as total_value,
                    SUM(CASE WHEN stock_quantity = 0 THEN 1 ELSE 0 END) as out_of_stock,
                    SUM(CASE WHEN stock_quantity > 0 AND stock_quantity <= COALESCE(NULLIF(min_stock_level, 0), 15) THEN 1 ELSE 0 END) as low_stock
                   FROM products
                   WHERE isActive = 1";
    $summaryStmt = $pdo->query($summarySql);
    $summary = $summaryStmt->fetch(PDO::FETCH_ASSOC);

    // Fetch products by category
    $productsSql = "SELECT p.product_name, p.product_code, c.category_name, 
                           p.stock_quantity, p.min_stock_level, p.price,
                           (p.stock_quantity * p.price) as total_value,
                           CASE 
                               WHEN p.stock_quantity = 0 THEN 'Out of Stock'
                               WHEN p.stock_quantity <= COALESCE(NULLIF(p.min_stock_level, 0), 15) THEN 'Low Stock'
                               ELSE 'In Stock'
                           END as status
                    FROM products p
                    INNER JOIN categories c ON c.category_id = p.category_id
                    WHERE p.isActive = 1
                    ORDER BY c.category_name, p.product_name";
    $productsStmt = $pdo->query($productsSql);
    $products = $productsStmt->fetchAll(PDO::FETCH_ASSOC);

    // Create PDF
    $pdf = new FPDF();
    $pdf->AddPage();

    // Header
    $logoPath = __DIR__ . '/../../../assets/images/M&E_LOGO_transparent.png';
    if (file_exists($logoPath)) {
        $pdf->Image($logoPath, 10, 8, 20);
    }

    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'INVENTORY REPORT', 0, 1, 'C');
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 6, 'M&E: Interior Supplies Trading', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(0, 5, 'Generated on: ' . date('F j, Y g:i A'), 0, 1, 'C');
    $pdf->Ln(5);

    // Divider
    $pdf->SetDrawColor(30, 64, 175);
    $pdf->SetLineWidth(0.5);
    $pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
    $pdf->Ln(8);

    // Summary Section
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetTextColor(30, 64, 175);
    $pdf->Cell(0, 7, 'Inventory Summary', 0, 1);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', '', 10);

    $pdf->SetFillColor(240, 248, 255);
    $pdf->Cell(95, 7, 'Total Products:', 1, 0, 'L', true);
    $pdf->Cell(95, 7, number_format($summary['total_products']), 1, 1, 'R', true);
    
    $pdf->Cell(95, 7, 'Total Stock Units:', 1, 0, 'L');
    $pdf->Cell(95, 7, number_format($summary['total_stock']), 1, 1, 'R');
    
    $pdf->Cell(95, 7, 'Total Inventory Value:', 1, 0, 'L', true);
    $pdf->Cell(95, 7, 'PHP ' . number_format($summary['total_value'], 2), 1, 1, 'R', true);
    
    $pdf->Cell(95, 7, 'Out of Stock Items:', 1, 0, 'L');
    $pdf->SetTextColor(220, 38, 38);
    $pdf->Cell(95, 7, number_format($summary['out_of_stock']), 1, 1, 'R');
    
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(95, 7, 'Low Stock Items:', 1, 0, 'L', true);
    $pdf->SetTextColor(245, 158, 11);
    $pdf->Cell(95, 7, number_format($summary['low_stock']), 1, 1, 'R', true);
    
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Ln(8);

    // Products Table
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetTextColor(30, 64, 175);
    $pdf->Cell(0, 7, 'Product Details', 0, 1);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Ln(2);

    // Table Header
    $pdf->SetFillColor(30, 64, 175);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(60, 7, 'Product Name', 1, 0, 'L', true);
    $pdf->Cell(25, 7, 'SKU', 1, 0, 'C', true);
    $pdf->Cell(30, 7, 'Category', 1, 0, 'L', true);
    $pdf->Cell(20, 7, 'Stock', 1, 0, 'C', true);
    $pdf->Cell(25, 7, 'Price', 1, 0, 'R', true);
    $pdf->Cell(20, 7, 'Status', 1, 1, 'C', true);

    // Table Rows
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', '', 8);
    $currentCategory = '';
    $rowCount = 0;

    foreach ($products as $product) {
        // Check if we need a new page
        if ($pdf->GetY() > 260) {
            $pdf->AddPage();
            
            // Repeat header
            $pdf->SetFillColor(30, 64, 175);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(60, 7, 'Product Name', 1, 0, 'L', true);
            $pdf->Cell(25, 7, 'SKU', 1, 0, 'C', true);
            $pdf->Cell(30, 7, 'Category', 1, 0, 'L', true);
            $pdf->Cell(20, 7, 'Stock', 1, 0, 'C', true);
            $pdf->Cell(25, 7, 'Price', 1, 0, 'R', true);
            $pdf->Cell(20, 7, 'Status', 1, 1, 'C', true);
            
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('Arial', '', 8);
        }

        // Alternate row colors
        $fill = ($rowCount % 2 == 0);
        if ($fill) {
            $pdf->SetFillColor(248, 250, 252);
        }

        // Product name (truncate if too long)
        $productName = strlen($product['product_name']) > 35 ? 
                      substr($product['product_name'], 0, 32) . '...' : 
                      $product['product_name'];
        
        $pdf->Cell(60, 6, $productName, 1, 0, 'L', $fill);
        $pdf->Cell(25, 6, $product['product_code'], 1, 0, 'C', $fill);
        
        // Category (truncate if too long)
        $categoryName = strlen($product['category_name']) > 18 ? 
                       substr($product['category_name'], 0, 15) . '...' : 
                       $product['category_name'];
        $pdf->Cell(30, 6, $categoryName, 1, 0, 'L', $fill);
        
        // Stock with color coding
        if ($product['stock_quantity'] == 0) {
            $pdf->SetTextColor(220, 38, 38); // Red
        } elseif ($product['stock_quantity'] <= ($product['min_stock_level'] ?? 15)) {
            $pdf->SetTextColor(245, 158, 11); // Orange
        } else {
            $pdf->SetTextColor(0, 0, 0); // Black
        }
        $pdf->Cell(20, 6, $product['stock_quantity'], 1, 0, 'C', $fill);
        
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(25, 6, number_format($product['price'], 2), 1, 0, 'R', $fill);
        
        // Status with color
        if ($product['status'] == 'Out of Stock') {
            $pdf->SetTextColor(220, 38, 38);
        } elseif ($product['status'] == 'Low Stock') {
            $pdf->SetTextColor(245, 158, 11);
        } else {
            $pdf->SetTextColor(34, 197, 94);
        }
        $pdf->Cell(20, 6, $product['status'], 1, 1, 'C', $fill);
        
        $pdf->SetTextColor(0, 0, 0);
        $rowCount++;
    }

    // Footer
    $pdf->Ln(5);
    $pdf->SetDrawColor(200, 200, 200);
    $pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
    $pdf->Ln(3);

    $pdf->SetFont('Arial', 'I', 8);
    $pdf->SetTextColor(100, 100, 100);
    $pdf->Cell(0, 4, 'M&E Interior Supplies Trading - Inventory Management System', 0, 1, 'C');
    $pdf->Cell(0, 4, 'Report generated by: ' . ($_SESSION['admin_username'] ?? 'Admin'), 0, 1, 'C');

    // Output PDF
    $pdf->Output('D', 'Inventory_Report_' . date('Y-m-d') . '.pdf');

} catch (Exception $e) {
    die('Error generating report: ' . $e->getMessage());
}
