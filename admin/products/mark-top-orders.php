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
    <?php
    // require_once __DIR__ . '/../../includes/auth.php'; // Uncomment to enable authentication
    ?>
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
                        <div class="stat-value" id="statFeaturedCount">0</div>
                        <div class="stat-change positive">↗ Featured items</div>
                    </div>
                    <div class="stat-card gold">
                        <div class="stat-label">Featured Revenue</div>
                        <div class="stat-value" id="statRevenue">₱0</div>
                        <div class="stat-change positive">↗ Potential value</div>
                    </div>
                    <div class="stat-card silver">
                        <div class="stat-label">Avg. Featured Stock</div>
                        <div class="stat-value" id="statAvgStock">0</div>
                        <div class="stat-change positive">↗ Units available</div>
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
                            <option value="sanitary">Sanitary Supplies</option>
                        </select>
                        <select class="form-select" id="sortBy">
                            <option value="featured">Sort by Featured</option>
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
                            <th>Unit</th>
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
                            <label class="form-label">Minimum Stock Count</label>
                            <input type="number" class="form-input" id="minStock" value="50" min="0">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Maximum Featured Products</label>
                            <input type="number" class="form-input" id="maxFeatured" value="15" min="1" max="50">
                        </div>
                    </div>
                    <div class="form-column">
                        <div class="form-group">
                            <label class="form-label">Category Priority</label>
                            <select class="form-select" id="categoryPriority">
                                <option value="all">All Categories</option>
                                <option value="office">Office Supplies First</option>
                                <option value="school">School Supplies First</option>
                                <option value="sanitary">Sanitary Supplies First</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Stock Requirement</label>
                            <select class="form-select" id="stockRequirement">
                                <option value="any">Any Stock Level</option>
                                <option value="in-stock">In Stock Only</option>
                                <option value="high-stock">High Stock Only (50+)</option>
                            </select>
                        </div>
                    </div>
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

        let products = [];
        let selectedProducts = new Set();

        document.addEventListener('DOMContentLoaded', function() {
            loadProducts();
            setupEventListeners();
        });

        async function loadProducts() {
            try {
                const res = await fetch(`../../api/admin/products/list.php?page=1&pageSize=1000&_=${Date.now()}`, {
                    headers: { 'Accept': 'application/json' },
                    cache: 'no-store'
                });
                if (!res.ok) throw new Error('Failed to load products');
                const data = await res.json();

                products = (data.items || []).map(p => ({
                    id: p.id,
                    name: p.name,
                    description: p.description || '',
                    category: (p.category || '').toLowerCase().includes('office') ? 'office' :
                              (p.category || '').toLowerCase().includes('school') ? 'school' : 'sanitary',
                    categoryLabel: p.categoryLabel || p.category || '',
                    price: Number(p.price || 0),
                    stock: Number(p.stock || 0),
                    unit: p.unit || 'pieces',
                    featured: !!p.featured,
                    image: p.image ? `<img src="${p.image}" alt="${p.name}" style="width:24px;height:24px;border-radius:4px;object-fit:cover;" />` : '📦'
                }));

                selectedProducts.clear();
                filterProducts();
                updateStats();
            } catch (e) {
                console.error(e);
                showAlert('Failed to load products', 'error');
            }
        }

        function setupEventListeners() {
            document.getElementById('autoFeatureForm').addEventListener('submit', handleAutoFeature);
            document.getElementById('categoryFilter').addEventListener('change', filterProducts);
            document.getElementById('sortBy').addEventListener('change', filterProducts);
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
                                    <p>${product.description.substring(0, 50)}${product.description.length > 50 ? '...' : ''}</p>
                                </div>
                            </div>
                        </td>
                        <td class="table-cell">
                            <span class="category-badge ${categoryClass}">${product.categoryLabel}</span>
                        </td>
                        <td class="table-cell">
                            <div class="price-info">
                                <div class="current-price">₱${product.price.toFixed(2)}</div>
                            </div>
                        </td>
                        <td class="table-cell">
                            <div class="stock-info">
                                <div class="stock-count">${product.stock}</div>
                                <div class="stock-status ${stockClass}">${stockStatus}</div>
                            </div>
                        </td>
                        <td class="table-cell">
                            <span style="text-transform: capitalize;">${product.unit}</span>
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

            lucide.createIcons();
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

        async function markSelectedAsFeatured() {
            if (selectedProducts.size === 0) return;
            try {
                const res = await fetch('../../api/admin/products/feature.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ ids: Array.from(selectedProducts), featured: 1 })
                });
                const data = await res.json();
                if (!res.ok) throw new Error(data.error || 'Feature failed');
                showAlert(data.message || `Successfully marked ${selectedProducts.size} products as featured!`, 'success');
                clearSelection();
                await loadProducts();
            } catch (err) {
                console.error(err);
                showAlert(err.message || 'Failed to mark as featured', 'error');
            }
        }

        async function removeFeaturedStatus() {
            if (selectedProducts.size === 0) return;
            try {
                const res = await fetch('../../api/admin/products/feature.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ ids: Array.from(selectedProducts), featured: 0 })
                });
                const data = await res.json();
                if (!res.ok) throw new Error(data.error || 'Unfeature failed');
                showAlert(data.message || `Removed featured status from ${selectedProducts.size} products!`, 'success');
                clearSelection();
                await loadProducts();
            } catch (err) {
                console.error(err);
                showAlert(err.message || 'Failed to remove featured', 'error');
            }
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
                return categoryFilter === 'all' || product.category === categoryFilter;
            });

            // Apply sorting
            switch (sortBy) {
                case 'featured':
                    filteredProducts.sort((a, b) => (b.featured ? 1 : 0) - (a.featured ? 1 : 0));
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

        function openAutoMarkModal() {
            document.getElementById('autoFeatureModal').classList.add('show');
        }

        function closeModal() {
            document.getElementById('autoFeatureModal').classList.remove('show');
        }

        async function handleAutoFeature(e) {
            e.preventDefault();

            const minStock = parseInt(document.getElementById('minStock').value);
            const maxFeatured = parseInt(document.getElementById('maxFeatured').value);
            const categoryPriority = document.getElementById('categoryPriority').value;
            const stockRequirement = document.getElementById('stockRequirement').value;

            // Filter products based on criteria
            let eligibleProducts = products.filter(product => {
                const meetsStockMin = product.stock >= minStock;

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

                return meetsStockMin && meetsStockReq && meetsCategoryReq;
            });

            // Sort by stock (descending)
            eligibleProducts.sort((a, b) => b.stock - a.stock);

            // Get top products
            const toFeatureIds = eligibleProducts.slice(0, maxFeatured).map(p => p.id);

            if (toFeatureIds.length === 0) {
                showAlert('No products match the criteria', 'error');
                return;
            }

            try {
                // First, unfeature all
                const allIds = products.map(p => p.id);
                await fetch('../../api/admin/products/feature.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ ids: allIds, featured: 0 })
                });

                // Then feature selected ones
                const res = await fetch('../../api/admin/products/feature.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ ids: toFeatureIds, featured: 1 })
                });

                const data = await res.json();
                if (!res.ok) throw new Error(data.error || 'Auto feature failed');

                showAlert(`Auto-featured ${toFeatureIds.length} products based on your criteria!`, 'success');
                closeModal();
                await loadProducts();
            } catch (err) {
                console.error(err);
                showAlert(err.message || 'Failed to auto-feature products', 'error');
            }
        }

        function updateStats() {
            const featuredProducts = products.filter(p => p.featured);
            const featuredCount = featuredProducts.length;
            const featuredRevenue = featuredProducts.reduce((sum, p) => sum + (p.price * p.stock), 0);
            const avgStock = featuredCount > 0 ?
                Math.round(featuredProducts.reduce((sum, p) => sum + p.stock, 0) / featuredCount) : 0;

            document.getElementById('statFeaturedCount').textContent = featuredCount;
            document.getElementById('statRevenue').textContent = `₱${featuredRevenue.toLocaleString('en-PH', {minimumFractionDigits: 2})}`;
            document.getElementById('statAvgStock').textContent = avgStock;
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
