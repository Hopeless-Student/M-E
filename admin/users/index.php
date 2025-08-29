<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers - M & E Dashboard</title>
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
            flex-shrink: 0;
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
            overflow-x: auto;
            min-width: 0;
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

        /* Customer Stats */
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

        /* Customer Controls */
        .customer-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .search-filter {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
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
            max-width: 100%;
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
            min-width: 150px;
        }

        /* Customers Table */
        .customers-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .table-container {
            overflow-x: auto;
        }

        .customers-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
        }

        .customers-table th {
            background-color: #f8fafc;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #475569;
            font-size: 0.9rem;
            border-bottom: 2px solid #e2e8f0;
            white-space: nowrap;
        }

        .customers-table td {
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: middle;
        }

        .customers-table tr:hover {
            background-color: #f8fafc;
        }

        .customer-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
            flex-shrink: 0;
        }

        .customer-info {
            display: flex;
            align-items: center;
            gap: 1rem;
            min-width: 200px;
        }

        .customer-details h4 {
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 0.25rem;
            white-space: nowrap;
        }

        .customer-details p {
            font-size: 0.85rem;
            color: #64748b;
            white-space: nowrap;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            white-space: nowrap;
        }

        .status-badge.active { background-color: #d1fae5; color: #065f46; }
        .status-badge.inactive { background-color: #fee2e2; color: #dc2626; }
        .status-badge.new { background-color: #dbeafe; color: #1d4ed8; }

        .action-btn {
            padding: 0.5rem 1rem;
            background-color: #1e40af;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.8rem;
            transition: background-color 0.2s ease;
            white-space: nowrap;
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

        .actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
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
        }

        @media (max-width: 768px) {
            .header h2 {
                font-size: 1.5rem;
            }

            .customer-controls {
                flex-direction: column;
                align-items: stretch;
            }

            .search-filter {
                flex-direction: column;
                width: 100%;
            }

            .search-box input {
                width: 100%;
            }

            .filter-select {
                width: 100%;
            }

            .stats-grid {
                grid-template-columns: 1fr;
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
            .main-content {
                padding: 0.5rem;
            }

            .header {
                text-align: center;
            }

            .actions {
                flex-direction: column;
            }

            .action-btn {
                width: 100%;
                text-align: center;
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
                  <a href="./users/index.php" class="nav-link active">
                      <i>👥</i> Customers
                  </a>
              </li>
              <li class="nav-item">
                  <a href="../inventory/index.php" class="nav-link">
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
                <h2>Customer Management</h2>
                <div class="user-info">
                    <span>Admin Panel</span>
                    <div class="avatar">A</div>
                </div>
            </div>

            <!-- Customer Stats -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-title">Total Customers</div>
                    <div class="stat-value">142</div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">New This Month</div>
                    <div class="stat-value">23</div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">Active Customers</div>
                    <div class="stat-value">127</div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">Repeat Customers</div>
                    <div class="stat-value">89</div>
                </div>
            </div>

            <!-- Customer Controls -->
            <div class="customer-controls">
                <div class="search-filter">
                    <div class="search-box">
                        <input type="text" placeholder="Search customers..." id="searchInput">
                    </div>
                    <select class="filter-select" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="new">New</option>
                    </select>
                </div>
            </div>

            <!-- Customers Table -->
            <div class="customers-section">
                <div class="table-container">
                    <table class="customers-table">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Location</th>
                                <th>Orders</th>
                                <th>Total Spent</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="customer-info">
                                        <div class="customer-avatar">JD</div>
                                        <div class="customer-details">
                                            <h4>Juan Dela Cruz</h4>
                                            <p>Member since Aug 2024</p>
                                        </div>
                                    </div>
                                </td>
                                <td>juan.delacruz@email.com</td>
                                <td>+63 917 123 4567</td>
                                <td>Olongapo City</td>
                                <td>8</td>
                                <td><strong>₱4,250</strong></td>
                                <td><span class="status-badge active">Active</span></td>
                                <td>
                                    <div class="actions">
                                        <button class="action-btn">View</button>
                                        <button class="action-btn secondary">Message</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="customer-info">
                                        <div class="customer-avatar">RG</div>
                                        <div class="customer-details">
                                            <h4>Roberto Garcia</h4>
                                            <p>Member since Jun 2024</p>
                                        </div>
                                    </div>
                                </td>
                                <td>roberto.garcia@email.com</td>
                                <td>+63 919 345 6789</td>
                                <td>Olongapo City</td>
                                <td>5</td>
                                <td><strong>₱2,180</strong></td>
                                <td><span class="status-badge active">Active</span></td>
                                <td>
                                    <div class="actions">
                                        <button class="action-btn">View</button>
                                        <button class="action-btn secondary">Message</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="customer-info">
                                        <div class="customer-avatar">AR</div>
                                        <div class="customer-details">
                                            <h4>Ana Reyes</h4>
                                            <p>Member since Aug 2025</p>
                                        </div>
                                    </div>
                                </td>
                                <td>ana.reyes@email.com</td>
                                <td>+63 920 456 7890</td>
                                <td>Olongapo City</td>
                                <td>2</td>
                                <td><strong>₱1,850</strong></td>
                                <td><span class="status-badge new">New</span></td>
                                <td>
                                    <div class="actions">
                                        <button class="action-btn">View</button>
                                        <button class="action-btn secondary">Message</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="customer-info">
                                        <div class="customer-avatar">CM</div>
                                        <div class="customer-details">
                                            <h4>Carlos Mendoza</h4>
                                            <p>Member since May 2024</p>
                                        </div>
                                    </div>
                                </td>
                                <td>carlos.mendoza@email.com</td>
                                <td>+63 921 567 8901</td>
                                <td>Olongapo City</td>
                                <td>15</td>
                                <td><strong>₱8,900</strong></td>
                                <td><span class="status-badge active">Active</span></td>
                                <td>
                                    <div class="actions">
                                        <button class="action-btn">View</button>
                                        <button class="action-btn secondary">Message</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="customer-info">
                                        <div class="customer-avatar">LF</div>
                                        <div class="customer-details">
                                            <h4>Lisa Fernandez</h4>
                                            <p>Member since Apr 2024</p>
                                        </div>
                                    </div>
                                </td>
                                <td>lisa.fernandez@email.com</td>
                                <td>+63 922 678 9012</td>
                                <td>Olongapo City</td>
                                <td>3</td>
                                <td><strong>₱1,200</strong></td>
                                <td><span class="status-badge inactive">Inactive</span></td>
                                <td>
                                    <div class="actions">
                                        <button class="action-btn">View</button>
                                        <button class="action-btn secondary">Message</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="customer-info">
                                        <div class="customer-avatar">MT</div>
                                        <div class="customer-details">
                                            <h4>Miguel Torres</h4>
                                            <p>Member since Mar 2024</p>
                                        </div>
                                    </div>
                                </td>
                                <td>miguel.torres@email.com</td>
                                <td>+63 923 789 0123</td>
                                <td>Olongapo City</td>
                                <td>7</td>
                                <td><strong>₱3,450</strong></td>
                                <td><span class="status-badge active">Active</span></td>
                                <td>
                                    <div class="actions">
                                        <button class="action-btn">View</button>
                                        <button class="action-btn secondary">Message</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="customer-info">
                                        <div class="customer-avatar">CL</div>
                                        <div class="customer-details">
                                            <h4>Carmen Lopez</h4>
                                            <p>Member since Aug 2025</p>
                                        </div>
                                    </div>
                                </td>
                                <td>carmen.lopez@email.com</td>
                                <td>+63 924 890 1234</td>
                                <td>Olongapo City</td>
                                <td>1</td>
                                <td><strong>₱450</strong></td>
                                <td><span class="status-badge new">New</span></td>
                                <td>
                                    <div class="actions">
                                        <button class="action-btn">View</button>
                                        <button class="action-btn secondary">Message</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="customer-info">
                                        <div class="customer-avatar">MS</div>
                                        <div class="customer-details">
                                            <h4>Maria Santos</h4>
                                            <p>Member since Jul 2024</p>
                                        </div>
                                    </div>
                                </td>
                                <td>maria.santos@email.com</td>
                                <td>+63 918 234 5678</td>
                                <td>Olongapo City</td>
                                <td>12</td>
                                <td><strong>₱6,780</strong></td>
                                <td><span class="status-badge active">Active</span></td>
                                <td>
                                    <div class="actions">
                                        <button class="action-btn">View</button>
                                        <button class="action-btn secondary">Message</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination">
                    <div class="pagination-info">
                        Showing 1-8 of 142 customers
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
        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('.customers-table tbody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });

            updatePaginationInfo();
        });

        // Status filter
        document.getElementById('statusFilter').addEventListener('change', function(e) {
            const filterValue = e.target.value;
            const rows = document.querySelectorAll('.customers-table tbody tr');

            rows.forEach(row => {
                const status = row.querySelector('.status-badge').textContent.toLowerCase();
                row.style.display = !filterValue || status.includes(filterValue) ? '' : 'none';
            });

            updatePaginationInfo();
        });

        // Action button functionality
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('action-btn')) {
                const action = e.target.textContent;
                const customerName = e.target.closest('tr').querySelector('.customer-details h4').textContent;
                alert(`${action} action for customer: ${customerName}`);
            }
        });

        // Update pagination info based on visible rows
        function updatePaginationInfo() {
            const visibleRows = document.querySelectorAll('.customers-table tbody tr:not([style*="display: none"])');
            const totalRows = document.querySelectorAll('.customers-table tbody tr').length;
            const paginationInfo = document.querySelector('.pagination-info');

            if (paginationInfo) {
                paginationInfo.textContent = `Showing ${visibleRows.length} of ${totalRows} customers`;
            }
        }

        // Pagination button functionality
        document.querySelectorAll('.page-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                if (!this.classList.contains('active') && this.textContent !== 'Previous' && this.textContent !== 'Next') {
                    document.querySelector('.page-btn.active').classList.remove('active');
                    this.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>
