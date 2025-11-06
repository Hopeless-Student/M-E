<?php
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../auth/mainpage-auth.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../assets/images/M&E_LOGO-semi-transparent.ico">
    <title>Shop - Catalog</title>
    <link rel="stylesheet" href="../assets/css/navbar.css">
    <link rel="stylesheet" href="../assets/css/homepage.css">
    <link rel="stylesheet" href="../assets/css/products.css">

</head>
<body>
    <?php include '../includes/navbar.php'; ?>

    <div class="toolbar">
      <div class="search-bar">
        <div class="search-input-group">
          <input type="text" id="searchInput" placeholder="Search products..." />
        </div>
        <div class="search-btn-group">
          <button id="searchBtn">Search</button>
          <button id="clearSearchBtn" style="display:none;">Clear</button>
        </div>
        <div id="suggestionsBox" class="suggestions-box"></div>
      </div>
        <div class="dropdown" onmouseleave="hideMenu('catMenu')">
            <button class="drop-btn" onclick="toggleMenu('catMenu')">Categories ▾</button>
            <div class="menu" id="catMenu">
                <ul>
                    <li onclick="setFilter('category','all')">All</li>
                    <li onclick="setFilter('category','School Supplies')">School Supplies</li>
                    <li onclick="setFilter('category','Office Supplies')">Office Supplies</li>
                    <li onclick="setFilter('category','Sanitary')">Sanitary Supplies</li>
                </ul>
            </div>
        </div>
        <div class="dropdown" onmouseleave="hideMenu('priceMenu')">
            <button class="drop-btn" onclick="toggleMenu('priceMenu')">Price ▾</button>
            <div class="menu" id="priceMenu">
                <ul>
                    <li onclick="setFilter('price','all')">All</li>
                    <li onclick="setFilter('price','0-5')">₱0 - ₱5</li>
                    <li onclick="setFilter('price','5-10')">₱5 - ₱10</li>
                    <li onclick="setFilter('price','10-20')">₱10 - ₱20</li>
                    <li onclick="setFilter('price','20-999')">₱20+</li>
                </ul>
            </div>
        </div>
        <div class="ml-auto">
            <select class="sort-select" id="sortSelect" onchange="handleSort()">
                <option value="default">Default Sorting</option>
                <option value="price-low">Price: Low to High</option>
                <option value="price-high">Price: High to Low</option>
                <option value="name-az">Name: A-Z</option>
                <option value="name-za">Name: Z-A</option>
            </select>
        </div>
    </div>

    <?php if (!empty($_GET['q'])): ?>
        <div class="search-result-banner">
            Showing results for "<strong><?= htmlspecialchars($_GET['q']) ?></strong>"
        </div>
    <?php endif; ?>

    <div class="container">
        <div class="grid" id="productsGrid"></div>
        <div class="pagination" id="pagination"></div>
    </div>

    <div class="modal product-modal" id="productModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Product Details</h2>
                <button class="close-btn-pr" onclick="closeProductModal()">×</button>
            </div>
            <div id="productDetails"></div>
        </div>
    </div>

    <?php include '../includes/login-modal.php';?>
    <div class="toast" id="toast"></div>

    <script src="../assets/js/search-suggestions.js" defer></script>
    <script>
        let products = [];
        let filters = { category: 'all', price: 'all' };
        let sortMethod = 'default';
        let currentPage = 1;
        let totalPages = 1;
        const pageSize = 12;

        const urlParams = new URLSearchParams(window.location.search);
        const searchQuery = urlParams.get('q') || '';

        function renderProducts() {
            const grid = document.getElementById('productsGrid');
            const pagEl = document.getElementById('pagination');

            if (!products.length) {
                grid.innerHTML = `
                    <div class="no-results">
                        <div class="no-results-icon">🔍</div>
                        <h3>No products found</h3>
                        ${searchQuery ? `<p>No matches for "${searchQuery}"</p>` : `<p>Try adjusting your filters</p>`}
                    </div>
                `;
                pagEl.innerHTML = '';
                return;
            }

            grid.innerHTML = products.map(product => `
                <div class="card" data-category="${product.category}" onmousemove="handleMouseMove(event, this)">
                    <div class="shine-overlay"></div>
                    <div class="image-container">
                        <img loading="lazy" src="${product.image}" alt="${product.title}" onerror="this.src='../assets/images/default.png';">
                    </div>
                    <div class="card-content">
                        <span class="category-badge">${product.category}</span>
                        <h3 class="card-title">${product.title}</h3>
                        <p class="card-description">${product.description}</p>
                        <div class="card-footer">
                            <div class="price-row">
                                <span class="price">₱${product.price} / ${product.unit}</span>
                            </div>
                            <div class="card-actions">
                                <button class="view-more-btn" onclick="viewProduct(${product.id})">View More</button>
                                <button class="add-to-cart-btn" onclick="addToCart(${product.id})">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
            `).join('');

            renderPagination();
        }

        function renderPagination() {
            const pagEl = document.getElementById('pagination');

            if (totalPages <= 1) {
                pagEl.innerHTML = '';
                return;
            }

            let pages = [];
            const maxVisible = 5;
            let startPage = Math.max(1, currentPage - Math.floor(maxVisible / 2));
            let endPage = Math.min(totalPages, startPage + maxVisible - 1);

            if (endPage - startPage < maxVisible - 1) {
                startPage = Math.max(1, endPage - maxVisible + 1);
            }

            for (let p = startPage; p <= endPage; p++) {
                pages.push(`
                    <button class="page-btn ${p === currentPage ? 'active' : ''}" onclick="gotoPage(${p})">${p}</button>
                `);
            }

            pagEl.innerHTML = `
                <button class="page-btn" ${currentPage === 1 ? 'disabled' : ''} onclick="gotoPage(${currentPage - 1})">« Prev</button>
                ${startPage > 1 ? `<button class="page-btn" onclick="gotoPage(1)">1</button>` : ''}
                ${startPage > 2 ? `<span class="page-ellipsis">...</span>` : ''}
                ${pages.join('')}
                ${endPage < totalPages - 1 ? `<span class="page-ellipsis">...</span>` : ''}
                ${endPage < totalPages ? `<button class="page-btn" onclick="gotoPage(${totalPages})">${totalPages}</button>` : ''}
                <button class="page-btn" ${currentPage === totalPages ? 'disabled' : ''} onclick="gotoPage(${currentPage + 1})">Next »</button>
            `;
        }

        function viewProduct(product_id) {
            const product = products.find(p => p.id === product_id);
            if (!product) return;

            const detailsHTML = `
                <div class="product-details">
                    <div class="product-header">
                        <div class="product-icon-large">
                            <img loading="lazy" src="${product.image}" alt="${product.title}" onerror="this.src='../assets/images/default.png';">
                        </div>
                        <div class="product-info">
                            <h3>${product.title}</h3>
                            <span class="category-badge">${product.category}</span>
                            <div class="product-price-large">₱${product.price} / ${product.unit}</div>
                        </div>
                    </div>

                    <div class="product-description-full">
                        <h4 style="font-weight: 600; margin-bottom: 0.5rem;">About this product</h4>
                        <p>${product.description}. This premium ${product.category.toLowerCase()} product combines cutting-edge technology with elegant design to deliver an exceptional user experience. Perfect for both professionals and enthusiasts alike.</p>
                    </div>

                    <div class="product-actions">
                        <button class="add-to-cart-btn" onclick="addToCart(${product.id}); closeProductModal()">
                            Add to Cart
                        </button>
                    </div>
                </div>
            `;

            document.getElementById('productDetails').innerHTML = detailsHTML;
            document.getElementById('productModal').classList.add('active');
        }

        function closeProductModal() {
            document.getElementById('productModal').classList.remove('active');
        }

        function handleMouseMove(e, card) {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            const shineOverlay = card.querySelector('.shine-overlay');
            if (shineOverlay) {
                shineOverlay.style.background = `radial-gradient(circle 150px at ${x}px ${y}px, rgba(255, 255, 255, 0.8), transparent 80%)`;
            }
        }

        function handleSort() {
            sortMethod = document.getElementById('sortSelect').value;
            currentPage = 1;
            fetchProducts();
        }

        function setFilter(key, value) {
            filters[key] = value;
            currentPage = 1;
            fetchProducts();
            hideAllMenus();
        }

        function gotoPage(p) {
            if (p < 1 || p > totalPages) return;
            currentPage = p;
            fetchProducts();
            window.scrollTo({top: 0, behavior: 'smooth'});
        }

        function toggleMenu(id) {
            const el = document.getElementById(id);
            if (el) el.classList.toggle('show');
        }

        function hideMenu(id) {
            const el = document.getElementById(id);
            if (el) el.classList.remove('show');
        }

        function hideAllMenus() {
            ['catMenu', 'priceMenu'].forEach(hideMenu);
        }

        function showToast(message) {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.classList.add('show');

            setTimeout(() => {
                toast.classList.remove('show');
            }, 2000);
        }

        if (searchQuery) {
            document.getElementById('searchInput').value = searchQuery;
            document.getElementById('clearSearchBtn').style.display = 'inline-block';
        }

        document.getElementById('searchInput').addEventListener('keyup', (e) => {
            if (e.key === 'Enter') document.getElementById('searchBtn').click();
        });

        document.getElementById('searchBtn').addEventListener('click', () => {
            const query = document.getElementById('searchInput').value.trim();
            if (query) {
                window.location.href = `products.php?q=${encodeURIComponent(query)}`;
            }
        });

        document.getElementById('clearSearchBtn').addEventListener('click', () => {
            window.location.href = 'products.php';
        });

        function addToCart(product_id, quantity = 1) {
            const product = products.find(p => p.id === product_id);

            fetch('../ajax/add-to-cart.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ product_id: product_id, quantity: quantity })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    showToast(`${product ? product.title : 'Item'} added to cart`);
                    fetchCart();
                } else {
                    showToast(data.message || 'Failed to add to cart');
                }
            })
            .catch(err => {
                console.error('Add to cart error:', err);
                showToast('Error adding to cart');
            });
        }

        function fetchCart() {
            fetch('../ajax/fetch-cart.php')
                .then(res => res.json())
                .then(data => {
                    const cartCount = document.getElementById('cartCount');
                    if (cartCount) {
                        cartCount.textContent = data.count || 0;
                    }
                })
                .catch(err => console.error('Fetch cart error:', err));
        }

        function removeFromCart(product_id) {
            fetch('../ajax/remove-from-cart.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ product_id })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    showToast('Item removed');
                    fetchCart();
                } else {
                    showToast(data.message || 'Failed to remove item');
                }
            })
            .catch(err => {
                console.error('Remove from cart error:', err);
                showToast('Error removing item');
            });
        }

        function updateQuantity(product_id, delta) {
            fetch('../ajax/update-cart.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ product_id, delta })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    fetchCart();
                } else {
                    showToast(data.message || 'Update failed');
                }
            })
            .catch(err => {
                console.error('Update quantity error:', err);
                showToast('Error updating quantity');
            });
        }

        function clearCart() {
            if (!confirm('Clear all items from cart?')) return;
            fetch('../ajax/clear-cart.php', { method: 'POST' })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        showToast('Cart cleared');
                        fetchCart();
                    } else {
                        showToast('Failed to clear cart');
                    }
                })
                .catch(err => {
                    console.error('Clear cart error:', err);
                    showToast('Error clearing cart');
                });
        }

        function showCartPreview() {
            fetch('../ajax/fetch-cart.php')
                .then(res => res.json())
                .then(data => {
                    const list = document.getElementById('cartPreviewList');
                    if (list && data.cart) {
                        list.innerHTML = data.cart.map(item => `
                            <div class="cart-item">
                                <img src="../${item.product_image}" width="40" alt="${item.product_name}">
                                <span>${item.product_name}</span>
                                <span>x${item.quantity}</span>
                            </div>
                        `).join('');
                    }
                })
                .catch(err => console.error('Cart preview error:', err));
        }

        document.getElementById('productModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeProductModal();
            }
        });

        function fetchProducts() {
            const grid = document.getElementById('productsGrid');
            grid.innerHTML = `
                <div class="loading">
                    <div class="loading-spinner"></div>
                    <span>Loading products...</span>
                </div>
            `;

            const params = new URLSearchParams();
            params.set('page', currentPage);
            params.set('pageSize', pageSize);
            params.set('sort', sortMethod);

            if (filters.category !== 'all') {
                const catMap = {
                    'School Supplies': 'school-supplies',
                    'Office Supplies': 'office-supplies',
                    'Sanitary': 'sanitary'
                };
                params.set('category', catMap[filters.category] || filters.category);
            }

            if (searchQuery) {
                params.set('q', searchQuery);
            }

            fetch('../api/products.php?' + params.toString())
                .then(r => {
                    if (!r.ok) throw new Error('Failed to fetch products');
                    return r.json();
                })
                .then(data => {
                    products = data.items || [];
                    totalPages = data.totalPages || 1;
                    currentPage = data.page || 1;
                    renderProducts();
                })
                .catch(err => {
                    console.error('Fetch products error:', err);
                    products = [];
                    totalPages = 1;
                    grid.innerHTML = `
                        <div class="no-results">
                            <div class="no-results-icon">⚠️</div>
                            <h3>Error loading products</h3>
                            <p>Please try again later</p>
                        </div>
                    `;
                });
        }

        fetchProducts();
        fetchCart();
    </script>

    <script src="../assets/js/homepage.js"></script>
    <script src="../assets/js/navbar.js"></script>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
