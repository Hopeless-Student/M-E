<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers - M & E Dashboard</title>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <link rel="stylesheet" href="../assets/css/admin/users/index.css">
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
                <h2>Customer Management</h2>
                <div class="user-info">
                    <span>Admin Panel</span>
                    <div class="avatar">A</div>
                </div>
            </div>

            <!-- Customer Stats -->
            <div class="stats-grid">
                <div class="stat-card">
                  <div class="stat-header">
                    <div class="stat-title">Total Customers</div>
                    <i data-lucide="users" class="stat-icon"></i>
                  </div>
                    <div class="stat-value" id="totalCustomers">0</div>
                    <div class="stat-change neutral">Total registered customers</div>
                </div>
                <div class="stat-card">
                  <div class="stat-header">
                    <div class="stat-title">Active Customers</div>
                    <i data-lucide="user-round-check" class="stat-icon"></i>
                  </div>
                    <div class="stat-value" id="activeCustomers">0</div>
                    <div class="stat-change neutral">Customers with orders from the past 1–2 months</div>
                </div>
                <div class="stat-card">
                  <div class="stat-header">
                    <div class="stat-title">Inactive Customers</div>
                    <i data-lucide="user-round-minus" class="stat-icon"></i>
                  </div>
                    <div class="stat-value" id="inactiveCustomers">0</div>
                    <div class="stat-change neutral">Customers without orders from the past 1–2 months</div>
                </div>
                <div class="stat-card">
                  <div class="stat-header">
                    <div class="stat-title">New Customers</div>
                    <i data-lucide="user-plus" class="stat-icon"></i>
                  </div>
                    <div class="stat-value" id="newCustomers">0</div>
                    <div class="stat-change neutral">Registered within this month</div>
                </div>
            </div>

            <!-- Customer Controls -->
            <div class="customer-controls">
                <div class="search-filter">
                    <div class="search-box">
                        <i data-lucide="search" class="search-icon"></i>
                        <input type="text" placeholder="Search customers..." id="searchInput">
                    </div>
                    <select class="filter-select" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="new">New</option>
                    </select>
                    <select class="filter-select" id="locationFilter">
                        <option value="">All Locations</option>
                        <option value="Olongapo City">Olongapo City</option>
                        <option value="Subic Bay">Subic Bay</option>
                        <option value="Zambales">Zambales</option>
                    </select>
                </div>
                <button class="add-customer-btn" onclick="showAddCustomerModal()">+ Add Customer</button>
            </div>

            <!-- Customers Table -->
            <div class="customers-section">
                <div class="table-container">
                    <table class="customers-table">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Location</th>
                                <th>Orders</th>
                                <th>Total Spent</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Customers will be populated dynamically -->
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination">
                    <div class="pagination-info">
                        Showing 1-8 of 142 customers
                    </div>
                    <div class="pagination-controls">
                        <button class="page-btn" id="prevBtn">Previous</button>
                        <button class="page-btn active">1</button>
                        <button class="page-btn">2</button>
                        <button class="page-btn">3</button>
                        <button class="page-btn" id="nextBtn">Next</button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Add Customer Modal -->
    <div id="addCustomerModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Add New Customer</h3>
                <button class="close-btn" onclick="closeAddCustomerModal()">&times;</button>
            </div>
            <form id="addCustomerForm">
                <div class="form-group">
                    <label class="form-label">First Name *</label>
                    <input type="text" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Last Name *</label>
                    <input type="text" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Email Address *</label>
                    <input type="email" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Phone Number *</label>
                    <input type="tel" class="form-input" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Location</label>
                    <input type="text" class="form-input" placeholder="City, Province">
                </div>
                <div class="form-group">
                    <label class="form-label">Customer Type</label>
                    <select class="form-input">
                        <option value="regular">Regular</option>
                        <option value="vip">Company</option>
                        <option value="wholesale">Wholesale</option>
                    </select>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeAddCustomerModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Customer</button>
                </div>
            </form>
        </div>
    </div>
    <?php include './edit-user.php';
          include './user-details.php';
          include './user-orders.php';
          ?>
  <script>
  // Close customer details modal
function closeCustomerDetailsModal(event) {
    const modal = document.getElementById('customerDetailsModal');
    if (modal && (event === undefined || event.target === modal || event.target.closest('.customer-details-close-btn'))) {
        modal.classList.remove('show');
        document.body.style.overflow = 'auto';
    }
}

