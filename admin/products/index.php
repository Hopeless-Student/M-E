<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - M & E Dashboard</title>
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
        .product-image-container {
            height: 200px;
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .product-image-container img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 10px;
        }

        img {

          width: 200px;
          height: 200px;
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
        }

        .search-filter {
            display: flex;
            gap: 1rem;
            align-items: center;
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

        .add-product-btn {
            padding: 0.75rem 1.5rem;
            background-color: #1e40af;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: background-color 0.2s ease;
        }

        .add-product-btn:hover {
            background-color: #1e3a8a;
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
        }

        .product-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .product-image {
            height: 200px;
            background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: #1e40af;
            position: relative;
        }

        .product-info {
            padding: 1.5rem;
        }

        .product-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 0.5rem;
        }

        .product-description {
            color: #64748b;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            line-height: 1.5;
        }

        .product-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
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

        .category-badge {
            padding: 0.25rem 0.5rem;
            background-color: #e0e7ff;
            color: #1e40af;
            border-radius: 6px;
            font-size: 0.8rem;
            margin-bottom: 1rem;
            display: inline-block;
        }

        .product-actions {
            display: flex;
            gap: 0.5rem;
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

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .modal-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1e40af;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #64748b;
        }

        .close-btn:hover {
            color: #dc2626;
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

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 0.9rem;
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

        .form-select {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: white;
            font-size: 0.9rem;
        }

        .modal-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 2rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background-color: #1e40af;
            color: white;
        }

        .btn-primary:hover {
            background-color: #1e3a8a;
        }

        .btn-secondary {
            background-color: #64748b;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #475569;
        }

        .btn-danger {
            background-color: #dc2626;
            color: white;
        }

        .btn-danger:hover {
            background-color: #b91c1c;
        }

        /* Success/Error Messages */
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

        .no-products {
            text-align: center;
            padding: 4rem 2rem;
            color: #64748b;
        }

        .no-products h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
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

            .modal-content {
                width: 95%;
                margin: 1rem;
            }
        }
    </style>
