<?php
 require_once __DIR__ . '/../../auth/admin_auth.php';
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - M & E Dashboard</title>
    <link rel="icon" type="image/x-icon" href="../../assets/images/M&E_LOGO-semi-transparent.ico">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <link rel="stylesheet" href="../assets/css/admin/products/add.css">
</head>
<body>
    <?php
    // require_once __DIR__ . '/../../includes/auth.php'; // Uncomment to enable authentication
    ?>
    <div class="dashboard">
      <button class="mobile-menu-btn" data-sidebar-toggle="open">
          <i data-lucide="menu"></i>
      </button>

        <!-- Sidebar -->
        <?php include '../../includes/admin_sidebar.php' ?>

        <!-- Main Content -->
        <main class="main-content">
            <div class="header">
                <h2>Add New Product</h2>
                <div class="user-info">
                    <span><?= htmlspecialchars($_SESSION['admin_username'] ?? 'Admin') ?></span>
                    <div class="avatar"><?= htmlspecialchars(strtoupper(substr($_SESSION['admin_username'] ?? 'A', 0, 1))) ?></div>
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
        (function() {
    const sidebar = document.querySelector('.sidebar');
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');

    if (!sidebar || !mobileMenuBtn) return;

    let overlay = document.querySelector('.sidebar-overlay');
    if (!overlay) {
        overlay = document.createElement('div');
        overlay.className = 'sidebar-overlay';
        overlay.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            display: none;
        `;
        document.body.appendChild(overlay);
    }

    function toggleSidebar() {
        const isActive = sidebar.classList.contains('active');

        if (isActive) {
            sidebar.classList.remove('active');
            overlay.style.display = 'none';
            document.body.style.overflow = '';
            if (typeof lucide !== 'undefined') {
                mobileMenuBtn.innerHTML = '<i data-lucide="menu"></i>';
                lucide.createIcons();
            }
        } else {
            sidebar.classList.add('active');
            overlay.style.display = 'block';
            document.body.style.overflow = 'hidden';
            if (typeof lucide !== 'undefined') {
                mobileMenuBtn.innerHTML = '<i data-lucide="x"></i>';
                lucide.createIcons();
            }
        }
    }

    mobileMenuBtn.addEventListener('click', toggleSidebar);
    overlay.addEventListener('click', toggleSidebar);

    sidebar.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth <= 1024) {
                toggleSidebar();
            }
        });
    });

    window.addEventListener('resize', () => {
        if (window.innerWidth > 1024 && sidebar.classList.contains('active')) {
            toggleSidebar();
        }
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && sidebar.classList.contains('active')) {
            toggleSidebar();
        }
    });
})();
    </script>
</body>
</html>
