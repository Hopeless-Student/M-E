<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Orders Modal</title>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <style>
        /* Base styles for all modals */
        .customer-orders-modal-base {
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

        .customer-orders-modal-base.show {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            animation: customerOrdersFadeIn 0.3s ease;
        }

        @keyframes customerOrdersFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .customer-orders-modal-content {
            background: white;
            border-radius: 16px;
            width: 100%;
            max-width: 1100px;
            max-height: 90vh;
            overflow: hidden;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);
            animation: customerOrdersSlideIn 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        @keyframes customerOrdersSlideIn {
            from { transform: translateY(-30px) scale(0.95); opacity: 0; }
            to { transform: translateY(0) scale(1); opacity: 1; }
        }

        /* Modal Header */
        .customer-orders-modal-header {
            padding: 1rem 2rem; /* Slightly reduced padding */
            border-bottom: 1px solid #e2e8f0;
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
        }

        .customer-orders-modal-title {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .customer-orders-avatar-large {
            width: 50px; /* Slightly smaller avatar */
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.1rem; /* Slightly smaller font */
        }

        .customer-orders-modal-title h3 {
            font-size: 1.3rem; /* Slightly smaller font */
            font-weight: 600;
            margin: 0;
        }

        .customer-orders-modal-title p {
            opacity: 0.9;
            font-size: 0.85rem; /* Slightly smaller font */
            margin: 0;
        }

        .customer-orders-close-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: white;
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.2s ease;
            width: 36px; /* Slightly smaller button */
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .customer-orders-close-btn:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        /* Modal Body */
        .customer-orders-modal-body {
            flex: 1;
            overflow-y: auto;
            padding: 2rem;
        }

        /* Stats Section (renamed to avoid conflict, though not used in this modal's HTML) */
        .customer-orders-order-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .customer-orders-stat-card {
            background: #f8fafc;
            padding: 1.5rem;
            border-radius: 12px;
            text-align: center;
            border-left: 4px solid #1e40af;
        }

        .customer-orders-stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 0.5rem;
        }

        .customer-orders-stat-label {
            color: #64748b;
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Order Summary */
        .customer-orders-order-summary {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
            padding: 1.5rem;
        }

        .customer-orders-summary-title {
            color: #1e40af;
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.05rem; /* Slightly smaller font */
        }

        .customer-orders-summary-title .lucide {
            width: 16px; /* Slightly smaller icon */
            height: 16px;
        }

        .customer-orders-summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); /* Adjusted minmax */
            gap: 1rem;
        }

        .customer-orders-summary-item {
            text-align: center;
            padding: 1rem;
            border-radius: 8px;
            background: #f8fafc;
        }

        .customer-orders-summary-value {
            font-size: 1.2rem; /* Slightly smaller font */
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 0.25rem;
        }

        .customer-orders-summary-label {
            color: #64748b;
            font-size: 0.8rem; /* Slightly smaller font */
        }

        /* Filter Controls */
        .customer-orders-filter-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .customer-orders-filter-group {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .customer-orders-filter-select, .customer-orders-date-input {
            padding: 0.5rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            background: white;
            font-size: 0.9rem;
            min-width: 120px;
        }

        .customer-orders-date-range {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        /* Orders Table */
        .customer-orders-orders-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .customer-orders-table-container {
            overflow-x: auto;
        }

        .customer-orders-orders-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
        }

        .customer-orders-orders-table th {
            background-color: #f8fafc;
            padding: 0.8rem 1rem; /* Slightly reduced padding */
            text-align: left;
            font-weight: 600;
            color: #475569;
            font-size: 0.85rem; /* Slightly smaller font */
            border-bottom: 1px solid #e2e8f0;
            white-space: nowrap;
        }

        .customer-orders-orders-table td {
            padding: 0.8rem 1rem; /* Slightly reduced padding */
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .customer-orders-orders-table tr:hover {
            background-color: #f8fafc;
        }

        .customer-orders-order-id {
            color: #1e40af;
            font-weight: 600;
            text-decoration: none;
            font-size: 0.85rem;
        }

        .customer-orders-order-id:hover {
            text-decoration: underline;
        }

        .customer-orders-order-status {
            padding: 0.2rem 0.6rem; /* Slightly reduced padding */
            border-radius: 20px;
            font-size: 0.75rem; /* Slightly smaller font */
            font-weight: 500;
            white-space: nowrap;
        }

        .customer-orders-order-status.completed { background-color: #d1fae5; color: #065f46; }
        .customer-orders-order-status.pending { background-color: #fef3c7; color: #92400e; }
        .customer-orders-order-status.processing { background-color: #dbeafe; color: #1d4ed8; }
        .customer-orders-order-status.cancelled { background-color: #fee2e2; color: #dc2626; }

        .customer-orders-order-items {
            max-width: 200px;
        }

        .customer-orders-item-count {
            font-weight: 500;
            color: #1e40af;
            margin-bottom: 0.25rem;
            font-size: 0.85rem;
        }

        .customer-orders-item-list {
            font-size: 0.8rem;
            color: #64748b;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .customer-orders-order-total {
            font-weight: 700;
            color: #1e293b;
            font-size: 0.95rem; /* Slightly smaller font */
        }

        .customer-orders-action-btn {
            padding: 0.4rem 0.8rem; /* Slightly reduced padding */
            background-color: #1e40af;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.75rem; /* Slightly smaller font */
            transition: background-color 0.2s ease;
            text-decoration: none;
            display: inline-block;
            white-space: nowrap;
        }

        .customer-orders-action-btn:hover {
            background-color: #1e3a8a;
        }

        /* Pagination */
        .customer-orders-pagination {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.2rem 1.5rem; /* Slightly reduced padding */
            border-top: 1px solid #e2e8f0;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .customer-orders-pagination-info {
            color: #64748b;
            font-size: 0.85rem; /* Slightly smaller font */
        }

        .customer-orders-pagination-controls {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .customer-orders-page-btn {
            padding: 0.4rem 0.8rem; /* Slightly reduced padding */
            border: 1px solid #d1d5db;
            background: white;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
            min-width: 38px; /* Slightly smaller button */
            text-align: center;
            font-size: 0.85rem; /* Slightly smaller font */
        }

        .customer-orders-page-btn:hover {
            background-color: #1e40af;
            color: white;
            border-color: #1e40af;
        }

        .customer-orders-page-btn.active {
            background-color: #1e40af;
            color: white;
            border-color: #1e40af;
        }

        /* Modal Footer */
        .customer-orders-modal-footer {
            padding: 1rem 2rem; /* Slightly reduced padding */
            border-top: 1px solid #e2e8f0;
            background: #f8fafc;
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            flex-shrink: 0;
        }

        .customer-orders-btn {
            padding: 0.6rem 1.2rem; /* Slightly reduced padding */
            border: none;
            border-radius: 8px;
            font-size: 0.85rem; /* Slightly smaller font */
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .customer-orders-btn .lucide {
            width: 14px; /* Slightly smaller icon */
            height: 14px;
        }

        .customer-orders-btn-primary {
            background-color: #1e40af;
            color: white;
        }

        .customer-orders-btn-primary:hover {
            background-color: #1e3a8a;
        }

        .customer-orders-btn-secondary {
            background-color: #64748b;
            color: white;
        }

        .customer-orders-btn-secondary:hover {
            background-color: #475569;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .customer-orders-modal-content {
                max-width: 95vw;
                margin: 0.5rem;
            }

            .customer-orders-order-stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .customer-orders-filter-controls {
                flex-direction: column;
                align-items: stretch;
            }

            .customer-orders-filter-group {
                flex-direction: column;
                width: 100%;
            }

            .customer-orders-filter-select, .customer-orders-date-input {
                width: 100%;
            }

            .customer-orders-pagination {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .customer-orders-pagination-controls {
                justify-content: center;
            }
            .customer-orders-modal-header {
                flex-direction: column;
                text-align: center;
                gap: 0.8rem;
                padding: 1rem;
            }
            .customer-orders-modal-title {
                flex-direction: column;
                gap: 0.5rem;
            }
            .customer-orders-modal-title h3 {
                font-size: 1.2rem;
            }
            .customer-orders-modal-title p {
                font-size: 0.8rem;
            }
            .customer-orders-avatar-large {
                width: 45px;
                height: 45px;
                font-size: 1rem;
            }
            .customer-orders-modal-body {
                padding: 1rem;
            }
            .customer-orders-modal-footer {
                flex-direction: column;
                gap: 0.8rem;
                padding: 1rem;
            }
            .customer-orders-btn {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .customer-orders-order-stats {
                grid-template-columns: 1fr;
            }

            .customer-orders-summary-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <!-- Customer Orders Modal -->
    <div id="customerOrdersModal" class="customer-orders-modal-base" onclick="closeCustomerOrdersModal(event)">
        <div class="customer-orders-modal-content" onclick="event.stopPropagation()">
            <div class="customer-orders-modal-header">
                <div class="customer-orders-modal-title">
                    <div class="customer-orders-avatar-large">JD</div>
                    <div>
                        <h3>Juan Dela Cruz - Orders</h3>
                        <p>Customer ID: #CUS-001 • Member since August 2024</p>
                    </div>
                </div>
                <button class="customer-orders-close-btn" onclick="closeCustomerOrdersModal()">&times;</button>
            </div>

            <div class="customer-orders-modal-body">
                <!-- Order Summary -->
                <div class="customer-orders-order-summary">
                    <h4 class="customer-orders-summary-title">
                        <i data-lucide="bar-chart-3"></i>
                        Order Summary by Status
                    </h4>
                    <div class="customer-orders-summary-grid">
                        <div class="customer-orders-summary-item">
                            <div class="customer-orders-summary-value">7</div>
                            <div class="customer-orders-summary-label">Completed (₱3,950)</div>
                        </div>
                        <div class="customer-orders-summary-item">
                            <div class="customer-orders-summary-value">0</div>
                            <div class="customer-orders-summary-label">Pending (₱0)</div>
                        </div>
                        <div class="customer-orders-summary-item">
                            <div class="customer-orders-summary-value">0</div>
                            <div class="customer-orders-summary-label">Processing (₱0)</div>
                        </div>
                        <div class="customer-orders-summary-item">
                            <div class="customer-orders-summary-value">1</div>
                            <div class="customer-orders-summary-label">Cancelled (₱300)</div>
                        </div>
                    </div>
                </div>

                <!-- Filter Controls -->
                <div class="customer-orders-filter-controls">
                    <div class="customer-orders-filter-group">
                        <select class="customer-orders-filter-select" id="customerOrdersStatusFilter">
                            <option value="">All Status</option>
                            <option value="completed">Completed</option>
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                        <div class="customer-orders-date-range">
                            <input type="date" class="customer-orders-date-input" id="customerOrdersStartDate" title="Start Date">
                            <span>to</span>
                            <input type="date" class="customer-orders-date-input" id="customerOrdersEndDate" title="End Date">
                        </div>
                    </div>
                    <div class="customer-orders-filter-group">
                        <button class="customer-orders-btn customer-orders-btn-secondary" onclick="exportOrders()">
                            <i data-lucide="download"></i> Export
                        </button>
                    </div>
                </div>

                <!-- Orders Table -->
                <div class="customer-orders-orders-section">
                    <div class="customer-orders-table-container">
                        <table class="customer-orders-orders-table">
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
                                    <td><a href="#" class="customer-orders-order-id">#1234</a></td>
                                    <td>Aug 30, 2025</td>
                                    <td>
                                        <div class="customer-orders-order-items">
                                            <div class="customer-orders-item-count">3 items</div>
                                            <div class="customer-orders-item-list">Widget A, Widget B, Widget C</div>
                                        </div>
                                    </td>
                                    <td><span class="customer-orders-order-total">₱850</span></td>
                                    <td>Credit Card</td>
                                    <td><span class="customer-orders-order-status completed">Completed</span></td>
                                    <td><a href="#" class="customer-orders-action-btn">View</a></td>
                                </tr>
                                <tr>
                                    <td><a href="#" class="customer-orders-order-id">#1233</a></td>
                                    <td>Aug 25, 2025</td>
                                    <td>
                                        <div class="customer-orders-order-items">
                                            <div class="customer-orders-item-count">2 items</div>
                                            <div class="customer-orders-item-list">Product X, Product Y</div>
                                        </div>
                                    </td>
                                    <td><span class="customer-orders-order-total">₱650</span></td>
                                    <td>GCash</td>
                                    <td><span class="customer-orders-order-status completed">Completed</span></td>
                                    <td><a href="#" class="customer-orders-action-btn">View</a></td>
                                </tr>
                                <tr>
                                    <td><a href="#" class="customer-orders-order-id">#1232</a></td>
                                    <td>Aug 20, 2025</td>
                                    <td>
                                        <div class="customer-orders-order-items">
                                            <div class="customer-orders-item-count">5 items</div>
                                            <div class="customer-orders-item-list">Item A, Item B, Item C, Item D, Item E</div>
                                        </div>
                                    </td>
                                    <td><span class="customer-orders-order-total">₱1,200</span></td>
                                    <td>PayPal</td>
                                    <td><span class="customer-orders-order-status completed">Completed</span></td>
                                    <td><a href="#" class="customer-orders-action-btn">View</a></td>
                                </tr>
                                <tr>
                                    <td><a href="#" class="customer-orders-order-id">#1231</a></td>
                                    <td>Aug 15, 2025</td>
                                    <td>
                                        <div class="customer-orders-order-items">
                                            <div class="customer-orders-item-count">1 item</div>
                                            <div class="customer-orders-item-list">Special Product</div>
                                        </div>
                                    </td>
                                    <td><span class="customer-orders-order-total">₱300</span></td>
                                    <td>Credit Card</td>
                                    <td><span class="customer-orders-order-status cancelled">Cancelled</span></td>
                                    <td><a href="#" class="customer-orders-action-btn">View</a></td>
                                </tr>
                                <tr>
                                    <td><a href="#" class="customer-orders-order-id">#1230</a></td>
                                    <td>Aug 10, 2025</td>
                                    <td>
                                        <div class="customer-orders-order-items">
                                            <div class="customer-orders-item-count">4 items</div>
                                            <div class="customer-orders-item-list">Product A, Product B, Product C, Product D</div>
                                        </div>
                                    </td>
                                    <td><span class="customer-orders-order-total">₱950</span></td>
                                    <td>Bank Transfer</td>
                                    <td><span class="customer-orders-order-status completed">Completed</span></td>
                                    <td><a href="#" class="customer-orders-action-btn">View</a></td>
                                </tr>
                                <tr>
                                    <td><a href="#" class="customer-orders-order-id">#1229</a></td>
                                    <td>Aug 05, 2025</td>
                                    <td>
                                        <div class="customer-orders-order-items">
                                            <div class="customer-orders-item-count">2 items</div>
                                            <div class="customer-orders-item-list">Widget X, Widget Y</div>
                                        </div>
                                    </td>
                                    <td><span class="customer-orders-order-total">₱750</span></td>
                                    <td>GCash</td>
                                    <td><span class="customer-orders-order-status completed">Completed</span></td>
                                    <td><a href="#" class="customer-orders-action-btn">View</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="customer-orders-pagination">
                        <div class="customer-orders-pagination-info">
                            Showing 1-6 of 8 orders
                        </div>
                        <div class="customer-orders-pagination-controls">
                            <button class="customer-orders-page-btn">Previous</button>
                            <button class="customer-orders-page-btn active">1</button>
                            <button class="customer-orders-page-btn">2</button>
                            <button class="customer-orders-page-btn">Next</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="customer-orders-modal-footer">
                <button class="customer-orders-btn customer-orders-btn-secondary" onclick="closeCustomerOrdersModal()">
                    <i data-lucide="x"></i> Close
                </button>
                <button class="customer-orders-btn customer-orders-btn-secondary">
                    <i data-lucide="user"></i> View Profile
                </button>
                <button class="customer-orders-btn customer-orders-btn-primary">
                    <i data-lucide="edit"></i> Edit Customer
                </button>
            </div>
        </div>
    </div>
</body>
</html>
