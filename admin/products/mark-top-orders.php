<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Top Products - M & E Dashboard</title>
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
        img{
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

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 2rem;
            color: #64748b;
        }

        .breadcrumb a {
            color: #1e40af;
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
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

        /* Top Products Container */
        .top-products-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .container-header {
            padding: 2rem;
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            border-bottom: 1px solid #e5e7eb;
        }

        .container-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 0.5rem;
        }

        .container-subtitle {
            color: #64748b;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            padding: 2rem;
            background: #f8fafc;
            border-bottom: 1px solid #e5e7eb;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            border-left: 4px solid #1e40af;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .stat-card.gold {
            border-left-color: #f59e0b;
        }

        .stat-card.silver {
            border-left-color: #6b7280;
        }

        .stat-card.bronze {
            border-left-color: #d97706;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #64748b;
            margin-bottom: 0.5rem;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: #1e40af;
        }

        .stat-change {
            font-size: 0.8rem;
            margin-top: 0.25rem;
        }

        .stat-change.positive {
            color: #059669;
        }

        .stat-change.negative {
            color: #dc2626;
        }

        /* Controls */
        .controls {
            padding: 1.5rem 2rem;
            background: #f8fafc;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
        }

        .category-filter {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .form-select, .form-input {
            padding: 0.5rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            background: white;
            font-size: 0.9rem;
        }

        .mark-actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
        }

        .btn-primary {
            background: #1e40af;
            color: white;
        }

        .btn-primary:hover {
            background: #1e3a8a;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #64748b;
            color: white;
        }

        .btn-secondary:hover {
            background: #475569;
        }

        .btn-gold {
            background: #f59e0b;
            color: white;
        }

        .btn-gold:hover {
            background: #d97706;
        }

        /* Products Table */
        .products-table {
            width: 100%;
        }

        .table-header {
            background: #f8fafc;
            border-bottom: 2px solid #e5e7eb;
        }

        .table-header th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #374151;
            font-size: 0.9rem;
        }

        .table-row {
            border-bottom: 1px solid #e5e7eb;
            transition: all 0.2s ease;
        }

        .table-row:hover {
            background: #f8fafc;
        }

        .table-row.featured {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            border-left: 4px solid #f59e0b;
        }

        .table-row.selected {
            background: #eff6ff;
            border-left: 4px solid #1e40af;
        }

        .table-cell {
            padding: 1rem;
            vertical-align: middle;
        }

        .checkbox-cell {
            width: 50px;
            text-align: center;
        }

        .product-checkbox {
            width: 18px;
            height: 18px;
            accent-color: #1e40af;
        }

        .product-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .product-image {
            width: 50px;
            height: 50px;
            background: #e2e8f0;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .product-details h4 {
            font-size: 0.95rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.25rem;
        }

        .product-details p {
            font-size: 0.85rem;
            color: #64748b;
        }

        .category-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 500;
            background: #e2e8f0;
            color: #475569;
        }

        .category-badge.office {
            background: #dbeafe;
            color: #1e40af;
        }

        .category-badge.school {
            background: #dcfce7;
            color: #166534;
        }

        .category-badge.hygiene {
            background: #fef3c7;
            color: #92400e;
        }

        .price-info {
            text-align: right;
        }

        .current-price {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1e40af;
        }

        .original-price {
            font-size: 0.85rem;
            color: #64748b;
            text-decoration: line-through;
        }

        .stock-info {
            text-align: center;
        }

        .stock-count {
            font-size: 1rem;
            font-weight: 600;
            color: #374151;
        }

        .stock-status {
            font-size: 0.8rem;
            margin-top: 0.25rem;
        }

        .stock-status.in-stock {
            color: #059669;
        }

        .stock-status.low-stock {
            color: #d97706;
        }

        .stock-status.out-of-stock {
            color: #dc2626;
        }

        .sales-stats {
            text-align: center;
        }

        .sales-count {
            font-size: 1rem;
            font-weight: 600;
            color: #374151;
        }

        .sales-trend {
            font-size: 0.8rem;
            margin-top: 0.25rem;
        }

        .sales-trend.up {
            color: #059669;
        }

        .sales-trend.down {
            color: #dc2626;
        }

        .featured-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.25rem 0.5rem;
            background: #f59e0b;
            color: white;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal.show {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 500px;
            padding: 2rem;
        }

        .modal-header {
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 0.5rem;
        }

        .modal-subtitle {
            color: #64748b;
            font-size: 0.9rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #374151;
        }

        .form-textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 0.9rem;
            resize: vertical;
            min-height: 80px;
        }

        .modal-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 2rem;
        }

        /* Alert */
        .alert {
            position: fixed;
            top: 2rem;
            right: 2rem;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            z-index: 1100;
            transform: translateX(400px);
            transition: transform 0.3s ease;
        }

        .alert.show {
            transform: translateX(0);
        }

        .alert.success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert.error {
            background: #fee2e2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        @media (max-width: 768px) {
            .dashboard {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .controls {
                flex-direction: column;
                align-items: stretch;
            }

            .category-filter {
                justify-content: center;
            }

            .mark-actions {
                justify-content: center;
            }

            .products-table {
                font-size: 0.85rem;
            }

            .table-cell {
                padding: 0.75rem 0.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="logo">
                <img src="../../assets/images/logo/ME logo.png" alt="">
            </div>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="../index.php" class="nav-link">
                        <i data-lucide="bar-chart-3"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../orders/index.php" class="nav-link">
                        <i data-lucide="package"></i> Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./index.php" class="nav-link active">
                        <i data-lucide="shopping-cart"></i> Products
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../users/index.php" class="nav-link">
                        <i data-lucide="users"></i> Customers
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../inventory/index.php" class="nav-link">
                        <i data-lucide="clipboard-list"></i> Inventory
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../requests/index.php" class="nav-link">
                        <i data-lucide="message-circle"></i> Messages
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../settings/index.php" class="nav-link">
                        <i data-lucide="settings"></i> Settings
                    </a>
                </li>
            </ul>
        </nav>

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

            <div class="top-products-container">
                <div class="container-header">
                    <h3 class="container-title">Featured Products Management</h3>
                    <p class="container-subtitle">Mark products as featured to showcase them as best-sellers and boost their visibility</p>
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
                    <div class="stat-card bronze">
                        <div class="stat-label">Conversion Rate</div>
                        <div class="stat-value">12.5%</div>
                        <div class="stat-change positive">↗ +2.1% improvement</div>
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
                <div class="form-group">
                    <label class="form-label">Minimum Sales Count</label>
                    <input type="number" class="form-input" id="minSales" value="50" min="0">
                </div>
                <div class="form-group">
                    <label class="form-label">Maximum Featured Products</label>
                    <input type="number" class="form-input" id="maxFeatured" value="15" min="1" max="20">
                </div>
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
            document.getElementById('sortBy').addEventListener('change', sortProducts);
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
            const category = document.getElementById('categoryFilter').value;
            let filtered = products;

            if (category !== 'all') {
                filtered = products.filter(product => product.category === category);
            }

            renderProducts(filtered);
        }

        function sortProducts() {
            const sortBy = document.getElementById('sortBy').value;
            let sorted = [...products];

            switch (sortBy) {
                case 'sales':
                    sorted.sort((a, b) => b.sales - a.sales);
                    break;
                case 'price':
                    sorted.sort((a, b) => b.price - a.price);
                    break;
                case 'stock':
                    sorted.sort((a, b) => b.stock - a.stock);
                    break;
                case 'name':
                    sorted.sort((a, b) => a.name.localeCompare(b.name));
                    break;
            }

            renderProducts(sorted);
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
            let eligible = products.filter(product => {
                if (product.sales < minSales) return false;

                if (stockRequirement === 'in-stock' && product.stock === 0) return false;
                if (stockRequirement === 'high-stock' && product.stock < 50) return false;

                return true;
            });

            // Sort by priority
            if (categoryPriority !== 'all') {
                eligible.sort((a, b) => {
                    if (a.category === categoryPriority && b.category !== categoryPriority) return -1;
                    if (a.category !== categoryPriority && b.category === categoryPriority) return 1;
                    return b.sales - a.sales;
                });
            } else {
                eligible.sort((a, b) => b.sales - a.sales);
            }

            // Mark top products as featured
            const toFeature = eligible.slice(0, maxFeatured);
            toFeature.forEach(product => product.featured = true);

            showAlert(`Auto-featured ${toFeature.length} products based on criteria!`, 'success');
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
