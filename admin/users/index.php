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
                    <div class="stat-title">Total Customers</div>
                    <div class="stat-value">142</div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">New This Month</div>
                    <div class="stat-value">23</div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">Active Customers</div>
                    <div class="stat-value">127</div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">Repeat Customers</div>
                    <div class="stat-value">89</div>
                </div>
            </div>

            <!-- Customer Controls -->
            <div class="customer-controls">
                <div class="search-filter">
                    <div class="search-box">
                        <input type="text" placeholder="Search customers..." id="searchInput">
                    </div>
                    <select class="filter-select" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="new">New</option>
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
                            <tr>
                                <td>
                                    <div class="customer-info">
                                        <div class="customer-avatar">JD</div>
                                        <div class="customer-details">
                                            <h4>Juan Dela Cruz</h4>
                                            <p>Member since Aug 2024</p>
                                        </div>
                                    </div>
                                </td>
                                <td>juan.delacruz@email.com</td>
                                <td>+63 917 123 4567</td>
                                <td>Olongapo City</td>
                                <td>8</td>
                                <td><strong>₱4,250</strong></td>
                                <td><span class="status-badge active">Active</span></td>
                                <td>
                                    <div class="actions">
                                        <a href="user-details.php?id=1" class="action-btn">View</a>
                                        <a href="user-orders.php?id=1" class="action-btn orders">Orders</a>
                                        <a href="edit-user.php?id=1" class="action-btn secondary">Edit</a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="customer-info">
                                        <div class="customer-avatar">RG</div>
                                        <div class="customer-details">
                                            <h4>Roberto Garcia</h4>
                                            <p>Member since Jun 2024</p>
                                        </div>
                                    </div>
                                </td>
                                <td>roberto.garcia@email.com</td>
                                <td>+63 919 345 6789</td>
                                <td>Olongapo City</td>
                                <td>5</td>
                                <td><strong>₱2,180</strong></td>
                                <td><span class="status-badge active">Active</span></td>
                                <td>
                                    <div class="actions">
                                        <a href="user-details.php?id=2" class="action-btn">View</a>
                                        <a href="user-orders.php?id=2" class="action-btn orders">Orders</a>
                                        <a href="edit-user.php?id=2" class="action-btn secondary">Edit</a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="customer-info">
                                        <div class="customer-avatar">AR</div>
                                        <div class="customer-details">
                                            <h4>Ana Reyes</h4>
                                            <p>Member since Aug 2025</p>
                                        </div>
                                    </div>
                                </td>
                                <td>ana.reyes@email.com</td>
                                <td>+63 920 456 7890</td>
                                <td>Olongapo City</td>
                                <td>2</td>
                                <td><strong>₱1,850</strong></td>
                                <td><span class="status-badge new">New</span></td>
                                <td>
                                    <div class="actions">
                                        <a href="user-details.php?id=3" class="action-btn">View</a>
                                        <a href="user-orders.php?id=3" class="action-btn orders">Orders</a>
                                        <a href="edit-user.php?id=3" class="action-btn secondary">Edit</a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="customer-info">
                                        <div class="customer-avatar">CM</div>
                                        <div class="customer-details">
                                            <h4>Carlos Mendoza</h4>
                                            <p>Member since May 2024</p>
                                        </div>
                                    </div>
                                </td>
                                <td>carlos.mendoza@email.com</td>
                                <td>+63 921 567 8901</td>
                                <td>Olongapo City</td>
                                <td>15</td>
                                <td><strong>₱8,900</strong></td>
                                <td><span class="status-badge active">Active</span></td>
                                <td>
                                    <div class="actions">
                                        <a href="user-details.php?id=4" class="action-btn">View</a>
                                        <a href="user-orders.php?id=4" class="action-btn orders">Orders</a>
                                        <a href="edit-user.php?id=4" class="action-btn secondary">Edit</a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="customer-info">
                                        <div class="customer-avatar">LF</div>
                                        <div class="customer-details">
                                            <h4>Lisa Fernandez</h4>
                                            <p>Member since Apr 2024</p>
                                        </div>
                                    </div>
                                </td>
                                <td>lisa.fernandez@email.com</td>
                                <td>+63 922 678 9012</td>
                                <td>Olongapo City</td>
                                <td>3</td>
                                <td><strong>₱1,200</strong></td>
                                <td><span class="status-badge inactive">Inactive</span></td>
                                <td>
                                    <div class="actions">
                                        <a href="user-details.php?id=5" class="action-btn">View</a>
                                        <a href="user-orders.php?id=5" class="action-btn orders">Orders</a>
                                        <a href="edit-user.php?id=5" class="action-btn secondary">Edit</a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="customer-info">
                                        <div class="customer-avatar">MT</div>
                                        <div class="customer-details">
                                            <h4>Miguel Torres</h4>
                                            <p>Member since Mar 2024</p>
                                        </div>
                                    </div>
                                </td>
                                <td>miguel.torres@email.com</td>
                                <td>+63 923 789 0123</td>
                                <td>Olongapo City</td>
                                <td>7</td>
                                <td><strong>₱3,450</strong></td>
                                <td><span class="status-badge active">Active</span></td>
                                <td>
                                    <div class="actions">
                                        <a href="user-details.php?id=6" class="action-btn">View</a>
                                        <a href="user-orders.php?id=6" class="action-btn orders">Orders</a>
                                        <a href="edit-user.php?id=6" class="action-btn secondary">Edit</a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="customer-info">
                                        <div class="customer-avatar">CL</div>
                                        <div class="customer-details">
                                            <h4>Carmen Lopez</h4>
                                            <p>Member since Aug 2025</p>
                                        </div>
                                    </div>
                                </td>
                                <td>carmen.lopez@email.com</td>
                                <td>+63 924 890 1234</td>
                                <td>Olongapo City</td>
                                <td>1</td>
                                <td><strong>₱450</strong></td>
                                <td><span class="status-badge new">New</span></td>
                                <td>
                                    <div class="actions">
                                        <a href="user-details.php?id=7" class="action-btn">View</a>
                                        <a href="user-orders.php?id=7" class="action-btn orders">Orders</a>
                                        <a href="edit-user.php?id=7" class="action-btn secondary">Edit</a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="customer-info">
                                        <div class="customer-avatar">MS</div>
                                        <div class="customer-details">
                                            <h4>Maria Santos</h4>
                                            <p>Member since Jul 2024</p>
                                        </div>
                                    </div>
                                </td>
                                <td>maria.santos@email.com</td>
                                <td>+63 918 234 5678</td>
                                <td>Olongapo City</td>
                                <td>12</td>
                                <td><strong>₱6,780</strong></td>
                                <td><span class="status-badge active">Active</span></td>
                                <td>
                                    <div class="actions">
                                        <a href="user-details.php?id=8" class="action-btn">View</a>
                                        <a href="user-orders.php?id=8" class="action-btn orders">Orders</a>
                                        <a href="edit-user.php?id=8" class="action-btn secondary">Edit</a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination">
                    <div class="pagination-info">
                        Showing 1-8 of 142 customers
                    </div>
                    <div class="pagination-controls">
                        <button class="page-btn">Previous</button>
                        <button class="page-btn active">1</button>
                        <button class="page-btn">2</button>
                        <button class="page-btn">3</button>
                        <button class="page-btn">Next</button>
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
                        <option value="vip">VIP</option>
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

    <script>
        lucide.createIcons();
        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('.customers-table tbody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });

            updatePaginationInfo();
        });

        // Status filter
        document.getElementById('statusFilter').addEventListener('change', function(e) {
            const filterValue = e.target.value;
            const rows = document.querySelectorAll('.customers-table tbody tr');

            rows.forEach(row => {
                const status = row.querySelector('.status-badge').textContent.toLowerCase();
                row.style.display = !filterValue || status.includes(filterValue) ? '' : 'none';
            });

            updatePaginationInfo();
        });

        // Modal functions
        function showAddCustomerModal() {
            document.getElementById('addCustomerModal').classList.add('show');
        }

        function closeAddCustomerModal() {
            document.getElementById('addCustomerModal').classList.remove('show');
            document.getElementById('addCustomerForm').reset();
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
            }, 1500);
        });

        // Update pagination info based on visible rows
        function updatePaginationInfo() {
            const visibleRows = document.querySelectorAll('.customers-table tbody tr:not([style*="display: none"])');
            const totalRows = document.querySelectorAll('.customers-table tbody tr').length;
            const paginationInfo = document.querySelector('.pagination-info');

            if (paginationInfo) {
                paginationInfo.textContent = `Showing ${visibleRows.length} of ${totalRows} customers`;
            }
        }

        // Pagination button functionality
        document.querySelectorAll('.page-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                if (!this.classList.contains('active') && this.textContent !== 'Previous' && this.textContent !== 'Next') {
                    document.querySelector('.page-btn.active').classList.remove('active');
                    this.classList.add('active');
                }
            });
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // ESC to close modal
            if (e.key === 'Escape') {
                closeAddCustomerModal();
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
    </script>
</body>
</html>