// Open customer orders modal
async function openCustomerOrdersModal(customerId) {
    const modal = document.getElementById('customerOrdersModal');
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';

    const modalBody = modal.querySelector('.customer-orders-modal-body');
    const loadingOverlay = showLoading(modalBody);

    try {
        const data = await apiRequest(`../../api/admin/customers/orders.php?id=${customerId}`);
        populateCustomerOrdersModal(data);

        const viewProfileBtn = modal.querySelector('#viewProfile');
        if (viewProfileBtn) {
            viewProfileBtn.onclick = () => {
                closeCustomerOrdersModal();
                openCustomerDetailsModal(customerId);
            };
        }

        const editCustomerBtn = modal.querySelector('#editCustomer');
        if (editCustomerBtn) {
            editCustomerBtn.onclick = () => {
                closeCustomerOrdersModal();
                openCustomerEditModal(customerId);
            };
        }
    } catch (error) {
        showToast('Error loading orders: ' + error.message, 'error');
        closeCustomerOrdersModal();
    } finally {
        hideLoading(loadingOverlay);
        lucide.createIcons();
    }
}

// Populate customer orders modal
function populateCustomerOrdersModal(data) {
    const modal = document.getElementById('customerOrdersModal');
    const customer = data.user;

    const nameParts = customer.name.split(' ');
    const firstName = nameParts[0] || '';
    const lastName = nameParts[nameParts.length - 1] || '';
    const avatar = (firstName.charAt(0) + lastName.charAt(0)).toUpperCase();

    modal.querySelector('.customer-orders-avatar-large').textContent = avatar;
    modal.querySelector('.customer-orders-modal-title h3').textContent = `${customer.name} - Orders`;
    modal.querySelector('.customer-orders-modal-title p').textContent = `Customer ID: #CUS-${String(customer.id).padStart(3, '0')} • Member since ${customer.memberSince}`;

    // Update order summary
    const summaryItems = modal.querySelectorAll('.customer-orders-summary-item');
    if (summaryItems[0]) {
        summaryItems[0].querySelector('.customer-orders-summary-value').textContent = data.statistics.completed.count;
        summaryItems[0].querySelector('.customer-orders-summary-label').textContent = `Completed (₱${data.statistics.completed.amount.toLocaleString()})`;
    }
    if (summaryItems[1]) {
        summaryItems[1].querySelector('.customer-orders-summary-value').textContent = data.statistics.pending.count;
        summaryItems[1].querySelector('.customer-orders-summary-label').textContent = `Pending (₱${data.statistics.pending.amount.toLocaleString()})`;
    }
    if (summaryItems[2]) {
        summaryItems[2].querySelector('.customer-orders-summary-value').textContent = data.statistics.processing.count;
        summaryItems[2].querySelector('.customer-orders-summary-label').textContent = `Processing (₱${data.statistics.processing.amount.toLocaleString()})`;
    }
    if (summaryItems[3]) {
        summaryItems[3].querySelector('.customer-orders-summary-value').textContent = data.statistics.cancelled.count;
        summaryItems[3].querySelector('.customer-orders-summary-label').textContent = `Cancelled (₱${data.statistics.cancelled.amount.toLocaleString()})`;
    }

    // Update orders table
    const ordersTableBody = modal.querySelector('.customer-orders-orders-table tbody');
    if (data.orders && data.orders.length > 0) {
        ordersTableBody.innerHTML = data.orders.map(order => `
            <tr>
                <td><a href="#" class="customer-orders-order-id">#${order.orderNumber}</a></td>
                <td>${order.orderDateFormatted}</td>
                <td>
                    <div class="customer-orders-order-items">
                        <div class="customer-orders-item-count">${order.itemCount} item${order.itemCount !== 1 ? 's' : ''}</div>
                        <div class="customer-orders-item-list">${order.itemNames}</div>
                    </div>
                </td>
                <td><span class="customer-orders-order-total">₱${order.finalAmount.toLocaleString()}</span></td>
                <td>${order.paymentMethod || 'N/A'}</td>
                <td><span class="customer-orders-order-status ${order.orderStatus.toLowerCase()}">${order.orderStatus}</span></td>
                <td><a href="#" class="customer-orders-action-btn">View</a></td>
            </tr>
        `).join('');
    } else {
        ordersTableBody.innerHTML = '<tr><td colspan="7" style="text-align: center; padding: 1rem;">No orders found</td></tr>';
    }

    // Update pagination info
    const paginationInfo = modal.querySelector('.customer-orders-pagination-info');
    const pagination = data.pagination;
    const startItem = ((pagination.page - 1) * pagination.pageSize) + 1;
    const endItem = Math.min(pagination.page * pagination.pageSize, pagination.total);
    paginationInfo.textContent = `Showing ${startItem}-${endItem} of ${pagination.total} orders`;
}

