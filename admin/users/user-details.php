<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Details - M & E Dashboard</title>
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

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            color: white;
            padding: 2rem 0;
            box-shadow: 4px 0 10px rgba(30, 58, 138, 0.1);
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

        /* Customer Profile Header */
        .customer-profile {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .profile-header {
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            color: white;
            padding: 2rem;
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .customer-avatar-large {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .profile-info h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .profile-info p {
            opacity: 0.9;
            margin-bottom: 0.25rem;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            margin-top: 0.5rem;
            display: inline-block;
        }

        .status-badge.active { background-color: rgba(255, 255, 255, 0.2); color: #dcfce7; }
        .status-badge.inactive { background-color: rgba(255, 255, 255, 0.2); color: #fecaca; }
        .status-badge.new { background-color: rgba(255, 255, 255, 0.2); color: #dbeafe; }

        /* Stats Grid */
        .stats-grid {
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
            font-size: 2rem;
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
        .stat-change.negative { color: #dc2626; }

        /* Content Grid */
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .info-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .section-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            background: #f8fafc;
        }

        .section-header h4 {
            color: #1e40af;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .section-content {
            padding: 1.5rem;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
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
            text-align: right;
        }

        /* Recent Orders */
        .recent-orders {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            grid-column: 1 / -1;
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
            border-bottom: 2px solid #e2e8f0;
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
        }

        .order-status.completed { background-color: #d1fae5; color: #065f46; }
        .order-status.pending { background-color: #fef3c7; color: #92400e; }
        .order-status.processing { background-color: #dbeafe; color: #1d4ed8; }
        .order-status.cancelled { background-color: #fee2e2; color: #dc2626; }

        /* Activity Timeline */
        .activity-timeline {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
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
            left: 0;
            top: 1.5rem;
            width: 4px;
            height: 4px;
            background: #1e40af;
            border-radius: 50%;
        }

        .timeline-content {
            margin-left: 1rem;
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

            .content-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .profile-header {
                flex-direction: column;
                text-align: center;
                padding: 1.5rem;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .header-actions {
                flex-direction: column;
                width: 100%;
            }

            .btn {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .info-row {
                flex-direction: column;
                gap: 0.25rem;
            }

            .info-value {
                text-align: left;
                font-weight: 600;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <nav class="sidebar">
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
                <a href="./index.php">Customers</a>
                <span>›</span>
                <span>Juan Dela Cruz</span>
            </div>

            <div class="header">
                <h2>Customer Details</h2>
                <div class="header-actions">
                    <a href="user-orders.php?id=1" class="btn btn-secondary">View Orders</a>
                    <a href="edit-user.php?id=1" class="btn btn-primary">Edit Customer</a>
                </div>
            </div>

            <!-- Customer Profile -->
            <div class="customer-profile">
                <div class="profile-header">
                    <div class="customer-avatar-large">JD</div>
                    <div class="profile-info">
                        <h3>Juan Dela Cruz</h3>
                        <p>juan.delacruz@email.com</p>
                        <p>+63 917 123 4567</p>
                        <p>Customer ID: #CUS-001</p>
                        <span class="status-badge active">Active Customer</span>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
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
                        <h4>Personal Information</h4>
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
                        <h4>Address Information</h4>
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
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="recent-orders">
                <div class="section-header">
                    <h4>Recent Orders (Last 5)</h4>
                </div>
                <div class="table-container">
                    <table class="orders-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><a href="../orders/order-details.php?id=1234" class="order-id">#1234</a></td>
                                <td>Aug 30, 2025</td>
                                <td>3 items</td>
                                <td><strong>₱850</strong></td>
                                <td><span class="order-status completed">Completed</span></td>
                                <td><a href="../orders/order-details.php?id=1234" class="btn btn-secondary" style="font-size: 0.8rem; padding: 0.4rem 0.8rem;">View</a></td>
                            </tr>
                            <tr>
                                <td><a href="../orders/order-details.php?id=1233" class="order-id">#1233</a></td>
                                <td>Aug 25, 2025</td>
                                <td>2 items</td>
                                <td><strong>₱650</strong></td>
                                <td><span class="order-status completed">Completed</span></td>
                                <td><a href="../orders/order-details.php?id=1233" class="btn btn-secondary" style="font-size: 0.8rem; padding: 0.4rem 0.8rem;">View</a></td>
                            </tr>
                            <tr>
                                <td><a href="../orders/order-details.php?id=1232" class="order-id">#1232</a></td>
                                <td>Aug 20, 2025</td>
                                <td>5 items</td>
                                <td><strong>₱1,200</strong></td>
                                <td><span class="order-status completed">Completed</span></td>
                                <td><a href="../orders/order-details.php?id=1232" class="btn btn-secondary" style="font-size: 0.8rem; padding: 0.4rem 0.8rem;">View</a></td>
                            </tr>
                            <tr>
                                <td><a href="../orders/order-details.php?id=1231" class="order-id">#1231</a></td>
                                <td>Aug 15, 2025</td>
                                <td>1 item</td>
                                <td><strong>₱300</strong></td>
                                <td><span class="order-status cancelled">Cancelled</span></td>
                                <td><a href="../orders/order-details.php?id=1231" class="btn btn-secondary" style="font-size: 0.8rem; padding: 0.4rem 0.8rem;">View</a></td>
                            </tr>
                            <tr>
                                <td><a href="../orders/order-details.php?id=1230" class="order-id">#1230</a></td>
                                <td>Aug 10, 2025</td>
                                <td>4 items</td>
                                <td><strong>₱950</strong></td>
                                <td><span class="order-status completed">Completed</span></td>
                                <td><a href="../orders/order-details.php?id=1230" class="btn btn-secondary" style="font-size: 0.8rem; padding: 0.4rem 0.8rem;">View</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Activity Timeline -->
            <div style="margin-top: 2rem;">
                <div class="activity-timeline">
                    <div class="section-header">
                        <h4>Recent Activity</h4>
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
                    <div class="timeline-item">
                        <div class="timeline-content">
                            <div class="timeline-title">Account Created</div>
                            <div class="timeline-desc">Customer registered new account</div>
                            <div class="timeline-time">August 2024</div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        lucide.createIcons();
        // Add some interactive functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Animate stat cards on load
            const statCards = document.querySelectorAll('.stat-card');
            statCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });

            // Add click tracking for orders
            document.querySelectorAll('.order-id').forEach(link => {
                link.addEventListener('click', function(e) {
                    console.log('Viewing order:', this.textContent);
                });
            });

            // Add hover effects for timeline items
            document.querySelectorAll('.timeline-item').forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.backgroundColor = '#f8fafc';
                });
                item.addEventListener('mouseleave', function() {
                    this.style.backgroundColor = '';
                });
            });
        });
    </script>
</body>
</html>
