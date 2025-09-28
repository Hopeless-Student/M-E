<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Low Stock Alerts - M & E Dashboard</title>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <style>
        /* Base styles */
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
            width: 250px;
            height: 250px;
        }

        .low-stock-alerts-dashboard {
            display: flex;
            min-height: 100vh;
        }

        /* Main Content */
        .low-stock-alerts-main-content {
            flex: 1;
            padding: 2rem;
            margin-left: 280px; /* Adjust if sidebar is not present or different width */
        }

        .low-stock-alerts-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            background: white;
            padding: 1.5rem 2rem;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .low-stock-alerts-header h2 {
            font-size: 2rem;
            font-weight: 600;
            color: #dc2626;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .low-stock-alerts-header-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .low-stock-alerts-back-btn {
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

        .low-stock-alerts-back-btn:hover {
            background: #475569;
            color: white;
        }

        .low-stock-alerts-refresh-btn {
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

        .low-stock-alerts-refresh-btn:hover {
            background: #1e3a8a;
        }

        .low-stock-alerts-user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .low-stock-alerts-avatar {
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
        .low-stock-alerts-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .low-stock-alerts-summary-card {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border-left: 4px solid;
            position: relative;
        }

        .low-stock-alerts-summary-card.critical {
            border-left-color: #dc2626;
        }

        .low-stock-alerts-summary-card.warning {
            border-left-color: #d97706;
        }

        .low-stock-alerts-summary-card.info {
            border-left-color: #1e40af;
        }

        .low-stock-alerts-summary-title {
            font-size: 0.9rem;
            color: #64748b;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .low-stock-alerts-summary-value {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .low-stock-alerts-summary-card.critical .low-stock-alerts-summary-value {
            color: #dc2626;
        }

        .low-stock-alerts-summary-card.warning .low-stock-alerts-summary-value {
            color: #d97706;
        }

        .low-stock-alerts-summary-card.info .low-stock-alerts-summary-value {
            color: #1e40af;
        }

        .low-stock-alerts-summary-subtitle {
            font-size: 0.8rem;
            color: #64748b;
        }

        .low-stock-alerts-summary-icon {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            font-size: 2rem;
            opacity: 0.3;
        }

        /* Quick Actions */
        .low-stock-alerts-quick-actions {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .low-stock-alerts-actions-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 1rem;
        }

        .low-stock-alerts-actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .low-stock-alerts-action-btn {
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

        .low-stock-alerts-action-btn:hover {
            border-color: #1e40af;
            background: #f8fafc;
            color: #1e40af;
        }

        .low-stock-alerts-action-btn.primary {
            background: #1e40af;
            border-color: #1e40af;
            color: white;
        }

        .low-stock-alerts-action-btn.primary:hover {
            background: #1e3a8a;
        }

        /* Alerts Table */
        .low-stock-alerts-alerts-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .low-stock-alerts-section-header {
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
            color: white;
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .low-stock-alerts-section-title {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .low-stock-alerts-controls {
            display: flex;
            gap: 1rem;
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #e2e8f0;
            background: #f8fafc;
        }

        .low-stock-alerts-search-box {
            position: relative;
            flex: 1;
        }

        .low-stock-alerts-search-input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 0.9rem;
        }

        .low-stock-alerts-search-box::before {
            content: '🔍';
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
        }

        .low-stock-alerts-filter-select {
            padding: 0.75rem 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            background: white;
            font-size: 0.9rem;
            min-width: 150px;
        }

        .low-stock-alerts-alerts-table {
            width: 100%;
            border-collapse: collapse;
        }

        .low-stock-alerts-alerts-table th {
            background-color: #f8fafc;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #475569;
            font-size: 0.9rem;
            border-bottom: 2px solid #e2e8f0;
        }

        .low-stock-alerts-alerts-table td {
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .low-stock-alerts-alerts-table tr:hover {
            background-color: #fef2f2;
        }

        .low-stock-alerts-product-cell {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .low-stock-alerts-product-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .low-stock-alerts-product-info h4 {
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 0.25rem;
        }

        .low-stock-alerts-product-info p {
            font-size: 0.85rem;
            color: #64748b;
        }

        .low-stock-alerts-alert-level {
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .low-stock-alerts-alert-level.critical {
            background: #fee2e2;
            color: #991b1b;
        }

        .low-stock-alerts-alert-level.warning {
            background: #fef3c7;
            color: #92400e;
        }

        .low-stock-alerts-alert-level.low {
            background: #e0e7ff;
            color: #1e40af;
        }

        .low-stock-alerts-stock-info {
            text-align: center;
        }

        .low-stock-alerts-current-stock {
            font-size: 1.2rem;
            font-weight: 700;
            color: #dc2626;
        }

        .low-stock-alerts-min-stock {
            font-size: 0.85rem;
            color: #64748b;
        }

        .low-stock-alerts-stock-progress {
            width: 100px;
            height: 8px;
            background: #fee2e2;
            border-radius: 4px;
            overflow: hidden;
            margin: 0.5rem auto;
        }

        .low-stock-alerts-stock-fill {
            height: 100%;
            background: #dc2626;
            border-radius: 4px;
            transition: width 0.3s ease;
        }

        .low-stock-alerts-days-supply {
            font-weight: 600;
            text-align: center;
        }

        .low-stock-alerts-days-supply.critical {
            color: #dc2626;
        }

        .low-stock-alerts-days-supply.warning {
            color: #d97706;
        }

        .low-stock-alerts-action-buttons {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .low-stock-alerts-btn-sm {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.8rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .low-stock-alerts-btn-primary {
            background: #1e40af;
            color: white;
        }

        .low-stock-alerts-btn-primary:hover {
            background: #1e3a8a;
        }

        .low-stock-alerts-btn-secondary {
            background: #64748b;
            color: white;
        }

        .low-stock-alerts-btn-secondary:hover {
            background: #475569;
        }

        /* Pagination */
        .low-stock-alerts-pagination {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 2rem;
            border-top: 1px solid #e2e8f0;
        }

        .low-stock-alerts-pagination-info {
            color: #64748b;
            font-size: 0.9rem;
        }

        .low-stock-alerts-pagination-controls {
            display: flex;
            gap: 0.5rem;
        }

        .low-stock-alerts-page-btn {
            padding: 0.5rem 1rem;
            border: 1px solid #d1d5db;
            background: white;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .low-stock-alerts-page-btn:hover {
            background-color: #1e40af;
            color: white;
        }

        .low-stock-alerts-page-btn.active {
            background-color: #1e40af;
            color: white;
            border-color: #1e40af;
        }

        /* Modal Base Styles */
        .low-stock-alerts-modal-base {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            animation: lowStockAlertsFadeIn 0.3s ease;
        }

        .low-stock-alerts-modal-base.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @keyframes lowStockAlertsFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .low-stock-alerts-modal-content {
            background-color: white;
            padding: 2rem;
            border-radius: 12px;
            width: 90%;
            max-width: 600px;
            max-height: 80vh;
            overflow-y: auto;
            animation: lowStockAlertsSlideIn 0.3s ease;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);
        }

        @keyframes lowStockAlertsSlideIn {
            from { transform: translateY(-30px) scale(0.95); opacity: 0; }
            to { transform: translateY(0) scale(1); opacity: 1; }
        }

        .low-stock-alerts-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e2e8f0;
        }

        .low-stock-alerts-modal-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1e40af;
        }

        .low-stock-alerts-modal-close-btn {
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

        .low-stock-alerts-modal-close-btn:hover {
            color: #1e40af;
            background: #f1f5f9;
        }

        .low-stock-alerts-form-group {
            margin-bottom: 1.5rem;
        }

        .low-stock-alerts-form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #475569;
        }

        .low-stock-alerts-form-input, .low-stock-alerts-form-select, .low-stock-alerts-form-textarea {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .low-stock-alerts-form-textarea {
            resize: vertical;
            min-height: 100px;
        }

        .low-stock-alerts-form-input:focus, .low-stock-alerts-form-select:focus, .low-stock-alerts-form-textarea:focus {
            outline: none;
            border-color: #1e40af;
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
        }

        .low-stock-alerts-form-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px solid #e2e8f0;
        }

        .low-stock-alerts-btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s;
        }

        .low-stock-alerts-btn-primary {
            background: #1e40af;
            color: white;
        }

        .low-stock-alerts-btn-primary:hover {
            background: #1e3a8a;
        }

        .low-stock-alerts-btn-secondary {
            background: #e2e8f0;
            color: #475569;
        }

        .low-stock-alerts-btn-secondary:hover {
            background: #cbd5e1;
        }

        .low-stock-alerts-btn-warning {
            background: #d97706;
            color: white;
        }

        .low-stock-alerts-btn-warning:hover {
            background: #b45309;
        }

        .low-stock-alerts-btn-success {
            background: #059669;
            color: white;
        }

        .low-stock-alerts-btn-success:hover {
            background: #047857;
        }

        .low-stock-alerts-modal-section {
            margin-bottom: 2rem;
        }

        .low-stock-alerts-modal-section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .low-stock-alerts-item-list {
            max-height: 300px;
            overflow-y: auto;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
        }

        .low-stock-alerts-item-entry {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid #f3f4f6;
        }

        .low-stock-alerts-item-entry:last-child {
            border-bottom: none;
        }

        .low-stock-alerts-item-info {
            flex: 1;
        }

        .low-stock-alerts-item-name {
            font-weight: 500;
            color: #374151;
        }

        .low-stock-alerts-item-details {
            font-size: 0.8rem;
            color: #6b7280;
        }

        .low-stock-alerts-quantity-input {
            width: 80px;
            text-align: center;
            padding: 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: 6px;
        }

        .low-stock-alerts-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .low-stock-alerts-info-card {
            background: #f8fafc;
            padding: 1rem;
            border-radius: 8px;
            border-left: 3px solid #1e40af;
        }

        .low-stock-alerts-info-label {
            font-size: 0.8rem;
            color: #64748b;
            margin-bottom: 0.25rem;
        }

        .low-stock-alerts-info-value {
            font-weight: 600;
            color: #1e40af;
        }

        /* Specific Modal Overrides/Additions */
        #bulkRestockModal .low-stock-alerts-modal-title .lucide { color: white; }
        #individualRestockModal .low-stock-alerts-modal-title .lucide { color: white; }
        #adjustStockModal .low-stock-alerts-modal-title .lucide { color: white; }
        #minimumLevelsModal .low-stock-alerts-modal-title .lucide { color: white; }
        #emailAlertsModal .low-stock-alerts-modal-title .lucide { color: white; }

        /* Notification styles */
        .low-stock-alerts-notification {
            position: fixed;
            top: 2rem;
            right: 2rem;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            z-index: 3000;
            max-width: 300px;
            opacity: 0;
            transform: translateY(-20px);
            transition: opacity 0.3s ease-out, transform 0.3s ease-out;
        }

        .low-stock-alerts-notification.show {
            opacity: 1;
            transform: translateY(0);
        }

        .low-stock-alerts-notification.success {
            background: #dcfce7;
            color: #166534;
        }

        .low-stock-alerts-notification.error {
            background: #fee2e2;
            color: #dc2626;
        }

        .low-stock-alerts-notification.info {
            background: #dbeafe;
            color: #1e40af;
        }


        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: static;
                height: auto;
            }

            .low-stock-alerts-main-content {
                margin-left: 0;
            }

            .low-stock-alerts-dashboard {
                flex-direction: column;
            }

            .low-stock-alerts-summary {
                grid-template-columns: 1fr;
            }

            .low-stock-alerts-actions-grid {
                grid-template-columns: 1fr;
            }

            .low-stock-alerts-controls {
                flex-direction: column;
            }

            .low-stock-alerts-action-buttons {
                justify-content: center;
            }

            .low-stock-alerts-info-grid {
                grid-template-columns: 1fr;
            }

            .low-stock-alerts-modal-content {
                max-width: 95vw;
                margin: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="low-stock-alerts-dashboard">
        <!-- Sidebar -->
        <?php include '../../includes/admin_sidebar.php' ?>

        <!-- Main Content -->
        <main class="low-stock-alerts-main-content">
            <div class="low-stock-alerts-header">
                <h2><i data-lucide="siren" style="width:45px; height:50px;"></i> Low Stock Alerts</h2>
                <div class="low-stock-alerts-header-actions">
                    <button class="low-stock-alerts-refresh-btn" onclick="refreshLowStockAlerts()">
                        <span data-lucide="rotate-cw"></span> Refresh
                    </button>
                    <a href="index.php" class="low-stock-alerts-back-btn">
                        <span data-lucide="arrow-left"></span> Back to Inventory
                    </a>
                    <div class="low-stock-alerts-user-info">
                        <span>Admin Panel</span>
                        <div class="low-stock-alerts-avatar">A</div>
                    </div>
                </div>
            </div>

            <!-- Alert Summary -->
            <div class="low-stock-alerts-summary">
                <div class="low-stock-alerts-summary-card critical">
                    <div class="low-stock-alerts-summary-icon"><i data-lucide="siren" style="width:55px; height:60px; color:red;"></i></div>
                    <div class="low-stock-alerts-summary-title">Critical Alerts</div>
                    <div class="low-stock-alerts-summary-value" id="criticalAlertsCount">3</div>
                    <div class="low-stock-alerts-summary-subtitle">Out of stock</div>
                </div>
                <div class="low-stock-alerts-summary-card warning">
                    <div class="low-stock-alerts-summary-icon"><i data-lucide="triangle-alert" style="width:55px; height:60px; color: orange;"></i></div>
                    <div class="low-stock-alerts-summary-title">Warning Alerts</div>
                    <div class="low-stock-alerts-summary-value" id="warningAlertsCount">9</div>
                    <div class="low-stock-alerts-summary-subtitle">Below minimum stock</div>
                </div>
                <div class="low-stock-alerts-summary-card info">
                    <div class="low-stock-alerts-summary-icon"><i data-lucide="chart-no-axes-column-increasing" style="width:55px; height:60px; color: #4169e1;"></i></div>
                    <div class="low-stock-alerts-summary-title">Total Items</div>
                    <div class="low-stock-alerts-summary-value" id="totalAlertItemsCount">12</div>
                    <div class="low-stock-alerts-summary-subtitle">Requiring attention</div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="low-stock-alerts-quick-actions">
                <h3 class="low-stock-alerts-actions-title">Quick Actions</h3>
                <div class="low-stock-alerts-actions-grid">
                    <button class="low-stock-alerts-action-btn primary" onclick="openBulkRestockModal()">
                        <span data-lucide="package-plus"></span> Create Bulk Restock Request
                    </button>
                    <button class="low-stock-alerts-action-btn" onclick="openMinimumLevelsModal()">
                        <span data-lucide="ruler" style="color:black"></span> Adjust Min Levels
                    </button>
                    <button class="low-stock-alerts-action-btn" onclick="exportLowStockReport()">
                        <span data-lucide="download"></span> Export Report
                    </button>
                    <button class="low-stock-alerts-action-btn" onclick="openEmailAlertsModal()">
                        <span data-lucide="mail"></span> Send Email Alerts
                    </button>
                </div>
            </div>

            <!-- Alerts Table -->
            <div class="low-stock-alerts-alerts-section">
                <div class="low-stock-alerts-section-header">
                    <h3 class="low-stock-alerts-section-title">Low Stock Items</h3>
                    <span id="lowStockAlertsCount">12 items need attention</span>
                </div>

                <div class="low-stock-alerts-controls">
                    <div class="low-stock-alerts-search-box">
                        <input type="text" class="low-stock-alerts-search-input" placeholder="Search products..." id="lowStockSearchInput">
                    </div>
                    <select class="low-stock-alerts-filter-select" id="lowStockCategoryFilter">
                        <option value="">All Categories</option>
                        <option value="office">Office Supplies</option>
                        <option value="school">School Supplies</option>
                        <option value="sanitary">Sanitary Supplies</option>
                    </select>
                    <select class="low-stock-alerts-filter-select" id="lowStockAlertLevelFilter">
                        <option value="">All Alert Levels</option>
                        <option value="critical">Critical</option>
                        <option value="warning">Warning</option>
                        <option value="low">Low</option>
                    </select>
                </div>

                <table class="low-stock-alerts-alerts-table">
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
                    <tbody id="lowStockAlertsTableBody">
                        <!-- Alert data will be populated here -->
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="low-stock-alerts-pagination">
                    <div class="low-stock-alerts-pagination-info">
                        Showing <span id="lowStockStartItem">1</span>-<span id="lowStockEndItem">12</span> of <span id="lowStockTotalAlerts">12</span> alerts
                    </div>
                    <div class="low-stock-alerts-pagination-controls">
                        <button class="low-stock-alerts-page-btn" id="lowStockPrevBtn" onclick="changeLowStockAlertsPage('prev')">Previous</button>
                        <div id="lowStockPageNumbers"></div>
                        <button class="low-stock-alerts-page-btn" id="lowStockNextBtn" onclick="changeLowStockAlertsPage('next')">Next</button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Bulk Restock Modal -->
    <div id="bulkRestockModal" class="low-stock-alerts-modal-base">
        <div class="low-stock-alerts-modal-content">
            <div class="low-stock-alerts-modal-header">
                <h3 class="low-stock-alerts-modal-title">📦 Create Bulk Restock Request</h3>
                <button class="low-stock-alerts-modal-close-btn" onclick="closeBulkRestockModal()">&times;</button>
            </div>
            <form id="bulkRestockForm">
                <div class="low-stock-alerts-modal-section">
                    <div class="low-stock-alerts-modal-section-title">Request Details</div>
                    <div class="low-stock-alerts-form-group">
                        <label class="low-stock-alerts-form-label">Request Priority</label>
                        <select class="low-stock-alerts-form-select" id="bulkRestockRequestPriority" required>
                            <option value="urgent">Urgent (Within 24 hours)</option>
                            <option value="high">High Priority (2-3 days)</option>
                            <option value="normal">Normal (1 week)</option>
                        </select>
                    </div>
                    <div class="low-stock-alerts-form-group">
                        <label class="low-stock-alerts-form-label">Requested By</label>
                        <input type="text" class="low-stock-alerts-form-input" id="bulkRestockRequestedBy" value="Admin User" readonly>
                    </div>
                    <div class="low-stock-alerts-form-group">
                        <label class="low-stock-alerts-form-label">Department</label>
                        <select class="low-stock-alerts-form-select" id="bulkRestockDepartment" required>
                            <option value="inventory">Inventory Management</option>
                            <option value="purchasing">Purchasing Department</option>
                            <option value="operations">Operations</option>
                        </select>
                    </div>
                </div>

                <div class="low-stock-alerts-modal-section">
                    <div class="low-stock-alerts-modal-section-title">Items to Restock</div>
                    <div class="low-stock-alerts-item-list" id="bulkRestockItemsList">
                        <!-- Items will be populated here -->
                    </div>
                </div>

                <div class="low-stock-alerts-modal-section">
                    <div class="low-stock-alerts-modal-section-title">Additional Notes</div>
                    <div class="low-stock-alerts-form-group">
                        <label class="low-stock-alerts-form-label">Special Instructions</label>
                        <textarea class="low-stock-alerts-form-textarea" id="bulkRestockNotes" placeholder="Any special handling requirements or notes..."></textarea>
                    </div>
                </div>

                <div class="low-stock-alerts-form-actions">
                    <button type="button" class="low-stock-alerts-btn low-stock-alerts-btn-secondary" onclick="closeBulkRestockModal()">Cancel</button>
                    <button type="submit" class="low-stock-alerts-btn low-stock-alerts-btn-primary">Submit Restock Request</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Individual Restock Modal -->
    <div id="individualRestockModal" class="low-stock-alerts-modal-base">
        <div class="low-stock-alerts-modal-content">
            <div class="low-stock-alerts-modal-header">
                <h3 class="low-stock-alerts-modal-title">🔄 Restock Item</h3>
                <button class="low-stock-alerts-modal-close-btn" onclick="closeIndividualRestockModal()">&times;</button>
            </div>
            <form id="individualRestockForm">
                <div class="low-stock-alerts-modal-section">
                    <div class="low-stock-alerts-modal-section-title">Product Information</div>
                    <div class="low-stock-alerts-info-grid">
                        <div class="low-stock-alerts-info-card">
                            <div class="low-stock-alerts-info-label">Product Name</div>
                            <div class="low-stock-alerts-info-value" id="individualRestockProductName">-</div>
                        </div>
                        <div class="low-stock-alerts-info-card">
                            <div class="low-stock-alerts-info-label">Current Stock</div>
                            <div class="low-stock-alerts-info-value" id="individualRestockCurrentStock">-</div>
                        </div>
                        <div class="low-stock-alerts-info-card">
                            <div class="low-stock-alerts-info-label">Minimum Stock</div>
                            <div class="low-stock-alerts-info-value" id="individualRestockMinStock">-</div>
                        </div>
                        <div class="low-stock-alerts-info-card">
                            <div class="low-stock-alerts-info-label">Recommended Qty</div>
                            <div class="low-stock-alerts-info-value" id="individualRestockRecommended">-</div>
                        </div>
                    </div>
                </div>

                <div class="low-stock-alerts-modal-section">
                    <div class="low-stock-alerts-modal-section-title">Restock Details</div>
                    <div class="low-stock-alerts-form-group">
                        <label class="low-stock-alerts-form-label">Restock Quantity</label>
                        <input type="number" class="low-stock-alerts-form-input" id="individualRestockQuantity" min="1" required>
                    </div>
                    <div class="low-stock-alerts-form-group">
                        <label class="low-stock-alerts-form-label">Priority Level</label>
                        <select class="low-stock-alerts-form-select" id="individualRestockPriority" required>
                            <option value="urgent">Urgent - Critical Stock</option>
                            <option value="high">High Priority</option>
                            <option value="normal">Normal Priority</option>
                        </select>
                    </div>
                    <div class="low-stock-alerts-form-group">
                        <label class="low-stock-alerts-form-label">Reason for Restock</label>
                        <select class="low-stock-alerts-form-select" id="individualRestockReason" required>
                            <option value="low_stock">Below Minimum Stock Level</option>
                            <option value="out_of_stock">Out of Stock</option>
                            <option value="high_demand">High Demand Expected</option>
                            <option value="seasonal">Seasonal Preparation</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="low-stock-alerts-form-group">
                        <label class="low-stock-alerts-form-label">Notes</label>
                        <textarea class="low-stock-alerts-form-textarea" id="individualRestockItemNotes" placeholder="Additional notes or special requirements..."></textarea>
                    </div>
                </div>

                <div class="low-stock-alerts-form-actions">
                    <button type="button" class="low-stock-alerts-btn low-stock-alerts-btn-secondary" onclick="closeIndividualRestockModal()">Cancel</button>
                    <button type="submit" class="low-stock-alerts-btn low-stock-alerts-btn-primary">Submit Restock Request</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Adjust Stock Modal -->
    <div id="adjustStockModal" class="low-stock-alerts-modal-base">
        <div class="low-stock-alerts-modal-content">
            <div class="low-stock-alerts-modal-header">
                <h3 class="low-stock-alerts-modal-title">📝 Adjust Stock Level</h3>
                <button class="low-stock-alerts-modal-close-btn" onclick="closeAdjustStockModal()">&times;</button>
            </div>
            <form id="adjustStockModalForm">
                <div class="low-stock-alerts-modal-section">
                    <div class="low-stock-alerts-modal-section-title">Product Information</div>
                    <div class="low-stock-alerts-info-grid">
                        <div class="low-stock-alerts-info-card">
                            <div class="low-stock-alerts-info-label">Product Name</div>
                            <div class="low-stock-alerts-info-value" id="adjustStockModalProductName">-</div>
                        </div>
                        <div class="low-stock-alerts-info-card">
                            <div class="low-stock-alerts-info-label">Current Stock</div>
                            <div class="low-stock-alerts-info-value" id="adjustStockModalCurrentStock">-</div>
                        </div>
                    </div>
                </div>

                <div class="low-stock-alerts-modal-section">
                    <div class="low-stock-alerts-modal-section-title">Stock Adjustment</div>
                    <div class="low-stock-alerts-form-group">
                        <label class="low-stock-alerts-form-label">Adjustment Type</label>
                        <select class="low-stock-alerts-form-select" id="adjustStockModalAdjustmentType" required>
                            <option value="add">Add Stock (+)</option>
                            <option value="remove">Remove Stock (-)</option>
                            <option value="set">Set Exact Amount</option>
                        </select>
                    </div>
                    <div class="low-stock-alerts-form-group">
                        <label class="low-stock-alerts-form-label">Quantity</label>
                        <input type="number" class="low-stock-alerts-form-input" id="adjustStockModalQuantity" min="0" required>
                    </div>
                    <div class="low-stock-alerts-form-group">
                        <label class="low-stock-alerts-form-label">Reason for Adjustment</label>
                        <select class="low-stock-alerts-form-select" id="adjustStockModalReason" required>
                            <option value="recount">Physical Recount</option>
                            <option value="damaged">Damaged Items</option>
                            <option value="expired">Expired Items</option>
                            <option value="found">Items Found</option>
                            <option value="transfer">Transfer Between Locations</option>
                            <option value="correction">Data Correction</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="low-stock-alerts-form-group">
                        <label class="low-stock-alerts-form-label">Notes</label>
                        <textarea class="low-stock-alerts-form-textarea" id="adjustStockModalNotes" placeholder="Detailed explanation for this adjustment..." required></textarea>
                    </div>
                </div>

                <div class="low-stock-alerts-form-actions">
                    <button type="button" class="low-stock-alerts-btn low-stock-alerts-btn-secondary" onclick="closeAdjustStockModal()">Cancel</button>
                    <button type="submit" class="low-stock-alerts-btn low-stock-alerts-btn-warning">Apply Adjustment</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Minimum Levels Modal -->
    <div id="minimumLevelsModal" class="low-stock-alerts-modal-base">
        <div class="low-stock-alerts-modal-content">
            <div class="low-stock-alerts-modal-header">
                <h3 class="low-stock-alerts-modal-title">📏 Adjust Minimum Stock Levels</h3>
                <button class="low-stock-alerts-modal-close-btn" onclick="closeMinimumLevelsModal()">&times;</button>
            </div>
            <div class="low-stock-alerts-modal-section">
                <div class="low-stock-alerts-modal-section-title">Bulk Adjustment Options</div>
                <div class="low-stock-alerts-form-group">
                    <label class="low-stock-alerts-form-label">Adjustment Method</label>
                    <select class="low-stock-alerts-form-select" id="minimumLevelsBulkAdjustMethod">
                        <option value="percentage">Percentage Increase/Decrease</option>
                        <option value="fixed">Fixed Amount Increase/Decrease</option>
                        <option value="individual">Individual Item Adjustment</option>
                    </select>
                </div>
                <div class="low-stock-alerts-form-group" id="minimumLevelsPercentageGroup">
                    <label class="low-stock-alerts-form-label">Percentage Change (%)</label>
                    <input type="number" class="low-stock-alerts-form-input" id="minimumLevelsPercentageChange" placeholder="e.g., 20 for 20% increase, -10 for 10% decrease">
                </div>
                <div class="low-stock-alerts-form-group" id="minimumLevelsFixedGroup" style="display:none;">
                    <label class="low-stock-alerts-form-label">Fixed Amount Change</label>
                    <input type="number" class="low-stock-alerts-form-input" id="minimumLevelsFixedChange" placeholder="e.g., 5 to add 5 to each minimum, -3 to subtract 3">
                </div>
            </div>

            <div class="low-stock-alerts-modal-section" id="minimumLevelsIndividualAdjustSection" style="display:none;">
                <div class="low-stock-alerts-modal-section-title">Individual Adjustments</div>
                <div class="low-stock-alerts-item-list" id="minimumLevelsList">
                    <!-- Items will be populated here -->
                </div>
            </div>

            <div class="low-stock-alerts-form-actions">
                <button type="button" class="low-stock-alerts-btn low-stock-alerts-btn-secondary" onclick="closeMinimumLevelsModal()">Cancel</button>
                <button type="button" class="low-stock-alerts-btn low-stock-alerts-btn-primary" onclick="applyMinimumLevelChanges()">Apply Changes</button>
            </div>
        </div>
    </div>

    <!-- Email Alerts Modal -->
    <div id="emailAlertsModal" class="low-stock-alerts-modal-base">
        <div class="low-stock-alerts-modal-content">
            <div class="low-stock-alerts-modal-header">
                <h3 class="low-stock-alerts-modal-title">📧 Send Email Alerts</h3>
                <button class="low-stock-alerts-modal-close-btn" onclick="closeEmailAlertsModal()">&times;</button>
            </div>
            <form id="emailAlertsForm">
                <div class="low-stock-alerts-modal-section">
                    <div class="low-stock-alerts-modal-section-title">Recipients</div>
                    <div class="low-stock-alerts-form-group">
                        <label class="low-stock-alerts-form-label">
                            <input type="checkbox" id="emailAlertsManagersCheckbox" checked>
                            All Managers (3 recipients)
                        </label>
                    </div>
                    <div class="low-stock-alerts-form-group">
                        <label class="low-stock-alerts-form-label">
                            <input type="checkbox" id="emailAlertsPurchasingCheckbox" checked>
                            Purchasing Department (2 recipients)
                        </label>
                    </div>
                    <div class="low-stock-alerts-form-group">
                        <label class="low-stock-alerts-form-label">
                            <input type="checkbox" id="emailAlertsInventoryCheckbox">
                            Inventory Team (4 recipients)
                        </label>
                    </div>
                    <div class="low-stock-alerts-form-group">
                        <label class="low-stock-alerts-form-label">Additional Recipients</label>
                        <textarea class="low-stock-alerts-form-textarea" id="emailAlertsAdditionalEmails" placeholder="Enter additional email addresses, separated by commas..."></textarea>
                    </div>
                </div>

                <div class="low-stock-alerts-modal-section">
                    <div class="low-stock-alerts-modal-section-title">Alert Settings</div>
                    <div class="low-stock-alerts-form-group">
                        <label class="low-stock-alerts-form-label">Alert Level Filter</label>
                        <select class="low-stock-alerts-form-select" id="emailAlertsEmailAlertLevel">
                            <option value="all">All Alert Levels</option>
                            <option value="critical">Critical Only</option>
                            <option value="critical_warning">Critical & Warning</option>
                        </select>
                    </div>
                    <div class="low-stock-alerts-form-group">
                        <label class="low-stock-alerts-form-label">Email Format</label>
                        <select class="low-stock-alerts-form-select" id="emailAlertsEmailFormat">
                            <option value="summary">Summary Report</option>
                            <option value="detailed">Detailed Report</option>
                            <option value="both">Both Summary & Detailed</option>
                        </select>
                    </div>
                    <div class="low-stock-alerts-form-group">
                        <label class="low-stock-alerts-form-label">
                            <input type="checkbox" id="emailAlertsIncludeActions">
                            Include Suggested Actions
                        </label>
                    </div>
                </div>

                <div class="low-stock-alerts-modal-section">
                    <div class="low-stock-alerts-modal-section-title">Custom Message</div>
                    <div class="low-stock-alerts-form-group">
                        <label class="low-stock-alerts-form-label">Additional Message (Optional)</label>
                        <textarea class="low-stock-alerts-form-textarea" id="emailAlertsCustomMessage" placeholder="Add any additional context or instructions..."></textarea>
                    </div>
                </div>

                <div class="low-stock-alerts-form-actions">
                    <button type="button" class="low-stock-alerts-btn low-stock-alerts-btn-secondary" onclick="closeEmailAlertsModal()">Cancel</button>
                    <button type="submit" class="low-stock-alerts-btn low-stock-alerts-btn-success">Send Alerts</button>
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
        let currentLowStockPage = 1;
        const lowStockItemsPerPage = 10;
        let filteredLowStockData = [...lowStockData];

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            populateLowStockAlertsTable(filteredLowStockData);
            updateLowStockSummaryCards();
            setupLowStockAlertsEventListeners();
            setupLowStockAlertsModalClickOutside(); // Setup click outside for modals in this file
        });

        function populateLowStockAlertsTable(data) {
            const tbody = document.getElementById('lowStockAlertsTableBody');
            tbody.innerHTML = '';

            const startIndex = (currentLowStockPage - 1) * lowStockItemsPerPage;
            const endIndex = startIndex + lowStockItemsPerPage;
            const pageData = data.slice(startIndex, endIndex);

            if (pageData.length === 0) {
                tbody.innerHTML = `<tr><td colspan="7" style="text-align: center; padding: 2rem; color: #64748b;">No low stock items found matching your criteria.</td></tr>`;
                updateLowStockPagination(data.length);
                return;
            }

            pageData.forEach(item => {
                const row = tbody.insertRow();
                const stockPercentage = (item.currentStock / item.minStock) * 100;

                row.innerHTML = `
                    <td>
                        <div class="low-stock-alerts-product-cell">
                            <div class="low-stock-alerts-product-icon">${item.icon}</div>
                            <div class="low-stock-alerts-product-info">
                                <h4>${item.name}</h4>
                                <p>${item.sku}</p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="low-stock-alerts-alert-level ${item.alertLevel}">${capitalizeFirst(item.alertLevel)}</span>
                    </td>
                    <td>
                        <div class="low-stock-alerts-stock-info">
                            <div class="low-stock-alerts-current-stock">${item.currentStock}</div>
                            <div class="low-stock-alerts-min-stock">Min: ${item.minStock}</div>
                            <div class="low-stock-alerts-stock-progress">
                                <div class="low-stock-alerts-stock-fill" style="width: ${Math.min(stockPercentage, 100)}%"></div>
                            </div>
                        </div>
                    </td>
                    <td>${stockPercentage.toFixed(0)}%</td>
                    <td>
                        <div class="low-stock-alerts-days-supply ${item.daysSupply <= 3 ? 'critical' : item.daysSupply <= 7 ? 'warning' : ''}">
                            ${item.daysSupply} days
                        </div>
                    </td>
                    <td>${formatDate(item.lastRestock)}</td>
                    <td>
                        <div class="low-stock-alerts-action-buttons">
                            <button class="low-stock-alerts-btn-sm low-stock-alerts-btn-primary" onclick="openIndividualRestockModal(${item.id})">Restock</button>
                            <button class="low-stock-alerts-btn-sm low-stock-alerts-btn-secondary" onclick="openAdjustStockModal(${item.id})">Adjust</button>
                        </div>
                    </td>
                `;
            });
            updateLowStockPagination(data.length);
            lucide.createIcons(); // Re-create icons for new table content
        }

        function setupLowStockAlertsEventListeners() {
            // Search functionality
            document.getElementById('lowStockSearchInput').addEventListener('input', applyLowStockAlertsFilters);

            // Category filter
            document.getElementById('lowStockCategoryFilter').addEventListener('change', applyLowStockAlertsFilters);

            // Alert level filter
            document.getElementById('lowStockAlertLevelFilter').addEventListener('change', applyLowStockAlertsFilters);

            // Minimum levels adjustment method change
            document.getElementById('minimumLevelsBulkAdjustMethod').addEventListener('change', function() {
                const method = this.value;
                document.getElementById('minimumLevelsPercentageGroup').style.display = method === 'percentage' ? 'block' : 'none';
                document.getElementById('minimumLevelsFixedGroup').style.display = method === 'fixed' ? 'block' : 'none';
                document.getElementById('minimumLevelsIndividualAdjustSection').style.display = method === 'individual' ? 'block' : 'none';

                if (method === 'individual') {
                    populateMinimumLevelsList();
                }
            });
        }

        function applyLowStockAlertsFilters() {
            const searchTerm = document.getElementById('lowStockSearchInput').value.toLowerCase();
            const selectedCategory = document.getElementById('lowStockCategoryFilter').value;
            const selectedLevel = document.getElementById('lowStockAlertLevelFilter').value;

            filteredLowStockData = lowStockData.filter(item => {
                const matchesSearch = item.name.toLowerCase().includes(searchTerm) ||
                                    item.sku.toLowerCase().includes(searchTerm);
                const matchesCategory = !selectedCategory || item.category === selectedCategory;
                const matchesLevel = !selectedLevel || item.alertLevel === selectedLevel;

                return matchesSearch && matchesCategory && matchesLevel;
            });

            currentLowStockPage = 1;
            populateLowStockAlertsTable(filteredLowStockData);
            updateLowStockAlertsCount();
        }

        function updateLowStockSummaryCards() {
            const critical = lowStockData.filter(item => item.alertLevel === 'critical').length;
            const warning = lowStockData.filter(item => item.alertLevel === 'warning').length;

            document.getElementById('criticalAlertsCount').textContent = critical;
            document.getElementById('warningAlertsCount').textContent = warning;
            document.getElementById('totalAlertItemsCount').textContent = lowStockData.length;
        }

        function updateLowStockAlertsCount() {
            document.getElementById('lowStockAlertsCount').textContent = `${filteredLowStockData.length} items need attention`;
        }

        function updateLowStockPagination(totalItems) {
            const totalPages = Math.ceil(totalItems / lowStockItemsPerPage);
            const startItem = totalItems === 0 ? 0 : (currentLowStockPage - 1) * lowStockItemsPerPage + 1;
            const endItem = Math.min(currentLowStockPage * lowStockItemsPerPage, totalItems);

            document.getElementById('lowStockStartItem').textContent = startItem;
            document.getElementById('lowStockEndItem').textContent = endItem;
            document.getElementById('lowStockTotalAlerts').textContent = totalItems;

            const prevBtn = document.getElementById('lowStockPrevBtn');
            const nextBtn = document.getElementById('lowStockNextBtn');
            const pageNumbersContainer = document.getElementById('lowStockPageNumbers');

            prevBtn.disabled = currentLowStockPage === 1;
            nextBtn.disabled = currentLowStockPage === totalPages || totalPages === 0;

            pageNumbersContainer.innerHTML = '';
            for (let i = 1; i <= totalPages; i++) {
                const pageBtn = document.createElement('button');
                pageBtn.className = `low-stock-alerts-page-btn ${i === currentLowStockPage ? 'active' : ''}`;
                pageBtn.textContent = i;
                pageBtn.onclick = () => changeLowStockAlertsPage(i);
                pageNumbersContainer.appendChild(pageBtn);
            }
        }

        function changeLowStockAlertsPage(page) {
            const totalPages = Math.ceil(filteredLowStockData.length / lowStockItemsPerPage);

            if (page === 'prev' && currentLowStockPage > 1) {
                currentLowStockPage--;
            } else if (page === 'next' && currentLowStockPage < totalPages) {
                currentLowStockPage++;
            } else if (typeof page === 'number' && page >= 1 && page <= totalPages) {
                currentLowStockPage = page;
            }
            populateLowStockAlertsTable(filteredLowStockData);
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
            document.body.style.overflow = 'hidden';
            populateBulkRestockItemsList();
            lucide.createIcons(); // Re-create icons for new modal content
        }

        function closeBulkRestockModal() {
            document.getElementById('bulkRestockModal').classList.remove('show');
            document.body.style.overflow = 'auto';
            document.getElementById('bulkRestockForm').reset();
        }

        function populateBulkRestockItemsList() {
            const itemsList = document.getElementById('bulkRestockItemsList');
            itemsList.innerHTML = '';

            filteredLowStockData.forEach(item => { // Use filtered data for bulk actions
                const recommendedQty = Math.max(item.minStock * 2 - item.currentStock, 0);
                const itemEntry = document.createElement('div');
                itemEntry.className = 'low-stock-alerts-item-entry';
                itemEntry.innerHTML = `
                    <div class="low-stock-alerts-item-info">
                        <div class="low-stock-alerts-item-name">${item.icon} ${item.name}</div>
                        <div class="low-stock-alerts-item-details">Current: ${item.currentStock} | Min: ${item.minStock} | SKU: ${item.sku}</div>
                    </div>
                    <div>
                        <input type="number" class="low-stock-alerts-quantity-input" value="${recommendedQty}" min="0"
                               data-item-id="${item.id}" placeholder="Qty">
                    </div>
                `;
                itemsList.appendChild(itemEntry);
            });
        }

        function openIndividualRestockModal(itemId) {
            const item = lowStockData.find(i => i.id === itemId);
            currentEditingItem = item;

            document.getElementById('individualRestockProductName').textContent = item.name;
            document.getElementById('individualRestockCurrentStock').textContent = item.currentStock;
            document.getElementById('individualRestockMinStock').textContent = item.minStock;
            document.getElementById('individualRestockRecommended').textContent = Math.max(item.minStock * 2 - item.currentStock, 0);
            document.getElementById('individualRestockQuantity').value = Math.max(item.minStock * 2 - item.currentStock, 0);
            document.getElementById('individualRestockPriority').value = item.alertLevel === 'critical' ? 'urgent' : 'high';

            document.getElementById('individualRestockModal').classList.add('show');
            document.body.style.overflow = 'hidden';
            lucide.createIcons(); // Re-create icons for new modal content
        }

        function closeIndividualRestockModal() {
            document.getElementById('individualRestockModal').classList.remove('show');
            document.body.style.overflow = 'auto';
            document.getElementById('individualRestockForm').reset();
            currentEditingItem = null;
        }

        function openAdjustStockModal(itemId) {
            const item = lowStockData.find(i => i.id === itemId);
            currentEditingItem = item;

            document.getElementById('adjustStockModalProductName').textContent = item.name;
            document.getElementById('adjustStockModalCurrentStock').textContent = item.currentStock;
            document.getElementById('adjustStockModalQuantity').value = '';
            document.getElementById('adjustStockModalNotes').value = '';

            document.getElementById('adjustStockModal').classList.add('show');
            document.body.style.overflow = 'hidden';
            lucide.createIcons(); // Re-create icons for new modal content
        }

        function closeAdjustStockModal() {
            document.getElementById('adjustStockModal').classList.remove('show');
            document.body.style.overflow = 'auto';
            document.getElementById('adjustStockModalForm').reset();
            currentEditingItem = null;
        }

        function openMinimumLevelsModal() {
            document.getElementById('minimumLevelsModal').classList.add('show');
            document.body.style.overflow = 'hidden';
            populateMinimumLevelsList();
            lucide.createIcons(); // Re-create icons for new modal content
        }

        function closeMinimumLevelsModal() {
            document.getElementById('minimumLevelsModal').classList.remove('show');
            document.body.style.overflow = 'auto';
            // Reset form elements for minimum levels modal
            document.getElementById('minimumLevelsBulkAdjustMethod').value = 'percentage';
            document.getElementById('minimumLevelsPercentageGroup').style.display = 'block';
            document.getElementById('minimumLevelsFixedGroup').style.display = 'none';
            document.getElementById('minimumLevelsIndividualAdjustSection').style.display = 'none';
            document.getElementById('minimumLevelsPercentageChange').value = '';
            document.getElementById('minimumLevelsFixedChange').value = '';
        }

        function populateMinimumLevelsList() {
            const itemsList = document.getElementById('minimumLevelsList');
            itemsList.innerHTML = '';

            filteredLowStockData.forEach(item => { // Use filtered data for bulk actions
                const itemEntry = document.createElement('div');
                itemEntry.className = 'low-stock-alerts-item-entry';
                itemEntry.innerHTML = `
                    <div class="low-stock-alerts-item-info">
                        <div class="low-stock-alerts-item-name">${item.icon} ${item.name}</div>
                        <div class="low-stock-alerts-item-details">Current Min: ${item.minStock} | SKU: ${item.sku}</div>
                    </div>
                    <div>
                        <input type="number" class="low-stock-alerts-quantity-input" value="${item.minStock}" min="1"
                               data-item-id="${item.id}" placeholder="New Min">
                    </div>
                `;
                itemsList.appendChild(itemEntry);
            });
        }

        function openEmailAlertsModal() {
            document.getElementById('emailAlertsModal').classList.add('show');
            document.body.style.overflow = 'hidden';
            lucide.createIcons(); // Re-create icons for new modal content
        }

        function closeEmailAlertsModal() {
            document.getElementById('emailAlertsModal').classList.remove('show');
            document.body.style.overflow = 'auto';
            document.getElementById('emailAlertsForm').reset();
        }

        // Action Functions
        function refreshLowStockAlerts() {
            const refreshBtn = document.querySelector('.low-stock-alerts-refresh-btn');
            refreshBtn.style.opacity = '0.6';
            refreshBtn.style.pointerEvents = 'none';

            showLowStockAlertsNotification('Refreshing alerts...', 'info');

            setTimeout(() => {
                // Re-apply filters to simulate data refresh
                applyLowStockAlertsFilters();
                updateLowStockSummaryCards();
                refreshBtn.style.opacity = '1';
                refreshBtn.style.pointerEvents = 'auto';

                const header = document.querySelector('.low-stock-alerts-header h2');
                const originalText = header.innerHTML;
                header.innerHTML = '<i data-lucide="check-circle" style="width:45px; height:50px; color:#059669;"></i> Alerts Updated';
                lucide.createIcons(); // Re-create icon

                setTimeout(() => {
                    header.innerHTML = originalText;
                    lucide.createIcons(); // Re-create icon
                }, 2000);
            }, 1000);
        }

        function exportLowStockReport() {
            let csvContent = "Product Name,SKU,Current Stock,Minimum Stock,Alert Level,Days Supply,Last Restock\n";

            filteredLowStockData.forEach(item => {
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

            showLowStockAlertsNotification('Low stock report exported successfully!', 'success');
        }

        function applyMinimumLevelChanges() {
            const method = document.getElementById('minimumLevelsBulkAdjustMethod').value;
            let changesApplied = 0;

            if (method === 'percentage') {
                const percentage = parseFloat(document.getElementById('minimumLevelsPercentageChange').value);
                if (isNaN(percentage)) {
                    showLowStockAlertsNotification('Please enter a valid percentage', 'error');
                    return;
                }
                // Simulate applying changes to filteredLowStockData
                filteredLowStockData.forEach(item => {
                    item.minStock = Math.round(item.minStock * (1 + percentage / 100));
                });
                changesApplied = filteredLowStockData.length;
                showLowStockAlertsNotification(`Minimum levels adjusted by ${percentage}% for ${changesApplied} items`, 'success');
            } else if (method === 'fixed') {
                const fixedAmount = parseFloat(document.getElementById('minimumLevelsFixedChange').value);
                if (isNaN(fixedAmount)) {
                    showLowStockAlertsNotification('Please enter a valid fixed amount', 'error');
                    return;
                }
                // Simulate applying changes to filteredLowStockData
                filteredLowStockData.forEach(item => {
                    item.minStock = Math.max(1, item.minStock + fixedAmount); // Ensure minStock doesn't go below 1
                });
                changesApplied = filteredLowStockData.length;
                showLowStockAlertsNotification(`Minimum levels adjusted by ${fixedAmount} units for ${changesApplied} items`, 'success');
            } else if (method === 'individual') {
                const inputs = document.querySelectorAll('#minimumLevelsList .low-stock-alerts-quantity-input');
                inputs.forEach(input => {
                    const itemId = parseInt(input.dataset.itemId);
                    const newMin = parseInt(input.value);
                    const item = lowStockData.find(i => i.id === itemId);
                    if (item && !isNaN(newMin) && newMin >= 1) {
                        item.minStock = newMin;
                        changesApplied++;
                    }
                });
                showLowStockAlertsNotification(`Individual minimum levels updated for ${changesApplied} items`, 'success');
            }

            // Re-evaluate alert levels and refresh table
            lowStockData.forEach(item => {
                if (item.currentStock <= 0) item.alertLevel = 'critical';
                else if (item.currentStock <= item.minStock * 0.5) item.alertLevel = 'critical';
                else if (item.currentStock <= item.minStock) item.alertLevel = 'warning';
                else item.alertLevel = 'low'; // Or 'normal' if you have that level
            });

            applyLowStockAlertsFilters(); // Re-apply filters to update table and summary
            closeMinimumLevelsModal();
        }

        // Form Submissions
        document.getElementById('bulkRestockForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const priority = document.getElementById('bulkRestockRequestPriority').value;
            const department = document.getElementById('bulkRestockDepartment').value;
            const notes = document.getElementById('bulkRestockNotes').value;

            const items = [];
            document.querySelectorAll('#bulkRestockItemsList .low-stock-alerts-quantity-input').forEach(input => {
                const quantity = parseInt(input.value);
                if (quantity > 0) {
                    items.push({
                        id: input.dataset.itemId,
                        quantity: quantity
                    });
                }
            });

            showLowStockAlertsNotification(`Bulk restock request submitted!\n${items.length} items requested with ${priority} priority.`, 'success');
            closeBulkRestockModal();
        });

        document.getElementById('individualRestockForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const quantity = document.getElementById('individualRestockQuantity').value;
            const priority = document.getElementById('individualRestockPriority').value;
            const reason = document.getElementById('individualRestockReason').value;

            showLowStockAlertsNotification(`Restock request submitted for ${currentEditingItem.name}\nQuantity: ${quantity} units\nPriority: ${capitalizeFirst(priority)}`, 'success');
            closeIndividualRestockModal();
        });

        document.getElementById('adjustStockModalForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const type = document.getElementById('adjustStockModalAdjustmentType').value;
            const quantity = document.getElementById('adjustStockModalQuantity').value;
            const reason = document.getElementById('adjustStockModalReason').value;

            showLowStockAlertsNotification(`Stock adjustment applied for ${currentEditingItem.name}\nType: ${capitalizeFirst(type)}\nQuantity: ${quantity}\nReason: ${reason}`, 'success');
            closeAdjustStockModal();
        });

        document.getElementById('emailAlertsForm').addEventListener('submit', function(e) {
            e.preventDefault();
            let recipientCount = 0;
            if (document.getElementById('emailAlertsManagersCheckbox').checked) recipientCount += 3;
            if (document.getElementById('emailAlertsPurchasingCheckbox').checked) recipientCount += 2;
            if (document.getElementById('emailAlertsInventoryCheckbox').checked) recipientCount += 4;

            showLowStockAlertsNotification(`Email alerts sent successfully to ${recipientCount} recipients!`, 'success');
            closeEmailAlertsModal();
        });

        function setupLowStockAlertsModalClickOutside() {
            const modals = document.querySelectorAll('.low-stock-alerts-modal-base');
            modals.forEach(modal => {
                modal.addEventListener('click', function(e) {
                    if (e.target === this) { // Only close if clicking on the backdrop
                        // Determine which specific close function to call
                        if (this.id === 'bulkRestockModal') closeBulkRestockModal();
                        else if (this.id === 'individualRestockModal') closeIndividualRestockModal();
                        else if (this.id === 'adjustStockModal') closeAdjustStockModal();
                        else if (this.id === 'minimumLevelsModal') closeMinimumLevelsModal();
                        else if (this.id === 'emailAlertsModal') closeEmailAlertsModal();
                    }
                });
            });
        }

        function showLowStockAlertsNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `low-stock-alerts-notification ${type}`;
            notification.textContent = message;

            document.body.appendChild(notification);

            // Trigger reflow to enable transition
            void notification.offsetWidth;
            notification.classList.add('show');

            setTimeout(() => {
                notification.classList.remove('show');
                notification.addEventListener('transitionend', () => notification.remove());
            }, 3000);
        }

        // Auto-refresh alerts every 5 minutes (disabled for now, but structure is there)
        // setInterval(function() {
        //     console.log('Auto-refreshing alerts...');
        //     refreshLowStockAlerts();
        // }, 300000);
    </script>
</body>
</html>
