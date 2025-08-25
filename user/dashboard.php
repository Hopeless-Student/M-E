<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account - M&E Interior Supplies</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            color: #333;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 2rem;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            transition: opacity 0.3s;
        }

        .nav-links a:hover {
            opacity: 0.8;
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 2rem;
        }

        .sidebar {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            height: fit-content;
            position: sticky;
            top: 2rem;
        }

        .user-info {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid #f0f0f0;
        }

        .user-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            margin: 0 auto 1rem;
        }

        .sidebar ul {
            list-style: none;
        }

        .sidebar li {
            margin-bottom: 0.5rem;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: #555;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .sidebar a:hover, .sidebar a.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: translateX(5px);
        }

        .sidebar-icon {
            margin-right: 0.75rem;
            font-size: 1.1rem;
        }

        .main-content {
            background: white;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .dashboard-header {
            margin-bottom: 2rem;
        }

        .dashboard-title {
            font-size: 2rem;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .breadcrumb {
            color: #666;
            font-size: 0.9rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 1.5rem;
            border-radius: 10px;
            text-align: center;
            transition: transform 0.3s;
        }

        .stat-card:nth-child(2) {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .stat-card:nth-child(3) {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }

        .stat-card:nth-child(4) {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .recent-section {
            margin-bottom: 2rem;
        }

        .section-title {
            font-size: 1.3rem;
            margin-bottom: 1rem;
            color: #333;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .view-all {
            color: #667eea;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .orders-list {
            background: #f8f9fa;
            border-radius: 8px;
            overflow: hidden;
        }

        .order-item {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e9ecef;
            transition: background-color 0.3s;
        }

        .order-item:hover {
            background: #e9ecef;
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .order-id {
            font-weight: bold;
            color: #667eea;
            margin-right: 1rem;
        }

        .order-details {
            flex-grow: 1;
        }

        .order-date {
            font-size: 0.85rem;
            color: #666;
        }

        .order-status {
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-processing {
            background: #d1ecf1;
            color: #0c5460;
        }

        .status-shipped {
            background: #d4edda;
            color: #155724;
        }

        .status-delivered {
            background: #d1f2eb;
            color: #00695c;
        }

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 2rem;
        }

        .action-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem;
            border-radius: 10px;
            text-align: center;
            text-decoration: none;
            transition: all 0.3s;
        }

        .action-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }

        .action-icon {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        @media (max-width: 768px) {
            .container {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .sidebar {
                position: static;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .header-content {
                flex-direction: column;
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-content">
            <div class="logo">M&E Interior Supplies</div>
            <nav class="nav-links">
                <a href="/">Home</a>
                <a href="/shop">Shop</a>
                <a href="/contact">Contact</a>
                <a href="/logout">Logout</a>
            </nav>
        </div>
    </header>

    <div class="container">
        <aside class="sidebar">
            <div class="user-info">
                <div class="user-avatar">JD</div>
                <h3>John Dela Cruz</h3>
                <p>john.delacruz@email.com</p>
            </div>
            <ul>
                <li><a href="#" class="active"><span class="sidebar-icon">📊</span>Dashboard</a></li>
                <li><a href="#"><span class="sidebar-icon">📋</span>Order History</a></li>
                <li><a href="#"><span class="sidebar-icon">👤</span>Profile Settings</a></li>
                <li><a href="#"><span class="sidebar-icon">📍</span>Addresses</a></li>
                <li><a href="#"><span class="sidebar-icon">💬</span>My Requests</a></li>
                <li><a href="#"><span class="sidebar-icon">🔒</span>Change Password</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <div class="dashboard-header">
                <h1 class="dashboard-title">Welcome back, John!</h1>
                <p class="breadcrumb">Dashboard → Overview</p>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">12</div>
                    <div class="stat-label">Total Orders</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">2</div>
                    <div class="stat-label">Pending Orders</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">₱15,240</div>
                    <div class="stat-label">Total Spent</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">3</div>
                    <div class="stat-label">Active Requests</div>
                </div>
            </div>

            <div class="recent-section">
                <h2 class="section-title">
                    Recent Orders
                    <a href="#" class="view-all">View All →</a>
                </h2>
                <div class="orders-list">
                    <div class="order-item">
                        <span class="order-id">#ORD-2024-001</span>
                        <div class="order-details">
                            <div>Office Supplies Bundle</div>
                            <div class="order-date">Ordered on March 15, 2024 • ₱2,350</div>
                        </div>
                        <span class="order-status status-shipped">Shipped</span>
                    </div>
                    <div class="order-item">
                        <span class="order-id">#ORD-2024-002</span>
                        <div class="order-details">
                            <div>School Supplies Set</div>
                            <div class="order-date">Ordered on March 12, 2024 • ₱1,890</div>
                        </div>
                        <span class="order-status status-processing">Processing</span>
                    </div>
                    <div class="order-item">
                        <span class="order-id">#ORD-2024-003</span>
                        <div class="order-details">
                            <div>Sanitary Supplies</div>
                            <div class="order-date">Ordered on March 10, 2024 • ₱950</div>
                        </div>
                        <span class="order-status status-delivered">Delivered</span>
                    </div>
                </div>
            </div>

            <div class="quick-actions">
                <a href="#" class="action-card">
                    <div class="action-icon">🛒</div>
                    <div>Continue Shopping</div>
                </a>
                <a href="#" class="action-card">
                    <div class="action-icon">📦</div>
                    <div>Track Order</div>
                </a>
                <a href="#" class="action-card">
                    <div class="action-icon">💬</div>
                    <div>Submit Request</div>
                </a>
                <a href="#" class="action-card">
                    <div class="action-icon">📞</div>
                    <div>Contact Support</div>
                </a>
            </div>
        </main>
    </div>
</body>
</html>
