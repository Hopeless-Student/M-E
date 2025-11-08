<?php
 require_once __DIR__ . '/../../auth/admin_auth.php';
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders - M & E Dashboard</title>
    <link rel="icon" type="image/x-icon" href="../../assets/images/M&E_LOGO-semi-transparent.ico">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js?v=<?php echo time(); ?>"></script>
    <link rel="stylesheet" href="../assets/css/admin/orders/index.css?v=<?php echo time(); ?>">
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
                    <span><?= htmlspecialchars($_SESSION['admin_username'] ?? 'Admin') ?></span>
                    <div class="avatar"><?= htmlspecialchars(strtoupper(substr($_SESSION['admin_username'] ?? 'A', 0, 1))) ?></div>
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
                        <div class="stat-title">confirmed</div>
                        <i data-lucide="circle-dot-dashed" class="stat-icon"></i>
                    </div>
                    <div class="stat-value" id="totalconfirmed">0</div>
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
                        <option value="confirmed">confirmed</option>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
                    </select>
                    <select class="filter-select" id="categoryFilter">
                        <option value="">All Categories</option>
                        <option value="School Supplies">School Supplies</option>
                        <option value="Sanitary">Sanitary Supplies</option>
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

    <!-- Delete Confirmation Modal -->
    <div class="delete-modal" id="deleteModal" onclick="closeDeleteModal(event)">
    <div class="delete-modal-content" onclick="event.stopPropagation()">
        <div class="delete-modal-header">
            <div class="delete-icon-wrapper">
                <i data-lucide="alert-triangle"></i>
            </div>
            <div class="delete-modal-title">
                <h3>Delete Order</h3>
                <p id="deleteModalSubtitle">This action cannot be undone</p>
            </div>
        </div>

        <div class="delete-modal-body">
            <!-- Warning section - Initially hidden -->
            <div class="delete-warning" id="deleteWarning" style="display: none;">
                <p>
                    <i data-lucide="alert-circle"></i>
                    <strong>Warning:</strong> You are about to permanently delete this order. This action is irreversible.
                </p>
            </div>

            <div class="delete-order-info">
                <div class="delete-info-row">
                    <span class="delete-info-label">Order ID:</span>
                    <span class="delete-info-value" id="deleteOrderId">-</span>
                </div>
                <div class="delete-info-row">
                    <span class="delete-info-label">Customer:</span>
                    <span class="delete-info-value" id="deleteCustomerName">-</span>
                </div>
                <div class="delete-info-row">
                    <span class="delete-info-label">Amount:</span>
                    <span class="delete-info-value" id="deleteOrderAmount">-</span>
                </div>
                <div class="delete-info-row">
                    <span class="delete-info-label">Status:</span>
                    <span class="delete-info-value" id="deleteOrderStatus">-</span>
                </div>
            </div>
        </div>

        <div class="delete-modal-actions">
            <button class="delete-btn-cancel" onclick="closeDeleteModal()">
                <i data-lucide="x"></i>
                Cancel
            </button>
            <!-- First delete button -->
            <button class="delete-btn-confirm" id="firstDeleteBtn" onclick="showDeleteWarning()">
                <i data-lucide="trash-2"></i>
                Delete Order
            </button>
            <!-- Final confirm button - Initially hidden -->
            <button class="delete-btn-confirm delete-btn-final" id="finalDeleteBtn" style="display: none;" onclick="confirmDelete()">
                <i data-lucide="trash-2"></i>
                Confirm Delete
            </button>
        </div>
    </div>
