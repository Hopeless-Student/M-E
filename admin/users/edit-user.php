<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer - M & E Dashboard</title>

    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
            color: #334155;
            line-height: 1.6;
        }

        img {
            width: 250px;
            height: 250px;
        }

        .dashboard {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            color: white;
            padding: 2rem 0;
            box-shadow: 4px 0 10px rgba(30, 58, 138, 0.1);
        }

        .logo {
            width: 120px;
            height: 120px;
            margin: 0 auto 2rem;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 700;
            text-align: center;
            line-height: 1.2;
            margin-bottom: 75px;
            margin-top: 30px;
        }

        .logo h1 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .logo p {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .nav-menu {
            list-style: none;
        }

        .nav-item {
            margin-bottom: 0.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 1rem 2rem;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .nav-link:hover, .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            border-left-color: #60a5fa;
        }

        .nav-link .lucide {
            margin-right: 1rem;
            width: 20px;
            height: 20px;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 2rem;
            overflow-x: auto;
            min-width: 0;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .header h2 {
            font-size: 2rem;
            font-weight: 600;
            color: #1e40af;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #64748b;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .breadcrumb a {
            color: #1e40af;
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        /* Edit Form */
        .edit-form-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .form-header {
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            color: white;
            padding: 1.5rem 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .form-header h3 {
            font-size: 1.3rem;
            font-weight: 600;
        }

        .customer-avatar-large {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.2rem;
        }

        .form-content {
            padding: 2rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .form-input {
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 0.9rem;
            transition: border-color 0.2s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: #1e40af;
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
        }

        .form-select {
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: white;
            font-size: 0.9rem;
            transition: border-color 0.2s ease;
        }

        .form-select:focus {
            outline: none;
            border-color: #1e40af;
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
        }

        .form-textarea {
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 0.9rem;
            resize: vertical;
            min-height: 100px;
            font-family: inherit;
            transition: border-color 0.2s ease;
        }

        .form-textarea:focus {
            outline: none;
            border-color: #1e40af;
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
        }

        /* Status Badge in Form */
        .status-display {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .current-status {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .current-status.active { background-color: #d1fae5; color: #065f46; }
        .current-status.inactive { background-color: #fee2e2; color: #dc2626; }
        .current-status.new { background-color: #dbeafe; color: #1d4ed8; }

        /* Form Actions */
        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            padding: 1.5rem 2rem;
            background-color: #f8fafc;
            border-top: 1px solid #e2e8f0;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-align: center;
        }

        .btn .lucide {
            width: 16px;
            height: 16px;
        }

        .btn-primary {
            background-color: #1e40af;
            color: white;
        }

        .btn-primary:hover {
            background-color: #1e3a8a;
        }

        .btn-secondary {
            background-color: #64748b;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #475569;
        }

        .btn-danger {
            background-color: #dc2626;
            color: white;
        }

        .btn-danger:hover {
            background-color: #b91c1c;
        }

        /* Customer Stats in Form */
        .customer-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: #f8fafc;
            border-radius: 8px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.8rem;
            color: #64748b;
            font-weight: 500;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            color: #64748b;
            font-size: 0.8rem;
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .info-value {
            color: #1e293b;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .checkbox-group {
            margin-top: 0.5rem;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem;
            border-radius: 6px;
            transition: background-color 0.2s ease;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .checkbox-item:hover {
            background-color: #f1f5f9;
        }

        .checkbox-item input[type="checkbox"] {
            margin: 0;
            width: 16px;
            height: 16px;
            accent-color: #1e40af;
        }

        .financial-summary .form-grid {
            margin-bottom: 0;
        }

        .quick-actions .btn {
            justify-content: center;
        }

        .section-header {
            margin: 2rem 0 1rem;
            color: #1e40af;
            font-size: 1.1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .section-header .lucide {
            width: 20px;
            height: 20px;
        }

        .info-display {
            background: #f8fafc;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 2rem;
        }

        .notice-box {
            margin-top: 1rem;
            padding: 1rem;
            background: white;
            border-radius: 6px;
            border-left: 4px solid #fbbf24;
        }

        .notice-box p {
            color: #92400e;
            font-size: 0.9rem;
            margin: 0;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(3px);
        }

        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-content {
            background: white;
            border-radius: 12px;
            padding: 0;
            max-width: 600px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from { transform: translateY(-20px) scale(0.95); }
            to { transform: translateY(0) scale(1); }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #e2e8f0;
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        }

        .modal-header h3 {
            color: #1e40af;
            font-size: 1.2rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .modal-header h3 .lucide {
            width: 20px;
            height: 20px;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #64748b;
            padding: 0.25rem;
            border-radius: 4px;
            transition: all 0.2s ease;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .close-btn:hover {
            color: #dc2626;
            background-color: #fee2e2;
        }

        .modal-content form {
            padding: 1.5rem 2rem 2rem;
        }

        .modal-content .form-actions {
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid #f1f5f9;
            padding-left: 2rem;
            padding-right: 2rem;
            background: transparent;
        }

        .warning-box {
            padding: 1rem;
            background: #fef3c7;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            border-left: 4px solid #f59e0b;
        }

        .warning-box p {
            color: #92400e;
            margin: 0;
            font-size: 0.9rem;
        }

        .danger-box {
            padding: 1rem;
            background: #fee2e2;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            border-left: 4px solid #dc2626;
        }

        .danger-box p {
            color: #dc2626;
            margin: 0;
            font-size: 0.9rem;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Mobile Styles */
        @media (max-width: 1024px) {
            .dashboard {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                position: static;
            }

            .main-content {
                padding: 1rem;
            }

            .modal-content {
                width: 95%;
                max-height: 85vh;
            }
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column-reverse;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .customer-stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .modal-content {
                width: 98%;
                margin: 1rem 0;
            }

            .modal-header {
                padding: 1rem 1.5rem;
            }

            .modal-content form {
                padding: 1rem 1.5rem;
            }

            .modal-content .form-actions {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .form-content {
                padding: 1rem;
            }

            .form-actions {
                padding: 1rem;
            }

            .customer-stats {
                grid-template-columns: 1fr;
            }

            .modal-content {
                width: 100%;
                height: 100vh;
                max-height: 100vh;
                border-radius: 0;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <nav class="sidebar">
            <div class="logo">
                <img src="../../assets/images/logo/ME logo.png" alt="">
            </div>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="../index.php" class="nav-link">
                        <i data-lucide="bar-chart-3"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../orders/index.php" class="nav-link">
                        <i data-lucide="package"></i> Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../products/index.php" class="nav-link">
                        <i data-lucide="shopping-cart"></i> Products
                    </a>
                </li>
                <li class="nav-item">
                    <a href="index.php" class="nav-link active">
                        <i data-lucide="users"></i> Customers
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../inventory/index.php" class="nav-link">
                        <i data-lucide="clipboard-list"></i> Inventory
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../requests/index.php" class="nav-link">
                        <i data-lucide="message-circle"></i> Messages
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../settings/index.php" class="nav-link">
                        <i data-lucide="settings"></i> Settings
                    </a>
                </li>
            </ul>
        </nav>

        <main class="main-content">
            <div class="breadcrumb">
                <a href="../index.php">Dashboard</a>
                <span>›</span>
                <a href="index.php">Customers</a>
                <span>›</span>
                <span>Edit Customer</span>
            </div>

            <div class="header">
                <h2>Edit Customer</h2>
            </div>

            <div class="edit-form-container">
                <div class="form-header">
                    <div class="customer-avatar-large">JD</div>
                    <div>
                        <h3>Juan Dela Cruz</h3>
                        <p>Customer ID: #CUS-001</p>
                    </div>
                </div>

                <form class="form-content" id="editCustomerForm">
                    <!-- Customer Stats -->
                    <div class="customer-stats">
                        <div class="stat-item">
                            <div class="stat-value">8</div>
                            <div class="stat-label">Total Orders</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">₱4,250</div>
                            <div class="stat-label">Total Spent</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">Aug 2024</div>
                            <div class="stat-label">Member Since</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">2 days ago</div>
                            <div class="stat-label">Last Order</div>
                        </div>
                    </div>

                    <!-- Customer Information (Read-Only) -->
                    <h4 class="section-header">
                        <i data-lucide="user"></i>
                        Customer Information
                    </h4>
                    <div class="info-display">
                        <div class="form-grid">
                            <div class="info-item">
                                <label class="info-label">Full Name</label>
                                <span class="info-value">Juan Dela Cruz</span>
                            </div>
                            <div class="info-item">
                                <label class="info-label">Email Address</label>
                                <span class="info-value">juan.delacruz@email.com</span>
                            </div>
                            <div class="info-item">
                                <label class="info-label">Phone Number</label>
                                <span class="info-value">+63 917 123 4567</span>
                            </div>
                            <div class="info-item">
                                <label class="info-label">Registration Date</label>
                                <span class="info-value">August 15, 2024</span>
                            </div>
                            <div class="info-item">
                                <label class="info-label">Location</label>
                                <span class="info-value">Olongapo City, Zambales</span>
                            </div>
                            <div class="info-item">
                                <label class="info-label">Last Login</label>
                                <span class="info-value">August 30, 2025 - 2:45 PM</span>
                            </div>
                        </div>
                        <div class="notice-box">
                            <p><strong><i data-lucide="info" style="width: 14px; height: 14px; display: inline; margin-right: 4px;"></i>Note:</strong> Personal information can only be updated by the customer through their account settings. Admins can only modify account status, permissions, and business-related settings.</p>
                        </div>
                    </div>

                    <!-- Admin Controls -->
                    <h4 class="section-header">
                        <i data-lucide="settings"></i>
                        Admin Controls
                    </h4>
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Account Status</label>
                            <select class="form-select" name="account_status">
                                <option value="active" selected>Active</option>
                                <option value="suspended">Suspended</option>
                                <option value="banned">Banned</option>
                                <option value="under_review">Under Review</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Customer Type</label>
                            <select class="form-select" name="customer_type">
                                <option value="regular" selected>Regular Customer</option>
                                <option value="vip">VIP Customer</option>
                                <option value="wholesale">Wholesale Customer</option>
                                <option value="corporate">Corporate Account</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Credit Limit</label>
                            <input type="number" class="form-input" value="10000" name="credit_limit" placeholder="0">
                            <small style="color: #64748b; font-size: 0.8rem;">Credit limit for wholesale/corporate accounts (₱)</small>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Discount Rate</label>
                            <input type="number" class="form-input" value="5" name="discount_rate" min="0" max="50" step="0.1">
                            <small style="color: #64748b; font-size: 0.8rem;">Special discount percentage (%)</small>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Payment Terms</label>
                            <select class="form-select" name="payment_terms">
                                <option value="immediate">Immediate Payment</option>
                                <option value="net7">Net 7 Days</option>
                                <option value="net15">Net 15 Days</option>
                                <option value="net30" selected>Net 30 Days</option>
                                <option value="net60">Net 60 Days</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Sales Representative</label>
                            <select class="form-select" name="sales_rep">
                                <option value="">No assigned rep</option>
                                <option value="1" selected>Maria Santos</option>
                                <option value="2">John Reyes</option>
                                <option value="3">Ana Garcia</option>
                            </select>
                        </div>
                    </div>

                    <!-- Permissions & Restrictions -->
                    <h4 class="section-header">
                        <i data-lucide="shield-check"></i>
                        Permissions & Restrictions
                    </h4>
                    <div class="form-grid">
                        <div class="form-group" style="grid-column: 1 / -1;">
                            <div class="checkbox-group" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                                <label class="checkbox-item">
                                    <input type="checkbox" checked> Allow Bulk Orders
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" checked> Allow Credit Purchases
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox"> Require Order Approval
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox"> Block New Orders
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" checked> Receive Marketing Emails
                                </label>
                                <label class="checkbox-item">
                                    <input type="checkbox" checked> Access to Wholesale Prices
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Financial Information -->
                    <h4 class="section-header">
                        <i data-lucide="dollar-sign"></i>
                        Financial Summary
                    </h4>
                    <div class="financial-summary" style="background: #f8fafc; padding: 1.5rem; border-radius: 8px; margin-bottom: 1rem;">
                        <div class="form-grid">
                            <div class="info-item">
                                <label class="info-label">Outstanding Balance</label>
                                <span class="info-value" style="color: #dc2626; font-weight: 700;">₱0.00</span>
                            </div>
                            <div class="info-item">
                                <label class="info-label">Available Credit</label>
                                <span class="info-value" style="color: #059669; font-weight: 700;">₱10,000.00</span>
                            </div>
                            <div class="info-item">
                                <label class="info-label">Total Lifetime Value</label>
                                <span class="info-value" style="color: #1e40af; font-weight: 700;">₱4,250.00</span>
                            </div>
                            <div class="info-item">
                                <label class="info-label">Last Payment</label>
                                <span class="info-value">August 30, 2025</span>
                            </div>
                        </div>
                    </div>

                    <!-- Admin Notes & History -->
                    <h4 class="section-header">
                        <i data-lucide="file-text"></i>
                        Admin Notes & Actions
                    </h4>
                    <div class="form-group">
                        <label class="form-label">Internal Notes</label>
                        <textarea class="form-textarea" name="admin_notes" placeholder="Add internal notes about this customer... (Not visible to customer)">Customer requested VIP status. Good payment history. Potential for bulk orders.</textarea>
                    </div>

                    <!-- Quick Actions -->
                    <div class="quick-actions" style="margin-top: 2rem; padding: 1.5rem; background: #f8fafc; border-radius: 8px;">
                        <h5 style="margin-bottom: 1rem; color: #1e40af; display: flex; align-items: center; gap: 0.5rem;">
                            <i data-lucide="zap" style="width: 18px; height: 18px;"></i>
                            Quick Actions
                        </h5>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                            <button type="button" class="btn btn-secondary" onclick="showEmailModal()">
                                <i data-lucide="mail"></i> Send Email
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="viewOrderHistory()">
                                <i data-lucide="clipboard-list"></i> View Order History
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="showReportModal()">
                                <i data-lucide="bar-chart-3"></i> Generate Report
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="showPasswordResetModal()">
                                <i data-lucide="key"></i> Reset Password
                            </button>
                        </div>
                    </div>
                </form>

                <div class="form-actions">
                    <a href="index.php" class="btn btn-secondary">
                        <i data-lucide="x"></i> Cancel
                    </a>
                    <button type="button" class="btn btn-danger" onclick="showDeleteModal()">
                        <i data-lucide="trash-2"></i> Delete Customer
                    </button>
                    <button type="submit" form="editCustomerForm" class="btn btn-primary">
                        <i data-lucide="save"></i> Save Changes
                    </button>
                </div>
            </div>
        </main>
    </div>

    <!-- Email Modal -->
    <div id="emailModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i data-lucide="mail"></i>Send Email to Customer</h3>
                <button class="close-btn" onclick="closeModal('emailModal')">&times;</button>
            </div>
            <form id="emailForm">
                <div class="form-group">
                    <label class="form-label">To</label>
                    <input type="email" class="form-input" value="juan.delacruz@email.com" readonly>
                </div>
                <div class="form-group">
                    <label class="form-label">Template</label>
                    <select class="form-input" id="emailTemplate" onchange="updateEmailContent()">
                        <option value="custom">Custom Message</option>
                        <option value="account_update">Account Update Notification</option>
                        <option value="payment_reminder">Payment Reminder</option>
                        <option value="welcome">Welcome Message</option>
                        <option value="suspension">Account Suspension Notice</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Subject</label>
                    <input type="text" class="form-input" id="emailSubject" placeholder="Enter email subject" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Message</label>
                    <textarea class="form-textarea" id="emailMessage" placeholder="Enter your message here..." rows="6" required></textarea>
                </div>
                <div class="form-group">
                    <label class="checkbox-item">
                        <input type="checkbox" id="sendCopy"> Send copy to admin
                    </label>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('emailModal')">
                        <i data-lucide="x"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i data-lucide="send"></i> Send Email
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Report Modal -->
    <div id="reportModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i data-lucide="file-text"></i>Generate Customer Report</h3>
                <button class="close-btn" onclick="closeModal('reportModal')">&times;</button>
            </div>
            <form id="reportForm">
                <div class="form-group">
                    <label class="form-label">Report Type</label>
                    <select class="form-input" id="reportType" required>
                        <option value="">Select Report Type</option>
                        <option value="summary">Customer Summary</option>
                        <option value="orders">Order History</option>
                        <option value="financial">Financial Report</option>
                        <option value="activity">Activity Log</option>
                        <option value="complete">Complete Profile</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Date Range</label>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem;">
                        <input type="date" class="form-input" id="reportStartDate">
                        <input type="date" class="form-input" id="reportEndDate">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Format</label>
                    <select class="form-input" id="reportFormat" required>
                        <option value="pdf">PDF Document</option>
                        <option value="excel">Excel Spreadsheet</option>
                        <option value="csv">CSV File</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Include</label>
                    <div class="checkbox-group">
                        <label class="checkbox-item">
                            <input type="checkbox" checked> Personal Information
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" checked> Order Details
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox" checked> Payment History
                        </label>
                        <label class="checkbox-item">
                            <input type="checkbox"> Admin Notes
                        </label>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('reportModal')">
                        <i data-lucide="x"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i data-lucide="download"></i> Generate Report
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Password Reset Modal -->
    <div id="passwordResetModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i data-lucide="key"></i>Reset Customer Password</h3>
                <button class="close-btn" onclick="closeModal('passwordResetModal')">&times;</button>
            </div>
            <div class="warning-box">
                <p>
                    <strong><i data-lucide="alert-triangle" style="width: 14px; height: 14px; display: inline; margin-right: 4px;"></i>Warning:</strong> This will invalidate the customer's current password. They will receive an email with reset instructions.
                </p>
            </div>
            <form id="passwordResetForm">
                <div class="form-group">
                    <label class="form-label">Customer Email</label>
                    <input type="email" class="form-input" value="juan.delacruz@email.com" readonly>
                </div>
                <div class="form-group">
                    <label class="form-label">Reset Method</label>
                    <select class="form-input" id="resetMethod" required>
                        <option value="email">Send Reset Link via Email</option>
                        <option value="temporary">Generate Temporary Password</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Reason for Reset</label>
                    <select class="form-input" id="resetReason" required>
                        <option value="">Select Reason</option>
                        <option value="customer_request">Customer Request</option>
                        <option value="security_concern">Security Concern</option>
                        <option value="account_recovery">Account Recovery</option>
                        <option value="admin_action">Administrative Action</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Additional Notes</label>
                    <textarea class="form-textarea" id="resetNotes" placeholder="Optional notes about this password reset..." rows="3"></textarea>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('passwordResetModal')">
                        <i data-lucide="x"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i data-lucide="key"></i> Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content" style="max-width: 400px;">
            <div class="modal-header">
                <h3 style="color: #dc2626;"><i data-lucide="trash-2"></i>Delete Customer</h3>
                <button class="close-btn" onclick="closeModal('deleteModal')">&times;</button>
            </div>
            <div class="danger-box">
                <p>
                    <strong><i data-lucide="alert-triangle" style="width: 14px; height: 14px; display: inline; margin-right: 4px;"></i>Danger Zone:</strong> This action cannot be undone. All customer data, orders, and history will be permanently deleted.
                </p>
            </div>
            <div style="margin-bottom: 1.5rem;">
                <p><strong>Customer:</strong> Juan Dela Cruz</p>
                <p><strong>Total Orders:</strong> 8</p>
                <p><strong>Total Spent:</strong> ₱4,250</p>
                <p><strong>Outstanding Balance:</strong> ₱0.00</p>
            </div>
            <form id="deleteForm">
                <div class="form-group">
                    <label class="form-label">Reason for Deletion</label>
                    <select class="form-input" id="deleteReason" required>
                        <option value="">Select Reason</option>
                        <option value="customer_request">Customer Request (GDPR)</option>
                        <option value="duplicate_account">Duplicate Account</option>
                        <option value="fraudulent">Fraudulent Account</option>
                        <option value="inactive">Long-term Inactive</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Type "DELETE" to confirm</label>
                    <input type="text" class="form-input" id="deleteConfirm" placeholder="Type DELETE to confirm" required>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('deleteModal')">
                        <i data-lucide="x"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-danger" id="deleteBtn" disabled>
                        <i data-lucide="trash-2"></i> Delete Customer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        lucide.createIcons();

        // Form submission
        document.getElementById('editCustomerForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Show loading state
            const submitBtn = document.querySelector('button[form="editCustomerForm"]');
            const originalHTML = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i data-lucide="loader-2" style="animation: spin 1s linear infinite;"></i> Saving...';
            submitBtn.disabled = true;
            lucide.createIcons();

            // Simulate API call
            setTimeout(() => {
                alert('Customer information updated successfully!');
                submitBtn.innerHTML = originalHTML;
                submitBtn.disabled = false;
                lucide.createIcons();
                window.location.href = 'user-details.php?id=1';
            }, 1500);
        });

        // Modal Functions
        function showModal(modalId) {
            document.getElementById(modalId).classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('show');
            document.body.style.overflow = 'auto';
            // Reset forms when closing
            const form = document.querySelector(`#${modalId} form`);
            if (form) form.reset();
        }

        // Specific modal show functions
        function showEmailModal() { showModal('emailModal'); }
        function showReportModal() { showModal('reportModal'); }
        function showPasswordResetModal() { showModal('passwordResetModal'); }
        function showDeleteModal() { showModal('deleteModal'); }

        // Close modal when clicking outside
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal')) {
                closeModal(e.target.id);
            }
        });

        // ESC key to close modals
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const openModal = document.querySelector('.modal.show');
                if (openModal) {
                    closeModal(openModal.id);
                }
            }
        });

        // Email Template Function
        function updateEmailContent() {
            const template = document.getElementById('emailTemplate').value;
            const subjectInput = document.getElementById('emailSubject');
            const messageTextarea = document.getElementById('emailMessage');

            const templates = {
                account_update: {
                    subject: 'Your Account Has Been Updated',
                    message: 'Dear Juan,\n\nYour account information has been updated by our admin team. If you have any questions or concerns, please contact our support team.\n\nBest regards,\nM & E Team'
                },
                payment_reminder: {
                    subject: 'Payment Reminder - Outstanding Balance',
                    message: 'Dear Juan,\n\nThis is a friendly reminder that you have an outstanding balance on your account. Please review your account and process payment at your earliest convenience.\n\nThank you,\nM & E Billing Team'
                },
                welcome: {
                    subject: 'Welcome to M & E!',
                    message: 'Dear Juan,\n\nWelcome to M & E! We\'re excited to have you as part of our community. Your account is now active and ready to use.\n\nIf you need any assistance, don\'t hesitate to reach out.\n\nBest regards,\nM & E Team'
                },
                suspension: {
                    subject: 'Account Suspension Notice',
                    message: 'Dear Juan,\n\nWe are writing to inform you that your account has been temporarily suspended. Please contact our support team to resolve this matter.\n\nRegards,\nM & E Support Team'
                }
            };

            if (templates[template]) {
                subjectInput.value = templates[template].subject;
                messageTextarea.value = templates[template].message;
            } else {
                subjectInput.value = '';
                messageTextarea.value = '';
            }
        }

        // Form Submissions
        document.getElementById('emailForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const submitBtn = this.querySelector('.btn-primary');
            const originalHTML = submitBtn.innerHTML;

            submitBtn.innerHTML = '<i data-lucide="loader-2" style="animation: spin 1s linear infinite;"></i> Sending...';
            submitBtn.disabled = true;
            lucide.createIcons();

            setTimeout(() => {
                alert('Email sent successfully to juan.delacruz@email.com');
                closeModal('emailModal');
                submitBtn.innerHTML = originalHTML;
                submitBtn.disabled = false;
                lucide.createIcons();
            }, 2000);
        });

        document.getElementById('reportForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const reportType = document.getElementById('reportType').value;
            const format = document.getElementById('reportFormat').value;
            const submitBtn = this.querySelector('.btn-primary');
            const originalHTML = submitBtn.innerHTML;

            submitBtn.innerHTML = '<i data-lucide="loader-2" style="animation: spin 1s linear infinite;"></i> Generating...';
            submitBtn.disabled = true;
            lucide.createIcons();

            setTimeout(() => {
                alert(`${reportType.charAt(0).toUpperCase() + reportType.slice(1)} report generated successfully as ${format.toUpperCase()}!`);
                closeModal('reportModal');
                submitBtn.innerHTML = originalHTML;
                submitBtn.disabled = false;
                lucide.createIcons();
            }, 3000);
        });

        document.getElementById('passwordResetForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const method = document.getElementById('resetMethod').value;
            const submitBtn = this.querySelector('.btn-primary');
            const originalHTML = submitBtn.innerHTML;

            submitBtn.innerHTML = '<i data-lucide="loader-2" style="animation: spin 1s linear infinite;"></i> Processing...';
            submitBtn.disabled = true;
            lucide.createIcons();

            setTimeout(() => {
                if (method === 'email') {
                    alert('Password reset link sent to customer\'s email address.');
                } else {
                    alert('Temporary password generated and sent to customer.');
                }
                closeModal('passwordResetModal');
                submitBtn.innerHTML = originalHTML;
                submitBtn.disabled = false;
                lucide.createIcons();
            }, 2000);
        });

        // Delete confirmation
        document.getElementById('deleteConfirm').addEventListener('input', function(e) {
            const deleteBtn = document.getElementById('deleteBtn');
            deleteBtn.disabled = e.target.value !== 'DELETE';
        });

        document.getElementById('deleteForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const confirmation = document.getElementById('deleteConfirm').value;

            if (confirmation === 'DELETE') {
                const submitBtn = this.querySelector('.btn-danger');
                const originalHTML = submitBtn.innerHTML;

                submitBtn.innerHTML = '<i data-lucide="loader-2" style="animation: spin 1s linear infinite;"></i> Deleting...';
                submitBtn.disabled = true;
                lucide.createIcons();

                setTimeout(() => {
                    alert('Customer account deleted successfully.');
                    window.location.href = 'index.php';
                }, 2000);
            } else {
                alert('Please type "DELETE" to confirm deletion.');
            }
        });

        function viewOrderHistory() {
            window.open('user-orders.php?id=1', '_blank');
        }

        // Real-time credit limit validation
        document.querySelector('input[name="credit_limit"]').addEventListener('input', function(e) {
            const value = parseFloat(e.target.value) || 0;
            const availableCredit = document.querySelector('.financial-summary .info-item:nth-child(2) .info-value');
            if (availableCredit) {
                availableCredit.textContent = `₱${value.toLocaleString()}.00`;
                availableCredit.style.color = value > 0 ? '#059669' : '#dc2626';
            }
        });

        // Auto-save draft functionality
        let saveTimeout;
        const formInputs = document.querySelectorAll('.form-input, .form-select, .form-textarea');

        formInputs.forEach(input => {
            input.addEventListener('input', function() {
                clearTimeout(saveTimeout);
                saveTimeout = setTimeout(() => {
                    console.log('Auto-saving draft...');
                }, 2000);
            });
        });
    </script>
</body>
</html>
