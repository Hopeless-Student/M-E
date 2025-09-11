<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - M & E Dashboard</title>
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

        /* Form Styles */
        .form-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            max-width: 800px;
        }

        .form-header {
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .form-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 0.5rem;
        }

        .form-subtitle {
            color: #64748b;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #374151;
        }

        .form-label.required::after {
            content: ' *';
            color: #dc2626;
        }

        .form-input, .form-textarea, .form-select {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 0.9rem;
            transition: border-color 0.2s ease;
        }

        .form-input:focus, .form-textarea:focus, .form-select:focus {
            outline: none;
            border-color: #1e40af;
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
        }

        .form-textarea {
            resize: vertical;
            min-height: 100px;
        }

        .file-upload-container {
            position: relative;
            border: 2px dashed #d1d5db;
            border-radius: 8px;
            padding: 2rem;
            text-align: center;
            transition: border-color 0.2s ease;
            background: #f9fafb;
        }

        .file-upload-container:hover {
            border-color: #1e40af;
            background: #eff6ff;
        }

        .file-upload-container.dragover {
            border-color: #1e40af;
            background: #eff6ff;
        }

        .file-upload-input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .file-upload-label {
            cursor: pointer;
            color: #1e40af;
            font-weight: 500;
        }

        .file-upload-text {
            color: #64748b;
            margin-top: 0.5rem;
        }

        .image-preview {
            max-width: 200px;
            max-height: 200px;
            border-radius: 8px;
            border: 1px solid #d1d5db;
            margin-top: 1rem;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            padding-top: 2rem;
            border-top: 1px solid #e5e7eb;
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

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column;
            }

            .main-content {
                padding: 1rem;
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
                        <i data-lucide=shopping-cart></i> Products
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
                <h2>Add New Product</h2>
                <div class="user-info">
                    <span>Admin Panel</span>
                    <div class="avatar">A</div>
                </div>
            </div>

            <div class="breadcrumb">
                <a href="./index.php">Products</a>
                <span>></span>
                <span>Add Product</span>
            </div>

            <div class="form-container">
                <div class="form-header">
                    <h3 class="form-title">Product Information</h3>
                    <p class="form-subtitle">Fill in the details below to add a new product to your inventory</p>
                </div>

                <form id="addProductForm" method="POST" enctype="multipart/form-data">
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label required" for="productName">Product Name</label>
                            <input type="text" class="form-input" id="productName" name="product_name" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label required" for="productCategory">Category</label>
                            <select class="form-select" id="productCategory" name="category" required>
                                <option value="">Select Category</option>
                                <option value="office">Office Supplies</option>
                                <option value="school">School Supplies</option>
                                <option value="sanitary">Sanitary Supplies</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label required" for="productPrice">Price (₱)</label>
                            <input type="number" class="form-input" id="productPrice" name="price" min="0" step="0.01" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label required" for="productStock">Stock Quantity</label>
                            <input type="number" class="form-input" id="productStock" name="stock" min="0" required>
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label required" for="productDescription">Description</label>
                            <textarea class="form-textarea" id="productDescription" name="description" required placeholder="Enter a detailed description of the product..."></textarea>
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label" for="productImage">Product Image</label>
                            <div class="file-upload-container" id="fileUploadContainer">
                                <input type="file" class="file-upload-input" id="productImage" name="product_image" accept="image/*">
                                <div class="file-upload-content">
                                    <p class="file-upload-label">Click to upload or drag and drop</p>
                                    <p class="file-upload-text">PNG, JPG, JPEG up to 5MB</p>
                                </div>
                            </div>
                            <img id="imagePreview" class="image-preview" style="display: none;">
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="./index.php" class="btn btn-outline">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <span data-lucide="file-plus-2"></span>
                            Add Product
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <!-- Alert Container -->
    <div class="alert" id="alertContainer"></div>

    <script>
        lucide.createIcons();
        // File upload functionality
        const fileInput = document.getElementById('productImage');
        const fileUploadContainer = document.getElementById('fileUploadContainer');
        const imagePreview = document.getElementById('imagePreview');

        // Handle file input change
        fileInput.addEventListener('change', function(e) {
            handleFileSelect(e.target.files[0]);
        });

        // Handle drag and drop
        fileUploadContainer.addEventListener('dragover', function(e) {
            e.preventDefault();
            fileUploadContainer.classList.add('dragover');
        });

        fileUploadContainer.addEventListener('dragleave', function(e) {
            e.preventDefault();
            fileUploadContainer.classList.remove('dragover');
        });

        fileUploadContainer.addEventListener('drop', function(e) {
            e.preventDefault();
            fileUploadContainer.classList.remove('dragover');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                handleFileSelect(files[0]);
            }
        });

        function handleFileSelect(file) {
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        }

        // Form submission
        document.getElementById('addProductForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Get form data
            const formData = new FormData(this);

            // Simulate form submission (replace with actual AJAX call)
            showAlert('Product added successfully!', 'success');

            // Reset form after success
            setTimeout(() => {
                window.location.href = './index.php';
            }, 1500);
        });

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
