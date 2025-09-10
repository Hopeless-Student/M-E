<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archive Messages - M & E Dashboard</title>
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

        /* Archive Stats */
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
            border-left: 4px solid #64748b;
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
            color: #64748b;
            margin-top: 0.5rem;
        }

        /* Archive Controls */
        .archive-controls {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .controls-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .controls-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1e40af;
        }

        .filter-controls {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-label {
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #374151;
            font-size: 0.9rem;
        }

        .form-select {
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-family: inherit;
            transition: border-color 0.2s ease;
        }

        .form-select:focus {
            outline: none;
            border-color: #1e40af;
        }

        /* Archive List */
        .archive-list {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .archive-list-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .list-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1e40af;
        }

        .bulk-actions {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .select-all-checkbox {
            margin-right: 1rem;
        }

        .bulk-btn {
            padding: 0.5rem 1rem;
            border: 1px solid #d1d5db;
            background: white;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.85rem;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .bulk-btn:hover {
            background-color: #f8fafc;
        }

        .bulk-btn.danger {
            color: #dc2626;
        }

        .bulk-btn.danger:hover {
            background-color: #fef2f2;
        }

        .archive-table {
            width: 100%;
            border-collapse: collapse;
        }

        .archive-table th,
        .archive-table td {
            padding: 1rem 1.5rem;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        .archive-table th {
            background-color: #f8fafc;
            font-weight: 600;
            color: #374151;
            font-size: 0.9rem;
        }

        .archive-table tbody tr:hover {
            background-color: #f8fafc;
        }

        .checkbox-cell {
            width: 40px;
        }

        .message-cell {
            max-width: 300px;
        }

        .message-from {
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 0.25rem;
        }

        .message-subject {
            color: #374151;
            margin-bottom: 0.25rem;
        }

        .message-preview {
            font-size: 0.85rem;
            color: #64748b;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .message-type {
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 500;
            display: inline-block;
        }

        .message-type.inquiry { background-color: #dbeafe; color: #1d4ed8; }
        .message-type.custom-order { background-color: #fef3c7; color: #92400e; }
        .message-type.complaint { background-color: #fee2e2; color: #dc2626; }
        .message-type.feedback { background-color: #d1fae5; color: #065f46; }

        .archive-date {
            color: #64748b;
            font-size: 0.85rem;
        }

        .action-cell {
            width: 120px;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .icon-btn {
            padding: 0.5rem;
            border: 1px solid #d1d5db;
            background: white;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon-btn:hover {
            background-color: #f8fafc;
        }

        .icon-btn.danger {
            color: #dc2626;
        }

        .icon-btn.danger:hover {
            background-color: #fef2f2;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1.5rem;
            gap: 0.5rem;
        }

        .pagination-btn {
            padding: 0.5rem 0.75rem;
            border: 1px solid #d1d5db;
            background: white;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .pagination-btn:hover {
            background-color: #f8fafc;
        }

        .pagination-btn.active {
            background-color: #1e40af;
            color: white;
        }

        .pagination-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #64748b;
        }

        .empty-state-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
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
            padding: 2rem;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
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

        .form-textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-family: inherit;
            min-height: 100px;
            resize: vertical;
        }

        .modal-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 2rem;
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

        .action-btn.danger {
            background-color: #dc2626;
            color: white;
        }

        .action-btn.danger:hover {
            background-color: #b91c1c;
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

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .filter-controls {
                grid-template-columns: 1fr;
            }

            .archive-table {
                font-size: 0.85rem;
            }

            .archive-table th,
            .archive-table td {
                padding: 0.75rem 0.5rem;
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
                <h2>Archived Messages</h2>
                <div class="header-actions">
                    <div class="search-box">
                        <i data-lucide="search" class="search-icon"></i>
                        <input type="text" class="search-input" placeholder="Search archived messages...">
                    </div>
                    <a href="./index.php" class="action-button secondary">
                        <i data-lucide="arrow-left" width="16" height="16"></i>
                        Back to Messages
                    </a>
                    <button class="action-button" onclick="openRestoreModal()">
                        <i data-lucide="rotate-ccw" width="16" height="16"></i>
                        Bulk Restore
                    </button>
                    <div class="user-info">
                        <span>Admin Panel</span>
                        <div class="avatar">A</div>
                    </div>
                </div>
            </div>

            <!-- Archive Stats -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-title">Total Archived</div>
                    <div class="stat-value">156</div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">This Month</div>
                    <div class="stat-value">23</div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">Auto-Archived</div>
                    <div class="stat-value">89</div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">Storage Saved</div>
                    <div class="stat-value">2.4GB</div>
                </div>
            </div>

            <!-- Archive Controls -->
            <div class="archive-controls">
                <div class="controls-header">
                    <h3 class="controls-title">Filter & Sort</h3>
                </div>
                <div class="filter-controls">
                    <div class="form-group">
                        <label class="form-label">Archive Date</label>
                        <select class="form-select" id="dateFilter">
                            <option value="">All dates</option>
                            <option value="today">Today</option>
                            <option value="week">This week</option>
                            <option value="month">This month</option>
                            <option value="quarter">Last 3 months</option>
                            <option value="year">This year</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Message Type</label>
                        <select class="form-select" id="typeFilter">
                            <option value="">All types</option>
                            <option value="inquiry">Inquiry</option>
                            <option value="custom-order">Custom Order</option>
                            <option value="complaint">Complaint</option>
                            <option value="feedback">Feedback</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Archive Reason</label>
                        <select class="form-select" id="reasonFilter">
                            <option value="">All reasons</option>
                            <option value="resolved">Resolved</option>
                            <option value="auto">Auto-archived</option>
                            <option value="manual">Manually archived</option>
                            <option value="expired">Expired</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Sort By</label>
                        <select class="form-select" id="sortFilter">
                            <option value="date_desc">Archive Date (Newest)</option>
                            <option value="date_asc">Archive Date (Oldest)</option>
                            <option value="customer">Customer Name</option>
                            <option value="type">Message Type</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Archive List -->
            <div class="archive-list">
                <div class="archive-list-header">
                    <h3 class="list-title">Archived Messages (156)</h3>
                    <div class="bulk-actions">
                        <input type="checkbox" class="select-all-checkbox" id="selectAll" onchange="toggleSelectAll()">
                        <label for="selectAll" style="margin-right: 1rem; font-size: 0.9rem;">Select All</label>
                        <button class="bulk-btn" onclick="bulkRestore()" id="restoreBtn" disabled>
                            <i data-lucide="rotate-ccw" width="14" height="14"></i>
                            Restore
                        </button>
                        <button class="bulk-btn danger" onclick="bulkDelete()" id="deleteBtn" disabled>
                            <i data-lucide="trash-2" width="14" height="14"></i>
                            Delete
                        </button>
                    </div>
                </div>

                <table class="archive-table">
                    <thead>
                        <tr>
                            <th class="checkbox-cell"></th>
                            <th>Message</th>
                            <th>Type</th>
                            <th>Original Date</th>
                            <th>Archived Date</th>
                            <th>Reason</th>
                            <th class="action-cell">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="archiveTableBody">
                        <tr>
                            <td class="checkbox-cell">
                                <input type="checkbox" class="message-checkbox" data-id="1" onchange="updateBulkActions()">
                            </td>
                            <td class="message-cell">
                                <div class="message-from">Juan Dela Cruz</div>
                                <div class="message-subject">Product Availability Inquiry</div>
                                <div class="message-preview">Hi, I'm looking for bulk ballpoint pens for our office...</div>
                            </td>
                            <td>
                                <div class="message-type inquiry">Inquiry</div>
                            </td>
                            <td class="archive-date">Aug 18, 2025</td>
                            <td class="archive-date">Aug 20, 2025</td>
                            <td class="archive-date">Resolved</td>
                            <td class="action-cell">
                                <div class="action-buttons">
                                    <button class="icon-btn" onclick="viewArchivedMessage(1)" title="View">
                                        <i data-lucide="eye" width="14" height="14"></i>
                                    </button>
                                    <button class="icon-btn" onclick="restoreMessage(1)" title="Restore">
                                        <i data-lucide="rotate-ccw" width="14" height="14"></i>
                                    </button>
                                    <button class="icon-btn danger" onclick="deleteMessage(1)" title="Delete Permanently">
                                        <i data-lucide="trash-2" width="14" height="14"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="checkbox-cell">
                                <input type="checkbox" class="message-checkbox" data-id="2" onchange="updateBulkActions()">
                            </td>
                            <td class="message-cell">
                                <div class="message-from">Maria Santos</div>
                                <div class="message-subject">Custom Order Request</div>
                                <div class="message-preview">I need customized notebooks with our school logo...</div>
                            </td>
                            <td>
                                <div class="message-type custom-order">Custom Order</div>
                            </td>
                            <td class="archive-date">Aug 15, 2025</td>
                            <td class="archive-date">Aug 19, 2025</td>
                            <td class="archive-date">Resolved</td>
                            <td class="action-cell">
                                <div class="action-buttons">
                                    <button class="icon-btn" onclick="viewArchivedMessage(2)" title="View">
                                        <i data-lucide="eye" width="14" height="14"></i>
                                    </button>
                                    <button class="icon-btn" onclick="restoreMessage(2)" title="Restore">
                                        <i data-lucide="rotate-ccw" width="14" height="14"></i>
                                    </button>
                                    <button class="icon-btn danger" onclick="deleteMessage(2)" title="Delete Permanently">
                                        <i data-lucide="trash-2" width="14" height="14"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="checkbox-cell">
                                <input type="checkbox" class="message-checkbox" data-id="3" onchange="updateBulkActions()">
                            </td>
                            <td class="message-cell">
                                <div class="message-from">Roberto Garcia</div>
                                <div class="message-subject">Positive Feedback</div>
                                <div class="message-preview">Great service! The delivery was fast and all items...</div>
                            </td>
                            <td>
                                <div class="message-type feedback">Feedback</div>
                            </td>
                            <td class="archive-date">Aug 10, 2025</td>
                            <td class="archive-date">Aug 17, 2025</td>
                            <td class="archive-date">Auto-archived</td>
                            <td class="action-cell">
                                <div class="action-buttons">
                                    <button class="icon-btn" onclick="viewArchivedMessage(3)" title="View">
                                        <i data-lucide="eye" width="14" height="14"></i>
                                    </button>
                                    <button class="icon-btn" onclick="restoreMessage(3)" title="Restore">
                                        <i data-lucide="rotate-ccw" width="14" height="14"></i>
                                    </button>
                                    <button class="icon-btn danger" onclick="deleteMessage(3)" title="Delete Permanently">
                                        <i data-lucide="trash-2" width="14" height="14"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="checkbox-cell">
                                <input type="checkbox" class="message-checkbox" data-id="4" onchange="updateBulkActions()">
                            </td>
                            <td class="message-cell">
                                <div class="message-from">Ana Reyes</div>
                                <div class="message-subject">Delivery Issue</div>
                                <div class="message-preview">My order was supposed to arrive yesterday but...</div>
                            </td>
                            <td>
                                <div class="message-type complaint">Complaint</div>
                            </td>
                            <td class="archive-date">Aug 12, 2025</td>
                            <td class="archive-date">Aug 16, 2025</td>
                            <td class="archive-date">Resolved</td>
                            <td class="action-cell">
                                <div class="action-buttons">
                                    <button class="icon-btn" onclick="viewArchivedMessage(4)" title="View">
                                        <i data-lucide="eye" width="14" height="14"></i>
                                    </button>
                                    <button class="icon-btn" onclick="restoreMessage(4)" title="Restore">
                                        <i data-lucide="rotate-ccw" width="14" height="14"></i>
                                    </button>
                                    <button class="icon-btn danger" onclick="deleteMessage(4)" title="Delete Permanently">
                                        <i data-lucide="trash-2" width="14" height="14"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="checkbox-cell">
                                <input type="checkbox" class="message-checkbox" data-id="5" onchange="updateBulkActions()">
                            </td>
                            <td class="message-cell">
                                <div class="message-from">Carlos Mendoza</div>
                                <div class="message-subject">Payment Options</div>
                                <div class="message-preview">Do you accept other payment methods aside from COD?...</div>
                            </td>
                            <td>
                                <div class="message-type inquiry">Inquiry</div>
                            </td>
                            <td class="archive-date">Aug 8, 2025</td>
                            <td class="archive-date">Aug 15, 2025</td>
                            <td class="archive-date">Auto-archived</td>
                            <td class="action-cell">
                                <div class="action-buttons">
                                    <button class="icon-btn" onclick="viewArchivedMessage(5)" title="View">
                                        <i data-lucide="eye" width="14" height="14"></i>
                                    </button>
                                    <button class="icon-btn" onclick="restoreMessage(5)" title="Restore">
                                        <i data-lucide="rotate-ccw" width="14" height="14"></i>
                                    </button>
                                    <button class="icon-btn danger" onclick="deleteMessage(5)" title="Delete Permanently">
                                        <i data-lucide="trash-2" width="14" height="14"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="pagination">
                    <button class="pagination-btn" disabled>
                        <i data-lucide="chevron-left" width="14" height="14"></i>
                    </button>
                    <button class="pagination-btn active">1</button>
                    <button class="pagination-btn">2</button>
                    <button class="pagination-btn">3</button>
                    <span style="margin: 0 1rem; color: #64748b;">...</span>
                    <button class="pagination-btn">15</button>
                    <button class="pagination-btn">16</button>
                    <button class="pagination-btn">
                        <i data-lucide="chevron-right" width="14" height="14"></i>
                    </button>
                </div>
            </div>
        </main>
    </div>

    <!-- Restore Modal -->
    <div class="modal-overlay" id="restoreModal">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title">Bulk Restore Messages</h3>
                <button class="close-btn" onclick="closeModal('restoreModal')">&times;</button>
            </div>
            <form onsubmit="handleBulkRestore(event)">
                <div class="form-group">
                    <label class="form-label">Restore To</label>
                    <select class="form-select" name="restoreTo" required>
                        <option value="">Select destination</option>
                        <option value="inbox">Main Inbox</option>
                        <option value="priority">Priority Queue</option>
                        <option value="follow-up">Follow-up Required</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Restore Reason (Optional)</label>
                    <textarea class="form-textarea" name="reason" placeholder="Enter reason for restoring these messages..."></textarea>
                </div>
                <div class="modal-actions">
                    <button type="button" class="action-btn secondary" onclick="closeModal('restoreModal')">Cancel</button>
                    <button type="submit" class="action-btn primary">Restore Messages</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal-overlay" id="deleteModal">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title">Confirm Deletion</h3>
                <button class="close-btn" onclick="closeModal('deleteModal')">&times;</button>
            </div>
            <p style="margin-bottom: 1.5rem; color: #64748b;">
                Are you sure you want to permanently delete the selected messages? This action cannot be undone.
            </p>
            <div class="modal-actions">
                <button type="button" class="action-btn secondary" onclick="closeModal('deleteModal')">Cancel</button>
                <button type="button" class="action-btn danger" onclick="confirmDelete()">Delete Permanently</button>
            </div>
        </div>
    </div>

    <!-- Notification -->
    <div class="notification" id="notification"></div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        let selectedMessages = [];
        let deleteTarget = null;

        // Search functionality
        document.querySelector('.search-input').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#archiveTableBody tr');

            rows.forEach(row => {
                const customerName = row.querySelector('.message-from').textContent.toLowerCase();
                const subject = row.querySelector('.message-subject').textContent.toLowerCase();
                const preview = row.querySelector('.message-preview').textContent.toLowerCase();

                if (customerName.includes(searchTerm) || subject.includes(searchTerm) || preview.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Filter functionality
        document.querySelectorAll('.form-select').forEach(select => {
            select.addEventListener('change', applyFilters);
        });

        function applyFilters() {
            const dateFilter = document.getElementById('dateFilter').value;
            const typeFilter = document.getElementById('typeFilter').value;
            const reasonFilter = document.getElementById('reasonFilter').value;
            const sortFilter = document.getElementById('sortFilter').value;

            // Apply filters (simplified for demo)
            console.log('Applying filters:', { dateFilter, typeFilter, reasonFilter, sortFilter });
            showNotification('Filters applied successfully', 'success');
        }

        // Select all functionality
        function toggleSelectAll() {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.message-checkbox');

            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked;
            });

            updateBulkActions();
        }

        // Update bulk actions
        function updateBulkActions() {
            const checkboxes = document.querySelectorAll('.message-checkbox:checked');
            const restoreBtn = document.getElementById('restoreBtn');
            const deleteBtn = document.getElementById('deleteBtn');

            selectedMessages = Array.from(checkboxes).map(cb => cb.dataset.id);

            if (selectedMessages.length > 0) {
                restoreBtn.disabled = false;
                deleteBtn.disabled = false;
            } else {
                restoreBtn.disabled = true;
                deleteBtn.disabled = true;
            }
        }

        // View archived message
        function viewArchivedMessage(id) {
            window.open('view-request.php?id=' + id + '&archived=true', '_blank');
        }

        // Restore single message
        function restoreMessage(id) {
            if (confirm('Are you sure you want to restore this message to the inbox?')) {
                // Simulate restore
                setTimeout(() => {
                    showNotification('Message restored successfully', 'success');
                    removeMessageRow(id);
                }, 500);
            }
        }

        // Delete single message
        function deleteMessage(id) {
            deleteTarget = [id];
            document.getElementById('deleteModal').classList.add('active');
        }

        // Bulk restore
        function bulkRestore() {
            if (selectedMessages.length === 0) return;
            document.getElementById('restoreModal').classList.add('active');
        }

        // Bulk delete
        function bulkDelete() {
            if (selectedMessages.length === 0) return;
            deleteTarget = selectedMessages.slice();
            document.getElementById('deleteModal').classList.add('active');
        }

        // Open restore modal
        function openRestoreModal() {
            document.getElementById('restoreModal').classList.add('active');
        }

        // Handle bulk restore
        function handleBulkRestore(event) {
            event.preventDefault();
            const formData = new FormData(event.target);
            const restoreTo = formData.get('restoreTo');
            const reason = formData.get('reason');

            setTimeout(() => {
                showNotification(`${selectedMessages.length} messages restored to ${restoreTo}`, 'success');
                closeModal('restoreModal');
                selectedMessages.forEach(id => removeMessageRow(id));
                selectedMessages = [];
                updateBulkActions();
            }, 1000);
        }

        // Confirm delete
        function confirmDelete() {
            setTimeout(() => {
                showNotification(`${deleteTarget.length} message(s) deleted permanently`, 'success');
                closeModal('deleteModal');
                deleteTarget.forEach(id => removeMessageRow(id));
                deleteTarget = null;
                selectedMessages = [];
                updateBulkActions();
            }, 500);
        }

        // Remove message row
        function removeMessageRow(id) {
            const checkbox = document.querySelector(`.message-checkbox[data-id="${id}"]`);
            if (checkbox) {
                checkbox.closest('tr').remove();
            }
        }

        // Modal functions
        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('active');
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
            updateBulkActions();
        });
    </script>
</body>
</html>
