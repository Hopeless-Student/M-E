<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders - M & E Dashboard</title>
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

        .logo img {
            width: 120px;
            height: 60px;
            object-fit: contain;
            margin-bottom: 0.5rem;
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
            font-size: 1.2rem;
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

        /* Orders Controls */
        .orders-controls {
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
            outline: none;
            transition: border-color 0.2s ease;
        }

        .search-box input:focus {
            border-color: #1e40af;
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
            outline: none;
            cursor: pointer;
        }

        .filter-select:focus {
            border-color: #1e40af;
        }

        .add-order-btn {
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .add-order-btn:hover {
            transform: translateY(-1px);
        }

        /* Orders Table */
        .orders-section {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
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
            border-bottom: 2px solid #e2e8f0;
        }

        .orders-table td {
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .orders-table tr:hover {
            background-color: #f8fafc;
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

        .action-btn.danger {
            background-color: #dc2626;
        }

        .action-btn.danger:hover {
            background-color: #b91c1c;
        }

        .actions {
            display: flex;
            gap: 0.5rem;
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

            .orders-controls {
                flex-direction: column;
                align-items: stretch;
            }

            .search-filter {
                flex-direction: column;
            }

            .search-box input {
                width: 100%;
            }

            .actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <nav class="sidebar">
            <div class="logo">
                <h1>M & E</h1>
                <p>Supply Management</p>
            </div>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="../index.php" class="nav-link">
                        <i>📊</i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./index.php" class="nav-link active">
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
                <h2>Orders Management</h2>
                <div class="user-info">
                    <span>Elbar Como</span>
                    <div class="avatar">E</div>
                </div>
            </div>

            <!-- Orders Controls -->
            <div class="orders-controls">
                <div class="search-filter">
                    <div class="search-box">
                        <input type="text" placeholder="Search orders..." id="searchInput">
                    </div>
                    <select class="filter-select" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
                    </select>
                    <select class="filter-select" id="categoryFilter">
                        <option value="">All Categories</option>
                        <option value="office">Office Supplies</option>
                        <option value="school">School Supplies</option>
                        <option value="sanitary">Sanitary Supplies</option>
                    </select>
                </div>
                <button class="add-order-btn">+ Add New Order</button>
            </div>

            <!-- Orders Table -->
            <div class="orders-section">
                <table class="orders-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Category</th>
                            <th>Items</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>#ORD-001</strong></td>
                            <td>Cjay Gonzales</td>
                            <td><span class="category-badge">Office Supplies</span></td>
                            <td>Ballpens (50pcs), Bond Paper (5 reams)</td>
                            <td><strong>₱1,250</strong></td>
                            <td>Aug 20, 2025</td>
                            <td><span class="status processing">Processing</span></td>
                            <td>
                                <div class="actions">
                                    <a href="order-details.php?id=001" class="action-btn secondary">View</a>
                                    <a href="update-status.php?id=001" class="action-btn">Update</a>
                                    <a href="print-invoice.php?id=001" class="action-btn" target="_blank">Print</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>#ORD-002</strong></td>
                            <td>Joshua Lapitan</td>
                            <td><span class="category-badge">School Supplies</span></td>
                            <td>Notebooks (20pcs), Pencils (100pcs)</td>
                            <td><strong>₱890</strong></td>
                            <td>Aug 19, 2025</td>
                            <td><span class="status shipped">Shipped</span></td>
                            <td>
                                <div class="actions">
                                    <a href="order-details.php?id=002" class="action-btn secondary">View</a>
                                    <a href="update-status.php?id=002" class="action-btn">Update</a>
                                    <a href="print-invoice.php?id=002" class="action-btn" target="_blank">Print</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>#ORD-003</strong></td>
                            <td>Prince Ace Masinsin</td>
                            <td><span class="category-badge">Sanitary Supplies</span></td>
                            <td>Hand Soap (10 bottles), Tissue (24 rolls)</td>
                            <td><strong>₱675</strong></td>
                            <td>Aug 19, 2025</td>
                            <td><span class="status delivered">Delivered</span></td>
                            <td>
                                <div class="actions">
                                    <a href="order-details.php?id=003" class="action-btn secondary">View</a>
                                    <a href="update-status.php?id=003" class="action-btn">Update</a>
                                    <a href="print-invoice.php?id=003" class="action-btn" target="_blank">Print</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>#ORD-004</strong></td>
                            <td>Gillian Lorenzo</td>
                            <td><span class="category-badge">Office Supplies</span></td>
                            <td>Folders (25pcs), Staplers (5pcs)</td>
                            <td><strong>₱1,420</strong></td>
                            <td>Aug 18, 2025</td>
                            <td><span class="status pending">Pending</span></td>
                            <td>
                                <div class="actions">
                                    <a href="order-details.php?id=004" class="action-btn secondary">View</a>
                                    <a href="update-status.php?id=004" class="action-btn">Update</a>
                                    <a href="print-invoice.php?id=004" class="action-btn" target="_blank">Print</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>#ORD-005</strong></td>
                            <td>Kenji Chua</td>
                            <td><span class="category-badge">School Supplies</span></td>
                            <td>Crayons (15 sets), Drawing Paper (200 sheets)</td>
                            <td><strong>₱750</strong></td>
                            <td>Aug 18, 2025</td>
                            <td><span class="status delivered">Delivered</span></td>
                            <td>
                                <div class="actions">
                                    <a href="order-details.php?id=005" class="action-btn secondary">View</a>
                                    <a href="update-status.php?id=005" class="action-btn">Update</a>
                                    <a href="print-invoice.php?id=005" class="action-btn" target="_blank">Print</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>#ORD-006</strong></td>
                            <td>Angel Bien</td>
                            <td><span class="category-badge">Office Supplies</span></td>
                            <td>Paper Clips (500pcs), Rubber Bands (200pcs)</td>
                            <td><strong>₱320</strong></td>
                            <td>Aug 17, 2025</td>
                            <td><span class="status processing">Processing</span></td>
                            <td>
                                <div class="actions">
                                    <a href="order-details.php?id=006" class="action-btn secondary">View</a>
                                    <a href="update-status.php?id=006" class="action-btn">Update</a>
                                    <a href="print-invoice.php?id=006" class="action-btn" target="_blank">Print</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>#ORD-007</strong></td>
                            <td>Miguel Torres</td>
                            <td><span class="category-badge">Sanitary Supplies</span></td>
                            <td>Disinfectant (5 bottles), Masks (100pcs)</td>
                            <td><strong>₱980</strong></td>
                            <td>Aug 17, 2025</td>
                            <td><span class="status shipped">Shipped</span></td>
                            <td>
                                <div class="actions">
                                    <a href="order-details.php?id=007" class="action-btn secondary">View</a>
                                    <a href="update-status.php?id=007" class="action-btn">Update</a>
                                    <a href="print-invoice.php?id=007" class="action-btn" target="_blank">Print</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>#ORD-008</strong></td>
                            <td>Carmen Lopez</td>
                            <td><span class="category-badge">School Supplies</span></td>
                            <td>Erasers (50pcs), Rulers (20pcs)</td>
                            <td><strong>₱450</strong></td>
                            <td>Aug 16, 2025</td>
                            <td><span class="status delivered">Delivered</span></td>
                            <td>
                                <div class="actions">
                                    <a href="order-details.php?id=008" class="action-btn secondary">View</a>
                                    <a href="update-status.php?id=008" class="action-btn">Update</a>
                                    <a href="print-invoice.php?id=008" class="action-btn" target="_blank">Print</a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="pagination">
                    <div class="pagination-info">
                        Showing 1-8 of 267 orders
                    </div>
                    <div class="pagination-controls">
                        <button class="page-btn">Previous</button>
                        <button class="page-btn active">1</button>
                        <button class="page-btn">2</button>
                        <button class="page-btn">3</button>
                        <button class="page-btn">4</button>
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
            const rows = document.querySelectorAll('.orders-table tbody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });

        // Status filter functionality
        document.getElementById('statusFilter').addEventListener('change', function(e) {
            const filterValue = e.target.value;
            const rows = document.querySelectorAll('.orders-table tbody tr');

            rows.forEach(row => {
                const status = row.querySelector('.status').textContent.toLowerCase();
                row.style.display = !filterValue || status.includes(filterValue) ? '' : 'none';
            });
        });

        // Category filter functionality
        document.getElementById('categoryFilter').addEventListener('change', function(e) {
            const filterValue = e.target.value;
            const rows = document.querySelectorAll('.orders-table tbody tr');

            rows.forEach(row => {
                const category = row.querySelector('.category-badge').textContent.toLowerCase();
                row.style.display = !filterValue || category.includes(filterValue) ? '' : 'none';
            });
        });

        // Pagination functionality
        document.querySelectorAll('.page-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                if (this.textContent !== 'Previous' && this.textContent !== 'Next') {
                    document.querySelector('.page-btn.active').classList.remove('active');
                    this.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>
