<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Orders - M & E Dashboard</title>
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

        img {
            width: 200px;
            height: 200px;
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
            overflow-x: auto;
            min-width: 0;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #64748b;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .breadcrumb a {
            color: #1e40af;
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .header h2 {
            font-size: 2rem;
            font-weight: 600;
            color: #1e40af;
        }

        .header-actions {
            display: flex;
            gap: 1rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-primary {
            background-color: #1e40af;
            color: white;
        }

        .btn-primary:hover {
            background-color: #1e3a8a;
        }

        .btn-secondary {
            background-color: #64748b;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #475569;
        }

        /* Customer Info Header */
        .customer-info-header {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .customer-avatar {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.2rem;
        }

        .customer-details h3 {
            color: #1e40af;
            margin-bottom: 0.25rem;
        }

        .customer-details p {
            color: #64748b;
            font-size: 0.9rem;
        }

        /* Order Stats */
        .order-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            text-align: center;
            border-left: 4px solid #1e40af;
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #64748b;
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Filter Controls */
        .filter-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .filter-group {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .filter-select {
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: white;
            font-size: 0.9rem;
            min-width: 150px;
        }

        .date-range {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .date-input {
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 0.9rem;
        }

        /* Orders Table */
        .orders-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .table-container {
            overflow-x: auto;
        }

        .orders-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
        }

        .orders-table th {
            background-color: #f8fafc;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #475569;
            font-size: 0.9rem;
            border-bottom: 2px solid #e2e8f0;
            white-space: nowrap;
        }

        .orders-table td {
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: middle;
        }

        .orders-table tr:hover {
            background-color: #f8fafc;
        }

        .order-id {
            color: #1e40af;
            font-weight: 600;
            text-decoration: none;
        }

        .order-id:hover {
            text-decoration: underline;
        }

        .order-status {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            white-space: nowrap;
        }

        .order-status.completed { background-color: #d1fae5; color: #065f46; }
        .order-status.pending { background-color: #fef3c7; color: #92400e; }
        .order-status.processing { background-color: #dbeafe; color: #1d4ed8; }
        .order-status.cancelled { background-color: #fee2e2; color: #dc2626; }
        .order-status.refunded { background-color: #f3e8ff; color: #7c3aed; }

        .order-items {
            max-width: 200px;
        }

        .item-list {
            font-size: 0.85rem;
            color: #64748b;
        }

        .item-count {
            font-weight: 500;
            color: #1e40af;
        }

        .order-total {
            font-weight: 700;
            color: #1e293b;
            font-size: 1rem;
        }

        .action-btn {
            padding: 0.5rem 1rem;
            background-color: #1e40af;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.8rem;
            transition: background-color 0.2s ease;
            text-decoration: none;
            display: inline-block;
            white-space: nowrap;
        }

        .action-btn:hover {
            background-color: #1e3a8a;
        }

        .action-btn.secondary {
            background-color: #64748b;
        }

        .action-btn.secondary:hover {
            background-color: #475569;
        }

        .actions {
            display: flex;
            gap: 0.5rem;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem;
            border-top: 1px solid #e2e8f0;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .pagination-info {
            color: #64748b;
            font-size: 0.9rem;
        }

        .pagination-controls {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .page-btn {
            padding: 0.5rem 1rem;
            border: 1px solid #d1d5db;
            background: white;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
            min-width: 44px;
            text-align: center;
        }

        .page-btn:hover {
            background-color: #1e40af;
            color: white;
        }

        .page-btn.active {
            background-color: #1e40af;
            color: white;
            border-color: #1e40af;
        }

        /* Order Summary */
        .order-summary {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
            padding: 1.5rem;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .summary-item {
            text-align: center;
            padding: 1rem;
            border-radius: 8px;
            background: #f8fafc;
        }

        .summary-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 0.25rem;
        }

        .summary-label {
            color: #64748b;
            font-size: 0.9rem;
        }

        /* Mobile Styles */
        @media (max-width: 1024px) {
            .dashboard {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                position: static;
            }

            .main-content {
                padding: 1rem;
            }
        }

        @media (max-width: 768px) {
            .customer-info-header {
                flex-direction: column;
                text-align: center;
            }

            .filter-controls {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-group {
                flex-direction: column;
                width: 100%;
            }

            .filter-select, .date-input {
                width: 100%;
            }

            .header-actions {
                flex-direction: column;
                width: 100%;
            }

            .btn {
                width: 100%;
            }

            .order-stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .order-stats {
                grid-template-columns: 1fr;
            }

            .actions {
                flex-direction: column;
            }

            .action-btn {
                width: 100%;
                text-align: center;
            }

            .pagination {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .pagination-controls {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <nav class="sidebar">
            <div class="logo">
                <img src="../M-E_logo.png" alt="">
            </div>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="../index.php" class="nav-link">
                        <i data-lucide="bar-chart-3"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../orders/index.php" class="nav-link">
                        <i data-lucide="package"></i> Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../products/index.php" class="nav-link">
                        <i data-lucide="shopping-cart"></i> Products
                    </a>
                </li>
                <li class="nav-item">
                    <a href="index.php" class="nav-link active">
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

        <main class="main-content">
            <div class="breadcrumb">
                <a href="../index.php">Dashboard</a>
                <span>›</span>
                <a href="index.php">Customers</a>
                <span>›</span>
                <a href="user-details.php?id=1">Juan Dela Cruz</a>
                <span>›</span>
                <span>Orders</span>
            </div>

            <div class="header">
                <h2>Customer Orders</h2>
                <div class="header-actions">
                    <a href="user-details.php?id=1" class="btn btn-secondary">Back to Profile</a>
                    <a href="edit-user.php?id=1" class="btn btn-primary">Edit Customer</a>
                </div>
            </div>

            <!-- Customer Info Header -->
            <div class="customer-info-header">
                <div class="customer-avatar">JD</div>
                <div class="customer-details">
                    <h3>Juan Dela Cruz</h3>
                    <p>juan.delacruz@email.com • +63 917 123 4567</p>
                    <p>Customer ID: #CUS-001 • Member since August 2024</p>
                </div>
            </div>

            <!-- Order Stats -->
            <div class="order-stats">
                <div class="stat-card">
                    <div class="stat-value">8</div>
                    <div class="stat-label">Total Orders</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">₱4,250</div>
                    <div class="stat-label">Total Spent</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">₱531</div>
                    <div class="stat-label">Average Order</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">7</div>
                    <div class="stat-label">Completed Orders</div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="order-summary">
                <h4 style="margin-bottom: 1rem; color: #1e40af;">Order Summary by Status</h4>
                <div class="summary-grid">
                    <div class="summary-item">
                        <div class="summary-value">7</div>
                        <div class="summary-label">Completed (₱3,950)</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-value">0</div>
                        <div class="summary-label">Pending (₱0)</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-value">0</div>
                        <div class="summary-label">Processing (₱0)</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-value">1</div>
                        <div class="summary-label">Cancelled (₱300)</div>
                    </div>
                </div>
            </div>

            <!-- Filter Controls -->
            <div class="filter-controls">
                <div class="filter-group">
                    <select class="filter-select" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="completed">Completed</option>
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="cancelled">Cancelled</option>
                        <option value="refunded">Refunded</option>
                    </select>
                    <div class="date-range">
                        <input type="date" class="date-input" id="startDate" title="Start Date">
                        <span>to</span>
                        <input type="date" class="date-input" id="endDate" title="End Date">
                    </div>
                </div>
                <div class="filter-group">
                    <button class="btn btn-secondary" onclick="exportOrders()">Export Orders</button>
                </div>
            </div>

            <!-- Orders Table -->
            <div class="orders-section">
                <div class="table-container">
                    <table class="orders-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Payment Method</th>
                                <th>Status</th>
                                <th>Last Updated</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><a href="../orders/order-details.php?id=1234" class="order-id">#1234</a></td>
                                <td>Aug 30, 2025</td>
                                <td>
                                    <div class="order-items">
                                        <div class="item-count">3 items</div>
                                        <div class="item-list">Widget A, Widget B, Widget C</div>
                                    </div>
                                </td>
                                <td><span class="order-total">₱850</span></td>
                                <td>Credit Card</td>
                                <td><span class="order-status completed">Completed</span></td>
                                <td>Aug 30, 2025</td>
                                <td>
                                    <div class="actions">
                                        <a href="../orders/order-details.php?id=1234" class="action-btn">View</a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="../orders/order-details.php?id=1233" class="order-id">#1233</a></td>
                                <td>Aug 25, 2025</td>
                                <td>
                                    <div class="order-items">
                                        <div class="item-count">2 items</div>
                                        <div class="item-list">Product X, Product Y</div>
                                    </div>
                                </td>
                                <td><span class="order-total">₱650</span></td>
                                <td>GCash</td>
                                <td><span class="order-status completed">Completed</span></td>
                                <td>Aug 25, 2025</td>
                                <td>
                                    <div class="actions">
                                        <a href="../orders/order-details.php?id=1233" class="action-btn">View</a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="../orders/order-details.php?id=1232" class="order-id">#1232</a></td>
                                <td>Aug 20, 2025</td>
                                <td>
                                    <div class="order-items">
                                        <div class="item-count">5 items</div>
                                        <div class="item-list">Item A, Item B, Item C, Item D, Item E</div>
                                    </div>
                                </td>
                                <td><span class="order-total">₱1,200</span></td>
                                <td>PayPal</td>
                                <td><span class="order-status completed">Completed</span></td>
                                <td>Aug 20, 2025</td>
                                <td>
                                    <div class="actions">
                                        <a href="../orders/order-details.php?id=1232" class="action-btn">View</a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="../orders/order-details.php?id=1231" class="order-id">#1231</a></td>
                                <td>Aug 15, 2025</td>
                                <td>
                                    <div class="order-items">
                                        <div class="item-count">1 item</div>
                                        <div class="item-list">Special Product</div>
                                    </div>
                                </td>
                                <td><span class="order-total">₱300</span></td>
                                <td>Credit Card</td>
                                <td><span class="order-status cancelled">Cancelled</span></td>
                                <td>Aug 16, 2025</td>
                                <td>
                                    <div class="actions">
                                        <a href="../orders/order-details.php?id=1231" class="action-btn">View</a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="../orders/order-details.php?id=1230" class="order-id">#1230</a></td>
                                <td>Aug 10, 2025</td>
                                <td>
                                    <div class="order-items">
                                        <div class="item-count">4 items</div>
                                        <div class="item-list">Product A, Product B, Product C, Product D</div>
                                    </div>
                                </td>
                                <td><span class="order-total">₱950</span></td>
                                <td>Bank Transfer</td>
                                <td><span class="order-status completed">Completed</span></td>
                                <td>Aug 10, 2025</td>
                                <td>
                                    <div class="actions">
                                        <a href="../orders/order-details.php?id=1230" class="action-btn">View</a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="../orders/order-details.php?id=1229" class="order-id">#1229</a></td>
                                <td>Aug 05, 2025</td>
                                <td>
                                    <div class="order-items">
                                        <div class="item-count">2 items</div>
                                        <div class="item-list">Widget X, Widget Y</div>
                                    </div>
                                </td>
                                <td><span class="order-total">₱750</span></td>
                                <td>GCash</td>
                                <td><span class="order-status completed">Completed</span></td>
                                <td>Aug 05, 2025</td>
                                <td>
                                    <div class="actions">
                                        <a href="../orders/order-details.php?id=1229" class="action-btn">View</a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><a href="../orders/order-details.php?id=1228" class="order-id">#1228</a></td>
                                <td>Jul 30, 2025</td>
                                <td>
                                    <div class="order-items">
                                        <div class="item-count">3 items</div>
                                        <div class="item-list">Item X, Item Y, Item Z</div>
                                    </div>
                                </td>
                                <td><span class="order-total">₱495</span></td>
                                <td>Credit Card</td>
                                <td><span class="order-status completed">Completed</span></td>
                                <td>Jul 30, 2025</td>
                                <td>
                                    <div class="actions">
                                        <a href="../orders/order-details.php?id=1228" class="action-btn">View</a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination">
                    <div class="pagination-info">
                        Showing 1-7 of 8 orders
                    </div>
                    <div class="pagination-controls">
                        <button class="page-btn">Previous</button>
                        <button class="page-btn active">1</button>
                        <button class="page-btn">2</button>
                        <button class="page-btn">Next</button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        lucide.createIcons();
        // Status filter functionality
        document.getElementById('statusFilter').addEventListener('change', function(e) {
            const filterValue = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('.orders-table tbody tr');

            rows.forEach(row => {
                const statusElement = row.querySelector('.order-status');
                const status = statusElement.textContent.toLowerCase();

                row.style.display = !filterValue || status.includes(filterValue) ? '' : 'none';
            });

            updatePaginationInfo();
        });

        // Date range filter
        function filterByDateRange() {
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            const rows = document.querySelectorAll('.orders-table tbody tr');

            if (!startDate && !endDate) {
                rows.forEach(row => row.style.display = '');
                return;
            }

            rows.forEach(row => {
                const dateCell = row.cells[1].textContent;
                const orderDate = new Date(dateCell);

                let showRow = true;

                if (startDate && orderDate < new Date(startDate)) {
                    showRow = false;
                }

                if (endDate && orderDate > new Date(endDate)) {
                    showRow = false;
                }

                row.style.display = showRow ? '' : 'none';
            });

            updatePaginationInfo();
        }

        document.getElementById('startDate').addEventListener('change', filterByDateRange);
        document.getElementById('endDate').addEventListener('change', filterByDateRange);

        // Export orders functionality
        function exportOrders() {
            const visibleRows = document.querySelectorAll('.orders-table tbody tr:not([style*="display: none"])');

            if (visibleRows.length === 0) {
                alert('No orders to export with current filters.');
                return;
            }

            // Create CSV content
            let csvContent = "Order ID,Date,Items,Total,Payment Method,Status,Last Updated\n";

            visibleRows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const rowData = [
                    cells[0].textContent.trim(),
                    cells[1].textContent.trim(),
                    cells[2].querySelector('.item-count').textContent.trim(),
                    cells[3].textContent.trim(),
                    cells[4].textContent.trim(),
                    cells[5].textContent.trim(),
                    cells[6].textContent.trim()
                ];

                csvContent += rowData.map(field => `"${field}"`).join(',') + '\n';
            });

            // Download CSV
            const blob = new Blob([csvContent], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `juan_delacruz_orders_${new Date().toISOString().split('T')[0]}.csv`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            window.URL.revokeObjectURL(url);

            alert('Orders exported successfully!');
        }

        // Update pagination info based on visible rows
        function updatePaginationInfo() {
            const visibleRows = document.querySelectorAll('.orders-table tbody tr:not([style*="display: none"])');
            const totalRows = document.querySelectorAll('.orders-table tbody tr').length;
            const paginationInfo = document.querySelector('.pagination-info');

            if (paginationInfo) {
                paginationInfo.textContent = `Showing ${visibleRows.length} of ${totalRows} orders`;
            }
        }

        // Pagination button functionality
        document.querySelectorAll('.page-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                if (!this.classList.contains('active') &&
                    this.textContent !== 'Previous' &&
                    this.textContent !== 'Next') {
                    document.querySelector('.page-btn.active').classList.remove('active');
                    this.classList.add('active');
                }
            });
        });

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            // Set default date range to current month
            const now = new Date();
            const firstDay = new Date(now.getFullYear(), now.getMonth(), 1);
            const lastDay = new Date(now.getFullYear(), now.getMonth() + 1, 0);

            // Uncomment to set default date range
            // document.getElementById('startDate').value = firstDay.toISOString().split('T')[0];
            // document.getElementById('endDate').value = lastDay.toISOString().split('T')[0];

            // Add click tracking for orders
            document.querySelectorAll('.order-id').forEach(link => {
                link.addEventListener('click', function(e) {
                    console.log('Viewing order:', this.textContent);
                });
            });
        });
    </script>
</body>
</html>
