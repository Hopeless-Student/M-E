<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory - M & E Dashboard</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <link rel="stylesheet" href="../assets/css/admin/inventory/index.css">
</head>
<body>
    <div class="dashboard">
        <?php include '../../includes/admin_sidebar.php' ?>

        <main class="main-content">
            <div class="header">
                <h2>Inventory Management</h2>
                <div class="header-actions">
                    <button class="notification-btn" onclick="openLowStockAlertsModal()">
                        <span class="notification-badge" id="lowStockAlertsBadge">12</span>
                        <i data-lucide="bell-ring"></i> Low Stock Alerts
                    </button>
                    <div class="user-info">
                        <span>Admin Panel</span>
                        <div class="avatar">A</div>
                    </div>
                </div>
            </div>

            <div class="quick-actions">
                <button class="quick-action-btn primary" onclick="openAdjustStockModalFromIndex()">
                    <i data-lucide="plus"></i> Quick Stock Adjust
                </button>
                <button class="quick-action-btn" onclick="openStockMovementsModal()">
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
                    <div class="stat-value" id="totalProductsStat">8</div>
                    <div class="stat-subtitle">Across 3 categories</div>
                </div>
                <div class="stat-card warning" onclick="openLowStockAlertsModal()">
                    <div class="stat-title">Low Stock Items</div>
                    <div class="stat-value" id="lowStockItemsStat">4</div>
                    <div class="stat-subtitle">Need restocking</div>
                </div>
                <div class="stat-card danger" onclick="filterByStatus('out-of-stock')">
                    <div class="stat-title">Out of Stock</div>
                    <div class="stat-value" id="outOfStockStat">0</div>
                    <div class="stat-subtitle">Immediate attention</div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">Total Value</div>
                    <div class="stat-value" id="totalValueStat">₱285K</div>
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
                <button class="export-btn" onclick="exportInventoryReport()">
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

    <!-- --- MODAL CONTAINERS --- -->

    <!-- Bulk Update Modal -->
    <div id="bulkUpdateModal" class="modal-base">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i data-lucide="edit"></i> Bulk Stock Update</h3>
                <button class="modal-close-btn" onclick="closeModal('bulkUpdateModal')"><i data-lucide="x"></i></button>
            </div>
            <form id="bulkUpdateForm">
                <div class="form-group">
                    <label class="form-label">Category</label>
                    <select class="form-select" id="bulkCategory" required>
                        <option value="">Select Category</option>
                        <option value="office">Office Supplies</option>
                        <option value="school">School Supplies</option>
                        <option value="sanitary">Sanitary Supplies</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Action</label>
                    <select class="form-select" id="bulkAction" required>
                        <option value="increase">Increase by Percentage</option>
                        <option value="decrease">Decrease by Percentage</option>
                        <option value="setMin">Set Minimum Stock</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Value</label>
                    <input type="number" class="form-input" id="bulkValue" min="0" required>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('bulkUpdateModal')">Cancel</button>
                    <button type="submit" class="btn btn-primary">Apply Update</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Product Details Modal -->
    <div id="productDetailsModal" class="modal-base">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i data-lucide="info"></i> Product Details</h3>
                <button class="modal-close-btn" onclick="closeModal('productDetailsModal')"><i data-lucide="x"></i></button>
            </div>
            <div id="productDetailsContent">
                <!-- Details will be populated here -->
            </div>
            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="closeModal('productDetailsModal')">Close</button>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmationModal" class="modal-base">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><i data-lucide="alert-triangle"></i> Confirm Action</h3>
                <button class="modal-close-btn" onclick="closeModal('confirmationModal')"><i data-lucide="x"></i></button>
            </div>
            <p id="confirmationMessage" style="margin-bottom: 1.5rem;"></p>
            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="closeModal('confirmationModal')">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmActionButton">Confirm</button>
            </div>
        </div>
    </div>

    <?php include 'adjust-stock.php'; ?>
    <?php include 'stock-movements.php'; ?>
    <?php include 'low-stock-alerts.php'; ?>

    <script src="inventory_data.js"></script>
    <script src="shared_functions.js"></script>
    <script>
        let currentPage = 1;
        let itemsPerPage = 5;
        let filteredData = [...inventoryData];
        let currentConfirmAction = null; // For confirmation modal

        // --- MAIN DASHBOARD INITIALIZATION ---
        document.addEventListener('DOMContentLoaded', function() {
            initializeDashboard();
            // Initialize all modal-specific event listeners
            setupAdjustStockModalListeners();
            setupStockMovementsModalListeners();
            setupLowStockAlertsModalListeners();
            setupBulkUpdateModalListeners();
            setupConfirmationModalListeners();
        });

        function initializeDashboard() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
            updateAllDataAndUI(); // Initial load and update
            setupEventListeners();
        }

        function updateAllDataAndUI() {
            // Recalculate stock levels for inventoryData based on minStock
            inventoryData.forEach(item => {
                if (item.stock <= 0) {
                    item.stockLevel = 'low'; // Treat 0 as low/critical
                } else if (item.stock <= item.minStock * 0.5) {
                    item.stockLevel = 'low';
                } else if (item.stock <= item.minStock) {
                    item.stockLevel = 'medium';
                } else {
                    item.stockLevel = 'high';
                }
            });

            // Recalculate alert levels for lowStockData based on inventoryData
            lowStockData.forEach(lowItem => {
                const correspondingInventoryItem = inventoryData.find(invItem => invItem.id === lowItem.id);
                if (correspondingInventoryItem) {
                    lowItem.currentStock = correspondingInventoryItem.stock;
                    lowItem.minStock = correspondingInventoryItem.minStock;

                    if (lowItem.currentStock <= 0) {
                        lowItem.alertLevel = 'critical';
                    } else if (lowItem.currentStock <= lowItem.minStock * 0.5) {
                        lowItem.alertLevel = 'critical';
                    } else if (lowItem.currentStock <= lowItem.minStock) {
                        lowItem.alertLevel = 'warning';
                    } else {
                        lowItem.alertLevel = 'low'; // Or 'normal' if you have that level
                    }
                }
            });

            applyFilters(); // Re-apply main inventory filters
            updateStats();
            initializeCharts();
            updateLowStockAlertsBadge();
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
                const stockPercentage = Math.min((item.stock / (item.minStock * 2)) * 100, 100); // Max 100% for bar

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
                        <div class="action-buttons-container">
                            <button class="action-btn" onclick="openAdjustStockModalFromIndex(${item.id})">Adjust</button>
                            <button class="action-btn secondary" onclick="openProductDetailsModal(${item.id})">Details</button>
                            <button class="action-btn danger" onclick="confirmDeleteItem(${item.id})">Delete</button>
                        </div>
                    </td>
                `;
            });

            updatePaginationInfo();
            updatePaginationControls();
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
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

        let stockChartInstance = null;
        let turnoverChartInstance = null;

        function initializeCharts() {
            const stockCtx = document.getElementById('stockChart').getContext('2d');
            if (stockChartInstance) stockChartInstance.destroy(); // Destroy existing chart
            stockChartInstance = new Chart(stockCtx, {
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
            if (turnoverChartInstance) turnoverChartInstance.destroy(); // Destroy existing chart
            turnoverChartInstance = new Chart(turnoverCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Inventory Turnover',
                        data: [2.1, 2.8, 3.2, 2.9, 3.5, 3.8], // Static data for now
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

            document.getElementById('totalProductsStat').textContent = totalProducts;
            document.getElementById('lowStockItemsStat').textContent = lowStockItems;
            document.getElementById('outOfStockStat').textContent = outOfStockItems;
            document.getElementById('totalValueStat').textContent = `₱${Math.round(totalValue / 1000)}K`;
        }

        function updateLowStockAlertsBadge() {
            const lowItems = inventoryData.filter(item => item.stock <= item.minStock);
            document.getElementById('lowStockAlertsBadge').textContent = lowItems.length;
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

        function exportInventoryReport() {
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

        // --- BULK UPDATE MODAL FUNCTIONS ---
        function openBulkUpdateModal() {
            openModal('bulkUpdateModal');
        }

        function setupBulkUpdateModalListeners() {
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
                });

                showNotification(`Bulk update completed! ${updatedCount} items updated successfully.`, 'success');
                closeModal('bulkUpdateModal');
                updateAllDataAndUI(); // Refresh all dashboard data and UI
            });
        }

        // --- PRODUCT DETAILS MODAL FUNCTIONS ---
        function openProductDetailsModal(itemId) {
            const item = inventoryData.find(i => i.id === itemId);
            if (item) {
                const detailsContent = document.getElementById('productDetailsContent');
                detailsContent.innerHTML = `
                    <div class="product-details-grid">
                        <div class="product-details-card">
                            <div class="product-details-label">Product Name</div>
                            <div class="product-details-value">${item.name}</div>
                        </div>
                        <div class="product-details-card">
                            <div class="product-details-label">SKU</div>
                            <div class="product-details-value">${item.sku}</div>
                        </div>
                        <div class="product-details-card">
                            <div class="product-details-label">Category</div>
                            <div class="product-details-value">${item.categoryName}</div>
                        </div>
                        <div class="product-details-card">
                            <div class="product-details-label">Current Stock</div>
                            <div class="product-details-value">${item.stock}</div>
                        </div>
                        <div class="product-details-card">
                            <div class="product-details-label">Minimum Stock</div>
                            <div class="product-details-value">${item.minStock}</div>
                        </div>
                        <div class="product-details-card">
                            <div class="product-details-label">Unit Price</div>
                            <div class="product-details-value">₱${item.price.toLocaleString()}</div>
                        </div>
                        <div class="product-details-card">
                            <div class="product-details-label">Total Value</div>
                            <div class="product-details-value">₱${(item.stock * item.price).toLocaleString()}</div>
                        </div>
                    </div>
                `;
                openModal('productDetailsModal');
            }
        }

        // --- CONFIRMATION MODAL FUNCTIONS ---
        function openConfirmationModal(message, callback) {
            document.getElementById('confirmationMessage').textContent = message;
            document.getElementById('confirmActionButton').onclick = () => {
                callback();
                closeModal('confirmationModal');
            };
            openModal('confirmationModal');
        }

        function confirmDeleteItem(itemId) {
            const item = inventoryData.find(i => i.id === itemId);
            if (item) {
                openConfirmationModal(`Are you sure you want to delete "${item.name}" from inventory? This action cannot be undone.`, () => {
                    deleteItem(itemId);
                });
            }
        }

        function deleteItem(itemId) {
            const index = inventoryData.findIndex(i => i.id === itemId);
            if (index !== -1) {
                inventoryData.splice(index, 1);
                showNotification('Item deleted successfully!', 'success');
                updateAllDataAndUI(); // Refresh all dashboard data and UI
            }
        }

        function setupConfirmationModalListeners() {
            // No specific listeners needed beyond the dynamic onclick for confirmActionButton
        }

        // Initial icon creation
        setTimeout(() => {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        }, 100);
    </script>
</body>
</html>
