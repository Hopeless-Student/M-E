<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Low Stock Alerts - M & E Dashboard</title>
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

        .logo img {
            width: 200px;
            height: auto;
            margin-bottom: 1rem;
        }

        .dashboard {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 280px;
            height: 100vh;
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            color: white;
            padding: 2rem 0;
            box-shadow: 4px 0 10px rgba(30, 58, 138, 0.1);
            z-index: 1000;
            overflow-y: auto;
            transition: transform 0.3s ease;
        }

        .logo {
            padding: 0 2rem 2rem;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 2rem;
        }

        .logo img {
            width: 200px;
            height: auto;
            margin-bottom: 1rem;
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
            margin-left: 280px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            background: white;
            padding: 1.5rem 2rem;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .header h2 {
            font-size: 2rem;
            font-weight: 600;
            color: #dc2626;

            display: flex;
            align-items: center; /* centers icon with text */
            gap: 0.5rem; /* spacing between icon and text */
        }


        .header-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .back-btn {
            background: #64748b;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .back-btn:hover {
            background: #475569;
            color: white;
        }

        .refresh-btn {
            background: #1e40af;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .refresh-btn:hover {
            background: #1e3a8a;
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

        /* Alert Summary */
        .alert-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .summary-card {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border-left: 4px solid;
            position: relative;
        }

        .summary-card.critical {
            border-left-color: #dc2626;
        }

        .summary-card.warning {
            border-left-color: #d97706;
        }

        .summary-card.info {
            border-left-color: #1e40af;
        }

        .summary-title {
            font-size: 0.9rem;
            color: #64748b;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .summary-value {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .summary-card.critical .summary-value {
            color: #dc2626;
        }

        .summary-card.warning .summary-value {
            color: #d97706;
        }

        .summary-card.info .summary-value {
            color: #1e40af;
        }

        .summary-subtitle {
            font-size: 0.8rem;
            color: #64748b;
        }

        .summary-icon {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            font-size: 2rem;
            opacity: 0.3;
        }

        /* Quick Actions */
        .quick-actions {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .actions-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 1rem;
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .action-btn {
            padding: 1rem;
            border: 2px solid #e2e8f0;
            background: white;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 500;
            color: #475569;
        }

        .action-btn:hover {
            border-color: #1e40af;
            background: #f8fafc;
            color: #1e40af;
        }

        .action-btn.primary {
            background: #1e40af;
            border-color: #1e40af;
            color: white;
        }

        .action-btn.primary:hover {
            background: #1e3a8a;
        }

        /* Alerts Table */
        .alerts-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .section-header {
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
            color: white;
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .alerts-controls {
            display: flex;
            gap: 1rem;
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #e2e8f0;
            background: #f8fafc;
        }

        .search-box {
            position: relative;
            flex: 1;
        }

        .search-input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 0.9rem;
        }

        .search-box::before {
            content: '🔍';
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
        }

        .filter-select {
            padding: 0.75rem 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            background: white;
            font-size: 0.9rem;
            min-width: 150px;
        }

        .alerts-table {
            width: 100%;
            border-collapse: collapse;
        }

        .alerts-table th {
            background-color: #f8fafc;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #475569;
            font-size: 0.9rem;
            border-bottom: 2px solid #e2e8f0;
        }

        .alerts-table td {
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .alerts-table tr:hover {
            background-color: #fef2f2;
        }

        .product-cell {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .product-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .product-info h4 {
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 0.25rem;
        }

        .product-info p {
            font-size: 0.85rem;
            color: #64748b;
        }

        .alert-level {
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .alert-level.critical {
            background: #fee2e2;
            color: #991b1b;
        }

        .alert-level.warning {
            background: #fef3c7;
            color: #92400e;
        }

        .alert-level.low {
            background: #e0e7ff;
            color: #1e40af;
        }

        .stock-info {
            text-align: center;
        }

        .current-stock {
            font-size: 1.2rem;
            font-weight: 700;
            color: #dc2626;
        }

        .min-stock {
            font-size: 0.85rem;
            color: #64748b;
        }

        .stock-progress {
            width: 100px;
            height: 8px;
            background: #fee2e2;
            border-radius: 4px;
            overflow: hidden;
            margin: 0.5rem auto;
        }

        .stock-fill {
            height: 100%;
            background: #dc2626;
            border-radius: 4px;
            transition: width 0.3s ease;
        }

        .days-supply {
            font-weight: 600;
            text-align: center;
        }

        .days-supply.critical {
            color: #dc2626;
        }

        .days-supply.warning {
            color: #d97706;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.8rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-primary {
            background: #1e40af;
            color: white;
        }

        .btn-primary:hover {
            background: #1e3a8a;
        }

        .btn-secondary {
            background: #64748b;
            color: white;
        }

        .btn-secondary:hover {
            background: #475569;
        }

        .btn-warning {
            background: #d97706;
            color: white;
        }

        .btn-warning:hover {
            background: #b45309;
        }

        .btn-success {
            background: #059669;
            color: white;
        }

        .btn-success:hover {
            background: #047857;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 2rem;
            border-top: 1px solid #e2e8f0;
        }

        .pagination-info {
            color: #64748b;
            font-size: 0.9rem;
        }

        .pagination-controls {
            display: flex;
            gap: 0.5rem;
        }

        .page-btn {
            padding: 0.5rem 1rem;
            border: 1px solid #d1d5db;
            background: white;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
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

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.3s ease;
        }

        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: white;
            padding: 2rem;
            border-radius: 12px;
            width: 90%;
            max-width: 600px;
            max-height: 80vh;
            overflow-y: auto;
            animation: slideIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideIn {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e2e8f0;
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1e40af;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #64748b;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.2s;
        }

        .close-btn:hover {
            color: #1e40af;
            background: #f1f5f9;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #475569;
        }

        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: #1e40af;
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px solid #e2e8f0;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s;
        }

        .modal-section {
            margin-bottom: 2rem;
        }

        .modal-section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .item-list {
            max-height: 300px;
            overflow-y: auto;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
        }

        .item-entry {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid #f3f4f6;
        }

        .item-entry:last-child {
            border-bottom: none;
        }

        .item-info {
            flex: 1;
        }

        .item-name {
            font-weight: 500;
            color: #374151;
        }

        .item-details {
            font-size: 0.8rem;
            color: #6b7280;
        }

        .quantity-input {
            width: 80px;
            text-align: center;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .info-card {
            background: #f8fafc;
            padding: 1rem;
            border-radius: 8px;
            border-left: 3px solid #1e40af;
        }

        .info-label {
            font-size: 0.8rem;
            color: #64748b;
            margin-bottom: 0.25rem;
        }

        .info-value {
            font-weight: 600;
            color: #1e40af;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: static;
                height: auto;
            }

            .main-content {
                margin-left: 0;
            }

            .dashboard {
                flex-direction: column;
            }

            .alert-summary {
                grid-template-columns: 1fr;
            }

            .actions-grid {
                grid-template-columns: 1fr;
            }

            .alerts-controls {
                flex-direction: column;
            }

            .action-buttons {
                justify-content: center;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="logo">
                <img src="../M-E_logo.png" alt="M&E Logo">
                <h1>M & E Inventory</h1>
                <p>Management System</p>
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
                    <a href="../users/index.php" class="nav-link">
                        <i data-lucide="users"></i> Customers
                    </a>
                </li>
                <li class="nav-item">
                    <a href="index.php" class="nav-link active">
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
                <h2><i data-lucide="siren"style="width:45px; height:50px;"></i> Low Stock Alerts</h2>
                <div class="header-actions">
                    <button class="refresh-btn" onclick="refreshAlerts()">
                        <span data-lucide="rotate-cw"></span> Refresh
                    </button>
                    <a href="index.php" class="back-btn">
                        <span data-lucide="arrow-left"></span> Back to Inventory
                    </a>
                    <div class="user-info">
                        <span>Admin Panel</span>
                        <div class="avatar">A</div>
                    </div>
                </div>
            </div>

            <!-- Alert Summary -->
            <div class="alert-summary">
                <div class="summary-card critical">
                    <div class="summary-icon"><i data-lucide="siren" style="width:55px; height:60px; color:red;"></i></div>
                    <div class="summary-title">Critical Alerts</div>
                    <div class="summary-value">3</div>
                    <div class="summary-subtitle">Out of stock</div>
                </div>
                <div class="summary-card warning">
                    <div class="summary-icon"><i data-lucide="triangle-alert" style="width:55px; height:60px; color: yellow;"></i></div>
                    <div class="summary-title">Warning Alerts</div>
                    <div class="summary-value">9</div>
                    <div class="summary-subtitle">Below minimum stock</div>
                </div>
                <div class="summary-card info">
                    <div class="summary-icon"><i data-lucide="chart-no-axes-column-increasing" style="width:55px; height:60px; color: #4169e1;"></i></div>
                    <div class="summary-title">Total Items</div>
                    <div class="summary-value">12</div>
                    <div class="summary-subtitle">Requiring attention</div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <h3 class="actions-title">Quick Actions</h3>
                <div class="actions-grid">
                    <button class="action-btn primary" onclick="openBulkRestockModal()">
                        <span data-lucide="package-plus"></span> Create Bulk Restock Request
                    </button>
                    <button class="action-btn" onclick="openMinimumLevelsModal()">
                        <span data-lucide="ruler" style="color:black"></span> Adjust Min Levels
                    </button>
                    <button class="action-btn" onclick="exportLowStockReport()">
                        <span data-lucide="download"></span> Export Report
                    </button>
                    <button class="action-btn" onclick="openEmailAlertsModal()">
                        <span data-lucide="mail"></span> Send Email Alerts
                    </button>
                </div>
            </div>

            <!-- Alerts Table -->
            <div class="alerts-section">
                <div class="section-header">
                    <h3 class="section-title">Low Stock Items</h3>
                    <span id="alertsCount">12 items need attention</span>
                </div>

                <div class="alerts-controls">
                    <div class="search-box">
                        <input type="text" class="search-input" placeholder="Search products..." id="searchInput">
                    </div>
                    <select class="filter-select" id="categoryFilter">
                        <option value="">All Categories</option>
                        <option value="office">Office Supplies</option>
                        <option value="school">School Supplies</option>
                        <option value="sanitary">Sanitary Supplies</option>
                    </select>
                    <select class="filter-select" id="alertLevelFilter">
                        <option value="">All Alert Levels</option>
                        <option value="critical">Critical</option>
                        <option value="warning">Warning</option>
                        <option value="low">Low</option>
                    </select>
                </div>

                <table class="alerts-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Alert Level</th>
                            <th>Current/Min Stock</th>
                            <th>Stock Level</th>
                            <th>Days Supply</th>
                            <th>Last Restock</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="alertsTableBody">
                        <!-- Alert data will be populated here -->
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="pagination">
                    <div class="pagination-info">
                        Showing <span id="startItem">1</span>-<span id="endItem">12</span> of <span id="totalAlerts">12</span> alerts
                    </div>
                    <div class="pagination-controls">
                        <button class="page-btn" onclick="changePage('prev')">Previous</button>
                        <button class="page-btn active" onclick="changePage(1)">1</button>
                        <button class="page-btn" onclick="changePage('next')">Next</button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Bulk Restock Modal -->
    <div id="bulkRestockModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">📦 Create Bulk Restock Request</h3>
                <button class="close-btn" onclick="closeModal('bulkRestockModal')">&times;</button>
            </div>
            <form id="bulkRestockForm">
                <div class="modal-section">
                    <div class="modal-section-title">Request Details</div>
                    <div class="form-group">
                        <label class="form-label">Request Priority</label>
                        <select class="form-select" id="requestPriority" required>
                            <option value="urgent">Urgent (Within 24 hours)</option>
                            <option value="high">High Priority (2-3 days)</option>
                            <option value="normal">Normal (1 week)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Requested By</label>
                        <input type="text" class="form-input" id="requestedBy" value="Admin User" readonly>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Department</label>
                        <select class="form-select" id="department" required>
                            <option value="inventory">Inventory Management</option>
                            <option value="purchasing">Purchasing Department</option>
                            <option value="operations">Operations</option>
                        </select>
                    </div>
                </div>

                <div class="modal-section">
                    <div class="modal-section-title">Items to Restock</div>
                    <div class="item-list" id="restockItemsList">
                        <!-- Items will be populated here -->
                    </div>
                </div>

                <div class="modal-section">
                    <div class="modal-section-title">Additional Notes</div>
                    <div class="form-group">
                        <label class="form-label">Special Instructions</label>
                        <textarea class="form-textarea" id="restockNotes" placeholder="Any special handling requirements or notes..."></textarea>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('bulkRestockModal')">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit Restock Request</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Individual Restock Modal -->
    <div id="individualRestockModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">🔄 Restock Item</h3>
                <button class="close-btn" onclick="closeModal('individualRestockModal')">&times;</button>
            </div>
            <form id="individualRestockForm">
                <div class="modal-section">
                    <div class="modal-section-title">Product Information</div>
                    <div class="info-grid">
                        <div class="info-card">
                            <div class="info-label">Product Name</div>
                            <div class="info-value" id="restockProductName">-</div>
                        </div>
                        <div class="info-card">
                            <div class="info-label">Current Stock</div>
                            <div class="info-value" id="restockCurrentStock">-</div>
                        </div>
                        <div class="info-card">
                            <div class="info-label">Minimum Stock</div>
                            <div class="info-value" id="restockMinStock">-</div>
                        </div>
                        <div class="info-card">
                            <div class="info-label">Recommended Qty</div>
                            <div class="info-value" id="restockRecommended">-</div>
                        </div>
                    </div>
                </div>

                <div class="modal-section">
                    <div class="modal-section-title">Restock Details</div>
                    <div class="form-group">
                        <label class="form-label">Restock Quantity</label>
                        <input type="number" class="form-input" id="restockQuantity" min="1" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Priority Level</label>
                        <select class="form-select" id="restockPriority" required>
                            <option value="urgent">Urgent - Critical Stock</option>
                            <option value="high">High Priority</option>
                            <option value="normal">Normal Priority</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Reason for Restock</label>
                        <select class="form-select" id="restockReason" required>
                            <option value="low_stock">Below Minimum Stock Level</option>
                            <option value="out_of_stock">Out of Stock</option>
                            <option value="high_demand">High Demand Expected</option>
                            <option value="seasonal">Seasonal Preparation</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Notes</label>
                        <textarea class="form-textarea" id="restockItemNotes" placeholder="Additional notes or special requirements..."></textarea>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('individualRestockModal')">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit Restock Request</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Adjust Stock Modal -->
    <div id="adjustStockModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">📝 Adjust Stock Level</h3>
                <button class="close-btn" onclick="closeModal('adjustStockModal')">&times;</button>
            </div>
            <form id="adjustStockForm">
                <div class="modal-section">
                    <div class="modal-section-title">Product Information</div>
                    <div class="info-grid">
                        <div class="info-card">
                            <div class="info-label">Product Name</div>
                            <div class="info-value" id="adjustProductName">-</div>
                        </div>
                        <div class="info-card">
                            <div class="info-label">Current Stock</div>
                            <div class="info-value" id="adjustCurrentStock">-</div>
                        </div>
                    </div>
                </div>

                <div class="modal-section">
                    <div class="modal-section-title">Stock Adjustment</div>
                    <div class="form-group">
                        <label class="form-label">Adjustment Type</label>
                        <select class="form-select" id="adjustmentType" required>
                            <option value="add">Add Stock (+)</option>
                            <option value="remove">Remove Stock (-)</option>
                            <option value="set">Set Exact Amount</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Quantity</label>
                        <input type="number" class="form-input" id="adjustQuantity" min="0" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Reason for Adjustment</label>
                        <select class="form-select" id="adjustReason" required>
                            <option value="recount">Physical Recount</option>
                            <option value="damaged">Damaged Items</option>
                            <option value="expired">Expired Items</option>
                            <option value="found">Items Found</option>
                            <option value="transfer">Transfer Between Locations</option>
                            <option value="correction">Data Correction</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Notes</label>
                        <textarea class="form-textarea" id="adjustNotes" placeholder="Detailed explanation for this adjustment..." required></textarea>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('adjustStockModal')">Cancel</button>
                    <button type="submit" class="btn btn-warning">Apply Adjustment</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Minimum Levels Modal -->
    <div id="minimumLevelsModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">📏 Adjust Minimum Stock Levels</h3>
                <button class="close-btn" onclick="closeModal('minimumLevelsModal')">&times;</button>
            </div>
            <div class="modal-section">
                <div class="modal-section-title">Bulk Adjustment Options</div>
                <div class="form-group">
                    <label class="form-label">Adjustment Method</label>
                    <select class="form-select" id="bulkAdjustMethod">
                        <option value="percentage">Percentage Increase/Decrease</option>
                        <option value="fixed">Fixed Amount Increase/Decrease</option>
                        <option value="individual">Individual Item Adjustment</option>
                    </select>
                </div>
                <div class="form-group" id="percentageGroup">
                    <label class="form-label">Percentage Change (%)</label>
                    <input type="number" class="form-input" id="percentageChange" placeholder="e.g., 20 for 20% increase, -10 for 10% decrease">
                </div>
                <div class="form-group" id="fixedGroup" style="display:none;">
                    <label class="form-label">Fixed Amount Change</label>
                    <input type="number" class="form-input" id="fixedChange" placeholder="e.g., 5 to add 5 to each minimum, -3 to subtract 3">
                </div>
            </div>

            <div class="modal-section" id="individualAdjustSection" style="display:none;">
                <div class="modal-section-title">Individual Adjustments</div>
                <div class="item-list" id="minimumLevelsList">
                    <!-- Items will be populated here -->
                </div>
            </div>

            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="closeModal('minimumLevelsModal')">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="applyMinimumLevelChanges()">Apply Changes</button>
            </div>
        </div>
    </div>

    <!-- Email Alerts Modal -->
    <div id="emailAlertsModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">📧 Send Email Alerts</h3>
                <button class="close-btn" onclick="closeModal('emailAlertsModal')">&times;</button>
            </div>
            <form id="emailAlertsForm">
                <div class="modal-section">
                    <div class="modal-section-title">Recipients</div>
                    <div class="form-group">
                        <label class="form-label">
                            <input type="checkbox" id="managersCheckbox" checked>
                            All Managers (3 recipients)
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="form-label">
                            <input type="checkbox" id="purchasingCheckbox" checked>
                            Purchasing Department (2 recipients)
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="form-label">
                            <input type="checkbox" id="inventoryCheckbox">
                            Inventory Team (4 recipients)
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Additional Recipients</label>
                        <textarea class="form-textarea" id="additionalEmails" placeholder="Enter additional email addresses, separated by commas..."></textarea>
                    </div>
                </div>

                <div class="modal-section">
                    <div class="modal-section-title">Alert Settings</div>
                    <div class="form-group">
                        <label class="form-label">Alert Level Filter</label>
                        <select class="form-select" id="emailAlertLevel">
                            <option value="all">All Alert Levels</option>
                            <option value="critical">Critical Only</option>
                            <option value="critical_warning">Critical & Warning</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email Format</label>
                        <select class="form-select" id="emailFormat">
                            <option value="summary">Summary Report</option>
                            <option value="detailed">Detailed Report</option>
                            <option value="both">Both Summary & Detailed</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">
                            <input type="checkbox" id="includeActions">
                            Include Suggested Actions
                        </label>
                    </div>
                </div>

                <div class="modal-section">
                    <div class="modal-section-title">Custom Message</div>
                    <div class="form-group">
                        <label class="form-label">Additional Message (Optional)</label>
                        <textarea class="form-textarea" id="customMessage" placeholder="Add any additional context or instructions..."></textarea>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('emailAlertsModal')">Cancel</button>
                    <button type="submit" class="btn btn-success">Send Alerts</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        lucide.createIcons();
        // Sample low stock data
        const lowStockData = [
            {
                id: 1,
                name: 'Staplers',
                category: 'office',
                sku: 'OFF-STA-004',
                currentStock: 0,
                minStock: 25,
                icon: '📎',
                alertLevel: 'critical',
                daysSupply: 0,
                lastRestock: '2024-10-15',
                avgDailyUsage: 2.5
            },
            {
                id: 2,
                name: 'Notebooks',
                category: 'school',
                sku: 'SCH-NOT-005',
                currentStock: 8,
                minStock: 20,
                icon: '📓',
                alertLevel: 'critical',
                daysSupply: 3,
                lastRestock: '2024-10-20',
                avgDailyUsage: 2.8
            },
            {
                id: 3,
                name: 'Hand Sanitizer',
                category: 'sanitary',
                sku: 'SAN-HAN-006',
                currentStock: 5,
                minStock: 30,
                icon: '🧴',
                alertLevel: 'critical',
                daysSupply: 2,
                lastRestock: '2024-10-18',
                avgDailyUsage: 3.2
            },
            {
                id: 4,
                name: 'File Folders',
                category: 'office',
                sku: 'OFF-FOL-003',
                currentStock: 12,
                minStock: 15,
                icon: '📁',
                alertLevel: 'warning',
                daysSupply: 8,
                lastRestock: '2024-11-01',
                avgDailyUsage: 1.5
            },
            {
                id: 5,
                name: 'Whiteboard Markers',
                category: 'office',
                sku: 'OFF-MAR-007',
                currentStock: 18,
                minStock: 25,
                icon: '🖊️',
                alertLevel: 'warning',
                daysSupply: 12,
                lastRestock: '2024-10-28',
                avgDailyUsage: 1.8
            },
            {
                id: 6,
                name: 'Tissue Paper',
                category: 'sanitary',
                sku: 'SAN-TIS-008',
                currentStock: 22,
                minStock: 40,
                icon: '🧻',
                alertLevel: 'warning',
                daysSupply: 7,
                lastRestock: '2024-10-25',
                avgDailyUsage: 3.5
            },
            {
                id: 7,
                name: 'Printer Paper',
                category: 'office',
                sku: 'OFF-PAP-009',
                currentStock: 15,
                minStock: 20,
                icon: '📄',
                alertLevel: 'warning',
                daysSupply: 10,
                lastRestock: '2024-11-05',
                avgDailyUsage: 1.8
            },
            {
                id: 8,
                name: 'Calculators',
                category: 'office',
                sku: 'OFF-CAL-010',
                currentStock: 6,
                minStock: 10,
                icon: '🔢',
                alertLevel: 'warning',
                daysSupply: 15,
                lastRestock: '2024-10-12',
                avgDailyUsage: 0.4
            }
        ];

        let currentEditingItem = null;

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            populateAlertsTable(lowStockData);
            updateSummaryCards();
            setupEventListeners();
        });

        function populateAlertsTable(data) {
            const tbody = document.getElementById('alertsTableBody');
            tbody.innerHTML = '';

            data.forEach(item => {
                const row = tbody.insertRow();
                const stockPercentage = (item.currentStock / item.minStock) * 100;

                row.innerHTML = `
                    <td>
                        <div class="product-cell">
                            <div class="product-icon">${item.icon}</div>
                            <div class="product-info">
                                <h4>${item.name}</h4>
                                <p>${item.sku}</p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="alert-level ${item.alertLevel}">${capitalizeFirst(item.alertLevel)}</span>
                    </td>
                    <td>
                        <div class="stock-info">
                            <div class="current-stock">${item.currentStock}</div>
                            <div class="min-stock">Min: ${item.minStock}</div>
                            <div class="stock-progress">
                                <div class="stock-fill" style="width: ${Math.min(stockPercentage, 100)}%"></div>
                            </div>
                        </div>
                    </td>
                    <td>${stockPercentage.toFixed(0)}%</td>
                    <td>
                        <div class="days-supply ${item.daysSupply <= 3 ? 'critical' : item.daysSupply <= 7 ? 'warning' : ''}">
                            ${item.daysSupply} days
                        </div>
                    </td>
                    <td>${formatDate(item.lastRestock)}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-sm btn-primary" onclick="openIndividualRestockModal(${item.id})">Restock</button>
                            <button class="btn-sm btn-secondary" onclick="openAdjustStockModal(${item.id})">Adjust</button>
                        </div>
                    </td>
                `;
            });
        }

        function setupEventListeners() {
            // Search functionality
            document.getElementById('searchInput').addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const filteredData = lowStockData.filter(item =>
                    item.name.toLowerCase().includes(searchTerm) ||
                    item.sku.toLowerCase().includes(searchTerm)
                );
                populateAlertsTable(filteredData);
            });

            // Category filter
            document.getElementById('categoryFilter').addEventListener('change', function() {
                const selectedCategory = this.value;
                const filteredData = selectedCategory ?
                    lowStockData.filter(item => item.category === selectedCategory) :
                    lowStockData;
                populateAlertsTable(filteredData);
            });

            // Alert level filter
            document.getElementById('alertLevelFilter').addEventListener('change', function() {
                const selectedLevel = this.value;
                const filteredData = selectedLevel ?
                    lowStockData.filter(item => item.alertLevel === selectedLevel) :
                    lowStockData;
                populateAlertsTable(filteredData);
            });

            // Minimum levels adjustment method change
            document.getElementById('bulkAdjustMethod').addEventListener('change', function() {
                const method = this.value;
                document.getElementById('percentageGroup').style.display = method === 'percentage' ? 'block' : 'none';
                document.getElementById('fixedGroup').style.display = method === 'fixed' ? 'block' : 'none';
                document.getElementById('individualAdjustSection').style.display = method === 'individual' ? 'block' : 'none';

                if (method === 'individual') {
                    populateMinimumLevelsList();
                }
            });
        }

        function updateSummaryCards() {
            const critical = lowStockData.filter(item => item.alertLevel === 'critical').length;
            const warning = lowStockData.filter(item => item.alertLevel === 'warning').length;

            document.querySelector('.summary-card.critical .summary-value').textContent = critical;
            document.querySelector('.summary-card.warning .summary-value').textContent = warning;
            document.querySelector('.summary-card.info .summary-value').textContent = lowStockData.length;
        }

        function capitalizeFirst(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });
        }

        // Modal Functions
        function openBulkRestockModal() {
            document.getElementById('bulkRestockModal').classList.add('show');
            populateRestockItemsList();
        }

        function populateRestockItemsList() {
            const itemsList = document.getElementById('restockItemsList');
            itemsList.innerHTML = '';

            lowStockData.forEach(item => {
                const recommendedQty = Math.max(item.minStock * 2 - item.currentStock, 0);
                const itemEntry = document.createElement('div');
                itemEntry.className = 'item-entry';
                itemEntry.innerHTML = `
                    <div class="item-info">
                        <div class="item-name">${item.icon} ${item.name}</div>
                        <div class="item-details">Current: ${item.currentStock} | Min: ${item.minStock} | SKU: ${item.sku}</div>
                    </div>
                    <div>
                        <input type="number" class="quantity-input" value="${recommendedQty}" min="0"
                               data-item-id="${item.id}" placeholder="Qty">
                    </div>
                `;
                itemsList.appendChild(itemEntry);
            });
        }

        function openIndividualRestockModal(itemId) {
            const item = lowStockData.find(i => i.id === itemId);
            currentEditingItem = item;

            document.getElementById('restockProductName').textContent = item.name;
            document.getElementById('restockCurrentStock').textContent = item.currentStock;
            document.getElementById('restockMinStock').textContent = item.minStock;
            document.getElementById('restockRecommended').textContent = item.minStock * 2 - item.currentStock;
            document.getElementById('restockQuantity').value = item.minStock * 2 - item.currentStock;
            document.getElementById('restockPriority').value = item.alertLevel === 'critical' ? 'urgent' : 'high';

            document.getElementById('individualRestockModal').classList.add('show');
        }

        function openAdjustStockModal(itemId) {
            const item = lowStockData.find(i => i.id === itemId);
            currentEditingItem = item;

            document.getElementById('adjustProductName').textContent = item.name;
            document.getElementById('adjustCurrentStock').textContent = item.currentStock;
            document.getElementById('adjustQuantity').value = '';
            document.getElementById('adjustNotes').value = '';

            document.getElementById('adjustStockModal').classList.add('show');
        }

        function openMinimumLevelsModal() {
            document.getElementById('minimumLevelsModal').classList.add('show');
        }

        function populateMinimumLevelsList() {
            const itemsList = document.getElementById('minimumLevelsList');
            itemsList.innerHTML = '';

            lowStockData.forEach(item => {
                const itemEntry = document.createElement('div');
                itemEntry.className = 'item-entry';
                itemEntry.innerHTML = `
                    <div class="item-info">
                        <div class="item-name">${item.icon} ${item.name}</div>
                        <div class="item-details">Current Min: ${item.minStock} | SKU: ${item.sku}</div>
                    </div>
                    <div>
                        <input type="number" class="quantity-input" value="${item.minStock}" min="1"
                               data-item-id="${item.id}" placeholder="New Min">
                    </div>
                `;
                itemsList.appendChild(itemEntry);
            });
        }

        function openEmailAlertsModal() {
            document.getElementById('emailAlertsModal').classList.add('show');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('show');
            currentEditingItem = null;
        }

        // Action Functions
        function refreshAlerts() {
            const refreshBtn = document.querySelector('.refresh-btn');
            refreshBtn.style.opacity = '0.6';
            refreshBtn.style.pointerEvents = 'none';

            setTimeout(() => {
                populateAlertsTable(lowStockData);
                updateSummaryCards();
                refreshBtn.style.opacity = '1';
                refreshBtn.style.pointerEvents = 'auto';

                const header = document.querySelector('.header h2');
                const originalText = header.textContent;
                header.textContent = '✅ Alerts Updated';
                header.style.color = '#059669';

                setTimeout(() => {
                    header.textContent = originalText;
                    header.style.color = '#dc2626';
                }, 2000);
            }, 1000);
        }

        function exportLowStockReport() {
            let csvContent = "Product Name,SKU,Current Stock,Minimum Stock,Alert Level,Days Supply,Last Restock\n";

            lowStockData.forEach(item => {
                csvContent += `"${item.name}",${item.sku},${item.currentStock},${item.minStock},${item.alertLevel},${item.daysSupply},${item.lastRestock}\n`;
            });

            const blob = new Blob([csvContent], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.setAttribute('hidden', '');
            a.setAttribute('href', url);
            a.setAttribute('download', 'low_stock_report_' + new Date().toISOString().split('T')[0] + '.csv');
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        }

        function applyMinimumLevelChanges() {
            const method = document.getElementById('bulkAdjustMethod').value;
            let changesApplied = 0;

            if (method === 'percentage') {
                const percentage = parseFloat(document.getElementById('percentageChange').value);
                if (isNaN(percentage)) {
                    alert('Please enter a valid percentage');
                    return;
                }
                changesApplied = lowStockData.length;
                alert(`Minimum levels adjusted by ${percentage}% for ${changesApplied} items`);
            } else if (method === 'fixed') {
                const fixedAmount = parseFloat(document.getElementById('fixedChange').value);
                if (isNaN(fixedAmount)) {
                    alert('Please enter a valid fixed amount');
                    return;
                }
                changesApplied = lowStockData.length;
                alert(`Minimum levels adjusted by ${fixedAmount} units for ${changesApplied} items`);
            } else if (method === 'individual') {
                const inputs = document.querySelectorAll('#minimumLevelsList .quantity-input');
                changesApplied = inputs.length;
                alert(`Individual minimum levels updated for ${changesApplied} items`);
            }

            closeModal('minimumLevelsModal');
        }

        function changePage(page) {
            console.log('Changing to page:', page);
        }

        // Form Submissions
        document.getElementById('bulkRestockForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const priority = document.getElementById('requestPriority').value;
            const department = document.getElementById('department').value;
            const notes = document.getElementById('restockNotes').value;

            const items = [];
            document.querySelectorAll('#restockItemsList .quantity-input').forEach(input => {
                const quantity = parseInt(input.value);
                if (quantity > 0) {
                    items.push({
                        id: input.dataset.itemId,
                        quantity: quantity
                    });
                }
            });

            alert(`Bulk restock request submitted!\n${items.length} items requested with ${priority} priority.`);
            closeModal('bulkRestockModal');
        });

        document.getElementById('individualRestockForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const quantity = document.getElementById('restockQuantity').value;
            const priority = document.getElementById('restockPriority').value;
            const reason = document.getElementById('restockReason').value;

            alert(`Restock request submitted for ${currentEditingItem.name}\nQuantity: ${quantity} units\nPriority: ${capitalizeFirst(priority)}`);
            closeModal('individualRestockModal');
        });

        document.getElementById('adjustStockForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const type = document.getElementById('adjustmentType').value;
            const quantity = document.getElementById('adjustQuantity').value;
            const reason = document.getElementById('adjustReason').value;

            alert(`Stock adjustment applied for ${currentEditingItem.name}\nType: ${capitalizeFirst(type)}\nQuantity: ${quantity}\nReason: ${reason}`);
            closeModal('adjustStockModal');
        });

        document.getElementById('emailAlertsForm').addEventListener('submit', function(e) {
            e.preventDefault();
            let recipientCount = 0;
            if (document.getElementById('managersCheckbox').checked) recipientCount += 3;
            if (document.getElementById('purchasingCheckbox').checked) recipientCount += 2;
            if (document.getElementById('inventoryCheckbox').checked) recipientCount += 4;

            alert(`Email alerts sent successfully to ${recipientCount} recipients!`);
            closeModal('emailAlertsModal');
        });

        // Close modal when clicking outside
        window.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal')) {
                e.target.classList.remove('show');
                currentEditingItem = null;
            }
        });

        // Auto-refresh alerts every 5 minutes
        setInterval(function() {
            console.log('Auto-refreshing alerts...');
        }, 300000);
    </script>
</body>
</html>
