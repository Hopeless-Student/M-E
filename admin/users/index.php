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
                                memberSince: "Aug 2024"
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
                                memberSince: "Jun 2024"
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
                                memberSince: "Aug 2025"
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
                                memberSince: "May 2024"
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
                                memberSince: "Apr 2024"
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
                                memberSince: "Mar 2024"
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
                                memberSince: "Aug 2025"
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
                                memberSince: "Jul 2024"
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

            // Populate the customer details modal with customer data
            populateCustomerDetailsModal(customer);

            // Show the customer details modal (use your existing modal ID)
            document.getElementById('customerDetailsModal').classList.add('show');
            document.body.style.overflow = 'hidden';

            // Refresh Lucide icons for the modal
            setTimeout(() => {
                lucide.createIcons();
            }, 100);
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

            // Setup close button if it exists
            const closeBtn = document.querySelector('#customerOrdersModal .close-btn');
            if (closeBtn) {
                closeBtn.onclick = closeCustomerOrdersModal;
            }

            setTimeout(() => {
                lucide.createIcons();
            }, 100);
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

            // Setup close button if it exists
            const closeBtn = document.querySelector('#customerEditModal .close-btn');
            if (closeBtn) {
                closeBtn.onclick = closeCustomerEditModal;
            }

            setTimeout(() => {
                lucide.createIcons();
            }, 100);
        }

        // These functions populate your existing modals with customer data
        function openCustomerDetailsModal(customerId) {
            const customer = allCustomers.find(c => c.id === customerId);
            if (!customer) {
                alert('Customer not found');
                return;
            }

            populateCustomerDetailsModal(customer);
            document.getElementById('customerDetailsModal').classList.add('show');
            document.body.style.overflow = 'hidden';

            // Setup close button if it exists
            const closeBtn = document.querySelector('#customerDetailsModal .close-btn');
            if (closeBtn) {
                closeBtn.onclick = closeCustomerDetailsModal;
            }

            setTimeout(() => {
                lucide.createIcons();
            }, 100);
        }
        function populateCustomerOrdersModal(customer) {
            // Update customer orders modal with customer data
            const modal = document.getElementById('customerOrdersModal');
            if (modal) {
                const nameElement = modal.querySelector('.modal-title h3');
                if (nameElement) nameElement.textContent = `${customer.name} - Orders`;

                const avatarElement = modal.querySelector('.customer-avatar-large');
                if (avatarElement) avatarElement.textContent = customer.avatar;

                // Update order stats
                const statsElements = modal.querySelectorAll('.stat-value');
                if (statsElements.length >= 4) {
                    statsElements[0].textContent = customer.orders;
                    statsElements[1].textContent = `₱${customer.totalSpent.toLocaleString()}`;
                    statsElements[2].textContent = `₱${Math.round(customer.totalSpent / customer.orders).toLocaleString()}`;
                    statsElements[3].textContent = customer.orders - (customer.status === 'active' ? 0 : 1); // Assuming cancelled orders
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
        function closeCustomerDetailsModal() {
            const modal = document.getElementById('customerDetailsModal');
            if (modal) {
                modal.classList.remove('show');
                document.body.style.overflow = 'auto';
            }
        }
        function closeCustomerOrdersModal() {
            const modal = document.getElementById('customerOrdersModal');
            if (modal) {
                modal.classList.remove('show');
                document.body.style.overflow = 'auto';
            }
        }
        function closeCustomerEditModal() {
            const modal = document.getElementById('customerEditModal');
            if (modal) {
                modal.classList.remove('show');
                document.body.style.overflow = 'auto';

                // Reset any form data if there's a form in the edit modal
                const form = modal.querySelector('form');
                if (form) {
                    form.reset();
                }
            }
        }
        function closeAllModals() {
            const modals = document.querySelectorAll('.modal.show');
            modals.forEach(modal => {
                modal.classList.remove('show');

                // Reset forms if they exist
                const form = modal.querySelector('form');
                if (form) {
                    form.reset();
                }
            });
            document.body.style.overflow = 'auto';
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
        }

        function populateCustomerEditModal(customer) {
            // Update customer edit modal with customer data
            const modal = document.getElementById('customerEditModal');
            if (modal) {
                const nameElement = modal.querySelector('.modal-title h3');
                if (nameElement) nameElement.textContent = `Edit Customer - ${customer.name}`;

                const avatarElement = modal.querySelector('.customer-avatar-large');
                if (avatarElement) avatarElement.textContent = customer.avatar;

                // Update customer info in read-only fields
                const infoValues = modal.querySelectorAll('.info-value');
                if (infoValues.length >= 6) {
                    infoValues[0].textContent = customer.name;
                    infoValues[1].textContent = customer.email;
                    infoValues[2].textContent = customer.phone;
                    infoValues[4].textContent = customer.location;
                }
            }
        }

        // Modal functions for add customer
        function showAddCustomerModal() {
            document.getElementById('addCustomerModal').classList.add('show');
        }

        // Close modal when clicking outside
        document.getElementById('addCustomerModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAddCustomerModal();
            }
        });

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
                closeAddCustomerModal();
                // Close other modals if they exist
                const modals = document.querySelectorAll('.modal.show');
                modals.forEach(modal => {
                    modal.classList.remove('show');
                    document.body.style.overflow = 'auto';
                });
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
