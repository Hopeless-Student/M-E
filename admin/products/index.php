<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - M & E Dashboard</title>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <link rel="stylesheet" href="../assets/css/admin/products/index.css">
</head>
<body>
    <div class="dashboard">
        <!-- Mobile Menu Button -->
        <button class="mobile-menu-btn" data-sidebar-toggle="open">
            <i data-lucide="menu"></i>
        </button>

        <!-- Sidebar -->
        <?php include '../../includes/admin_sidebar.php' ?>

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
                    <div class="stat-header">
                        <div class="stat-title">Total Products</div>
                        <i data-lucide="package" class="stat-icon"></i>
                    </div>
                    <div class="stat-value" id="totalProducts">0</div>
                    <div class="stat-change neutral">Active products</div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-title">Low Stock Items</div>
                        <i data-lucide="alert-triangle" class="stat-icon"></i>
                    </div>
                    <div class="stat-value" id="lowStockProducts">0</div>
                    <div class="stat-change neutral">Need attention</div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-title">Out of Stock</div>
                        <i data-lucide="x-circle" class="stat-icon"></i>
                    </div>
                    <div class="stat-value" id="outOfStock">0</div>
                    <div class="stat-change neutral">Items unavailable</div>
                </div>
            </div>

            <!-- Product Controls -->
            <div class="product-controls">
                <div class="search-filter">
                    <div class="search-box">
                        <i data-lucide="search" class="search-icon"></i>
                        <input type="text" placeholder="Search products..." id="searchInput">
                    </div>
                    <select class="filter-select" id="categoryFilter">
                        <option value="">All Categories</option>
                        <option value="School">School Supplies</option>
                        <option value="Office">Office Supplies</option>
                        <option value="Sanitary">Sanitary Supplies</option>
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
                        <i data-lucide="plus"></i>
                        Add Product
                    </a>
                    <a href="./mark-top-orders.php" class="btn btn-accent">
                        <i data-lucide="trending-up"></i>
                        Featured
                    </a>
                    <a href="./bulk-actions.php" class="btn btn-secondary">
                        <i data-lucide="settings"></i>
                        Bulk Actions
                    </a>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="products-grid" id="productsGrid">
                <!-- Products will be loaded here dynamically -->
            </div>

            <!-- Pagination -->
            <div class="pagination" id="paginationContainer">
                <div class="pagination-info" id="paginationInfo">
                    Showing 1-6 of 12 products
                </div>
                <div class="pagination-controls" id="paginationControls">
                    <button class="page-btn">Previous</button>
                    <button class="page-btn active">1</button>
                    <button class="page-btn">2</button>
                    <button class="page-btn">Next</button>
                </div>
            </div>

            <!-- No Products Message -->
            <div class="no-products" id="noProducts" style="display: none;">
                <i data-lucide="package-x"></i>
                <h3>No products found</h3>
                <p>Try adjusting your search or filter criteria, or <a href="./add-product.php">add your first product</a></p>
            </div>
        </main>
    </div>

    <!-- Product View Modal -->
    <div class="modal-overlay" id="productModal">
        <div class="modal">
            <div class="modal-header">
                <h2 class="modal-title">Product Details</h2>
                <button class="modal-close" onclick="closeProductModal()">
                    <i data-lucide="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="product-modal-content" id="modalContent">
                    <!-- Product details will be loaded here -->
                </div>
            </div>
            <div class="modal-footer">
                <button class="modal-btn modal-btn-secondary" onclick="closeProductModal()">Close</button>
                <button class="modal-btn modal-btn-edit" id="EditModal">Edit</button>
                <button class="modal-btn modal-btn-delete" id="modalDeleteBtn">
                    <i data-lucide="trash-2"></i> Delete Product
                </button>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="delete-modal-overlay" id="deleteModal">
        <div class="delete-modal">
            <div class="delete-modal-header">
                <div class="delete-modal-icon">
                    <i data-lucide="trash"></i>
                </div>
                <h2 class="delete-modal-title">Delete Product</h2>
                <p class="delete-modal-subtitle">Are you sure you want to delete this product?</p>
            </div>
            <div class="delete-modal-body">
                <div class="delete-product-info" id="deleteProductInfo">
                    <!-- Product info will be loaded here -->
                </div>

                <!-- Hidden warning message - shows after first delete click -->
                <div class="delete-warning" id="deleteWarning" style="display: none;">
                    <div class="delete-warning-title">
                        <i data-lucide="triangle-alert"></i> Warning
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

    <?php include 'edit-product.php'; ?>

    <script>
        lucide.createIcons();

        // Global variables
        let currentPage = 1;
        let totalPages = 1;
        let allProducts = [];
        let filteredProducts = [];
        let apiTotal = 0;
        const productsPerPage = 6;
        let deleteConfirmationStep = 0; // Track delete confirmation step
        let productToDelete = null; // Store product ID to delete

        const categoryLabels = {
            'School': 'School supplies',
            'Office': 'Office supplies',
            'Sanitary': 'Sanitary supplies'
        };

        document.addEventListener('DOMContentLoaded', function() {
            loadProductsData();
            setupEventListeners();
        });

        async function loadProductsData() {
            try {
                const q = document.getElementById('searchInput').value.trim();
                const category = document.getElementById('categoryFilter').value; // office|school|sanitary|''
                const stock = document.getElementById('stockFilter').value; // in-stock|low-stock|out-of-stock|''

                const params = new URLSearchParams({ page: String(currentPage), pageSize: String(productsPerPage) });
                if (q) params.set('q', q);
                if (category) params.set('category', category);
                if (stock) params.set('stock', stock);

                const res = await fetch(`../../api/admin/products/list.php?${params.toString()}`, { headers: { 'Accept': 'application/json' } });
                if (!res.ok) throw new Error('Failed to load products');
                const data = await res.json();

                allProducts = (data.items || []).map(p => ({
                    id: p.id,
                    name: p.name,
                    description: p.description || '',
                    category: mapCategoryToKey(p.category),
                    price: Number(p.price || 0),
                    stock: Number(p.stock || 0),
                    image: p.image || "../../assets/images/products/placeholder.png"
                }));
                filteredProducts = [...allProducts];
                apiTotal = Number(data.total || 0);
                totalPages = Number(data.totalPages || Math.max(1, Math.ceil(apiTotal / productsPerPage)));

                renderProducts();
                renderPagination();
                updateStats();
            } catch (e) {
                console.error(e);
                showAlert('Error loading products', 'error');
            }
        }

        function generateMockProducts(count) {
            const products = [
                {
                    id: 1,
                    name: "Scotch tape",
                    description: "High-quality adhesive tape for office and school use. Strong hold and easy to tear.",
                    category: "Office",
                    price: 1250,
                    stock: 150,
                    image: "../../assets/images/products/scotch-tape-roll.png"
                },
                {
                    id: 2,
                    name: "Ceramic Wall Tiles",
                    description: "Premium ceramic tiles with glossy finish. Suitable for bathrooms and kitchens.",
                    category: "School",
                    price: 850,
                    stock: 75,
                    image: "../../assets/images/products/scotch-tape-roll.png"
                },
                {
                    id: 3,
                    name: "LED Ceiling Light",
                    description: "Modern LED ceiling fixture with dimmer control. Energy efficient and long-lasting.",
                    category: "Sanitary",
                    price: 2200,
                    stock: 8,
                    image: "../../assets/images/products/scotch-tape-roll.png"
                },
                {
                    id: 4,
                    name: "Vinyl Plank Flooring",
                    description: "Waterproof vinyl planks with realistic wood texture. Easy to install and maintain.",
                    category: "Sanitary",
                    price: 980,
                    stock: 200,
                    image: "../../assets/images/products/scotch-tape-roll.png"
                },
                {
                    id: 5,
                    name: "Porcelain Floor Tiles",
                    description: "Durable porcelain tiles with anti-slip surface. Perfect for high-traffic areas.",
                    category: "Office",
                    price: 1450,
                    stock: 120,
                    image: "../../assets/images/products/scotch-tape-roll.png"
                },
                {
                    id: 6,
                    name: "Cabinet Door Handles",
                    description: "Stainless steel cabinet handles with modern design. Set of 10 pieces.",
                    category: "School",
                    price: 650,
                    stock: 0,
                    image: "../../assets/images/products/scotch-tape-roll.png"
                },
                {
                    id: 7,
                    name: "Hardwood Flooring Oak",
                    description: "Solid oak hardwood flooring with natural finish. Premium quality construction.",
                    category: "Sanitary",
                    price: 3200,
                    stock: 45,
                    image: "../../assets/images/products/scotch-tape-roll.png"
                },
                {
                    id: 8,
                    name: "Subway Tiles White",
                    description: "Classic white subway tiles for kitchen backsplash. Timeless design.",
                    category: "Office",
                    price: 420,
                    stock: 180,
                    image: "../../assets/images/products/scotch-tape-roll.png"
                },
                {
                    id: 9,
                    name: "Pendant Light Fixture",
                    description: "Industrial style pendant light with adjustable cord. Perfect for kitchens.",
                    category: "School",
                    price: 1100,
                    stock: 25,
                    image: "../../assets/images/products/scotch-tape-roll.png"
                },
                {
                    id: 10,
                    name: "Bamboo Flooring",
                    description: "Eco-friendly bamboo flooring with natural grain pattern. Sustainable choice.",
                    category: "Sanitary",
                    price: 1680,
                    stock: 12,
                    image: "../../assets/images/products/scotch-tape-roll.png"
                },
                {
                    id: 11,
                    name: "Mosaic Glass Tiles",
                    description: "Decorative glass mosaic tiles for accent walls. Various color options available.",
                    category: "Office",
                    price: 890,
                    stock: 65,
                    image: "../../assets/images/products/scotch-tape-roll.png"
                },
                {
                    id: 12,
                    name: "Wall Light Sconces",
                    description: "Modern wall sconces with LED bulbs. Perfect for hallways and bedrooms.",
                    category: "Sanitary",
                    price: 750,
                    stock: 38,
                    image: "../../assets/images/products/scotch-tape-roll.png"
                }
            ];
            return products.slice(0, count);
        }

        function setupEventListeners() {
            document.getElementById('searchInput').addEventListener('input', applyFilters);
            document.getElementById('categoryFilter').addEventListener('change', applyFilters);
            document.getElementById('stockFilter').addEventListener('change', applyFilters);

            document.getElementById('productModal').addEventListener('click', function(e) {
                if (e.target === this) closeProductModal();
            });

            document.getElementById('deleteModal').addEventListener('click', function(e) {
                if (e.target === this) closeDeleteModal();
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeProductModal();
                    closeDeleteModal();
                }
            });
        }

        function updateStats() {
            const totalProducts = allProducts.length;
            const lowStockProducts = allProducts.filter(p => p.stock > 0 && p.stock <= 15).length;
            const outOfStock = allProducts.filter(p => p.stock === 0).length;

            document.getElementById('totalProducts').textContent = totalProducts;
            document.getElementById('lowStockProducts').textContent = lowStockProducts;
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

        function renderProducts() {
            const grid = document.getElementById('productsGrid');
            const noProducts = document.getElementById('noProducts');
            const paginationContainer = document.getElementById('paginationContainer');

            const startIndex = (currentPage - 1) * productsPerPage;
            const endIndex = startIndex + productsPerPage;
            const pageProducts = filteredProducts.slice(startIndex, endIndex);

            if (pageProducts.length === 0) {
                grid.style.display = 'none';
                paginationContainer.style.display = 'none';
                noProducts.style.display = 'block';
                lucide.createIcons();
                return;
            }

            grid.style.display = 'grid';
            paginationContainer.style.display = 'flex';
            noProducts.style.display = 'none';

            grid.innerHTML = pageProducts.map(product => {
                const stockStatus = getStockStatus(product.stock);
                const stockLabel = getStockLabel(product.stock);

                return `
                    <div class="product-card">
                        <div class="product-image-container">
                            <img src="${product.image}" alt="${product.name}" onerror="this.src='./images/placeholder.png'">
                            <div class="stock-status ${stockStatus}">${stockLabel}</div>
                        </div>
                        <div class="product-info">
                            <div class="category-badge">${categoryLabels[product.category]}</div>
                            <h3 class="product-title">${product.name}</h3>
                            <p class="product-description">${product.description}</p>
                            <div class="product-details">
                                <span class="product-price">₱${product.price.toLocaleString()}</span>
                                <span class="product-stock">Stock: ${product.stock}</span>
                            </div>
                            <div class="product-actions">
                                <button class="action-btn action-btn-view" onclick="viewProduct(${product.id})" title="View Product">
                                    <i data-lucide="eye"></i>
                                </button>
                                <button class="action-btn action-btn-edit" onclick="openEditProd(${product.id})" title="Edit Product">
                                    <i data-lucide="pencil"></i>
                                </button>
                                <button class="action-btn action-btn-delete" onclick="showDeleteModal(${product.id})" title="Delete Product">
                                    <i data-lucide="trash-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');

            lucide.createIcons();
        }

        function renderPagination() {
            const paginationInfo = document.getElementById('paginationInfo');
            const paginationControls = document.getElementById('paginationControls');

            if (apiTotal === 0) {
                paginationInfo.textContent = 'Showing 0-0 of 0 products';
            } else {
                const startItem = ((currentPage - 1) * productsPerPage) + 1;
                const endItem = Math.min(currentPage * productsPerPage, apiTotal);
                paginationInfo.textContent = `Showing ${startItem}-${endItem} of ${apiTotal} products`;
            }

            let buttonsHTML = '<button class="page-btn" id="prevBtn">Previous</button>';

            for (let i = 1; i <= totalPages; i++) {
                buttonsHTML += `<button class="page-btn ${i === currentPage ? 'active' : ''}" data-page="${i}">${i}</button>`;
            }

            buttonsHTML += '<button class="page-btn" id="nextBtn">Next</button>';

            paginationControls.innerHTML = buttonsHTML;

            document.getElementById('prevBtn').onclick = () => goToPage(currentPage - 1);
            document.getElementById('nextBtn').onclick = () => goToPage(currentPage + 1);

            document.querySelectorAll('[data-page]').forEach(btn => {
                btn.onclick = () => goToPage(parseInt(btn.dataset.page));
            });
        }

        function goToPage(page) {
            if (page < 1 || page > totalPages) return;
            currentPage = page;
            loadProductsData();
        }

        function applyFilters() {
            currentPage = 1;
            loadProductsData();
        }

        function mapCategoryToKey(category) {
            const c = (category || '').toLowerCase();
            if (c.includes('office')) return 'Office';
            if (c.includes('school')) return 'School';
            if (c.includes('sanitary') || c.includes('hygiene')) return 'Sanitary';
            return 'Office';
        }

        function viewProduct(id) {
            const product = allProducts.find(p => p.id === id);
            if (!product) return;

            const stockStatus = getStockStatus(product.stock);
            const stockLabel = getStockLabel(product.stock);

            const modalContent = `
                <div class="modal-header-section">
                    <div class="modal-image-section">
                        <img src="${product.image}" alt="${product.name}" class="modal-product-image" onerror="this.src='./images/placeholder.png'">
                    </div>
                    <div class="modal-basic-info">
                        <div class="modal-category-badge">${categoryLabels[product.category]}</div>
                        <h3>${product.name}</h3>
                        <div class="modal-description">
                            <p>${product.description}</p>
                        </div>
                    </div>
                </div>
                <div class="modal-details-section">
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
                </div>
            `;

            document.getElementById('modalContent').innerHTML = modalContent;
            document.getElementById('EditModal').onclick = () => openEditProd(id);
            document.getElementById('modalDeleteBtn').onclick = () => showDeleteModal(product.id);

            openProductModal();
        }

        function showDeleteModal(productId) {
            const product = allProducts.find(p => p.id === productId);
            if (!product) return;

            // Reset delete confirmation step
            deleteConfirmationStep = 0;
            productToDelete = productId;

            const deleteProductInfo = `
                <div class="delete-product-name">${product.name}</div>
                <div class="delete-product-details">
                    <span>ID: #${String(product.id).padStart(4, '0')}</span>
                    <span>Stock: ${product.stock} units</span>
                </div>
                <div class="delete-product-details">
                    <span>Price: ₱${product.price.toLocaleString()}</span>
                    <span>Category: ${categoryLabels[product.category]}</span>
                </div>
            `;

            document.getElementById('deleteProductInfo').innerHTML = deleteProductInfo;
            document.getElementById('deleteWarning').style.display = 'none';

            const confirmBtn = document.getElementById('confirmDeleteBtn');
            confirmBtn.innerHTML = '<i data-lucide="trash-2"></i> Delete Product';

            // Remove previous event listeners by cloning the button
            const newConfirmBtn = confirmBtn.cloneNode(true);
            confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);

            newConfirmBtn.onclick = handleDeleteConfirmation;

            openDeleteModal();
            lucide.createIcons();
        }

        function handleDeleteConfirmation() {
            if (deleteConfirmationStep === 0) {
                // First click - show warning
                document.getElementById('deleteWarning').style.display = 'block';
                const confirmBtn = document.getElementById('confirmDeleteBtn');
                confirmBtn.innerHTML = '<i data-lucide="alert-triangle"></i> Confirm Delete';
                confirmBtn.classList.add('warning-state');
                deleteConfirmationStep = 1;
                lucide.createIcons();
            } else {
                // Second click - actually delete
                deleteProduct(productToDelete);
            }
        }

        async function deleteProduct(productId) {
            const product = allProducts.find(p => p.id === productId);
            if (!product) return;
            try {
                const res = await fetch('../../api/admin/products/delete.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: productId })
                });
                if (!res.ok) throw new Error('Failed to delete');
                showAlert(`Product "${product.name}" has been deleted successfully.`, 'success');
                closeDeleteModal();
                closeProductModal();
                applyFilters();
                updateStats();
            } catch (e) {
                console.error(e);
                showAlert('Failed to delete product', 'error');
            }
        }

        function openEditProd(id) {
                const product = allProducts.find(p => p.id === id);

                if (!product) {
                    alert('Product not found');
                    return;
                }

                // Close the product view modal first
                closeProductModal();

                // Populate the form fields with product data
                document.getElementById('productName').value = product.name;
                document.getElementById('productCategory').value = product.category;
                document.getElementById('productPrice').value = product.price;
                document.getElementById('productDescription').value = product.description;

                // Set current image if exists
                const currentImage = document.getElementById('currentImage');
                if (product.image) {
                    currentImage.src = product.image;
                    currentImage.style.display = 'block';
                    document.getElementById('currentImageContainer').style.display = 'block';
                } else {
                    currentImage.src = './images/placeholder.png';
                }

                // Show the edit modal
                document.getElementById('editModal').classList.add('active');
                document.body.style.overflow = 'hidden';

                // Store the product ID for later use in form submission
                document.getElementById('editProductForm').dataset.productId = id;

                const dltbtn = document.getElementById('deleteModal2');
                if(dltbtn){
                  dltbtn.onclick = () => showDeleteModal(id);
                }
                // Initialize Lucide icons after modal is shown
                setTimeout(() => {
                    lucide.createIcons();
                }, 100);
            }

            // Also add these supporting functions for the edit modal:

            function closeEditModal() {
                document.getElementById('editModal').classList.remove('active');
                document.body.style.overflow = '';

                // Reset the form
                document.getElementById('editProductForm').reset();

                // Hide image preview
                document.getElementById('imagePreview').style.display = 'none';
            }

            function closeModal(event) {
                if (event && event.target !== document.getElementById('editModal')) {
                    return;
                }
                closeEditModal();
            }

            // Add image preview functionality
            document.getElementById('productImage').addEventListener('change', function(e) {
                const file = e.target.files[0];
                const preview = document.getElementById('imagePreview');

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                } else {
                    preview.style.display = 'none';
                }
            });

            // Handle form submission
            document.getElementById('editProductForm').addEventListener('submit', async function(e) {
                e.preventDefault();
                const productId = parseInt(this.dataset.productId);
                const formData = new FormData(this);
                formData.append('id', String(productId));
                try {
                    const res = await fetch('../../api/admin/products/update.php', {
                        method: 'POST',
                        body: formData
                    });
                    if (!res.ok) throw new Error('Failed to update');
                    closeEditModal();
                    showAlert('Product updated successfully!', 'success');
                    applyFilters();
                    updateStats();
                } catch (err) {
                    console.error(err);
                    showAlert('Failed to update product', 'error');
                }
            });

            // Add ESC key support for closing modal
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeEditModal();
                }
            });


        function openDeleteModal() {
            document.getElementById('deleteModal').classList.add('active');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('active');
            deleteConfirmationStep = 0;
            productToDelete = null;
        }

        function openProductModal() {
            document.body.style.overflow = 'hidden';
            document.getElementById('productModal').classList.add('active');
            lucide.createIcons();
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
                alert.classList.add('after');
            }, 3000);
        }
    </script>
</body>
</html>
