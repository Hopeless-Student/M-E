<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Movements - M & E Dashboard</title>
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
        }
        img {
            width: 250px;
            height: 250px;
        }



        .dashboard {
            display: flex;
            min-height: 100vh;
        }

        /* Main Content */
        .main-content {
         flex: 1;
         margin-left: 230px !important; /* Exact match to sidebar width */
         padding: 1.5rem;
         min-height: 100vh;
         transition: margin-left 0.3s ease;
         width: calc(100vw - 230px); /* Changed from 100% to 100vw for absolute viewport width */
         max-width: calc(100vw - 230px);
         box-sizing: border-box;
         position: relative; /* Ensure proper positioning */
         overflow-x: hidden; /* Prevent horizontal scroll */
       }
       .header {
           display: flex;
           justify-content: space-between;
           align-items: center;
           margin-bottom: 1.5rem;
           background: none;
           padding: 1.25rem 0rem;
           border-radius: 12px;
           box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
           flex-wrap: wrap;
           gap: 1rem;
       }

       .header h2 {
           padding-left: 0.3rem;
           font-size: 1.75rem;
           font-weight: 600;
           color: #1e40af;

       }
       .user-info {
           display: flex;
           align-items: center;
           padding-right: 0.3rem;
           gap: 0.75rem;
           font-size: 1rem;
           font-weight: 500;
           color: #475569;
       }

       .avatar {
           width: 36px;
           height: 36px;
           background: linear-gradient(135deg, #1e40af, #3b82f6);
           border-radius: 50%;
           display: flex;
           align-items: center;
           justify-content: center;
           color: white;
           font-weight: 600;
           font-size: 1rem;
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

        /* Stats Cards */
        .stats-row {
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
            border-left: 4px solid #1e40af;
        }

        .stat-card.positive {
            border-left-color: #059669;
        }

        .stat-card.negative {
            border-left-color: #dc2626;
        }

        .stat-card.warning {
            border-left-color: #d97706;
        }

        .stat-title {
            color: #64748b;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1e40af;
        }

        .stat-card.positive .stat-value {
            color: #059669;
        }

        .stat-card.negative .stat-value {
            color: #dc2626;
        }

        .stat-card.warning .stat-value {
            color: #d97706;
        }

        .stat-trend {
            font-size: 0.8rem;
            color: #64748b;
            margin-top: 0.25rem;
        }

        /* Controls */
        .controls-section {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .controls-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .filters-group {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .filter-input, .filter-select {
            padding: 0.75rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 0.9rem;
            transition: border-color 0.2s;
        }

        .filter-input:focus, .filter-select:focus {
            outline: none;
            border-color: #1e40af;
        }

        .date-range {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .export-actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
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

        /* Chart Section */
        .chart-container {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .chart-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 1rem;
        }

        .chart-wrapper {
            position: relative;
            height: 300px;
        }

        /* Movements Table */
        .movements-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .section-header {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
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

        .movements-table {
            width: 100%;
            border-collapse: collapse;
        }

        .movements-table th {
            background-color: #f8fafc;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #475569;
            font-size: 0.9rem;
            border-bottom: 2px solid #e2e8f0;
        }

        .movements-table td {
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .movements-table tr:hover {
            background-color: #f8fafc;
        }

        .product-cell {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .product-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
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

        .movement-type {
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .movement-type.inbound {
            background: #dcfce7;
            color: #166534;
        }

        .movement-type.outbound {
            background: #fee2e2;
            color: #991b1b;
        }

        .movement-type.adjustment {
            background: #e0e7ff;
            color: #1e40af;
        }

        .movement-type.transfer {
            background: #fef3c7;
            color: #92400e;
        }

        .quantity-change {
            font-weight: 600;
            font-size: 1.1rem;
        }

        .quantity-change.positive {
            color: #059669;
        }

        .quantity-change.negative {
            color: #dc2626;
        }

        .reference-link {
            color: #1e40af;
            text-decoration: none;
            font-weight: 500;
        }

        .reference-link:hover {
            text-decoration: underline;
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
            font-size: 0.9rem;
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

        .page-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .page-btn:disabled:hover {
            background-color: white;
            color: #9ca3af;
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

            .controls-row {
                flex-direction: column;
                align-items: stretch;
            }

            .filters-group {
                flex-direction: column;
            }

            .stats-row {
                grid-template-columns: 1fr;
            }

            .date-range {
                flex-direction: column;
            }

            .export-actions {
                justify-content: stretch;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <?php include '../../includes/admin_sidebar.php' ?>

        <!-- Main Content -->
        <main class="main-content">
            <div class="header">
                <h2>Stock Movements</h2>
                <div class="header-actions">
                    <a href="index.php" class="back-btn">
                        <span>←</span> Back to Inventory
                    </a>
                    <div class="user-info">
                        <span>Admin Panel</span>
                        <div class="avatar">A</div>
                    </div>
                </div>
            </div>

            <!-- Movement Stats -->
            <div class="stats-row">
                <div class="stat-card positive">
                    <div class="stat-title">Total Inbound</div>
                    <div class="stat-value">+342</div>
                    <div class="stat-trend">This month</div>
                </div>
                <div class="stat-card negative">
                    <div class="stat-title">Total Outbound</div>
                    <div class="stat-value">-287</div>
                    <div class="stat-trend">This month</div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">Net Movement</div>
                    <div class="stat-value">+55</div>
                    <div class="stat-trend">This month</div>
                </div>
                <div class="stat-card warning">
                    <div class="stat-title">Adjustments</div>
                    <div class="stat-value">23</div>
                    <div class="stat-trend">This month</div>
                </div>
            </div>

            <!-- Controls -->
            <div class="controls-section">
                <div class="controls-row">
                    <div class="filters-group">
                        <input type="text" class="filter-input" placeholder="Search products..." id="searchInput">
                        <select class="filter-select" id="movementTypeFilter">
                            <option value="">All Movement Types</option>
                            <option value="inbound">Inbound</option>
                            <option value="outbound">Outbound</option>
                            <option value="adjustment">Adjustment</option>
                            <option value="transfer">Transfer</option>
                        </select>
                        <select class="filter-select" id="productFilter">
                            <option value="">All Products</option>
                            <option value="1">Ballpoint Pens</option>
                            <option value="2">Bond Paper</option>
                            <option value="3">File Folders</option>
                        </select>
                    </div>
                    <div class="export-actions">
                        <button class="btn btn-secondary" onclick="exportMovements()">
                            <i data-lucide="download"></i> Export CSV
                        </button>
                        <button class="btn btn-primary" onclick="generateReport()">
                            <i data-lucide="file-text"></i> Generate Report
                        </button>
                    </div>
                </div>
                <div class="date-range">
                    <label>Date Range:</label>
                    <input type="date" class="filter-input" id="startDate" value="2024-11-01">
                    <span>to</span>
                    <input type="date" class="filter-input" id="endDate" value="2024-11-15">
                    <button class="btn btn-primary" onclick="applyDateFilter()">Apply</button>
                </div>
            </div>

            <!-- Movement Chart -->
            <div class="chart-container">
                <div class="chart-title">Stock Movement Trends</div>
                <div class="chart-wrapper">
                    <canvas id="movementChart"></canvas>
                </div>
            </div>

            <!-- Movements Table -->
            <div class="movements-section">
                <div class="section-header">
                    <h3 class="section-title">Recent Stock Movements</h3>
                    <span id="movementCount">Showing movements</span>
                </div>
                <table class="movements-table">
                    <thead>
                        <tr>
                            <th>Date & Time</th>
                            <th>Product</th>
                            <th>Type</th>
                            <th>Quantity Change</th>
                            <th>Previous Stock</th>
                            <th>New Stock</th>
                            <th>Reference</th>
                            <th>User</th>
                        </tr>
                    </thead>
                    <tbody id="movementsTableBody">
                        <!-- Movement data will be populated here -->
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="pagination">
                    <div class="pagination-info">
                        Showing <span id="startItem">1</span>-<span id="endItem">10</span> of <span id="totalMovements">0</span> movements
                    </div>
                    <div class="pagination-controls">
                        <button class="page-btn" id="prevBtn" onclick="changePage('prev')">Previous</button>
                        <div id="pageNumbers"></div>
                        <button class="page-btn" id="nextBtn" onclick="changePage('next')">Next</button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        lucide.createIcons();

        // Enhanced sample movement data with more entries
        const movementData = [
            {
                id: 1,
                date: '2024-11-15',
                time: '10:30 AM',
                productName: 'Ballpoint Pens',
                productIcon: '🖊️',
                sku: 'OFF-PEN-001',
                type: 'inbound',
                quantity: 50,
                previousStock: 100,
                newStock: 150,
                reference: 'PO-2024-001',
                user: 'Admin'
            },
            {
                id: 2,
                date: '2024-11-15',
                time: '09:45 AM',
                productName: 'Bond Paper',
                productIcon: '📄',
                sku: 'OFF-PAP-002',
                type: 'outbound',
                quantity: -25,
                previousStock: 110,
                newStock: 85,
                reference: 'ORD-2024-045',
                user: 'Staff'
            },
            {
                id: 3,
                date: '2024-11-15',
                time: '09:15 AM',
                productName: 'File Folders',
                productIcon: '📁',
                sku: 'OFF-FOL-003',
                type: 'adjustment',
                quantity: -5,
                previousStock: 50,
                newStock: 45,
                reference: 'ADJ-2024-012',
                user: 'Admin'
            },
            {
                id: 4,
                date: '2024-11-14',
                time: '02:30 PM',
                productName: 'Staplers',
                productIcon: '🔗',
                sku: 'OFF-STA-004',
                type: 'outbound',
                quantity: -8,
                previousStock: 20,
                newStock: 12,
                reference: 'ORD-2024-044',
                user: 'Staff'
            },
            {
                id: 5,
                date: '2024-11-14',
                time: '11:20 AM',
                productName: 'Notebooks',
                productIcon: '📓',
                sku: 'SCH-NOT-005',
                type: 'inbound',
                quantity: 30,
                previousStock: 15,
                newStock: 45,
                reference: 'PO-2024-002',
                user: 'Admin'
            },
            {
                id: 6,
                date: '2024-11-14',
                time: '10:15 AM',
                productName: 'Ballpoint Pens',
                productIcon: '🖊️',
                sku: 'OFF-PEN-001',
                type: 'outbound',
                quantity: -15,
                previousStock: 115,
                newStock: 100,
                reference: 'ORD-2024-043',
                user: 'Staff'
            },
            {
                id: 7,
                date: '2024-11-13',
                time: '03:45 PM',
                productName: 'Hand Sanitizer',
                productIcon: '🧴',
                sku: 'SAN-HAN-006',
                type: 'transfer',
                quantity: -10,
                previousStock: 35,
                newStock: 25,
                reference: 'TRF-2024-008',
                user: 'Manager'
            },
            {
                id: 8,
                date: '2024-11-13',
                time: '01:20 PM',
                productName: 'Bond Paper',
                productIcon: '📄',
                sku: 'OFF-PAP-002',
                type: 'inbound',
                quantity: 100,
                previousStock: 10,
                newStock: 110,
                reference: 'PO-2024-003',
                user: 'Admin'
            },
            {
                id: 9,
                date: '2024-11-13',
                time: '11:00 AM',
                productName: 'Correction Tape',
                productIcon: '✏️',
                sku: 'OFF-COR-007',
                type: 'inbound',
                quantity: 40,
                previousStock: 12,
                newStock: 52,
                reference: 'PO-2024-004',
                user: 'Admin'
            },
            {
                id: 10,
                date: '2024-11-12',
                time: '04:30 PM',
                productName: 'Highlighters',
                productIcon: '🖍️',
                sku: 'OFF-HIG-008',
                type: 'outbound',
                quantity: -20,
                previousStock: 75,
                newStock: 55,
                reference: 'ORD-2024-042',
                user: 'Staff'
            },
            {
                id: 11,
                date: '2024-11-12',
                time: '02:15 PM',
                productName: 'Erasers',
                productIcon: '🟧',
                sku: 'OFF-ERA-009',
                type: 'adjustment',
                quantity: 3,
                previousStock: 28,
                newStock: 31,
                reference: 'ADJ-2024-011',
                user: 'Admin'
            },
            {
                id: 12,
                date: '2024-11-12',
                time: '10:45 AM',
                productName: 'Paper Clips',
                productIcon: '📎',
                sku: 'OFF-CLI-010',
                type: 'inbound',
                quantity: 200,
                previousStock: 150,
                newStock: 350,
                reference: 'PO-2024-005',
                user: 'Admin'
            },
            {
                id: 13,
                date: '2024-11-11',
                time: '03:20 PM',
                productName: 'Sticky Notes',
                productIcon: '🗒️',
                sku: 'OFF-STI-011',
                type: 'outbound',
                quantity: -35,
                previousStock: 90,
                newStock: 55,
                reference: 'ORD-2024-041',
                user: 'Staff'
            },
            {
                id: 14,
                date: '2024-11-11',
                time: '01:00 PM',
                productName: 'Rulers',
                productIcon: '📏',
                sku: 'OFF-RUL-012',
                type: 'transfer',
                quantity: -8,
                previousStock: 25,
                newStock: 17,
                reference: 'TRF-2024-007',
                user: 'Manager'
            },
            {
                id: 15,
                date: '2024-11-11',
                time: '09:30 AM',
                productName: 'Calculators',
                productIcon: '🧮',
                sku: 'OFF-CAL-013',
                type: 'inbound',
                quantity: 15,
                previousStock: 8,
                newStock: 23,
                reference: 'PO-2024-006',
                user: 'Admin'
            },
            {
                id: 16,
                date: '2024-11-10',
                time: '04:45 PM',
                productName: 'Folders',
                productIcon: '📂',
                sku: 'OFF-FOL-014',
                type: 'outbound',
                quantity: -12,
                previousStock: 42,
                newStock: 30,
                reference: 'ORD-2024-040',
                user: 'Staff'
            },
            {
                id: 17,
                date: '2024-11-10',
                time: '02:10 PM',
                productName: 'Binders',
                productIcon: '📒',
                sku: 'OFF-BIN-015',
                type: 'adjustment',
                quantity: -2,
                previousStock: 18,
                newStock: 16,
                reference: 'ADJ-2024-010',
                user: 'Admin'
            },
            {
                id: 18,
                date: '2024-11-10',
                time: '11:25 AM',
                productName: 'Markers',
                productIcon: '🖍️',
                sku: 'OFF-MAR-016',
                type: 'inbound',
                quantity: 60,
                previousStock: 25,
                newStock: 85,
                reference: 'PO-2024-007',
                user: 'Admin'
            },
            {
                id: 19,
                date: '2024-11-09',
                time: '03:55 PM',
                productName: 'Scissors',
                productIcon: '✂️',
                sku: 'OFF-SCI-017',
                type: 'outbound',
                quantity: -6,
                previousStock: 14,
                newStock: 8,
                reference: 'ORD-2024-039',
                user: 'Staff'
            },
            {
                id: 20,
                date: '2024-11-09',
                time: '01:40 PM',
                productName: 'Tape Dispensers',
                productIcon: '📼',
                sku: 'OFF-TAP-018',
                type: 'transfer',
                quantity: 5,
                previousStock: 10,
                newStock: 15,
                reference: 'TRF-2024-006',
                user: 'Manager'
            },
            {
                id: 21,
                date: '2024-11-09',
                time: '10:30 AM',
                productName: 'Envelopes',
                productIcon: '✉️',
                sku: 'OFF-ENV-019',
                type: 'inbound',
                quantity: 150,
                previousStock: 45,
                newStock: 195,
                reference: 'PO-2024-008',
                user: 'Admin'
            },
            {
                id: 22,
                date: '2024-11-08',
                time: '04:20 PM',
                productName: 'Rubber Bands',
                productIcon: '🔗',
                sku: 'OFF-RUB-020',
                type: 'adjustment',
                quantity: 10,
                previousStock: 85,
                newStock: 95,
                reference: 'ADJ-2024-009',
                user: 'Admin'
            },
            {
                id: 23,
                date: '2024-11-08',
                time: '02:15 PM',
                productName: 'Thumb Tacks',
                productIcon: '📌',
                sku: 'OFF-THU-021',
                type: 'outbound',
                quantity: -30,
                previousStock: 120,
                newStock: 90,
                reference: 'ORD-2024-038',
                user: 'Staff'
            },
            {
                id: 24,
                date: '2024-11-08',
                time: '11:50 AM',
                productName: 'Glue Sticks',
                productIcon: '🧴',
                sku: 'OFF-GLU-022',
                type: 'inbound',
                quantity: 45,
                previousStock: 22,
                newStock: 67,
                reference: 'PO-2024-009',
                user: 'Admin'
            },
            {
                id: 25,
                date: '2024-11-07',
                time: '03:30 PM',
                productName: 'Index Cards',
                productIcon: '🗃️',
                sku: 'OFF-IND-023',
                type: 'outbound',
                quantity: -40,
                previousStock: 80,
                newStock: 40,
                reference: 'ORD-2024-037',
                user: 'Staff'
            }
        ];

        // Pagination variables
        let currentPage = 1;
        let itemsPerPage = 10;
        let filteredData = movementData;

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            updateDisplay();
            initializeChart();
        });

        function updateDisplay() {
            populateMovementsTable();
            updatePagination();
            updateMovementCount();
        }

        function populateMovementsTable() {
            const tbody = document.getElementById('movementsTableBody');
            tbody.innerHTML = '';

            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const pageData = filteredData.slice(startIndex, endIndex);

            pageData.forEach(movement => {
                const row = tbody.insertRow();

                const typeClass = movement.type;
                const quantityClass = movement.quantity > 0 ? 'positive' : 'negative';
                const quantitySign = movement.quantity > 0 ? '+' : '';

                row.innerHTML = `
                    <td>
                        <div style="font-weight: 600;">${movement.date}</div>
                        <div style="font-size: 0.85rem; color: #64748b;">${movement.time}</div>
                    </td>
                    <td>
                        <div class="product-cell">
                            <div class="product-icon">${movement.productIcon}</div>
                            <div class="product-info">
                                <h4>${movement.productName}</h4>
                                <p>${movement.sku}</p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="movement-type ${typeClass}">${capitalizeFirst(movement.type)}</span>
                    </td>
                    <td>
                        <span class="quantity-change ${quantityClass}">${quantitySign}${Math.abs(movement.quantity)}</span>
                    </td>
                    <td>${movement.previousStock}</td>
                    <td>${movement.newStock}</td>
                    <td>
                        <a href="#" class="reference-link">${movement.reference}</a>
                    </td>
                    <td>${movement.user}</td>
                `;
            });
        }

        function updatePagination() {
            const totalPages = Math.ceil(filteredData.length / itemsPerPage);
            const startItem = (currentPage - 1) * itemsPerPage + 1;
            const endItem = Math.min(currentPage * itemsPerPage, filteredData.length);

            document.getElementById('startItem').textContent = startItem;
            document.getElementById('endItem').textContent = endItem;
            document.getElementById('totalMovements').textContent = filteredData.length;

            // Update pagination controls
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const pageNumbers = document.getElementById('pageNumbers');

            prevBtn.disabled = currentPage === 1;
            nextBtn.disabled = currentPage === totalPages;

            // Generate page numbers
            pageNumbers.innerHTML = '';
            for (let i = 1; i <= totalPages; i++) {
                if (i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
                    const pageBtn = document.createElement('button');
                    pageBtn.className = `page-btn ${i === currentPage ? 'active' : ''}`;
                    pageBtn.textContent = i;
                    pageBtn.onclick = () => changePage(i);
                    pageNumbers.appendChild(pageBtn);
                } else if (i === currentPage - 2 || i === currentPage + 2) {
                    const ellipsis = document.createElement('span');
                    ellipsis.textContent = '...';
                    ellipsis.style.padding = '0.5rem';
                    pageNumbers.appendChild(ellipsis);
                }
            }
        }

        function updateMovementCount() {
            document.getElementById('movementCount').textContent = `Showing ${filteredData.length} movements`;
        }

        function capitalizeFirst(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }

        function initializeChart() {
            const ctx = document.getElementById('movementChart').getContext('2d');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Nov 8', 'Nov 9', 'Nov 10', 'Nov 11', 'Nov 12', 'Nov 13', 'Nov 14', 'Nov 15'],
                    datasets: [
                        {
                            label: 'Inbound',
                            data: [20, 35, 15, 40, 25, 30, 45, 35],
                            borderColor: '#059669',
                            backgroundColor: 'rgba(5, 150, 105, 0.1)',
                            tension: 0.4
                        },
                        {
                            label: 'Outbound',
                            data: [-15, -25, -30, -20, -35, -15, -40, -25],
                            borderColor: '#dc2626',
                            backgroundColor: 'rgba(220, 38, 38, 0.1)',
                            tension: 0.4
                        },
                        {
                            label: 'Adjustments',
                            data: [2, -3, 1, -2, 4, -1, -3, 2],
                            borderColor: '#1e40af',
                            backgroundColor: 'rgba(30, 64, 175, 0.1)',
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    },
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
                    }
                }
            });
        }

        // Unified filtering system
        function applyAllFilters() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const selectedType = document.getElementById('movementTypeFilter').value;
            const selectedProduct = document.getElementById('productFilter').value;
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;

            filteredData = movementData.filter(movement => {
                // Search filter (product name or SKU)
                const matchesSearch = !searchTerm ||
                    movement.productName.toLowerCase().includes(searchTerm) ||
                    movement.sku.toLowerCase().includes(searchTerm);

                // Movement type filter
                const matchesType = !selectedType || movement.type === selectedType;

                // Product filter (you can extend this based on your product IDs)
                const matchesProduct = !selectedProduct || movement.sku.includes(selectedProduct);

                // Date filter
                let matchesDate = true;
                if (startDate && endDate) {
                    const movementDate = new Date(movement.date);
                    matchesDate = movementDate >= new Date(startDate) && movementDate <= new Date(endDate);
                }

                // All conditions must be true
                return matchesSearch && matchesType && matchesProduct && matchesDate;
            });

            currentPage = 1;
            updateDisplay();
        }

        // Filter event listeners
        document.getElementById('searchInput').addEventListener('input', applyAllFilters);
        document.getElementById('movementTypeFilter').addEventListener('change', applyAllFilters);
        document.getElementById('productFilter').addEventListener('change', applyAllFilters);

        function applyDateFilter() {
            applyAllFilters();
        }

        function exportMovements() {
            // Create CSV headers
            const headers = [
                'Date',
                'Time',
                'Product Name',
                'SKU',
                'Movement Type',
                'Quantity Change',
                'Previous Stock',
                'New Stock',
                'Reference',
                'User'
            ];

            // Create CSV content
            let csvContent = headers.join(',') + '\n';

            filteredData.forEach(movement => {
                const row = [
                    movement.date,
                    movement.time,
                    `"${movement.productName}"`,
                    movement.sku,
                    movement.type,
                    movement.quantity,
                    movement.previousStock,
                    movement.newStock,
                    movement.reference,
                    movement.user
                ];
                csvContent += row.join(',') + '\n';
            });

            // Create and trigger download
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);
            link.setAttribute('href', url);
            link.setAttribute('download', `stock_movements_${new Date().toISOString().split('T')[0]}.csv`);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        function generateReport() {
            // Create a detailed report with statistics
            const totalInbound = filteredData.filter(m => m.quantity > 0).reduce((sum, m) => sum + m.quantity, 0);
            const totalOutbound = filteredData.filter(m => m.quantity < 0).reduce((sum, m) => sum + Math.abs(m.quantity), 0);
            const adjustments = filteredData.filter(m => m.type === 'adjustment').length;
            const transfers = filteredData.filter(m => m.type === 'transfer').length;

            const reportContent = `
STOCK MOVEMENTS REPORT
Generated on: ${new Date().toLocaleDateString()}
Period: ${document.getElementById('startDate').value} to ${document.getElementById('endDate').value}

SUMMARY STATISTICS:
==================
Total Movements: ${filteredData.length}
Total Inbound Quantity: +${totalInbound}
Total Outbound Quantity: -${totalOutbound}
Net Movement: ${totalInbound - totalOutbound}
Adjustments: ${adjustments}
Transfers: ${transfers}

MOVEMENT BREAKDOWN BY TYPE:
=========================
Inbound: ${filteredData.filter(m => m.type === 'inbound').length} movements
Outbound: ${filteredData.filter(m => m.type === 'outbound').length} movements
Adjustments: ${adjustments} movements
Transfers: ${transfers} movements

DETAILED MOVEMENTS:
==================
${filteredData.map(m =>
    `${m.date} ${m.time} - ${m.productName} (${m.sku}): ${m.quantity > 0 ? '+' : ''}${m.quantity} [${m.type}] - ${m.reference}`
).join('\n')}
            `;

            // Create and download report
            const blob = new Blob([reportContent], { type: 'text/plain;charset=utf-8;' });
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);
            link.setAttribute('href', url);
            link.setAttribute('download', `stock_movements_report_${new Date().toISOString().split('T')[0]}.txt`);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
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

            updateDisplay();
        }
    </script>
</body>
</html>
