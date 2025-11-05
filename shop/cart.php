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
    <title>Shopping Cart - Your Items</title>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="../assets/css/homepage.css">
    <link rel="stylesheet" href="../assets/css/navbar.css">
    <link rel="stylesheet" href="../assets/css/cart.css">
</head>
<body>
    <?php include '../includes/navbar.php'; ?>
    <div class="shpcrt-wrapper">
        <!-- Header -->
        <div class="shpcrt-main-header">
            <div class="shpcrt-header-inner">
                <div>
                    <h1><i data-lucide="shopping-cart" class="shpcrt-header-icon-main" style="display: inline-block; vertical-align: middle; margin-right: 0.5rem;"></i>Shopping Cart</h1>
                    <div class="shpcrt-statistics-row">
                        <div class="shpcrt-stat-box">
                            <span class="shpcrt-stat-label-text"><i data-lucide="package" class="shpcrt-stat-icon-small" style="display: inline; vertical-align: middle;"></i>Total Items</span>
                            <span class="shpcrt-stat-number" id="totalItemsCount">0</span>
                        </div>
                        <div class="shpcrt-stat-box">
                            <span class="shpcrt-stat-label-text"><i data-lucide="check-circle" class="shpcrt-stat-icon-small" style="display: inline; vertical-align: middle;"></i>Selected for Checkout</span>
                            <span class="shpcrt-stat-number" id="selectedItemsCount">0</span>
                        </div>
                        <div class="shpcrt-stat-box">
                            <span class="shpcrt-stat-label-text"><i data-lucide="bookmark" class="shpcrt-stat-icon-small" style="display: inline; vertical-align: middle;"></i>Saved for Later</span>
                            <span class="shpcrt-stat-number" id="savedItemsCount">0</span>
                        </div>
                    </div>
                </div>
                <div class="shpcrt-nav-actions">
                    <a href="../pages/products.php" class="shpcrt-btn-base shpcrt-btn-secondary-style">
                        <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i>
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Cart Layout -->
        <div class="shpcrt-grid-layout">
            <!-- Cart Items -->
            <div class="shpcrt-items-container">
                <div class="shpcrt-section-top">
                    <h2>Cart Items</h2>
                    <div class="shpcrt-quick-actions">
                        <a class="shpcrt-action-link-style" onclick="selectAll()">Select All</a>
                        <a class="shpcrt-action-link-style" onclick="deselectAll()">Deselect All</a>
                    </div>
                </div>
                <div class="shpcrt-items-list" id="cartItems">
                    <div class="shpcrt-loading-state">
                        <div class="shpcrt-spinner"></div>
                        <span>Loading your cart...</span>
                    </div>
                </div>
            </div>

            <!-- Cart Summary -->
            <aside class="shpcrt-summary-panel">
                <div class="shpcrt-summary-inner">
                    <h3 class="shpcrt-summary-heading">Order Summary</h3>

                    <div class="shpcrt-summary-details">
                        <div class="shpcrt-summary-line">
                            <span class="shpcrt-summary-key">Subtotal</span>
                            <span class="shpcrt-summary-val" id="subtotalPrice">₱0.00</span>
                        </div>
                        <div class="shpcrt-summary-line">
                            <span class="shpcrt-summary-key">Items in Cart</span>
                            <span class="shpcrt-summary-val" id="summaryTotalItems">0</span>
                        </div>
                        <div class="shpcrt-summary-line">
                            <span class="shpcrt-summary-key">Selected Items</span>
                            <span class="shpcrt-summary-val" id="summarySelectedItems">0</span>
                        </div>
                    </div>

                    <div id="excludedItemsNotice"></div>

                    <div class="shpcrt-summary-line shpcrt-total-line">
                        <span class="shpcrt-total-text">Total</span>
                        <span class="shpcrt-total-amount" id="totalPrice">₱0.00</span>
                    </div>

                    <div class="shpcrt-action-buttons">
                        <button class="shpcrt-btn-base shpcrt-btn-primary-style shpcrt-btn-checkout-main" onclick="proceedToCheckout()" id="checkoutButton">
                            <i data-lucide="credit-card" style="width: 18px; height: 18px;"></i>
                            Proceed to Checkout
                        </button>
                        <button class="shpcrt-btn-base shpcrt-btn-secondary-style shpcrt-btn-clear-all" onclick="clearCart()" id="clearButton">
                            <i data-lucide="trash-2" style="width: 18px; height: 18px;"></i>
                            Clear Cart
                        </button>
                    </div>
                </div>

                <div class="shpcrt-trust-section">
                    <div class="shpcrt-trust-badge">
                        <i data-lucide="shield-check" class="shpcrt-badge-icon"></i>
                        <span>Secure Payment</span>
                    </div>
                    <div class="shpcrt-trust-badge">
                        <i data-lucide="truck" class="shpcrt-badge-icon"></i>
                        <span>Free Shipping</span>
                    </div>
                    <div class="shpcrt-trust-badge">
                        <i data-lucide="rotate-ccw" class="shpcrt-badge-icon"></i>
                        <span>Easy Returns</span>
                    </div>
                </div>
            </aside>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="shpcrt-toast-notify" id="toast">
        <span class="shpcrt-toast-icon-wrapper">
            <i data-lucide="check-circle" style="width: 20px; height: 20px;"></i>
        </span>
        <span id="toastMessage"></span>
    </div>

    <div id="clearCartModal" class="shpcrt-modal">
        <div class="shpcrt-modal-content">
            <span class="shpcrt-modal-close" onclick="closeClearCartModal()">&times;</span>
            <h3>Clear Cart</h3>
            <p>Are you sure you want to remove all items from your cart?</p>
            <div class="shpcrt-modal-actions">
                <button class="shpcrt-btn-base shpcrt-btn-secondary-style" onclick="closeClearCartModal()">Cancel</button>
                <button class="shpcrt-btn-base shpcrt-btn-primary-style shpcrt-btn-clear-confirm" onclick="confirmClearCart()">Yes, Clear</button>
            </div>
        </div>
    </div>
    <?php include '../includes/login-modal.php';?>
    <script>
        // Load products and cart from localStorage (populated by shop/products.php)
        let products = [];
        let cart = [];

      function loadCartFromDatabase() {
      const cartItems = document.getElementById('cartItems');
      cartItems.innerHTML = `
          <div class="shpcrt-loading-state">
              <div class="shpcrt-spinner"></div>
              <span>Refreshing cart...</span>
          </div>
      `;

      fetch('../ajax/fetch-cart.php')
          .then(res => res.json())
          .then(data => {
            console.log(data.cart);
              products = data.cart.map(item => ({
                  id: item.product_id,
                  title: item.product_name,
                  price: parseFloat(item.price),
                  image: `../assets/images/products/${item.product_image || 'default.png'}`,
                  category: item.category_name || 'Uncategorized',
                  unit: item.unit || 'piece'
              }));

              cart = data.cart.map(item => ({
                  id: item.product_id,
                  quantity: item.quantity,
                  selected: true
              }));

              updateCart();
              updateCartCount(data.count);
          })
          .catch(err => console.error('Fetch cart failed:', err));
  }


        function saveCartToLocalStorage() {
            const merged = cart.map(item => {
                const product = products.find(p => p.id === item.id);
                return product ? { ...product, quantity: item.quantity } : null;
            }).filter(Boolean);
            localStorage.setItem('cart', JSON.stringify(merged));

            const cartCount = document.getElementById('cartCount');
            if (cartCount) {
                const totalItems = cart.reduce((sum, i) => sum + i.quantity, 0);
                cartCount.textContent = totalItems;
            }
        }

        function updateCart() {
            const cartItems = document.getElementById('cartItems');
            cartItems.innerHTML = ''; // clear old DOM before re-render
            const totalItemsCount = document.getElementById('totalItemsCount');
            const selectedItemsCount = document.getElementById('selectedItemsCount');
            const savedItemsCount = document.getElementById('savedItemsCount');
            const subtotalPrice = document.getElementById('subtotalPrice');
            const totalPrice = document.getElementById('totalPrice');
            const summaryTotalItems = document.getElementById('summaryTotalItems');
            const summarySelectedItems = document.getElementById('summarySelectedItems');
            const excludedItemsNotice = document.getElementById('excludedItemsNotice');
            const checkoutButton = document.getElementById('checkoutButton');
            const clearButton = document.getElementById('clearButton');

            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            const selectedItems = cart.filter(item => item.selected);
            const excludedItems = cart.filter(item => !item.selected);
            const selectedCount = selectedItems.reduce((sum, item) => sum + item.quantity, 0);
            const excludedCount = excludedItems.reduce((sum, item) => sum + item.quantity, 0);

            const subtotal = cart.reduce((sum, item) => {
                const product = products.find(p => p.id === item.id);
                return sum + (product ? product.price * item.quantity : 0);
            }, 0);

            const checkoutTotal = selectedItems.reduce((sum, item) => {
                const product = products.find(p => p.id === item.id);
                return sum + (product ? product.price * item.quantity : 0);
            }, 0);

            // Update stats
            totalItemsCount.textContent = totalItems;
            selectedItemsCount.textContent = selectedCount;
            savedItemsCount.textContent = excludedCount;
            subtotalPrice.textContent = `₱${subtotal.toFixed(2)}`;
            totalPrice.textContent = `₱${checkoutTotal.toFixed(2)}`;
            summaryTotalItems.textContent = totalItems;
            summarySelectedItems.textContent = selectedCount;

            // Show excluded items notice
            if (excludedItems.length > 0) {
                const excludedNames = excludedItems.map(item => {
                    const product = products.find(p => p.id === item.id);
                    return product ? product.title : 'Item';
                }).join(', ');

                excludedItemsNotice.innerHTML = `
                    <div class="shpcrt-excluded-notice">
                        <div class="shpcrt-excluded-heading">
                            <i data-lucide="alert-circle" style="width: 16px; height: 16px; display: inline; vertical-align: middle; margin-right: 0.25rem;"></i>
                            Saved for Later (${excludedCount} item${excludedCount !== 1 ? 's' : ''})
                        </div>
                        <div class="shpcrt-excluded-list">${excludedNames}</div>
                    </div>
                `;
                setTimeout(() => lucide.createIcons(), 0);
            } else {
                excludedItemsNotice.innerHTML = '';
            }

            if (cart.length === 0) {
                cartItems.innerHTML = `
                    <div class="shpcrt-empty-state">
                        <i data-lucide="shopping-cart" class="shpcrt-empty-icon-large"></i>
                        <h3>Your cart is empty</h3>
                        <p>Add some amazing products to get started!</p>
                        <a href="../pages/products.php" class="shpcrt-btn-base shpcrt-btn-primary-style">
                            <i data-lucide="shopping-bag" style="width: 18px; height: 18px;"></i>
                            Browse Products
                        </a>
                    </div>
                `;
                // Initialize Lucide icons for empty state
                setTimeout(() => lucide.createIcons(), 0);
            } else {
                cartItems.innerHTML = cart.map(item => {
                    const product = products.find(p => p.id === item.id);
                    if (!product) return '';

                    const itemSubtotal = product.price * item.quantity;

                    return `
                        <div class="shpcrt-single-item ${!item.selected ? 'shpcrt-item-excluded' : ''}">
                            <div class="shpcrt-checkbox-area">
                                <div class="shpcrt-checkbox-holder">
                                    <input type="checkbox"
                                           id="item-${item.id}"
                                           ${item.selected ? 'checked' : ''}
                                           onchange="toggleItemSelection(${item.id})">
                                </div>
                            </div>
                            <div class="shpcrt-item-info-wrapper">
                                <div class="shpcrt-product-image">
                                <img src="${product.image}" alt="${product.title}" onerror="this.src='../assets/images/products/default.png'">
                                </div>
                                <div class="shpcrt-product-info">
                                    <div class="shpcrt-product-name">${product.title} /per ${product.unit}</div>
                                    <div class="shpcrt-product-category">${product.category}</div>
                                    <div class="shpcrt-product-price">
                                        ₱${product.price.toFixed(2)}
                                        <div class="shpcrt-price-subtotal">Subtotal: ₱${itemSubtotal.toFixed(2)}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="shpcrt-item-controls">
                                <div class="shpcrt-qty-adjuster">
                                    <button class="shpcrt-qty-button" onclick="updateQuantity(${item.id}, -1)" ${item.quantity <= 1 ? 'disabled' : ''}>
                                        <i data-lucide="minus" style="width: 16px; height: 16px;"></i>
                                    </button>
                                    <span class="shpcrt-qty-display">${item.quantity}</span>
                                    <button class="shpcrt-qty-button" onclick="updateQuantity(${item.id}, 1)">
                                        <i data-lucide="plus" style="width: 16px; height: 16px;"></i>
                                    </button>
                                </div>
                                <button class="shpcrt-remove-button" onclick="removeFromCart(${item.id})">
                                    <i data-lucide="trash-2" style="width: 14px; height: 14px; display: inline; vertical-align: middle; margin-right: 0.25rem;"></i>
                                    Remove
                                </button>
                            </div>
                        </div>
                    `;
                }).join('');

                // Initialize Lucide icons after rendering cart items
                setTimeout(() => lucide.createIcons(), 0);
            }

            // Enable/disable checkout button
            checkoutButton.disabled = selectedItems.length === 0;
            clearButton.disabled = cart.length === 0;

            // Persist changes to localStorage and navbar count
            saveCartToLocalStorage();
        }

        function toggleItemSelection(productId) {
            const item = cart.find(item => item.id === productId);
            if (item) {
                item.selected = !item.selected;
                updateCart();
                const product = products.find(p => p.id === productId);
                const action = item.selected ? 'selected for checkout' : 'saved for later';
                showToast(`${product.title} ${action}`, item.selected ? 'success' : 'warning');
            }
        }

        function selectAll() {
            cart.forEach(item => item.selected = true);
            updateCart();
            showToast('All items selected for checkout', 'success');
        }

        function deselectAll() {
            cart.forEach(item => item.selected = false);
            updateCart();
            showToast('All items saved for later', 'warning');
        }

        function updateQuantity(product_id, delta) {
            const item = cart.find(i => i.id === product_id);
            if (!item) return;

            const newQty = item.quantity + delta;
            if (newQty <= 0) {
                removeFromCart(product_id);
                return;
            }

            // Immediately update the number visually
            item.quantity = newQty;
            updateCart();

            fetch('../ajax/update-cart.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ product_id, quantity: newQty })
            })
            .then(res => res.json())
            .then(data => {
              if (data.success) {
                  showToast('Quantity updated', 'success');
                  updateCart();

              } else {
                  showToast(data.message || 'Failed to update quantity', 'error');
              }
          })
            .catch(err => console.error('Update error:', err));
        }



        function fetchCart() {
          fetch('../ajax/fetch-cart.php')
              .then(res => res.json())
              .then(data => {
                  updateCartCount(data.count);
              })
              .catch(err => console.error('Fetch cart count failed:', err));
      }
      function updateCartCount(count) {
          const cartCount = document.getElementById('cartCount');
          if (cartCount) {
              cartCount.textContent = count > 0 ? count : '';
          }
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
                  showToast('Item removed', 'success');
                  setTimeout(() => loadCartFromDatabase(), 150);
              } else {
                  showToast(data.message || 'Failed to remove item', 'error');
              }
          })
          .catch(err => console.error('Remove error:', err));
      }

      function clearCart() {
          document.getElementById('clearCartModal').style.display = 'flex';
      }
      function closeClearCartModal() {
          document.getElementById('clearCartModal').style.display = 'none';
      }
      function confirmClearCart() {
          fetch('../ajax/clear-cart.php', { method: 'POST' })
              .then(res => res.json())
              .then(data => {
                  if (data.success) {
                      showToast('Cart cleared', 'success');
                      loadCartFromDatabase();
                  } else {
                      showToast('Failed to clear cart', 'error');
                  }
              })
              .catch(err => console.error(err))
              .finally(() => closeClearCartModal());
      }
      // upate ko to
      function proceedToCheckout() {
          const selectedItems = cart.filter(item => item.selected);

          if (selectedItems.length === 0) {
              showToast('Please select at least one item to checkout', 'error');
              return;
          }

          // Create a form and submit via POST
          const form = document.createElement('form');
          form.method = 'POST';
          form.action = 'checkout.php';

          const input = document.createElement('input');
          input.type = 'hidden';
          input.name = 'selectedItems';
          input.value = JSON.stringify(selectedItems);

          form.appendChild(input);
          document.body.appendChild(form);
          form.submit();
      }


        function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    const toastMessage = document.getElementById('toastMessage');
    let toastIcon = toast.querySelector('.shpcrt-toast-icon-wrapper i')
                   || toast.querySelector('.shpcrt-toast-icon-wrapper svg'); // fallback

    const icons = {
        success: 'check-circle',
        error: 'x-circle',
        warning: 'alert-triangle'
    };

    toastMessage.textContent = message;

    toast.querySelector('.shpcrt-toast-icon-wrapper').innerHTML =
        `<i data-lucide="${icons[type] || icons.success}" style="width: 20px; height: 20px;"></i>`;

    toast.className = `shpcrt-toast-notify shpcrt-toast-${type}`;
    toast.classList.add('shpcrt-toast-show');

    lucide.createIcons();

    setTimeout(() => {
        toast.classList.remove('shpcrt-toast-show');
    }, 3000);
}


        document.addEventListener('DOMContentLoaded', function () {
            lucide.createIcons();
            loadCartFromDatabase();
        });


    </script>

    <!-- <script src="../assets/js/cart.js"></script> -->
    <script src="../assets/js/homepage.js"></script>
    <script src="../assets/js/search-suggestions.js" defer></script>
            <script src="../assets/js/navbar.js"></script>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
