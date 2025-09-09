<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - M & E Dashboard</title>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
            color: #334155;
            line-height: 1.6;
        }

        .dashboard {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            color: white;
            padding: 2rem 0;
            box-shadow: 4px 0 10px rgba(30, 58, 138, 0.1);
        }

        .logo {
            padding: 0 2rem 2rem;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 2rem;
        }

        .logo h1 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .logo p {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .nav-menu {
            list-style: none;
        }

        .nav-item {
            margin-bottom: 0.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 1rem 2rem;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .nav-link:hover, .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            border-left-color: #60a5fa;
        }

        .nav-link .lucide {
            margin-right: 1rem;
            width: 20px;
            height: 20px;
        }
        /* Main Content */
        .main-content {
            flex: 1;
            padding: 2rem;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .back-btn {
            padding: 0.5rem 1rem;
            background-color: #64748b;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .back-btn:hover {
            background-color: #475569;
        }

        .header h2 {
            font-size: 2rem;
            font-weight: 600;
            color: #1e40af;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        /* Order Details Cards */
        .order-details-container {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
        }

        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .order-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-size: 0.8rem;
            color: #64748b;
            margin-bottom: 0.25rem;
            text-transform: uppercase;
            font-weight: 600;
        }

        .info-value {
            font-size: 1rem;
            font-weight: 500;
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

        .category-badge {
            padding: 0.25rem 0.5rem;
            background-color: #e0e7ff;
            color: #1e40af;
            border-radius: 6px;
            font-size: 0.8rem;
            display: inline-block;
        }

        /* Items Table */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .items-table th {
            background-color: #f8fafc;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #475569;
            font-size: 0.9rem;
            border-bottom: 2px solid #e2e8f0;
        }

        .items-table td {
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .items-table tr:hover {
            background-color: #f8fafc;
        }

        /* Customer Info */
        .customer-card .info-item {
            margin-bottom: 1rem;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .action-btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            transition: all 0.2s ease;
        }

        .action-btn.primary {
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            color: white;
        }

        .action-btn.primary:hover {
            transform: translateY(-1px);
        }

        .action-btn.secondary {
            background-color: #64748b;
            color: white;
        }

        .action-btn.secondary:hover {
            background-color: #475569;
        }

        .action-btn.danger {
            background-color: #dc2626;
            color: white;
        }

        .action-btn.danger:hover {
            background-color: #b91c1c;
        }

        .order-timeline {
            margin-top: 2rem;
        }

        .timeline-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            padding: 1rem;
            background-color: #f8fafc;
            border-radius: 8px;
            border-left: 4px solid #1e40af;
        }

        .timeline-date {
            font-size: 0.8rem;
            color: #64748b;
            min-width: 100px;
        }

        .timeline-status {
            font-weight: 600;
            margin-left: 1rem;
        }

        .notes-section {
            margin-top: 2rem;
        }

        .notes-textarea {
            width: 100%;
            padding: 1rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            resize: vertical;
            min-height: 100px;
            font-family: inherit;
        }

        .notes-textarea:focus {
            outline: none;
            border-color: #1e40af;
        }

        @media (max-width: 768px) {
            .dashboard {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
            }

            .order-details-container {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <nav class="sidebar">
            <div class="logo">
                <h1>M & E</h1>
                <p>Supply Management</p>
            </div>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="../index.php" class="nav-link">
                        <i data-lucide="bar-chart-3"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./index.php" class="nav-link active">
                        <i data-lucide="package"></i> Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../products/index.php" class="nav-link">
                        <i data-lucide="shopping-cart"></i> Products
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../users/index.php" class="nav-link">
                        <i data-lucide="users"></i> Customers
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../inventory/index.php" class="nav-link">
                        <i data-lucide="clipboard-list"></i> Inventory
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../requests/index.php" class="nav-link">
                        <i data-lucide="message-circle"></i> Messages
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../settings/index.php" class="nav-link">
                        <i data-lucide="settings"></i> Settings
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="main-content">
            <div class="header">
                <div class="header-left">
                    <a href="./index.php" class="back-btn">← Back to Orders</a>
                    <h2>Order Details</h2>
                </div>
                <div class="user-info">
                    <span>Elbar Como</span>
                    <div class="avatar">E</div>
                </div>
            </div>

            <div class="order-details-container">
                <!-- Main Order Details -->
                <div class="main-details">
                    <div class="card">
                        <h3 class="card-title">
                            <span data-lucide = "clipboard-list"></span> Order Information
                        </h3>

                        <div class="order-info">
                            <div class="info-item">
                                <span class="info-label">Order ID</span>
                                <span class="info-value">#ORD-001</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Customer</span>
                                <span class="info-value">Cjay Gonzales</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Category</span>
                                <span class="category-badge">Office Supplies</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Total Amount</span>
                                <span class="info-value" style="font-size: 1.25rem; font-weight: 700; color: #1e40af;">₱1,250</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Order Date</span>
                                <span class="info-value">August 20, 2025</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Status</span>
                                <span class="status processing">Processing</span>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <h4 style="margin-bottom: 1rem; color: #475569; font-weight: 600;">Order Items</h4>
                        <table class="items-table">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Ballpens (Blue)</td>
                                    <td>50 pcs</td>
                                    <td>₱15.00</td>
                                    <td>₱750.00</td>
                                </tr>
                                <tr>
                                    <td>Bond Paper A4</td>
                                    <td>5 reams</td>
                                    <td>₱100.00</td>
                                    <td>₱500.00</td>
                                </tr>
                                <tr style="border-top: 2px solid #1e40af;">
                                    <td colspan="3" style="text-align: right; font-weight: 600;">Total:</td>
                                    <td style="font-weight: 700; color: #1e40af; font-size: 1.1rem;">₱1,250.00</td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Order Timeline -->
                        <div class="order-timeline">
                            <h4 style="margin-bottom: 1rem; color: #475569; font-weight: 600;">Order Timeline</h4>
                            <div class="timeline-item">
                                <span class="timeline-date">Aug 20, 10:30 AM</span>
                                <span class="timeline-status">Order Placed</span>
                            </div>
                            <div class="timeline-item">
                                <span class="timeline-date">Aug 20, 2:15 PM</span>
                                <span class="timeline-status">Payment Confirmed</span>
                            </div>
                            <div class="timeline-item">
                                <span class="timeline-date">Aug 21, 9:00 AM</span>
                                <span class="timeline-status">Processing Started</span>
                            </div>
                        </div>

                        <!-- Notes Section -->
                        <div class="notes-section">
                            <h4 style="margin-bottom: 1rem; color: #475569; font-weight: 600;">Order Notes</h4>
                            <textarea class="notes-textarea" placeholder="Add notes about this order...">Customer requested blue ballpens specifically. Priority delivery needed for office opening.</textarea>
                        </div>

                        <!-- Action Buttons -->
                        <div class="action-buttons">
                            <a href="update-status.php?id=001" class="action-btn primary">Update Status</a>
                            <a href="print-invoice.php?id=001" class="action-btn secondary" target="_blank">Print Invoice</a>
                            <button class="action-btn secondary" onclick="saveNotes()">Save Notes</button>
                            <button class="action-btn danger" onclick="cancelOrder()">Cancel Order</button>
                        </div>
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="customer-details">
                    <div class="card customer-card">
                        <h3 class="card-title">
                            <span data-lucide = "circle-user-round"></span> Customer Information
                        </h3>

                        <div class="info-item">
                            <span class="info-label">Customer Name</span>
                            <span class="info-value">Cjay Gonzales</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Email</span>
                            <span class="info-value">cjay.gonzales@email.com</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Phone</span>
                            <span class="info-value">+63 912 345 6789</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Company</span>
                            <span class="info-value">ABC Corporation</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Customer Since</span>
                            <span class="info-value">January 2024</span>
                        </div>
                    </div>

                    <div class="card">
                        <h3 class="card-title">
                            <span data-lucide="truck"></span> Delivery Information
                        </h3>

                        <div class="info-item">
                            <span class="info-label">Delivery Address</span>
                            <span class="info-value">
                                123 Business Street<br>
                                Quezon City, Metro Manila<br>
                                Philippines 1100
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Delivery Method</span>
                            <span class="info-value">Standard Delivery</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Expected Delivery</span>
                            <span class="info-value">August 22, 2025</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Tracking Number</span>
                            <span class="info-value">ME-TRK-2025-001</span>
                        </div>
                    </div>

                    <div class="card">
                        <h3 class="card-title">
                            <span data-lucide="credit-card"></span> Payment Information
                        </h3>

                        <div class="info-item">
                            <span class="info-label">Payment Method</span>
                            <span class="info-value">Bank Transfer</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Payment Status</span>
                            <span class="status delivered">Paid</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Transaction ID</span>
                            <span class="info-value">TXN-202508201030</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Payment Date</span>
                            <span class="info-value">August 20, 2025</span>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
    lucide.createIcons();
        function saveNotes() {
            const notes = document.querySelector('.notes-textarea').value;

            alert('Notes saved successfully!');
        }

        function cancelOrder() {
            if (confirm('Are you sure you want to cancel this order? This action cannot be undone.')) {

                alert('Order cancelled successfully!');
                window.location.href = './index.php';
            }
        }


        const urlParams = new URLSearchParams(window.location.search);
        const orderId = urlParams.get('id');

      //update page
        if (orderId) {
            document.title = `Order #ORD-${orderId} Details - M & E Dashboard`;
        }
    </script>
</body>
</html>
