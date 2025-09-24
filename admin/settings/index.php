<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - M & E Dashboard</title>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <link rel="stylesheet" href="../assets/css/admin/settings/index.css">
</head>
<body>
  <div class="dashboard">

      <?php include '../../includes/admin_sidebar.php' ?>

        <!-- Main Content -->
        <main class="main-content">
            <div class="header">
                <h2>Settings</h2>
                <div class="user-info">
                    <span>Admin Panel</span>
                    <div class="avatar">A</div>
                </div>
            </div>

            <!-- Settings Layout -->
            <div class="settings-layout">
                <!-- Settings Navigation -->
                <div class="settings-nav">
                    <h3 class="settings-nav-title">Settings Menu</h3>
                    <ul class="settings-nav-list">
                        <li class="settings-nav-item active" data-section="business">Business Info</li>
                        <li class="settings-nav-item" data-section="shipping">Shipping & Delivery</li>
                        <li class="settings-nav-item" data-section="notifications">Notifications</li>
                        <li class="settings-nav-item" data-section="users">User Management</li>
                        <li class="settings-nav-item" data-section="security">Security</li>
                        <li class="settings-nav-item" data-section="backup">Backup & Data</li>
                    </ul>
                </div>

                <!-- Settings Content -->
                <div class="settings-content">
                    <!-- Business Info Section -->
                    <div class="settings-section active" id="business">
                        <h3 class="section-title">Business Information</h3>

                        <div class="form-group">
                            <label class="form-label">Business Name</label>
                            <input type="text" class="form-input" value="M & E Interior Supplies Trading">
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Contact Email</label>
                                <input type="email" class="form-input" value="info@me-supplies.com">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Contact Phone</label>
                                <input type="tel" class="form-input" value="+63 47 222 3456">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Business Address</label>
                            <textarea class="form-textarea">123 Rizal Avenue, Olongapo City, Zambales, Philippines</textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Business Description</label>
                            <textarea class="form-textarea">Your trusted supplier for office, school, and sanitary supplies in Olongapo City. We provide quality products with fast and reliable delivery service.</textarea>
                        </div>

                        <button class="save-btn">Save Changes</button>
                    </div>

                    <!-- Shipping & Delivery Section -->
                    <div class="settings-section" id="shipping">
                        <h3 class="section-title">Shipping & Delivery Settings</h3>

                        <div class="settings-card">
                            <h4 class="card-title">Delivery Areas</h4>
                            <p class="card-description">Configure delivery zones and shipping rates</p>

                            <div class="form-group">
                                <label class="form-label">Primary Delivery Area</label>
                                <input type="text" class="form-input" value="Olongapo City, Zambales">
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Standard Delivery Fee</label>
                                    <input type="number" class="form-input" value="70">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Extended Area Fee</label>
                                    <input type="number" class="form-input" value="100">
                                </div>
                            </div>
                        </div>

                        <div class="settings-card">
                            <h4 class="card-title">Order Processing</h4>
                            <p class="card-description">Configure order handling and processing times</p>

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Processing Time (hours)</label>
                                    <input type="number" class="form-input" value="24">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Delivery Time (hours)</label>
                                    <input type="number" class="form-input" value="48">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="checkbox-group">
                                    <input type="checkbox" id="autoConfirm" checked>
                                    <label for="autoConfirm">Auto-confirm orders upon receipt</label>
                                </div>
                            </div>
                        </div>

                        <button class="save-btn">Save Shipping Settings</button>
                    </div>

                    <!-- Notifications Section -->
                    <div class="settings-section" id="notifications">
                        <h3 class="section-title">Notification Settings</h3>

                        <div class="settings-card">
                            <h4 class="card-title">Email Notifications</h4>
                            <p class="card-description">Configure when to receive email alerts</p>

                            <div class="form-group">
                                <div class="checkbox-group">
                                    <input type="checkbox" id="newOrder" checked>
                                    <label for="newOrder">New orders received</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="checkbox-group">
                                    <input type="checkbox" id="lowStock" checked>
                                    <label for="lowStock">Low stock alerts</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="checkbox-group">
                                    <input type="checkbox" id="newMessage" checked>
                                    <label for="newMessage">New customer messages</label>
                                </div>
                            </div>
                        </div>

                        <div class="settings-card">
                            <h4 class="card-title">System Notifications</h4>
                            <p class="card-description">Configure dashboard and system alerts</p>

                            <div class="form-group">
                                <div class="checkbox-group">
                                    <input type="checkbox" id="orderUpdates">
                                    <label for="orderUpdates">Order status updates</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="checkbox-group">
                                    <input type="checkbox" id="dailyReports" checked>
                                    <label for="dailyReports">Daily sales reports</label>
                                </div>
                            </div>
                        </div>

                        <button class="save-btn">Save Notification Settings</button>
                    </div>

                    <!-- User Management Section -->
                    <div class="settings-section" id="users">
                        <h3 class="section-title">User Management</h3>

                        <div class="settings-card">
                            <h4 class="card-title">Admin Account</h4>
                            <p class="card-description">Manage admin account settings</p>

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Username</label>
                                    <input type="text" class="form-input" value="admin">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-input" value="admin@me-supplies.com">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Change Password</label>
                                <input type="password" class="form-input" placeholder="Enter new password">
                            </div>

                            <div class="form-group">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" class="form-input" placeholder="Confirm new password">
                            </div>
                        </div>

                        <button class="save-btn">Update Account</button>
                    </div>

                    <!-- Security Section -->
                    <div class="settings-section" id="security">
                        <h3 class="section-title">Security Settings</h3>

                        <div class="settings-card">
                            <h4 class="card-title">Session Management</h4>
                            <p class="card-description">Configure login and session security</p>

                            <div class="form-group">
                                <label class="form-label">Session Timeout (minutes)</label>
                                <select class="form-select">
                                    <option value="30">30 minutes</option>
                                    <option value="60" selected>1 hour</option>
                                    <option value="120">2 hours</option>
                                    <option value="240">4 hours</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <div class="checkbox-group">
                                    <input type="checkbox" id="rememberLogin">
                                    <label for="rememberLogin">Allow "Remember Me" option</label>
                                </div>
                            </div>
                        </div>

                        <div class="settings-card">
                            <h4 class="card-title">Data Protection</h4>
                            <p class="card-description">Manage data security and privacy settings</p>

                            <div class="form-group">
                                <div class="checkbox-group">
                                    <input type="checkbox" id="dataEncryption" checked disabled>
                                    <label for="dataEncryption">Encrypt sensitive customer data</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="checkbox-group">
                                    <input type="checkbox" id="activityLog" checked>
                                    <label for="activityLog">Log admin activities</label>
                                </div>
                            </div>
                        </div>

                        <button class="save-btn">Save Security Settings</button>
                    </div>

                    <!-- Backup & Data Section -->
                    <div class="settings-section" id="backup">
                        <h3 class="section-title">Backup & Data Management</h3>

                        <div class="settings-card">
                            <h4 class="card-title">Database Backup</h4>
                            <p class="card-description">Manage system backups and data export</p>

                            <div class="form-group">
                                <label class="form-label">Automatic Backup Frequency</label>
                                <select class="form-select">
                                    <option value="daily" selected>Daily</option>
                                    <option value="weekly">Weekly</option>
                                    <option value="monthly">Monthly</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Last Backup</label>
                                <input type="text" class="form-input" value="August 20, 2025 - 12:00 AM" readonly>
                            </div>

                            <button class="save-btn">Create Backup Now</button>
                        </div>

                        <div class="settings-card">
                            <h4 class="card-title">Data Export</h4>
                            <p class="card-description">Export business data for reporting or migration</p>

                            <div class="form-group">
                                <button class="save-btn">Export Orders Data</button>
                                <button class="save-btn" style="margin-left: 1rem;">Export Customer Data</button>
                            </div>

                            <div class="form-group">
                                <button class="save-btn">Export Product Data</button>
                                <button class="save-btn" style="margin-left: 1rem;">Export Inventory Report</button>
                            </div>
                        </div>

                        <div class="settings-card" style="border-left-color: #dc2626;">
                            <h4 class="card-title" style="color: #dc2626;">Danger Zone</h4>
                            <p class="card-description">Irreversible actions that affect your entire system</p>

                            <button class="danger-btn">Reset All Data</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        lucide.createIcons();
        // Settings navigation
        document.querySelectorAll('.settings-nav-item').forEach(item => {
            item.addEventListener('click', function() {
                // Update active nav item
                document.querySelectorAll('.settings-nav-item').forEach(i => i.classList.remove('active'));
                this.classList.add('active');

                // Show corresponding section
                const sectionId = this.dataset.section;
                document.querySelectorAll('.settings-section').forEach(section => {
                    section.classList.remove('active');
                });
                document.getElementById(sectionId).classList.add('active');
            });
        });

        // Form submissions
        document.querySelectorAll('.save-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const section = this.closest('.settings-section').id;
                alert(`${section.charAt(0).toUpperCase() + section.slice(1)} settings saved successfully!`);
            });
        });

        // Danger button
        document.querySelector('.danger-btn').addEventListener('click', function() {
            if (confirm('Are you sure you want to reset all data? This action cannot be undone.')) {
                alert('Data reset functionality would be implemented here with proper safeguards.');
            }
        });

        // Toggle switches
        document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const label = this.nextElementSibling.textContent;
                console.log(`${label}: ${this.checked ? 'Enabled' : 'Disabled'}`);
            });
        });
    </script>
</body>
</html>
