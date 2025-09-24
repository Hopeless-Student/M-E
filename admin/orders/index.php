<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders - M & E Dashboard</title>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <link rel="stylesheet" href="../assets/css/admin/orders/index.css">
</head>
<body>
    <div class="dashboard">
        <!-- Mobile Menu Button -->
        <button class="mobile-menu-btn" data-sidebar-toggle="open">
            <i data-lucide="menu"></i>
        </button>

        <?php include '../../includes/admin_sidebar.php'; ?>

        <!-- Main Content -->
        <main class="main-content">
            <div class="header">
                <h2>Orders Management</h2>
                <div class="user-info">
                    <span>Elbar Como</span>
                    <div class="avatar">E</div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="quick-stats">
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-title">Pending</div>
                        <i data-lucide="circle-dashed" class="stat-icon"></i>
                    </div>
                    <div class="stat-value" id="totalPending">0</div>
                    <div class="stat-change neutral">Pending Orders</div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-title">Processing</div>
                        <i data-lucide="circle-dot-dashed" class="stat-icon"></i>
                    </div>
                    <div class="stat-value" id="totalProcessing">0</div>
                    <div class="stat-change neutral">Orders in Process</div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-title">Shipped</div>
                        <i data-lucide="truck" class="stat-icon"></i>
                    </div>
                    <div class="stat-value" id="totalShipped">0</div>
                    <div class="stat-change neutral">Orders in transit</div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-title">Delivered</div>
                        <i data-lucide="package-check " class="stat-icon"></i>
                    </div>
                    <div class="stat-value" id="totalDeliver">0</div>
                    <div class="stat-change neutral">Delivered Orders</div>
                </div>
            </div>
            <!-- Orders Controls -->
            <div class="orders-controls">
                <div class="search-filter">
                    <div class="search-box">
                        <i data-lucide="search" class="search-icon"></i>
                        <input type="text" class="search-input" id="searchInput" placeholder="Search orders...">
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
                        <option value="flooring">Flooring</option>
                        <option value="tiles">Tiles</option>
                        <option value="fixtures">Fixtures</option>
                    </select>
                </div>
                <!-- <button class="add-order-btn">
                    <i data-lucide="plus"></i>
                    Add New Order
                </button> -->
            </div>

            <!-- Orders Table -->
            <div class="orders-section">
                <div class="table-container">
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
                                <td><span class="category-badge">Flooring</span></td>
                                <td>3 items</td>
                                <td><strong>₱12,500</strong></td>
                                <td>Sep 20, 2024</td>
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
                                <td><span class="category-badge">Tiles</span></td>
                                <td>5 items</td>
                                <td><strong>₱8,900</strong></td>
                                <td>Sep 19, 2024</td>
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
                                <td><span class="category-badge">Fixtures</span></td>
                                <td>2 items</td>
                                <td><strong>₱6,750</strong></td>
                                <td>Sep 19, 2024</td>
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
                                <td><span class="category-badge">Flooring</span></td>
                                <td>4 items</td>
                                <td><strong>₱14,200</strong></td>
                                <td>Sep 18, 2024</td>
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
                                <td><span class="category-badge">Tiles</span></td>
                                <td>1 item</td>
                                <td><strong>₱7,500</strong></td>
                                <td>Sep 18, 2024</td>
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
                                <td><span class="category-badge">Fixtures</span></td>
                                <td>2 items</td>
                                <td><strong>₱3,200</strong></td>
                                <td>Sep 17, 2024</td>
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
                                <td><span class="category-badge">Flooring</span></td>
                                <td>3 items</td>
                                <td><strong>₱19,800</strong></td>
                                <td>Sep 17, 2024</td>
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
                                <td><span class="category-badge">Tiles</span></td>
                                <td>2 items</td>
                                <td><strong>₱4,500</strong></td>
                                <td>Sep 16, 2024</td>
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
                </div>

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
    lucide.createIcons();
    function updateStats() {
        const totalProducts = allProducts.length;
        const lowStockProducts = allProducts.filter(p => p.stock > 0 && p.stock <= 15).length;
        const outOfStock = allProducts.filter(p => p.stock === 0).length;

        document.getElementById('totalProducts').textContent = totalProducts;
        document.getElementById('lowStockProducts').textContent = lowStockProducts;
        document.getElementById('outOfStock').textContent = outOfStock;
    }
        // Global variables for pagination and data
        let currentPage = 1;
        let totalPages = 1;
        let allOrders = [];
        let filteredOrders = [];
        const ordersPerPage = 8;

        // Load orders data on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadOrdersData();
        });

        async function loadOrdersData() {
            try {
                // Replace this with actual API call
                // const response = await fetch('/api/orders.php');
                // const result = await response.json();

                // Mock data for now
                const result = {
                    success: true,
                    data: {
                        orders: generateMockOrders(25), // Generate 25 sample orders
                        total: 25
                    }
                };

                allOrders = result.data.orders;
                filteredOrders = [...allOrders];
                totalPages = Math.ceil(filteredOrders.length / ordersPerPage);

                renderOrders();
                renderPagination();
            } catch (error) {
                console.error('Error loading orders:', error);
                showError('Error loading orders data.');
            }
        }

        function generateMockOrders(count) {
            const customers = ['Cjay Gonzales', 'Joshua Lapitan', 'Prince Ace Masinsin', 'Gillian Lorenzo', 'Kenji Chua', 'Angel Bien', 'Miguel Torres', 'Carmen Lopez'];
            const categories = ['Flooring', 'Tiles', 'Fixtures'];
            const statuses = ['pending', 'processing', 'shipped', 'delivered'];
            const orders = [];

            for (let i = 1; i <= count; i++) {
                orders.push({
                    id: String(i).padStart(3, '0'),
                    customer: customers[Math.floor(Math.random() * customers.length)],
                    category: categories[Math.floor(Math.random() * categories.length)],
                    items: Math.floor(Math.random() * 5) + 1,
                    amount: (Math.random() * 20000 + 1000).toFixed(0),
                    date: new Date(2024, 8, Math.floor(Math.random() * 30) + 1).toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric'
                    }),
                    status: statuses[Math.floor(Math.random() * statuses.length)]
                });
            }
            return orders;
        }

        function renderOrders() {
            const tbody = document.querySelector('.orders-table tbody');
            const startIndex = (currentPage - 1) * ordersPerPage;
            const endIndex = startIndex + ordersPerPage;
            const pageOrders = filteredOrders.slice(startIndex, endIndex);

            if (pageOrders.length === 0) {
                tbody.innerHTML = '<tr><td colspan="8" class="loading">No orders found</td></tr>';
                return;
            }

            tbody.innerHTML = pageOrders.map(order => `
                <tr>
                    <td><strong>#ORD-${order.id}</strong></td>
                    <td>${order.customer}</td>
                    <td><span class="category-badge">${order.category}</span></td>
                    <td>${order.items} item${order.items !== 1 ? 's' : ''}</td>
                    <td><strong>₱${parseInt(order.amount).toLocaleString()}</strong></td>
                    <td>${order.date}</td>
                    <td><span class="status ${order.status}">${order.status.charAt(0).toUpperCase() + order.status.slice(1)}</span></td>
                    <td>
                        <div class="actions">
                            <a href="order-details.php?id=${order.id}" class="action-btn secondary">View</a>
                            <a href="update-status.php?id=${order.id}" class="action-btn">Update</a>
                            <a href="print-invoice.php?id=${order.id}" class="action-btn" target="_blank">Print</a>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        function renderPagination() {
            const paginationInfo = document.querySelector('.pagination-info');
            const paginationControls = document.querySelector('.pagination-controls');

            const startItem = ((currentPage - 1) * ordersPerPage) + 1;
            const endItem = Math.min(currentPage * ordersPerPage, filteredOrders.length);

            paginationInfo.textContent = `Showing ${startItem}-${endItem} of ${filteredOrders.length} orders`;

            // Generate page buttons
            let buttonsHTML = '<button class="page-btn" id="prevBtn">Previous</button>';

            for (let i = 1; i <= totalPages; i++) {
                buttonsHTML += `<button class="page-btn ${i === currentPage ? 'active' : ''}" data-page="${i}">${i}</button>`;
            }

            buttonsHTML += '<button class="page-btn" id="nextBtn">Next</button>';

            paginationControls.innerHTML = buttonsHTML;

            // Add event listeners
            document.getElementById('prevBtn').onclick = () => goToPage(currentPage - 1);
            document.getElementById('nextBtn').onclick = () => goToPage(currentPage + 1);

            document.querySelectorAll('[data-page]').forEach(btn => {
                btn.onclick = () => goToPage(parseInt(btn.dataset.page));
            });
        }

        function goToPage(page) {
            if (page < 1 || page > totalPages) return;
            currentPage = page;
            renderOrders();
            renderPagination();
        }

        function applyFilters() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const statusFilter = document.getElementById('statusFilter').value;
            const categoryFilter = document.getElementById('categoryFilter').value;

            filteredOrders = allOrders.filter(order => {
                const matchesSearch = !searchTerm ||
                    order.customer.toLowerCase().includes(searchTerm) ||
                    order.id.includes(searchTerm);

                const matchesStatus = !statusFilter || order.status === statusFilter;
                const matchesCategory = !categoryFilter || order.category.toLowerCase() === categoryFilter;

                return matchesSearch && matchesStatus && matchesCategory;
            });

            totalPages = Math.ceil(filteredOrders.length / ordersPerPage);
            currentPage = 1; // Reset to first page when filtering
            renderOrders();
            renderPagination();
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', applyFilters);

        // Status filter functionality
        document.getElementById('statusFilter').addEventListener('change', applyFilters);

        // Category filter functionality
        document.getElementById('categoryFilter').addEventListener('change', applyFilters);

        function showError(message) {
            const tbody = document.querySelector('.orders-table tbody');
            tbody.innerHTML = `<tr><td colspan="8" class="error" style="text-align: center; padding: 2rem; color: #dc2626;">${message}</td></tr>`;
        }
    </script>
</body>
</html>
