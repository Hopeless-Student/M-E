<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Details Modal</title>
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
            max-width: 900px;
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
        .stats-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
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

        .stat-change {
            font-size: 0.8rem;
            margin-top: 0.25rem;
        }

        .stat-change.positive { color: #059669; }

        /* Content Grid */
        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .info-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .section-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            background: #f8fafc;
        }

        .section-header h4 {
            color: #1e40af;
            font-size: 1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .section-header .lucide {
            width: 18px;
            height: 18px;
        }

        .section-content {
            padding: 1.5rem;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .info-row:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .info-label {
            color: #64748b;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .info-value {
            color: #1e293b;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .status-badge.active { background-color: #d1fae5; color: #065f46; }

        /* Recent Orders */
        .recent-orders {
            grid-column: 1 / -1;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .orders-table {
            width: 100%;
            border-collapse: collapse;
        }

        .orders-table th {
            background-color: #f8fafc;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #475569;
            font-size: 0.9rem;
            border-bottom: 1px solid #e2e8f0;
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
        }

        .order-status.completed { background-color: #d1fae5; color: #065f46; }
        .order-status.cancelled { background-color: #fee2e2; color: #dc2626; }

        /* Activity Timeline */
        .activity-timeline {
            grid-column: 1 / -1;
        }

        .timeline-item {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #f1f5f9;
            position: relative;
        }

        .timeline-item:last-child {
            border-bottom: none;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: 1.5rem;
            top: 1.5rem;
            width: 8px;
            height: 8px;
            background: #1e40af;
            border-radius: 50%;
        }

        .timeline-content {
            margin-left: 2rem;
        }

        .timeline-title {
            font-weight: 600;
            color: #1e293b;
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }

        .timeline-desc {
            color: #64748b;
            font-size: 0.85rem;
            margin-bottom: 0.25rem;
        }

        .timeline-time {
            color: #94a3b8;
            font-size: 0.8rem;
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

            .content-grid {
                grid-template-columns: 1fr;
            }

            .stats-section {
                grid-template-columns: repeat(2, 1fr);
            }

            .modal-header {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }
        }

        @media (max-width: 480px) {
            .stats-section {
                grid-template-columns: 1fr;
            }

            .info-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.25rem;
            }
        }
    </style>
</head>
<body>


    <!-- Customer Details Modal -->
    <div id="customerDetailsModal" class="modal" onclick="closeModal(event)">
        <div class="modal-content" onclick="event.stopPropagation()">
            <div class="modal-header">
                <div class="modal-title">
                    <div class="customer-avatar-large">JD</div>
                    <div>
                        <h3>Juan Dela Cruz</h3>
                        <p>Customer ID: #CUS-001</p>
                    </div>
                </div>
                <button class="close-btn" onclick="closeCustomerDetailsModal()">&times;</button>
            </div>

            <div class="modal-body">
                <!-- Stats Section -->
                <div class="stats-section">
                    <div class="stat-card">
                        <div class="stat-value">8</div>
                        <div class="stat-label">Total Orders</div>
                        <div class="stat-change positive">+2 this month</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value">₱4,250</div>
                        <div class="stat-label">Total Spent</div>
                        <div class="stat-change positive">+₱850 this month</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value">₱531</div>
                        <div class="stat-label">Average Order</div>
                        <div class="stat-change positive">+12% from last month</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value">2 days</div>
                        <div class="stat-label">Last Order</div>
                        <div class="stat-change">Order #1234</div>
                    </div>
                </div>

                <!-- Content Grid -->
                <div class="content-grid">
                    <!-- Personal Information -->
                    <div class="info-section">
                        <div class="section-header">
                            <h4><i data-lucide="user"></i>Personal Information</h4>
                        </div>
                        <div class="section-content">
                            <div class="info-row">
                                <span class="info-label">Full Name</span>
                                <span class="info-value">Juan Dela Cruz</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Email</span>
                                <span class="info-value">juan.delacruz@email.com</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Phone</span>
                                <span class="info-value">+63 917 123 4567</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Date of Birth</span>
                                <span class="info-value">June 15, 1985</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Gender</span>
                                <span class="info-value">Male</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Member Since</span>
                                <span class="info-value">August 2024</span>
                            </div>
                        </div>
                    </div>

                    <!-- Address Information -->
                    <div class="info-section">
                        <div class="section-header">
                            <h4><i data-lucide="map-pin"></i>Address Information</h4>
                        </div>
                        <div class="section-content">
                            <div class="info-row">
                                <span class="info-label">Street Address</span>
                                <span class="info-value">123 Main Street</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">City</span>
                                <span class="info-value">Olongapo City</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Province</span>
                                <span class="info-value">Zambales</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Postal Code</span>
                                <span class="info-value">2200</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Country</span>
                                <span class="info-value">Philippines</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Status</span>
                                <span class="status-badge active">Active Customer</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="recent-orders">
                    <div class="section-header">
                        <h4><i data-lucide="package"></i>Recent Orders (Last 5)</h4>
                    </div>
                    <table class="orders-table">
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
                                <td><a href="#" class="order-id">#1234</a></td>
                                <td>Aug 30, 2025</td>
                                <td>3 items</td>
                                <td><strong>₱850</strong></td>
                                <td><span class="order-status completed">Completed</span></td>
                            </tr>
                            <tr>
                                <td><a href="#" class="order-id">#1233</a></td>
                                <td>Aug 25, 2025</td>
                                <td>2 items</td>
                                <td><strong>₱650</strong></td>
                                <td><span class="order-status completed">Completed</span></td>
                            </tr>
                            <tr>
                                <td><a href="#" class="order-id">#1232</a></td>
                                <td>Aug 20, 2025</td>
                                <td>5 items</td>
                                <td><strong>₱1,200</strong></td>
                                <td><span class="order-status completed">Completed</span></td>
                            </tr>
                            <tr>
                                <td><a href="#" class="order-id">#1231</a></td>
                                <td>Aug 15, 2025</td>
                                <td>1 item</td>
                                <td><strong>₱300</strong></td>
                                <td><span class="order-status cancelled">Cancelled</span></td>
                            </tr>
                            <tr>
                                <td><a href="#" class="order-id">#1230</a></td>
                                <td>Aug 10, 2025</td>
                                <td>4 items</td>
                                <td><strong>₱950</strong></td>
                                <td><span class="order-status completed">Completed</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Activity Timeline -->
                <div class="activity-timeline">
                    <div class="info-section">
                        <div class="section-header">
                            <h4><i data-lucide="activity"></i>Recent Activity</h4>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-content">
                                <div class="timeline-title">Order Completed</div>
                                <div class="timeline-desc">Order #1234 was successfully delivered</div>
                                <div class="timeline-time">2 days ago</div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-content">
                                <div class="timeline-title">Order Placed</div>
                                <div class="timeline-desc">New order #1234 placed for ₱850</div>
                                <div class="timeline-time">5 days ago</div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-content">
                                <div class="timeline-title">Profile Updated</div>
                                <div class="timeline-desc">Customer updated phone number</div>
                                <div class="timeline-time">1 week ago</div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-content">
                                <div class="timeline-title">Order Completed</div>
                                <div class="timeline-desc">Order #1233 was successfully delivered</div>
                                <div class="timeline-time">2 weeks ago</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeModal()">
                    <i data-lucide="x"></i> Close
                </button>
                <button class="btn btn-secondary">
                    <i data-lucide="package"></i> View All Orders
                </button>
                <button class="btn btn-primary">
                    <i data-lucide="edit"></i> Edit Customer
                </button>
            </div>
        </div>
    </div>
</body>
</html>
