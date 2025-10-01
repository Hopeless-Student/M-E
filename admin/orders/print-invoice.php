<!DOCTYPE html>
<html lang="en">s
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #INV-001 - M & E Supply</title>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #ffffff;
            color: #334155;
            line-height: 1.6;
            padding: 2rem;
        }

        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .invoice-header {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            color: white;
            padding: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .company-info h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .company-info p {
            opacity: 0.9;
            margin-bottom: 0.25rem;
        }

        .invoice-info {
            text-align: right;
        }

        .invoice-info h2 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .invoice-info p {
            opacity: 0.9;
        }

        .invoice-body {
            padding: 2rem;
        }

        .billing-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .billing-info h3 {
            color: #1e40af;
            font-weight: 600;
            margin-bottom: 1rem;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 0.5rem;
        }

        .billing-info p {
            margin-bottom: 0.5rem;
        }

        .order-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
            padding: 1.5rem;
            background-color: #f8fafc;
            border-radius: 8px;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
        }

        .detail-label {
            font-size: 0.8rem;
            color: #64748b;
            margin-bottom: 0.25rem;
            text-transform: uppercase;
            font-weight: 600;
        }

        .detail-value {
            font-weight: 600;
            color: #1e40af;
        }

        .status {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            display: inline-block;
        }

        .status.pending { background-color: #fef3c7; color: #92400e; }
        .status.processing { background-color: #dbeafe; color: #1d4ed8; }
        .status.delivered { background-color: #d1fae5; color: #065f46; }
        .status.shipped { background-color: #e0e7ff; color: #3730a3; }

        /* Items Table */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2rem;
        }

        .items-table th {
            background-color: #1e40af;
            color: white;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
        }

        .items-table td {
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .items-table tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .total-section {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 2rem;
        }

        .total-table {
            width: 300px;
            border-collapse: collapse;
        }

        .total-table td {
            padding: 0.5rem 1rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .total-table .total-row {
            background-color: #1e40af;
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .payment-info {
            background-color: #f8fafc;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 2rem;
        }

        .payment-info h4 {
            color: #1e40af;
            margin-bottom: 1rem;
        }

        .payment-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .footer-note {
            text-align: center;
            color: #64748b;
            font-size: 0.9rem;
            border-top: 2px solid #e2e8f0;
            padding-top: 1rem;
        }

        .print-controls {
          display: flex;
          justify-content: center; /* Center horizontally */
          align-items: center;
          gap: 1rem; /* Space between buttons */
          margin-bottom: 2rem;
        }

        .print-btn {
          padding: 0.75rem 2rem;
          background: linear-gradient(135deg, #1e40af, #3b82f6); /* Primary gradient */
          color: white;
          border: none;
          border-radius: 8px;
          cursor: pointer;
          font-weight: 600;
          font-size: 1rem;
          text-decoration: none;
          display: inline-flex; /* Icon + text in a row */
          align-items: center;
          transition: transform 0.2s ease, opacity 0.2s ease;
        }
       .lucide{
          margin-right: 1rem;
          width: 20px;
          height: 20px;
        }

        .print-btn:hover {
          transform: translateY(-1px);
          opacity: 0.9;
        }

        .print-btn.secondary {
            background: linear-gradient(135deg, #64748b, #94a3b8); /* Gray gradient */
        }

        .print-btn.secondary:hover {
            background: linear-gradient(135deg, #475569, #64748b);
        }
        .print-btn i {
            margin-right: 0.5rem;
            width: 20px;
            height: 20px;
        }

        @media print {
            body {
                padding: 0;
            }

            .print-controls {
                display: none;
            }

            .invoice-container {
                box-shadow: none;
                border-radius: 0;
            }
        }

        @media (max-width: 768px) {
            .invoice-header {
                flex-direction: column;
                gap: 1rem;
            }

            .invoice-info {
                text-align: left;
            }

            .billing-section {
                grid-template-columns: 1fr;
            }

            .order-details {
                grid-template-columns: 1fr;
            }

            .items-table {
                font-size: 0.9rem;
            }

            .items-table th,
            .items-table td {
                padding: 0.75rem 0.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="print-controls">
        <button class="print-btn" onclick="window.print()"><i data-lucide="printer"></i> Print Invoice</button>
        <button class="print-btn secondary" onclick="downloadPDF()"><i data-lucide="file-text"></i> Download PDF</button>
        <a href="./index.php" class="print-btn secondary">← Back to Orders</a>
    </div>

    <div class="invoice-container">
        <!-- Invoice Header -->
        <div class="invoice-header">
            <div class="company-info">
                <h1>M & E Supply</h1>
                <p>Supply Management Solutions</p>
                <p>123 Business Avenue, Quezon City</p>
                <p>Metro Manila, Philippines 1100</p>
                <p>Phone: +63 2 8123 4567</p>
                <p>Email: info@mesupply.com</p>
            </div>
            <div class="invoice-info">
                <h2>INVOICE</h2>
                <p><strong>Invoice #:</strong> INV-001</p>
                <p><strong>Date:</strong> August 29, 2025</p>
                <p><strong>Due Date:</strong> September 12, 2025</p>
            </div>
        </div>

        <!-- Invoice Body -->
        <div class="invoice-body">
            <!-- Billing Information -->
            <div class="billing-section">
                <div class="billing-info">
                    <h3>Bill To:</h3>
                    <p><strong>Cjay Gonzales</strong></p>
                    <p>ABC Corporation</p>
                    <p>456 Corporate Plaza</p>
                    <p>Makati City, Metro Manila</p>
                    <p>Philippines 1226</p>
                    <p>Email: cjay.gonzales@email.com</p>
                    <p>Phone: +63 912 345 6789</p>
                </div>
                <div class="billing-info">
                    <h3>Ship To:</h3>
                    <p><strong>ABC Corporation</strong></p>
                    <p>Office Supplies Department</p>
                    <p>123 Business Street</p>
                    <p>Quezon City, Metro Manila</p>
                    <p>Philippines 1100</p>
                </div>
            </div>

            <!-- Order Details -->
            <div class="order-details">
                <div class="detail-item">
                    <span class="detail-label">Order ID</span>
                    <span class="detail-value">#ORD-001</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Order Date</span>
                    <span class="detail-value">August 20, 2025</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Status</span>
                    <span class="status processing">Processing</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Payment Method</span>
                    <span class="detail-value">Bank Transfer</span>
                </div>
            </div>

            <!-- Items Table -->
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th style="text-align: center;">Quantity</th>
                        <th style="text-align: right;">Unit Price</th>
                        <th style="text-align: right;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <strong>Ballpens (Blue)</strong><br>
                            <small style="color: #64748b;">Premium quality ballpoint pens</small>
                        </td>
                        <td style="text-align: center;">50 pcs</td>
                        <td style="text-align: right;">₱15.00</td>
                        <td style="text-align: right;">₱750.00</td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Bond Paper A4</strong><br>
                            <small style="color: #64748b;">80gsm white bond paper, 500 sheets per ream</small>
                        </td>
                        <td style="text-align: center;">5 reams</td>
                        <td style="text-align: right;">₱100.00</td>
                        <td style="text-align: right;">₱500.00</td>
                    </tr>
                </tbody>
            </table>

            <!-- Total Section -->
            <div class="total-section">
                <table class="total-table">
                    <tr>
                        <td>Subtotal:</td>
                        <td style="text-align: right;">₱1,250.00</td>
                    </tr>
                    <tr>
                        <td>Tax (12% VAT):</td>
                        <td style="text-align: right;">₱150.00</td>
                    </tr>
                    <tr>
                        <td>Delivery Fee:</td>
                        <td style="text-align: right;">₱50.00</td>
                    </tr>
                    <tr>
                        <td>Discount:</td>
                        <td style="text-align: right;">-₱25.00</td>
                    </tr>
                    <tr class="total-row">
                        <td>TOTAL:</td>
                        <td style="text-align: right;">₱1,425.00</td>
                    </tr>
                </table>
            </div>

            <!-- Payment Information -->
            <div class="payment-info">
                <h4>Payment Information</h4>
                <div class="payment-details">
                    <div class="detail-item">
                        <span class="detail-label">Payment Status</span>
                        <span class="detail-value" style="color: #059669;">Paid</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Payment Date</span>
                        <span class="detail-value">August 20, 2025</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Transaction ID</span>
                        <span class="detail-value">TXN-202508201030</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Payment Method</span>
                        <span class="detail-value">Bank Transfer</span>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="footer-note">
                <p><strong>Terms & Conditions:</strong></p>
                <p>Payment is due within 14 days of invoice date. Late payments may incur additional charges.</p>
                <p>All items are subject to availability. Returns must be made within 7 days of delivery.</p>
                <p style="margin-top: 1rem;"><strong>Thank you for your business!</strong></p>
                <p style="margin-top: 0.5rem; font-size: 0.8rem;">
                    This invoice was generated on August 29, 2025 | M & E Supply Management System
                </p>
            </div>
        </div>
    </div>

    <script>
      lucide.createIcons();
        function downloadPDF() {

            document.querySelector('.print-controls').style.display = 'none';


            alert('PDF download functionality would be implemented here with a library like html2pdf.js');

            document.querySelector('.print-controls').style.display = 'block';
        }


        const urlParams = new URLSearchParams(window.location.search);
        const orderId = urlParams.get('id');

        if (orderId) {

            const invoiceData = {
                '001': {
                    customer: 'Cjay Gonzales',
                    company: 'ABC Corporation',
                    email: 'cjay.gonzales@email.com',
                    phone: '+63 912 345 6789',
                    items: [
                        { name: 'Ballpens (Blue)', desc: 'Premium quality ballpoint pens', qty: 50, unit: 'pcs', price: 15.00 },
                        { name: 'Bond Paper A4', desc: '80gsm white bond paper, 500 sheets per ream', qty: 5, unit: 'reams', price: 100.00 }
                    ]
                },
                '002': {
                    customer: 'Joshua Lapitan',
                    company: 'XYZ School',
                    email: 'joshua.lapitan@email.com',
                    phone: '+63 917 123 4567',
                    items: [
                        { name: 'Notebooks', desc: 'Spiral-bound notebooks, 80 pages', qty: 20, unit: 'pcs', price: 25.00 },
                        { name: 'Pencils', desc: 'HB graphite pencils', qty: 100, unit: 'pcs', price: 3.90 }
                    ]
                }
            };

            if (invoiceData[orderId]) {
                const data = invoiceData[orderId];
                document.title = `Invoice #INV-${orderId} - M & E Supply`;

                // Update customer information
                const billToSection = document.querySelector('.billing-section .billing-info:first-child');
                billToSection.innerHTML = `
                    <h3>Bill To:</h3>
                    <p><strong>${data.customer}</strong></p>
                    <p>${data.company}</p>
                    <p>456 Corporate Plaza</p>
                    <p>Makati City, Metro Manila</p>
                    <p>Philippines 1226</p>
                    <p>Email: ${data.email}</p>
                    <p>Phone: ${data.phone}</p>
                `;


                document.querySelector('.invoice-info p').innerHTML = `<strong>Invoice #:</strong> INV-${orderId}`;


                const tbody = document.querySelector('.items-table tbody');
                tbody.innerHTML = '';
                let subtotal = 0;

                data.items.forEach(item => {
                    const itemTotal = item.qty * item.price;
                    subtotal += itemTotal;

                    tbody.innerHTML += `
                        <tr>
                            <td>
                                <strong>${item.name}</strong><br>
                                <small style="color: #64748b;">${item.desc}</small>
                            </td>
                            <td style="text-align: center;">${item.qty} ${item.unit}</td>
                            <td style="text-align: right;">₱${item.price.toFixed(2)}</td>
                            <td style="text-align: right;">₱${itemTotal.toFixed(2)}</td>
                        </tr>
                    `;
                });


                const tax = subtotal * 0.12;
                const deliveryFee = 50;
                const discount = 25;
                const total = subtotal + tax + deliveryFee - discount;

                document.querySelector('.total-table').innerHTML = `
                    <tr>
                        <td>Subtotal:</td>
                        <td style="text-align: right;">₱${subtotal.toFixed(2)}</td>
                    </tr>
                    <tr>
                        <td>Tax (12% VAT):</td>
                        <td style="text-align: right;">₱${tax.toFixed(2)}</td>
                    </tr>
                    <tr>
                        <td>Delivery Fee:</td>
                        <td style="text-align: right;">₱${deliveryFee.toFixed(2)}</td>
                    </tr>
                    <tr>
                        <td>Discount:</td>
                        <td style="text-align: right;">-₱${discount.toFixed(2)}</td>
                    </tr>
                    <tr class="total-row">
                        <td>TOTAL:</td>
                        <td style="text-align: right;">₱${total.toFixed(2)}</td>
                    </tr>
                `;
            }
        }
    </script>
</body>
</html>