// Close customer orders modal
function closeCustomerOrdersModal(event) {
    const modal = document.getElementById('customerOrdersModal');
    if (modal && (event === undefined || event.target === modal || event.target.closest('.customer-orders-close-btn'))) {
        modal.classList.remove('show');
        document.body.style.overflow = 'auto';
    }
}

// Open customer edit modal
async function openCustomerEditModal(customerId) {
    const modal = document.getElementById('customerEditModal');
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';

    const modalBody = modal.querySelector('.customer-edit-modal-body');
    const loadingOverlay = showLoading(modalBody);

    try {
        const customer = await apiRequest(`../../api/admin/customers/get.php?id=${customerId}`);
        populateCustomerEditModal(customer);

        // Setup form submission
        const form = modal.querySelector('#editCustomerForm');
        form.onsubmit = (e) => handleCustomerUpdate(e, customerId);

        const viewOrdersBtn = modal.querySelector('#UserOrder');
        if (viewOrdersBtn) {
            viewOrdersBtn.onclick = () => {
                closeCustomerEditModal();
                openCustomerOrdersModal(customerId);
            };
        }
    } catch (error) {
        showToast('Error loading customer: ' + error.message, 'error');
        closeCustomerEditModal();
    } finally {
        hideLoading(loadingOverlay);
        lucide.createIcons();
    }
}

// Populate customer edit modal
function populateCustomerEditModal(customer) {
    const modal = document.getElementById('customerEditModal');

    const nameParts = customer.name.split(' ');
    const firstName = nameParts[0] || '';
    const lastName = nameParts[nameParts.length - 1] || '';
    const avatar = (firstName.charAt(0) + lastName.charAt(0)).toUpperCase();

    modal.querySelector('.customer-edit-avatar-large').textContent = avatar;
    modal.querySelector('.customer-edit-modal-title h3').textContent = `Edit Customer - ${customer.name}`;
    modal.querySelector('#customerEditID').textContent = `#CUS-${String(customer.id).padStart(3, '0')}`;

    // Update stats
    const stats = modal.querySelectorAll('.customer-edit-stat-value');
    if (stats[0]) stats[0].textContent = customer.statistics.totalOrders;
    if (stats[1]) stats[1].textContent = `₱${customer.statistics.totalSpent.toLocaleString()}`;
    if (stats[2]) stats[2].textContent = customer.memberSince;
    if (stats[3]) {
        const days = customer.statistics.daysSinceLastOrder;
        stats[3].textContent = days !== null ? `${days} day${days !== 1 ? 's' : ''} ago` : 'Never';
    }

    // Update customer info (read-only)
    const infoValues = modal.querySelectorAll('.customer-edit-info-display .customer-edit-info-value');
    if (infoValues[0]) infoValues[0].textContent = customer.name;
    if (infoValues[1]) infoValues[1].textContent = customer.email;
    if (infoValues[2]) infoValues[2].textContent = customer.contactNumber || 'N/A';
    if (infoValues[3]) infoValues[3].textContent = new Date(customer.createdAt).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
    if (infoValues[4]) infoValues[4].textContent = customer.location || 'N/A';
    if (infoValues[5]) infoValues[5].textContent = customer.updatedAt ? new Date(customer.updatedAt).toLocaleString('en-US') : 'N/A';

    // Populate admin settings if available
    if (customer.adminSettings) {
        const settings = customer.adminSettings;

        // Permissions checkboxes
        const checkboxes = {
            'allow_bulk_orders': settings.permissions.allowBulkOrders,
            'allow_credit_purchases': settings.permissions.allowCreditPurchases,
            'require_order_approval': settings.permissions.requireOrderApproval,
            'block_new_orders': settings.permissions.blockNewOrders,
            'receive_marketing_emails': settings.permissions.receiveMarketingEmails,
            'access_wholesale_prices': settings.permissions.accessWholesalePrices
        };

        Object.entries(checkboxes).forEach(([name, value]) => {
            const checkbox = modal.querySelector(`input[type="checkbox"][data-permission="${name}"]`);
            if (checkbox) checkbox.checked = value;
        });

        // Financial summary
        const financialValues = modal.querySelectorAll('.customer-edit-financial-value');
        if (financialValues[0]) financialValues[0].textContent = `₱${settings.outstandingBalance.toLocaleString()}`;
        if (financialValues[1]) financialValues[1].textContent = `₱${settings.availableCredit.toLocaleString()}`;
        if (financialValues[2]) financialValues[2].textContent = `₱${customer.statistics.totalSpent.toLocaleString()}`;

        // Admin notes
        const adminNotesTextarea = modal.querySelector('textarea[name="admin_notes"]');
        if (adminNotesTextarea) adminNotesTextarea.value = settings.adminNotes || '';
    }

    // Add data attributes for permissions checkboxes
    modal.querySelectorAll('.customer-edit-checkbox-item input[type="checkbox"]').forEach((checkbox, index) => {
        const permissions = ['allow_bulk_orders', 'allow_credit_purchases', 'require_order_approval', 'block_new_orders', 'receive_marketing_emails', 'access_wholesale_prices'];
        if (permissions[index]) {
            checkbox.setAttribute('data-permission', permissions[index]);
        }
    });

    // Sub-modal email field
    const emailSubModalInput = modal.querySelector('#emailModal .customer-edit-form-input[type="email"]');
    if (emailSubModalInput) emailSubModalInput.value = customer.email;

    // Sub-modal password reset email field
    const passwordSubModalInput = modal.querySelector('#passwordModal .customer-edit-form-input[type="email"]');
    if (passwordSubModalInput) passwordSubModalInput.value = customer.email;
}

