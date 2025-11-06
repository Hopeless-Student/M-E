<?php
 require_once __DIR__ . '/../../auth/admin_auth.php';
 ?>
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
      <button class="mobile-menu-btn" data-sidebar-toggle="open">
          <i data-lucide="menu"></i>
      </button>

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
        
        // Toast notification function
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

        // Loading overlay
        function showLoading(element) {
            const overlay = document.createElement('div');
            overlay.className = 'loading-overlay';
            overlay.innerHTML = '<div class="spinner"></div>';
            overlay.style.cssText = `
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
            `;
            element.style.position = 'relative';
            element.appendChild(overlay);
            return overlay;
        }

        function hideLoading(overlay) {
            if (overlay && overlay.parentNode) overlay.remove();
        }

        // API request helper
        async function apiRequest(url, options = {}) {
            try {
                const response = await fetch(url, {
                    ...options,
                    headers: {
                        'Content-Type': 'application/json',
                        ...options.headers
                    }
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || data.error || 'Request failed');
                }

                return data;
            } catch (error) {
                console.error('API Error:', error);
                throw error;
            }
        }

        // Load settings on page load
        async function loadSettings() {
            try {
                const data = await apiRequest('../../api/admin/settings/get.php?type=all');
                if (data.success && data.settings) {
                    populateSettings(data.settings);
                }
            } catch (error) {
                console.error('Failed to load settings:', error);
                showToast('Failed to load settings', 'error');
            }
        }

        // Populate form fields with settings
        function populateSettings(settings) {
            // Business settings
            if (settings.business) {
                document.querySelector('#business input[type="text"]').value = settings.business.business_name?.value || '';
                document.querySelector('#business input[type="email"]').value = settings.business.contact_email?.value || '';
                document.querySelector('#business input[type="tel"]').value = settings.business.contact_phone?.value || '';
                const addressTextarea = document.querySelector('#business textarea');
                if (addressTextarea) addressTextarea.value = settings.business.business_address?.value || '';
                const descTextarea = document.querySelectorAll('#business textarea')[1];
                if (descTextarea) descTextarea.value = settings.business.business_description?.value || '';
            }

            // Shipping settings
            if (settings.shipping) {
                const shippingInputs = document.querySelectorAll('#shipping input');
                if (shippingInputs[0]) shippingInputs[0].value = settings.shipping.primary_delivery_area?.value || '';
                if (shippingInputs[1]) shippingInputs[1].value = settings.shipping.standard_delivery_fee?.value || '';
                if (shippingInputs[2]) shippingInputs[2].value = settings.shipping.extended_area_fee?.value || '';
                if (shippingInputs[3]) shippingInputs[3].value = settings.shipping.processing_time_hours?.value || '';
                if (shippingInputs[4]) shippingInputs[4].value = settings.shipping.delivery_time_hours?.value || '';
                
                const autoConfirm = document.getElementById('autoConfirm');
                if (autoConfirm) autoConfirm.checked = settings.shipping.auto_confirm_orders?.value === '1';
            }

            // Notification settings
            if (settings.notifications) {
                document.getElementById('newOrder').checked = settings.notifications.email_new_orders?.value === '1';
                document.getElementById('lowStock').checked = settings.notifications.email_low_stock?.value === '1';
                document.getElementById('newMessage').checked = settings.notifications.email_new_messages?.value === '1';
                document.getElementById('orderUpdates').checked = settings.notifications.system_order_updates?.value === '1';
                document.getElementById('dailyReports').checked = settings.notifications.system_daily_reports?.value === '1';
            }

            // Security settings
            if (settings.security) {
                const sessionSelect = document.querySelector('#security select');
                if (sessionSelect) sessionSelect.value = settings.security.session_timeout_minutes?.value || '60';
                document.getElementById('rememberLogin').checked = settings.security.allow_remember_me?.value === '1';
                document.getElementById('activityLog').checked = settings.security.log_admin_activities?.value === '1';
            }

            // Backup settings
            if (settings.backup) {
                const backupSelect = document.querySelector('#backup select');
                if (backupSelect) backupSelect.value = settings.backup.auto_backup_frequency?.value || 'daily';
                const lastBackup = document.querySelector('#backup input[readonly]');
                if (lastBackup && settings.backup.last_backup_date?.value) {
                    lastBackup.value = settings.backup.last_backup_date.value;
                }
            }
        }

        // Settings navigation
        document.querySelectorAll('.settings-nav-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.settings-nav-item').forEach(i => i.classList.remove('active'));
                this.classList.add('active');

                const sectionId = this.dataset.section;
                document.querySelectorAll('.settings-section').forEach(section => {
                    section.classList.remove('active');
                });
                document.getElementById(sectionId).classList.add('active');
            });
        });

        // Save settings
        async function saveSettings(category, button) {
            const section = document.getElementById(category);
            const overlay = showLoading(section);

            try {
                const settings = {};

                if (category === 'business') {
                    const inputs = section.querySelectorAll('input, textarea');
                    settings.business_name = inputs[0].value;
                    settings.contact_email = inputs[1].value;
                    settings.contact_phone = inputs[2].value;
                    settings.business_address = inputs[3].value;
                    settings.business_description = inputs[4].value;
                } else if (category === 'shipping') {
                    const inputs = section.querySelectorAll('input');
                    settings.primary_delivery_area = inputs[0].value;
                    settings.standard_delivery_fee = inputs[1].value;
                    settings.extended_area_fee = inputs[2].value;
                    settings.processing_time_hours = inputs[3].value;
                    settings.delivery_time_hours = inputs[4].value;
                    settings.auto_confirm_orders = document.getElementById('autoConfirm').checked;
                } else if (category === 'notifications') {
                    settings.email_new_orders = document.getElementById('newOrder').checked;
                    settings.email_low_stock = document.getElementById('lowStock').checked;
                    settings.email_new_messages = document.getElementById('newMessage').checked;
                    settings.system_order_updates = document.getElementById('orderUpdates').checked;
                    settings.system_daily_reports = document.getElementById('dailyReports').checked;
                } else if (category === 'security') {
                    const sessionSelect = section.querySelector('select');
                    settings.session_timeout_minutes = sessionSelect.value;
                    settings.allow_remember_me = document.getElementById('rememberLogin').checked;
                    settings.log_admin_activities = document.getElementById('activityLog').checked;
                } else if (category === 'backup') {
                    const backupSelect = section.querySelector('select');
                    settings.auto_backup_frequency = backupSelect.value;
                }

                const result = await apiRequest('../../api/admin/settings/update.php', {
                    method: 'POST',
                    body: JSON.stringify({
                        category: category,
                        settings: settings
                    })
                });

                if (result.success) {
                    showToast(result.message, 'success');
                }
            } catch (error) {
                showToast('Failed to save settings: ' + error.message, 'error');
            } finally {
                hideLoading(overlay);
            }
        }

        // Form submissions
        document.querySelectorAll('.save-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const section = this.closest('.settings-section');
                const category = section.id;
                
                // Handle special cases
                if (this.textContent.includes('Create Backup')) {
                    createBackup();
                } else if (this.textContent.includes('Export')) {
                    const type = this.textContent.toLowerCase().includes('orders') ? 'orders' :
                                this.textContent.toLowerCase().includes('customer') ? 'customers' :
                                this.textContent.toLowerCase().includes('product') ? 'products' : 'inventory';
                    exportData(type);
                } else {
                    saveSettings(category, this);
                }
            });
        });

        // Create backup
        async function createBackup() {
            const section = document.getElementById('backup');
            const overlay = showLoading(section);

            try {
                const result = await apiRequest('../../api/admin/settings/backup.php', {
                    method: 'POST'
                });

                if (result.success) {
                    showToast('Backup created successfully!', 'success');
                    // Update last backup date
                    const lastBackupInput = section.querySelector('input[readonly]');
                    if (lastBackupInput && result.backup) {
                        lastBackupInput.value = result.backup.date;
                    }
                }
            } catch (error) {
                showToast('Failed to create backup: ' + error.message, 'error');
            } finally {
                hideLoading(overlay);
            }
        }

        // Export data
        function exportData(type) {
            window.open(`../../api/admin/settings/export.php?type=${type}`, '_blank');
            showToast(`Exporting ${type} data...`, 'success');
        }

        // Danger button
        document.querySelector('.danger-btn').addEventListener('click', function() {
            if (confirm('Are you sure you want to reset all data? This action cannot be undone.')) {
                showToast('Data reset functionality requires additional confirmation', 'error');
            }
        });

        // Load settings on page load
        document.addEventListener('DOMContentLoaded', () => {
            loadSettings();
        });
    </script>
</body>
</html>
