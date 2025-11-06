<?php
require_once __DIR__ . '/../../../includes/fpdf/fpdf.php';
require_once __DIR__ . '/../../../config/config.php';

// Require admin session
session_start();
if (!isset($_SESSION['admin_id'])) {
    die('Unauthorized access');
}

$orderId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($orderId <= 0) {
    die('Invalid order ID');
}

try {
    // Fetch order details
    $orderSql = "SELECT o.*, u.first_name, u.middle_name, u.last_name, u.email, u.contact_number
                 FROM orders o
                 INNER JOIN users u ON o.user_id = u.user_id
                 WHERE o.order_id = :orderId";
    $orderStmt = $pdo->prepare($orderSql);
    $orderStmt->execute([':orderId' => $orderId]);
    $order = $orderStmt->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        die('Order not found');
    }

    // Fetch order items
    $itemsSql = "SELECT product_name, quantity, product_price, subtotal
                 FROM order_items
                 WHERE order_id = :orderId";
    $itemsStmt = $pdo->prepare($itemsSql);
    $itemsStmt->execute([':orderId' => $orderId]);
    $items = $itemsStmt->fetchAll(PDO::FETCH_ASSOC);

    // Create PDF
    $pdf = new FPDF();
    $pdf->AddPage();

    // Header with logo
    $logoPath = __DIR__ . '/../../../assets/images/M&E_LOGO_transparent.png';
    if (file_exists($logoPath)) {
        $pdf->Image($logoPath, 10, 8, 25);
    }

    // Company info
    $pdf->SetFont('Arial', 'B', 18);
    $pdf->Cell(0, 10, 'INVOICE', 0, 1, 'C');
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 8, 'M&E: Interior Supplies Trading', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 5, 'Purok 4 Banaba St Bo. Barretto Olongapo City', 0, 1, 'C');
    $pdf->Cell(0, 5, 'Phone: +63 916 635 1911 | Email: elbarcoma@gmail.com', 0, 1, 'C');
    $pdf->Ln(5);

    // Divider line
    $pdf->SetDrawColor(30, 64, 175);
    $pdf->SetLineWidth(0.5);
    $pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
    $pdf->Ln(8);

    // Order information
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetTextColor(30, 64, 175);
    $pdf->Cell(100, 7, 'Order Information', 0, 0);
    $pdf->Cell(90, 7, 'Customer Information', 0, 1);
    
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', '', 10);
    
    // Left column - Order info
    $y = $pdf->GetY();
    $pdf->Cell(100, 6, 'Order Number: ' . $order['order_number'], 0, 1);
    $pdf->Cell(100, 6, 'Order Date: ' . date('F j, Y', strtotime($order['order_date'])), 0, 1);
    $pdf->Cell(100, 6, 'Payment Method: ' . $order['payment_method'], 0, 1);
    $pdf->Cell(100, 6, 'Order Status: ' . $order['order_status'], 0, 1);

    // Right column - Customer info
    $pdf->SetXY(110, $y);
    $middleInitial = !empty($order['middle_name']) ? ' ' . substr($order['middle_name'], 0, 1) . '.' : '';
    $customerName = $order['first_name'] . $middleInitial . ' ' . $order['last_name'];
    $pdf->Cell(90, 6, 'Name: ' . $customerName, 0, 1);
    $pdf->SetX(110);
    $pdf->Cell(90, 6, 'Email: ' . $order['email'], 0, 1);
    $pdf->SetX(110);
    $pdf->Cell(90, 6, 'Contact: ' . $order['contact_number'], 0, 1);
    
    $pdf->Ln(8);

    // Delivery address
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 6, 'Delivery Address:', 0, 1);
    $pdf->SetFont('Arial', '', 10);
    $pdf->MultiCell(0, 6, $order['delivery_address']);
    $pdf->Ln(5);

    // Items table header
    $pdf->SetFillColor(30, 64, 175);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(85, 8, 'Product', 1, 0, 'L', true);
    $pdf->Cell(25, 8, 'Quantity', 1, 0, 'C', true);
    $pdf->Cell(35, 8, 'Unit Price', 1, 0, 'R', true);
    $pdf->Cell(35, 8, 'Subtotal', 1, 1, 'R', true);

    // Items table rows
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', '', 10);
    foreach ($items as $item) {
        $pdf->Cell(85, 7, $item['product_name'], 1, 0, 'L');
        $pdf->Cell(25, 7, $item['quantity'], 1, 0, 'C');
        $pdf->Cell(35, 7, 'PHP ' . number_format($item['product_price'], 2), 1, 0, 'R');
        $pdf->Cell(35, 7, 'PHP ' . number_format($item['subtotal'], 2), 1, 1, 'R');
    }

    $pdf->Ln(5);

    // Totals
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(145, 6, 'Subtotal:', 0, 0, 'R');
    $pdf->Cell(35, 6, 'PHP ' . number_format($order['total_amount'], 2), 0, 1, 'R');
    
    $pdf->Cell(145, 6, 'Shipping Fee:', 0, 0, 'R');
    $pdf->Cell(35, 6, 'PHP ' . number_format($order['shipping_fee'], 2), 0, 1, 'R');

    $pdf->Ln(2);
    $pdf->SetFillColor(30, 64, 175);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(145, 10, 'TOTAL AMOUNT:', 1, 0, 'R', true);
    $pdf->Cell(35, 10, 'PHP ' . number_format($order['final_amount'], 2), 1, 1, 'R', true);

    // Special instructions
    if (!empty($order['special_instructions'])) {
        $pdf->Ln(8);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 6, 'Special Instructions:', 0, 1);
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(0, 6, $order['special_instructions']);
    }

    // Footer
    $pdf->Ln(10);
    $pdf->SetDrawColor(200, 200, 200);
    $pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
    $pdf->Ln(5);

    $pdf->SetFont('Arial', 'I', 9);
    $pdf->SetTextColor(100, 100, 100);
    $pdf->Cell(0, 5, 'Thank you for your business!', 0, 1, 'C');
    $pdf->Cell(0, 5, 'For inquiries, please contact us at elbarcoma@gmail.com or +63 916 635 1911', 0, 1, 'C');
    $pdf->Ln(3);
    $pdf->SetFont('Arial', '', 8);
    $pdf->Cell(0, 4, 'Generated on: ' . date('F j, Y g:i A'), 0, 1, 'C');

    // Output PDF
    $pdf->Output('D', 'Invoice_' . $order['order_number'] . '.pdf');

} catch (Exception $e) {
    die('Error generating invoice: ' . $e->getMessage());
}