// Handle customer update
async function handleCustomerUpdate(event, customerId) {
    event.preventDefault();

    const modal = document.getElementById('customerEditModal');
    const form = event.target;
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;

    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i data-lucide="loader" class="animate-spin"></i> Saving...';
    lucide.createIcons();

    try {
        // Collect form data
        const formData = {
            userId: customerId,
            adminNotes: form.querySelector('textarea[name="admin_notes"]')?.value || ''
        };

        // Collect permissions
        modal.querySelectorAll('input[type="checkbox"][data-permission]').forEach(checkbox => {
            const permission = checkbox.getAttribute('data-permission');
            const camelCase = permission.replace(/_([a-z])/g, (g) => g[1].toUpperCase());
            formData[camelCase] = checkbox.checked;
        });

        const result = await apiRequest('../../api/admin/customers/update.php', {
            method: 'POST',
            body: JSON.stringify(formData)
        });

        showToast('Customer updated successfully!', 'success');
        closeCustomerEditModal();
        loadCustomersData(); // Refresh the list

    } catch (error) {
        showToast('Error updating customer: ' + error.message, 'error');
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
        lucide.createIcons();
    }
}

// Close customer edit modal
function closeCustomerEditModal(event) {
    const modal = document.getElementById('customerEditModal');
    if (modal && (event === undefined || event.target === modal || event.target.closest('.customer-edit-close-btn'))) {
        modal.classList.remove('show');
        document.body.style.overflow = 'auto';
        const form = modal.querySelector('form');
        if (form) form.reset();
    }
}

// Show customer edit sub-modal
function showCustomerEditSubModal(modalId) {
    const subModal = document.getElementById(modalId);
    if (subModal) {
        subModal.classList.add('show');

        // Setup delete confirmation
        if (modalId === 'deleteModal') {
            const deleteForm = subModal.querySelector('#deleteForm');
            if (deleteForm) {
                deleteForm.onsubmit = handleCustomerDelete;
            }
        }
    }
}

// Close customer edit sub-modal
function closeCustomerEditSubModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('show');
        const form = modal.querySelector('form');
        if (form) form.reset();
    }
}