</head>
<body>
  <div class="dashboard">

      <nav class="sidebar">
          <div class="logo">
              <img src="M-E_logo.png" alt="">
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
                      <i>🛍️</i> Products
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
                  <a href="../requests/index.php/" class="nav-link">
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
            <div class="header">
                <h2>Products Management</h2>
                <div class="user-info">
                    <span>Admin Panel</span>
                    <div class="avatar">A</div>
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
                <button class="add-product-btn" onclick="openModal('add')">+ Add New Product</button>
            </div>

            <!-- Products Grid -->
            <div class="products-grid" id="productsGrid">
                <!-- Products will be loaded here dynamically -->
            </div>

            <!-- No Products Message -->
            <div class="no-products" id="noProducts" style="display: none;">
                <h3>No products found</h3>
                <p>Try adjusting your search or filter criteria</p>
            </div>
        </main>
    </div>

    <!-- Product Modal -->
    <div class="modal" id="productModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="modalTitle">Add New Product</h2>
                <button class="close-btn" onclick="closeModal()">&times;</button>
            </div>
            <form id="productForm">
                <div class="form-group">
                    <label class="form-label" for="productName">Product Name</label>
                    <input type="text" class="form-input" id="productName" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="productDescription">Description</label>
                    <textarea class="form-textarea" id="productDescription" required></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label" for="productCategory">Category</label>
                    <select class="form-select" id="productCategory" required>
                        <option value="">Select Category</option>
                        <option value="office">Office Supplies</option>
                        <option value="school">School Supplies</option>
                        <option value="sanitary">Sanitary Supplies</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="productPrice">Price (₱)</label>
                    <input type="number" class="form-input" id="productPrice" min="0" step="0.01" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="productStock">Stock Quantity</label>
                    <input type="number" class="form-input" id="productStock" min="0" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="productIcon">Icon (Emoji)</label>
                    <input type="text" class="form-input" id="productIcon" placeholder="📝" maxlength="2">
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveBtn">Save Product</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal" id="deleteModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Confirm Deletion</h2>
                <button class="close-btn" onclick="closeDeleteModal()">&times;</button>
            </div>
            <p>Are you sure you want to delete this product? This action cannot be undone.</p>
            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="confirmDelete()">Delete Product</button>
            </div>
        </div>
    </div>

    <!-- Alert Container -->
    <div class="alert" id="alertContainer"></div>

    <script>
        let products = [
            {
              id: 1,
                name: "Ballpoint Pens (Pack of 12)",
                description: "High-quality ballpoint pens with smooth ink flow. Perfect for office and professional use.",
                category: "office",
                price: 180,
                stock: 150,
                image: "./images./ballpointpen.png"  // Add image path here
            },
            {
                id: 2,
                name: "Bond Paper (1 Ream)",
                description: "Premium white bond paper, 80gsm, 500 sheets per ream. Ideal for printing and copying.",
                category: "office",
                price: 320,
                stock: 75,
                  image: "./images./ballpointpen.png"
            },
            {
                id: 3,
                name: "File Folders (Pack of 10)",
                description: "Durable manila folders for document organization. Letter size with tab labels.",
                category: "office",
                price: 250,
                stock: 8,
                image: "./images./ballpointpen.png"
            },
            {
                id: 4,
                name: "Spiral Notebooks (Pack of 5)",
                description: "100-page ruled notebooks with durable spiral binding. Perfect for students.",
                category: "school",
                price: 125,
                stock: 200,
                image: "./images./ballpointpen.png"
            },
            {
                id: 5,
                name: "No. 2 Pencils (Pack of 24)",
                description: "Standard #2 pencils with erasers. Ideal for tests, homework, and daily writing.",
                category: "school",
                price: 95,
                stock: 120,
                image: "./images./ballpointpen.png"
            },
            {
                id: 6,
                name: "Hand Sanitizer (500ml)",
                description: "70% alcohol-based hand sanitizer with moisturizers. Kills 99.9% of germs.",
                category: "sanitary",
                price: 145,
                stock: 90,
                  image: "./images./ballpointpen.png"
            }
        ];

        let currentEditId = null;
        let deleteProductId = null;

        // Category mappings
        const categoryLabels = {
            'office': 'Office Supplies',
            'school': 'School Supplies',
            'sanitary': 'Sanitary Supplies'
        };

        // Initialize the app
        document.addEventListener('DOMContentLoaded', function() {
            renderProducts();
            setupEventListeners();
        });

        function setupEventListeners() {
            // Search functionality
            document.getElementById('searchInput').addEventListener('input', filterProducts);
            document.getElementById('categoryFilter').addEventListener('change', filterProducts);
            document.getElementById('stockFilter').addEventListener('change', filterProducts);

            // Form submission
            document.getElementById('productForm').addEventListener('submit', handleFormSubmit);

            // Close modal on backdrop click
            document.getElementById('productModal').addEventListener('click', function(e) {
                if (e.target === this) closeModal();
            });

            document.getElementById('deleteModal').addEventListener('click', function(e) {
                if (e.target === this) closeDeleteModal();
            });
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
                            <img src="${product.image || 'placeholder.png'}" alt="${product.name}">
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
                                <button class="action-btn primary" onclick="editProduct(${product.id})">Edit</button>
                                <button class="action-btn" onclick="viewProduct(${product.id})">View</button>
                                <button class="action-btn danger" onclick="deleteProduct(${product.id})">Delete</button>
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

        function openModal(mode, productId = null) {
            const modal = document.getElementById('productModal');
            const modalTitle = document.getElementById('modalTitle');
            const saveBtn = document.getElementById('saveBtn');

            currentEditId = productId;

            if (mode === 'add') {
                modalTitle.textContent = 'Add New Product';
                saveBtn.textContent = 'Add Product';
                resetForm();
            } else if (mode === 'edit') {
                modalTitle.textContent = 'Edit Product';
                saveBtn.textContent = 'Update Product';
                loadProductData(productId);
            }

            modal.classList.add('show');
        }

        function closeModal() {
            document.getElementById('productModal').classList.remove('show');
            resetForm();
            currentEditId = null;
        }

        function resetForm() {
            document.getElementById('productForm').reset();
        }

        function loadProductData(productId) {
            const product = products.find(p => p.id === productId);
            if (product) {
                document.getElementById('productName').value = product.name;
                document.getElementById('productDescription').value = product.description;
                document.getElementById('productCategory').value = product.category;
                document.getElementById('productPrice').value = product.price;
                document.getElementById('productStock').value = product.stock;
                document.getElementById('productIcon').value = product.icon;
            }
        }

        function handleFormSubmit(e) {
            e.preventDefault();

            const formData = {
                name: document.getElementById('productName').value,
                description: document.getElementById('productDescription').value,
                category: document.getElementById('productCategory').value,
                price: parseFloat(document.getElementById('productPrice').value),
                stock: parseInt(document.getElementById('productStock').value),
                icon: document.getElementById('productIcon').value || '📦'
            };

            if (currentEditId) {
                updateProduct(currentEditId, formData);
            } else {
                addProduct(formData);
            }
        }

        function addProduct(productData) {
            const newId = Math.max(...products.map(p => p.id)) + 1;
            const newProduct = { id: newId, ...productData };

            products.push(newProduct);
            renderProducts();
            closeModal();
            showAlert('Product added successfully!', 'success');
        }

        function updateProduct(id, productData) {
            const index = products.findIndex(p => p.id === id);
            if (index !== -1) {
                products[index] = { id, ...productData };
                renderProducts();
                closeModal();
                showAlert('Product updated successfully!', 'success');
            }
        }

        function editProduct(id) {
            openModal('edit', id);
        }

        function viewProduct(id) {
            const product = products.find(p => p.id === id);
            if (product) {
                alert(`Product Details:
Name: ${product.name}
Description: ${product.description}
Category: ${categoryLabels[product.category]}
Price: ₱${product.price}
Stock: ${product.stock}
Icon: ${product.icon}`);
            }
        }

        function deleteProduct(id) {
            deleteProductId = id;
            document.getElementById('deleteModal').classList.add('show');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('show');
            deleteProductId = null;
        }

        function confirmDelete() {
            if (deleteProductId) {
                products = products.filter(p => p.id !== deleteProductId);
                renderProducts();
                closeDeleteModal();
                showAlert('Product deleted successfully!', 'success');
            }
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
