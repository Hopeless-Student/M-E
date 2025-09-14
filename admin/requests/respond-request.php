<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Response Templates - M & E Dashboard</title>
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
            width: 200px;
            height: 200px;
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
            padding: 0 2rem 2rem;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 2rem;
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
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .header h2 {
            font-size: 2rem;
            font-weight: 600;
            color: #1e40af;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .search-box {
            position: relative;
        }

        .search-input {
            padding: 0.75rem 1rem 0.75rem 2.5rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            width: 250px;
            font-size: 0.9rem;
        }

        .search-icon {
            position: absolute;
            left: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
        }

        .action-button {
            padding: 0.75rem 1.5rem;
            background-color: #1e40af;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .action-button:hover {
            background-color: #1e3a8a;
        }

        .action-button.secondary {
            background-color: #64748b;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        /* Template Stats */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border-left: 4px solid #10b981;
            transition: transform 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
        }

        .stat-title {
            color: #64748b;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: #10b981;
            margin-top: 0.5rem;
        }

        /* Template Categories */
        .template-layout {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 2rem;
        }

        .template-categories {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .categories-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
        }

        .categories-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1e40af;
        }

        .category-list {
            list-style: none;
        }

        .category-item {
            margin: 0;
        }

        .category-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 1.5rem;
            color: #374151;
            text-decoration: none;
            transition: all 0.2s ease;
            border-left: 4px solid transparent;
        }

        .category-link:hover, .category-link.active {
            background-color: #f8fafc;
            border-left-color: #1e40af;
            color: #1e40af;
        }

        .category-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .category-count {
            background-color: #e2e8f0;
            color: #64748b;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .category-link.active .category-count {
            background-color: #1e40af;
            color: white;
        }

        /* Template Grid */
        .template-panel {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .panel-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .panel-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1e40af;
        }

        .view-toggle {
            display: flex;
            gap: 0.5rem;
        }

        .toggle-btn {
            padding: 0.5rem;
            border: 1px solid #d1d5db;
            background: white;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .toggle-btn.active {
            background-color: #1e40af;
            color: white;
        }

        .templates-container {
            padding: 1.5rem;
        }

        .template-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .template-card {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .template-card:hover {
            border-color: #1e40af;
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(30, 64, 175, 0.1);
        }

        .template-header {
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
            background-color: #f8fafc;
        }

        .template-title {
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .template-meta {
            font-size: 0.85rem;
            color: #64748b;
            display: flex;
            gap: 1rem;
        }

        .template-content {
            padding: 1rem;
        }

        .template-preview {
            font-size: 0.9rem;
            color: #374151;
            line-height: 1.5;
            margin-bottom: 1rem;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }

        .template-actions {
            display: flex;
            gap: 0.5rem;
        }

        .template-btn {
            flex: 1;
            padding: 0.5rem 1rem;
            border: 1px solid #d1d5db;
            background: white;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .template-btn:hover {
            background-color: #f8fafc;
        }

        .template-btn.primary {
            background-color: #1e40af;
            color: white;
            border-color: #1e40af;
        }

        .template-btn.primary:hover {
            background-color: #1e3a8a;
        }

        .usage-badge {
            background-color: #10b981;
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: 500;
        }

        .list-view .template-card {
            display: grid;
            grid-template-columns: 1fr auto;
            align-items: center;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 0.75rem;
        }

        .list-view .template-card:last-child {
            margin-bottom: 0;
        }

        .list-view .template-header {
            padding: 0;
            border: none;
            background: none;
        }

        .list-view .template-content {
            padding: 0;
            margin-left: 2rem;
        }

        .list-view .template-actions {
            margin-left: auto;
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal {
            background: white;
            border-radius: 12px;
            padding: 0;
            max-width: 700px;
            width: 90%;
            max-height: 90vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .modal-header {
            padding: 2rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1e40af;
        }

        .close-btn {
            border: none;
            background: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #64748b;
        }

        .modal-body {
            padding: 2rem;
            flex: 1;
            overflow-y: auto;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #374151;
        }

        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-family: inherit;
            transition: border-color 0.2s ease;
        }

        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: #1e40af;
        }

        .form-textarea {
            resize: vertical;
            min-height: 200px;
        }

        .template-variables {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .variables-title {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .variables-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .variable-tag {
            background-color: #e2e8f0;
            color: #64748b;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-family: monospace;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .variable-tag:hover {
            background-color: #1e40af;
            color: white;
        }

        .modal-actions {
            padding: 2rem;
            border-top: 1px solid #e2e8f0;
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
        }

        .action-btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .action-btn.primary {
            background-color: #1e40af;
            color: white;
        }

        .action-btn.primary:hover {
            background-color: #1e3a8a;
        }

        .action-btn.secondary {
            background-color: #e2e8f0;
            color: #64748b;
        }

        .action-btn.secondary:hover {
            background-color: #cbd5e1;
        }

        /* Notification */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 1rem 1.5rem;
            background-color: #10b981;
            color: white;
            border-radius: 8px;
            transform: translateX(100%);
            transition: transform 0.3s ease;
            z-index: 1001;
        }

        .notification.show {
            transform: translateX(0);
        }

        .notification.error {
            background-color: #dc2626;
        }

        @media (max-width: 768px) {
            .dashboard {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
            }

            .template-layout {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .template-grid {
                grid-template-columns: 1fr;
            }

            .search-input {
                width: 200px;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <nav class="sidebar">
            <div class="logo">
                <img src="M-E_logo.png" alt="">
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
                    <a href="../users/index.php" class="nav-link">
                        <i data-lucide="users"></i> Customers
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../inventory/index.php" class="nav-link">
                        <i data-lucide="clipboard-list"></i> Inventory
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./index.php" class="nav-link active">
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

        <!-- Main Content -->
        <main class="main-content">
            <div class="header">
                <h2>Response Templates</h2>
                <div class="header-actions">
                    <div class="search-box">
                        <i data-lucide="search" class="search-icon"></i>
                        <input type="text" class="search-input" placeholder="Search templates...">
                    </div>
                    <a href="./index.php" class="action-button secondary">
                        <i data-lucide="arrow-left" width="16" height="16"></i>
                        Back to Messages
                    </a>
                    <button class="action-button" onclick="createTemplate()">
                        <i data-lucide="plus" width="16" height="16"></i>
                        New Template
                    </button>
                    <div class="user-info">
                        <span>Admin Panel</span>
                        <div class="avatar">A</div>
                    </div>
                </div>
            </div>

            <!-- Template Stats -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-title">Total Templates</div>
                    <div class="stat-value">24</div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">Most Used</div>
                    <div class="stat-value">Product Info</div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">This Month Usage</div>
                    <div class="stat-value">156</div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">Avg Response Time</div>
                    <div class="stat-value">45s</div>
                </div>
            </div>

            <!-- Template Layout -->
            <div class="template-layout">
                <!-- Categories -->
                <div class="template-categories">
                    <div class="categories-header">
                        <h3 class="categories-title">Categories</h3>
                    </div>
                    <ul class="category-list">
                        <li class="category-item">
                            <a href="#" class="category-link active" data-category="all">
                                <div class="category-info">
                                    <i data-lucide="folder" width="16" height="16"></i>
                                    <span>All Templates</span>
                                </div>
                                <span class="category-count">24</span>
                            </a>
                        </li>
                        <li class="category-item">
                            <a href="#" class="category-link" data-category="inquiry">
                                <div class="category-info">
                                    <i data-lucide="help-circle" width="16" height="16"></i>
                                    <span>Product Inquiry</span>
                                </div>
                                <span class="category-count">8</span>
                            </a>
                        </li>
                        <li class="category-item">
                            <a href="#" class="category-link" data-category="orders">
                                <div class="category-info">
                                    <i data-lucide="shopping-bag" width="16" height="16"></i>
                                    <span>Order Related</span>
                                </div>
                                <span class="category-count">6</span>
                            </a>
                        </li>
                        <li class="category-item">
                            <a href="#" class="category-link" data-category="support">
                                <div class="category-info">
                                    <i data-lucide="headphones" width="16" height="16"></i>
                                    <span>Customer Support</span>
                                </div>
                                <span class="category-count">5</span>
                            </a>
                        </li>
                        <li class="category-item">
                            <a href="#" class="category-link" data-category="feedback">
                                <div class="category-info">
                                    <i data-lucide="star" width="16" height="16"></i>
                                    <span>Feedback Response</span>
                                </div>
                                <span class="category-count">3</span>
                            </a>
                        </li>
                        <li class="category-item">
                            <a href="#" class="category-link" data-category="custom">
                                <div class="category-info">
                                    <i data-lucide="edit-3" width="16" height="16"></i>
                                    <span>Custom Orders</span>
                                </div>
                                <span class="category-count">2</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Templates Panel -->
                <div class="template-panel">
                    <div class="panel-header">
                        <h3 class="panel-title">All Templates (24)</h3>
                        <div class="view-toggle">
                            <button class="toggle-btn active" onclick="switchView('grid')" title="Grid View">
                                <i data-lucide="grid-3x3" width="16" height="16"></i>
                            </button>
                            <button class="toggle-btn" onclick="switchView('list')" title="List View">
                                <i data-lucide="list" width="16" height="16"></i>
                            </button>
                        </div>
                    </div>

                    <div class="templates-container">
                        <div class="template-grid" id="templateGrid">
                            <!-- Product Availability Template -->
                            <div class="template-card" data-category="inquiry">
                                <div class="template-header">
                                    <div class="template-title">
                                        Product Availability
                                        <span class="usage-badge">Most Used</span>
                                    </div>
                                    <div class="template-meta">
                                        <span>Used 45 times</span>
                                        <span>Last updated: Aug 15</span>
                                    </div>
                                </div>
                                <div class="template-content">
                                    <div class="template-preview">
                                        Dear {{customer_name}},

Thank you for your inquiry about {{product_name}}. Yes, we have the quantity you need available in stock. For bulk orders of {{quantity}}+ pieces, we offer a {{discount}}% discount...
                                    </div>
                                    <div class="template-actions">
                                        <button class="template-btn primary" onclick="useTemplate('product-availability')">
                                            <i data-lucide="send" width="14" height="14"></i>
                                            Use Template
                                        </button>
                                        <button class="template-btn" onclick="editTemplate('order-confirmation')">
                                            <i data-lucide="edit-2" width="14" height="14"></i>
                                            Edit
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Complaint Resolution Template -->
                            <div class="template-card" data-category="support">
                                <div class="template-header">
                                    <div class="template-title">Complaint Resolution</div>
                                    <div class="template-meta">
                                        <span>Used 28 times</span>
                                        <span>Last updated: Aug 10</span>
                                    </div>
                                </div>
                                <div class="template-content">
                                    <div class="template-preview">
                                        Dear {{customer_name}},

We sincerely apologize for the inconvenience you've experienced with {{issue_description}}. We take all customer concerns seriously and will investigate this matter immediately...
                                    </div>
                                    <div class="template-actions">
                                        <button class="template-btn primary" onclick="useTemplate('complaint-resolution')">
                                            <i data-lucide="send" width="14" height="14"></i>
                                            Use Template
                                        </button>
                                        <button class="template-btn" onclick="editTemplate('complaint-resolution')">
                                            <i data-lucide="edit-2" width="14" height="14"></i>
                                            Edit
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Delivery Information Template -->
                            <div class="template-card" data-category="orders">
                                <div class="template-header">
                                    <div class="template-title">Delivery Information</div>
                                    <div class="template-meta">
                                        <span>Used 25 times</span>
                                        <span>Last updated: Aug 8</span>
                                    </div>
                                </div>
                                <div class="template-content">
                                    <div class="template-preview">
                                        Dear {{customer_name}},

Your order #{{order_id}} has been shipped and is on its way to {{delivery_address}}.

Tracking Number: {{tracking_number}}
Estimated Delivery: {{delivery_date}}...
                                    </div>
                                    <div class="template-actions">
                                        <button class="template-btn primary" onclick="useTemplate('delivery-info')">
                                            <i data-lucide="send" width="14" height="14"></i>
                                            Use Template
                                        </button>
                                        <button class="template-btn" onclick="editTemplate('delivery-info')">
                                            <i data-lucide="edit-2" width="14" height="14"></i>
                                            Edit
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Thank You Response Template -->
                            <div class="template-card" data-category="feedback">
                                <div class="template-header">
                                    <div class="template-title">Thank You Response</div>
                                    <div class="template-meta">
                                        <span>Used 22 times</span>
                                        <span>Last updated: Aug 5</span>
                                    </div>
                                </div>
                                <div class="template-content">
                                    <div class="template-preview">
                                        Dear {{customer_name}},

Thank you so much for your positive feedback! We're delighted to hear that you're satisfied with {{product_service}}.

Customer satisfaction is our top priority...
                                    </div>
                                    <div class="template-actions">
                                        <button class="template-btn primary" onclick="useTemplate('thank-you')">
                                            <i data-lucide="send" width="14" height="14"></i>
                                            Use Template
                                        </button>
                                        <button class="template-btn" onclick="editTemplate('thank-you')">
                                            <i data-lucide="edit-2" width="14" height="14"></i>
                                            Edit
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Custom Order Quote Template -->
                            <div class="template-card" data-category="custom">
                                <div class="template-header">
                                    <div class="template-title">Custom Order Quote</div>
                                    <div class="template-meta">
                                        <span>Used 18 times</span>
                                        <span>Last updated: Aug 3</span>
                                    </div>
                                </div>
                                <div class="template-content">
                                    <div class="template-preview">
                                        Dear {{customer_name}},

Thank you for your custom order inquiry for {{custom_item}}. Based on your requirements, here's our detailed quote:

{{quote_details}}

Timeline: {{delivery_timeline}}...
                                    </div>
                                    <div class="template-actions">
                                        <button class="template-btn primary" onclick="useTemplate('custom-quote')">
                                            <i data-lucide="send" width="14" height="14"></i>
                                            Use Template
                                        </button>
                                        <button class="template-btn" onclick="editTemplate('custom-quote')">
                                            <i data-lucide="edit-2" width="14" height="14"></i>
                                            Edit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Template Editor Modal -->
    <div class="modal-overlay" id="templateModal">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title" id="modalTitle">Edit Template</h3>
                <button class="close-btn" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body">
                <form id="templateForm" onsubmit="saveTemplate(event)">
                    <div class="form-group">
                        <label class="form-label">Template Name</label>
                        <input type="text" class="form-input" name="name" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Category</label>
                        <select class="form-select" name="category" required>
                            <option value="inquiry">Product Inquiry</option>
                            <option value="orders">Order Related</option>
                            <option value="support">Customer Support</option>
                            <option value="feedback">Feedback Response</option>
                            <option value="custom">Custom Orders</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Subject Line</label>
                        <input type="text" class="form-input" name="subject" placeholder="Email subject (optional)">
                    </div>

                    <div class="template-variables">
                        <div class="variables-title">Available Variables (click to insert)</div>
                        <div class="variables-list">
                            <span class="variable-tag" onclick="insertVariable('{{customer_name}}')">{{customer_name}}</span>
                            <span class="variable-tag" onclick="insertVariable('{{order_id}}')">{{order_id}}</span>
                            <span class="variable-tag" onclick="insertVariable('{{product_name}}')">{{product_name}}</span>
                            <span class="variable-tag" onclick="insertVariable('{{quantity}}')">{{quantity}}</span>
                            <span class="variable-tag" onclick="insertVariable('{{price}}')">{{price}}</span>
                            <span class="variable-tag" onclick="insertVariable('{{delivery_date}}')">{{delivery_date}}</span>
                            <span class="variable-tag" onclick="insertVariable('{{tracking_number}}')">{{tracking_number}}</span>
                            <span class="variable-tag" onclick="insertVariable('{{company_name}}')">{{company_name}}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Template Content</label>
                        <textarea class="form-textarea" name="content" id="templateContent" required placeholder="Enter your template content here..."></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Usage Notes (Internal)</label>
                        <textarea class="form-input" name="notes" rows="3" placeholder="Optional notes about when to use this template..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-actions">
                <button type="button" class="action-btn secondary" onclick="closeModal()">Cancel</button>
                <button type="submit" form="templateForm" class="action-btn primary">Save Template</button>
            </div>
        </div>
    </div>

    <!-- Template Usage Modal -->
    <div class="modal-overlay" id="useTemplateModal">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title">Use Template</h3>
                <button class="close-btn" onclick="closeModal('useTemplateModal')">&times;</button>
            </div>
            <div class="modal-body">
                <form id="useTemplateForm" onsubmit="sendTemplateResponse(event)">
                    <div class="form-group">
                        <label class="form-label">To:</label>
                        <input type="email" class="form-input" name="recipient" value="juan.delacruz@email.com" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Subject:</label>
                        <input type="text" class="form-input" name="subject" id="templateSubject" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Message:</label>
                        <textarea class="form-textarea" name="message" id="templateMessage" required></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Priority:</label>
                        <select class="form-select" name="priority">
                            <option value="normal">Normal</option>
                            <option value="high">High</option>
                            <option value="urgent">Urgent</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-actions">
                <button type="button" class="action-btn secondary" onclick="closeModal('useTemplateModal')">Cancel</button>
                <button type="submit" form="useTemplateForm" class="action-btn primary">Send Response</button>
            </div>
        </div>
    </div>

    <!-- Notification -->
    <div class="notification" id="notification"></div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Template data
        const templates = {
            'product-availability': {
                name: 'Product Availability',
                category: 'inquiry',
                subject: 'RE: Product Availability Inquiry',
                content: `Dear {{customer_name}},

Thank you for your inquiry about {{product_name}}. Yes, we have the quantity you need available in stock. For bulk orders of {{quantity}}+ pieces, we offer a {{discount}}% discount.

Here are the details:
- Regular price: ₱{{regular_price}} per pack
- Bulk price: ₱{{bulk_price}} per pack
- Total for {{quantity}} pieces: ₱{{total_price}}
- Delivery to {{location}}: ₱{{delivery_fee}}

Would you like to proceed with this order?

Best regards,
M & E Team`,
                notes: 'Use when customer inquires about product availability and pricing'
            },
            'order-confirmation': {
                name: 'Order Confirmation',
                category: 'orders',
                subject: 'Order Confirmation - #{{order_id}}',
                content: `Dear {{customer_name}},

Thank you for your order #{{order_id}}. We have received your order and it is being processed.

Your order details:
{{order_details}}

Payment Method: {{payment_method}}
Estimated delivery: {{delivery_date}}
Delivery Address: {{delivery_address}}

You will receive a tracking number once your order ships.

Best regards,
M & E Team`,
                notes: 'Send immediately after order is placed'
            },
            'complaint-resolution': {
                name: 'Complaint Resolution',
                category: 'support',
                subject: 'RE: {{complaint_subject}}',
                content: `Dear {{customer_name}},

We sincerely apologize for the inconvenience you've experienced with {{issue_description}}. We take all customer concerns seriously and will investigate this matter immediately.

We will:
1. {{action_1}}
2. {{action_2}}
3. {{action_3}}

We will provide you with an update within {{timeline}}.

Thank you for your patience and for giving us the opportunity to make this right.

Best regards,
M & E Team`,
                notes: 'Use for customer complaints and issues'
            }
        };

        let currentView = 'grid';

        // Search functionality
        document.querySelector('.search-input').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const cards = document.querySelectorAll('.template-card');

            cards.forEach(card => {
                const title = card.querySelector('.template-title').textContent.toLowerCase();
                const preview = card.querySelector('.template-preview').textContent.toLowerCase();

                if (title.includes(searchTerm) || preview.includes(searchTerm)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Category filtering
        document.querySelectorAll('.category-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();

                // Update active category
                document.querySelectorAll('.category-link').forEach(l => l.classList.remove('active'));
                this.classList.add('active');

                const category = this.dataset.category;
                const cards = document.querySelectorAll('.template-card');

                cards.forEach(card => {
                    if (category === 'all' || card.dataset.category === category) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Update panel title
                const panelTitle = document.querySelector('.panel-title');
                const categoryName = this.querySelector('span').textContent;
                const count = this.querySelector('.category-count').textContent;
                panelTitle.textContent = `${categoryName} (${count})`;
            });
        });

        // View toggle
        function switchView(view) {
            currentView = view;
            const grid = document.getElementById('templateGrid');
            const toggleBtns = document.querySelectorAll('.toggle-btn');

            toggleBtns.forEach(btn => btn.classList.remove('active'));
            event.target.closest('.toggle-btn').classList.add('active');

            if (view === 'list') {
                grid.classList.add('list-view');
                grid.style.display = 'block';
            } else {
                grid.classList.remove('list-view');
                grid.style.display = 'grid';
            }
        }

        // Template actions
        function useTemplate(templateId) {
            const template = templates[templateId];
            if (!template) return;

            // Populate the use template modal
            document.getElementById('templateSubject').value = template.subject;
            document.getElementById('templateMessage').value = template.content;

            // Show modal
            document.getElementById('useTemplateModal').classList.add('active');
        }

        function editTemplate(templateId) {
            const template = templates[templateId] || {
                name: '',
                category: 'inquiry',
                subject: '',
                content: '',
                notes: ''
            };

            // Populate form
            const form = document.getElementById('templateForm');
            form.name.value = template.name;
            form.category.value = template.category;
            form.subject.value = template.subject;
            form.content.value = template.content;
            form.notes.value = template.notes;

            // Update modal title
            document.getElementById('modalTitle').textContent = templateId ? 'Edit Template' : 'Create New Template';

            // Show modal
            document.getElementById('templateModal').classList.add('active');
        }

        function createTemplate() {
            editTemplate(null);
        }

        // Modal functions
        function closeModal(modalId = 'templateModal') {
            document.getElementById(modalId).classList.remove('active');
        }

        // Insert variable into template content
        function insertVariable(variable) {
            const textarea = document.getElementById('templateContent');
            const cursorPos = textarea.selectionStart;
            const textBefore = textarea.value.substring(0, cursorPos);
            const textAfter = textarea.value.substring(cursorPos);

            textarea.value = textBefore + variable + textAfter;
            textarea.focus();
            textarea.setSelectionRange(cursorPos + variable.length, cursorPos + variable.length);
        }

        // Save template
        function saveTemplate(event) {
            event.preventDefault();
            const formData = new FormData(event.target);

            // Simulate saving
            setTimeout(() => {
                showNotification('Template saved successfully!', 'success');
                closeModal('templateModal');
            }, 1000);
        }

        // Send template response
        function sendTemplateResponse(event) {
            event.preventDefault();
            const formData = new FormData(event.target);

            // Simulate sending
            setTimeout(() => {
                showNotification('Response sent successfully!', 'success');
                closeModal('useTemplateModal');
            }, 1000);
        }

        // Notification system
        function showNotification(message, type = 'success') {
            const notification = document.getElementById('notification');
            notification.textContent = message;
            notification.className = `notification ${type}`;
            notification.classList.add('show');

            setTimeout(() => {
                notification.classList.remove('show');
            }, 3000);
        }

        // Close modals when clicking outside
        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.remove('active');
                }
            });
        });

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            // Set up any initial state
            console.log('Response Templates page loaded');
        });
    </script>
</body>
</html>product-availability')">
                                            <i data-lucide="edit-2" width="14" height="14"></i>
                                            Edit
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Confirmation Template -->
                            <div class="template-card" data-category="orders">
                                <div class="template-header">
                                    <div class="template-title">Order Confirmation</div>
                                    <div class="template-meta">
                                        <span>Used 32 times</span>
                                        <span>Last updated: Aug 12</span>
                                    </div>
                                </div>
                                <div class="template-content">
                                    <div class="template-preview">
                                        Dear {{customer_name}},

Thank you for your order #{{order_id}}. We have received your order and it is being processed. Your order details:

{{order_details}}

Estimated delivery: {{delivery_date}}
                                    </div>
                                    <div class="template-actions">
                                        <button class="template-btn primary" onclick="useTemplate('order-confirmation')">
                                            <i data-lucide="send" width="14" height="14"></i>
                                            Use Template
                                        </button>
                                        <button class="template-btn" onclick="editTemplate('
