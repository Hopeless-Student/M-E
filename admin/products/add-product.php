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

        /* Main Content */
        .main-content {
          flex: 1;
          margin-left: 230px !important;
          padding: 1.5rem;
          min-height: 100vh;
          transition: margin-left 0.3s ease;
          width: calc(100vw - 230px);
          max-width: calc(100vw - 230px);
          box-sizing: border-box;
          position: relative;
          overflow-x: hidden;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            background: none;
            padding: 1.25rem 0rem;
            border-radius: 12px;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .header h2 {
            padding-left: 0.3rem;
            font-size: 1.75rem;
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
            padding-right: 0.3rem;
            gap: 0.75rem;
            font-size: 1rem;
            font-weight: 500;
            color: #475569;
        }

        .avatar {
            width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1rem;
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
    <?php
    // require_once __DIR__ . '/../../includes/auth.php'; // Uncomment to enable authentication
    ?>
    <div class="dashboard">
        <!-- Sidebar -->
        <?php include '../../includes/admin_sidebar.php' ?>

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
                            <input type="text" class="form-input" id="productName" name="product_name" maxlength="255" required>
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

                        <div class="form-group">
                            <label class="form-label required" for="productCode">Product Code</label>
                            <input type="text" class="form-input" id="productCode" name="product_code" placeholder="e.g BP-BLK01" maxlength="100" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label required" for="productUnit">Unit</label>
                            <select class="form-select" id="productUnit" name="unit" required>
                                <option value="">Select Unit</option>
                                <option value="box">Box</option>
                                <option value="pieces">Pieces</option>
                                <option value="reams">Reams</option>
                                <option value="rolls">Rolls</option>
                                <option value="gallon">Gallon</option>
                                <option value="pack">Pack</option>
                                <option value="pads">Pads</option>
                            </select>
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label required" for="productDescription">Description</label>
                            <textarea class="form-textarea" id="productDescription" name="description" maxlength="1000" required placeholder="Enter a detailed description of the product..."></textarea>
                        </div>

                        <div class="form-group full-width">
                            <label class="form-label" for="productImage">Product Image</label>
                            <div class="file-upload-container" id="fileUploadContainer">
                                <input type="file" class="file-upload-input" id="productImage" name="product_image" accept="image/*">
                                <div class="file-upload-content">
                                    <p class="file-upload-label">Click to upload or drag and drop</p>
                                    <p class="file-upload-text">PNG, JPG, JPEG, WebP up to 5MB</p>
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

        fileInput.addEventListener('change', function(e) {
            handleFileSelect(e.target.files[0]);
        });

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
                // Check file size (5MB)
                if (file.size > 5 * 1024 * 1024) {
                    showAlert('Image too large. Maximum size is 5MB', 'error');
                    fileInput.value = '';
                    imagePreview.style.display = 'none';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        }

        // Form submission
        document.getElementById('addProductForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            try {
                const res = await fetch('../../api/admin/products/create.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await res.json();

                if (!res.ok) {
                    throw new Error(data.error || 'Failed to create product');
                }

                if (!data.success) {
                    throw new Error(data.error || 'Create failed');
                }

                showAlert('Product added successfully!', 'success');
                setTimeout(() => {
                    window.location.href = './index.php';
                }, 1200);

            } catch (err) {
                console.error(err);
                showAlert(err.message || 'Failed to add product', 'error');
            }
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
