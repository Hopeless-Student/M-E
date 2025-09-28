<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory - M & E Dashboard</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <link rel="stylesheet" href="../assets/css/admin/inventory/index.css">
    <style>
        /* General Modal Styles (prefixed for this file's modals) */
        .inventory-modal-base {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            animation: inventoryModalFadeIn 0.3s ease;
        }

        .inventory-modal-base.show {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        @keyframes inventoryModalFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .inventory-modal-content {
            background-color: white;
            padding: 2rem;
            border-radius: 12px;
            width: 90%;
            max-width: 600px;
            max-height: 80vh;
            overflow-y: auto;
            animation: inventoryModalSlideIn 0.3s ease;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);
        }

        @keyframes inventoryModalSlideIn {
            from { transform: translateY(-30px) scale(0.95); opacity: 0; }
            to { transform: translateY(0) scale(1); opacity: 1; }
        }

        .inventory-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e2e8f0;
        }

        .inventory-modal-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1e40af;
        }

        .inventory-modal-close-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #64748b;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.2s;
        }

        .inventory-modal-close-btn:hover {
            color: #1e40af;
            background: #f1f5f9;
        }

        .inventory-form-group {
            margin-bottom: 1.5rem;
        }

        .inventory-form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #475569;
        }

        .inventory-form-input, .inventory-form-select {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .inventory-form-input:focus, .inventory-form-select:focus {
            outline: none;
            border-color: #1e40af;
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
        }

        .inventory-form-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px solid #e2e8f0;
        }

        .inventory-btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s;
        }

        .inventory-btn-primary {
            background: #1e40af;
            color: white;
        }

        .inventory-btn-primary:hover {
            background: #1e3a8a;
        }

        .inventory-btn-secondary {
            background: #e2e8f0;
            color: #475569;
        }

        .inventory-btn-secondary:hover {
            background: #cbd5e1;
        }

        /* Low Stock Modal Specifics */
        .low-stock-modal-list-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            margin-bottom: 1rem;
            background: #fef2f2;
        }

        .low-stock-modal-item-details {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .low-stock-modal-item-icon {
            font-size: 2rem;
        }

        .low-stock-modal-item-name {
            color: #dc2626;
            margin-bottom: 0.25rem;
            font-weight: 600;
        }

        .low-stock-modal-item-stock {
            color: #64748b;
            font-size: 0.85rem;
        }

        .low-stock-modal-reorder-btn {
            padding: 0.5rem 1rem;
            background: #1e40af;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s;
        }

        .low-stock-modal-reorder-btn:hover {
            background: #1e3a8a;
        }

        /* Notification styles */
        .inventory-notification {
            position: fixed;
            top: 2rem;
            right: 2rem;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            z-index: 3000;
            max-width: 300px;
            opacity: 0;
            transform: translateY(-20px);
            transition: opacity 0.3s ease-out, transform 0.3s ease-out;
        }

        .inventory-notification.show {
            opacity: 1;
            transform: translateY(0);
        }

        .inventory-notification.success {
            background: #dcfce7;
            color: #166534;
        }

        .inventory-notification.error {
            background: #fee2e2;
            color: #dc2626;
        }

        .inventory-notification.info {
            background: #dbeafe;
            color: #1e40af;
        }

        @media (max-width: 768px) {
            .inventory-modal-content {
                max-width: 95vw;
                margin: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <?php include '../../includes/admin_sidebar.php' ?>

        <main class="main-content">
            <div class="header">
                <h2>Inventory Management</h2>
                <div class="header-actions">
                    <button class="notification-btn">
                        <span class="notification-badge">12</span>
                        <i data-lucide="bell-ring"></i> Low Stock Alerts
                    </button>
                    <div class="user-info">
                        <span>Admin Panel</span>
                        <div class="avatar">A</div>
                    </div>
                </div>
            </div>

            <div class="quick-actions">
                <button class="quick-action-btn primary" onclick="window.location.href='adjust-stock.php'">
                    <i data-lucide="plus"></i> Quick Stock Adjust
                </button>
                <button class="quick-action-btn" onclick="window.location.href='stock-movements.php'">
                    <i data-lucide="activity"></i> View Movements
                </button>
                <button class="quick-action-btn" onclick="openBulkUpdateModal()">
                    <i data-lucide="edit"></i> Bulk Update
                </button>
                <button class="quick-action-btn" onclick="generateReport()">
                    <i data-lucide="download"></i> Generate Report
                </button>
            </div>

            <div class="stats-grid">
                <div class="stat-card" onclick="filterByStatus('all')">
                    <div class="stat-title">Total Products</div>
                    <div class="stat-value">8</div>
                    <div class="stat-subtitle">Across 3 categories</div>
                </div>
                <div class="stat-card warning" onclick="openLowStockModal()">
                    <div class="stat-title">Low Stock Items</div>
                    <div class="stat-value">4</div>
                    <div class="stat-subtitle">Need restocking</div>
                </div>
                <div class="stat-card danger" onclick="filterByStatus('out-of-stock')">
                    <div class="stat-title">Out of Stock</div>
                    <div class="stat-value">0</div>
                    <div class="stat-subtitle">Immediate attention</div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">Total Value</div>
                    <div class="stat-value">₱285K</div>
                    <div class="stat-subtitle">Current inventory</div>
                </div>
            </div>

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

            <div class="inventory-controls">
                <div class="search-filter">
                    <div class="search-box">
                        <i data-lucide="search" class="search-icon"></i>
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
                <button class="export-btn" onclick="exportReport()">
                    <i data-lucide="download"></i> Export Report
                </button>
            </div>

            <div class="inventory-section">
                <div class="table-container">
                    <table class="inventory-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Category</th>
                                <th>SKU</th>
                                <th>Stock</th>
                                <th>Min</th>
                                <th>Price</th>
                                <th>Value</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="inventoryTableBody">
                        </tbody>
                    </table>
                </div>

                <div class="pagination">
                    <div class="pagination-info">
                        Showing <span id="startItem">1</span>-<span id="endItem">5</span> of <span id="totalItems">8</span> products
                    </div>
                    <div class="pagination-controls">
                        <button class="page-btn" id="prevBtn" onclick="changePage('prev')">← Previous</button>
                        <span id="pageNumbers"></span>
                        <button class="page-btn" id="nextBtn" onclick="changePage('next')">Next →</button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div id="bulkUpdateModal" class="inventory-modal-base">
        <div class="inventory-modal-content">
            <div class="inventory-modal-header">
                <h3 class="inventory-modal-title">Bulk Stock Update</h3>
                <button class="inventory-modal-close-btn" onclick="closeBulkUpdateModal()">&times;</button>
            </div>
            <form id="bulkUpdateForm">
                <div class="inventory-form-group">
                    <label class="inventory-form-label">Category</label>
                    <select class="inventory-form-select" id="bulkCategory" required>
                        <option value="">Select Category</option>
                        <option value="office">Office Supplies</option>
                        <option value="school">School Supplies</option>
                        <option value="sanitary">Sanitary Supplies</option>
                    </select>
                </div>
                <div class="inventory-form-group">
                    <label class="inventory-form-label">Action</label>
                    <select class="inventory-form-select" id="bulkAction" required>
                        <option value="increase">Increase by Percentage</option>
                        <option value="decrease">Decrease by Percentage</option>
                        <option value="setMin">Set Minimum Stock</option>
                    </select>
                </div>
                <div class="inventory-form-group">
                    <label class="inventory-form-label">Value</label>
                    <input type="number" class="inventory-form-input" id="bulkValue" min="0" required>
                </div>
                <div class="inventory-form-actions">
                    <button type="button" class="inventory-btn inventory-btn-secondary" onclick="closeBulkUpdateModal()">Cancel</button>
                    <button type="submit" class="inventory-btn inventory-btn-primary">Apply Update</button>
                </div>
            </form>
        </div>
    </div>

    <div id="lowStockModal" class="inventory-modal-base">
        <div class="inventory-modal-content">
            <div class="inventory-modal-header">
                <h3 class="inventory-modal-title">Low Stock Alert</h3>
                <button class="inventory-modal-close-btn" onclick="closeLowStockModal()">&times;</button>
            </div>
            <div id="lowStockList">
            </div>
            <div class="inventory-form-actions">
                <button type="button" class="inventory-btn inventory-btn-secondary" onclick="closeLowStockModal()">Close</button>
                <button type="button" class="inventory-btn inventory-btn-primary" onclick="bulkReorder()">Bulk Reorder</button>
            </div>
        </div>
    </div>

    <script>
        const inventoryData = [
            {
                id: 1,
                name: 'Ballpoint Pens',
                description: 'Pack of 12',
                category: 'office',
                categoryName: 'Office Supplies',
                sku: 'OFF-PEN-001',
                stock: 150,
                minStock: 20,
                price: 180,
                icon: '🖊️',
                stockLevel: 'high'
            },
            {
                id: 2,
                name: 'Bond Paper',
                description: 'A4 Ream 500 sheets',
                category: 'office',
                categoryName: 'Office Supplies',
                sku: 'OFF-PAP-002',
                stock: 85,
                minStock: 30,
                price: 250,
                icon: '📄',
                stockLevel: 'medium'
            },
            {
                id: 3,
                name: 'File Folders',
                description: 'Manila folders',
                category: 'office',
                categoryName: 'Office Supplies',
                sku: 'OFF-FOL-003',
                stock: 45,
                minStock: 15,
                price: 120,
                icon: '📁',
                stockLevel: 'medium'
            },
            {
                id: 4,
                name: 'Staplers',
                description: 'Heavy duty stapler',
                category: 'office',
                categoryName: 'Office Supplies',
                sku: 'OFF-STA-004',
                stock: 12,
                minStock: 25,
                price: 850,
                icon: '📎',
                stockLevel: 'low'
            },
            {
                id: 5,
                name: 'Notebooks',
                description: 'Spiral notebook 100 pages',
                category: 'school',
                categoryName: 'School Supplies',
                sku: 'SCH-NOT-005',
                stock: 8,
                minStock: 20,
                price: 65,
                icon: '📓',
                stockLevel: 'low'
            },
            {
                id: 6,
                name: 'Hand Sanitizer',
                description: '500ml bottle',
                category: 'sanitary',
                categoryName: 'Sanitary Supplies',
                sku: 'SAN-HAN-006',
                stock: 25,
                minStock: 30,
                price: 185,
                icon: '🧴',
                stockLevel: 'low'
            },
            {
                id: 7,
                name: 'Whiteboard Markers',
                description: 'Set of 4 colors',
                category: 'office',
                categoryName: 'Office Supplies',
                sku: 'OFF-MAR-007',
                stock: 75,
                minStock: 25,
                price: 320,
                icon: '🖍️',
                stockLevel: 'high'
            },
            {
                id: 8,
                name: 'Tissue Paper',
                description: 'Box of 200 sheets',
                category: 'sanitary',
                categoryName: 'Sanitary Supplies',
                sku: 'SAN-TIS-008',
                stock: 22,
                minStock: 40,
                price: 95,
                icon: '🧻',
                stockLevel: 'low'
            }
        ];

        let currentPage = 1;
        let itemsPerPage = 5;
        let filteredData = [...inventoryData];

        document.addEventListener('DOMContentLoaded', function() {
            initializeDashboard();
            setupInventoryModalClickOutside(); // Setup click outside for modals in this file
        });

        function initializeDashboard() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            populateInventoryTable();
            initializeCharts();
            updateStats();
            setupEventListeners();
            populateLowStockModal();
        }

        function populateInventoryTable() {
            const tbody = document.getElementById('inventoryTableBody');
            tbody.innerHTML = '';

            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const pageData = filteredData.slice(startIndex, endIndex);

            pageData.forEach(item => {
                const row = tbody.insertRow();
                const totalValue = item.stock * item.price;
                const stockPercentage = Math.min((item.stock / (item.minStock * 2)) * 100, 100);

                row.innerHTML = `
                    <td>
                        <div class="product-info-cell">
                            <div class="product-icon">${item.icon}</div>
                            <div class="product-details">
                                <h4>${item.name}</h4>
                                <p>${item.description}</p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="category-badge">${item.categoryName}</span>
                    </td>
                    <td>${item.sku}</td>
                    <td>
                        <div class="stock-level ${item.stockLevel}">${item.stock}</div>
                        <div class="stock-bar">
                            <div class="stock-fill ${item.stockLevel}" style="width: ${stockPercentage}%"></div>
                        </div>
                    </td>
                    <td>${item.minStock}</td>
                    <td>₱${item.price.toLocaleString()}</td>
                    <td>₱${totalValue.toLocaleString()}</td>
                    <td>
                        <button class="action-btn" onclick="window.location.href='adjust-stock.php?productId=${item.id}'">Adjust</button>
                        <button class="action-btn secondary" onclick="viewDetails(${item.id})">Details</button>
                        <button class="action-btn danger" onclick="deleteItem(${item.id})">Delete</button>
                    </td>
                `;
            });

            updatePaginationInfo();
            updatePaginationControls();
        }

        function updatePaginationInfo() {
            const totalItems = filteredData.length;
            const startItem = totalItems === 0 ? 0 : (currentPage - 1) * itemsPerPage + 1;
            const endItem = Math.min(currentPage * itemsPerPage, totalItems);

            document.getElementById('startItem').textContent = startItem;
            document.getElementById('endItem').textContent = endItem;
            document.getElementById('totalItems').textContent = totalItems;
        }

        function updatePaginationControls() {
            const totalPages = Math.ceil(filteredData.length / itemsPerPage);
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const pageNumbers = document.getElementById('pageNumbers');

            prevBtn.disabled = currentPage === 1;
            nextBtn.disabled = currentPage === totalPages || totalPages === 0;

            let pageNumbersHTML = '';
            const maxVisiblePages = 5;
            let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
            let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);

            if (endPage - startPage < maxVisiblePages - 1) {
                startPage = Math.max(1, endPage - maxVisiblePages + 1);
            }

            for (let i = startPage; i <= endPage; i++) {
                pageNumbersHTML += `<button class="page-btn ${i === currentPage ? 'active' : ''}" onclick="changePage(${i})">${i}</button>`;
            }

            pageNumbers.innerHTML = pageNumbersHTML;
        }

        function setupEventListeners() {
            document.getElementById('searchInput').addEventListener('input', function() {
                applyFilters();
            });

            document.getElementById('categoryFilter').addEventListener('change', function() {
                applyFilters();
            });

            document.getElementById('stockFilter').addEventListener('change', function() {
                applyFilters();
            });
        }

        function applyFilters() {
            const selectedCategory = document.getElementById('categoryFilter').value;
            const selectedStock = document.getElementById('stockFilter').value;
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();

            filteredData = inventoryData.filter(item => {
                const matchesSearch = item.name.toLowerCase().includes(searchTerm) ||
                                    item.sku.toLowerCase().includes(searchTerm) ||
                                    item.description.toLowerCase().includes(searchTerm);
                const matchesCategory = !selectedCategory || item.category === selectedCategory;
                const matchesStock = !selectedStock || item.stockLevel === selectedStock;

                return matchesSearch && matchesCategory && matchesStock;
            });

            currentPage = 1;
            populateInventoryTable();
            updateStats();
        }

        function initializeCharts() {
            const stockCtx = document.getElementById('stockChart').getContext('2d');
            new Chart(stockCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Office Supplies', 'School Supplies', 'Sanitary Supplies'],
                    datasets: [{
                        data: [
                            inventoryData.filter(item => item.category === 'office').reduce((sum, item) => sum + item.stock, 0),
                            inventoryData.filter(item => item.category === 'school').reduce((sum, item) => sum + item.stock, 0),
                            inventoryData.filter(item => item.category === 'sanitary').reduce((sum, item) => sum + item.stock, 0)
                        ],
                        backgroundColor: ['#3b82f6', '#10b981', '#f59e0b'],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });

            const turnoverCtx = document.getElementById('turnoverChart').getContext('2d');
            new Chart(turnoverCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Inventory Turnover',
                        data: [2.1, 2.8, 3.2, 2.9, 3.5, 3.8],
                        borderColor: '#1e40af',
                        backgroundColor: 'rgba(30, 64, 175, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }

        function updateStats() {
            const totalProducts = filteredData.length;
            const lowStockItems = filteredData.filter(item => item.stockLevel === 'low').length;
            const outOfStockItems = filteredData.filter(item => item.stock === 0).length;
            const totalValue = filteredData.reduce((sum, item) => sum + (item.stock * item.price), 0);

            const statCards = document.querySelectorAll('.stat-card');
            if (statCards.length >= 4) {
                statCards[0].querySelector('.stat-value').textContent = totalProducts;
                statCards[1].querySelector('.stat-value').textContent = lowStockItems;
                statCards[2].querySelector('.stat-value').textContent = outOfStockItems;
                statCards[3].querySelector('.stat-value').textContent = `₱${Math.round(totalValue / 1000)}K`;
            }
        }

        function populateLowStockModal() {
            const lowStockItems = inventoryData.filter(item => item.stockLevel === 'low');
            const lowStockList = document.getElementById('lowStockList');

            lowStockList.innerHTML = lowStockItems.map(item => `
                <div class="low-stock-modal-list-item">
                    <div class="low-stock-modal-item-details">
                        <div class="low-stock-modal-item-icon">${item.icon}</div>
                        <div>
                            <h4 class="low-stock-modal-item-name">${item.name}</h4>
                            <p class="low-stock-modal-item-stock">Current: ${item.stock} | Min: ${item.minStock}</p>
                        </div>
                    </div>
                    <button class="low-stock-modal-reorder-btn" onclick="quickReorder('${item.name}')">Quick Reorder</button>
                </div>
            `).join('');
            lucide.createIcons(); // Re-create icons for new modal content
        }

        function openBulkUpdateModal() {
            document.getElementById('bulkUpdateModal').classList.add('show');
            document.body.style.overflow = 'hidden';
            lucide.createIcons(); // Re-create icons for new modal content
        }

        function closeBulkUpdateModal() {
            document.getElementById('bulkUpdateModal').classList.remove('show');
            document.body.style.overflow = 'auto';
            document.getElementById('bulkUpdateForm').reset();
        }

        function openLowStockModal() {
            document.getElementById('lowStockModal').classList.add('show');
            document.body.style.overflow = 'hidden';
            lucide.createIcons(); // Re-create icons for new modal content
        }

        function closeLowStockModal() {
            document.getElementById('lowStockModal').classList.remove('show');
            document.body.style.overflow = 'auto';
        }

        function viewDetails(itemId) {
            const item = inventoryData.find(i => i.id === itemId);
            if (item) {
                showNotification(`Product Details:\n\nName: ${item.name}\nSKU: ${item.sku}\nCategory: ${item.categoryName}\nStock: ${item.stock}\nMin Stock: ${item.minStock}\nPrice: ₱${item.price.toLocaleString()}\nTotal Value: ₱${(item.stock * item.price).toLocaleString()}`, 'info');
            }
        }

        function deleteItem(itemId) {
            const item = inventoryData.find(i => i.id === itemId);
            if (item && confirm(`Are you sure you want to delete "${item.name}" from inventory?`)) {
                const index = inventoryData.findIndex(i => i.id === itemId);
                inventoryData.splice(index, 1);

                applyFilters();

                const totalPages = Math.ceil(filteredData.length / itemsPerPage);
                if (currentPage > totalPages && totalPages > 0) {
                    currentPage = totalPages;
                }

                populateInventoryTable();
                updateStats();
                populateLowStockModal();
                showNotification('Item deleted successfully!', 'success');
            }
        }

        function filterByStatus(status) {
            document.getElementById('categoryFilter').value = '';
            document.getElementById('stockFilter').value = '';
            document.getElementById('searchInput').value = '';

            if (status === 'all') {
                filteredData = [...inventoryData];
            } else if (status === 'out-of-stock') {
                filteredData = inventoryData.filter(item => item.stock === 0);
            } else {
                filteredData = inventoryData.filter(item => item.stockLevel === status);
            }

            currentPage = 1;
            populateInventoryTable();
            updateStats();
        }

        function changePage(page) {
            const totalPages = Math.ceil(filteredData.length / itemsPerPage);

            if (page === 'prev' && currentPage > 1) {
                currentPage--;
            } else if (page === 'next' && currentPage < totalPages) {
                currentPage++;
            } else if (typeof page === 'number' && page >= 1 && page <= totalPages) {
                currentPage = page;
            }

            populateInventoryTable();
        }

        function exportReport() {
            let csvContent = "Product Name,SKU,Category,Current Stock,Min Stock,Unit Price,Total Value\n";

            filteredData.forEach(item => {
                const totalValue = item.stock * item.price;
                csvContent += `"${item.name}",${item.sku},"${item.categoryName}",${item.stock},${item.minStock},${item.price},${totalValue}\n`;
            });

            const blob = new Blob([csvContent], { type: 'text/csv' });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.setAttribute('hidden', '');
            a.setAttribute('href', url);
            a.setAttribute('download', 'inventory_report_' + new Date().toISOString().split('T')[0] + '.csv');
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);

            showNotification('Report exported successfully!', 'success');
        }

        function generateReport() {
            showNotification('Generating comprehensive inventory report...', 'info');
        }

        function quickReorder(product) {
            showNotification(`Reorder request sent for ${product}`, 'success');
            closeLowStockModal();
        }

        function bulkReorder() {
            showNotification('Bulk reorder request sent for all low stock items', 'success');
            closeLowStockModal();
        }

        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `inventory-notification ${type}`;
            notification.textContent = message;

            document.body.appendChild(notification);

            // Trigger reflow to enable transition
            void notification.offsetWidth;
            notification.classList.add('show');

            setTimeout(() => {
                notification.classList.remove('show');
                notification.addEventListener('transitionend', () => notification.remove());
            }, 3000);
        }

        document.getElementById('bulkUpdateForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const category = document.getElementById('bulkCategory').value;
            const action = document.getElementById('bulkAction').value;
            const value = parseFloat(document.getElementById('bulkValue').value);

            if (!category || !action || isNaN(value)) {
                showNotification('Please fill in all fields with valid values', 'error');
                return;
            }

            const itemsToUpdate = inventoryData.filter(item => item.category === category);
            let updatedCount = 0;

            itemsToUpdate.forEach(item => {
                switch (action) {
                    case 'increase':
                        item.stock = Math.round(item.stock * (1 + value / 100));
                        updatedCount++;
                        break;
                    case 'decrease':
                        item.stock = Math.round(item.stock * (1 - value / 100));
                        updatedCount++;
                        break;
                    case 'setMin':
                        item.minStock = value;
                        updatedCount++;
                        break;
                }

                item.stockLevel = item.stock <= item.minStock * 0.5 ? 'low' :
                                 item.stock <= item.minStock ? 'medium' : 'high';
            });

            showNotification(`Bulk update completed! ${updatedCount} items updated successfully.`, 'success');
            closeBulkUpdateModal();
            populateInventoryTable();
            updateStats();
            populateLowStockModal();

            this.reset();
        });

        function setupInventoryModalClickOutside() {
            const bulkUpdateModal = document.getElementById('bulkUpdateModal');
            if (bulkUpdateModal) {
                bulkUpdateModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeBulkUpdateModal();
                    }
                });
            }

            const lowStockModal = document.getElementById('lowStockModal');
            if (lowStockModal) {
                lowStockModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeLowStockModal();
                    }
                });
            }
        }

        // Ensure icons are created for dynamically added content
        setTimeout(() => {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        }, 100);
    </script>
</body>
</html>
