<?php
 require_once __DIR__ . '/../../auth/admin_auth.php';
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Manual Order - M & E Dashboard</title>
    <link rel="icon" type="image/x-icon" href="../../assets/images/M&E_LOGO-semi-transparent.ico">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <link rel="stylesheet" href="../assets/css/admin/orders/create.css">
</head>
<body>
    <div class="dashboard">
        <!-- Mobile Menu Button -->
        <button class="mobile-menu-btn" data-sidebar-toggle="open">
            <i data-lucide="menu"></i>
        </button>

        <?php include '../../includes/admin_sidebar.php'; ?>

        <!-- Main Content -->
        <main class="main-content">
            <div class="header">
                <div class="header-left">
                    <h2>Create Manual Order</h2>
                    <p class="header-subtitle">Create a new order for a customer</p>
                </div>
                <div class="user-info">
                    <span><?= htmlspecialchars($_SESSION['admin_username'] ?? 'Admin') ?></span>
                    <div class="avatar"><?= htmlspecialchars(strtoupper(substr($_SESSION['admin_username'] ?? 'A', 0, 1))) ?></div>
                </div>
            </div>

            <div class="breadcrumb">
                <a href="./index.php">Orders</a>
                <span>></span>
                <span>Create Order</span>
            </div>

            <form id="createOrderForm" class="order-form">
                <!-- Customer Selection -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i data-lucide="user"></i>
                        Customer Information
                    </h3>
                    <div class="form-row">
                        <div class="form-group full-width">
                            <label class="form-label">Search Customer *</label>
                            <div class="search-input-wrapper">
                                <i data-lucide="search" class="search-icon"></i>
                                <input 
                                    type="text" 
                                    id="customerSearch" 
                                    class="form-input" 
                                    placeholder="Search by name, email, or phone..."
                                    autocomplete="off"
                                >
                                <div id="customerDropdown" class="search-dropdown"></div>
                            </div>
                            <input type="hidden" id="selectedCustomerId" required>
                        </div>
                    </div>

                    <div id="selectedCustomerInfo" class="customer-info-card" style="display: none;">
                        <div class="customer-info-header">
                            <div class="customer-avatar" id="customerAvatar">C</div>
                            <div class="customer-details">
                                <h4 id="customerName"></h4>
                                <p id="customerEmail"></p>
                            </div>
                            <button type="button" class="btn-remove" onclick="clearCustomer()">
                                <i data-lucide="x"></i>
                            </button>
                        </div>
                        <div class="customer-info-body">
                            <div class="info-item">
                                <span class="info-label">Contact:</span>
                                <span id="customerContact"></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Address:</span>
                                <span id="customerAddress"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Selection -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i data-lucide="package"></i>
                        Order Items
                    </h3>
                    <div class="form-row">
                        <div class="form-group full-width">
                            <label class="form-label">Search Products</label>
                            <div class="search-input-wrapper">
                                <i data-lucide="search" class="search-icon"></i>
                                <input 
                                    type="text" 
                                    id="productSearch" 
                                    class="form-input" 
                                    placeholder="Search products by name or code..."
                                    autocomplete="off"
                                >
                                <div id="productDropdown" class="search-dropdown"></div>
                            </div>
                        </div>
                    </div>

                    <div id="orderItemsContainer" class="order-items-container">
                        <div class="empty-state">
                            <i data-lucide="shopping-cart"></i>
                            <p>No items added yet. Search and select products above.</p>
                        </div>
                    </div>

                    <div id="orderSummary" class="order-summary" style="display: none;">
                        <div class="summary-row">
                            <span>Subtotal:</span>
                            <span id="subtotalAmount">₱0.00</span>
                        </div>
                        <div class="summary-row">
                            <span>Shipping Fee:</span>
                            <span id="shippingAmount">₱70.00</span>
                        </div>
                        <div class="summary-row total">
                            <span>Total Amount:</span>
                            <span id="totalAmount">₱70.00</span>
                        </div>
                    </div>
                </div>

                <!-- Delivery Information -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i data-lucide="truck"></i>
                        Delivery Information
                    </h3>
                    <div class="form-row">
                        <div class="form-group full-width">
                            <label class="form-label">Delivery Address *</label>
                            <textarea 
                                id="deliveryAddress" 
                                class="form-textarea" 
                                rows="3" 
                                placeholder="Enter complete delivery address..."
                                required
                            ></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Contact Number *</label>
                            <input 
                                type="text" 
                                id="contactNumber" 
                                class="form-input" 
                                placeholder="09XX XXX XXXX"
                                required
                            >
                        </div>
                        <div class="form-group">
                            <label class="form-label">Shipping Fee</label>
                            <input 
                                type="number" 
                                id="shippingFee" 
                                class="form-input" 
                                value="70.00"
                                min="0"
                                step="0.01"
                            >
                        </div>
                    </div>
                </div>

                <!-- Order Details -->
                <div class="form-section">
                    <h3 class="section-title">
                        <i data-lucide="file-text"></i>
                        Order Details
                    </h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Payment Method</label>
                            <select id="paymentMethod" class="form-select">
                                <option value="COD">Cash on Delivery (COD)</option>
                                <option value="Bank Transfer">Bank Transfer</option>
                                <option value="GCash">GCash</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Order Status</label>
                            <select id="orderStatus" class="form-select">
                                <option value="Pending">Pending</option>
                                <option value="Confirmed">Confirmed</option>
                                <option value="Shipped">Shipped</option>
                                <option value="Delivered">Delivered</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group full-width">
                            <label class="form-label">Special Instructions</label>
                            <textarea 
                                id="specialInstructions" 
                                class="form-textarea" 
                                rows="2" 
                                placeholder="Any special delivery instructions..."
                            ></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group full-width">
                            <label class="form-label">Admin Notes (Internal)</label>
                            <textarea 
                                id="adminNotes" 
                                class="form-textarea" 
                                rows="2" 
                                placeholder="Internal notes (not visible to customer)..."
                            ></textarea>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='./index.php'">
                        <i data-lucide="x"></i>
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i data-lucide="check"></i>
                        Create Order
                    </button>
                </div>
            </form>
        </main>
    </div>

    <script>
        // State management
        let selectedCustomer = null;
        let orderItems = [];
        let customerSearchTimeout = null;
        let productSearchTimeout = null;

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
            setupEventListeners();
            checkForPrefilledCustomer();
        });

        function setupEventListeners() {
            // Customer search
            document.getElementById('customerSearch').addEventListener('input', handleCustomerSearch);
            
            // Product search
            document.getElementById('productSearch').addEventListener('input', handleProductSearch);
            
            // Shipping fee change
            document.getElementById('shippingFee').addEventListener('input', updateOrderSummary);
            
            // Form submit
            document.getElementById('createOrderForm').addEventListener('submit', handleSubmit);
            
            // Close dropdowns when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.search-input-wrapper')) {
                    document.getElementById('customerDropdown').style.display = 'none';
                    document.getElementById('productDropdown').style.display = 'none';
                }
            });
        }

        // Check for prefilled customer from URL parameter
        async function checkForPrefilledCustomer() {
            const urlParams = new URLSearchParams(window.location.search);
            const customerEmail = urlParams.get('customer');
            
            if (customerEmail) {
                // Auto-search for the customer
                try {
                    const response = await fetch(`../../api/admin/orders/search-customers.php?q=${encodeURIComponent(customerEmail)}`);
                    const data = await response.json();
                    
                    if (data.success && data.customers.length > 0) {
                        // Auto-select the first matching customer
                        const customer = data.customers[0];
                        selectCustomer(customer);
                        showToast('Customer auto-selected from request', 'success');
                    } else {
                        // If not found, pre-fill the search box
                        document.getElementById('customerSearch').value = customerEmail;
                        showToast('Customer not found. Please search manually.', 'warning');
                    }
                } catch (error) {
                    console.error('Error loading customer:', error);
                    document.getElementById('customerSearch').value = customerEmail;
                }
            }
        }

        // Customer search
        function handleCustomerSearch(e) {
            const query = e.target.value.trim();
            const dropdown = document.getElementById('customerDropdown');
            
            clearTimeout(customerSearchTimeout);
            
            if (query.length < 2) {
                dropdown.style.display = 'none';
                return;
            }
            
            customerSearchTimeout = setTimeout(async () => {
                try {
                    const response = await fetch(`../../api/admin/orders/search-customers.php?q=${encodeURIComponent(query)}`);
                    const data = await response.json();
                    
                    if (data.success && data.customers.length > 0) {
                        displayCustomerResults(data.customers);
                    } else {
                        dropdown.innerHTML = '<div class="dropdown-item no-results">No customers found</div>';
                        dropdown.style.display = 'block';
                    }
                } catch (error) {
                    console.error('Error searching customers:', error);
                    showToast('Error searching customers', 'error');
                }
            }, 300);
        }

        function displayCustomerResults(customers) {
            const dropdown = document.getElementById('customerDropdown');
            dropdown.innerHTML = customers.map(customer => `
                <div class="dropdown-item" onclick='selectCustomer(${JSON.stringify(customer)})'>
                    <div class="dropdown-item-main">
                        <strong>${customer.name}</strong>
                        <span class="dropdown-item-meta">${customer.email}</span>
                    </div>
                    <div class="dropdown-item-secondary">
                        ${customer.contact_number || ''}
                        ${customer.location ? ' • ' + customer.location : ''}
                    </div>
                </div>
            `).join('');
            dropdown.style.display = 'block';
        }

        function selectCustomer(customer) {
            selectedCustomer = customer;
            document.getElementById('selectedCustomerId').value = customer.id;
            document.getElementById('customerSearch').value = customer.name;
            document.getElementById('customerDropdown').style.display = 'none';
            
            // Display customer info
            const initials = customer.name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);
            document.getElementById('customerAvatar').textContent = initials;
            document.getElementById('customerName').textContent = customer.name;
            document.getElementById('customerEmail').textContent = customer.email;
            document.getElementById('customerContact').textContent = customer.contact_number || 'N/A';
            document.getElementById('customerAddress').textContent = customer.address || 'N/A';
            
            // Auto-fill delivery info
            if (customer.address) {
                document.getElementById('deliveryAddress').value = customer.address;
            }
            if (customer.contact_number) {
                document.getElementById('contactNumber').value = customer.contact_number;
            }
            
            document.getElementById('selectedCustomerInfo').style.display = 'block';
            lucide.createIcons();
        }

        function clearCustomer() {
            selectedCustomer = null;
            document.getElementById('selectedCustomerId').value = '';
            document.getElementById('customerSearch').value = '';
            document.getElementById('selectedCustomerInfo').style.display = 'none';
        }

        // Product search
        function handleProductSearch(e) {
            const query = e.target.value.trim();
            const dropdown = document.getElementById('productDropdown');
            
            clearTimeout(productSearchTimeout);
            
            if (query.length < 2) {
                dropdown.style.display = 'none';
                return;
            }
            
            productSearchTimeout = setTimeout(async () => {
                try {
                    const response = await fetch(`../../api/admin/orders/search-products.php?q=${encodeURIComponent(query)}`);
                    const data = await response.json();
                    
                    if (data.success && data.products.length > 0) {
                        displayProductResults(data.products);
                    } else {
                        dropdown.innerHTML = '<div class="dropdown-item no-results">No products found</div>';
                        dropdown.style.display = 'block';
                    }
                } catch (error) {
                    console.error('Error searching products:', error);
                    showToast('Error searching products', 'error');
                }
            }, 300);
        }

        function displayProductResults(products) {
            const dropdown = document.getElementById('productDropdown');
            dropdown.innerHTML = products.map(product => `
                <div class="dropdown-item ${!product.available ? 'disabled' : ''}" 
                     onclick='${product.available ? `selectProduct(${JSON.stringify(product)})` : ''}'>
                    <div class="dropdown-item-main">
                        <strong>${product.name}</strong>
                        <span class="dropdown-item-meta">${product.code}</span>
                    </div>
                    <div class="dropdown-item-secondary">
                        ₱${product.price.toFixed(2)} • Stock: ${product.stock}
                        ${!product.available ? ' • <span style="color: #ef4444;">Out of Stock</span>' : ''}
                    </div>
                </div>
            `).join('');
            dropdown.style.display = 'block';
        }

        function selectProduct(product) {
            // Check if product already in order
            const existingItem = orderItems.find(item => item.id === product.id);
            if (existingItem) {
                showToast('Product already added to order', 'warning');
                return;
            }
            
            orderItems.push({
                id: product.id,
                name: product.name,
                code: product.code,
                price: product.price,
                stock: product.stock,
                quantity: 1,
                image: product.image
            });
            
            document.getElementById('productSearch').value = '';
            document.getElementById('productDropdown').style.display = 'none';
            
            renderOrderItems();
            updateOrderSummary();
        }

        function renderOrderItems() {
            const container = document.getElementById('orderItemsContainer');
            
            if (orderItems.length === 0) {
                container.innerHTML = `
                    <div class="empty-state">
                        <i data-lucide="shopping-cart"></i>
                        <p>No items added yet. Search and select products above.</p>
                    </div>
                `;
                document.getElementById('orderSummary').style.display = 'none';
                lucide.createIcons();
                return;
            }
            
            container.innerHTML = orderItems.map((item, index) => `
                <div class="order-item">
                    <div class="order-item-image">
                        ${item.image 
                            ? `<img src="${item.image}" alt="${item.name}">`
                            : '<i data-lucide="package"></i>'
                        }
                    </div>
                    <div class="order-item-details">
                        <h4>${item.name}</h4>
                        <p>${item.code} • ₱${item.price.toFixed(2)}</p>
                        <p class="stock-info">Available: ${item.stock} units</p>
                    </div>
                    <div class="order-item-quantity">
                        <button type="button" class="qty-btn" onclick="updateQuantity(${index}, -1)">
                            <i data-lucide="minus"></i>
                        </button>
                        <input 
                            type="number" 
                            class="qty-input" 
                            value="${item.quantity}"
                            min="1"
                            max="${item.stock}"
                            onchange="setQuantity(${index}, this.value)"
                        >
                        <button type="button" class="qty-btn" onclick="updateQuantity(${index}, 1)">
                            <i data-lucide="plus"></i>
                        </button>
                    </div>
                    <div class="order-item-subtotal">
                        ₱${(item.price * item.quantity).toFixed(2)}
                    </div>
                    <button type="button" class="order-item-remove" onclick="removeItem(${index})">
                        <i data-lucide="trash-2"></i>
                    </button>
                </div>
            `).join('');
            
            document.getElementById('orderSummary').style.display = 'block';
            lucide.createIcons();
        }

        function updateQuantity(index, change) {
            const item = orderItems[index];
            const newQty = item.quantity + change;
            
            if (newQty < 1) {
                showToast('Quantity cannot be less than 1', 'warning');
                return;
            }
            
            if (newQty > item.stock) {
                showToast(`Only ${item.stock} units available`, 'warning');
                return;
            }
            
            item.quantity = newQty;
            renderOrderItems();
            updateOrderSummary();
        }

        function setQuantity(index, value) {
            const item = orderItems[index];
            const qty = parseInt(value) || 1;
            
            if (qty < 1) {
                item.quantity = 1;
            } else if (qty > item.stock) {
                item.quantity = item.stock;
                showToast(`Only ${item.stock} units available`, 'warning');
            } else {
                item.quantity = qty;
            }
            
            renderOrderItems();
            updateOrderSummary();
        }

        function removeItem(index) {
            orderItems.splice(index, 1);
            renderOrderItems();
            updateOrderSummary();
        }

        function updateOrderSummary() {
            const subtotal = orderItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const shipping = parseFloat(document.getElementById('shippingFee').value) || 0;
            const total = subtotal + shipping;
            
            document.getElementById('subtotalAmount').textContent = '₱' + subtotal.toFixed(2);
            document.getElementById('shippingAmount').textContent = '₱' + shipping.toFixed(2);
            document.getElementById('totalAmount').textContent = '₱' + total.toFixed(2);
        }

        // Form submission
        async function handleSubmit(e) {
            e.preventDefault();
            
            // Validation
            if (!selectedCustomer) {
                showToast('Please select a customer', 'error');
                return;
            }
            
            if (orderItems.length === 0) {
                showToast('Please add at least one product', 'error');
                return;
            }
            
            const deliveryAddress = document.getElementById('deliveryAddress').value.trim();
            const contactNumber = document.getElementById('contactNumber').value.trim();
            
            if (!deliveryAddress) {
                showToast('Delivery address is required', 'error');
                return;
            }
            
            if (!contactNumber) {
                showToast('Contact number is required', 'error');
                return;
            }
            
            // Prepare order data
            const orderData = {
                user_id: selectedCustomer.id,
                items: orderItems.map(item => ({
                    product_id: item.id,
                    quantity: item.quantity
                })),
                shipping_fee: parseFloat(document.getElementById('shippingFee').value) || 70.00,
                payment_method: document.getElementById('paymentMethod').value,
                order_status: document.getElementById('orderStatus').value,
                delivery_address: deliveryAddress,
                contact_number: contactNumber,
                special_instructions: document.getElementById('specialInstructions').value.trim(),
                admin_notes: document.getElementById('adminNotes').value.trim()
            };
            
            // Submit
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i data-lucide="loader"></i> Creating Order...';
            lucide.createIcons();
            
            try {
                const response = await fetch('../../api/admin/orders/create.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(orderData)
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showToast('Order created successfully!', 'success');
                    setTimeout(() => {
                        window.location.href = './index.php';
                    }, 1500);
                } else {
                    showToast(data.error || 'Failed to create order', 'error');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i data-lucide="check"></i> Create Order';
                    lucide.createIcons();
                }
            } catch (error) {
                console.error('Error creating order:', error);
                showToast('Error creating order. Please try again.', 'error');
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i data-lucide="check"></i> Create Order';
                lucide.createIcons();
            }
        }

        // Toast notification
        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.textContent = message;
            document.body.appendChild(toast);
            
            setTimeout(() => toast.classList.add('show'), 100);
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }
    </script>
</body>
</html>
