<?php
require_once __DIR__ . '/../../../includes/fpdf/fpdf.php';
require_once __DIR__ . '/../../../config/config.php';

// Require admin session
session_start();
if (!isset($_SESSION['admin_id'])) {
    die('Unauthorized access');
}

try {
    // Fetch low stock products
    $sql = "SELECT p.product_name, p.product_code, c.category_name, 
                   p.stock_quantity, p.min_stock_level, p.price,
                   CASE 
                       WHEN p.stock_quantity = 0 THEN 'Critical - Out of Stock'
                       WHEN p.stock_quantity <= COALESCE(NULLIF(p.min_stock_level, 0), 15) * 0.5 THEN 'Critical'
                       ELSE 'Warning'
                   END as alert_level,
                   (COALESCE(NULLIF(p.min_stock_level, 0), 15) - p.stock_quantity) as reorder_qty
            FROM products p
            INNER JOIN categories c ON c.category_id = p.category_id
            WHERE p.isActive = 1 
              AND p.stock_quantity <= COALESCE(NULLIF(p.min_stock_level, 0), 15)
            ORDER BY p.stock_quantity ASC, p.product_name";
    
    $stmt = $pdo->query($sql);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Count by alert level
    $critical = 0;
    $warning = 0;
    foreach ($products as $p) {
        if ($p['alert_level'] == 'Critical - Out of Stock' || $p['alert_level'] == 'Critical') {
            $critical++;
        } else {
            $warning++;
        }
    }

    // Create PDF
    $pdf = new FPDF();
    $pdf->AddPage();

    // Header
    $logoPath = __DIR__ . '/../../../assets/images/M&E_LOGO_transparent.png';
    if (file_exists($logoPath)) {
        $pdf->Image($logoPath, 10, 8, 20);
    }

    $pdf->SetFont('Arial', 'B', 16);
    $pdf->SetTextColor(220, 38, 38);
    $pdf->Cell(0, 10, 'LOW STOCK ALERT REPORT', 0, 1, 'C');
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 6, 'M&E: Interior Supplies Trading', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 9);
    $pdf->Cell(0, 5, 'Generated on: ' . date('F j, Y g:i A'), 0, 1, 'C');
    $pdf->Ln(5);

    // Divider
    $pdf->SetDrawColor(220, 38, 38);
    $pdf->SetLineWidth(0.5);
    $pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
    $pdf->Ln(8);

    // Alert Summary
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetTextColor(220, 38, 38);
    $pdf->Cell(0, 7, 'Alert Summary', 0, 1);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', '', 10);

    $pdf->SetFillColor(254, 226, 226);
    $pdf->Cell(95, 7, 'Total Low Stock Items:', 1, 0, 'L', true);
    $pdf->SetTextColor(220, 38, 38);
    $pdf->Cell(95, 7, count($products), 1, 1, 'R', true);
    
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(95, 7, 'Critical Alerts:', 1, 0, 'L');
    $pdf->SetTextColor(220, 38, 38);
    $pdf->Cell(95, 7, $critical, 1, 1, 'R');
    
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(95, 7, 'Warning Alerts:', 1, 0, 'L', true);
    $pdf->SetTextColor(245, 158, 11);
    $pdf->Cell(95, 7, $warning, 1, 1, 'R', true);
    
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Ln(8);

    // Products Table
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetTextColor(220, 38, 38);
    $pdf->Cell(0, 7, 'Products Requiring Attention', 0, 1);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Ln(2);

    // Table Header
    $pdf->SetFillColor(220, 38, 38);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->Cell(55, 7, 'Product Name', 1, 0, 'L', true);
    $pdf->Cell(25, 7, 'SKU', 1, 0, 'C', true);
    $pdf->Cell(30, 7, 'Category', 1, 0, 'L', true);
    $pdf->Cell(18, 7, 'Stock', 1, 0, 'C', true);
    $pdf->Cell(18, 7, 'Min', 1, 0, 'C', true);
    $pdf->Cell(20, 7, 'Reorder', 1, 0, 'C', true);
    $pdf->Cell(24, 7, 'Alert', 1, 1, 'C', true);

    // Table Rows
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', '', 8);
    $rowCount = 0;

    foreach ($products as $product) {
        // Check if we need a new page
        if ($pdf->GetY() > 260) {
            $pdf->AddPage();
            
            // Repeat header
            $pdf->SetFillColor(220, 38, 38);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(55, 7, 'Product Name', 1, 0, 'L', true);
            $pdf->Cell(25, 7, 'SKU', 1, 0, 'C', true);
            $pdf->Cell(30, 7, 'Category', 1, 0, 'L', true);
            $pdf->Cell(18, 7, 'Stock', 1, 0, 'C', true);
            $pdf->Cell(18, 7, 'Min', 1, 0, 'C', true);
            $pdf->Cell(20, 7, 'Reorder', 1, 0, 'C', true);
            $pdf->Cell(24, 7, 'Alert', 1, 1, 'C', true);
            
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetFont('Arial', '', 8);
        }

        // Alternate row colors
        $fill = ($rowCount % 2 == 0);
        if ($fill) {
            $pdf->SetFillColor(254, 242, 242);
        }

        // Product name (truncate if too long)
        $productName = strlen($product['product_name']) > 32 ? 
                      substr($product['product_name'], 0, 29) . '...' : 
                      $product['product_name'];
        
        $pdf->Cell(55, 6, $productName, 1, 0, 'L', $fill);
        $pdf->Cell(25, 6, $product['product_code'], 1, 0, 'C', $fill);
        
        // Category (truncate if too long)
        $categoryName = strlen($product['category_name']) > 18 ? 
                       substr($product['category_name'], 0, 15) . '...' : 
                       $product['category_name'];
        $pdf->Cell(30, 6, $categoryName, 1, 0, 'L', $fill);
        
        // Stock with color
        if ($product['stock_quantity'] == 0) {
            $pdf->SetTextColor(220, 38, 38);
            $pdf->SetFont('Arial', 'B', 8);
        } else {
            $pdf->SetTextColor(0, 0, 0);
        }
        $pdf->Cell(18, 6, $product['stock_quantity'], 1, 0, 'C', $fill);
        
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(18, 6, $product['min_stock_level'] ?? 15, 1, 0, 'C', $fill);
        
        // Reorder quantity
        $reorderQty = max(0, $product['reorder_qty']);
        $pdf->SetTextColor(30, 64, 175);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(20, 6, $reorderQty, 1, 0, 'C', $fill);
        
        // Alert level with color
        $pdf->SetFont('Arial', '', 7);
        if (strpos($product['alert_level'], 'Critical') !== false) {
            $pdf->SetTextColor(220, 38, 38);
        } else {
            $pdf->SetTextColor(245, 158, 11);
        }
        $alertText = str_replace('Critical - ', '', $product['alert_level']);
        $pdf->Cell(24, 6, $alertText, 1, 1, 'C', $fill);
        
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 8);
        $rowCount++;
    }

    // Recommendations
    $pdf->Ln(8);
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->SetTextColor(30, 64, 175);
    $pdf->Cell(0, 6, 'Recommended Actions:', 0, 1);
    $pdf->SetFont('Arial', '', 9);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->MultiCell(0, 5, "• Immediately reorder products marked as 'Critical'\n• Review minimum stock levels for frequently low-stock items\n• Contact suppliers for products with extended lead times\n• Consider increasing safety stock for high-demand products");

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
    $pdf->Output('D', 'Low_Stock_Alert_' . date('Y-m-d') . '.pdf');

} catch (Exception $e) {
    die('Error generating report: ' . $e->getMessage());
}
