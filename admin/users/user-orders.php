<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Orders Modal</title>
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
            padding: 2rem;
        }

        .demo-btn {
            padding: 0.75rem 1.5rem;
            background-color: #1e40af;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 2rem;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
        }

        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-content {
            background: white;
            border-radius: 16px;
            width: 100%;
            max-width: 1100px;
            max-height: 90vh;
            overflow: hidden;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);
            animation: slideIn 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        @keyframes slideIn {
            from { transform: translateY(-30px) scale(0.95); opacity: 0; }
            to { transform: translateY(0) scale(1); opacity: 1; }
        }

        /* Modal Header */
        .modal-header {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #e2e8f0;
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
        }

        .modal-title {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .customer-avatar-large {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.3rem;
        }

        .modal-title h3 {
            font-size: 1.4rem;
            font-weight: 600;
            margin: 0;
        }

        .modal-title p {
            opacity: 0.9;
            font-size: 0.9rem;
            margin: 0;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: white;
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.2s ease;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .close-btn:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        /* Modal Body */
        .modal-body {
            flex: 1;
            overflow-y: auto;
            padding: 2rem;
        }

        /* Stats Section */
        .order-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: #f8fafc;
            padding: 1.5rem;
            border-radius: 12px;
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

        /* Order Summary */
        .order-summary {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
            padding: 1.5rem;
        }

        .summary-title {
            color: #1e40af;
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .summary-title .lucide {
            width: 18px;
            height: 18px;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .summary-item {
            text-align: center;
            padding: 1rem;
            border-radius: 8px;
            background: #f8fafc;
        }

        .summary-value {
            font-size: 1.3rem;
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 0.25rem;
        }

        .summary-label {
            color: #64748b;
            font-size: 0.85rem;
        }

        /* Filter Controls */
        .filter-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .filter-group {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .filter-select, .date-input {
            padding: 0.5rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            background: white;
            font-size: 0.9rem;
            min-width: 120px;
        }

        .date-range {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        /* Orders Table */
        .orders-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .table-container {
            overflow-x: auto;
        }

        .orders-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
        }

        .orders-table th {
            background-color: #f8fafc;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #475569;
            font-size: 0.9rem;
            border-bottom: 1px solid #e2e8f0;
            white-space: nowrap;
        }

        .orders-table td {
            padding: 1rem;
            border-bottom: 1px solid #f1f5f9;
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

        .order-items {
            max-width: 200px;
        }

        .item-count {
            font-weight: 500;
            color: #1e40af;
            margin-bottom: 0.25rem;
        }

        .item-list {
            font-size: 0.85rem;
            color: #64748b;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
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
            font-size: 0.9rem;
        }

        .page-btn:hover {
            background-color: #1e40af;
            color: white;
            border-color: #1e40af;
        }

        .page-btn.active {
            background-color: #1e40af;
            color: white;
            border-color: #1e40af;
        }

        /* Modal Footer */
        .modal-footer {
            padding: 1.5rem 2rem;
            border-top: 1px solid #e2e8f0;
            background: #f8fafc;
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            flex-shrink: 0;
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
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn .lucide {
            width: 16px;
            height: 16px;
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

        /* Responsive Design */
        @media (max-width: 768px) {
            .modal-content {
                max-width: 95vw;
                margin: 0.5rem;
            }

            .order-stats {
                grid-template-columns: repeat(2, 1fr);
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

            .pagination {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .pagination-controls {
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .order-stats {
                grid-template-columns: 1fr;
            }

            .summary-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <!-- Customer Orders Modal -->
    <div id="customerOrdersModal" class="modal" onclick="closeModal(event)">
        <div class="modal-content" onclick="event.stopPropagation()">
            <div class="modal-header">
                <div class="modal-title">
                    <div class="customer-avatar-large">JD</div>
                    <div>
                        <h3>Juan Dela Cruz - Orders</h3>
                        <p>Customer ID: #CUS-001 • Member since August 2024</p>
                    </div>
                </div>
                <button class="close-btn" onclick="closeCustomerOrdersModal()">&times;</button>
            </div>

            <div class="modal-body">
                <!-- Order Stats -->
                <!-- <div class="order-stats">
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
                </div> -->

                <!-- Order Summary -->
                <div class="order-summary">
                    <h4 class="summary-title">
                        <i data-lucide="bar-chart-3"></i>
                        Order Summary by Status
                    </h4>
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
                        </select>
                        <div class="date-range">
                            <input type="date" class="date-input" id="startDate" title="Start Date">
                            <span>to</span>
                            <input type="date" class="date-input" id="endDate" title="End Date">
                        </div>
                    </div>
                    <div class="filter-group">
                        <button class="btn btn-secondary" onclick="exportOrders()">
                            <i data-lucide="download"></i> Export
                        </button>
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
                                    <th>Payment</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><a href="#" class="order-id">#1234</a></td>
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
                                    <td><a href="#" class="action-btn">View</a></td>
                                </tr>
                                <tr>
                                    <td><a href="#" class="order-id">#1233</a></td>
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
                                    <td><a href="#" class="action-btn">View</a></td>
                                </tr>
                                <tr>
                                    <td><a href="#" class="order-id">#1232</a></td>
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
                                    <td><a href="#" class="action-btn">View</a></td>
                                </tr>
                                <tr>
                                    <td><a href="#" class="order-id">#1231</a></td>
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
                                    <td><a href="#" class="action-btn">View</a></td>
                                </tr>
                                <tr>
                                    <td><a href="#" class="order-id">#1230</a></td>
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
                                    <td><a href="#" class="action-btn">View</a></td>
                                </tr>
                                <tr>
                                    <td><a href="#" class="order-id">#1229</a></td>
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
                                    <td><a href="#" class="action-btn">View</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="pagination">
                        <div class="pagination-info">
                            Showing 1-6 of 8 orders
                        </div>
                        <div class="pagination-controls">
                            <button class="page-btn">Previous</button>
                            <button class="page-btn active">1</button>
                            <button class="page-btn">2</button>
                            <button class="page-btn">Next</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeModal()">
                    <i data-lucide="x"></i> Close
                </button>
                <button class="btn btn-secondary">
                    <i data-lucide="user"></i> View Profile
                </button>
                <button class="btn btn-primary">
                    <i data-lucide="edit"></i> Edit Customer
                </button>
            </div>
        </div>
    </div>
</body>
</html>
