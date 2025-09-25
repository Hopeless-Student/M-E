<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders - M & E Dashboard</title>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <link rel="stylesheet" href="../assets/css/admin/orders/index.css">
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
                <h2>Orders Management</h2>
                <div class="user-info">
                    <span>Elbar Como</span>
                    <div class="avatar">E</div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="quick-stats">
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-title">Pending</div>
                        <i data-lucide="circle-dashed" class="stat-icon"></i>
                    </div>
                    <div class="stat-value" id="totalPending">0</div>
                    <div class="stat-change neutral">Pending Orders</div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-title">Processing</div>
                        <i data-lucide="circle-dot-dashed" class="stat-icon"></i>
                    </div>
                    <div class="stat-value" id="totalProcessing">0</div>
                    <div class="stat-change neutral">Orders in Process</div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-title">Shipped</div>
                        <i data-lucide="truck" class="stat-icon"></i>
                    </div>
                    <div class="stat-value" id="totalShipped">0</div>
                    <div class="stat-change neutral">Orders in transit</div>
                </div>
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-title">Delivered</div>
                        <i data-lucide="package-check " class="stat-icon"></i>
                    </div>
                    <div class="stat-value" id="totalDeliver">0</div>
                    <div class="stat-change neutral">Delivered Orders</div>
                </div>
            </div>
            <!-- Orders Controls -->
            <div class="orders-controls">
                <div class="search-filter">
                    <div class="search-box">
                        <i data-lucide="search" class="search-icon"></i>
                        <input type="text" class="search-input" id="searchInput" placeholder="Search orders...">
                    </div>
                    <select class="filter-select" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="processing">Processing</option>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
                    </select>
                    <select class="filter-select" id="categoryFilter">
                        <option value="">All Categories</option>
                        <option value="School Supplies">School Supplies</option>
                        <option value="Sanitary Supplies">Sanitary Supplies</option>
                        <option value="Office Supplies">Office Supplies</option>
                    </select>
                </div>
            </div>

            <!-- Orders Table -->
            <div class="orders-section">
                <div class="table-container">
                    <table class="orders-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Category</th>
                                <th>Items</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Orders will be populated dynamically -->
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination">
                    <div class="pagination-info">
                        Showing 1-8 of 267 orders
                    </div>
                    <div class="pagination-controls">
                        <button class="page-btn">Previous</button>
                        <button class="page-btn active">1</button>
                        <button class="page-btn">2</button>
                        <button class="page-btn">3</button>
                        <button class="page-btn">4</button>
                        <button class="page-btn">Next</button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Include the modal -->
    <?php include 'order-details.php';
          include 'update-status.php';
    ?>

    <script>
    lucide.createIcons();

    // Global variables for pagination and data
    let currentPage = 1;
    let totalPages = 1;
    let allOrders = [];
    let filteredOrders = [];
    const ordersPerPage = 8;

    // Load orders data on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadOrdersData();
        updateStats();
    });

    function updateStats() {
        // Calculate stats from all orders
        const pending = allOrders.filter(o => o.status === 'pending').length;
        const processing = allOrders.filter(o => o.status === 'processing').length;
        const shipped = allOrders.filter(o => o.status === 'shipped').length;
        const delivered = allOrders.filter(o => o.status === 'delivered').length;

        document.getElementById('totalPending').textContent = pending;
        document.getElementById('totalProcessing').textContent = processing;
        document.getElementById('totalShipped').textContent = shipped;
        document.getElementById('totalDeliver').textContent = delivered;
    }

    async function loadOrdersData() {
        try {
            // Replace this with actual API call
            // const response = await fetch('/api/orders.php');
            // const result = await response.json();

            // Mock data for now
            const result = {
                success: true,
                data: {
                    orders: generateMockOrders(25), // Generate 25 sample orders
                    total: 25
                }
            };

            allOrders = result.data.orders;
            filteredOrders = [...allOrders];
            totalPages = Math.ceil(filteredOrders.length / ordersPerPage);

            renderOrders();
            renderPagination();
            updateStats();
        } catch (error) {
            console.error('Error loading orders:', error);
            showError('Error loading orders data.');
        }
    }

    function generateMockOrders(count) {
        const customers = ['Cjay Gonzales', 'Joshua Lapitan', 'Prince Ace Masinsin', 'Gillian Lorenzo', 'Kenji Chua', 'Angel Bien', 'Miguel Torres', 'Carmen Lopez'];
        const categories = ['School Supplies', 'Office Supplies', 'Sanitary Supplies'];
        const statuses = ['pending', 'processing', 'shipped', 'delivered'];
        const orders = [];

        for (let i = 1; i <= count; i++) {
            orders.push({
                id: String(i).padStart(3, '0'),
                customer: customers[Math.floor(Math.random() * customers.length)],
                category: categories[Math.floor(Math.random() * categories.length)],
                items: Math.floor(Math.random() * 5) + 1,
                amount: (Math.random() * 20000 + 1000).toFixed(0),
                date: new Date(2024, 8, Math.floor(Math.random() * 30) + 1).toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                }),
                status: statuses[Math.floor(Math.random() * statuses.length)],
                // Additional details for modal
                email: customers[Math.floor(Math.random() * customers.length)].toLowerCase().replace(' ', '.') + '@email.com',
                phone: '+63 9' + Math.floor(Math.random() * 100000000).toString().padStart(8, '0'),
                company: 'Company ' + String.fromCharCode(65 + Math.floor(Math.random() * 26)),
                address: Math.floor(Math.random() * 999) + ' Business Street, Quezon City, Metro Manila',
                trackingNumber: 'ME-TRK-2024-' + String(i).padStart(3, '0'),
                paymentMethod: ['Bank Transfer', 'Credit Card', 'Cash'][Math.floor(Math.random() * 3)],
                transactionId: 'TXN-' + Date.now() + i,
                notes: 'Customer requested priority delivery for business opening.'
            });
        }
        return orders;
    }

    function renderOrders() {
        const tbody = document.querySelector('.orders-table tbody');
        const startIndex = (currentPage - 1) * ordersPerPage;
        const endIndex = startIndex + ordersPerPage;
        const pageOrders = filteredOrders.slice(startIndex, endIndex);

        if (pageOrders.length === 0) {
            tbody.innerHTML = '<tr><td colspan="8" class="loading">No orders found</td></tr>';
            return;
        }

        tbody.innerHTML = pageOrders.map(order => `
            <tr>
                <td><strong>#ORD-${order.id}</strong></td>
                <td>${order.customer}</td>
                <td><span class="category-badge">${order.category}</span></td>
                <td>${order.items} item${order.items !== 1 ? 's' : ''}</td>
                <td><strong>₱${parseInt(order.amount).toLocaleString()}</strong></td>
                <td>${order.date}</td>
                <td><span class="status ${order.status}">${order.status.charAt(0).toUpperCase() + order.status.slice(1)}</span></td>
                <td>
                    <div class="actions">
                        <button class="action-btn secondary" onclick="openOrderModal('${order.id}')">View</button>
                        <button class="action-btn primary" onclick="openUpdateModal('${order.id}')">Update</button>
                        <button class="action-btn danger"  >Del</button>
                    </div>
                </td>
            </tr>
        `).join('');
    }

    function renderPagination() {
        const paginationInfo = document.querySelector('.pagination-info');
        const paginationControls = document.querySelector('.pagination-controls');

        const startItem = ((currentPage - 1) * ordersPerPage) + 1;
        const endItem = Math.min(currentPage * ordersPerPage, filteredOrders.length);

        paginationInfo.textContent = `Showing ${startItem}-${endItem} of ${filteredOrders.length} orders`;

        // Generate page buttons
        let buttonsHTML = '<button class="page-btn" id="prevBtn">Previous</button>';

        for (let i = 1; i <= totalPages; i++) {
            buttonsHTML += `<button class="page-btn ${i === currentPage ? 'active' : ''}" data-page="${i}">${i}</button>`;
        }

        buttonsHTML += '<button class="page-btn" id="nextBtn">Next</button>';

        paginationControls.innerHTML = buttonsHTML;

        // Add event listeners
        document.getElementById('prevBtn').onclick = () => goToPage(currentPage - 1);
        document.getElementById('nextBtn').onclick = () => goToPage(currentPage + 1);

        document.querySelectorAll('[data-page]').forEach(btn => {
            btn.onclick = () => goToPage(parseInt(btn.dataset.page));
        });
    }

    function goToPage(page) {
        if (page < 1 || page > totalPages) return;
        currentPage = page;
        renderOrders();
        renderPagination();
    }

    function applyFilters() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value;
        const categoryFilter = document.getElementById('categoryFilter').value;

        filteredOrders = allOrders.filter(order => {
          const matchesSearch = !searchTerm ||
              order.customer.toLowerCase().includes(searchTerm) ||
              order.id.includes(searchTerm);

            const matchesStatus = !statusFilter || order.status === statusFilter;
            const matchesCategory = !categoryFilter || order.category.toLowerCase() === categoryFilter.toLowerCase();;

            return matchesSearch && matchesStatus && matchesCategory;
        });

        totalPages = Math.ceil(filteredOrders.length / ordersPerPage);
        currentPage = 1; // Reset to first page when filtering
        renderOrders();
        renderPagination();
    }

    // Search functionality
    document.getElementById('searchInput').addEventListener('input', applyFilters);
    document.getElementById('statusFilter').addEventListener('change', applyFilters);
    document.getElementById('categoryFilter').addEventListener('change', applyFilters);

    function showError(message) {
        const tbody = document.querySelector('.orders-table tbody');
        tbody.innerHTML = `<tr><td colspan="8" class="error" style="text-align: center; padding: 2rem; color: #dc2626;">${message}</td></tr>`;
    }

    // Modal Functions
    function openOrderModal(orderId) {
      const order = allOrders.find(o => o.id === orderId);
      if (!order) {
        alert('Order not found');
        return;
      }

      // Populate modal with order data
      populateModalData(order);

      // Show only the order details modal
      document.getElementById('orderModal').classList.add('active');
      document.body.style.overflow = 'hidden';

    const updtbtn = document.getElementById("updateModal");
    if(updtbtn){
      updtbtn.onclick = () => openUpdateModal(orderId);
    }

      // Refresh Lucide icons for the modal
      setTimeout(() => {
        lucide.createIcons();
      }, 100);
    }

    function openUpdateModal(orderId) {
      const order = allOrders.find(o => o.id === orderId);
      if (!order) {
        alert('Order not found');
        return;
      }

      populateUpdateData(order);

      // Close the order details modal
      const orderModal = document.getElementById("orderModal");
      if (orderModal) orderModal.classList.remove("active");

      // Open the update status modal
      const updateModal = document.getElementById("updateStatusModal");
      if (updateModal) updateModal.classList.add("active");

      document.body.style.overflow = "hidden";

      // Refresh Lucide icons for the modal
      setTimeout(() => {
        lucide.createIcons();
      }, 100);
    }

    function submitStatusUpdate(orderId) {
      alert("Order Updated Successfully!");

      const modal = document.getElementById("updateStatusModal");
      if (modal) {
        modal.classList.remove("active");
      }

      document.body.style.overflow = ''; // restore scrolling
    }


    function populateModalData(order) {
        // Basic order information
        document.getElementById('modalOrderId').textContent = `#ORD-${order.id}`;
        document.getElementById('detailOrderId').textContent = `#ORD-${order.id}`;
        document.getElementById('detailCustomer').textContent = order.customer;
        document.getElementById('detailCategory').textContent = order.category;
        document.getElementById('detailAmount').textContent = `₱${parseInt(order.amount).toLocaleString()}`;
        document.getElementById('detailDate').textContent = order.date;

        // Status with proper class
        const statusElement = document.getElementById('detailStatus');
        statusElement.textContent = order.status.charAt(0).toUpperCase() + order.status.slice(1);
        statusElement.className = `status ${order.status}`;

        // Customer information
        document.getElementById('customerName').textContent = order.customer;
        document.getElementById('customerEmail').textContent = order.email;
        document.getElementById('customerPhone').textContent = order.phone;
        document.getElementById('customerCompany').textContent = order.company;
        document.getElementById('customerSince').textContent = 'January 2024';

        // Delivery information
        document.getElementById('deliveryAddress').innerHTML = order.address.replace(', ', '<br>');
        document.getElementById('deliveryMethod').textContent = 'Standard Delivery';
        document.getElementById('expectedDelivery').textContent = getExpectedDeliveryDate(order.date, order.status);
        document.getElementById('trackingNumber').textContent = order.trackingNumber;

        // Payment information
        document.getElementById('paymentMethod').textContent = order.paymentMethod;
        const paymentStatusElement = document.getElementById('paymentStatus');
        paymentStatusElement.textContent = 'Paid';
        paymentStatusElement.className = 'status delivered';
        document.getElementById('transactionId').textContent = order.transactionId;
        document.getElementById('paymentDate').textContent = order.date;

        // Order items (mock data)
        populateOrderItems(order);

        // Order timeline
        populateOrderTimeline(order);

        // Notes
        document.getElementById('orderNotes').value = order.notes;
    }

    function populateUpdateData(order){
        document.getElementById('modalUpdateId').textContent = `#ORD-${order.id}`;
        document.getElementById('updateOrderId').textContent = `#ORD-${order.id}`;
        document.getElementById('updateCustomerName').textContent = order.customer;
        document.getElementById('updateOrderAmount').textContent = `₱${parseInt(order.amount).toLocaleString()}`;

        const statusElement = document.getElementById('updateCurrentStatus');
        statusElement.textContent = order.status.charAt(0).toUpperCase() + order.status.slice(1);
        statusElement.className = `status ${order.status}`;

        document.getElementById('updateOrderDate').textContent = order.date;
        document.getElementById('updateTrackingNumber').textContent = order.trackingNumber;


    }

    function populateOrderItems(order) {
        const itemsContainer = document.getElementById('orderItems');

        // Generate mock items based on category and amount
        const mockItems = generateMockItems(order.category, order.items, order.amount);

        let itemsHTML = '';
        let total = 0;

        mockItems.forEach(item => {
            const subtotal = item.quantity * item.price;
            total += subtotal;

            itemsHTML += `
                <tr>
                    <td>${item.name}</td>
                    <td>${item.quantity} ${item.unit}</td>
                    <td>₱${item.price.toLocaleString()}</td>
                    <td>₱${subtotal.toLocaleString()}</td>
                </tr>
            `;
        });

        itemsHTML += `
            <tr style="border-top: 2px solid #1e40af;">
                <td colspan="3" style="text-align: right; font-weight: 600;">Total:</td>
                <td style="font-weight: 700; color: #1e40af; font-size: 1.1rem;">₱${total.toLocaleString()}</td>
            </tr>
        `;

        itemsContainer.innerHTML = itemsHTML;
    }

    function generateMockItems(category, itemCount, totalAmount) {
        const itemsMap = {
            'School Supplies': [
                { name: 'Vinyl Planks', unit: 'sqm' },
                { name: 'Ceramic Tiles', unit: 'sqm' },
                { name: 'Hardwood Flooring', unit: 'sqm' }
            ],
            'Office Supplies': [
                { name: 'Ceramic Wall Tiles', unit: 'sqm' },
                { name: 'Porcelain Floor Tiles', unit: 'sqm' },
                { name: 'Mosaic Tiles', unit: 'sqm' }
            ],
            'Sanitary Supplies': [
                { name: 'LED Light Fixtures', unit: 'pcs' },
                { name: 'Ceiling Fans', unit: 'pcs' },
                { name: 'Wall Sconces', unit: 'pcs' }
            ]
        };

        const availableItems = itemsMap[category] || itemsMap['Fixtures'];
        const items = [];
        const targetAmount = parseInt(totalAmount);

        for (let i = 0; i < itemCount; i++) {
            const item = availableItems[i % availableItems.length];
            const quantity = Math.floor(Math.random() * 10) + 1;
            const price = Math.floor((targetAmount / itemCount) / quantity);

            items.push({
                name: item.name,
                quantity: quantity,
                unit: item.unit,
                price: price
            });
        }

        return items;
    }

    function populateOrderTimeline(order) {
        const timeline = document.getElementById('orderTimeline');
        const statuses = ['Order Placed', 'Payment Confirmed', 'Processing Started', 'Shipped', 'Delivered'];
        const currentStatusIndex = ['pending', 'processing', 'shipped', 'delivered'].indexOf(order.status);

        let timelineHTML = '';
        const baseDate = new Date(order.date);

        statuses.forEach((status, index) => {
            if (index <= currentStatusIndex + 1) {
                const statusDate = new Date(baseDate);
                statusDate.setHours(statusDate.getHours() + (index * 6));

                timelineHTML += `
                    <div class="timeline-item">
                        <span class="timeline-date">${statusDate.toLocaleDateString('en-US', {
                            month: 'short',
                            day: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        })}</span>
                        <span class="timeline-status">${status}</span>
                    </div>
                `;
            }
        });

        timeline.innerHTML = timelineHTML;
    }

    function getExpectedDeliveryDate(orderDate, status) {
        const date = new Date(orderDate);
        const daysToAdd = status === 'delivered' ? 0 : Math.floor(Math.random() * 5) + 1;
        date.setDate(date.getDate() + daysToAdd);

        return date.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    }

    function closeModal(event) {
        if (event && event.target !== event.currentTarget) return;
        document.getElementById('orderModal').classList.remove('active');
        document.body.style.overflow = 'auto';
    }
    function closeUpdateModal(event) {
        if (event && event.target !== event.currentTarget) return;
        document.getElementById('updateStatusModal').classList.remove('active');
        document.body.style.overflow = 'auto';
    }


    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeModal();
        }
    });
    </script>
</body>
</html>
