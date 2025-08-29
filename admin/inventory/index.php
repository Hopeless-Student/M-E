<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory - M & E Dashboard</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
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

          width: 200px;
          height: 200px;
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
            padding: 0 2rem 2rem;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 2rem;
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

        .nav-link i {
            margin-right: 1rem;
            width: 20px;
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

        /* Inventory Stats */
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
            border-left: 4px solid #1e40af;
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

        .stat-subtitle {
            font-size: 0.8rem;
            color: #64748b;
            margin-top: 0.25rem;
        }

        /* Charts Section */
        .charts-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .chart-container {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            height: 350px;
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
        }

        /* Inventory Controls */
        .inventory-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            gap: 1rem;
        }

        .search-filter {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .search-box {
            position: relative;
        }

        .search-box input {
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 0.9rem;
            width: 300px;
        }

        .search-box::before {
            content: '🔍';
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
        }

        .filter-select {
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: white;
            font-size: 0.9rem;
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

        .inventory-table {
            width: 100%;
            border-collapse: collapse;
        }

        .inventory-table th {
            background-color: #f8fafc;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #475569;
            font-size: 0.9rem;
            border-bottom: 2px solid #e2e8f0;
        }

        .inventory-table td {
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .inventory-table tr:hover {
            background-color: #f8fafc;
        }

        .product-info-cell {
            display: flex;
            align-items: center;
            gap: 1rem;
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
            transition: background-color 0.2s ease;
            margin-right: 0.5rem;
        }

        .action-btn:hover {
            background-color: #1e3a8a;
        }

        .action-btn.secondary {
            background-color: #64748b;
        }

        .action-btn.secondary:hover {
            background-color: #475569;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem;
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

        @media (max-width: 768px) {
            .dashboard {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
            }

            .inventory-controls {
                flex-direction: column;
                align-items: stretch;
            }

            .search-filter {
                flex-direction: column;
            }

            .search-box input {
                width: 100%;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .charts-section {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
  <div class="dashboard">

      <nav class="sidebar">
          <div class="logo">
              <img src="M-E_logo.png" alt="">
          </div>
          <ul class="nav-menu">
              <li class="nav-item">
                  <a href="../index.php" class="nav-link">
                      <i>📊</i> Dashboard
                  </a>
              </li>
              <li class="nav-item">
                  <a href="../orders/index.php" class="nav-link">
                      <i>📦</i> Orders
                  </a>
              </li>
              <li class="nav-item">
                  <a href="../products/index.php" class="nav-link">
                      <i>🛍️</i> Products
                  </a>
              </li>
              <li class="nav-item">
                  <a href="../users/index.php" class="nav-link">
                      <i>👥</i> Customers
                  </a>
              </li>
              <li class="nav-item">
                  <a href="./inventory.php" class="nav-link active">
                      <i>📋</i> Inventory
                  </a>
              </li>
              <li class="nav-item">
                  <a href="../requests/index.php" class="nav-link">
                      <i>💬</i> Messages
                  </a>
              </li>
              <li class="nav-item">
                  <a href="../settings/index.php" class="nav-link">
                      <i>⚙️</i> Settings
                  </a>
              </li>
          </ul>
      </nav>
        <!-- Main Content -->
        <main class="main-content">
            <div class="header">
                <h2>Inventory Management</h2>
                <div class="user-info">
                    <span>Admin Panel</span>
                    <div class="avatar">A</div>
                </div>
            </div>

            <!-- Inventory Stats -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-title">Total Products</div>
                    <div class="stat-value">156</div>
                    <div class="stat-subtitle">Across 3 categories</div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">Low Stock Items</div>
                    <div class="stat-value">12</div>
                    <div class="stat-subtitle">Need restocking</div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">Out of Stock</div>
                    <div class="stat-value">3</div>
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
                <button class="export-btn">Export Report</button>
            </div>

            <!-- Inventory Table -->
            <div class="inventory-section">
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
                    <tbody>
                        <tr data-category="office">
                            <td>
                                <div class="product-info-cell">
                                    <div class="product-icon">🖊️</div>
                                    <div class="product-details">
                                        <h4>Ballpoint Pens</h4>
                                        <p>Pack of 12</p>
                                    </div>
                                </div>
                            </td>
                            <td><span class="category-badge">Office Supplies</span></td>
                            <td>OFF-PEN-001</td>
                            <td>
                                <div class="stock-level high">150</div>
                                <div class="stock-bar">
                                    <div class="stock-fill high" style="width: 85%;"></div>
                                </div>
                            </td>
                            <td>20</td>
                            <td>₱180</td>
                            <td><strong>₱27,000</strong></td>
                            <td>
                                <button class="action-btn">Adjust</button>
                                <button class="action-btn secondary">History</button>
                            </td>
                        </tr>
                        <tr data-category="office">
                            <td>
                                <div class="product-info-cell">
                                    <div class="product-icon">📄</div>
                                    <div class="product-details">
                                        <h4>Bond Paper</h4>
                                        <p>1 Ream (500 sheets)</p>
                                    </div>
                                </div>
                            </td>
                            <td><span class="category-badge">Office Supplies</span></td>
                            <td>OFF-PAP-001</td>
                            <td>
                                <div class="stock-level high">75</div>
                                <div class="stock-bar">
                                    <div class="stock-fill high" style="width: 75%;"></div>
                                </div>
                            </td>
                            <td>10</td>
                            <td>₱320</td>
                            <td><strong>₱24,000</strong></td>
                            <td>
                                <button class="action-btn">Adjust</button>
                                <button class="action-btn secondary">History</button>
                            </td>
                        </tr>
                        <tr data-category="office">
                            <td>
                                <div class="product-info-cell">
                                    <div class="product-icon">📁</div>
                                    <div class="product-details">
                                        <h4>File Folders</h4>
                                        <p>Pack of 10</p>
                                    </div>
                                </div>
                            </td>
                            <td><span class="category-badge">Office Supplies</span></td>
                            <td>OFF-FOL-001</td>
                            <td>
                                <div class="stock-level low">8</div>
                                <div class="stock-bar">
                                    <div class="stock-fill low" style="width: 20%;"></div>
                                </div>
                            </td>
                            <td>15</td>
                            <td>₱250</td>
                            <td><strong>₱2,000</strong></td>
                            <td>
                                <button class="action-btn">Adjust</button>
                                <button class="action-btn secondary">History</button>
                            </td>
                        </tr>
                        <tr data-category="school">
                            <td>
                                <div class="product-info-cell">
                                    <div class="product-icon">📔</div>
                                    <div class="product-details">
                                        <h4>Spiral Notebooks</h4>
                                        <p>Pack of 5</p>
                                    </div>
                                </div>
                            </td>
                            <td><span class="category-badge">School Supplies</span></td>
                            <td>SCH-NOT-001</td>
                            <td>
                                <div class="stock-level high">200</div>
                                <div class="stock-bar">
                                    <div class="stock-fill high" style="width: 90%;"></div>
                                </div>
                            </td>
                            <td>25</td>
                            <td>₱125</td>
                            <td><strong>₱25,000</strong></td>
                            <td>
                                <button class="action-btn">Adjust</button>
                                <button class="action-btn secondary">History</button>
                            </td>
                        </tr>
                        <tr data-category="school">
                            <td>
                                <div class="product-info-cell">
                                    <div class="product-icon">✏️</div>
                                    <div class="product-details">
                                        <h4>No. 2 Pencils</h4>
                                        <p>Pack of 24</p>
                                    </div>
                                </div>
                            </td>
                            <td><span class="category-badge">School Supplies</span></td>
                            <td>SCH-PEN-001</td>
                            <td>
                                <div class="stock-level high">120</div>
                                <div class="stock-bar">
                                    <div class="stock-fill high" style="width: 80%;"></div>
                                </div>
                            </td>
                            <td>20</td>
                            <td>₱95</td>
                            <td><strong>₱11,400</strong></td>
                            <td>
                                <button class="action-btn">Adjust</button>
                                <button class="action-btn secondary">History</button>
                            </td>
                        </tr>
                        <tr data-category="sanitary">
                            <td>
                                <div class="product-info-cell">
                                    <div class="product-icon">🧴</div>
                                    <div class="product-details">
                                        <h4>Hand Sanitizer</h4>
                                        <p>500ml bottle</p>
                                    </div>
                                </div>
                            </td>
                            <td><span class="category-badge">Sanitary Supplies</span></td>
                            <td>SAN-HAN-001</td>
                            <td>
                                <div class="stock-level medium">90</div>
                                <div class="stock-bar">
                                    <div class="stock-fill medium" style="width: 60%;"></div>
                                </div>
                            </td>
                            <td>30</td>
                            <td>₱145</td>
                            <td><strong>₱13,050</strong></td>
                            <td>
                                <button class="action-btn">Adjust</button>
                                <button class="action-btn secondary">History</button>
                            </td>
                        </tr>
                        <tr data-category="sanitary">
                            <td>
                                <div class="product-info-cell">
                                    <div class="product-icon">🧻</div>
                                    <div class="product-details">
                                        <h4>Toilet Paper</h4>
                                        <p>12 rolls pack</p>
                                    </div>
                                </div>
                            </td>
                            <td><span class="category-badge">Sanitary Supplies</span></td>
                            <td>SAN-TOI-001</td>
                            <td>
                                <div class="stock-level low">12</div>
                                <div class="stock-bar">
                                    <div class="stock-fill low" style="width: 24%;"></div>
                                </div>
                            </td>
                            <td>25</td>
                            <td>₱280</td>
                            <td><strong>₱3,360</strong></td>
                            <td>
                                <button class="action-btn">Adjust</button>
                                <button class="action-btn secondary">History</button>
                            </td>
                        </tr>
                        <tr data-category="sanitary">
                            <td>
                                <div class="product-info-cell">
                                    <div class="product-icon">🧽</div>
                                    <div class="product-details">
                                        <h4>Cleaning Sponges</h4>
                                        <p>Pack of 6</p>
                                    </div>
                                </div>
                            </td>
                            <td><span class="category-badge">Sanitary Supplies</span></td>
                            <td>SAN-SPO-001</td>
                            <td>
                                <div class="stock-level low">0</div>
                                <div class="stock-bar">
                                    <div class="stock-fill low" style="width: 0%;"></div>
                                </div>
                            </td>
                            <td>20</td>
                            <td>₱65</td>
                            <td><strong>₱0</strong></td>
                            <td>
                                <button class="action-btn">Restock</button>
                                <button class="action-btn secondary">History</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="pagination">
                    <div class="pagination-info">
                        Showing 1-8 of 156 products
                    </div>
                    <div class="pagination-controls">
                        <button class="page-btn">Previous</button>
                        <button class="page-btn active">1</button>
                        <button class="page-btn">2</button>
                        <button class="page-btn">3</button>
                        <button class="page-btn">Next</button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Stock Chart
        const stockCtx = document.getElementById('stockChart').getContext('2d');
        new Chart(stockCtx, {
            type: 'bar',
            data: {
                labels: ['Office Supplies', 'School Supplies', 'Sanitary Supplies'],
                datasets: [{
                    label: 'Items in Stock',
                    data: [65, 58, 33],
                    backgroundColor: ['#1e40af', '#3b82f6', '#60a5fa'],
                    borderRadius: 6,
                    borderSkipped: false,
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
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(148, 163, 184, 0.2)'
                        }
                    }
                }
            }
        });

        // Turnover Chart
        const turnoverCtx = document.getElementById('turnoverChart').getContext('2d');
        new Chart(turnoverCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'],
                datasets: [{
                    label: 'Turnover Rate',
                    data: [2.1, 2.3, 2.8, 2.5, 3.1, 2.9, 3.4, 3.2],
                    borderColor: '#1e40af',
                    backgroundColor: 'rgba(30, 64, 175, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#1e40af',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 5
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
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(148, 163, 184, 0.2)'
                        },
                        ticks: {
                            callback: function(value) {
                                return value + 'x';
                            }
                        }
                    }
                }
            }
        });

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('.inventory-table tbody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });

        // Category filter
        document.getElementById('categoryFilter').addEventListener('change', function(e) {
            const filterValue = e.target.value;
            const rows = document.querySelectorAll('.inventory-table tbody tr');

            rows.forEach(row => {
                const category = row.dataset.category;
                row.style.display = !filterValue || category === filterValue ? '' : 'none';
            });
        });

        // Stock filter
        document.getElementById('stockFilter').addEventListener('change', function(e) {
            const filterValue = e.target.value;
            const rows = document.querySelectorAll('.inventory-table tbody tr');

            rows.forEach(row => {
                const stockLevel = row.querySelector('.stock-level').className;
                row.style.display = !filterValue || stockLevel.includes(filterValue) ? '' : 'none';
            });
        });

        // Action button functionality
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('action-btn')) {
                const action = e.target.textContent;
                const productName = e.target.closest('tr').querySelector('.product-details h4').textContent;
                alert(`${action} action for: ${productName}`);
            }
        });

        // Export functionality
        document.querySelector('.export-btn').addEventListener('click', function() {
            alert('Export inventory report functionality would generate and download a report here');
        });
    </script>
</body>
</html>
