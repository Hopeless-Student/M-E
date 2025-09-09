<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - M & E Dashboard</title>
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

        /* Product Controls */
        .product-controls {
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

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
        }

        .btn-primary {
            background-color: #1e40af;
            color: white;
        }

        .btn-primary:hover {
            background-color: #1e3a8a;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background-color: #64748b;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #475569;
        }

        .btn-outline {
            background-color: transparent;
            color: #1e40af;
            border: 1px solid #1e40af;
        }

        .btn-outline:hover {
            background-color: #1e40af;
            color: white;
        }

        .btn-warning {
            background-color: #f59e0b;
            color: white;
        }

        .btn-warning:hover {
            background-color: #d97706;
        }

        /* Products Grid */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.5rem;
        }

        .product-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            position: relative;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .product-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .product-image-container {
            height: 200px;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            flex-shrink: 0;
        }

        .product-image-container img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 10px;
        }

        .product-info {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .category-badge {
            padding: 0.25rem 0.5rem;
            background-color: #e0e7ff;
            color: #1e40af;
            border-radius: 6px;
            font-size: 0.8rem;
            margin-bottom: 1rem;
            display: inline-block;
            align-self: flex-start;
            flex-shrink: 0;
        }

        .product-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 0.5rem;
            flex-shrink: 0;
        }

        .product-description {
            color: #64748b;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            line-height: 1.5;
            flex-grow: 1;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            flex-shrink: 0;
        }

        .product-price {
            font-size: 1.2rem;
            font-weight: 700;
            color: #1e40af;
        }

        .product-stock {
            font-size: 0.9rem;
            color: #64748b;
        }

        .product-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: auto;
            flex-shrink: 0;
        }

        .action-btn {
            flex: 1;
            padding: 0.5rem;
            border: 1px solid #d1d5db;
            background: white;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.8rem;
            transition: all 0.2s ease;
            text-decoration: none;
            text-align: center;
            color: #374151;
        }

        .action-btn.primary {
            background-color: #1e40af;
            color: white;
            border-color: #1e40af;
        }

        .action-btn.danger {
            background-color: #dc2626;
            color: white;
            border-color: #dc2626;
        }

        .action-btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .stock-status {
            position: absolute;
            top: 1rem;
            right: 1rem;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .stock-status.in-stock {
            background-color: #d1fae5;
            color: #065f46;
        }

        .stock-status.low-stock {
            background-color: #fef3c7;
            color: #92400e;
        }

        .stock-status.out-of-stock {
            background-color: #fee2e2;
            color: #dc2626;
        }

        .no-products {
            text-align: center;
            padding: 4rem 2rem;
            color: #64748b;
        }

        .no-products h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        /* Quick Stats */
        .quick-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #1e40af;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e40af;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #64748b;
            margin-top: 0.25rem;
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            max-width: 700px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            transform: scale(0.9) translateY(20px);
            transition: transform 0.3s ease;
        }

        .modal-overlay.active .modal {
            transform: scale(1) translateY(0);
        }

        .modal-header {
            padding: 2rem 2rem 1rem;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e40af;
            margin: 0;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #6b7280;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .modal-close:hover {
            background-color: #f3f4f6;
            color: #374151;
        }

        .modal-body {
            padding: 2rem;
        }

        .product-modal-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            align-items: start;
        }

        .modal-image-section {
            text-align: center;
        }

        .modal-product-image {
            width: 100%;
            max-width: 300px;
            height: 300px;
            object-fit: contain;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 1rem;
            background: #f9fafb;
            margin-bottom: 1rem;
        }

        .image-placeholder {
            width: 100%;
            height: 300px;
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6b7280;
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .modal-details-section h3 {
            color: #1e40af;
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .modal-category-badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
            color: #1e40af;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .product-detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .product-detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 600;
            color: #374151;
            font-size: 0.95rem;
        }

        .detail-value {
            color: #6b7280;
            font-size: 0.95rem;
        }

        .detail-value.price {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e40af;
        }

        .detail-value.stock {
            font-weight: 600;
        }

        .modal-description {
            background: #f8fafc;
            padding: 1.5rem;
            border-radius: 12px;
            margin: 1.5rem 0;
            border-left: 4px solid #1e40af;
        }

        .modal-description h4 {
            color: #374151;
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .modal-description p {
            color: #6b7280;
            line-height: 1.6;
            margin: 0;
        }

        .modal-footer {
            padding: 1.5rem 2rem;
            border-top: 1px solid #e5e7eb;
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
        }

        .modal-btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .modal-btn-edit {
            background-color: #1e40af;
            color: white;
        }

        .modal-btn-edit:hover {
            background-color: #1e3a8a;
            transform: translateY(-1px);
        }

        .modal-btn-delete {
            background-color: #dc2626;
            color: white;
        }

        .modal-btn-delete:hover {
            background-color: #b91c1c;
        }

        .modal-btn-secondary {
            background-color: #6b7280;
            color: white;
        }

        .modal-btn-secondary:hover {
            background-color: #4b5563;
        }

        .stock-indicator {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .stock-indicator.in-stock {
            background-color: #d1fae5;
            color: #065f46;
        }

        .stock-indicator.low-stock {
            background-color: #fef3c7;
            color: #92400e;
        }

        .stock-indicator.out-of-stock {
            background-color: #fee2e2;
            color: #dc2626;
        }

        .stock-indicator::before {
            content: '';
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: currentColor;
        }

        /* Delete Confirmation Modal */
        .delete-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1200;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .delete-modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .delete-modal {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            width: 90%;
            transform: scale(0.9) translateY(20px);
            transition: transform 0.3s ease;
        }

        .delete-modal-overlay.active .delete-modal {
            transform: scale(1) translateY(0);
        }

        .delete-modal-header {
            padding: 2rem 2rem 1rem;
            text-align: center;
        }

        .delete-modal-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            color: #dc2626;
            font-size: 2.5rem;
        }

        .delete-modal-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #dc2626;
            margin-bottom: 0.5rem;
        }

        .delete-modal-subtitle {
            color: #6b7280;
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        .delete-modal-body {
            padding: 0 2rem 2rem;
        }

        .delete-product-info {
            background: #f9fafb;
            border: 2px solid #fee2e2;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .delete-product-name {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 0.5rem;
        }

        .delete-product-details {
            display: flex;
            justify-content: space-between;
            color: #6b7280;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .delete-warning {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-left: 4px solid #f59e0b;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }

        .delete-warning-title {
            font-weight: 600;
            color: #92400e;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .delete-warning-text {
            color: #92400e;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .delete-modal-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        .delete-modal-btn {
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            min-width: 120px;
            justify-content: center;
        }

        .delete-modal-btn-cancel {
            background-color: #6b7280;
            color: white;
        }

        .delete-modal-btn-cancel:hover {
            background-color: #4b5563;
        }

        .delete-modal-btn-confirm {
            background-color: #dc2626;
            color: white;
        }

        .delete-modal-btn-confirm:hover {
            background-color: #b91c1c;
            transform: translateY(-1px);
        }

        /* Alert */
        .alert {
            position: fixed;
            top: 2rem;
            right: 2rem;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            z-index: 1300;
            transform: translateX(400px);
            transition: transform 0.3s ease;
        }

        .alert.show {
            transform: translateX(0);
        }

        .alert.success {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert.error {
            background-color: #fee2e2;
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

            .product-controls {
                flex-direction: column;
                align-items: stretch;
            }

            .search-filter {
                flex-direction: column;
            }

            .search-box input {
                width: 100%;
            }

            .products-grid {
                grid-template-columns: 1fr;
            }

            .main-content {
                padding: 1rem;
            }

            .quick-stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .modal {
                width: 95%;
                margin: 1rem;
            }

            .product-modal-content {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .modal-footer {
                flex-direction: column;
            }

            .delete-modal-actions {
                flex-direction: column;
            }

            .delete-modal-btn {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="logo">
                <h1>M & E</h1>
                <p>Admin Dashboard</p>
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
                <h2>Products Management</h2>
                <div class="user-info">
                    <span>Admin Panel</span>
                    <div class="avatar">A</div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="quick-stats">
                <div class="stat-card">
                    <div class="stat-value" id="totalProducts">0</div>
                    <div class="stat-label">Total Products</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" id="lowStockProducts">0</div>
                    <div class="stat-label">Low Stock Items</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" id="totalValue">₱0</div>
                    <div class="stat-label">Total Inventory Value</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value" id="outOfStock">0</div>
                    <div class="stat-label">Out of Stock</div>
                </div>
            </div>

            <!-- Product Controls -->
            <div class="product-controls">
                <div class="search-filter">
                    <div class="search-box">
                        <input type="text" placeholder="Search products..." id="searchInput">
                    </div>
                    <select class="filter-select" id="categoryFilter">
                        <option value="">All Categories</option>
                        <option value="office">Office Supplies</option>
                        <option value="school">School Supplies</option>
                        <option value="sanitary">Sanitary Supplies</option>
                    </select>
                    <select class="filter-select" id="stockFilter">
                        <option value="">All Stock</option>
                        <option value="in-stock">In Stock</option>
                        <option value="low-stock">Low Stock</option>
                        <option value="out-of-stock">Out of Stock</option>
                    </select>
                </div>
                <div class="action-buttons">
                    <a href="./add-product.php" class="btn btn-primary">
                        <span data-lucide="circle-plus"></span>
                        Add Product
                    </a>
                    <a href="./bulk-actions.php" class="btn btn-secondary">
                        <span data-lucide="cog"></span>
                        Bulk Actions
                    </a>
                    <a href="./mark-top-orders.php" class="btn btn-warning">
                        <span data-lucide="star"></span>
                        Top Orders
                    </a>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="products-grid" id="productsGrid">
                <!-- Products will be loaded here dynamically -->
            </div>

            <!-- No Products Message -->
            <div class="no-products" id="noProducts" style="display: none;">
                <h3>No products found</h3>
                <p>Try adjusting your search or filter criteria, or <a href="./add-product.php" style="color: #1e40af;">add your first product</a></p>
            </div>
        </main>
    </div>

    <!-- Product View Modal -->
    <div class="modal-overlay" id="productModal">
        <div class="modal">
            <div class="modal-header">
                <h2 class="modal-title">Product Details</h2>
                <button class="modal-close" onclick="closeProductModal()">✕</button>
            </div>
            <div class="modal-body">
                <div class="product-modal-content" id="modalContent">
                    <!-- Product details will be loaded here -->
                </div>
            </div>
            <div class="modal-footer">
                <button class="modal-btn modal-btn-secondary" onclick="closeProductModal()">Close</button>
                <a href="#" class="modal-btn modal-btn-edit" id="modalEditBtn">
                    <i data-lucide="pencil"></i> Edit Product
                </a>
                <a href="#" class="modal-btn modal-btn-delete" id="modalDeleteBtn">
                    <i data-lucide="trash-2"></i> Delete Product
                </a>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="delete-modal-overlay" id="deleteModal">
        <div class="delete-modal">
            <div class="delete-modal-header">
                <i class="delete-modal-icon" data-lucide="trash"></i>
                <h2 class="delete-modal-title">Delete Product</h2>
                <p class="delete-modal-subtitle">Are you sure you want to delete this product?</p>
            </div>
            <div class="delete-modal-body">
                <div class="delete-product-info" id="deleteProductInfo">
                    <!-- Product info will be loaded here -->
                </div>
                <div class="delete-warning">
                    <div class="delete-warning-title">
                        <i data-lucide="Triangle-alert"></i> Warning
                    </div>
                    <div class="delete-warning-text">
                        This action cannot be undone. The product will be permanently removed from your inventory and all associated data will be lost.
                    </div>
                </div>
                <div class="delete-modal-actions">
                    <button class="delete-modal-btn delete-modal-btn-cancel" onclick="closeDeleteModal()">
                        Cancel
                    </button>
                    <button class="delete-modal-btn delete-modal-btn-confirm" id="confirmDeleteBtn">
                        <i data-lucide="trash-2"></i> Delete Product
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Container -->
    <div class="alert" id="alertContainer"></div>

    <script>
        lucide.createIcons();
        let products = [
            {
                id: 1,
                name: "Ballpoint Pens (Pack of 12)",
                description: "High-quality ballpoint pens with smooth ink flow. Perfect for office and professional use.",
                category: "office",
                price: 180,
                stock: 150,
                image: "./images/ballpointpen.png"
            },
            {
                id: 2,
                name: "Bond Paper (1 Ream)",
                description: "Premium white bond paper, 80gsm, 500 sheets per ream. Ideal for printing and copying.",
                category: "office",
                price: 320,
                stock: 75,
                image: "./images/bondpaper.png"
            },
            {
                id: 3,
                name: "File Folders (Pack of 10)",
                description: "Durable manila folders for document organization. Letter size with tab labels.",
                category: "office",
                price: 250,
                stock: 8,
                image: "./images/folders.png"
            },
            {
                id: 4,
                name: "Spiral Notebooks (Pack of 5)",
                description: "100-page ruled notebooks with durable spiral binding. Perfect for students.",
                category: "school",
                price: 125,
                stock: 200,
                image: "./images/notebooks.png"
            },
            {
                id: 5,
                name: "No. 2 Pencils (Pack of 24)",
                description: "Standard #2 pencils with erasers. Ideal for tests, homework, and daily writing.",
                category: "school",
                price: 95,
                stock: 120,
                image: "./images/pencils.png"
            },
            {
                id: 6,
                name: "Hand Sanitizer (500ml)",
                description: "70% alcohol-based hand sanitizer with moisturizers. Kills 99.9% of germs and provides long-lasting protection against bacteria and viruses. Contains vitamin E and aloe vera for skin softening.",
                category: "sanitary",
                price: 145,
                stock: 0,
                image: "./images/sanitizer.png"
            }
        ];

        // Category mappings
        const categoryLabels = {
            'office': 'Office Supplies',
            'school': 'School Supplies',
            'sanitary': 'Sanitary Supplies'
        };

        // Initialize the app
        document.addEventListener('DOMContentLoaded', function() {
            renderProducts();
            updateStats();
            setupEventListeners();
        });

        function setupEventListeners() {
            // Search functionality
            document.getElementById('searchInput').addEventListener('input', filterProducts);
            document.getElementById('categoryFilter').addEventListener('change', filterProducts);
            document.getElementById('stockFilter').addEventListener('change', filterProducts);

            // Modal close on outside click
            document.getElementById('productModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeProductModal();
                }
            });

            // Delete modal close on outside click
            document.getElementById('deleteModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeDeleteModal();
                }
            });

            // ESC key to close modal
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeProductModal();
                    closeDeleteModal();
                }
            });

            // Check for URL parameters (success/error messages)
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('success')) {
                showAlert('Operation completed successfully!', 'success');
            } else if (urlParams.get('error')) {
                showAlert('An error occurred. Please try again.', 'error');
            }
        }

        function updateStats() {
            const totalProducts = products.length;
            const lowStockProducts = products.filter(p => p.stock > 0 && p.stock <= 15).length;
            const outOfStock = products.filter(p => p.stock === 0).length;
            const totalValue = products.reduce((sum, p) => sum + (p.price * p.stock), 0);

            document.getElementById('totalProducts').textContent = totalProducts;
            document.getElementById('lowStockProducts').textContent = lowStockProducts;
            document.getElementById('totalValue').textContent = '₱' + totalValue.toLocaleString();
            document.getElementById('outOfStock').textContent = outOfStock;
        }

        function getStockStatus(stock) {
            if (stock === 0) return 'out-of-stock';
            if (stock <= 15) return 'low-stock';
            return 'in-stock';
        }

        function getStockLabel(stock) {
            if (stock === 0) return 'Out of Stock';
            if (stock <= 15) return 'Low Stock';
            return 'In Stock';
        }

        function renderProducts(filteredProducts = products) {
            const grid = document.getElementById('productsGrid');
            const noProducts = document.getElementById('noProducts');

            if (filteredProducts.length === 0) {
                grid.style.display = 'none';
                noProducts.style.display = 'block';
                return;
            }

            grid.style.display = 'grid';
            noProducts.style.display = 'none';

            grid.innerHTML = filteredProducts.map(product => {
                const stockStatus = getStockStatus(product.stock);
                const stockLabel = getStockLabel(product.stock);

                return `
                    <div class="product-card" data-category="${product.category}">
                        <div class="product-image-container">
                            <img src="${product.image || './images/placeholder.png'}" alt="${product.name}" onerror="this.src='./images/placeholder.png'">
                            <div class="stock-status ${stockStatus}">${stockLabel}</div>
                        </div>
                        <div class="product-info">
                            <div class="category-badge">${categoryLabels[product.category]}</div>
                            <h3 class="product-title">${product.name}</h3>
                            <p class="product-description">${product.description}</p>
                            <div class="product-details">
                                <span class="product-price">₱${product.price}</span>
                                <span class="product-stock">Stock: ${product.stock}</span>
                            </div>
                            <div class="product-actions">
                                <a href="./edit-product.php?id=${product.id}" class="action-btn primary">Edit</a>
                                <button class="action-btn" onclick="viewProduct(${product.id})">View</button>
                                <button class="action-btn danger" onclick="showDeleteModal(${product.id})">Delete</button>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');
        }

        function filterProducts() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const categoryFilter = document.getElementById('categoryFilter').value;
            const stockFilter = document.getElementById('stockFilter').value;

            const filtered = products.filter(product => {
                const matchesSearch = product.name.toLowerCase().includes(searchTerm) ||
                                    product.description.toLowerCase().includes(searchTerm);

                const matchesCategory = !categoryFilter || product.category === categoryFilter;

                let matchesStock = true;
                if (stockFilter) {
                    const stockStatus = getStockStatus(product.stock);
                    matchesStock = stockStatus === stockFilter;
                }

                return matchesSearch && matchesCategory && matchesStock;
            });

            renderProducts(filtered);
        }

        function viewProduct(id) {
            const product = products.find(p => p.id === id);
            if (!product) return;

            const stockStatus = getStockStatus(product.stock);
            const stockLabel = getStockLabel(product.stock);

            const modalContent = `
                <div class="modal-image-section">
                    ${product.image ?
                        `<img src="${product.image}" alt="${product.name}" class="modal-product-image" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                         <div class="image-placeholder" style="display: none;">📦</div>` :
                        `<div class="image-placeholder">📦</div>`
                    }
                    <div class="modal-category-badge">${categoryLabels[product.category]}</div>
                </div>
                <div class="modal-details-section">
                    <h3>${product.name}</h3>

                    <div class="modal-description">
                        <h4>Description</h4>
                        <p>${product.description}</p>
                    </div>

                    <div class="product-detail-row">
                        <span class="detail-label">Product ID</span>
                        <span class="detail-value">#${String(product.id).padStart(4, '0')}</span>
                    </div>

                    <div class="product-detail-row">
                        <span class="detail-label">Price</span>
                        <span class="detail-value price">₱${product.price.toLocaleString()}</span>
                    </div>

                    <div class="product-detail-row">
                        <span class="detail-label">Stock Quantity</span>
                        <span class="detail-value stock">${product.stock} units</span>
                    </div>

                    <div class="product-detail-row">
                        <span class="detail-label">Stock Status</span>
                        <span class="stock-indicator ${stockStatus}">${stockLabel}</span>
                    </div>

                    <div class="product-detail-row">
                        <span class="detail-label">Category</span>
                        <span class="detail-value">${categoryLabels[product.category]}</span>
                    </div>

                    <div class="product-detail-row">
                        <span class="detail-label">Total Value</span>
                        <span class="detail-value">₱${(product.price * product.stock).toLocaleString()}</span>
                    </div>
                </div>
            `;

            document.getElementById('modalContent').innerHTML = modalContent;
            document.getElementById('modalEditBtn').href = `./edit-product.php?id=${product.id}`;
            document.getElementById('modalDeleteBtn').onclick = function(e) {
                e.preventDefault();
                showDeleteModal(product.id);
            };

            openProductModal();
        }

        function showDeleteModal(productId) {
            const product = products.find(p => p.id === productId);
            if (!product) return;

            const stockStatus = getStockStatus(product.stock);
            const stockValue = product.price * product.stock;

            const deleteProductInfo = `
                <div class="delete-product-name">${product.name}</div>
                <div class="delete-product-details">
                    <span>ID: #${String(product.id).padStart(4, '0')}</span>
                    <span>Stock: ${product.stock} units</span>
                </div>
                <div class="delete-product-details">
                    <span>Price: ₱${product.price.toLocaleString()}</span>
                    <span>Total Value: ₱${stockValue.toLocaleString()}</span>
                </div>
            `;

            document.getElementById('deleteProductInfo').innerHTML = deleteProductInfo;

            // Set up confirm delete button
            document.getElementById('confirmDeleteBtn').onclick = function() {
                deleteProduct(product.id);
            };

            openDeleteModal();
        }

        function deleteProduct(productId) {
            const product = products.find(p => p.id === productId);
            if (!product) return;

            // In a real application, you would make an API call here
            // For demo purposes, we'll remove from the local array
            const productIndex = products.findIndex(p => p.id === productId);
            if (productIndex > -1) {
                products.splice(productIndex, 1);

                // Update the UI
                renderProducts();
                updateStats();

                // Close modals and show success message
                closeDeleteModal();
                closeProductModal();

                showAlert(`Product "${product.name}" has been deleted successfully.`, 'success');
            }
        }

        function openDeleteModal() {
            document.getElementById('deleteModal').classList.add('active');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('active');
        }

        function openProductModal() {
            document.body.style.overflow = 'hidden';
            document.getElementById('productModal').classList.add('active');
        }

        function closeProductModal() {
            document.body.style.overflow = '';
            document.getElementById('productModal').classList.remove('active');
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

        // Handle real-time updates (simulate WebSocket or polling)
        function refreshProducts() {
            // In a real app, this would fetch from the server
            renderProducts();
            updateStats();
        }

    </script>
</body>
</html>
