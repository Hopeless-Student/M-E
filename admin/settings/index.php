<?php
 require_once __DIR__ . '/../../auth/admin_auth.php';
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - M & E Dashboard</title>
    <link rel="icon" type="image/x-icon" href="../../assets/images/M&E_LOGO-semi-transparent.ico">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js?v=<?php echo time(); ?>"></script>
    <link rel="stylesheet" href="../assets/css/admin/settings/index.css?v=<?php echo time(); ?>">
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
                    <span><?= htmlspecialchars($_SESSION['admin_username'] ?? 'Admin') ?></span>
                    <div class="avatar"><?= htmlspecialchars(strtoupper(substr($_SESSION['admin_username'] ?? 'A', 0, 1))) ?></div>
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
                        <li class="settings-nav-item" data-section="users">User Management</li>
                    </ul>
                </div>

                <!-- Settings Content -->
                <div class="settings-content">
                    <!-- Business Info Section -->
                    <div class="settings-section active" id="business">
                        <h3 class="section-title">Business Information</h3>

                        <div class="form-group">
                            <label class="form-label">Business Name</label>
                            <input type="text" class="form-input" value="">
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Contact Email</label>
                                <input type="email" class="form-input" value="">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Contact Phone</label>
                                <input type="tel" class="form-input" value="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Business Address</label>
                            <textarea class="form-textarea"></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Business Description</label>
                            <textarea class="form-textarea"></textarea>
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
                                <input type="text" class="form-input" value="">
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Standard Delivery Fee</label>
                                    <input type="number" class="form-input" value="">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Extended Area Fee</label>
                                    <input type="number" class="form-input" value="">
                                </div>
                            </div>
                        </div>

                        <div class="settings-card">
                            <h4 class="card-title">Order Processing</h4>
                            <p class="card-description">Configure order handling and processing times</p>

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Processing Time (hours)</label>
                                    <input type="number" class="form-input" value="">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Delivery Time (hours)</label>
                                    <input type="number" class="form-input" value="">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="checkbox-group">
                                    <input type="checkbox" id="autoConfirm">
                                    <label for="autoConfirm">Auto-confirm orders upon receipt</label>
                                </div>
                            </div>
                        </div>

                        <button class="save-btn">Save Shipping Settings</button>
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
                
                // Load admin account info
                await loadAdminAccount();
            } catch (error) {
                console.error('Failed to load settings:', error);
                showToast('Failed to load settings', 'error');
            }
        }

        // Load admin account information
        async function loadAdminAccount() {
            try {
                const data = await apiRequest('../../api/admin/settings/get-account.php');
                if (data.success && data.admin) {
                    const section = document.getElementById('users');
                    const inputs = section.querySelectorAll('input');
                    if (inputs[0]) inputs[0].value = data.admin.username || '';
                    if (inputs[1]) inputs[1].value = data.admin.email || '';
                }
            } catch (error) {
                console.error('Failed to load admin account:', error);
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
                if (this.textContent.includes('Update Account')) {
                    updateAdminAccount();
                } else {
                    saveSettings(category, this);
                }
            });
        });

        // Update admin account
        async function updateAdminAccount() {
            const section = document.getElementById('users');
            const overlay = showLoading(section);

            try {
                const inputs = section.querySelectorAll('input');
                const username = inputs[0].value.trim();
                const email = inputs[1].value.trim();
                const password = inputs[2].value.trim();
                const confirmPassword = inputs[3].value.trim();

                // Validate inputs
                if (!username) {
                    showToast('Username is required', 'error');
                    hideLoading(overlay);
                    return;
                }

                if (!email) {
                    showToast('Email is required', 'error');
                    hideLoading(overlay);
                    return;
                }

                // Validate email format
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    showToast('Invalid email format', 'error');
                    hideLoading(overlay);
                    return;
                }

                // If password is provided, validate it
                if (password) {
                    if (password.length < 6) {
                        showToast('Password must be at least 6 characters long', 'error');
                        hideLoading(overlay);
                        return;
                    }

                    if (password !== confirmPassword) {
                        showToast('Passwords do not match', 'error');
                        hideLoading(overlay);
                        return;
                    }
                }

                const data = {
                    username: username,
                    email: email
                };

                if (password) {
                    data.password = password;
                    data.confirm_password = confirmPassword;
                }

                const result = await apiRequest('../../api/admin/settings/update-account.php', {
                    method: 'POST',
                    body: JSON.stringify(data)
                });

                if (result.success) {
                    showToast(result.message, 'success');
                    // Clear password fields
                    inputs[2].value = '';
                    inputs[3].value = '';
                    
                    // Update header username if changed
                    if (username !== inputs[0].defaultValue) {
                        const headerUsername = document.querySelector('.user-info span');
                        const headerAvatar = document.querySelector('.user-info .avatar');
                        if (headerUsername) headerUsername.textContent = username;
                        if (headerAvatar) headerAvatar.textContent = username.charAt(0).toUpperCase();
                    }
                }
            } catch (error) {
                showToast('Failed to update account: ' + error.message, 'error');
            } finally {
                hideLoading(overlay);
            }
        }

        // Load settings on page load
        document.addEventListener('DOMContentLoaded', () => {
            loadSettings();
        });
    </script>
</body>
</html>
