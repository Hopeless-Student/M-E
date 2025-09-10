
</body>
</html><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory - M & E Dashboard</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
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
            overflow-x: hidden;
        }
        img {
            width: 250px;
            height: 250px;
        }

        .dashboard {
            display: flex;
            min-height: 100vh;
            position: relative;
        }

        /* Sidebar - Fixed positioning */
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
            width: 120px;
            height: 120px;
            margin: 0 auto 2rem;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 700;
            text-align: center;
            line-height: 1.2;
            margin-bottom: 75px;
            margin-top: 30px;
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

        /* Main Content - Fixed margin for sidebar */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 2rem;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
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
            align-items: center;
            flex-wrap: wrap;
        }

        .notification-btn {
            position: relative;
            background: #fee2e2;
            color: #dc2626;
            border: none;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .notification-btn:hover {
            background: #fecaca;
            transform: translateY(-1px);
        }

        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #dc2626;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: bold;
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

        /* Quick Actions Bar */
        .quick-actions {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .quick-action-btn {
            padding: 0.75rem 1.5rem;
            background: white;
            color: #1e40af;
            border: 2px solid #1e40af;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .quick-action-btn:hover {
            background: #1e40af;
            color: white;
            transform: translateY(-1px);
        }

        .quick-action-btn.primary {
            background: #1e40af;
            color: white;
        }

        .quick-action-btn.primary:hover {
            background: #1e3a8a;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #1e40af;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 12px -1px rgba(0, 0, 0, 0.15);
        }

        .stat-card.warning {
            border-left-color: #d97706;
        }

        .stat-card.danger {
            border-left-color: #dc2626;
        }

        .stat-title {
            color: #64748b;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1e40af;
            margin-top: 0.5rem;
        }

        .stat-card.warning .stat-value {
            color: #d97706;
        }

        .stat-card.danger .stat-value {
            color: #dc2626;
        }

        .stat-subtitle {
            font-size: 0.8rem;
            color: #64748b;
            margin-top: 0.25rem;
        }

        /* Charts Section */
        .charts-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .chart-container {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            min-height: 350px;
        }

        .chart-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 1rem;
        }

        .chart-wrapper {
            position: relative;
            height: 280px;
            width: 100%;
        }

        /* Inventory Controls */
        .inventory-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            gap: 1rem;
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            flex-wrap: wrap;
        }

        .search-filter {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .search-box {
            position: relative;
        }

        .search-box input {
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 0.9rem;
            min-width: 300px;
        }

        .search-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            width: 16px;
            height: 16px;
        }

        .filter-select {
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: white;
            font-size: 0.9rem;
            min-width: 150px;
        }

        .export-btn {
            padding: 0.75rem 1.5rem;
            background-color: #64748b;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: background-color 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .export-btn:hover {
            background-color: #475569;
        }

        /* Inventory Table */
        .inventory-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .table-container {
            overflow-x: auto;
        }

        .inventory-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1000px;
        }

        .inventory-table th {
            background-color: #f8fafc;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #475569;
            font-size: 0.9rem;
            border-bottom: 2px solid #e2e8f0;
            white-space: nowrap;
        }

        .inventory-table td {
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
            white-space: nowrap;
        }

        .inventory-table tr:hover {
            background-color: #f8fafc;
        }

        .product-info-cell {
            display: flex;
            align-items: center;
            gap: 1rem;
            min-width: 250px;
            white-space: normal;
        }

        .product-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .product-details h4 {
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 0.25rem;
        }

        .product-details p {
            font-size: 0.85rem;
            color: #64748b;
        }

        .category-badge {
            padding: 0.25rem 0.5rem;
            background-color: #e0e7ff;
            color: #1e40af;
            border-radius: 6px;
            font-size: 0.8rem;
        }

        .stock-level {
            font-weight: 600;
            font-size: 1.1rem;
        }

        .stock-level.high { color: #059669; }
        .stock-level.medium { color: #d97706; }
        .stock-level.low { color: #dc2626; }

        .stock-bar {
            width: 100px;
            height: 8px;
            background-color: #e2e8f0;
            border-radius: 4px;
            overflow: hidden;
            margin-top: 0.5rem;
        }

        .stock-fill {
            height: 100%;
            border-radius: 4px;
            transition: width 0.3s ease;
        }

        .stock-fill.high { background-color: #059669; }
        .stock-fill.medium { background-color: #d97706; }
        .stock-fill.low { background-color: #dc2626; }

        .action-btn {
            padding: 0.5rem 1rem;
            background-color: #1e40af;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.8rem;
            transition: all 0.2s ease;
            margin-right: 0.5rem;
            margin-bottom: 0.25rem;
        }

        .action-btn:hover {
            background-color: #1e3a8a;
            transform: translateY(-1px);
        }

        .action-btn.secondary {
            background-color: #64748b;
        }

        .action-btn.secondary:hover {
            background-color: #475569;
        }

        .action-btn.danger {
            background-color: #dc2626;
        }

        .action-btn.danger:hover {
            background-color: #b91c1c;
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

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.3s;
        }

        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .modal-content {
            background-color: white;
            padding: 2rem;
            border-radius: 12px;
            width: 100%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
            animation: slideIn 0.3s;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e2e8f0;
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
            padding: 0.5rem;
            border-radius: 4px;
            transition: all 0.2s;
        }

        .close-btn:hover {
            color: #1e40af;
            background-color: #f1f5f9;
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

        .form-input, .form-select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.2s;
        }

        .form-input:focus, .form-select:focus {
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

        .btn-primary {
            background: #1e40af;
            color: white;
        }

        .btn-primary:hover {
            background: #1e3a8a;
        }

        .btn-secondary {
            background: #e2e8f0;
            color: #475569;
        }

        .btn-secondary:hover {
            background: #cbd5e1;
        }

        /* Loading states */
        .btn.loading {
            opacity: 0.7;
            cursor: not-allowed;
            position: relative;
        }

        .btn.loading::after {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            margin: auto;
            border: 2px solid transparent;
            border-top-color: currentColor;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideIn {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes slideInRight {
            from { transform: translateX(300px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Mobile Menu Toggle */
        .mobile-menu-toggle {
            display: none;
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1100;
            background: #1e40af;
            color: white;
            border: none;
            padding: 0.75rem;
            border-radius: 8px;
            cursor: pointer;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .main-content {
                margin-left: 0;
                padding: 1rem;
            }

            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .mobile-menu-toggle {
                display: block;
            }

            .dashboard.sidebar-open .main-content {
                margin-left: 0;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .charts-section {
                grid-template-columns: 1fr;
            }

            .inventory-controls {
                flex-direction: column;
                align-items: stretch;
            }

            .search-filter {
                flex-direction: column;
                width: 100%;
            }

            .search-box input {
                min-width: auto;
                width: 100%;
            }

            .filter-select {
                min-width: auto;
                width: 100%;
            }

            .header {
                flex-direction: column;
                text-align: center;
            }

            .header h2 {
                font-size: 1.5rem;
            }

            .quick-actions {
                justify-content: center;
            }

            .pagination {
                flex-direction: column;
                text-align: center;
            }
        }

        @media (max-width: 640px) {
            .main-content {
                padding: 0.5rem;
            }

            .modal-content {
                padding: 1rem;
                margin: 0.5rem;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Mobile Menu Toggle -->
    <!-- <button class="mobile-menu-toggle" onclick="toggleSidebar()">
        <i data-lucide="menu"></i>
    </button> -->

    <div class="dashboard" id="dashboard">
        <!-- Sidebar -->
        <nav class="sidebar" id="sidebar">
            <div class="logo">
                <img src="../../assets/images/logo/ME logo.png" alt="">

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
                    <a href="./index.php" class="nav-link active">
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
                <h2>Inventory Management</h2>
                <div class="header-actions">
                    <button class="notification-btn" onclick="window.location.href='./low-stock-alerts.php'">
                        <span class="notification-badge">12</span>
                        <i data-lucide="bell-ring"></i> Low Stock Alerts
                    </button>
                    <div class="user-info">
                        <span>Admin Panel</span>
                        <div class="avatar">A</div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <button class="quick-action-btn primary" onclick="window.location.href='./adjust-stock.php'">
                    <i data-lucide="plus"></i> Quick Stock Adjust
                </button>
                <button class="quick-action-btn" onclick="window.location.href='./stock-movements.php'">
                    <i data-lucide="activity"></i> View Movements
                </button>
                <button class="quick-action-btn" onclick="openBulkUpdateModal()">
                    <i data-lucide="edit"></i> Bulk Update
                </button>
                <button class="quick-action-btn" onclick="generateReport()">
                    <i data-lucide="download"></i> Generate Report
                </button>
            </div>

            <!-- Inventory Stats -->
            <div class="stats-grid">
                <div class="stat-card" onclick="filterByStatus('all')">
                    <div class="stat-title">Total Products</div>
                    <div class="stat-value">8</div>
                    <div class="stat-subtitle">Across 3 categories</div>
                </div>
                <div class="stat-card warning" onclick="openLowStockModal()">
                    <div class="stat-title">Low Stock Items</div>
                    <div class="stat-value">4</div>
                    <div class="stat-subtitle">Need restocking</div>
                </div>
                <div class="stat-card danger" onclick="filterByStatus('out-of-stock')">
                    <div class="stat-title">Out of Stock</div>
                    <div class="stat-value">0</div>
                    <div class="stat-subtitle">Immediate attention</div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">Total Value</div>
                    <div class="stat-value">₱285K</div>
                    <div class="stat-subtitle">Current inventory</div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="charts-section">
                <div class="chart-container">
                    <div class="chart-title">Stock Levels by Category</div>
                    <div class="chart-wrapper">
                        <canvas id="stockChart"></canvas>
                    </div>
                </div>
                <div class="chart-container">
                    <div class="chart-title">Inventory Turnover</div>
                    <div class="chart-wrapper">
                        <canvas id="turnoverChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Inventory Controls -->
            <div class="inventory-controls">
                <div class="search-filter">
                    <div class="search-box">
                        <i data-lucide="search" class="search-icon"></i>
                        <input type="text" placeholder="Search inventory..." id="searchInput">
                    </div>
                    <select class="filter-select" id="categoryFilter">
                        <option value="">All Categories</option>
                        <option value="office">Office Supplies</option>
                        <option value="school">School Supplies</option>
                        <option value="sanitary">Sanitary Supplies</option>
                    </select>
                    <select class="filter-select" id="stockFilter">
                        <option value="">All Stock Levels</option>
                        <option value="high">High Stock</option>
                        <option value="medium">Medium Stock</option>
                        <option value="low">Low Stock</option>
                    </select>
                </div>
                <button class="export-btn" onclick="exportReport()">
                    <i data-lucide="download"></i> Export Report
                </button>
            </div>

            <!-- Inventory Table -->
            <div class="inventory-section">
                <div class="table-container">
                    <table class="inventory-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Category</th>
                                <th>SKU</th>
                                <th>Current Stock</th>
                                <th>Min Stock</th>
                                <th>Unit Price</th>
                                <th>Total Value</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="inventoryTableBody">
                            <!-- Table rows will be populated here -->
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination">
                    <div class="pagination-info">
                        Showing <span id="startItem">1</span>-<span id="endItem">8</span> of <span id="totalItems">8</span> products
                    </div>
                    <!-- Bulk Update Modal -->
            <div id="bulkUpdateModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Bulk Stock Update</h3>
                        <button class="close-btn" onclick="closeModal('bulkUpdateModal')">&times;</button>
                    </div>
                    <form id="bulkUpdateForm">
                        <div class="form-group">
                            <label class="form-label">Category</label>
                            <select class="form-input" id="bulkCategory" required>
                                <option value="">Select Category</option>
                                <option value="office">Office Supplies</option>
                                <option value="school">School Supplies</option>
                                <option value="sanitary">Sanitary Supplies</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Action</label>
                            <select class="form-input" id="bulkAction" required>
                                <option value="increase">Increase by Percentage</option>
                                <option value="decrease">Decrease by Percentage</option>
                                <option value="setMin">Set Minimum Stock</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Value</label>
                            <input type="number" class="form-input" id="bulkValue" min="0" required>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="btn btn-secondary" onclick="closeModal('bulkUpdateModal')">Cancel</button>
                            <button type="submit" class="btn btn-primary">Apply Update</button>
                        </div>
                    </form>
                </div>
            </div>

            <div id="viewDetailsModal"class="modal">

            </div>
<script>
      // Initialize Lucide icons
      lucide.createIcons();

      const inventoryData = [
          {
              id: 1,
              name: 'Ballpoint Pens',
              description: 'Pack of 12',
              category: 'office',
              categoryName: 'Office Supplies',
              sku: 'OFF-PEN-001',
              stock: 150,
              minStock: 20,
              price: 180,
              icon: '🖊️',
              stockLevel: 'high'
          },
          {
              id: 2,
              name: 'Bond Paper',
              description: 'A4 Ream 500 sheets',
              category: 'office',
              categoryName: 'Office Supplies',
              sku: 'OFF-PAP-002',
              stock: 85,
              minStock: 30,
              price: 250,
              icon: '📄',
              stockLevel: 'medium'
          },
          {
              id: 3,
              name: 'File Folders',
              description: 'Manila folders',
              category: 'office',
              categoryName: 'Office Supplies',
              sku: 'OFF-FOL-003',
              stock: 45,
              minStock: 15,
              price: 120,
              icon: '📁',
              stockLevel: 'medium'
          },
          {
              id: 4,
              name: 'Staplers',
              description: 'Heavy duty stapler',
              category: 'office',
              categoryName: 'Office Supplies',
              sku: 'OFF-STA-004',
              stock: 12,
              minStock: 25,
              price: 850,
              icon: '📎',
              stockLevel: 'low'
          },
          {
              id: 5,
              name: 'Notebooks',
              description: 'Spiral notebook 100 pages',
              category: 'school',
              categoryName: 'School Supplies',
              sku: 'SCH-NOT-005',
              stock: 8,
              minStock: 20,
              price: 65,
              icon: '📓',
              stockLevel: 'low'
          },
          {
              id: 6,
              name: 'Hand Sanitizer',
              description: '500ml bottle',
              category: 'sanitary',
              categoryName: 'Sanitary Supplies',
              sku: 'SAN-HAN-006',
              stock: 25,
              minStock: 30,
              price: 185,
              icon: '🧴',
              stockLevel: 'low'
          },
          {
              id: 7,
              name: 'Whiteboard Markers',
              description: 'Set of 4 colors',
              category: 'office',
              categoryName: 'Office Supplies',
              sku: 'OFF-MAR-007',
              stock: 75,
              minStock: 25,
              price: 320,
              icon: '🖊️',
              stockLevel: 'high'
          },
          {
              id: 8,
              name: 'Tissue Paper',
              description: 'Box of 200 sheets',
              category: 'sanitary',
              categoryName: 'Sanitary Supplies',
              sku: 'SAN-TIS-008',
              stock: 22,
              minStock: 40,
              price: 95,
              icon: '🧻',
              stockLevel: 'low'
          }
      ];

      let currentPage = 1;
      let itemsPerPage = 10;
      let filteredData = inventoryData;

      // Initialize page
      document.addEventListener('DOMContentLoaded', function() {
          populateInventoryTable();
          initializeCharts();
          updateStats();
          setupEventListeners();
          populateLowStockModal();
      });

      function populateInventoryTable() {
          const tbody = document.getElementById('inventoryTableBody');
          tbody.innerHTML = '';

          const startIndex = (currentPage - 1) * itemsPerPage;
          const endIndex = startIndex + itemsPerPage;
          const pageData = filteredData.slice(startIndex, endIndex);

          pageData.forEach(item => {
              const row = tbody.insertRow();
              const totalValue = item.stock * item.price;

              row.innerHTML = `
                  <td>
                      <div class="product-info-cell">
                          <div class="product-icon">${item.icon}</div>
                          <div class="product-details">
                              <h4>${item.name}</h4>
                              <p>${item.description}</p>
                          </div>
                      </div>
                  </td>
                  <td>
                      <span class="category-badge">${item.categoryName}</span>
                  </td>
                  <td>${item.sku}</td>
                  <td>
                      <div class="stock-level ${item.stockLevel}">${item.stock}</div>
                      <div class="stock-bar">
                          <div class="stock-fill ${item.stockLevel}" style="width: ${Math.min((item.stock / item.minStock) * 100, 100)}%"></div>
                      </div>
                  </td>
                  <td>${item.minStock}</td>
                  <td>₱${item.price.toLocaleString()}</td>
                  <td>₱${totalValue.toLocaleString()}</td>
                  <td>
                      <button class="action-btn" onclick="window.location.href='./adjust-stock.php'">Adjust</button>
                      <button class="action-btn secondary" onclick="viewDetails(${item.id})">Details</button>
                      <button class="action-btn danger" onclick="deleteItem(${item.id})">Delete</button>
                  </td>
              `;
          });

          updatePaginationInfo();
      }

      function setupEventListeners() {
          // Search functionality
          document.getElementById('searchInput').addEventListener('input', function() {
              const searchTerm = this.value.toLowerCase();
              filteredData = inventoryData.filter(item =>
                  item.name.toLowerCase().includes(searchTerm) ||
                  item.sku.toLowerCase().includes(searchTerm) ||
                  item.description.toLowerCase().includes(searchTerm)
              );
              currentPage = 1;
              populateInventoryTable();
              updateStats();
          });

          // Category filter
          document.getElementById('categoryFilter').addEventListener('change', function() {
              const selectedCategory = this.value;
              filteredData = selectedCategory ?
                  inventoryData.filter(item => item.category === selectedCategory) :
                  inventoryData;
              currentPage = 1;
              populateInventoryTable();
              updateStats();
          });

          // Stock filter
          document.getElementById('stockFilter').addEventListener('change', function() {
              const selectedStock = this.value;
              filteredData = selectedStock ?
                  inventoryData.filter(item => item.stockLevel === selectedStock) :
                  inventoryData;
              currentPage = 1;
              populateInventoryTable();
              updateStats();
          });
      }

      function initializeCharts() {
          // Stock Levels Chart
          const stockCtx = document.getElementById('stockChart').getContext('2d');
          new Chart(stockCtx, {
              type: 'doughnut',
              data: {
                  labels: ['Office Supplies', 'School Supplies', 'Sanitary Supplies'],
                  datasets: [{
                      data: [
                          inventoryData.filter(item => item.category === 'office').reduce((sum, item) => sum + item.stock, 0),
                          inventoryData.filter(item => item.category === 'school').reduce((sum, item) => sum + item.stock, 0),
                          inventoryData.filter(item => item.category === 'sanitary').reduce((sum, item) => sum + item.stock, 0)
                      ],
                      backgroundColor: ['#3b82f6', '#10b981', '#f59e0b'],
                      borderWidth: 2,
                      borderColor: '#fff'
                  }]
              },
              options: {
                  responsive: true,
                  maintainAspectRatio: false,
                  plugins: {
                      legend: {
                          position: 'bottom'
                      }
                  }
              }
          });

          // Turnover Chart
          const turnoverCtx = document.getElementById('turnoverChart').getContext('2d');
          new Chart(turnoverCtx, {
              type: 'line',
              data: {
                  labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                  datasets: [{
                      label: 'Inventory Turnover',
                      data: [2.1, 2.8, 3.2, 2.9, 3.5, 3.8],
                      borderColor: '#1e40af',
                      backgroundColor: 'rgba(30, 64, 175, 0.1)',
                      tension: 0.4,
                      fill: true
                  }]
              },
              options: {
                  responsive: true,
                  maintainAspectRatio: false,
                  scales: {
                      y: {
                          beginAtZero: true,
                          grid: {
                              color: 'rgba(0, 0, 0, 0.1)'
                          }
                      },
                      x: {
                          grid: {
                              color: 'rgba(0, 0, 0, 0.1)'
                          }
                      }
                  },
                  plugins: {
                      legend: {
                          display: false
                      }
                  }
              }
          });
      }

      function updateStats() {
          const totalProducts = filteredData.length;
          const lowStockItems = filteredData.filter(item => item.stockLevel === 'low').length;
          const outOfStockItems = filteredData.filter(item => item.stock === 0).length;
          const totalValue = filteredData.reduce((sum, item) => sum + (item.stock * item.price), 0);

          // Update stat cards
          const statCards = document.querySelectorAll('.stat-card');
          if (statCards.length >= 4) {
              statCards[0].querySelector('.stat-value').textContent = totalProducts;
              statCards[1].querySelector('.stat-value').textContent = lowStockItems;
              statCards[2].querySelector('.stat-value').textContent = outOfStockItems;
              statCards[3].querySelector('.stat-value').textContent = `₱${Math.round(totalValue / 1000)}K`;
          }
      }

      function updatePaginationInfo() {
          const totalItems = filteredData.length;
          const startItem = (currentPage - 1) * itemsPerPage + 1;
          const endItem = Math.min(currentPage * itemsPerPage, totalItems);

          document.getElementById('startItem').textContent = startItem;
          document.getElementById('endItem').textContent = endItem;
          document.getElementById('totalItems').textContent = totalItems;
      }

      function populateLowStockModal() {
          const lowStockItems = inventoryData.filter(item => item.stockLevel === 'low');
          const lowStockList = document.getElementById('lowStockList');

          lowStockList.innerHTML = lowStockItems.map(item => `
              <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; border: 1px solid #e2e8f0; border-radius: 8px; margin-bottom: 1rem; background: #fef2f2;">
                  <div style="display: flex; align-items: center; gap: 1rem;">
                      <div style="font-size: 2rem;">${item.icon}</div>
                      <div>
                          <h4 style="color: #dc2626; margin-bottom: 0.25rem;">${item.name}</h4>
                          <p style="color: #64748b; font-size: 0.85rem;">Current: ${item.stock} | Min: ${item.minStock}</p>
                      </div>
                  </div>
                  <button class="btn btn-primary" onclick="quickReorder('${item.name}')">Quick Reorder</button>
              </div>
          `).join('');
      }

      // Modal functions
      function openAdjustStockModal(itemId = null) {
          const modal = document.getElementById('adjustStockModal');
          modal.classList.add('show');

          if (itemId) {
              document.getElementById('adjustProduct').value = itemId;
          }
      }

      function openBulkUpdateModal() {
          const modal = document.getElementById('bulkUpdateModal');
          modal.classList.add('show');
      }

      function openLowStockModal() {
          const modal = document.getElementById('lowStockModal');
          modal.classList.add('show');
      }

      function openStockMovementsModal() {
          const modal = document.getElementById('stockMovementsModal');
          modal.classList.add('show');
      }

      function closeModal(modalId) {
          const modal = document.getElementById(modalId);
          modal.classList.remove('show');
      }

      // Mobile sidebar toggle
      function toggleSidebar() {
          const sidebar = document.getElementById('sidebar');
          const dashboard = document.getElementById('dashboard');

          sidebar.classList.toggle('show');
          dashboard.classList.toggle('sidebar-open');
      }

      // Action functions
      function viewDetails(itemId) {
          const item = inventoryData.find(i => i.id === itemId);
          const modal = document.getElementById('productDetailsModal');
          const content = document.getElementById('productDetailsContent');

          content.innerHTML = `
              <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                  <div>
                      <div style="text-align: center; margin-bottom: 2rem;">
                          <div style="width: 100px; height: 100px; background: linear-gradient(135deg, #e0e7ff, #c7d2fe); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 3rem; margin: 0 auto 1rem;">${item.icon}</div>
                          <h3 style="color: #1e40af; margin-bottom: 0.5rem;">${item.name}</h3>
                          <p style="color: #64748b;">${item.description}</p>
                      </div>
                  </div>
                  <div>
                      <div style="background: #f8fafc; padding: 1.5rem; border-radius: 8px;">
                          <h4 style="margin-bottom: 1rem; color: #475569;">Product Information</h4>
                          <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                              <div style="display: flex; justify-content: space-between;">
                                  <span style="color: #64748b;">SKU:</span>
                                  <span style="font-weight: 600;">${item.sku}</span>
                              </div>
                              <div style="display: flex; justify-content: space-between;">
                                  <span style="color: #64748b;">Category:</span>
                                  <span style="font-weight: 600;">${item.categoryName}</span>
                              </div>
                              <div style="display: flex; justify-content: space-between;">
                                  <span style="color: #64748b;">Current Stock:</span>
                                  <span style="font-weight: 600; color: ${item.stockLevel === 'low' ? '#dc2626' : item.stockLevel === 'medium' ? '#d97706' : '#059669'};">${item.stock}</span>
                              </div>
                              <div style="display: flex; justify-content: space-between;">
                                  <span style="color: #64748b;">Minimum Stock:</span>
                                  <span style="font-weight: 600;">${item.minStock}</span>
                              </div>
                              <div style="display: flex; justify-content: space-between;">
                                  <span style="color: #64748b;">Unit Price:</span>
                                  <span style="font-weight: 600;">₱${item.price.toLocaleString()}</span>
                              </div>
                              <div style="display: flex; justify-content: space-between;">
                                  <span style="color: #64748b;">Total Value:</span>
                                  <span style="font-weight: 600; color: #1e40af;">₱${(item.stock * item.price).toLocaleString()}</span>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          `;

          modal.classList.add('show');
      }

      function deleteItem(itemId) {
          const item = inventoryData.find(i => i.id === itemId);
          if (confirm(`Are you sure you want to delete "${item.name}" from inventory?`)) {
              const index = inventoryData.findIndex(i => i.id === itemId);
              inventoryData.splice(index, 1);
              filteredData = inventoryData;
              populateInventoryTable();
              updateStats();
              showNotification('Item deleted successfully!', 'success');
          }
      }

      function filterByStatus(status) {
          if (status === 'all') {
              filteredData = inventoryData;
          } else if (status === 'out-of-stock') {
              filteredData = inventoryData.filter(item => item.stock === 0);
          } else {
              filteredData = inventoryData.filter(item => item.stockLevel === status);
          }

          currentPage = 1;
          populateInventoryTable();
          updateStats();
      }

      function changePage(page) {
          const totalPages = Math.ceil(filteredData.length / itemsPerPage);

          if (page === 'prev' && currentPage > 1) {
              currentPage--;
          } else if (page === 'next' && currentPage < totalPages) {
              currentPage++;
          } else if (typeof page === 'number' && page >= 1 && page <= totalPages) {
              currentPage = page;
          }

          populateInventoryTable();

          // Update active page button
          document.querySelectorAll('.page-btn').forEach(btn => {
              btn.classList.remove('active');
              if (btn.textContent == currentPage) {
                  btn.classList.add('active');
              }
          });
      }

      function exportReport() {
          // Create CSV content
          let csvContent = "Product Name,SKU,Category,Current Stock,Min Stock,Unit Price,Total Value\n";

          filteredData.forEach(item => {
              const totalValue = item.stock * item.price;
              csvContent += `"${item.name}",${item.sku},"${item.categoryName}",${item.stock},${item.minStock},${item.price},${totalValue}\n`;
          });

          // Create download link
          const blob = new Blob([csvContent], { type: 'text/csv' });
          const url = window.URL.createObjectURL(blob);
          const a = document.createElement('a');
          a.setAttribute('hidden', '');
          a.setAttribute('href', url);
          a.setAttribute('download', 'inventory_report_' + new Date().toISOString().split('T')[0] + '.csv');
          document.body.appendChild(a);
          a.click();
          document.body.removeChild(a);

          showNotification('Report exported successfully!', 'success');
      }

      function generateReport() {
          showNotification('Generating comprehensive inventory report...', 'info');
      }

      function quickReorder(product) {
          showNotification(`Reorder request sent for ${product}`, 'success');
      }

      function bulkReorder() {
          showNotification('Bulk reorder request sent for all low stock items', 'success');
      }

      function exportMovements() {
          showNotification('Stock movements exported successfully!', 'success');
      }

      function editProduct() {
          showNotification('Edit product functionality would open here', 'info');
      }

      function showNotification(message, type = 'info') {
          const notification = document.createElement('div');
          notification.style.cssText = `
              position: fixed;
              top: 2rem;
              right: 2rem;
              background: ${type === 'success' ? '#dcfce7' : type === 'error' ? '#fee2e2' : '#dbeafe'};
              color: ${type === 'success' ? '#166534' : type === 'error' ? '#dc2626' : '#1e40af'};
              padding: 1rem 1.5rem;
              border-radius: 8px;
              box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
              z-index: 3000;
              animation: slideInRight 0.3s ease;
              max-width: 300px;
          `;
          notification.textContent = message;

          document.body.appendChild(notification);

          setTimeout(() => {
              notification.remove();
          }, 3000);
      }

      // Form submissions
      document.getElementById('adjustStockForm').addEventListener('submit', function(e) {
          e.preventDefault();

          const productId = document.getElementById('adjustProduct').value;
          const type = document.getElementById('adjustType').value;
          const quantity = parseInt(document.getElementById('adjustQuantity').value);
          const reason = document.getElementById('adjustReason').value;

          if (!productId || !type || !quantity || !reason) {
              showNotification('Please fill in all fields', 'error');
              return;
          }

          const item = inventoryData.find(i => i.id == productId);
          let newStock;

          switch (type) {
              case 'add':
                  newStock = item.stock + quantity;
                  break;
              case 'remove':
                  newStock = Math.max(0, item.stock - quantity);
                  break;
              case 'set':
                  newStock = quantity;
                  break;
          }

          // Update the item
          item.stock = newStock;
          item.stockLevel = newStock <= item.minStock * 0.5 ? 'low' :
                           newStock <= item.minStock ? 'medium' : 'high';

          showNotification(`Stock adjustment applied successfully! ${item.name} stock updated to ${newStock}`, 'success');
          closeModal('adjustStockModal');
          populateInventoryTable();
          updateStats();
          populateLowStockModal();

          // Reset form
          this.reset();
      });

      document.getElementById('bulkUpdateForm').addEventListener('submit', function(e) {
          e.preventDefault();

          const category = document.getElementById('bulkCategory').value;
          const action = document.getElementById('bulkAction').value;
          const value = parseFloat(document.getElementById('bulkValue').value);

          if (!category || !action || !value) {
              showNotification('Please fill in all fields', 'error');
              return;
          }

          const itemsToUpdate = inventoryData.filter(item => item.category === category);
          let updatedCount = 0;

          itemsToUpdate.forEach(item => {
              switch (action) {
                  case 'increase':
                      item.stock = Math.round(item.stock * (1 + value / 100));
                      updatedCount++;
                      break;
                  case 'decrease':
                      item.stock = Math.round(item.stock * (1 - value / 100));
                      updatedCount++;
                      break;
                  case 'setMin':
                      item.minStock = value;
                      updatedCount++;
                      break;
              }

              // Update stock level
              item.stockLevel = item.stock <= item.minStock * 0.5 ? 'low' :
                               item.stock <= item.minStock ? 'medium' : 'high';
          });

          showNotification(`Bulk update completed! ${updatedCount} items updated successfully.`, 'success');
          closeModal('bulkUpdateModal');
          populateInventoryTable();
          updateStats();
          populateLowStockModal();

          // Reset form
          this.reset();
      });

      // Close modals when clicking outside
      window.addEventListener('click', function(e) {
          if (e.target.classList.contains('modal')) {
              e.target.classList.remove('show');
          }
      });

      // Keyboard shortcuts
      document.addEventListener('keydown', function(e) {
          if (e.ctrlKey && e.key === 'f') {
              e.preventDefault();
              document.getElementById('searchInput').focus();
          }
          if (e.key === 'Escape') {
              // Close any open modals
              document.querySelectorAll('.modal.show').forEach(modal => {
                  modal.classList.remove('show');
              });
          }
      });

      // Initialize tooltips and additional functionality
      setTimeout(() => {
          // Add hover effects to action buttons
          document.querySelectorAll('.action-btn').forEach(btn => {
              btn.addEventListener('mouseenter', function() {
                  this.style.transform = 'translateY(-1px)';
              });
              btn.addEventListener('mouseleave', function() {
                  this.style.transform = 'translateY(0)';
              });
          });

          // Add click animation to buttons
          document.querySelectorAll('button').forEach(btn => {
              btn.addEventListener('click', function() {
                  this.style.transform = 'scale(0.98)';
                  setTimeout(() => {
                      this.style.transform = '';
                  }, 100);
              });
          });

          // Auto-refresh data every 30 seconds (simulate real-time updates)
          setInterval(() => {
              // This would typically fetch fresh data from an API
              updateStats();
          }, 30000);
      }, 1000);

      // Export functions for external use
      window.inventorySystem = {
          getData: () => inventoryData,
          updateItem: (id, updates) => {
              const item = inventoryData.find(i => i.id === id);
              if (item) {
                  Object.assign(item, updates);
                  populateInventoryTable();
                  updateStats();
                  return true;
              }
              return false;
          },
          addItem: (newItem) => {
              const maxId = Math.max(...inventoryData.map(i => i.id));
              newItem.id = maxId + 1;
              inventoryData.push(newItem);
              populateInventoryTable();
              updateStats();
              return newItem.id;
          },
          searchItems: (query) => {
              return inventoryData.filter(item =>
                  item.name.toLowerCase().includes(query.toLowerCase()) ||
                  item.sku.toLowerCase().includes(query.toLowerCase())
              );
          }
      };
  </script>
