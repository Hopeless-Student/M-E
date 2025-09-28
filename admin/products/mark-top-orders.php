<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Top Products - M & E Dashboard</title>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <link rel="stylesheet" href="../assets/css/admin/products/toptag.css">
</head>
<body>
    <div class="dashboard">
        <!-- Sidebar -->
        <?php include '../../includes/admin_sidebar.php'; ?>

        <!-- Main Content -->
        <main class="main-content">
            <div class="header">
                <h2>Featured Products</h2>
                <div class="user-info">
                    <span>Admin Panel</span>
                    <div class="avatar">A</div>
                </div>
            </div>

            <div class="breadcrumb">
                <a href="./index.php">Products</a>
                <span>></span>
                <span>Featured Products</span>
            </div>

                <!-- Stats -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-label">Featured Products</div>
                        <div class="stat-value">12</div>
                        <div class="stat-change positive">↗ +3 from last week</div>
                    </div>
                    <div class="stat-card gold">
                        <div class="stat-label">Featured Revenue</div>
                        <div class="stat-value">₱285,400</div>
                        <div class="stat-change positive">↗ +25% from last month</div>
                    </div>
                    <div class="stat-card silver">
                        <div class="stat-label">Avg. Featured Sales</div>
                        <div class="stat-value">156</div>
                        <div class="stat-change positive">↗ +8% weekly</div>
                    </div>
                </div>

                <!-- Controls -->
                <div class="controls">
                    <div class="category-filter">
                        <label style="font-size: 0.9rem; color: #64748b;">Filter by category:</label>
                        <select class="form-select" id="categoryFilter">
                            <option value="all">All Categories</option>
                            <option value="office">Office Supplies</option>
                            <option value="school">School Supplies</option>
                            <option value="hygiene">Hygiene Products</option>
                        </select>
                        <select class="form-select" id="sortBy">
                            <option value="sales">Sort by Sales</option>
                            <option value="price">Sort by Price</option>
                            <option value="stock">Sort by Stock</option>
                            <option value="name">Sort by Name</option>
                        </select>
                    </div>
                    <div class="mark-actions">
                        <button class="btn btn-gold" onclick="markSelectedAsFeatured()" id="markFeaturedBtn" disabled>
                            <span data-lucide="star"></span>
                            Mark as Featured
                        </button>
                        <button class="btn btn-secondary" onclick="removeFeaturedStatus()" id="removeFeaturedBtn" disabled>
                            <span data-lucide="star-off"></span>
                            Remove Featured
                        </button>
                        <button class="btn btn-primary" onclick="openAutoMarkModal()">
                            <span data-lucide="square-pen"></span>
                            Auto Feature
                        </button>
                    </div>
                </div>

                <!-- Products Table -->
                <table class="products-table">
                    <thead class="table-header">
                        <tr>
                            <th class="checkbox-cell">
                                <input type="checkbox" id="selectAllCheckbox" class="product-checkbox" onchange="toggleSelectAll()">
                            </th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Sales</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="productsTableBody">
                        <!-- Products will be loaded here -->
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <!-- Auto Feature Modal -->
    <div class="modal" id="autoFeatureModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Auto Feature Products</h3>
                <p class="modal-subtitle">Automatically feature products based on performance criteria</p>
            </div>
            <form id="autoFeatureForm">
                <div class="form-grid">
                    <div class="form-column">
                        <div class="form-group">
                            <label class="form-label">Minimum Sales Count</label>
                            <input type="number" class="form-input" id="minSales" value="50" min="0">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Maximum Featured Products</label>
                            <input type="number" class="form-input" id="maxFeatured" value="15" min="1" max="20">
                        </div>
                    </div>
                    <div class="form-column">
                        <div class="form-group">
                            <label class="form-label">Category Priority</label>
                            <select class="form-select" id="categoryPriority">
                                <option value="all">All Categories</option>
                                <option value="office">Office Supplies First</option>
                                <option value="school">School Supplies First</option>
                                <option value="hygiene">Hygiene Products First</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Stock Requirement</label>
                            <select class="form-select" id="stockRequirement">
                                <option value="any">Any Stock Level</option>
                                <option value="in-stock">In Stock Only</option>
                                <option value="high-stock">High Stock Only</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Additional Criteria</label>
                    <textarea class="form-textarea" id="autoFeatureNotes" placeholder="Add any specific criteria or notes for auto-featuring products..."></textarea>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn btn-gold">Apply Auto Feature</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Alert Container -->
    <div class="alert" id="alertContainer"></div>

    <script>
        lucide.createIcons();
        // Sample products data
        const products = [
            {
                id: 'PRD-001',
                name: 'Ballpoint Pens Set',
                description: 'Premium quality ballpoint pens (Pack of 50)',
                category: 'office',
                price: 850,
                originalPrice: 950,
                stock: 245,
                sales: 189,
                trend: 'up',
                featured: true,
                image: '🖊️'
            },
            {
                id: 'PRD-002',
                name: 'Bond Paper A4',
                description: 'High quality bond paper 500 sheets',
                category: 'office',
                price: 320,
                originalPrice: null,
                stock: 156,
                sales: 143,
                trend: 'up',
                featured: false,
                image: '📄'
            },
            {
                id: 'PRD-003',
                name: 'Hand Sanitizer',
                description: 'Antibacterial hand sanitizer 500ml',
                category: 'hygiene',
                price: 125,
                originalPrice: 150,
                stock: 89,
                sales: 267,
                trend: 'up',
                featured: true,
                image: '🧴'
            },
            {
                id: 'PRD-004',
                name: 'Notebooks Set',
                description: 'Spiral notebooks for students (Pack of 5)',
                category: 'school',
                price: 450,
                originalPrice: null,
                stock: 78,
                sales: 198,
                trend: 'up',
                featured: true,
                image: '📔'
            },
            {
                id: 'PRD-005',
                name: 'File Folders',
                description: 'Expandable file folders (Pack of 10)',
                category: 'office',
                price: 280,
                originalPrice: 320,
                stock: 34,
                sales: 87,
                trend: 'down',
                featured: false,
                image: '📁'
            },
            {
                id: 'PRD-006',
                name: 'Pencils HB',
                description: 'Drawing pencils HB grade (Pack of 12)',
                category: 'school',
                price: 180,
                originalPrice: null,
                stock: 156,
                sales: 234,
                trend: 'up',
                featured: false,
                image: '✏️'
            },
            {
                id: 'PRD-007',
                name: 'Tissue Paper',
                description: 'Soft facial tissue (Pack of 6)',
                category: 'hygiene',
                price: 95,
                originalPrice: 110,
                stock: 0,
                sales: 145,
                trend: 'down',
                featured: false,
                image: '🧻'
            },
            {
                id: 'PRD-008',
                name: 'Erasers Premium',
                description: 'Premium quality erasers (Pack of 20)',
                category: 'school',
                price: 65,
                originalPrice: null,
                stock: 298,
                sales: 156,
                trend: 'up',
                featured: true,
                image: '🔴'
            }
        ];

        let selectedProducts = new Set();

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            renderProducts();
            setupEventListeners();
        });

        function setupEventListeners() {
            document.getElementById('autoFeatureForm').addEventListener('submit', handleAutoFeature);
            document.getElementById('categoryFilter').addEventListener('change', filterProducts);
            document.getElementById('sortBy').addEventListener('change', filterProducts); // Changed from sortProducts to filterProducts
        }

        function renderProducts(filteredProducts = products) {
            const tbody = document.getElementById('productsTableBody');
            tbody.innerHTML = filteredProducts.map(product => {
                const categoryClass = product.category;
                const rowClass = product.featured ? 'table-row featured' : 'table-row';
                const stockStatus = getStockStatus(product.stock);
                const stockClass = stockStatus.replace(' ', '-').toLowerCase();

                return `
                    <tr class="${rowClass}" id="row-${product.id}">
                        <td class="table-cell checkbox-cell">
                            <input type="checkbox" class="product-checkbox"
                                   value="${product.id}"
                                   onchange="toggleProduct('${product.id}')">
                        </td>
                        <td class="table-cell">
                            <div class="product-info">
                                <div class="product-image">${product.image}</div>
                                <div class="product-details">
                                    <h4>${product.name}</h4>
                                    <p>${product.description}</p>
                                </div>
                            </div>
                        </td>
                        <td class="table-cell">
                            <span class="category-badge ${categoryClass}">${getCategoryName(product.category)}</span>
                        </td>
                        <td class="table-cell">
                            <div class="price-info">
                                <div class="current-price">₱${product.price}</div>
                                ${product.originalPrice ?
                                    `<div class="original-price">₱${product.originalPrice}</div>` : ''
                                }
                            </div>
                        </td>
                        <td class="table-cell">
                            <div class="stock-info">
                                <div class="stock-count">${product.stock}</div>
                                <div class="stock-status ${stockClass}">${stockStatus}</div>
                            </div>
                        </td>
                        <td class="table-cell">
                            <div class="sales-stats">
                                <div class="sales-count">${product.sales}</div>
                                <div class="sales-trend ${product.trend}">
                                    ${product.trend === 'up' ? '↗ Trending' : '↘ Declining'}
                                </div>
                            </div>
                        </td>
                        <td class="table-cell">
                            ${product.featured ?
                                '<span class="featured-badge"><span>⭐</span>Featured</span>' :
                                '<span style="color: #94a3b8;">Regular</span>'
                            }
                        </td>
                    </tr>
                `;
            }).join('');
        }

        function getCategoryName(category) {
            const names = {
                'office': 'Office Supplies',
                'school': 'School Supplies',
                'hygiene': 'Hygiene Products'
            };
            return names[category] || category;
        }

        function getStockStatus(stock) {
            if (stock === 0) return 'Out of Stock';
            if (stock < 50) return 'Low Stock';
            return 'In Stock';
        }

        function toggleProduct(productId) {
            const checkbox = document.querySelector(`input[value="${productId}"]`);
            const row = document.getElementById(`row-${productId}`);

            if (checkbox.checked) {
                selectedProducts.add(productId);
                row.classList.add('selected');
            } else {
                selectedProducts.delete(productId);
                row.classList.remove('selected');
            }

            updateSelectionUI();
        }

        function toggleSelectAll() {
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            const productCheckboxes = document.querySelectorAll('.product-checkbox:not(#selectAllCheckbox)');

            productCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
                const productId = checkbox.value;
                const row = document.getElementById(`row-${productId}`);

                if (selectAllCheckbox.checked) {
                    selectedProducts.add(productId);
                    row.classList.add('selected');
                } else {
                    selectedProducts.delete(productId);
                    row.classList.remove('selected');
                }
            });

            updateSelectionUI();
        }

        function updateSelectionUI() {
            const hasSelection = selectedProducts.size > 0;
            document.getElementById('markFeaturedBtn').disabled = !hasSelection;
            document.getElementById('removeFeaturedBtn').disabled = !hasSelection;
        }

        function markSelectedAsFeatured() {
            if (selectedProducts.size === 0) return;

            // Update products
            products.forEach(product => {
                if (selectedProducts.has(product.id)) {
                    product.featured = true;
                }
            });

            showAlert(`Successfully marked ${selectedProducts.size} products as featured!`, 'success');
            clearSelection();
            renderProducts();
            updateStats();
        }

        function removeFeaturedStatus() {
            if (selectedProducts.size === 0) return;

            // Update products
            products.forEach(product => {
                if (selectedProducts.has(product.id)) {
                    product.featured = false;
                }
            });

            showAlert(`Removed featured status from ${selectedProducts.size} products!`, 'success');
            clearSelection();
            renderProducts();
            updateStats();
        }

        function clearSelection() {
            selectedProducts.clear();
            document.querySelectorAll('.product-checkbox').forEach(checkbox => {
                checkbox.checked = false;
            });
            document.querySelectorAll('.table-row').forEach(row => {
                row.classList.remove('selected');
            });
            updateSelectionUI();
        }

        function filterProducts() {
            const categoryFilter = document.getElementById('categoryFilter').value;
            const sortBy = document.getElementById('sortBy').value;

            let filteredProducts = products.filter(product => {
                const matchesCategory = categoryFilter === 'all' || product.category === categoryFilter;
                return matchesCategory;
            });

            // Apply sorting
            switch (sortBy) {
                case 'sales':
                    filteredProducts.sort((a, b) => b.sales - a.sales);
                    break;
                case 'price':
                    filteredProducts.sort((a, b) => b.price - a.price);
                    break;
                case 'stock':
                    filteredProducts.sort((a, b) => b.stock - a.stock);
                    break;
                case 'name':
                    filteredProducts.sort((a, b) => a.name.localeCompare(b.name));
                    break;
            }

            renderProducts(filteredProducts);
        }

        function sortProducts() {
            filterProducts();
        }

        function openAutoMarkModal() {
            document.getElementById('autoFeatureModal').classList.add('show');
        }

        function closeModal() {
            document.getElementById('autoFeatureModal').classList.remove('show');
        }

        function handleAutoFeature(e) {
            e.preventDefault();

            const minSales = parseInt(document.getElementById('minSales').value);
            const maxFeatured = parseInt(document.getElementById('maxFeatured').value);
            const categoryPriority = document.getElementById('categoryPriority').value;
            const stockRequirement = document.getElementById('stockRequirement').value;

            // Reset all featured status first
            products.forEach(product => product.featured = false);

            // Filter products based on criteria
            let eligibleProducts = products.filter(product => {
                const meetsSalesReq = product.sales >= minSales;

                let meetsStockReq = true;
                if (stockRequirement === 'in-stock') {
                    meetsStockReq = product.stock > 0;
                } else if (stockRequirement === 'high-stock') {
                    meetsStockReq = product.stock >= 50;
                }

                let meetsCategoryReq = true;
                if (categoryPriority !== 'all') {
                    meetsCategoryReq = product.category === categoryPriority;
                }

                return meetsSalesReq && meetsStockReq && meetsCategoryReq;
            });

            // Sort eligible products by sales (descending)
            eligibleProducts.sort((a, b) => b.sales - a.sales);

            // Mark top products as featured (up to maxFeatured limit)
            const toFeature = eligibleProducts.slice(0, maxFeatured);
            toFeature.forEach(product => {
                product.featured = true;
            });

            showAlert(`Auto-featured ${toFeature.length} products based on your criteria!`, 'success');
            closeModal();
            renderProducts();
            updateStats();
        }

        function updateStats() {
            const featuredCount = products.filter(p => p.featured).length;
            const featuredRevenue = products
                .filter(p => p.featured)
                .reduce((sum, p) => sum + (p.price * p.sales), 0);
            const avgSales = featuredCount > 0 ?
                Math.round(products.filter(p => p.featured).reduce((sum, p) => sum + p.sales, 0) / featuredCount) : 0;

            // Update the stats in the UI
            document.querySelector('.stat-card .stat-value').textContent = featuredCount;
            document.querySelector('.stat-card.gold .stat-value').textContent = `₱${featuredRevenue.toLocaleString()}`;
            document.querySelector('.stat-card.silver .stat-value').textContent = avgSales;
        }

        function showAlert(message, type) {
            const alert = document.getElementById('alertContainer');
            alert.textContent = message;
            alert.className = `alert ${type}`;
            alert.classList.add('show');

            setTimeout(() => {
                alert.classList.remove('show');
            }, 3000);
        }

        // Close modal on backdrop click
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal')) {
                e.target.classList.remove('show');
            }
        });
    </script>
</body>
</html>