// Handle customer delete
async function handleCustomerDelete(event) {
    event.preventDefault();

    const form = event.target;
    const modal = document.getElementById('customerEditModal');
    const customerIdText = modal.querySelector('#customerEditID').textContent;
    const customerId = parseInt(customerIdText.replace(/[^0-9]/g, ''));

    const reasonSelect = form.querySelector('select');
    const confirmationInput = form.querySelector('input[type="text"]');
    const submitBtn = form.querySelector('button[type="submit"]');

    const reason = reasonSelect.value;
    const confirmation = confirmationInput.value;

    if (confirmation !== 'DELETE') {
        showToast('Please type DELETE to confirm', 'error');
        return;
    }

    const originalText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i data-lucide="loader" class="animate-spin"></i> Deleting...';
    lucide.createIcons();

    try {
        const result = await apiRequest('../../api/admin/customers/delete.php', {
            method: 'POST',
            body: JSON.stringify({
                userId: customerId,
                reason: reason,
                confirmation: confirmation
            })
        });

        showToast('Customer deactivated successfully!', 'success');
        closeCustomerEditSubModal('deleteModal');
        closeCustomerEditModal();
        loadCustomersData(); // Refresh the list

    } catch (error) {
        showToast('Error deleting customer: ' + error.message, 'error');
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
        lucide.createIcons();
    }
}

// Add customer modal functions
function showAddCustomerModal() {
    document.getElementById('addCustomerModal').classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeAddCustomerModal() {
    const modal = document.getElementById('addCustomerModal');
    if (modal) {
        modal.classList.remove('show');
        document.getElementById('addCustomerForm').reset();
        document.body.style.overflow = 'auto';
    }
}

// Setup modal click outside handlers
function setupModalClickOutside() {
    const modals = [
        'addCustomerModal',
        'customerDetailsModal',
        'customerOrdersModal',
        'customerEditModal',
        'emailModal',
        'reportModal',
        'passwordModal',
        'deleteModal'
    ];

    modals.forEach(modalId => {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    if (modalId === 'addCustomerModal') closeAddCustomerModal();
                    else if (modalId === 'customerDetailsModal') closeCustomerDetailsModal();
                    else if (modalId === 'customerOrdersModal') closeCustomerOrdersModal();
                    else if (modalId === 'customerEditModal') closeCustomerEditModal();
                    else closeCustomerEditSubModal(modalId);
                }
            });
        }
    });
}

// Add customer form submission
document.getElementById('addCustomerForm')?.addEventListener('submit', function(e) {
    e.preventDefault();

    showToast('Add customer functionality not yet implemented', 'error');
    // TODO: Implement add customer API endpoint and connect here
});

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const addModal = document.getElementById('addCustomerModal');
        if (addModal?.classList.contains('show')) {
            closeAddCustomerModal();
            return;
        }

        const detailsModal = document.getElementById('customerDetailsModal');
        if (detailsModal?.classList.contains('show')) {
            closeCustomerDetailsModal();
            return;
        }

        const ordersModal = document.getElementById('customerOrdersModal');
        if (ordersModal?.classList.contains('show')) {
            closeCustomerOrdersModal();
            return;
        }

        const editModal = document.getElementById('customerEditModal');
        if (editModal?.classList.contains('show')) {
            const subModals = editModal.querySelectorAll('.customer-edit-sub-modal.show');
            if (subModals.length > 0) {
                subModals.forEach(subModal => closeCustomerEditSubModal(subModal.id));
            } else {
                closeCustomerEditModal();
            }
            return;
        }
    }

    if (e.ctrlKey && e.key === 'k') {
        e.preventDefault();
        document.getElementById('searchInput')?.focus();
    }

    if (e.ctrlKey && e.key === 'n') {
        e.preventDefault();
        showAddCustomerModal();
    }
});

// Event listeners
document.getElementById('searchInput')?.addEventListener('input', applyFilters);
document.getElementById('statusFilter')?.addEventListener('change', applyFilters);
document.getElementById('locationFilter')?.addEventListener('change', applyFilters);

lucide.createIcons();

// Global variables
let currentPage = 1;
let totalPages = 1;
let allCustomers = [];
const customersPerPage = 8;

// Toast notification system
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'success' ? '#10b981' : '#ef4444'};
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        z-index: 10000;
        animation: slideIn 0.3s ease;
    `;
    toast.textContent = message;
    document.body.appendChild(toast);

    setTimeout(() => {
        toast.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Add CSS for animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from { transform: translateX(400px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(400px); opacity: 0; }
    }
    .loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255,255,255,0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 100;
    }
    .spinner {
        border: 3px solid #f3f3f3;
        border-top: 3px solid #1e40af;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
`;
document.head.appendChild(style);

// Loading indicator
function showLoading(element) {
    const overlay = document.createElement('div');
    overlay.className = 'loading-overlay';
    overlay.innerHTML = '<div class="spinner"></div>';
    element.style.position = 'relative';
    element.appendChild(overlay);
    return overlay;
}

function hideLoading(overlay) {
    if (overlay && overlay.parentNode) {
        overlay.remove();
    }
}

