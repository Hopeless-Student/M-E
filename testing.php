<?php
require 'dompdf_folder/dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Example order details (you would get these from your database or form POST)
$customerName = "Juan Dela Cruz";
$productName = "Office Chair";
$quantity = 2;
$pricePerItem = 1500;
$totalPrice = $quantity * $pricePerItem;

// DOMPDF setup
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

// HTML receipt
$html = "
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; }
        h1 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .total { font-weight: bold; }
    </style>
</head>
<body>
    <h1>Receipt</h1>
    <p><strong>Customer:</strong> {$customerName}</p>
    <table>
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Price (₱)</th>
            <th>Total (₱)</th>
        </tr>
        <tr>
            <td>{$productName}</td>
            <td>{$quantity}</td>
            <td>{$pricePerItem}</td>
            <td>{$totalPrice}</td>
        </tr>
    </table>
    <p class='total'>Grand Total: ₱{$totalPrice}</p>
</body>
</html>
";

// Load HTML to DOMPDF
$dompdf->loadHtml($html);

// Set paper size
$dompdf->setPaper('A4', 'portrait');

// Render PDF
$dompdf->render();

// Output PDF for download
$dompdf->stream("receipt.pdf", ["Attachment" => true]);
