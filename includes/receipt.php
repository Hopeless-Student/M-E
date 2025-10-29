<?php
require('fpdf/fpdf.php');
require_once('database.php');

$pdo = connect();
$order_id = $_GET['order_id'] ?? null;

if (!$order_id) {
    die('Order ID is required.');
}

$stmt = $pdo->prepare("
    SELECT o.order_id, o.order_number, o.final_amount, o.order_date,
           o.payment_method, o.delivery_address, o.shipping_fee,
           u.first_name, u.last_name, u.email, u.contact_number
    FROM orders o
    JOIN users u ON o.user_id = u.user_id
    WHERE o.order_id = ?
");
$stmt->execute([$order_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    die('Order not found.');
}

$stmt = $pdo->prepare("
    SELECT oi.product_name, oi.quantity, oi.product_price, oi.subtotal
    FROM order_items oi
    WHERE oi.order_id = ?
");
$stmt->execute([$order_id]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pdf = new FPDF();
$pdf->AddPage();

// pan logo
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 8, 'ORDER RECEIPT', 0, 1, 'C');

$pdf->Image('../assets/images/M&E_LOGO_transparent.png', 10, 8, 25);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'M&E: Interior Supplies Trading', 0, 1, 'C');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 5, 'Purok 4 Banaba St Bo. Barretto Olongapo City', 0, 1, 'C');
$pdf->Cell(0, 5, 'Phone: +63 916 635 1911 | Email: elbarcoma@gmail.com', 0, 1, 'C');
$pdf->Ln(4);
$pdf->SetDrawColor(65, 105, 225);
$pdf->SetLineWidth(0.5);
$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
$pdf->Ln(8);


// order info
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(100, 8, "Order #: " . $order['order_number']);
$pdf->Ln(6);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(100, 8, "Order Date: " . date("F j, Y, g:i a", strtotime($order['order_date'])));
$pdf->Ln(6);
$pdf->Cell(100, 8, "Payment Method: " . $order['payment_method']);
$pdf->Ln(10);

// customer Info
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(100, 8, 'Customer Information');
$pdf->Ln(6);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(100, 8, $order['first_name'] . " " . $order['last_name']);
$pdf->Ln(6);
$pdf->Cell(100, 8, "Email: " . $order['email']);
$pdf->Ln(6);
$pdf->Cell(100, 8, "Contact: " . $order['contact_number']);
$pdf->Ln(6);
$pdf->MultiCell(0, 8, "Address: " . $order['delivery_address']);
$pdf->Ln(10);

// table header
$pdf->SetFillColor(65, 105, 225);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('Arial', 'B',12);
$pdf->Cell(80, 10, 'Product', 1, 0, 'C', true);
$pdf->Cell(25, 10, 'Qty', 1, 0, 'C', true);
$pdf->Cell(35, 10, 'Price', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Subtotal', 1, 1, 'C', true);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('Arial', '', 12);

// table rows
$pdf->SetFont('Arial', '', 12);
foreach ($items as $item) {
    $pdf->Cell(80, 10, $item['product_name'], 1);
    $pdf->Cell(25, 10, $item['quantity'], 1, 0, 'C');
    $pdf->Cell(35, 10, number_format($item['product_price'], 2), 1, 0, 'R');
    $pdf->Cell(40, 10, number_format($item['subtotal'], 2), 1, 1, 'R');
}

// totals

$pdf->Ln(4);
$pdf->SetFont('Arial', '', 12);
$shipping = $order['shipping_fee'] ?? 75.00;
$subtotal = $order['final_amount'] - $shipping;
$pdf->Cell(140, 8, 'Subtotal | PHP', 0, 0, 'R');
$pdf->Cell(40, 8, '' . number_format($subtotal, 2), 0, 1, 'R');
$pdf->Cell(140, 8, 'Shipping Fee | PHP', 0, 0, 'R');
$pdf->Cell(40, 8, '' . number_format($shipping, 2), 0, 1, 'R');

$pdf->Ln(2);
$pdf->SetFillColor(65, 105, 225);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(140, 10, 'Total Amount | PHP', 1, 0, 'R', true);
$pdf->Cell(40, 10, '' . number_format($order['final_amount'], 2), 1, 1, 'R', true);
$pdf->SetTextColor(0, 0, 0);
$pdf->Ln(10);
$pdf->SetDrawColor(200, 200, 200);
$pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
$pdf->Ln(4);

$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(0, 5, 'Thank you for shopping with us!', 0, 1, 'C');
$pdf->Cell(0, 5, 'For questions or concerns, contact elbarcoma@gmail.com', 0, 1, 'C');
$pdf->Ln(3);
$pdf->SetTextColor(150, 150, 150);
$pdf->Cell(0, 5, 'This is your online receipt. Physical receipt shall be received when delivered.', 0, 1, 'C');

$pdf->Output('I', 'Receipt_' . $order['order_number'] . '.pdf');
?>