// API helper function
async function apiRequest(url, options = {}) {
    try {
        console.log('API Request:', url); // Debug log

        const response = await fetch(url, {
            ...options,
            headers: {
                'Content-Type': 'application/json',
                ...options.headers
            }
        });

        const text = await response.text();
        console.log('API Response Status:', response.status); // Debug log
        console.log('API Response Text:', text.substring(0, 200)); // Debug log

        let data;
        try {
            data = JSON.parse(text);
        } catch (parseError) {
            console.error('JSON Parse Error:', parseError);
            console.error('Full response:', text);
            throw new Error('Server returned invalid JSON: ' + text.substring(0, 100));
        }

        if (!response.ok) {
            // Create error with additional details
            const error = new Error(data.error || data.message || 'Request failed');
            error.details = data.sqlError || data.details || null;
            error.code = data.sqlCode || null;
            throw error;
        }

        return data;
    } catch (error) {
        console.error('API Error:', error);
        throw error;
    }
}

// Load customers data
async function loadCustomersData() {
    const tbody = document.querySelector('.customers-table tbody');
    const loadingOverlay = showLoading(tbody.closest('.table-container'));

    try {
        const q = document.getElementById('searchInput').value.trim();
        const status = document.getElementById('statusFilter').value;
        const location = document.getElementById('locationFilter').value;

        const params = new URLSearchParams({
            page: String(currentPage),
            pageSize: String(customersPerPage)
        });
        if (q) params.set('q', q);
        if (status) params.set('status', status);
        if (location) params.set('location', location);

        const result = await apiRequest(`../../api/admin/customers/list.php?${params.toString()}`);

        allCustomers = result.items || [];
        totalPages = result.totalPages || 1;

        renderCustomers();
        renderPagination();
        updateStats();
    } catch (error) {
        showToast('Error loading customers: ' + error.message, 'error');
        tbody.innerHTML = '<tr><td colspan="8" style="text-align: center; padding: 2rem; color: #dc2626;">Failed to load customers</td></tr>';
    } finally {
        hideLoading(loadingOverlay);
    }
}

// Update statistics
function updateStats() {
    const total = allCustomers.length;
    const active = allCustomers.filter(c => c.status === 'active').length;
    const inactive = allCustomers.filter(c => c.status === 'inactive').length;
    const newCustomers = allCustomers.filter(c => c.status === 'new').length;

    document.getElementById('totalCustomers').textContent = total;
    document.getElementById('activeCustomers').textContent = active;
    document.getElementById('inactiveCustomers').textContent = inactive;
    document.getElementById('newCustomers').textContent = newCustomers;
}