</div>


    <script>
    lucide.createIcons();

    // Global variables for pagination and data
    let currentPage = 1;
    let totalPages = 1;
    let allOrders = [];
    let filteredOrders = [];
    let apiTotal = 0;
    const ordersPerPage = 8;
    let searchTimeout = null;

    // Load orders data on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadOrdersData();
        updateStats();
    });

    function updateStats() {
        const pending = filteredOrders.filter(o => o.status === 'pending').length;
        const confirmed = filteredOrders.filter(o => o.status === 'confirmed').length;
        const shipped = filteredOrders.filter(o => o.status === 'shipped').length;
        const delivered = filteredOrders.filter(o => o.status === 'delivered').length;

        document.getElementById('totalPending').textContent = pending;
        document.getElementById('totalconfirmed').textContent = confirmed;
        document.getElementById('totalShipped').textContent = shipped;
        document.getElementById('totalDeliver').textContent = delivered;
    }

    async function loadOrdersData() {
        try {
            const searchTerm = document.getElementById('searchInput').value.trim();
            const statusFilter = document.getElementById('statusFilter').value;
            const categoryFilter = document.getElementById('categoryFilter').value;

            const params = new URLSearchParams({
                page: String(currentPage),
                pageSize: String(ordersPerPage)
            });
            if (statusFilter) params.set('status', statusFilter);
            if (searchTerm) params.set('q', searchTerm);

            const response = await fetch(`../../api/orders/list.php?${params.toString()}`, {
                headers: { 'Accept': 'application/json' }
            });
            if (!response.ok) throw new Error('Network response was not ok');
            const result = await response.json();

            const items = Array.isArray(result.items) ? result.items : [];
            allOrders = items.map(o => ({
                id: String(o.order_id),
                customer: o.customer_name || '',
                email: o.email || '',
                category: o.category || '',
                items: Number(o.item_count || 0),
                amount: String((o.final_amount ?? o.total_amount ?? 0)),
                date: o.order_date ? new Date(o.order_date).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' }) : '',
                status: (o.order_status || '').toLowerCase(),
                _raw: o
            }));

            filteredOrders = categoryFilter
                ? allOrders.filter(o => (o.category || '').toLowerCase() === categoryFilter.toLowerCase())
                : [...allOrders];

            apiTotal = Number(result.total || 0);
            totalPages = Number(result.totalPages || Math.max(1, Math.ceil(apiTotal / ordersPerPage)));

            renderOrders();
            renderPagination();
            updateStats();
        } catch (error) {
            console.error('Error loading orders:', error);
            showError('Error loading orders data.');
        }
    }

    function renderOrders() {
        const tbody = document.querySelector('.orders-table tbody');
        const pageOrders = filteredOrders;

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
                    <button class="action-btn-icon secondary" onclick="openOrderModal('${order.id}')" title="View Order">
                        <i data-lucide="eye"></i>
                    </button>
                    ${order.status === 'delivered'
                        ? `<button class="action-btn-icon primary" disabled style="opacity: 0.5; cursor: not-allowed;" title="Cannot update delivered orders">
                            <i data-lucide="refresh-cw"></i>
                           </button>`
                        : `<button class="action-btn-icon primary" onclick="openUpdateModal('${order.id}')" title="Update Status">
                            <i data-lucide="refresh-cw"></i>
                           </button>`
                    }
                    <button class="action-btn-icon danger" onclick="openDeleteModal('${order.id}')" title="Delete Order">
                        <i data-lucide="trash-2"></i>
                    </button>
                    </div>
                </td>
            </tr>
        `).join('');
        lucide.createIcons();
    }

    function renderPagination() {
        const paginationInfo = document.querySelector('.pagination-info');
        const paginationControls = document.querySelector('.pagination-controls');

        if (apiTotal === 0) {
            paginationInfo.textContent = 'Showing 0-0 of 0 orders';
        } else {
            const startItem = ((currentPage - 1) * ordersPerPage) + 1;
            const endItem = Math.min(currentPage * ordersPerPage, apiTotal);
            paginationInfo.textContent = `Showing ${startItem}-${endItem} of ${apiTotal} orders`;
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
        loadOrdersData();
    }

    function applyFilters() {
        currentPage = 1;
        loadOrdersData();
    }

    // Search with debounce
    document.getElementById('searchInput').addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(applyFilters, 500);
    });

    document.getElementById('statusFilter').addEventListener('change', applyFilters);
    document.getElementById('categoryFilter').addEventListener('change', applyFilters);

    function showError(message) {
        const tbody = document.querySelector('.orders-table tbody');
        tbody.innerHTML = `<tr><td colspan="8" class="error" style="text-align: center; padding: 2rem; color: #dc2626;">${message}</td></tr>`;
    }

    // Modal Functions
    async function openOrderModal(orderId) {
      try {
        const response = await fetch(`../../api/orders/show.php?id=${encodeURIComponent(orderId)}`, { headers: { 'Accept': 'application/json' } });
        if (!response.ok) throw new Error('Failed to load order');
        const data = await response.json();

        const order = data.order || {};
        const items = Array.isArray(data.items) ? data.items : [];

        // Parse dates properly
        const orderDate = order.order_date ? new Date(order.order_date) : new Date();
        const confirmedDate = order.confirmed_at ? new Date(order.confirmed_at) : null;
        const deliveredDate = order.delivered_at ? new Date(order.delivered_at) : null;

        populateModalData({
          id: String(order.order_id || orderId),
          customer: order.customer_name || '',
          category: order.category || '',
          items: items.length,
          amount: String(order.final_amount ?? order.total_amount ?? 0),
          date: orderDate.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' }),
          rawDate: orderDate, // Keep raw date for calculations
          status: (order.order_status || '').toLowerCase(),
          email: order.email || '',
          phone: order.contact_number || '',
          company: '',
          address: order.delivery_address || '',
          paymentMethod: order.payment_method || '',
          transactionId: order.transaction_id || '',
          notes: order.admin_notes || '',
          confirmedAt: confirmedDate,
          deliveredAt: deliveredDate,
          _items: items
        });

        document.getElementById('orderModal').classList.add('active');
        document.body.style.overflow = 'hidden';

        const updtbtn = document.getElementById("updateModalBtn");
        if(updtbtn){
          if (order.order_status && order.order_status.toLowerCase() === 'delivered') {
            updtbtn.disabled = true;
            updtbtn.style.opacity = '0.5';
            updtbtn.style.cursor = 'not-allowed';
            updtbtn.onclick = (e) => {
              e.preventDefault();
              showAlert('Cannot update status of delivered orders', 'warning');
            };
          } else {
            updtbtn.disabled = false;
            updtbtn.style.opacity = '1';
            updtbtn.style.cursor = 'pointer';
            updtbtn.onclick = () => openUpdateModal(String(order.order_id || orderId));
          }
        }

        const dltbtn = document.getElementById("deleteModalBtn");
        if(dltbtn){
          if (order.order_status && order.order_status.toLowerCase() === 'delivered') {
            dltbtn.disabled = true;
            dltbtn.style.opacity = '0.5';
            dltbtn.style.cursor = 'not-allowed';
            dltbtn.onclick = (e) => {
              e.preventDefault();
              showAlert('Cannot delete delivered orders', 'warning');
            };
          } else {
            dltbtn.disabled = false;
            dltbtn.style.opacity = '1';
            dltbtn.style.cursor = 'pointer';
            dltbtn.onclick = () => openDeleteModal(String(order.order_id || orderId));
          }
        }

        setTimeout(() => {
          lucide.createIcons();
        }, 100);
      } catch (e) {
        console.error(e);
        showError('Failed to load order details.');
      }
    }

    let currentUpdateOrderId = null;
    function openUpdateModal(orderId) {
      const order = allOrders.find(o => o.id === orderId) || filteredOrders.find(o => o.id === orderId) || { id: orderId };

      if (order.status === 'delivered') {
        showAlert('Cannot update status of delivered orders', 'warning');
        return;
      }

      currentUpdateOrderId = orderId;
      populateUpdateData(order);

      const orderModal = document.getElementById("orderModal");
      if (orderModal) orderModal.classList.remove("active");

      const updateModal = document.getElementById("updateStatusModal");
      if (updateModal) updateModal.classList.add("active");

      document.body.style.overflow = "hidden";

      setTimeout(() => {
        lucide.createIcons();
      }, 100);
    }

    async function submitStatusUpdate() {
      if (!currentUpdateOrderId) return;
      const selected = document.querySelector('input[name="orderStatus"]:checked');
      if (!selected) {
        showAlert('Please select a new status', 'warning');
        return;
      }

      const notes = document.getElementById('updateStatusNotes').value.trim();

      try {
        const payload = {
          order_id: Number(currentUpdateOrderId),
          order_status: selected.value,
          admin_notes: notes || null
        };

        const res = await fetch('../../api/orders/update-status.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
          body: JSON.stringify(payload)
        });

        if (!res.ok) throw new Error('Failed to update status');

        const idx = allOrders.findIndex(o => o.id === String(currentUpdateOrderId));
        if (idx !== -1) allOrders[idx].status = selected.value;

        applyFilters();
        updateStats();

        showAlert('Order updated successfully!', 'success');

        const modal = document.getElementById("updateStatusModal");
        if (modal) modal.classList.remove("active");
        document.body.style.overflow = '';

      } catch (e) {
        console.error(e);
        showAlert('Failed to update order status', 'error');
      }
    }

    function populateModalData(order) {
        document.getElementById('modalOrderId').textContent = `#ORD-${order.id}`;
        document.getElementById('detailOrderId').textContent = `#ORD-${order.id}`;
        document.getElementById('detailCustomer').textContent = order.customer;
        document.getElementById('detailCategory').textContent = order.category;
        document.getElementById('detailAmount').textContent = `₱${parseInt(order.amount).toLocaleString()}`;
        document.getElementById('detailDate').textContent = order.date;

        const statusElement = document.getElementById('detailStatus');
        statusElement.textContent = order.status.charAt(0).toUpperCase() + order.status.slice(1);
        statusElement.className = `status ${order.status}`;

        document.getElementById('customerName').textContent = order.customer;
        document.getElementById('customerEmail').textContent = order.email;
        document.getElementById('customerPhone').textContent = order.phone;
        document.getElementById('customerCompany').textContent = order.company || 'N/A';
        document.getElementById('customerSince').textContent = 'January 2024';

        document.getElementById('deliveryAddress').innerHTML = order.address.replace(/,\s*/g, '<br>');
        document.getElementById('deliveryMethod').textContent = 'Standard Delivery';

        // Use consistent expected delivery calculation
        document.getElementById('expectedDelivery').textContent = getExpectedDeliveryDate(order.rawDate || order.date, order.status);
        document.getElementById('trackingNumber').textContent = order.trackingNumber || 'N/A';

        document.getElementById('paymentMethod').textContent = order.paymentMethod;
        const paymentStatusElement = document.getElementById('paymentStatus');
        paymentStatusElement.textContent = 'Paid';
        paymentStatusElement.className = 'status delivered';
        document.getElementById('transactionId').textContent = order.transactionId || 'N/A';
        document.getElementById('paymentDate').textContent = order.date;

        populateOrderItems(order);
        populateOrderTimeline(order);
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

        // Set minimum date to today for estimated delivery
        const today = new Date().toISOString().split('T')[0];
        const deliveryInput = document.getElementById('updateEstimatedDelivery');
        if (deliveryInput) {
            deliveryInput.min = today;
            deliveryInput.value = ''; // Clear previous value
        }

        // Clear tracking number
        const trackingInput = document.getElementById('updateTrackingNumber');
        if (trackingInput) {
            trackingInput.value = '';
        }

        // Clear notes
        const notesInput = document.getElementById('updateStatusNotes');
        if (notesInput) {
            notesInput.value = '';
        }

        // Pre-select current status
        const statusRadio = document.querySelector(`input[name="orderStatus"][value="${order.status}"]`);
        if (statusRadio) {
            statusRadio.checked = true;
        }

        // Clear any validation errors
        const errorMsg = document.getElementById('deliveryDateError');
        if (errorMsg) {
            errorMsg.style.display = 'none';
        }
        if (deliveryInput) {
            deliveryInput.classList.remove('error');
        }
    }

    function populateOrderItems(order) {
        const itemsContainer = document.getElementById('orderItems');
        const apiItems = Array.isArray(order._items) ? order._items : [];

        let itemsHTML = '';
        let total = 0;

        apiItems.forEach(item => {
            const name = item.product_name || `#${item.product_id}`;
            const quantity = Number(item.quantity || 0);
            const price = Number(item.product_price || 0);
            const subtotal = Number(item.subtotal != null ? item.subtotal : (quantity * price));
            total += subtotal;

            itemsHTML += `
                <tr>
                    <td>${name}</td>
                    <td>${quantity}</td>
                    <td>₱${price.toLocaleString()}</td>
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

    function populateOrderTimeline(order) {
        const timeline = document.getElementById('orderTimeline');
        const statusMap = {
            'pending': 0,
            'confirmed': 1,
            'shipped': 2,
            'delivered': 3
        };

        const timelineSteps = [
            { label: 'Order Placed', status: 'pending', hours: 0 },
            { label: 'Payment Confirmed', status: 'confirmed', hours: 2 },
            { label: 'Processing Started', status: 'confirmed', hours: 6 },
            { label: 'Shipped', status: 'shipped', hours: 24 },
            { label: 'Delivered', status: 'delivered', hours: 72 }
        ];

        const currentStatusLevel = statusMap[order.status] || 0;
        let timelineHTML = '';
        const baseDate = new Date(order.date);

        timelineSteps.forEach((step, index) => {
            const stepStatusLevel = statusMap[step.status] || 0;

            // Show step if it's at or before current status level
            if (stepStatusLevel <= currentStatusLevel) {
                const statusDate = new Date(baseDate);
                statusDate.setHours(statusDate.getHours() + step.hours);

                timelineHTML += `
                    <div class="timeline-item">
                        <span class="timeline-date">${statusDate.toLocaleDateString('en-US', {
                            month: 'short',
                            day: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        })}</span>
                        <span class="timeline-status">${step.label}</span>
                    </div>
                `;
            }
        });

        timeline.innerHTML = timelineHTML || '<div class="timeline-item"><span class="timeline-status">No timeline available</span></div>';
    }

    function getExpectedDeliveryDate(orderDate, status) {
        const date = new Date(orderDate);

        // Calculate days based on status
        let daysToAdd;
        switch(status.toLowerCase()) {
            case 'pending':
                daysToAdd = 7; // 7 days from order
                break;
            case 'confirmed':
                daysToAdd = 5; // 5 days from order
                break;
            case 'shipped':
                daysToAdd = 2; // 2 days from order
                break;
            case 'delivered':
                daysToAdd = 0; // Already delivered
                break;
            default:
                daysToAdd = 7;
        }

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

    // Delete Modal Functions
    let orderToDelete = null;
    let deleteConfirmationStep = 1;

    function openDeleteModal(orderId) {
        const order = allOrders.find(o => o.id === orderId) || filteredOrders.find(o => o.id === orderId);
        if (!order) {
            showAlert('Order not found', 'error');
            return;
        }

        if (order.status === 'delivered') {
            showAlert('Cannot delete delivered orders', 'warning');
            return;
        }

        orderToDelete = orderId;
        deleteConfirmationStep = 1;

        document.getElementById('deleteWarning').style.display = 'none';
        document.getElementById('firstDeleteBtn').style.display = 'inline-flex';
        document.getElementById('finalDeleteBtn').style.display = 'none';
        document.getElementById('deleteModalSubtitle').textContent = 'This action cannot be undone';

        document.getElementById('deleteOrderId').textContent = `#ORD-${order.id}`;
        document.getElementById('deleteCustomerName').textContent = order.customer;
        document.getElementById('deleteOrderAmount').textContent = `₱${parseInt(order.amount).toLocaleString()}`;
        document.getElementById('deleteOrderStatus').textContent = order.status.charAt(0).toUpperCase() + order.status.slice(1);

        // Close order modal if open
        const orderModal = document.getElementById('orderModal');
        if (orderModal) orderModal.classList.remove('active');

        document.getElementById('deleteModal').classList.add('active');
        document.body.style.overflow = 'hidden';

        setTimeout(() => {
            lucide.createIcons();
        }, 100);
    }

    function closeDeleteModal(event) {
        if (event && event.target !== event.currentTarget) return;

        document.getElementById('deleteWarning').style.display = 'none';
        document.getElementById('firstDeleteBtn').style.display = 'inline-flex';
        document.getElementById('finalDeleteBtn').style.display = 'none';
        document.getElementById('deleteModalSubtitle').textContent = 'This action cannot be undone';

        document.getElementById('deleteModal').classList.remove('active');
        document.body.style.overflow = 'auto';
        orderToDelete = null;
        deleteConfirmationStep = 1;
    }

    function showDeleteWarning() {
        deleteConfirmationStep = 2;
        document.getElementById('deleteWarning').style.display = 'block';
        document.getElementById('firstDeleteBtn').style.display = 'none';
        document.getElementById('finalDeleteBtn').style.display = 'inline-flex';
        document.getElementById('deleteModalSubtitle').textContent = 'Are you absolutely sure?';

        setTimeout(() => {
            lucide.createIcons();
        }, 100);
    }

    async function confirmDelete() {
        if (!orderToDelete || deleteConfirmationStep !== 2) return;

        try {
            const response = await fetch(`../../api/orders/delete.php?id=${encodeURIComponent(orderToDelete)}`, {
                method: 'DELETE',
                headers: { 'Accept': 'application/json' }
            });

            if (!response.ok) throw new Error('Failed to delete order');

            const result = await response.json();
            if (!result.success) throw new Error(result.error || 'Delete failed');

            // Remove from local arrays
            const index = allOrders.findIndex(o => o.id === orderToDelete);
            if (index !== -1) {
                allOrders.splice(index, 1);
            }

            applyFilters();
            updateStats();

            showAlert('Order deleted successfully!', 'success');
            closeDeleteModal();

        } catch (error) {
            console.error('Delete error:', error);
            showAlert('Failed to delete order: ' + error.message, 'error');
        }
    }

    // Alert notification system
    function showAlert(message, type = 'info') {
        const existingAlert = document.querySelector('.alert-notification');
        if (existingAlert) {
            existingAlert.remove();
        }

        const alert = document.createElement('div');
        alert.className = `alert-notification alert-${type}`;

        let icon = 'info';
        if (type === 'success') icon = 'check-circle';
        if (type === 'error') icon = 'alert-circle';
        if (type === 'warning') icon = 'alert-triangle';

        alert.innerHTML = `
            <div class="alert-content">
                <i data-lucide="${icon}"></i>
                <span>${message}</span>
            </div>
        `;

        document.body.appendChild(alert);
        lucide.createIcons();

        setTimeout(() => alert.classList.add('show'), 10);

        setTimeout(() => {
            alert.classList.remove('show');
            setTimeout(() => alert.remove(), 300);
        }, 3000);
    }


    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeModal();
            closeDeleteModal();
            closeUpdateModal();
        }
    });
    </script>
</body>
</html>
