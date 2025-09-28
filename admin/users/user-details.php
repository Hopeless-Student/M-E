<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Details Modal</title>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <style>
        /* Base styles for all modals */
        .customer-details-modal-base {
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

        .customer-details-modal-base.show {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            animation: customerDetailsFadeIn 0.3s ease;
        }

        @keyframes customerDetailsFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .customer-details-modal-content {
            background: white;
            border-radius: 16px;
            width: 100%;
            max-width: 900px;
            max-height: 90vh;
            overflow: hidden;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);
            animation: customerDetailsSlideIn 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        @keyframes customerDetailsSlideIn {
            from { transform: translateY(-30px) scale(0.95); opacity: 0; }
            to { transform: translateY(0) scale(1); opacity: 1; }
        }

        /* Modal Header */
        .customer-details-modal-header {
            padding: 1rem 2rem; /* Slightly reduced padding */
            border-bottom: 1px solid #e2e8f0;
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
        }

        .customer-details-modal-title {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .customer-details-avatar-large {
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

        .customer-details-modal-title h3 {
            font-size: 1.3rem; /* Slightly smaller font */
            font-weight: 600;
            margin: 0;
        }

        .customer-details-modal-title p {
            opacity: 0.9;
            font-size: 0.85rem; /* Slightly smaller font */
            margin: 0;
        }

        .customer-details-close-btn {
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

        .customer-details-close-btn:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        /* Modal Body */
        .customer-details-modal-body {
            flex: 1;
            overflow-y: auto;
            padding: 2rem;
        }

        /* Stats Section */
        .customer-details-stats-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); /* Adjusted minmax */
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .customer-details-stat-card {
            background: #f8fafc;
            padding: 1.2rem; /* Slightly reduced padding */
            border-radius: 12px;
            text-align: center;
            border-left: 4px solid #1e40af;
        }

        .customer-details-stat-value {
            font-size: 1.6rem; /* Slightly smaller font */
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 0.4rem;
        }

        .customer-details-stat-label {
            color: #64748b;
            font-size: 0.85rem; /* Slightly smaller font */
            font-weight: 500;
        }

        .customer-details-stat-change {
            font-size: 0.75rem; /* Slightly smaller font */
            margin-top: 0.2rem;
        }

        .customer-details-stat-change.positive { color: #059669; }

        /* Content Grid */
        .customer-details-content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .customer-details-info-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .customer-details-section-header {
            padding: 0.8rem 1.5rem; /* Slightly reduced padding */
            border-bottom: 1px solid #e2e8f0;
            background: #f8fafc;
        }

        .customer-details-section-header h4 {
            color: #1e40af;
            font-size: 0.95rem; /* Slightly smaller font */
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .customer-details-section-header .lucide {
            width: 16px; /* Slightly smaller icon */
            height: 16px;
        }

        .customer-details-section-content {
            padding: 1.5rem;
        }

        .customer-details-info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.8rem; /* Slightly reduced margin */
            padding-bottom: 0.8rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .customer-details-info-row:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .customer-details-info-label {
            color: #64748b;
            font-weight: 500;
            font-size: 0.85rem; /* Slightly smaller font */
        }

        .customer-details-info-value {
            color: #1e293b;
            font-weight: 500;
            font-size: 0.85rem; /* Slightly smaller font */
        }

        .customer-details-status-badge {
            padding: 0.2rem 0.6rem; /* Slightly reduced padding */
            border-radius: 20px;
            font-size: 0.75rem; /* Slightly smaller font */
            font-weight: 500;
        }

        .customer-details-status-badge.active { background-color: #d1fae5; color: #065f46; }

        /* Recent Orders */
        .customer-details-recent-orders {
            grid-column: 1 / -1;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .customer-details-orders-table {
            width: 100%;
            border-collapse: collapse;
        }

        .customer-details-orders-table th {
            background-color: #f8fafc;
            padding: 0.8rem 1rem; /* Slightly reduced padding */
            text-align: left;
            font-weight: 600;
            color: #475569;
            font-size: 0.85rem; /* Slightly smaller font */
            border-bottom: 1px solid #e2e8f0;
        }

        .customer-details-orders-table td {
            padding: 0.8rem 1rem; /* Slightly reduced padding */
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .customer-details-orders-table tr:hover {
            background-color: #f8fafc;
        }

        .customer-details-order-id {
            color: #1e40af;
            font-weight: 600;
            text-decoration: none;
            font-size: 0.85rem;
        }

        .customer-details-order-id:hover {
            text-decoration: underline;
        }

        .customer-details-order-status {
            padding: 0.2rem 0.6rem; /* Slightly reduced padding */
            border-radius: 20px;
            font-size: 0.75rem; /* Slightly smaller font */
            font-weight: 500;
        }

        .customer-details-order-status.completed { background-color: #d1fae5; color: #065f46; }
        .customer-details-order-status.cancelled { background-color: #fee2e2; color: #dc2626; }

        /* Activity Timeline */
        .customer-details-activity-timeline {
            grid-column: 1 / -1;
        }

        .customer-details-timeline-item {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #f1f5f9;
            position: relative;
        }

        .customer-details-timeline-item:last-child {
            border-bottom: none;
        }

        .customer-details-timeline-item::before {
            content: '';
            position: absolute;
            left: 1.5rem;
            top: 1.5rem;
            width: 8px;
            height: 8px;
            background: #1e40af;
            border-radius: 50%;
        }

        .customer-details-timeline-content {
            margin-left: 2rem;
        }

        .customer-details-timeline-title {
            font-weight: 600;
            color: #1e293b;
            font-size: 0.85rem; /* Slightly smaller font */
            margin-bottom: 0.25rem;
        }

        .customer-details-timeline-desc {
            color: #64748b;
            font-size: 0.8rem; /* Slightly smaller font */
            margin-bottom: 0.25rem;
        }

        .customer-details-timeline-time {
            color: #94a3b8;
            font-size: 0.75rem; /* Slightly smaller font */
        }

        /* Modal Footer */
        .customer-details-modal-footer {
            padding: 1rem 2rem; /* Slightly reduced padding */
            border-top: 1px solid #e2e8f0;
            background: #f8fafc;
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            flex-shrink: 0;
        }

        .customer-details-btn {
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

        .customer-details-btn .lucide {
            width: 14px; /* Slightly smaller icon */
            height: 14px;
        }

        .customer-details-btn-primary {
            background-color: #1e40af;
            color: white;
        }

        .customer-details-btn-primary:hover {
            background-color: #1e3a8a;
        }

        .customer-details-btn-secondary {
            background-color: #64748b;
            color: white;
        }

        .customer-details-btn-secondary:hover {
            background-color: #475569;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .customer-details-modal-content {
                max-width: 95vw;
                margin: 0.5rem;
            }

            .customer-details-content-grid {
                grid-template-columns: 1fr;
            }

            .customer-details-stats-section {
                grid-template-columns: repeat(2, 1fr);
            }

            .customer-details-modal-header {
                flex-direction: column;
                text-align: center;
                gap: 0.8rem;
                padding: 1rem;
            }
            .customer-details-modal-title {
                flex-direction: column;
                gap: 0.5rem;
            }
            .customer-details-modal-title h3 {
                font-size: 1.2rem;
            }
            .customer-details-modal-title p {
                font-size: 0.8rem;
            }
            .customer-details-avatar-large {
                width: 45px;
                height: 45px;
                font-size: 1rem;
            }
        }

        @media (max-width: 480px) {
            .customer-details-stats-section {
                grid-template-columns: 1fr;
            }

            .customer-details-info-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.25rem;
            }
            .customer-details-modal-body {
                padding: 1rem;
            }
            .customer-details-modal-footer {
                flex-direction: column;
                gap: 0.8rem;
                padding: 1rem;
            }
            .customer-details-btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>


    <!-- Customer Details Modal -->
    <div id="customerDetailsModal" class="customer-details-modal-base" onclick="closeCustomerDetailsModal(event)">
        <div class="customer-details-modal-content" onclick="event.stopPropagation()">
            <div class="customer-details-modal-header">
                <div class="customer-details-modal-title">
                    <div class="customer-details-avatar-large">JD</div>
                    <div>
                        <h3>Juan Dela Cruz</h3>
                        <p>Customer ID: #CUS-001</p>
                    </div>
                </div>
                <button class="customer-details-close-btn" onclick="closeCustomerDetailsModal()">&times;</button>
            </div>

            <div class="customer-details-modal-body">
                <!-- Stats Section -->
                <div class="customer-details-stats-section">
                    <div class="customer-details-stat-card">
                        <div class="customer-details-stat-value">8</div>
                        <div class="customer-details-stat-label">Total Orders</div>
                        <div class="customer-details-stat-change positive">+2 this month</div>
                    </div>
                    <div class="customer-details-stat-card">
                        <div class="customer-details-stat-value">₱4,250</div>
                        <div class="customer-details-stat-label">Total Spent</div>
                        <div class="customer-details-stat-change positive">+₱850 this month</div>
                    </div>
                    <div class="customer-details-stat-card">
                        <div class="customer-details-stat-value">₱531</div>
                        <div class="customer-details-stat-label">Average Order</div>
                        <div class="customer-details-stat-change positive">+12% from last month</div>
                    </div>
                    <div class="customer-details-stat-card">
                        <div class="customer-details-stat-value">2 days</div>
                        <div class="customer-details-stat-label">Last Order</div>
                        <div class="customer-details-stat-change">Order #1234</div>
                    </div>
                </div>

                <!-- Content Grid -->
                <div class="customer-details-content-grid">
                    <!-- Personal Information -->
                    <div class="customer-details-info-section">
                        <div class="customer-details-section-header">
                            <h4><i data-lucide="user"></i>Personal Information</h4>
                        </div>
                        <div class="customer-details-section-content">
                            <div class="customer-details-info-row">
                                <span class="customer-details-info-label">Full Name</span>
                                <span class="customer-details-info-value">Juan Dela Cruz</span>
                            </div>
                            <div class="customer-details-info-row">
                                <span class="customer-details-info-label">Email</span>
                                <span class="customer-details-info-value">juan.delacruz@email.com</span>
                            </div>
                            <div class="customer-details-info-row">
                                <span class="customer-details-info-label">Phone</span>
                                <span class="customer-details-info-value">+63 917 123 4567</span>
                            </div>
                            <div class="customer-details-info-row">
                                <span class="customer-details-info-label">Date of Birth</span>
                                <span class="customer-details-info-value">June 15, 1985</span>
                            </div>
                            <div class="customer-details-info-row">
                                <span class="customer-details-info-label">Gender</span>
                                <span class="customer-details-info-value">Male</span>
                            </div>
                            <div class="customer-details-info-row">
                                <span class="customer-details-info-label">Member Since</span>
                                <span class="customer-details-info-value">August 2024</span>
                            </div>
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="customer-details-info-section">
                        <div class="customer-details-section-header">
                            <h4><i data-lucide="map-pin"></i>Address Information</h4>
                        </div>
                        <div class="customer-details-section-content">
                            <div class="customer-details-info-row">
                                <span class="customer-details-info-label">Street Address</span>
                                <span class="customer-details-info-value">123 Main Street</span>
                            </div>
                            <div class="customer-details-info-row">
                                <span class="customer-details-info-label">City</span>
                                <span class="customer-details-info-value">Olongapo City</span>
                            </div>
                            <div class="customer-details-info-row">
                                <span class="customer-details-info-label">Province</span>
                                <span class="customer-details-info-value">Zambales</span>
                            </div>
                            <div class="customer-details-info-row">
                                <span class="customer-details-info-label">Postal Code</span>
                                <span class="customer-details-info-value">2200</span>
                            </div>
                            <div class="customer-details-info-row">
                                <span class="customer-details-info-label">Country</span>
                                <span class="customer-details-info-value">Philippines</span>
                            </div>
                            <div class="customer-details-info-row">
                                <span class="customer-details-info-label">Status</span>
                                <span class="customer-details-status-badge active">Active Customer</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="customer-details-recent-orders">
                    <div class="customer-details-section-header">
                        <h4><i data-lucide="package"></i>Recent Orders (Last 5)</h4>
                    </div>
                    <table class="customer-details-orders-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><a href="#" class="customer-details-order-id">#1234</a></td>
                                <td>Aug 30, 2025</td>
                                <td>3 items</td>
                                <td><strong>₱850</strong></td>
                                <td><span class="customer-details-order-status completed">Completed</span></td>
                            </tr>
                            <tr>
                                <td><a href="#" class="customer-details-order-id">#1233</a></td>
                                <td>Aug 25, 2025</td>
                                <td>2 items</td>
                                <td><strong>₱650</strong></td>
                                <td><span class="customer-details-order-status completed">Completed</span></td>
                            </tr>
                            <tr>
                                <td><a href="#" class="customer-details-order-id">#1232</a></td>
                                <td>Aug 20, 2025</td>
                                <td>5 items</td>
                                <td><strong>₱1,200</strong></td>
                                <td><span class="customer-details-order-status completed">Completed</span></td>
                            </tr>
                            <tr>
                                <td><a href="#" class="customer-details-order-id">#1231</a></td>
                                <td>Aug 15, 2025</td>
                                <td>1 item</td>
                                <td><strong>₱300</strong></td>
                                <td><span class="customer-details-order-status cancelled">Cancelled</span></td>
                            </tr>
                            <tr>
                                <td><a href="#" class="customer-details-order-id">#1230</a></td>
                                <td>Aug 10, 2025</td>
                                <td>4 items</td>
                                <td><strong>₱950</strong></td>
                                <td><span class="customer-details-order-status completed">Completed</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Activity Timeline -->
                <div class="customer-details-activity-timeline">
                    <div class="customer-details-info-section">
                        <div class="customer-details-section-header">
                            <h4><i data-lucide="activity"></i>Recent Activity</h4>
                        </div>
                        <div class="customer-details-timeline-item">
                            <div class="customer-details-timeline-content">
                                <div class="customer-details-timeline-title">Order Completed</div>
                                <div class="customer-details-timeline-desc">Order #1234 was successfully delivered</div>
                                <div class="customer-details-timeline-time">2 days ago</div>
                            </div>
                        </div>
                        <div class="customer-details-timeline-item">
                            <div class="customer-details-timeline-content">
                                <div class="customer-details-timeline-title">Order Placed</div>
                                <div class="customer-details-timeline-desc">New order #1234 placed for ₱850</div>
                                <div class="customer-details-timeline-time">5 days ago</div>
                            </div>
                        </div>
                        <div class="customer-details-timeline-item">
                            <div class="customer-details-timeline-content">
                                <div class="customer-details-timeline-title">Profile Updated</div>
                                <div class="customer-details-timeline-desc">Customer updated phone number</div>
                                <div class="customer-details-timeline-time">1 week ago</div>
                            </div>
                        </div>
                        <div class="customer-details-timeline-item">
                            <div class="customer-details-timeline-content">
                                <div class="customer-details-timeline-title">Order Completed</div>
                                <div class="customer-details-timeline-desc">Order #1233 was successfully delivered</div>
                                <div class="customer-details-timeline-time">2 weeks ago</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="customer-details-modal-footer">
                <button class="customer-details-btn customer-details-btn-secondary" onclick="closeCustomerDetailsModal()">
                    <i data-lucide="x"></i> Close
                </button>
                <button class="customer-details-btn customer-details-btn-secondary">
                    <i data-lucide="package"></i> View All Orders
                </button>
                <button class="customer-details-btn customer-details-btn-primary">
                    <i data-lucide="edit"></i> Edit Customer
                </button>
            </div>
        </div>
    </div>
</body>
</html>
