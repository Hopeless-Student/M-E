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
        lucide.createIcons();

        // Global variables for pagination and data management
        let currentPage = 1;
        let totalPages = 1;
        let allCustomers = [];
        let filteredCustomers = [];
        const customersPerPage = 8;

        // Load customers data on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadCustomersData();
            updateStats();
            setupModalClickOutside(); // Call this once on DOMContentLoaded
        });

        function updateStats() {
            // Calculate stats from all customers
            const total = allCustomers.length;
            const active = allCustomers.filter(c => c.status === 'active').length;
            const inactive = allCustomers.filter(c => c.status === 'inactive').length;
            const newCustomers = allCustomers.filter(c => c.status === 'new').length;

            document.getElementById('totalCustomers').textContent = total;
            document.getElementById('activeCustomers').textContent = active;
            document.getElementById('inactiveCustomers').textContent = inactive;
            document.getElementById('newCustomers').textContent = newCustomers;
        }

        async function loadCustomersData() {
            try {
                // Replace this with actual API call
                // const response = await fetch('/api/customers.php');
                // const result = await response.json();

                // Mock data for now - using your existing data structure
                const result = {
                    success: true,
                    data: {
                        customers: [
                            {
                                id: 1,
                                name: "Juan Dela Cruz",
                                email: "juan.delacruz@email.com",
                                phone: "+63 917 123 4567",
                                location: "Olongapo City",
                                orders: 8,
                                totalSpent: 4250,
                                status: "active",
                                avatar: "JD",
                                memberSince: "Aug 2024",
                                dob: "June 15, 1985",
                                gender: "Male",
                                streetAddress: "123 Main Street",
                                province: "Zambales",
                                postalCode: "2200",
                                country: "Philippines"
                            },
                            {
                                id: 2,
                                name: "Roberto Garcia",
                                email: "roberto.garcia@email.com",
                                phone: "+63 919 345 6789",
                                location: "Olongapo City",
                                orders: 5,
                                totalSpent: 2180,
                                status: "active",
                                avatar: "RG",
                                memberSince: "Jun 2024",
                                dob: "July 20, 1990",
                                gender: "Male",
                                streetAddress: "456 Oak Avenue",
                                province: "Zambales",
                                postalCode: "2200",
                                country: "Philippines"
                            },
                            {
                                id: 3,
                                name: "Ana Reyes",
                                email: "ana.reyes@email.com",
                                phone: "+63 920 456 7890",
                                location: "Olongapo City",
                                orders: 2,
                                totalSpent: 1850,
                                status: "new",
                                avatar: "AR",
                                memberSince: "Aug 2025",
                                dob: "January 10, 1995",
                                gender: "Female",
                                streetAddress: "789 Pine Lane",
                                province: "Zambales",
                                postalCode: "2200",
                                country: "Philippines"
                            },
                            {
                                id: 4,
                                name: "Carlos Mendoza",
                                email: "carlos.mendoza@email.com",
                                phone: "+63 921 567 8901",
                                location: "Olongapo City",
                                orders: 15,
                                totalSpent: 8900,
                                status: "active",
                                avatar: "CM",
                                memberSince: "May 2024",
                                dob: "March 5, 1980",
                                gender: "Male",
                                streetAddress: "101 Elm Street",
                                province: "Zambales",
                                postalCode: "2200",
                                country: "Philippines"
                            },
                            {
                                id: 5,
                                name: "Lisa Fernandez",
                                email: "lisa.fernandez@email.com",
                                phone: "+63 922 678 9012",
                                location: "Olongapo City",
                                orders: 3,
                                totalSpent: 1200,
                                status: "inactive",
                                avatar: "LF",
                                memberSince: "Apr 2024",
                                dob: "November 22, 1992",
                                gender: "Female",
                                streetAddress: "202 Birch Road",
                                province: "Zambales",
                                postalCode: "2200",
                                country: "Philippines"
                            },
                            {
                                id: 6,
                                name: "Miguel Torres",
                                email: "miguel.torres@email.com",
                                phone: "+63 923 789 0123",
                                location: "Olongapo City",
                                orders: 7,
                                totalSpent: 3450,
                                status: "active",
                                avatar: "MT",
                                memberSince: "Mar 2024",
                                dob: "September 1, 1988",
                                gender: "Male",
                                streetAddress: "303 Cedar Street",
                                province: "Zambales",
                                postalCode: "2200",
                                country: "Philippines"
                            },
                            {
                                id: 7,
                                name: "Carmen Lopez",
                                email: "carmen.lopez@email.com",
                                phone: "+63 924 890 1234",
                                location: "Olongapo City",
                                orders: 1,
                                totalSpent: 450,
                                status: "new",
                                avatar: "CL",
                                memberSince: "Aug 2025",
                                dob: "April 18, 1998",
                                gender: "Female",
                                streetAddress: "404 Willow Drive",
                                province: "Zambales",
                                postalCode: "2200",
                                country: "Philippines"
                            },
                            {
                                id: 8,
                                name: "Maria Santos",
                                email: "maria.santos@email.com",
                                phone: "+63 918 234 5678",
                                location: "Olongapo City",
                                orders: 12,
                                totalSpent: 6780,
                                status: "active",
                                avatar: "MS",
                                memberSince: "Jul 2024",
                                dob: "December 12, 1983",
                                gender: "Female",
                                streetAddress: "505 Maple Avenue",
                                province: "Zambales",
                                postalCode: "2200",
                                country: "Philippines"
                            }
                        ],
                        total: 8
                    }
                };

                allCustomers = result.data.customers;
                filteredCustomers = [...allCustomers];
                totalPages = Math.ceil(filteredCustomers.length / customersPerPage);

                renderCustomers();
                renderPagination();
                updateStats();
            } catch (error) {
                console.error('Error loading customers:', error);
                showError('Error loading customer data.');
            }
        }

        function renderCustomers() {
            const tbody = document.querySelector('.customers-table tbody');
            const startIndex = (currentPage - 1) * customersPerPage;
            const endIndex = startIndex + customersPerPage;
            const pageCustomers = filteredCustomers.slice(startIndex, endIndex);

            if (pageCustomers.length === 0) {
                tbody.innerHTML = '<tr><td colspan="8" class="loading">No customers found</td></tr>';
                return;
            }

            tbody.innerHTML = pageCustomers.map(customer => `
                <tr>
                    <td>
                        <div class="customer-info">
                            <div class="customer-avatar">${customer.avatar}</div>
                            <div class="customer-details">
                                <h4>${customer.name}</h4>
                                <p>Member since ${customer.memberSince}</p>
                            </div>
                        </div>
                    </td>
                    <td>${customer.email}</td>
                    <td>${customer.phone}</td>
                    <td>${customer.location}</td>
                    <td>${customer.orders}</td>
                    <td><strong>₱${customer.totalSpent.toLocaleString()}</strong></td>
                    <td><span class="status-badge ${customer.status}">${customer.status.charAt(0).toUpperCase() + customer.status.slice(1)}</span></td>
                    <td>
                        <div class="actions">
                            <button class="action-btn" onclick="openCustomerDetailsModal(${customer.id})">View</button>
                            <button class="action-btn orders" onclick="openCustomerOrdersModal(${customer.id})">Orders</button>
                            <button class="action-btn secondary" onclick="openCustomerEditModal(${customer.id})">Edit</button>
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        function renderPagination() {
            const paginationInfo = document.querySelector('.pagination-info');
            const paginationControls = document.querySelector('.pagination-controls');

            const startItem = ((currentPage - 1) * customersPerPage) + 1;
            const endItem = Math.min(currentPage * customersPerPage, filteredCustomers.length);

            paginationInfo.textContent = `Showing ${startItem}-${endItem} of ${filteredCustomers.length} customers`;

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
            renderCustomers();
            renderPagination();
        }

        function applyFilters() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const statusFilter = document.getElementById('statusFilter').value;
            const locationFilter = document.getElementById('locationFilter').value;

            filteredCustomers = allCustomers.filter(customer => {
                const matchesSearch = !searchTerm ||
                    customer.name.toLowerCase().includes(searchTerm) ||
                    customer.email.toLowerCase().includes(searchTerm);

                const matchesStatus = !statusFilter || customer.status === statusFilter;
                const matchesLocation = !locationFilter || customer.location.toLowerCase() === locationFilter.toLowerCase();

                return matchesSearch && matchesStatus && matchesLocation;
            });

            totalPages = Math.ceil(filteredCustomers.length / customersPerPage);
            currentPage = 1; // Reset to first page when filtering
            renderCustomers();
            renderPagination();
        }

        // Search and filter functionality
        document.getElementById('searchInput').addEventListener('input', applyFilters);
        document.getElementById('statusFilter').addEventListener('change', applyFilters);
        document.getElementById('locationFilter').addEventListener('change', applyFilters);

        function showError(message) {
            const tbody = document.querySelector('.customers-table tbody');
            tbody.innerHTML = `<tr><td colspan="8" class="error" style="text-align: center; padding: 2rem; color: #dc2626;">${message}</td></tr>`;
        }

        // Modal Functions - These will open your existing modals

        function openCustomerDetailsModal(customerId) {
            const customer = allCustomers.find(c => c.id === customerId);
            if (!customer) {
                alert('Customer not found');
                return;
            }

            populateCustomerDetailsModal(customer);
            document.getElementById('customerDetailsModal').classList.add('show');
            document.body.style.overflow = 'hidden';

            setTimeout(() => {
                lucide.createIcons();
            }, 100);
        }

        function populateCustomerDetailsModal(customer) {
            const modal = document.getElementById('customerDetailsModal');
            if (!modal) return;

            modal.querySelector('.customer-details-avatar-large').textContent = customer.avatar;
            modal.querySelector('.customer-details-modal-title h3').textContent = customer.name;
            modal.querySelector('.customer-details-modal-title p').textContent = `Customer ID: #CUS-00${customer.id}`;

            // Update stats
            const stats = modal.querySelectorAll('.customer-details-stat-value');
            if (stats[0]) stats[0].textContent = customer.orders;
            if (stats[1]) stats[1].textContent = `₱${customer.totalSpent.toLocaleString()}`;
            if (stats[2]) stats[2].textContent = `₱${Math.round(customer.totalSpent / customer.orders).toLocaleString()}`;
            // Last order is hardcoded in HTML, would need dynamic data for this

            // Update personal info
            const personalInfoRows = modal.querySelectorAll('.customer-details-info-section .customer-details-info-row');
            if (personalInfoRows[0]) personalInfoRows[0].querySelector('.customer-details-info-value').textContent = customer.name;
            if (personalInfoRows[1]) personalInfoRows[1].querySelector('.customer-details-info-value').textContent = customer.email;
            if (personalInfoRows[2]) personalInfoRows[2].querySelector('.customer-details-info-value').textContent = customer.phone;
            if (personalInfoRows[3]) personalInfoRows[3].querySelector('.customer-details-info-value').textContent = customer.dob;
            if (personalInfoRows[4]) personalInfoRows[4].querySelector('.customer-details-info-value').textContent = customer.gender;
            if (personalInfoRows[5]) personalInfoRows[5].querySelector('.customer-details-info-value').textContent = customer.memberSince;

            // Update address info
            const addressInfoRows = modal.querySelectorAll('.customer-details-info-section:nth-of-type(2) .customer-details-info-row');
            if (addressInfoRows[0]) addressInfoRows[0].querySelector('.customer-details-info-value').textContent = customer.streetAddress;
            if (addressInfoRows[1]) addressInfoRows[1].querySelector('.customer-details-info-value').textContent = customer.location; // Assuming location is city
            if (addressInfoRows[2]) addressInfoRows[2].querySelector('.customer-details-info-value').textContent = customer.province;
            if (addressInfoRows[3]) addressInfoRows[3].querySelector('.customer-details-info-value').textContent = customer.postalCode;
            if (addressInfoRows[4]) addressInfoRows[4].querySelector('.customer-details-info-value').textContent = customer.country;
            if (addressInfoRows[5]) {
                const statusBadge = addressInfoRows[5].querySelector('.customer-details-status-badge');
                statusBadge.textContent = customer.status.charAt(0).toUpperCase() + customer.status.slice(1) + ' Customer';
                statusBadge.className = `customer-details-status-badge ${customer.status}`;
            }

            // Recent orders and activity timeline are hardcoded, would need dynamic data for these
        }

        function closeCustomerDetailsModal(event) {
            const modal = document.getElementById('customerDetailsModal');
            if (modal && (event === undefined || event.target === modal || event.target.closest('.customer-details-close-btn'))) {
                modal.classList.remove('show');
                document.body.style.overflow = 'auto';
            }
        }

        function openCustomerOrdersModal(customerId) {
            const customer = allCustomers.find(c => c.id === customerId);
            if (!customer) {
                alert('Customer not found');
                return;
            }

            populateCustomerOrdersModal(customer);
            document.getElementById('customerOrdersModal').classList.add('show');
            document.body.style.overflow = 'hidden';

            setTimeout(() => {
                lucide.createIcons();
            }, 100);
        }

        function populateCustomerOrdersModal(customer) {
            const modal = document.getElementById('customerOrdersModal');
            if (!modal) return;

            modal.querySelector('.customer-orders-avatar-large').textContent = customer.avatar;
            modal.querySelector('.customer-orders-modal-title h3').textContent = `${customer.name} - Orders`;
            modal.querySelector('.customer-orders-modal-title p').textContent = `Customer ID: #CUS-00${customer.id} • Member since ${customer.memberSince}`;

            // Update order summary (hardcoded values, would need dynamic data)
            // For demonstration, let's assume completed orders are customer.orders and cancelled is 1 if status is inactive
            const completedOrders = customer.orders - (customer.status === 'inactive' ? 1 : 0);
            const cancelledOrders = (customer.status === 'inactive' ? 1 : 0);
            const completedSpent = customer.totalSpent - (cancelledOrders > 0 ? 300 : 0); // Example deduction for cancelled

            const summaryValues = modal.querySelectorAll('.customer-orders-summary-value');
            const summaryLabels = modal.querySelectorAll('.customer-orders-summary-label');

            if (summaryValues[0]) summaryValues[0].textContent = completedOrders;
            if (summaryLabels[0]) summaryLabels[0].textContent = `Completed (₱${completedSpent.toLocaleString()})`;

            if (summaryValues[1]) summaryValues[1].textContent = 0; // Pending
            if (summaryLabels[1]) summaryLabels[1].textContent = `Pending (₱0)`;

            if (summaryValues[2]) summaryValues[2].textContent = 0; // Processing
            if (summaryLabels[2]) summaryLabels[2].textContent = `Processing (₱0)`;

            if (summaryValues[3]) summaryValues[3].textContent = cancelledOrders;
            if (summaryLabels[3]) summaryLabels[3].textContent = `Cancelled (₱${(cancelledOrders > 0 ? 300 : 0).toLocaleString()})`;

            // Orders table is hardcoded, would need dynamic data for these
        }

        function closeCustomerOrdersModal(event) {
            const modal = document.getElementById('customerOrdersModal');
            if (modal && (event === undefined || event.target === modal || event.target.closest('.customer-orders-close-btn'))) {
                modal.classList.remove('show');
                document.body.style.overflow = 'auto';
            }
        }

        function openCustomerEditModal(customerId) {
            const customer = allCustomers.find(c => c.id === customerId);
            if (!customer) {
                alert('Customer not found');
                return;
            }

            populateCustomerEditModal(customer);
            document.getElementById('customerEditModal').classList.add('show');
            document.body.style.overflow = 'hidden';

            setTimeout(() => {
                lucide.createIcons();
            }, 100);
        }

        function populateCustomerEditModal(customer) {
            const modal = document.getElementById('customerEditModal');
            if (!modal) return;

            modal.querySelector('.customer-edit-avatar-large').textContent = customer.avatar;
            modal.querySelector('.customer-edit-modal-title h3').textContent = `Edit Customer - ${customer.name}`;
            modal.querySelector('#customerEditID').textContent = `#CUS-00${customer.id}`;

            // Update stats
            const stats = modal.querySelectorAll('.customer-edit-stat-value');
            if (stats[0]) stats[0].textContent = customer.orders;
            if (stats[1]) stats[1].textContent = `₱${customer.totalSpent.toLocaleString()}`;
            if (stats[2]) stats[2].textContent = customer.memberSince;
            // Last order is hardcoded in HTML, would need dynamic data for this

            // Update customer info in read-only fields
            const infoValues = modal.querySelectorAll('.customer-edit-info-display .customer-edit-info-value');
            if (infoValues[0]) infoValues[0].textContent = customer.name;
            if (infoValues[1]) infoValues[1].textContent = customer.email;
            if (infoValues[2]) infoValues[2].textContent = customer.phone;
            // Registration Date, Location, Last Login are hardcoded, would need dynamic data

            // Update form fields (example for account status and customer type)
            const accountStatusSelect = modal.querySelector('select[name="account_status"]');
            if (accountStatusSelect) accountStatusSelect.value = customer.status;

            // Financial summary (hardcoded, would need dynamic data)
            const financialValues = modal.querySelectorAll('.customer-edit-financial-value');
            if (financialValues[2]) financialValues[2].textContent = `₱${customer.totalSpent.toLocaleString()}`;

            // Sub-modal email field
            const emailSubModalInput = document.querySelector('#emailModal .customer-edit-form-input[type="email"]');
            if (emailSubModalInput) emailSubModalInput.value = customer.email;

            // Sub-modal password reset email field
            const passwordSubModalInput = document.querySelector('#passwordModal .customer-edit-form-input[type="email"]');
            if (passwordSubModalInput) passwordSubModalInput.value = customer.email;
        }

        function closeCustomerEditModal(event) {
            const modal = document.getElementById('customerEditModal');
            if (modal && (event === undefined || event.target === modal || event.target.closest('.customer-edit-close-btn'))) {
                modal.classList.remove('show');
                document.body.style.overflow = 'auto';
                const form = modal.querySelector('form');
                if (form) {
                    form.reset();
                }
            }
        }

        function showCustomerEditSubModal(modalId) {
            document.getElementById(modalId).classList.add('show');
            document.body.style.overflow = 'hidden'; // Keep main body locked
        }

        function closeCustomerEditSubModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('show');
                // Only unlock body if no other modals are open
                if (!document.querySelector('.customer-edit-modal-base.show')) {
                    document.body.style.overflow = 'auto';
                }
                const form = modal.querySelector('form');
                if (form) {
                    form.reset();
                }
            }
        }

        function closeAddCustomerModal() {
            const modal = document.getElementById('addCustomerModal');
            if (modal) {
                modal.classList.remove('show');
                document.getElementById('addCustomerForm').reset();
                document.body.style.overflow = 'auto';
            }
        }

        function setupModalClickOutside() {
            // Add Customer Modal
            const addCustomerModal = document.getElementById('addCustomerModal');
            if (addCustomerModal) {
                addCustomerModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeAddCustomerModal();
                    }
                });
            }

            // Customer Details Modal
            const customerDetailsModal = document.getElementById('customerDetailsModal');
            if (customerDetailsModal) {
                customerDetailsModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeCustomerDetailsModal();
                    }
                });
            }

            // Customer Orders Modal
            const customerOrdersModal = document.getElementById('customerOrdersModal');
            if (customerOrdersModal) {
                customerOrdersModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeCustomerOrdersModal();
                    }
                });
            }

            // Customer Edit Modal
            const customerEditModal = document.getElementById('customerEditModal');
            if (customerEditModal) {
                customerEditModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeCustomerEditModal();
                    }
                });
            }

            // Sub-modals for Edit Customer Modal
            const emailModal = document.getElementById('emailModal');
            if (emailModal) {
                emailModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeCustomerEditSubModal('emailModal');
                    }
                });
            }
            const reportModal = document.getElementById('reportModal');
            if (reportModal) {
                reportModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeCustomerEditSubModal('reportModal');
                    }
                });
            }
            const passwordModal = document.getElementById('passwordModal');
            if (passwordModal) {
                passwordModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeCustomerEditSubModal('passwordModal');
                    }
                });
            }
            const deleteModal = document.getElementById('deleteModal');
            if (deleteModal) {
                deleteModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeCustomerEditSubModal('deleteModal');
                    }
                });
            }
        }


        // Modal functions for add customer
        function showAddCustomerModal() {
            document.getElementById('addCustomerModal').classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        // Add customer form submission
        document.getElementById('addCustomerForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Show loading state
            const submitBtn = this.querySelector('.btn-primary');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Adding...';
            submitBtn.disabled = true;

            // Simulate API call
            setTimeout(() => {
                alert('Customer added successfully!');
                closeAddCustomerModal();
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
                // In a real app, you would refresh the table or add the new row
                loadCustomersData(); // Reload data to include new customer
            }, 1500);
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // ESC to close modals
            if (e.key === 'Escape') {
                // Close Add Customer Modal
                const addModal = document.getElementById('addCustomerModal');
                if (addModal && addModal.classList.contains('show')) {
                    closeAddCustomerModal();
                    return;
                }

                // Close Customer Details Modal
                const detailsModal = document.getElementById('customerDetailsModal');
                if (detailsModal && detailsModal.classList.contains('show')) {
                    closeCustomerDetailsModal();
                    return;
                }

                // Close Customer Orders Modal
                const ordersModal = document.getElementById('customerOrdersModal');
                if (ordersModal && ordersModal.classList.contains('show')) {
                    closeCustomerOrdersModal();
                    return;
                }

                // Close Customer Edit Modal (and its sub-modals first)
                const editModal = document.getElementById('customerEditModal');
                if (editModal && editModal.classList.contains('show')) {
                    const subModals = editModal.querySelectorAll('.customer-edit-sub-modal.show');
                    if (subModals.length > 0) {
                        subModals.forEach(subModal => closeCustomerEditSubModal(subModal.id));
                    } else {
                        closeCustomerEditModal();
                    }
                    return;
                }
            }
            // Ctrl+K to focus search
            if (e.ctrlKey && e.key === 'k') {
                e.preventDefault();
                document.getElementById('searchInput').focus();
            }
            // Ctrl+N to add customer
            if (e.ctrlKey && e.key === 'n') {
                e.preventDefault();
                showAddCustomerModal();
            }
        });

        // Initialize the page
        lucide.createIcons();
    </script>
</body>
</html>