// Render customers table
function renderCustomers() {
    const tbody = document.querySelector('.customers-table tbody');

    if (allCustomers.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" style="text-align: center; padding: 2rem;">No customers found</td></tr>';
        return;
    }

    tbody.innerHTML = allCustomers.map(customer => {
        const nameParts = customer.name.split(' ');
        const firstName = nameParts[0] || '';
        const lastName = nameParts[nameParts.length - 1] || '';
        const avatar = (firstName.charAt(0) + lastName.charAt(0)).toUpperCase();

        return `
            <tr>
                <td>
                    <div class="customer-info">
                        <div class="customer-avatar">${avatar}</div>
                        <div class="customer-details">
                            <h4>${customer.name}</h4>
                            <p>Member since ${customer.memberSince}</p>
                        </div>
                    </div>
                </td>
                <td>${customer.email}</td>
                <td>${customer.contactNumber || 'N/A'}</td>
                <td>${customer.location || 'N/A'}</td>
                <td>${customer.totalOrders}</td>
                <td><strong>₱${customer.totalSpent.toLocaleString()}</strong></td>
                <td><span class="status-badge ${customer.status}">${customer.status.charAt(0).toUpperCase() + customer.status.slice(1)}</span></td>
                <td>
                    <div class="actions">
                        <button class="action-btn-icon secondary" onclick="openCustomerDetailsModal(${customer.id})" title="View">
                            <i data-lucide="eye"></i>
                        </button>
                        <button class="action-btn-icon orders" onclick="openCustomerOrdersModal(${customer.id})" title="Orders">
                            <i data-lucide="package"></i>
                        </button>
                        <button class="action-btn-icon secondary" onclick="openCustomerEditModal(${customer.id})" title="Edit">
                            <i data-lucide="user-pen"></i>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    }).join('');

    lucide.createIcons();
}

// Render pagination
function renderPagination() {
    const paginationInfo = document.querySelector('.pagination-info');
    const paginationControls = document.querySelector('.pagination-controls');

    const startItem = ((currentPage - 1) * customersPerPage) + 1;
    const endItem = Math.min(currentPage * customersPerPage, allCustomers.length);

    paginationInfo.textContent = `Showing ${startItem}-${endItem} of ${allCustomers.length} customers`;

    let buttonsHTML = '<button class="page-btn" id="prevBtn">Previous</button>';

    for (let i = 1; i <= totalPages; i++) {
        if (totalPages <= 7 || i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
            buttonsHTML += `<button class="page-btn ${i === currentPage ? 'active' : ''}" data-page="${i}">${i}</button>`;
        } else if (i === currentPage - 2 || i === currentPage + 2) {
            buttonsHTML += '<span style="padding: 0 0.5rem;">...</span>';
        }
    }

    buttonsHTML += '<button class="page-btn" id="nextBtn">Next</button>';
    paginationControls.innerHTML = buttonsHTML;

    document.getElementById('prevBtn').onclick = () => goToPage(currentPage - 1);
    document.getElementById('nextBtn').onclick = () => goToPage(currentPage + 1);

    document.querySelectorAll('[data-page]').forEach(btn => {
        btn.onclick = () => goToPage(parseInt(btn.dataset.page));
    });
}

// Go to page
function goToPage(page) {
    if (page < 1 || page > totalPages) return;
    currentPage = page;
    loadCustomersData();
}

// Apply filters
function applyFilters() {
    currentPage = 1;
    loadCustomersData();
}

// Open customer details modal
async function openCustomerDetailsModal(customerId) {
    const modal = document.getElementById('customerDetailsModal');
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';

    const modalBody = modal.querySelector('.customer-details-modal-body');
    const loadingOverlay = showLoading(modalBody);

    try {
        const customer = await apiRequest(`../../api/admin/customers/get.php?id=${customerId}`);

        // Only populate if we got valid data
        if (customer) {
            populateCustomerDetailsModal(customer);

            const viewOrdersBtn = modal.querySelector('#viewOrders');
            if (viewOrdersBtn) {
                viewOrdersBtn.onclick = () => {
                    closeCustomerDetailsModal();
                    openCustomerOrdersModal(customerId);
                };
            }

            const editUserBtn = modal.querySelector('#editUser');
            if (editUserBtn) {
                editUserBtn.onclick = () => {
                    closeCustomerDetailsModal();
                    openCustomerEditModal(customerId);
                };
            }
        }
    } catch (error) {
        console.error('Customer details error:', error); // Add logging

        // Show detailed error if available
        let errorMessage = 'Error loading customer details: ' + error.message;
        if (error.details) {
            console.error('Error details:', error.details);
            errorMessage += '\n\nDetails: ' + error.details;
        }

        showToast(errorMessage, 'error');
        closeCustomerDetailsModal();
    } finally {
        // Only hide loading if overlay still exists
        if (loadingOverlay && loadingOverlay.parentNode) {
            hideLoading(loadingOverlay);
        }
        lucide.createIcons();
    }
}
// Populate customer details modal
function populateCustomerDetailsModal(customer) {
    const modal = document.getElementById('customerDetailsModal');

    const nameParts = customer.name.split(' ');
    const firstName = nameParts[0] || '';
    const lastName = nameParts[nameParts.length - 1] || '';
    const avatar = (firstName.charAt(0) + lastName.charAt(0)).toUpperCase();

    modal.querySelector('.customer-details-avatar-large').textContent = avatar;
    modal.querySelector('.customer-details-modal-title h3').textContent = customer.name;
    modal.querySelector('.customer-details-modal-title p').textContent = `Customer ID: #CUS-${String(customer.id).padStart(3, '0')}`;

    // Update stats
    const stats = modal.querySelectorAll('.customer-details-stat-value');
    if (stats[0]) stats[0].textContent = customer.statistics.totalOrders;
    if (stats[1]) stats[1].textContent = `₱${customer.statistics.totalSpent.toLocaleString()}`;
    if (stats[2]) stats[2].textContent = `₱${Math.round(customer.statistics.averageOrder).toLocaleString()}`;
    if (stats[3]) {
        const days = customer.statistics.daysSinceLastOrder;
        stats[3].textContent = days !== null ? `${days} day${days !== 1 ? 's' : ''}` : 'Never';
    }

    // Update personal info
    const personalInfoRows = modal.querySelectorAll('.customer-details-info-section:nth-of-type(1) .customer-details-info-row');
    if (personalInfoRows[0]) personalInfoRows[0].querySelector('.customer-details-info-value').textContent = customer.name;
    if (personalInfoRows[1]) personalInfoRows[1].querySelector('.customer-details-info-value').textContent = customer.email;
    if (personalInfoRows[2]) personalInfoRows[2].querySelector('.customer-details-info-value').textContent = customer.contactNumber || 'N/A';
    if (personalInfoRows[3]) personalInfoRows[3].querySelector('.customer-details-info-value').textContent = customer.dateOfBirth || 'N/A';
    if (personalInfoRows[4]) personalInfoRows[4].querySelector('.customer-details-info-value').textContent = customer.gender || 'N/A';
    if (personalInfoRows[5]) personalInfoRows[5].querySelector('.customer-details-info-value').textContent = customer.memberSince;

    // Update address info
    const addressInfoRows = modal.querySelectorAll('.customer-details-info-section:nth-of-type(2) .customer-details-info-row');
    if (addressInfoRows[0]) addressInfoRows[0].querySelector('.customer-details-info-value').textContent = customer.address || 'N/A';
    if (addressInfoRows[1]) addressInfoRows[1].querySelector('.customer-details-info-value').textContent = customer.cityName || 'N/A';
    if (addressInfoRows[2]) addressInfoRows[2].querySelector('.customer-details-info-value').textContent = customer.provinceName || 'N/A';
    if (addressInfoRows[3]) addressInfoRows[3].querySelector('.customer-details-info-value').textContent = 'N/A'; // Postal code not in API
    if (addressInfoRows[4]) addressInfoRows[4].querySelector('.customer-details-info-value').textContent = 'Philippines';
    if (addressInfoRows[5]) {
        const statusBadge = addressInfoRows[5].querySelector('.customer-details-status-badge');
        statusBadge.textContent = customer.status.charAt(0).toUpperCase() + customer.status.slice(1) + ' Customer';
        statusBadge.className = `customer-details-status-badge ${customer.status}`;
    }

    // Update recent orders
    const ordersTableBody = modal.querySelector('.customer-details-orders-table tbody');
    if (customer.recentOrders && customer.recentOrders.length > 0) {
        ordersTableBody.innerHTML = customer.recentOrders.map(order => `
            <tr>
                <td><a href="#" class="customer-details-order-id">#${order.orderNumber}</a></td>
                <td>${order.orderDateFormatted}</td>
                <td>${order.itemCount} item${order.itemCount !== 1 ? 's' : ''}</td>
                <td><strong>₱${order.finalAmount.toLocaleString()}</strong></td>
                <td><span class="customer-details-order-status ${order.orderStatus.toLowerCase()}">${order.orderStatus}</span></td>
            </tr>
        `).join('');
    } else {
        ordersTableBody.innerHTML = '<tr><td colspan="5" style="text-align: center; padding: 1rem;">No orders found</td></tr>';
    }

    // Update activity timeline
    const timelineContainer = modal.querySelector('.customer-details-activity-timeline .customer-details-info-section');
    const existingItems = timelineContainer.querySelectorAll('.customer-details-timeline-item');
    existingItems.forEach(item => item.remove());

    if (customer.activities && customer.activities.length > 0) {
        customer.activities.forEach(activity => {
            const item = document.createElement('div');
            item.className = 'customer-details-timeline-item';
            item.innerHTML = `
                <div class="customer-details-timeline-content">
                    <div class="customer-details-timeline-title">${formatActivityTitle(activity.type)}</div>
                    <div class="customer-details-timeline-desc">${activity.description}</div>
                    <div class="customer-details-timeline-time">${activity.timeAgo}</div>
                </div>
            `;
            timelineContainer.appendChild(item);
        });
    }
}

// Format activity title
function formatActivityTitle(type) {
    const titles = {
        'order_completed': 'Order Completed',
        'order_confirmed': 'Order Confirmed',
        'order_placed': 'Order Placed',
        'profile_updated': 'Profile Updated',
        'request_submitted': 'Request Submitted'
    };
    return titles[type] || type;
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    loadCustomersData();
    setupModalClickOutside();
    lucide.createIcons();
});

  </script>
</body>
</html>
