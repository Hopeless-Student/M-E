<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Your Items</title>
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

        .header-title p {
            color: #6b7280;
            margin-top: 0.25rem;
        }

        .nav-buttons {
            display: flex;
            gap: 1rem;
        }

        .nav-btn {
            background: #2563eb;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .nav-btn:hover {
            background: #1d4ed8;
        }

        .nav-btn.secondary {
            background: white;
            color: #2563eb;
            border: 2px solid #2563eb;
        }

        .nav-btn.secondary:hover {
            background: #eff6ff;
        }

        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 3rem 2rem;
        }

        .cart-container {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .cart-header {
            background: #f8fafc;
            padding: 2rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .cart-header h2 {
            font-size: 1.5rem;
            font-weight: bold;
            color: #111827;
            margin-bottom: 0.5rem;
        }

        .cart-header p {
            color: #6b7280;
        }

        .cart-items {
            padding: 0;
        }

        .cart-item {
            display: flex;
            gap: 1rem;
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #e5e7eb;
            align-items: center;
            transition: background 0.2s;
        }

        .cart-item:hover {
            background: #f9fafb;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item-icon {
            min-width: 60px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cart-item-icon img {
            width: 60px;
            height: 60px;
            object-fit: contain;
        }

        .cart-item-details {
            flex: 1;
        }

        .cart-item-title {
            font-weight: 600;
            font-size: 1.125rem;
            color: #111827;
            margin-bottom: 0.25rem;
        }

        .cart-item-category {
            color: #6b7280;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }

        .cart-item-price {
            color: #2563eb;
            font-size: 1.25rem;
            font-weight: bold;
        }

        .cart-item-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: #f3f4f6;
            border-radius: 0.5rem;
            padding: 0.25rem;
        }

        .qty-btn {
            background: white;
            border: 1px solid #d1d5db;
            width: 32px;
            height: 32px;
            border-radius: 0.25rem;
            cursor: pointer;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .qty-btn:hover {
            background: #e5e7eb;
            border-color: #9ca3af;
        }

        .qty-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .quantity {
            font-weight: 600;
            min-width: 24px;
            text-align: center;
            font-size: 1rem;
        }

        .remove-btn {
            background: #fee2e2;
            color: #dc2626;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            cursor: pointer;
            font-size: 0.875rem;
            font-weight: 600;
            transition: background 0.2s;
        }

        .remove-btn:hover {
            background: #fecaca;
        }

        .cart-empty {
            text-align: center;
            padding: 4rem 2rem;
            color: #6b7280;
        }

        .cart-empty-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .cart-empty h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: #111827;
        }

        .cart-empty p {
            margin-bottom: 2rem;
        }

        .cart-total {
            background: #f8fafc;
            padding: 2rem;
            border-top: 2px solid #e5e7eb;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            font-size: 1.5rem;
            font-weight: bold;
            color: #111827;
            margin-bottom: 1.5rem;
        }

        .checkout-actions {
            display: flex;
            gap: 1rem;
        }

        .checkout-btn {
            flex: 1;
            background: #16a34a;
            color: white;
            border: none;
            padding: 1rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.2s;
        }

        .checkout-btn:hover {
            background: #15803d;
        }

        .checkout-btn:disabled {
            background: #9ca3af;
            cursor: not-allowed;
        }

        .clear-cart-btn {
            background: #ef4444;
            color: white;
            border: none;
            padding: 1rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .clear-cart-btn:hover {
            background: #dc2626;
        }

        .clear-cart-btn:disabled {
            background: #9ca3af;
            cursor: not-allowed;
        }

        /* Toast Notification */
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

        .toast.error {
            background: #ef4444;
        }

        .toast.warning {
            background: #f59e0b;
        }

        /* Loading State */
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

        /* Responsive Design */
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
                padding: 1rem;
            }

            .header-title h1 {
                font-size: 1.5rem;
            }

            .nav-buttons {
                flex-direction: column;
                width: 100%;
            }

            .nav-btn {
                width: 100%;
                text-align: center;
            }

            .container {
                padding: 2rem 1rem;
            }

            .cart-item {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
                padding: 1.5rem 1rem;
            }

            .cart-item-actions {
                justify-content: center;
                flex-wrap: wrap;
            }

            .checkout-actions {
                flex-direction: column;
            }

            .toast {
                left: 1rem;
                right: 1rem;
                bottom: 1rem;
            }
        }

        @media (max-width: 480px) {
            .cart-item-icon {
                font-size: 2.5rem;
            }

            .cart-item-title {
                font-size: 1rem;
            }

            .cart-item-price {
                font-size: 1.125rem;
            }

            .total-row {
                font-size: 1.25rem;
            }
        }
        .navbar { display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 2rem; background: #ffffff; border-bottom: 1px solid #e5e7eb; }
        .navbar .logo img { height: 48px; }
        .navbar .nav-links a { margin-left: 1rem; text-decoration: none; color: #111827; font-weight: 600; }
        .navbar .nav-links a:hover { color: #2563eb; }
    </style>
</head>
<body>
    <?php if (file_exists(__DIR__ . '/../includes/navbar.php')) { include __DIR__ . '/../includes/navbar.php'; } ?>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
            <div class="header-title">
                <h1>Shopping Cart</h1>
                <p>Review your items and proceed to checkout</p>
            </div>
            <div class="nav-buttons">
                <a href="products.php" class="nav-btn secondary">←</a>
                <a href="checkout.php" class="nav-btn" id="checkoutBtn" style="display: none;">Proceed to Checkout</a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container">
        <div class="cart-container">
            <div class="cart-header">
                <h2>Your Cart Items</h2>
                <p id="cartSummary">Loading your cart...</p>
            </div>
            
            <div class="cart-items" id="cartItems">
                <div class="loading">
                    <div class="loading-spinner"></div>
                    <span>Loading cart...</span>
                </div>
            </div>
            
            <div class="cart-total" id="cartTotal" style="display: none;">
                <div class="total-row">
                    <span>Total:</span>
                    <span id="totalPrice">$0</span>
                </div>
                <div class="checkout-actions">
                    <button class="checkout-btn" onclick="proceedToCheckout()" id="checkoutButton">Proceed to Checkout</button>
                    <button class="clear-cart-btn" onclick="clearCart()" id="clearButton">Clear Cart</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="toast" id="toast"></div>

    <script src="../assets/js/products-data.js"></script>
    <script>
        // Cart data persisted in localStorage
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        // Shared dataset from products page
        const products = window.ALL_PRODUCTS || [];

        function updateCart() {
            const cartItems = document.getElementById('cartItems');
            const cartTotal = document.getElementById('cartTotal');
            const totalPrice = document.getElementById('totalPrice');
            const cartSummary = document.getElementById('cartSummary');
            const checkoutBtn = document.getElementById('checkoutBtn');
            const checkoutButton = document.getElementById('checkoutButton');
            const clearButton = document.getElementById('clearButton');

            // Save cart to localStorage
            localStorage.setItem('cart', JSON.stringify(cart));

            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);

            // Update cart summary
            if (totalItems === 0) {
                cartSummary.textContent = 'Your cart is empty';
            } else if (totalItems === 1) {
                cartSummary.textContent = '1 item in your cart';
            } else {
                cartSummary.textContent = `${totalItems} items in your cart`;
            }

            if (cart.length === 0) {
                cartItems.innerHTML = `
                    <div class="cart-empty">
                        <div class="cart-empty-icon">🛒</div>
                        <h3>Your cart is empty</h3>
                        <p>Add some products to get started!</p>
                        <a href="products.php" class="nav-btn">Browse Products</a>
                    </div>
                `;
                cartTotal.style.display = 'none';
                checkoutBtn.style.display = 'none';
            } else {
                cartItems.innerHTML = cart.map(item => {
                    const product = products.find(p => p.id === item.id);
                    if (!product) return '';

                    return `
                        <div class="cart-item">
                            <div class="cart-item-icon"><img src="${product.image || '../assets/images/scotch-tape-roll.png'}" alt="Item"></div>
                            <div class="cart-item-details">
                                <div class="cart-item-title">${product.title}</div>
                                <div class="cart-item-category">${product.category}</div>
                                <div class="cart-item-price">$${product.price}</div>
                            </div>
                            <div class="cart-item-actions">
                                <div class="quantity-controls">
                                    <button class="qty-btn" onclick="updateQuantity(${item.id}, -1)" ${item.quantity <= 1 ? 'disabled' : ''}>-</button>
                                    <span class="quantity">${item.quantity}</span>
                                    <button class="qty-btn" onclick="updateQuantity(${item.id}, 1)">+</button>
                                </div>
                                <button class="remove-btn" onclick="removeFromCart(${item.id})">Remove</button>
                            </div>
                        </div>
                    `;
                }).join('');

                totalPrice.textContent = `$${total.toFixed(2)}`;
                cartTotal.style.display = 'block';
                checkoutBtn.style.display = 'inline-block';
            }

            // Enable/disable buttons
            const hasItems = cart.length > 0;
            checkoutButton.disabled = !hasItems;
            clearButton.disabled = !hasItems;
        }

        function updateQuantity(productId, delta) {
            const item = cart.find(item => item.id === productId);
            if (item) {
                item.quantity += delta;
                if (item.quantity <= 0) {
                    removeFromCart(productId);
                } else {
                    updateCart();
                    showToast(`Quantity updated`, 'success');
                }
            }
        }

        function removeFromCart(productId) {
            const product = products.find(p => p.id === productId);
            cart = cart.filter(item => item.id !== productId);
            updateCart();
            showToast(`${product ? product.title : 'Item'} removed from cart`, 'success');
        }

        function clearCart() {
            if (cart.length === 0) return;

            if (confirm('Are you sure you want to clear your cart? This action cannot be undone.')) {
                cart = [];
                updateCart();
                showToast('Cart cleared', 'success');
            }
        }

        function proceedToCheckout() {
            if (cart.length === 0) {
                showToast('Your cart is empty!', 'error');
                return;
            }

            // In a real app, this would redirect to a checkout page
            const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            showToast(`Redirecting to checkout... Total: $${total.toFixed(2)}`, 'success');
            
            // Simulate redirect
            setTimeout(() => {
                window.location.href = 'checkout.php';
            }, 1500);
        }

        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            toast.textContent = message;
            toast.className = `toast ${type}`;
            toast.classList.add('show');

            setTimeout(() => {
                toast.classList.remove('show');
            }, 3000);
        }

        // Initialize cart on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Simulate loading delay for better UX
            setTimeout(() => {
                updateCart();
            }, 500);
        });

        // Handle browser back/forward navigation
        window.addEventListener('popstate', function() {
            updateCart();
        });
    </script>
</body>
</html>
