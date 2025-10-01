<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop - Catalog</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(to bottom right, #f9fafb, #e5e7eb);
            min-height: 100vh;
        }

        .header {
            background: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-content {
            max-width: 1280px;
            margin: 0 auto;
            padding: 1.5rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-title h1 {
            font-size: 2rem;
            font-weight: bold;
            color: #111827;
        }

        .navbar { display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 2rem; background: #ffffff; border-bottom: 1px solid #e5e7eb; }
        .navbar .logo img { height: 48px; }
        .navbar .nav-links a { margin-left: 1rem; text-decoration: none; color: #111827; font-weight: 600; }
        .navbar .nav-links a:hover { color: #2563eb; }

        .header-title p {
            color: #6b7280;
            margin-top: 0.25rem;
        }

        .cart-button {
            position: relative;
            background: #2563eb;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .cart-button:hover {
            background: #1d4ed8;
        }

        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: bold;
            transition: all 0.3s ease;
            animation: bounce 0.6s ease;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }

        .toolbar {
            max-width: 1280px;
            margin: 1rem auto 1.5rem;
            padding: 0 2rem;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.75rem;
        }
        .dropdown {
            position: relative;
        }
        .drop-btn {
            padding: 0.5rem 0.875rem;
            border: 1px solid #e5e7eb;
            background: white;
            border-radius: 0.375rem;
            cursor: pointer;
            font-weight: 500;
        }
        .menu {
            position: absolute;
            top: 110%;
            left: 0;
            min-width: 180px;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            box-shadow: 0 10px 20px rgba(0,0,0,0.08);
            display: none;
            z-index: 20;
        }
        .menu.show { display: block; }
        .menu ul { list-style: none; padding: 0.5rem; }
        .menu li { padding: 0.5rem 0.5rem; cursor: pointer; border-radius: 0.375rem; }
        .menu li:hover { background: #f3f4f6; }
        .ml-auto { margin-left: auto; }
        .sort-select { padding: 0.5rem 0.875rem; border: 1px solid #e5e7eb; border-radius: 0.375rem; background: white; }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 3rem 2rem;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 1rem;
        }

        .card {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
            opacity: 0;
            animation: slideUp 0.5s ease-out forwards;
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-4px);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card:nth-child(1) { animation-delay: 0s; }
        .card:nth-child(2) { animation-delay: 0.1s; }
        .card:nth-child(3) { animation-delay: 0.2s; }
        .card:nth-child(4) { animation-delay: 0.3s; }
        .card:nth-child(5) { animation-delay: 0.4s; }
        .card:nth-child(6) { animation-delay: 0.5s; }
        .card:nth-child(7) { animation-delay: 0.6s; }
        .card:nth-child(8) { animation-delay: 0.7s; }
        .card:nth-child(9) { animation-delay: 0.8s; }

        .shine-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.3s;
            mix-blend-mode: overlay;
        }

        .card:hover .shine-overlay {
            opacity: 1;
        }

        .image-container {
            width: 100%;
            height: 16rem;
            background: linear-gradient(to bottom right, #f3f4f6, #d1d5db);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .card-content {
            padding: 1.5rem;
        }

        .category-badge {
            display: inline-block;
            background: #dbeafe;
            color: #1e40af;
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
            color: #111827;
            margin-bottom: 0.5rem;
        }

        .card-description {
            color: #6b7280;
            font-size: 0.875rem;
            margin-bottom: 1rem;
            line-height: 1.5;
        }

        .card-footer {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .price {
            font-size: 1.5rem;
            font-weight: bold;
            color: #111827;
        }

        .card-actions {
            display: flex;
            gap: 0.5rem;
        }

        .view-more-btn {
            flex: 1;
            background: white;
            color: #2563eb;
            border: 2px solid #2563eb;
            padding: 0.625rem 1rem;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .view-more-btn:hover {
            background: #eff6ff;
        }

        .add-to-cart-btn {
            flex: 1;
            background: #2563eb;
            color: white;
            border: none;
            padding: 0.625rem 1rem;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .add-to-cart-btn:hover {
            background: #1d4ed8;
        }

        .add-to-cart-btn:active {
            transform: scale(0.95);
        }

        .pagination { display: flex; gap: 0.5rem; justify-content: center; margin-top: 2rem; }
        .page-btn { border: 1px solid #e5e7eb; background: white; padding: 0.5rem 0.75rem; border-radius: 0.375rem; cursor: pointer; }
        .page-btn.active { background: #111827; color: white; border-color: #111827; }

        .toast {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            background: #10b981;
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s;
            z-index: 1001;
        }

        .toast.show {
            opacity: 1;
            transform: translateY(0);
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 1rem;
            width: 90%;
            max-width: 600px;
            max-height: 80vh;
            overflow-y: auto;
            padding: 2rem;
            position: relative;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .modal-header h2 {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #6b7280;
        }

        .close-btn:hover {
            color: #111827;
        }

        .cart-item {
            display: flex;
            gap: 1rem;
            padding: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .cart-item-icon {
            font-size: 3rem;
        }

        .cart-item-details {
            flex: 1;
        }

        .cart-item-title {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .cart-item-price {
            color: #6b7280;
            font-size: 0.875rem;
        }

        .cart-item-actions {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .qty-btn {
            background: #f3f4f6;
            border: none;
            width: 28px;
            height: 28px;
            border-radius: 0.25rem;
            cursor: pointer;
            font-weight: bold;
        }

        .qty-btn:hover {
            background: #e5e7eb;
        }

        .quantity {
            font-weight: 600;
            min-width: 24px;
            text-align: center;
        }

        .remove-btn {
            background: #fee2e2;
            color: #dc2626;
            border: none;
            padding: 0.25rem 0.75rem;
            border-radius: 0.25rem;
            cursor: pointer;
            font-size: 0.75rem;
        }

        .remove-btn:hover {
            background: #fecaca;
        }

        .cart-empty {
            text-align: center;
            padding: 3rem 1rem;
            color: #6b7280;
        }

        .cart-total {
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 2px solid #e5e7eb;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            font-size: 1.25rem;
            font-weight: bold;
        }

        .checkout-btn {
            width: 100%;
            background: #16a34a;
            color: white;
            border: none;
            padding: 1rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            margin-top: 1rem;
            transition: background 0.2s;
        }

        .checkout-btn:hover {
            background: #15803d;
        }

        .clear-cart-btn {
            width: 100%;
            background: #ef4444;
            color: white;
            border: none;
            padding: 0.75rem;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 0.5rem;
            transition: background 0.2s;
        }

        .clear-cart-btn:hover {
            background: #dc2626;
        }

        .no-results {
            text-align: center;
            padding: 4rem 2rem;
            color: #6b7280;
        }

        .no-results-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .loading {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 4rem 2rem;
            color: #6b7280;
        }

        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #e5e7eb;
            border-top: 4px solid #2563eb;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-right: 1rem;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .product-modal .modal-content {
            max-width: 800px;
        }

        .product-details {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .product-header {
            display: flex;
            gap: 2rem;
        }

        .product-icon-large {
            background: linear-gradient(to bottom right, #f3f4f6, #d1d5db);
            padding: 2rem;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-icon-large img {
            width: 200px;
            height: 200px;
            object-fit: contain;
        }

        .product-info {
            flex: 1;
        }

        .product-info h3 {
            font-size: 1.75rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .product-info .category-badge {
            margin-bottom: 1rem;
        }

        .product-price-large {
            font-size: 2rem;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 1rem;
        }

        .product-description-full {
            color: #4b5563;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .product-specs {
            background: #f9fafb;
            padding: 1.5rem;
            border-radius: 0.5rem;
        }

        .product-specs h4 {
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .spec-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 0.75rem;
        }

        .spec-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #6b7280;
            font-size: 0.875rem;
        }

        .spec-item::before {
            content: '✓';
            color: #10b981;
            font-weight: bold;
        }

        .product-actions {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .product-actions button {
            flex: 1;
            padding: 0.875rem;
            font-size: 1rem;
        }

        @media (max-width: 768px) {
            .grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .header-content {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
                padding: 1rem;
            }

            .header-title h1 {
                font-size: 1.5rem;
            }

            .toolbar { padding: 0 1rem; }
            .ml-auto { margin-left: 0; width: 100%; }
            .sort-select { width: 100%; }

            .container {
                padding: 2rem 1rem;
            }

            .product-header {
                flex-direction: column;
                gap: 1rem;
            }

            .product-icon-large {
                padding: 1rem;
            }

            .product-icon-large img {
                width: 150px;
                height: 150px;
            }

            .product-actions {
                flex-direction: column;
            }

            .card-actions {
                flex-direction: column;
                gap: 0.5rem;
            }

            .view-more-btn, .add-to-cart-btn {
                width: 100%;
            }

            .toast {
                left: 1rem;
                right: 1rem;
                bottom: 1rem;
            }

            .modal-content {
                width: 95%;
                margin: 1rem;
                max-height: 90vh;
            }

            .cart-item {
                flex-direction: column;
                gap: 0.75rem;
                text-align: center;
            }

            .cart-item-actions {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <?php if (file_exists(__DIR__ . '/../includes/navbar.php')) { include __DIR__ . '/../includes/navbar.php'; } ?>

    <header class="header">
        <div class="header-content">
            <div class="header-title">
                <h1>Shop</h1>
                <p>Home › Shop</p>
            </div>
            <a href="cart.php" class="cart-button" style="text-decoration: none;">
                🛒 View Cart
                <span class="cart-count" id="cartCount">0</span>
            </a>
        </div>
    </header>

    <div class="toolbar">
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
                    <li onclick="setFilter('price','0-5')">$0 - $5</li>
                    <li onclick="setFilter('price','5-10')">$5 - $10</li>
                    <li onclick="setFilter('price','10-20')">$10 - $20</li>
                    <li onclick="setFilter('price','20-999')">$20+</li>
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

    <div class="container">
        <div class="grid" id="productsGrid"></div>
        <div class="pagination" id="pagination"></div>
    </div>

    <div class="modal product-modal" id="productModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Product Details</h2>
                <button class="close-btn" onclick="closeProductModal()">×</button>
            </div>
            <div id="productDetails"></div>
        </div>
    </div>

    <div class="toast" id="toast"></div>

    <script>
        let products = [];
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let filters = { category: 'all', price: 'all' };
        let sortMethod = 'default';
        let currentPage = 1;
        const pageSize = 12;

        function renderProducts() {
            const grid = document.getElementById('productsGrid');

            grid.innerHTML = `
                <div class="loading">
                    <div class="loading-spinner"></div>
                    <span>Loading products...</span>
                </div>
            `;

            setTimeout(() => {
                let filteredProducts = products.slice();

                if (filters.category !== 'all') filteredProducts = filteredProducts.filter(p => p.category === filters.category);
                if (filters.price !== 'all') {
                    const [minS, maxS] = filters.price.split('-');
                    const min = parseFloat(minS);
                    const max = parseFloat(maxS);
                    filteredProducts = filteredProducts.filter(p => p.price >= min && p.price <= (isNaN(max) ? Infinity : max));
                }

                if (sortMethod === 'price-low') {
                    filteredProducts.sort((a, b) => a.price - b.price);
                } else if (sortMethod === 'price-high') {
                    filteredProducts.sort((a, b) => b.price - a.price);
                } else if (sortMethod === 'name-az') {
                    filteredProducts.sort((a, b) => a.title.localeCompare(b.title));
                } else if (sortMethod === 'name-za') {
                    filteredProducts.sort((a, b) => b.title.localeCompare(a.title));
                }

                if (filteredProducts.length === 0) {
                    grid.innerHTML = `
                        <div class="no-results">
                            <div class="no-results-icon">🔍</div>
                            <h3>No products found</h3>
                            <p>Try adjusting your search or filters</p>
                        </div>
                    `;
                    return;
                }

                const totalPages = Math.max(1, Math.ceil(filteredProducts.length / pageSize));
                if (currentPage > totalPages) currentPage = totalPages;
                const start = (currentPage - 1) * pageSize;
                const pageProducts = filteredProducts.slice(start, start + pageSize);

                grid.innerHTML = pageProducts.map(product => {
                    return `
                        <div class="card" data-category="${product.category}" onmousemove="handleMouseMove(event, this)">
                            <div class="shine-overlay"></div>
                            <div class="image-container">
                                <img src="${product.image}" alt="Product Image">
                            </div>
                            <div class="card-content">
                                <span class="category-badge">${product.category}</span>
                                <h3 class="card-title">${product.title}</h3>
                                <p class="card-description">${product.description}</p>
                                <div class="card-footer">
                                    <div class="price-row">
                                        <span class="price">$${product.price}</span>
                                    </div>
                                    <div class="card-actions">
                                        <button class="view-more-btn" onclick="viewProduct(${product.id})">View More</button>
                                        <button class="add-to-cart-btn" onclick="addToCart(${product.id})">Add to Cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                }).join('');

                const pagEl = document.getElementById('pagination');
                const pages = [];
                for (let p = 1; p <= totalPages; p++) {
                    pages.push(`<button class="page-btn ${p===currentPage?'active':''}" onclick="gotoPage(${p})">${p}</button>`);
                }
                pagEl.innerHTML = pages.join('');
            }, 300);
        }

        function viewProduct(productId) {
            const product = products.find(p => p.id === productId);

            const detailsHTML = `
                <div class="product-details">
                    <div class="product-header">
                        <div class="product-icon-large">
                            <img src="${product.image}" alt="${product.title}">
                        </div>
                        <div class="product-info">
                            <h3>${product.title}</h3>
                            <span class="category-badge">${product.category}</span>
                            <div class="product-price-large">$${product.price}</div>
                        </div>
                    </div>

                    <div class="product-description-full">
                        <h4 style="font-weight: 600; margin-bottom: 0.5rem;">About this product</h4>
                        <p>${product.description}. This premium ${product.category.toLowerCase()} product combines cutting-edge technology with elegant design to deliver an exceptional user experience. Perfect for both professionals and enthusiasts alike.</p>
                    </div>

                    <div class="product-actions">
                        <button class="add-to-cart-btn" onclick="addToCart(${productId}); closeProductModal()">
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
            shineOverlay.style.background = `radial-gradient(circle 150px at ${x}px ${y}px, rgba(255, 255, 255, 0.8), transparent 80%)`;
        }

        function handleSort() {
            sortMethod = document.getElementById('sortSelect').value;
            renderProducts();
        }

        function setFilter(key, value) {
            filters[key] = value;
            currentPage = 1;
            renderProducts();
            hideAllMenus();
        }

        function gotoPage(p) {
            currentPage = p;
            renderProducts();
            window.scrollTo({top:0, behavior:'smooth'});
        }

        function toggleMenu(id){
            const el=document.getElementById(id);
            el.classList.toggle('show');
        }

        function hideMenu(id){
            const el=document.getElementById(id);
            el.classList.remove('show');
        }

        function hideAllMenus(){
            ['catMenu','priceMenu'].forEach(hideMenu);
        }

        function showToast(message) {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.classList.add('show');

            setTimeout(() => {
                toast.classList.remove('show');
            }, 2000);
        }

        function addToCart(productId) {
            const product = products.find(p => p.id === productId);
            const existingItem = cart.find(item => item.id === productId);

            if (existingItem) {
                existingItem.quantity++;
                showToast(`${product.title} quantity increased`);
            } else {
                cart.push({ ...product, quantity: 1 });
                showToast(`${product.title} added to cart`);
            }

            updateCart();
        }

        function removeFromCart(productId) {
            const product = products.find(p => p.id === productId);
            cart = cart.filter(item => item.id !== productId);
            showToast(`${product.title} removed from cart`);
            updateCart();
        }

        function updateQuantity(productId, delta) {
            const item = cart.find(item => item.id === productId);
            if (item) {
                item.quantity += delta;
                if (item.quantity <= 0) {
                    removeFromCart(productId);
                } else {
                    updateCart();
                }
            }
        }

        function clearCart() {
            if (cart.length === 0) return;

            if (confirm('Are you sure you want to clear your cart?')) {
                cart = [];
                updateCart();
                showToast('Cart cleared');
            }
        }

        function updateCart() {
            const cartCount = document.getElementById('cartCount');
            localStorage.setItem('cart', JSON.stringify(cart));

            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            cartCount.textContent = totalItems;
        }

        document.getElementById('productModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeProductModal();
            }
        });

        function fetchProducts() {
            const params = new URLSearchParams();
            params.set('page', currentPage);
            params.set('pageSize', pageSize);
            params.set('sort', sortMethod);
            if (filters.category !== 'all') {
                const catMap = { 'School Supplies': 'school-supplies', 'Office Supplies': 'office-supplies', 'Sanitary': 'sanitary' };
                params.set('category', catMap[filters.category] || filters.category);
            }

            return fetch('../api/products.php?' + params.toString())
                .then(r => r.json())
                .then(data => {
                    products = data.items || [];
                    renderProducts();
                })
                .catch(() => {
                    products = [];
                    renderProducts();
                });
        }

        fetchProducts();
        updateCart();
    </script>
    <?php if (file_exists(__DIR__ . '/../includes/footer.php')) { include __DIR__ . '/../includes/footer.php'; } ?>
</body>
</html>
