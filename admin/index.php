<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M & E Dashboard</title>
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
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .header h2 {
            font-size: 2rem;
            font-weight: 600;
            color: #1e40af;
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

        /* Stats Cards */
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
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .stat-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .stat-title {
            color: #64748b;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 0.5rem;
        }

        .stat-change {
            font-size: 0.85rem;
            display: flex;
            align-items: center;
        }

        .positive { color: #059669; }
        .negative { color: #dc2626; }

        /* Charts Section */
        .charts-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .chart-container {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .chart-container.sales-chart {
            height: 400px;
        }

        .chart-container.category-chart {
            height: 400px;
        }

        .chart-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 1rem;
        }

        .chart-wrapper {
            position: relative;
            height: 320px;
        }

        /* Recent Orders Table */
        .orders-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .orders-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .orders-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1e40af;
        }

        .view-all {
            color: #1e40af;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
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
        }

        .orders-table td {
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .status {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .status.pending { background-color: #fef3c7; color: #92400e; }
        .status.processing { background-color: #dbeafe; color: #1d4ed8; }
        .status.delivered { background-color: #d1fae5; color: #065f46; }
        .status.shipped { background-color: #e0e7ff; color: #3730a3; }

        .category-badge {
            padding: 0.25rem 0.5rem;
            background-color: #e0e7ff;
            color: #1e40af;
            border-radius: 6px;
            font-size: 0.8rem;
        }

        @media (max-width: 768px) {
            .dashboard {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
            }

            .charts-grid {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
          <!-- <?php
          $currentPage = 'index.php';
          $basePath = '../';
          include './includes/sidebar.php';

           ?> -->

        <nav class="sidebar">
            <div class="logo">
                <img src="../assets/images/logo/ME Logo.png" alt="">
            </div>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="./index.php" class="nav-link active">
                        <i data-lucide="bar-chart-3"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../admin/orders/index.php" class="nav-link">
                        <i data-lucide="package"></i> Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../admin/products/index.php" class="nav-link">
                        <i data-lucide="shopping-cart"></i> Products
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../admin/users/index.php" class="nav-link">
                        <i data-lucide="users"></i> Customers
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../admin/inventory/index.php" class="nav-link">
                        <i data-lucide="clipboard-list"></i> Inventory
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../admin/requests/index.php" class="nav-link">
                        <i data-lucide="message-circle"></i> Messages
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../admin/settings/index.php" class="nav-link">
                        <i data-lucide="settings"></i> Settings
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="main-content">
            <div class="header">
                <h2>Dashboard Overview</h2>
                <div class="user-info">
                    <span>Elbar Como</span>
                    <div class="avatar">A</div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-title">Total Revenue</div>
                    <div class="stat-value">₱48,750</div>
                    <div class="stat-change positive">
                        ↗ +12.5% from last month
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">Total Orders</div>
                    <div class="stat-value">267</div>
                    <div class="stat-change positive">
                        ↗ +8.2% from last month
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">New Customers</div>
                    <div class="stat-value">52</div>
                    <div class="stat-change positive">
                        ↗ +15.3% from last month
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">Avg. Order Value</div>
                    <div class="stat-value">₱825</div>
                    <div class="stat-change negative">
                        ↘ -2.1% from last month
                    </div>
                </div>
            </div>

            <!-- Charts -->
            <div class="charts-grid">
                <div class="chart-container sales-chart">
                    <div class="chart-title">Sales Overview (Last 6 Months)</div>
                    <div class="chart-wrapper">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
                <div class="chart-container category-chart">
                    <div class="chart-title">Product Categories</div>
                    <div class="chart-wrapper">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="orders-section">
                <div class="orders-header">
                    <h3 class="orders-title">Recent Orders</h3>
                    <a href="../admin/orders/index.php" class="view-all">View All Orders</a>
                </div>
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Category</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#ORD-001</td>
                            <td>Juan Dela Cruz</td>
                            <td><span class="category-badge">Office Supplies</span></td>
                            <td>₱1,250</td>
                            <td>Aug 20, 2025</td>
                            <td><span class="status processing">Processing</span></td>
                        </tr>
                        <tr>
                            <td>#ORD-002</td>
                            <td>Maria Santos</td>
                            <td><span class="category-badge">School Supplies</span></td>
                            <td>₱890</td>
                            <td>Aug 19, 2025</td>
                            <td><span class="status shipped">Shipped</span></td>
                        </tr>
                        <tr>
                            <td>#ORD-003</td>
                            <td>Roberto Garcia</td>
                            <td><span class="category-badge">Sanitary Supplies</span></td>
                            <td>₱675</td>
                            <td>Aug 19, 2025</td>
                            <td><span class="status delivered">Delivered</span></td>
                        </tr>
                        <tr>
                            <td>#ORD-004</td>
                            <td>Ana Reyes</td>
                            <td><span class="category-badge">Office Supplies</span></td>
                            <td>₱1,420</td>
                            <td>Aug 18, 2025</td>
                            <td><span class="status pending">Pending</span></td>
                        </tr>
                        <tr>
                            <td>#ORD-005</td>
                            <td>Carlos Mendoza</td>
                            <td><span class="category-badge">School Supplies</span></td>
                            <td>₱750</td>
                            <td>Aug 18, 2025</td>
                            <td><span class="status delivered">Delivered</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Sales Chart
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: ['March', 'April', 'May', 'June', 'July', 'August'],
                datasets: [{
                    label: 'Revenue (₱)',
                    data: [35000, 42000, 38000, 45000, 52000, 48750],
                    borderColor: '#1e40af',
                    backgroundColor: 'rgba(30, 64, 175, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#1e40af',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#64748b',
                            font: {
                                size: 12
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(148, 163, 184, 0.2)'
                        },
                        ticks: {
                            color: '#64748b',
                            font: {
                                size: 12
                            },
                            callback: function(value) {
                                return '₱' + value.toLocaleString();
                            }
                        }
                    }
                },
                elements: {
                    point: {
                        hoverBackgroundColor: '#1e40af',
                        hoverBorderColor: '#ffffff'
                    }
                }
            }
        });

        // Category Chart
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: ['Office Supplies', 'School Supplies', 'Sanitary Supplies'],
                datasets: [{
                    data: [45, 35, 20],
                    backgroundColor: [
                        '#1e40af',
                        '#3b82f6',
                        '#60a5fa'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    }
                }
            }
        });

    </script>
</body>
</html>
