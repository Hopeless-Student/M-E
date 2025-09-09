<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Product - M & E Dashboard</title>
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

        .nav-link i {
            margin-right: 1rem;
            width: 20px;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .delete-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            padding: 3rem;
            max-width: 600px;
            width: 100%;
            text-align: center;
        }

        .delete-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            margin: 0 auto 2rem;
            color: #dc2626;
        }

        .delete-title {
            font-size: 2rem;
            font-weight: 600;
            color: #dc2626;
            margin-bottom: 1rem;
        }

        .delete-message {
            color: #64748b;
            font-size: 1.1rem;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .product-preview {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 1.5rem;
            margin: 2rem 0;
            display: flex;
            align-items: center;
            gap: 1rem;
            text-align: left;
        }

        .product-image {
            width: 80px;
            height: 80px;
            background: #e2e8f0;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
        }

        .product-info h4 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 0.5rem;
        }

        .product-info p {
            color: #64748b;
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }

        .warning-box {
            background: #fef3c7;
            border: 1px solid #f59e0b;
            border-radius: 8px;
            padding: 1rem;
            margin: 2rem 0;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .warning-icon {
            color: #f59e0b;
            font-size: 1.2rem;
            margin-top: 0.1rem;
        }

        .warning-text {
            color: #92400e;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
        }

        .btn {
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.95rem;
        }

        .btn-primary {
            background-color: #1e40af;
            color: white;
        }

        .btn-primary:hover {
            background-color: #1e3a8a;
            transform: translateY(-1px);
        }

        .btn-danger {
            background-color: #dc2626;
            color: white;
        }

        .btn-danger:hover {
            background-color: #b91c1c;
            transform: translateY(-1px);
        }

        .btn-outline {
            background-color: transparent;
            color: #64748b;
            border: 1px solid #d1d5db;
        }

        .btn-outline:hover {
            background-color: #f8fafc;
            color: #374151;
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

            .main-content {
                padding: 1rem;
            }

            .delete-container {
                padding: 2rem 1.5rem;
            }

            .form-actions {
                flex-direction: column;
            }

            .product-preview {
                flex-direction: column;
                text-align: center;
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
                        <i>📊</i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../orders/index.php" class="nav-link">
                        <i>📦</i> Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./index.php" class="nav-link active">
                        <i>🛒</i> Products
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
            <div class="delete-container">
                <div class="delete-icon">
                    🗑️
                </div>

                <h2 class="delete-title">Delete Product</h2>
                <p class="delete-message">
                    Are you sure you want to permanently delete this product? This action cannot be undone and will remove all associated data.
                </p>

                <div class="product-preview" id="productPreview">
                    <div class="product-image">
                        📦
                    </div>
                    <div class="product-info">
                        <h4 id="productName">Ballpoint Pens (Pack of 12)</h4>
                        <p><strong>Category:</strong> <span id="productCategory">Office Supplies</span></p>
                        <p><strong>Price:</strong> ₱<span id="productPrice">180</span></p>
                        <p><strong>Stock:</strong> <span id="productStock">150</span> units</p>
                    </div>
                </div>

                <div class="warning-box">
                    <div class="warning-icon">⚠️</div>
                    <div class="warning-text">
                        <strong>Warning:</strong> Deleting this product will:
                        <ul style="margin: 0.5rem 0 0 1rem; text-align: left;">
                            <li>Remove it from all active orders</li>
                            <li>Delete all product history and analytics</li>
                            <li>Make it unavailable for future purchases</li>
                            <li>Remove associated inventory records</li>
                        </ul>
                    </div>
                </div>

                <form id="deleteProductForm" method="POST">
                    <input type="hidden" id="productId" name="product_id" value="">

                    <div class="form-actions">
                        <a href="./index.php" class="btn btn-outline">
                            <span>↩️</span>
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-danger">
                            <span>🗑️</span>
                            Delete Product
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <!-- Alert Container -->
    <div class="alert" id="alertContainer"></div>

    <script>
        // Sample product data (in real implementation, this would come from the server)
        const sampleProduct = {
            id: 1,
            name: "Ballpoint Pens (Pack of 12)",
            description: "High-quality ballpoint pens with smooth ink flow. Perfect for office and professional use.",
            category: "Office Supplies",
            price: 180,
            stock: 150,
            image: "./images/ballpointpen.png"
        };

        // Category mappings
        const categoryLabels = {
            'office': 'Office Supplies',
            'school': 'School Supplies',
            'sanitary': 'Sanitary Supplies'
        };

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            loadProductData();
            setupEventListeners();
        });

        function loadProductData() {
            // Get product ID from URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            const productId = urlParams.get('id') || 1;

            // In real implementation, fetch product data from server
            const product = sampleProduct;

            // Populate the preview
            document.getElementById('productId').value = product.id;
            document.getElementById('productName').textContent = product.name;
            document.getElementById('productCategory').textContent = product.category;
            document.getElementById('productPrice').textContent = product.price;
            document.getElementById('productStock').textContent = product.stock;
        }

        function setupEventListeners() {
            // Form submission
            document.getElementById('deleteProductForm').addEventListener('submit', handleDelete);
        }

        function handleDelete(e) {
            e.preventDefault();

            // Show loading state
            const submitBtn = document.querySelector('.btn-danger');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span>⏳</span> Deleting...';
            submitBtn.disabled = true;

            // Simulate deletion process
            setTimeout(() => {
                // In real implementation, send delete request to server
                showAlert('Product deleted successfully!', 'success');

                // Redirect after success
                setTimeout(() => {
                    window.location.href = './index.php';
                }, 1500);
            }, 2000);
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
    </script>
</body>
</html>
