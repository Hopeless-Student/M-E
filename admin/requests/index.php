<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages - M & E Dashboard</title>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <link rel="stylesheet" href="../assets/css/admin/requests/index.css">
    <style>
        /* General Modal Styles (to be shared across modals) */
        .app-modal-overlay {
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

        .app-modal-overlay.active {
            display: flex;
        }

        .app-modal {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            max-width: 700px; /* Increased max-width for better content display */
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .app-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .app-modal-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1e40af;
        }

        .app-modal-close-btn {
            border: none;
            background: none;
            font-size: 1.8rem;
            cursor: pointer;
            color: #64748b;
            line-height: 1;
            padding: 0.2rem 0.5rem;
            border-radius: 6px;
            transition: background-color 0.2s ease;
        }
        .app-modal-close-btn:hover {
            background-color: #f0f4f8;
        }

        .app-modal-body {
            flex-grow: 1;
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        .app-modal-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px solid #e2e8f0;
        }

        /* Form Group Styles (for modals) */
        .app-form-group {
            margin-bottom: 1.5rem;
        }

        .app-form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #374151;
            font-size: 0.95rem;
        }

        .app-form-input, .app-form-select, .app-form-textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-family: inherit;
            font-size: 0.9rem;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .app-form-input:focus, .app-form-select:focus, .app-form-textarea:focus {
            outline: none;
            border-color: #1e40af;
            box-shadow: 0 0 0 2px rgba(30, 64, 175, 0.2);
        }

        .app-form-textarea {
            min-height: 120px;
            resize: vertical;
        }

        /* Action Button Styles (for modals) */
        .app-action-btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s ease;
            font-size: 0.9rem;
        }

        .app-action-btn.primary {
            background-color: #1e40af;
            color: white;
        }

        .app-action-btn.primary:hover {
            background-color: #1e3a8a;
        }

        .app-action-btn.secondary {
            background-color: #e2e8f0;
            color: #64748b;
        }

        .app-action-btn.secondary:hover {
            background-color: #cbd5e1;
        }

        .app-action-btn.danger {
            background-color: #dc2626;
            color: white;
        }

        .app-action-btn.danger:hover {
            background-color: #b91c1c;
        }

        /* Specific styles for the main page's modals */
        #archiveModal .app-modal, #responseModal .app-modal {
            max-width: 600px;
        }
        #archiveModal .app-modal-title, #responseModal .app-modal-title {
            font-size: 1.25rem;
        }

        /* Notification styles */
        .app-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 1rem 1.5rem;
            background-color: #10b981;
            color: white;
            border-radius: 8px;
            transform: translateX(100%);
            transition: transform 0.3s ease-out;
            z-index: 1001;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            min-width: 250px;
            text-align: center;
        }

        .app-notification.show {
            transform: translateX(0);
        }

        .app-notification.error {
            background-color: #dc2626;
        }
        .app-notification.info {
            background-color: #2563eb;
        }

        /* Sidebar specific styles for active link */
        .nav-menu .nav-item .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            border-left-color: #60a5fa;
        }

        /* Archive Modal Specific Styles */
        #archiveModal .app-modal {
            max-width: 900px; /* Wider for table content */
        }
        #archiveModal .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        #archiveModal .stat-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 1rem;
            text-align: center;
        }
        #archiveModal .stat-title {
            font-size: 0.85rem;
            color: #64748b;
            margin-bottom: 0.5rem;
        }
        #archiveModal .stat-value {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1e40af;
        }
        #archiveModal .archive-controls {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        #archiveModal .controls-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        #archiveModal .controls-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #374151;
        }
        #archiveModal .filter-controls {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }
        #archiveModal .archive-list-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #e2e8f0;
        }
        #archiveModal .list-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #374151;
        }
        #archiveModal .bulk-actions {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        #archiveModal .bulk-btn {
            padding: 0.5rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            background-color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            font-weight: 500;
            color: #374151;
            transition: background-color 0.2s ease;
        }
        #archiveModal .bulk-btn:hover:not(:disabled) {
            background-color: #f0f4f8;
        }
        #archiveModal .bulk-btn.danger {
            background-color: #fee2e2;
            color: #dc2626;
            border-color: #fca5a5;
        }
        #archiveModal .bulk-btn.danger:hover:not(:disabled) {
            background-color: #fecaca;
        }
        #archiveModal .bulk-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        #archiveModal .archive-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1.5rem;
        }
        #archiveModal .archive-table th, #archiveModal .archive-table td {
            padding: 0.75rem;
            border-bottom: 1px solid #e2e8f0;
            text-align: left;
        }
        #archiveModal .archive-table th {
            background-color: #f8fafc;
            font-size: 0.85rem;
            font-weight: 600;
            color: #475569;
            text-transform: uppercase;
        }
        #archiveModal .archive-table td {
            font-size: 0.9rem;
            color: #374151;
        }
        #archiveModal .checkbox-cell {
            width: 30px;
            text-align: center;
        }
        #archiveModal .message-cell {
            min-width: 250px;
        }
        #archiveModal .message-from {
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        #archiveModal .message-subject {
            color: #1e40af;
            font-weight: 500;
            margin-bottom: 0.25rem;
        }
        #archiveModal .message-preview {
            font-size: 0.8rem;
            color: #64748b;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 200px;
        }
        #archiveModal .message-type {
            padding: 0.3rem 0.6rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 500;
            display: inline-block;
        }
        #archiveModal .message-type.inquiry { background-color: #dbeafe; color: #1d4ed8; }
        #archiveModal .message-type.custom-order { background-color: #fef3c7; color: #92400e; }
        #archiveModal .message-type.complaint { background-color: #fee2e2; color: #dc2626; }
        #archiveModal .message-type.feedback { background-color: #d1fae5; color: #065f46; }
        #archiveModal .action-cell {
            width: 120px;
            text-align: center;
        }
        #archiveModal .action-buttons {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
        }
        #archiveModal .icon-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.4rem;
            border-radius: 4px;
            transition: background-color 0.2s ease;
            color: #64748b;
        }
        #archiveModal .icon-btn:hover {
            background-color: #e2e8f0;
        }
        #archiveModal .icon-btn.danger {
            color: #dc2626;
        }
        #archiveModal .icon-btn.danger:hover {
            background-color: #fee2e2;
        }
        #archiveModal .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            margin-top: 1.5rem;
        }
        #archiveModal .pagination-btn {
            padding: 0.5rem 0.8rem;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            background-color: white;
            cursor: pointer;
            font-size: 0.85rem;
            color: #374151;
            transition: background-color 0.2s ease, border-color 0.2s ease;
        }
        #archiveModal .pagination-btn:hover:not(:disabled) {
            background-color: #f0f4f8;
            border-color: #a7b3c4;
        }
        #archiveModal .pagination-btn.active {
            background-color: #1e40af;
            color: white;
            border-color: #1e40af;
        }
        #archiveModal .pagination-btn.active:hover {
            background-color: #1e3a8a;
            border-color: #1e3a8a;
        }
        #archiveModal .pagination-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* View Details Modal Specific Styles */
        #viewDetailsModal .app-modal {
            max-width: 1000px; /* Even wider for detailed view */
            padding: 0; /* Remove padding from modal itself, content will add it */
        }
        #viewDetailsModal .app-modal-body {
            padding: 0; /* Remove padding from modal body, content will add it */
        }

        /* Templates Modal Specific Styles */
        #templatesModal .app-modal {
            max-width: 1100px; /* Wider for template layout */
        }
        #templatesModal .template-layout {
            display: flex;
            gap: 1.5rem;
            min-height: 500px; /* Ensure some height for layout */
        }
        #templatesModal .template-categories {
            flex: 0 0 250px; /* Fixed width for categories */
            background-color: #f8fafc;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
        }
        #templatesModal .categories-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e2e8f0;
        }
        #templatesModal .categories-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #374151;
        }
        #templatesModal .category-list {
            list-style: none;
            padding: 0;
            margin: 0;
            flex-grow: 1;
            overflow-y: auto;
        }
        #templatesModal .category-item {
            margin-bottom: 0.5rem;
        }
        #templatesModal .category-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 1rem;
            border-radius: 6px;
            text-decoration: none;
            color: #475569;
            transition: background-color 0.2s ease, color 0.2s ease;
        }
        #templatesModal .category-link:hover {
            background-color: #e2e8f0;
        }
        #templatesModal .category-link.active {
            background-color: #1e40af;
            color: white;
        }
        #templatesModal .category-link.active .category-info svg {
            color: white;
        }
        #templatesModal .category-link.active .category-count {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
        }
        #templatesModal .category-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 500;
        }
        #templatesModal .category-info svg {
            color: #64748b;
            transition: color 0.2s ease;
        }
        #templatesModal .category-count {
            padding: 0.2rem 0.6rem;
            background-color: #cbd5e1;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            color: #475569;
        }

        #templatesModal .template-panel {
            flex: 1;
            background-color: white;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
        }
        #templatesModal .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e2e8f0;
            flex-wrap: wrap;
        }
        #templatesModal .panel-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #374151;
        }
        #templatesModal .panel-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }
        #templatesModal .search-box {
            position: relative;
            display: flex;
            align-items: center;
        }
        #templatesModal .search-box .search-icon {
            position: absolute;
            left: 10px;
            color: #94a3b8;
        }
        #templatesModal .search-box .search-input {
            padding-left: 35px;
            border-radius: 8px;
            border: 1px solid #d1d5db;
            padding: 0.6rem 1rem 0.6rem 35px;
            font-size: 0.9rem;
            width: 200px;
        }
        #templatesModal .view-toggle {
            display: flex;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            overflow: hidden;
        }
        #templatesModal .toggle-btn {
            background-color: white;
            border: none;
            padding: 0.6rem 0.8rem;
            cursor: pointer;
            transition: background-color 0.2s ease;
            color: #64748b;
        }
        #templatesModal .toggle-btn:hover {
            background-color: #f0f4f8;
        }
        #templatesModal .toggle-btn.active {
            background-color: #1e40af;
            color: white;
        }
        #templatesModal .templates-container {
            flex-grow: 1;
            overflow-y: auto;
        }
        #templatesModal .template-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        #templatesModal .template-grid.list-view {
            display: block; /* Override grid for list view */
        }
        #templatesModal .template-card {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 1.2rem;
            background-color: #f8fafc;
            display: flex;
            flex-direction: column;
            transition: box-shadow 0.2s ease;
        }
        #templatesModal .template-grid.list-view .template-card {
            margin-bottom: 1rem;
        }
        #templatesModal .template-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        #templatesModal .template-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
            flex-wrap: wrap;
        }
        #templatesModal .template-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1e40af;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem; /* For wrapping */
        }
        #templatesModal .usage-badge {
            background-color: #dbeafe;
            color: #1d4ed8;
            padding: 0.2rem 0.6rem;
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: 500;
        }
        #templatesModal .template-meta {
            font-size: 0.8rem;
            color: #64748b;
            display: flex;
            gap: 1rem;
            margin-top: 0.5rem; /* For wrapping */
        }
        #templatesModal .template-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        #templatesModal .template-preview {
            font-size: 0.9rem;
            color: #475569;
            line-height: 1.5;
            margin-bottom: 1.5rem;
            max-height: 100px; /* Limit preview height */
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 4; /* Limit to 4 lines */
            -webkit-box-orient: vertical;
        }
        #templatesModal .template-actions {
            display: flex;
            gap: 0.75rem;
            margin-top: auto; /* Push actions to bottom */
        }
        #templatesModal .template-btn {
            padding: 0.6rem 1rem;
            border-radius: 6px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            transition: background-color 0.2s ease, border-color 0.2s ease;
            font-size: 0.85rem;
            border: 1px solid #d1d5db;
            background-color: white;
            color: #374151;
        }
        #templatesModal .template-btn.primary {
            background-color: #1e40af;
            color: white;
            border-color: #1e40af;
        }
        #templatesModal .template-btn.primary:hover {
            background-color: #1e3a8a;
            border-color: #1e3a8a;
        }
        #templatesModal .template-btn:hover:not(.primary) {
            background-color: #f0f4f8;
        }

        /* Template Editor/Usage Modal specific styles */
        #templateModal .template-variables, #useTemplateModal .template-variables {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }
        #templateModal .variables-title, #useTemplateModal .variables-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.75rem;
        }
        #templateModal .variables-list, #useTemplateModal .variables-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        #templateModal .variable-tag, #useTemplateModal .variable-tag {
            background-color: #e0e7ff;
            color: #3f51b5;
            padding: 0.4rem 0.8rem;
            border-radius: 16px;
            font-size: 0.8rem;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }
        #templateModal .variable-tag:hover, #useTemplateModal .variable-tag:hover {
            background-color: #c7d2fe;
        }

        @media (max-width: 900px) {
            #templatesModal .template-layout {
                flex-direction: column;
            }
            #templatesModal .template-categories {
                flex: none;
                width: 100%;
            }
            #templatesModal .panel-header {
                flex-direction: column;
                align-items: flex-start;
            }
            #templatesModal .panel-actions {
                margin-top: 1rem;
                width: 100%;
                justify-content: space-between;
            }
            #templatesModal .search-box .search-input {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <?php include '../../includes/admin_sidebar.php' ?>
        <!-- Main Content -->
        <main class="main-content">
            <div class="header">
                <h2>Customer Messages</h2>
                <div class="header-actions">
                    <div class="search-box">
                        <i data-lucide="search" class="search-icon"></i>
                        <input type="text" class="search-input" placeholder="Search messages..." oninput="appState.searchMessages.call(this)">
                    </div>
                    <button class="action-button secondary" onclick="appState.openTemplatesModal()">
                        <i data-lucide="file-text" width="16" height="16"></i>
                        Templates
                    </button>
                    <button class="action-button" onclick="appState.openArchiveModal()">
                        <i data-lucide="archive" width="16" height="16"></i>
                        Archive
                    </button>
                    <div class="user-info">
                        <span>Admin Panel</span>
                        <div class="avatar">A</div>
                    </div>
                </div>
            </div>

            <!-- Message Stats -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-title">Total Messages</div>
                    <div class="stat-value" id="totalMessages">89</div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">Unread Messages</div>
                    <div class="stat-value" id="unreadMessages">12</div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">Custom Orders</div>
                    <div class="stat-value" id="customOrders">8</div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">Avg Response Time</div>
                    <div class="stat-value">2.5h</div>
                </div>
            </div>

            <!-- Messages Layout -->
            <div class="messages-layout">
                <!-- Message List -->
                <div class="message-list">
                    <div class="message-list-header">
                        <h3 class="list-title">Customer Messages</h3>
                        <div class="filter-tabs">
                            <button class="tab-btn active" data-filter="all" onclick="appState.filterMessages.call(this, 'all')">All</button>
                            <button class="tab-btn" data-filter="unread" onclick="appState.filterMessages.call(this, 'unread')">
                                Unread
                                <span class="badge" id="unreadBadge">12</span>
                            </button>
                            <button class="tab-btn" data-filter="custom" onclick="appState.filterMessages.call(this, 'custom')">Custom Orders</button>
                        </div>
                    </div>
                    <div class="messages-container" id="messagesContainer">
                        <div class="message-item active unread" data-type="inquiry" data-id="1">
                            <div class="message-header">
                                <span class="message-from">Juan Dela Cruz</span>
                                <span class="message-time">2 hours ago</span>
                            </div>
                            <div class="message-subject">Product Availability Inquiry</div>
                            <div class="message-preview">Hi, I'm looking for bulk ballpoint pens for our office. Do you have at least 200 pieces available?</div>
                            <div class="message-type inquiry">Inquiry</div>
                        </div>

                        <div class="message-item unread" data-type="custom-order" data-id="2">
                            <div class="message-header">
                                <span class="message-from">Maria Santos</span>
                                <span class="message-time">4 hours ago</span>
                            </div>
                            <div class="message-subject">Custom Order Request</div>
                            <div class="message-preview">I need customized notebooks with our school logo. Can you help with this special order?</div>
                            <div class="message-type custom-order">Custom Order</div>
                        </div>

                        <div class="message-item" data-type="feedback" data-id="3">
                            <div class="message-header">
                                <span class="message-from">Roberto Garcia</span>
                                <span class="message-time">Yesterday</span>
                            </div>
                            <div class="message-subject">Positive Feedback</div>
                            <div class="message-preview">Great service! The delivery was fast and all items were in perfect condition. Thank you!</div>
                            <div class="message-type feedback">Feedback</div>
                        </div>

                        <div class="message-item unread" data-type="complaint" data-id="4">
                            <div class="message-header">
                                <span class="message-from">Ana Reyes</span>
                                <span class="message-time">Yesterday</span>
                            </div>
                            <div class="message-subject">Delivery Issue</div>
                            <div class="message-preview">My order was supposed to arrive yesterday but I haven't received it yet. Can you check the status?</div>
                            <div class="message-type complaint">Complaint</div>
                        </div>

                        <div class="message-item" data-type="inquiry" data-id="5">
                            <div class="message-header">
                                <span class="message-from">Carlos Mendoza</span>
                                <span class="message-time">2 days ago</span>
                            </div>
                            <div class="message-subject">Payment Options</div>
                            <div class="message-preview">Do you accept other payment methods aside from COD? I prefer online payment.</div>
                            <div class="message-type inquiry">Inquiry</div>
                        </div>

                        <div class="message-item unread" data-type="custom-order" data-id="6">
                            <div class="message-header">
                                <span class="message-from">Lisa Fernandez</span>
                                <span class="message-time">3 days ago</span>
                            </div>
                            <div class="message-subject">Bulk Order Discount</div>
                            <div class="message-preview">I need to order supplies for 5 different offices. Is there a bulk discount available?</div>
                            <div class="message-type custom-order">Custom Order</div>
                        </div>
                    </div>
                </div>

                <!-- Message Detail -->
                <div class="message-detail" id="messageDetail">
                    <div class="message-detail-header">
                        <div class="detail-customer">
                            <div class="customer-avatar">JD</div>
                            <div class="customer-details">
                                <h3>Juan Dela Cruz</h3>
                                <p>juan.delacruz@email.com • +63 917 123 4567</p>
                            </div>
                        </div>
                        <div class="message-actions">
                            <button class="icon-btn" onclick="appState.viewRequest()" title="View Details">
                                <i data-lucide="eye" width="16" height="16"></i>
                            </button>
                            <button class="icon-btn" onclick="appState.openResponseModal()" title="Quick Response">
                                <i data-lucide="reply" width="16" height="16"></i>
                            </button>
                            <button class="icon-btn" onclick="appState.archiveMessageFromViewDetails()" title="Archive">
                                <i data-lucide="archive" width="16" height="16"></i>
                            </button>
                        </div>
                        <div class="message-meta">
                            <div class="message-type inquiry">Product Inquiry</div>
                            <span class="message-time">August 20, 2025 - 2:15 PM</span>
                        </div>
                    </div>

                    <div class="message-content">
                        <h4 style="color: #1e40af; margin-bottom: 1rem;">Product Availability Inquiry</h4>
                        <div class="message-text">
                            <p>Hi M & E Team,</p>
                            <br>
                            <p>I'm looking for bulk ballpoint pens for our office. We need at least 200 pieces (around 16-17 packs of 12). Do you have this quantity available? Also, would there be any discount for bulk orders?</p>
                            <br>
                            <p>We're located in Olongapo City, so delivery should be within your service area. Please let me know the availability and total cost including delivery.</p>
                            <br>
                            <p>Thank you!</p>
                            <p>Juan Dela Cruz</p>
                        </div>
                    </div>

                    <div class="reply-section">
                        <form class="reply-form" onsubmit="appState.sendReply(event)">
                            <textarea class="reply-textarea" placeholder="Type your reply here..." required></textarea>
                            <div class="reply-actions">
                                <button type="button" class="action-btn secondary" onclick="appState.saveDraft()">
                                    <i data-lucide="save" width="16" height="16"></i>
                                    Save Draft
                                </button>
                                <button type="button" class="action-btn secondary" onclick="appState.openTemplatesModalForReply()">
                                    <i data-lucide="file-text" width="16" height="16"></i>
                                    Use Template
                                </button>
                                <button type="submit" class="action-btn primary">
                                    <i data-lucide="send" width="16" height="16"></i>
                                    Send Reply
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Archive Modal (Content loaded dynamically) -->
    <div class="app-modal-overlay" id="archiveModal">
        <div class="app-modal" id="archiveModalContent">
            <!-- Content from archive-request.php will be loaded here -->
        </div>
    </div>

    <!-- Response Modal -->
    <div class="app-modal-overlay" id="responseModal">
        <div class="app-modal">
            <div class="app-modal-header">
                <h3 class="app-modal-title">Quick Response</h3>
                <button class="app-modal-close-btn" onclick="appState.closeModal('responseModal')">&times;</button>
            </div>
            <form onsubmit="appState.handleQuickResponse(event)">
                <div class="app-form-group">
                    <label class="app-form-label">Response Template</label>
                    <select class="app-form-select" name="template" onchange="appState.loadTemplate(this.value, 'responseText')">
                        <option value="">Select template</option>
                        <option value="availability">Product Availability Response</option>
                        <option value="custom_order">Custom Order Response</option>
                        <option value="complaint">Complaint Resolution</option>
                        <option value="thank_you">Thank You Response</option>
                        <option value="delivery_info">Delivery Information</option>
                    </select>
                </div>
                <div class="app-form-group">
                    <label class="app-form-label">Response Message</label>
                    <textarea class="app-form-textarea" name="response" id="responseText" placeholder="Type your response here..." required></textarea>
                </div>
                <div class="app-form-group">
                    <label class="app-form-label">Priority</label>
                    <select class="app-form-select" name="priority">
                        <option value="normal">Normal</option>
                        <option value="high">High</option>
                        <option value="urgent">Urgent</option>
                    </select>
                </div>
                <div class="app-modal-actions">
                    <button type="button" class="app-action-btn secondary" onclick="appState.closeModal('responseModal')">Cancel</button>
                    <button type="submit" class="app-action-btn primary">Send Response</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Templates Modal (Content loaded dynamically) -->
    <div class="app-modal-overlay" id="templatesModal">
        <div class="app-modal" id="templatesModalContent">
            <!-- Content from respond-request.php will be loaded here -->
        </div>
    </div>

    <!-- View Details Modal (Content loaded dynamically) -->
    <div class="app-modal-overlay" id="viewDetailsModal">
        <div class="app-modal" id="viewDetailsModalContent">
            <!-- Content from view-request.php will be loaded here -->
        </div>
    </div>

    <!-- Notification -->
    <div class="app-notification" id="appNotification"></div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Global application state
        const appState = {
            currentMessageId: 1,
            messageData: {
                1: {
                    customer: 'Juan Dela Cruz',
                    email: 'juan.delacruz@email.com',
                    phone: '+63 917 123 4567',
                    location: 'Olongapo City, Philippines',
                    avatar: 'JD',
                    subject: 'Product Availability Inquiry',
                    type: 'inquiry',
                    priority: 'normal',
                    status: 'Active',
                    time: 'August 20, 2025 - 2:15 PM',
                    content: `Hi M & E Team,

I'm looking for bulk ballpoint pens for our office. We need at least 200 pieces (around 16-17 packs of 12). Do you have this quantity available? Also, would there be any discount for bulk orders?

We're located in Olongapo City, so delivery should be within your service area. Please let me know the availability and total cost including delivery.

Thank you!
Juan Dela Cruz`,
                    category: 'Product Inquiry',
                    source: 'Contact Form',
                    assignedTo: 'Admin Team',
                    tags: 'Bulk Order, Pens',
                    attachments: [
                        { name: 'company-logo.png', size: '245 KB', icon: 'image' },
                        { name: 'office-layout.pdf', size: '1.2 MB', icon: 'file-text' }
                    ],
                    history: [
                        { author: 'Juan Dela Cruz', avatar: 'JD', avatarBg: 'background: linear-gradient(135deg, #1e40af, #3b82f6);', time: 'August 20, 2025 - 6:15 PM', type: 'Customer Reply', text: 'Hi M & E Team,\n\nPerfect! The pricing looks good. I\'d like to proceed with the order of 17 packs of ballpoint pens.\n\nCan you arrange delivery for this Friday? Also, do you accept bank transfer for payment?\n\nThanks!\nJuan' },
                        { author: 'Admin (M & E Team)', avatar: 'AD', time: 'August 20, 2025 - 4:30 PM', type: 'Response Sent', text: 'Dear Juan,\n\nThank you for your inquiry about our ballpoint pens. Yes, we have the quantity you need available in stock. For bulk orders of 200+ pieces, we offer a 15% discount.\n\nHere are the details:\n- Regular price: ₱25 per pack (12 pieces)\n- Bulk price: ₱21.25 per pack\n- Total for 17 packs: ₱361.25\n- Delivery to Olongapo City: ₱150\n\nWould you like to proceed with this order?\n\nBest regards,\nM & E Team' },
                        { author: 'Juan Dela Cruz', avatar: 'JD', avatarBg: 'background: linear-gradient(135deg, #1e40af, #3b82f6);', time: 'August 20, 2025 - 2:15 PM', type: 'Message Received', text: 'Initial inquiry about ballpoint pens' }
                    ],
                    related: [
                        { id: 2, customer: 'Juan Dela Cruz', subject: 'Previous Order - Notebooks', date: 'Aug 10, 2025' },
                        { id: 3, customer: 'Juan Dela Cruz', subject: 'Delivery Inquiry', date: 'Jul 25, 2025' }
                    ]
                },
                2: {
                    customer: 'Maria Santos',
                    email: 'maria.santos@email.com',
                    phone: '+63 918 234 5678',
                    location: 'Quezon City, Philippines',
                    avatar: 'MS',
                    subject: 'Custom Order Request',
                    type: 'custom-order',
                    priority: 'high',
                    status: 'Pending Quote',
                    time: 'August 20, 2025 - 12:30 PM',
                    content: `Hello,

I need customized notebooks with our school logo. We need about 500 pieces for our incoming school year. The specifications are:
- Size: A5
- Pages: 100 pages each
- Cover: Hard cover with our logo
- Timeline: Need them by September 15

Can you provide a quote and timeline for this custom order?

Best regards,
Maria Santos`,
                    category: 'Custom Order',
                    source: 'Email',
                    assignedTo: 'Sales Team',
                    tags: 'Notebooks, School, Logo',
                    attachments: [],
                    history: [
                        { author: 'Maria Santos', avatar: 'MS', time: 'August 20, 2025 - 12:30 PM', type: 'Message Received', text: 'Custom notebook inquiry' }
                    ],
                    related: []
                },
                3: {
                    customer: 'Roberto Garcia',
                    email: 'roberto.garcia@email.com',
                    phone: '+63 919 345 6789',
                    location: 'Cebu City, Philippines',
                    avatar: 'RG',
                    subject: 'Positive Feedback',
                    type: 'feedback',
                    priority: 'normal',
                    status: 'Resolved',
                    time: 'Yesterday',
                    content: `Great service! The delivery was fast and all items were in perfect condition. Thank you!`,
                    category: 'Feedback',
                    source: 'Website Form',
                    assignedTo: 'Customer Service',
                    tags: 'Positive, Delivery',
                    attachments: [],
                    history: [
                        { author: 'Roberto Garcia', avatar: 'RG', time: 'Yesterday', type: 'Message Received', text: 'Positive feedback received' }
                    ],
                    related: []
                },
                4: {
                    customer: 'Ana Reyes',
                    email: 'ana.reyes@email.com',
                    phone: '+63 920 456 7890',
                    location: 'Davao City, Philippines',
                    avatar: 'AR',
                    subject: 'Delivery Issue',
                    type: 'complaint',
                    priority: 'urgent',
                    status: 'Investigating',
                    time: 'Yesterday',
                    content: `My order was supposed to arrive yesterday but I haven't received it yet. Can you check the status?`,
                    category: 'Complaint',
                    source: 'Phone Call',
                    assignedTo: 'Logistics Team',
                    tags: 'Delivery, Late',
                    attachments: [],
                    history: [
                        { author: 'Ana Reyes', avatar: 'AR', time: 'Yesterday', type: 'Message Received', text: 'Delivery issue reported' }
                    ],
                    related: []
                },
                5: {
                    customer: 'Carlos Mendoza',
                    email: 'carlos.mendoza@email.com',
                    phone: '+63 921 567 8901',
                    location: 'Makati City, Philippines',
                    avatar: 'CM',
                    subject: 'Payment Options',
                    type: 'inquiry',
                    priority: 'normal',
                    status: 'Active',
                    time: '2 days ago',
                    content: `Do you accept other payment methods aside from COD? I prefer online payment.`,
                    category: 'Product Inquiry',
                    source: 'Chat',
                    assignedTo: 'Sales Team',
                    tags: 'Payment, Online',
                    attachments: [],
                    history: [
                        { author: 'Carlos Mendoza', avatar: 'CM', time: '2 days ago', type: 'Message Received', text: 'Inquiry about payment options' }
                    ],
                    related: []
                },
                6: {
                    customer: 'Lisa Fernandez',
                    email: 'lisa.fernandez@email.com',
                    phone: '+63 922 678 9012',
                    location: 'Pasig City, Philippines',
                    avatar: 'LF',
                    subject: 'Bulk Order Discount',
                    type: 'custom-order',
                    priority: 'high',
                    status: 'Active',
                    time: '3 days ago',
                    content: `I need to order supplies for 5 different offices. Is there a bulk discount available?`,
                    category: 'Custom Order',
                    source: 'Email',
                    assignedTo: 'Sales Team',
                    tags: 'Bulk, Discount, Office Supplies',
                    attachments: [],
                    history: [
                        { author: 'Lisa Fernandez', avatar: 'LF', time: '3 days ago', type: 'Message Received', text: 'Bulk order discount inquiry' }
                    ],
                    related: []
                }
            },
            templates: {
                availability: {
                    name: 'Product Availability Response',
                    subject: 'RE: Product Availability Inquiry',
                    content: `Dear {{customer_name}},

Thank you for your inquiry about {{product_name}}. Yes, we have the quantity you need available in stock. For bulk orders of {{quantity}}+ pieces, we offer a {{discount}}% discount.

Here are the details:
- Regular price: ₱25 per pack (12 pieces)
- Bulk price: ₱21.25 per pack
- Total for 17 packs: ₱361.25
- Delivery to Olongapo City: ₱150

Would you like to proceed with this order?

Best regards,
M & E Team`
                },
                custom_order: {
                    name: 'Custom Order Response',
                    subject: 'RE: Custom Order Request',
                    content: `Dear {{customer_name}},

Thank you for your custom order inquiry. We'd be happy to help you with your customized notebooks.

Based on your requirements, here's our quote:
- Custom notebooks with logo printing
- Estimated cost: Will be provided after design review
- Timeline: 2-3 weeks from order confirmation

Please send us your logo file and we'll provide a detailed quote within 24 hours.

Best regards,
M & E Team`
                },
                complaint: {
                    name: 'Complaint Resolution',
                    subject: 'RE: Delivery Issue',
                    content: `Dear {{customer_name}},

We sincerely apologize for the inconvenience you've experienced with {{issue_description}}. We take all customer concerns seriously and will investigate this matter immediately.

We will:
1. Track your order status
2. Contact our delivery partner
3. Provide you with an update within 2 hours

Thank you for your patience.

Best regards,
M & E Team`
                },
                thank_you: {
                    name: 'Thank You Response',
                    subject: 'RE: Positive Feedback',
                    content: `Dear {{customer_name}},

Thank you so much for your positive feedback! We're delighted to hear that you're satisfied with {{product_service}}.

Customer satisfaction is our top priority, and reviews like yours motivate us to continue providing excellent service.

We look forward to serving you again!

Best regards,
M & E Team`
                },
                delivery_info: {
                    name: 'Delivery Information',
                    subject: 'RE: Delivery Information Request',
                    content: `Dear {{customer_name}},

Thank you for your inquiry about delivery options.

Our delivery information:
- Metro Manila: 1-2 business days (₱100)
- Provincial areas: 2-3 business days (₱150-200)
- Free delivery for orders above ₱1,500

You can track your order through our website using your order number.

Best regards,
M & E Team`
                }
            },
            selectedArchiveMessages: [], // For archive-request.php
            deleteTarget: null, // For archive-request.php
            targetReplyTextarea: null, // To store the target textarea for template insertion

            // --- Utility Functions ---
            showNotification: function(message, type = 'success') {
                const notification = document.getElementById('appNotification');
                notification.textContent = message;
                notification.className = `app-notification ${type}`;
                notification.classList.add('show');

                setTimeout(() => {
                    notification.classList.remove('show');
                }, 3000);
            },

            closeModal: function(modalId) {
                document.getElementById(modalId).classList.remove('active');
                // Remove content if it was dynamically loaded
                if (modalId === 'archiveModal' || modalId === 'templatesModal' || modalId === 'viewDetailsModal') {
                    document.getElementById(modalId + 'Content').innerHTML = '';
                }
            },

            // --- Message List Functions ---
            updateUnreadCount: function() {
                const unreadMessages = document.querySelectorAll('.message-item.unread');
                const count = unreadMessages.length;

                document.getElementById('unreadMessages').textContent = count;
                const unreadBadge = document.getElementById('unreadBadge');
                unreadBadge.textContent = count;
                unreadBadge.style.display = count === 0 ? 'none' : '';
            },

            loadMessageDetail: function(messageId) {
                const data = appState.messageData[messageId];
                if (!data) return;

                // Update customer info
                document.querySelector('.message-detail .detail-customer .customer-avatar').textContent = data.avatar;
                document.querySelector('.message-detail .detail-customer h3').textContent = data.customer;
                document.querySelector('.message-detail .detail-customer p').textContent = `${data.email} • ${data.phone}`;

                // Update message info
                const messageTypeBadge = document.querySelector('.message-detail .message-meta .message-type');
                messageTypeBadge.textContent = data.type.replace('-', ' ').replace(/\b\w/g, l => l.toUpperCase());
                messageTypeBadge.className = `message-type ${data.type}`; // Update class for styling
                document.querySelector('.message-detail .message-meta .message-time').textContent = data.time;
                document.querySelector('.message-detail .message-content h4').textContent = data.subject;

                // Update message content
                const messageText = document.querySelector('.message-detail .message-text');
                messageText.innerHTML = data.content.split('\n').map(line => line.trim() ? `<p>${line}</p>` : '<br>').join('');

                // Update currentMessageId for view/reply actions
                appState.currentMessageId = messageId;
            },

            searchMessages: function() {
                const searchTerm = this.value.toLowerCase();
                const messages = document.querySelectorAll('.message-item');

                messages.forEach(message => {
                    const customerName = message.querySelector('.message-from').textContent.toLowerCase();
                    const subject = message.querySelector('.message-subject').textContent.toLowerCase();
                    const preview = message.querySelector('.message-preview').textContent.toLowerCase();

                    if (customerName.includes(searchTerm) || subject.includes(searchTerm) || preview.includes(searchTerm)) {
                        message.style.display = '';
                    } else {
                        message.style.display = 'none';
                    }
                });
            },

            filterMessages: function(filter) {
                // Update active tab
                document.querySelectorAll('.filter-tabs .tab-btn').forEach(b => b.classList.remove('active'));
                document.querySelector(`.filter-tabs .tab-btn[data-filter="${filter}"]`).classList.add('active');

                const messages = document.querySelectorAll('.message-item');

                messages.forEach(message => {
                    if (filter === 'all') {
                        message.style.display = '';
                    } else if (filter === 'unread') {
                        message.style.display = message.classList.contains('unread') ? '' : 'none';
                    } else if (filter === 'custom') {
                        message.style.display = message.dataset.type === 'custom-order' ? '' : 'none';
                    }
                });
            },

            // --- Reply Section Functions ---
            sendReply: function(event) {
                event.preventDefault();
                const replyText = document.querySelector('.reply-textarea').value;
                if (replyText.trim()) {
                    appState.showNotification('Reply sent successfully!', 'success');
                    document.querySelector('.reply-textarea').value = '';

                    // Mark message as read if it was unread
                    const activeMessage = document.querySelector('.message-item.active');
                    if (activeMessage && activeMessage.classList.contains('unread')) {
                        activeMessage.classList.remove('unread');
                        appState.updateUnreadCount();
                    }
                }
            },

            saveDraft: function() {
                const replyText = document.querySelector('.reply-textarea').value;
                if (replyText.trim()) {
                    appState.showNotification('Draft saved successfully!', 'success');
                } else {
                    appState.showNotification('No content to save', 'error');
                }
            },

            // --- Modals Functions ---
            openArchiveModal: function() {
                fetch('archive-request.php')
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('archiveModalContent').innerHTML = html;
                        document.getElementById('archiveModal').classList.add('active');
                        lucide.createIcons(); // Re-initialize icons for new content
                        appState.initArchiveModalListeners(); // Re-bind event listeners
                    })
                    .catch(error => {
                        console.error('Error loading archive modal:', error);
                        appState.showNotification('Failed to load archive page.', 'error');
                    });
            },

            openResponseModal: function() {
                const currentMessage = appState.messageData[appState.currentMessageId];
                if (currentMessage) {
                    document.getElementById('responseModal').querySelector('.app-form-select[name="template"]').value = ''; // Clear previous selection
                    document.getElementById('responseText').value = ''; // Clear previous response
                    // Pre-fill recipient for quick response
                }
                document.getElementById('responseModal').classList.add('active');
            },

            // New function to open the single archive modal
            openSingleArchiveModal: function(messageId) {
                // Store the message ID for later use in handleSingleArchive
                appState.currentMessageIdToArchive = messageId;
                const modal = document.getElementById('singleArchiveModal');
                modal.querySelector('#archiveMessageIdDisplay').textContent = `#MSG-${String(messageId).padStart(3, '0')}`;
                modal.classList.add('active');
            },

            // New function to handle single message archive submission
            handleSingleArchive: function(event) {
                event.preventDefault();
                const formData = new FormData(event.target);
                const archiveReason = formData.get('archiveReason');
                const archiveNotes = formData.get('archiveNotes');
                const messageId = appState.currentMessageIdToArchive;

                if (!archiveReason) {
                    appState.showNotification('Please select an archive reason.', 'error');
                    return;
                }

                // Simulate archiving logic
                console.log(`Archiving message ${messageId} with reason: ${archiveReason}, notes: ${archiveNotes}`);
                appState.showNotification(`Message #${String(messageId).padStart(3, '0')} archived as "${archiveReason}".`, 'success');

                // Remove message from main message list (if it was there)
                const messageItemInList = document.querySelector(`.message-item[data-id="${messageId}"]`);
                if (messageItemInList) {
                    messageItemInList.remove();
                    appState.updateUnreadCount(); // Update counts if an unread message was archived
                    // If the archived message was the currently viewed one, clear the detail panel
                    if (appState.currentMessageId == messageId) {
                        document.getElementById('messageDetail').innerHTML = '<p style="text-align: center; padding: 50px; color: #64748b;">Select a message to view details.</p>';
                        appState.currentMessageId = null; // Clear current message
                    }
                }

                appState.closeModal('singleArchiveModal');
                appState.closeModal('viewDetailsModal'); // Close view details modal if it was open
                appState.currentMessageIdToArchive = null; // Clear stored ID
            },

            // Update existing archiveMessageFromViewDetails to use the new modal
            archiveMessageFromViewDetails: function() {
                // This function is called from the main message detail panel and viewDetailsModal
                const messageId = appState.currentMessageId;
                if (messageId) {
                    appState.openSingleArchiveModal(messageId);
                } else {
                    appState.showNotification('No message selected to archive.', 'error');
                }
            },

            handleQuickResponse: function(event) {
                event.preventDefault();
                const formData = new FormData(event.target);
                const response = formData.get('response');
                const priority = formData.get('priority');

                if (response.trim()) {
                    appState.showNotification('Response sent successfully!', 'success');
                    appState.closeModal('responseModal');

                    // Mark message as read
                    const activeMessage = document.querySelector('.message-item.active');
                    if (activeMessage && activeMessage.classList.contains('unread')) {
                        activeMessage.classList.remove('unread');
                        appState.updateUnreadCount();
                    }
                }
            },

            loadTemplate: function(templateType, targetTextareaId) {
                const responseTextarea = document.getElementById(targetTextareaId);
                const template = appState.templates[templateType];

                if (template) {
                    let content = template.content;
                    const currentMessage = appState.messageData[appState.currentMessageId];

                    // Robust variable replacement
                    if (currentMessage) {
                        content = content.replace(/{{customer_name}}/g, currentMessage.customer || 'Customer');
                        content = content.replace(/{{product_name}}/g, currentMessage.subject.includes('Product Availability') ? 'our products' : 'the item');
                        content = content.replace(/{{order_id}}/g, 'N/A'); // Placeholder
                        content = content.replace(/{{issue_description}}/g, currentMessage.subject);
                        content = content.replace(/{{quantity}}/g, 'N/A'); // Placeholder
                        content = content.replace(/{{discount}}/g, 'N/A'); // Placeholder
                        content = content.replace(/{{delivery_date}}/g, 'N/A'); // Placeholder
                        content = content.replace(/{{tracking_number}}/g, 'N/A'); // Placeholder
                        content = content.replace(/{{company_name}}/g, 'M & E Team'); // Placeholder
                        content = content.replace(/{{product_service}}/g, 'our service'); // Placeholder for thank_you
                        content = content.replace(/{{custom_item}}/g, currentMessage.subject); // Placeholder for custom_order
                        content = content.replace(/{{quote_details}}/g, 'Details to be provided'); // Placeholder
                        content = content.replace(/{{delivery_timeline}}/g, '2-3 weeks'); // Placeholder
                        content = content.replace(/{{delivery_address}}/g, currentMessage.location || 'N/A'); // Placeholder
                        content = content.replace(/{{order_details}}/g, 'See attached order summary'); // Placeholder
                    }
                    // Remove any remaining {{variables}} that weren't replaced
                    content = content.replace(/{{[a-zA-Z_]+}}/g, '');

                    responseTextarea.value = content;

                    // Optionally, update subject if template has one
                } else {
                    responseTextarea.value = '';
                    const subjectInput = responseTextarea.closest('form').querySelector('input[name="subject"]');
                    if (subjectInput) {
                        subjectInput.value = '';
                    }
                }
            },

            openTemplatesModal: function() {
                // Set targetReplyTextarea to null as this is for general template management
                appState.targetReplyTextarea = null;
                fetch('respond-request.php')
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('templatesModalContent').innerHTML = html;
                        document.getElementById('templatesModal').classList.add('active');
                        lucide.createIcons(); // Re-initialize icons for new content
                        appState.initTemplatesModalListeners();
                    })
                    .catch(error => {
                        console.error('Error loading templates modal:', error);
                        appState.showNotification('Failed to load templates page.', 'error');
                    });
            },

            openTemplatesModalForReply: function() {
                // Set the targetReplyTextarea to the main reply textarea
                appState.targetReplyTextarea = document.querySelector('.reply-textarea');
                fetch('respond-request.php')
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('templatesModalContent').innerHTML = html;
                        document.getElementById('templatesModal').classList.add('active');
                        lucide.createIcons(); // Re-initialize icons for new content
                        appState.initTemplatesModalListeners();
                    })
                    .catch(error => {
                        console.error('Error loading templates modal:', error);
                        appState.showNotification('Failed to load templates page.', 'error');
                    });
            },

            // --- View Request Function ---
            viewRequest: function(messageId = appState.currentMessageId, isArchived = false) {
                fetch(`view-request.php?id=${messageId}&archived=${isArchived}`)
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('viewDetailsModalContent').innerHTML = html;
                        document.getElementById('viewDetailsModal').classList.add('active');
                        lucide.createIcons(); // Re-initialize icons for new content
                        appState.initViewDetailsModalListeners(); // Re-initialize listeners for the new modal content
                    })
                    .catch(error => {
                        console.error('Error loading view details modal:', error);
                        appState.showNotification('Failed to load message details.', 'error');
                    });
            },

            // --- Dynamic Content Listeners (for modals) ---
            initArchiveModalListeners: function() {
                const archiveModal = document.getElementById('archiveModalContent');

                // Search (if implemented in archive-request.php)
                const searchInput = archiveModal.querySelector('.search-input');
                if (searchInput) {
                    searchInput.addEventListener('input', appState.archiveSearch);
                }

                // Filters
                archiveModal.querySelectorAll('.app-form-select').forEach(select => {
                    select.addEventListener('change', appState.archiveApplyFilters);
                });

                // Select All
                const selectAllCheckbox = archiveModal.querySelector('#selectAll');
                if (selectAllCheckbox) {
                    selectAllCheckbox.addEventListener('change', appState.archiveToggleSelectAll);
                }

                // Individual checkboxes
                archiveModal.querySelectorAll('.message-checkbox').forEach(checkbox => {
                    checkbox.addEventListener('change', appState.archiveUpdateBulkActions);
                });

                // Bulk Restore/Delete buttons
                const restoreBtn = archiveModal.querySelector('#restoreBtn');
                const deleteBtn = archiveModal.querySelector('#deleteBtn');
                if (restoreBtn) restoreBtn.onclick = () => appState.archiveBulkRestore();
                if (deleteBtn) deleteBtn.onclick = () => appState.archiveBulkDelete();

                // Individual action buttons (view, restore, delete)
                archiveModal.querySelectorAll('.archive-table .action-buttons .icon-btn').forEach(btn => {
                    const messageId = btn.closest('tr').querySelector('.message-checkbox').dataset.id;
                    if (btn.title === 'View') btn.onclick = () => appState.archiveViewArchivedMessage(messageId);
                    if (btn.title === 'Restore') btn.onclick = () => appState.archiveRestoreMessage(messageId);
                    if (btn.title === 'Delete Permanently') btn.onclick = () => appState.archiveDeleteMessage(messageId);
                });

                // Restore Modal form submission
                const restoreForm = archiveModal.querySelector('#restoreModal form');
                if (restoreForm) {
                    restoreForm.onsubmit = appState.archiveHandleBulkRestore;
                }
                // Delete Confirmation Modal button
                const confirmDeleteBtn = archiveModal.querySelector('#deleteModal .app-action-btn.danger');
                if (confirmDeleteBtn) {
                    confirmDeleteBtn.onclick = () => appState.archiveConfirmDelete();
                }

                // Close buttons for nested modals
                archiveModal.querySelectorAll('.app-modal-overlay .app-modal-close-btn').forEach(btn => {
                    btn.onclick = () => appState.closeModal(btn.closest('.app-modal-overlay').id);
                });

                // Initial update for bulk actions
                appState.archiveUpdateBulkActions();
            },

            initTemplatesModalListeners: function() {
                const templatesModal = document.getElementById('templatesModalContent');

                // Search
                const searchInput = templatesModal.querySelector('.search-input');
                if (searchInput) {
                    searchInput.addEventListener('input', appState.templatesSearch);
                }

                // Category filtering
                templatesModal.querySelectorAll('.category-link').forEach(link => {
                    link.addEventListener('click', appState.templatesFilterByCategory);
                });

                // View toggle
                templatesModal.querySelectorAll('.toggle-btn').forEach(btn => {
                    btn.addEventListener('click', (e) => appState.templatesSwitchView(e.currentTarget.dataset.view, e));
                });

                // Template actions (Use, Edit)
                templatesModal.querySelectorAll('.template-card').forEach(card => {
                    const templateId = card.dataset.templateId;
                    const useBtn = card.querySelector('.template-btn.primary');
                    const editBtn = card.querySelector('.template-btn:not(.primary)');

                    if (useBtn) useBtn.onclick = () => appState.templatesUseTemplate(templateId);
                    if (editBtn) editBtn.onclick = () => appState.templatesEditTemplate(templateId);
                });

                // New Template button (if present)
                const newTemplateBtn = templatesModal.querySelector('.categories-header .action-button');
                if (newTemplateBtn) {
                    newTemplateBtn.onclick = () => appState.templatesCreateTemplate();
                }

                // Template Editor Modal form submission
                const templateForm = templatesModal.querySelector('#templateModal form');
                if (templateForm) {
                    templateForm.onsubmit = appState.templatesSaveTemplate;
                }

                // Template Usage Modal form submission
                const useTemplateForm = templatesModal.querySelector('#useTemplateModal form');
                if (useTemplateForm) {
                    useTemplateForm.onsubmit = appState.templatesSendTemplateResponse;
                }

                // Insert variable buttons
                templatesModal.querySelectorAll('.variable-tag').forEach(tag => {
                    tag.onclick = () => appState.templatesInsertVariable(tag.textContent);
                });

                // Close buttons for nested modals
                templatesModal.querySelectorAll('.app-modal-overlay .app-modal-close-btn').forEach(btn => {
                    btn.onclick = () => appState.closeModal(btn.closest('.app-modal-overlay').id);
                });
            },

            initViewDetailsModalListeners: function() {
                const viewDetailsModal = document.getElementById('viewDetailsModalContent');

                // Re-bind action buttons within the modal
                const replyBtn = viewDetailsModal.querySelector('.header-actions .action-button.primary');
                const archiveBtn = viewDetailsModal.querySelector('.header-actions .action-button.danger');
                const backBtn = viewDetailsModal.querySelector('.header-actions .action-button.secondary');

                if (replyBtn) replyBtn.onclick = () => appState.openResponseModalFromViewDetails();
                if (archiveBtn) archiveBtn.onclick = () => appState.archiveMessageFromViewDetails();
                if (backBtn) backBtn.onclick = () => appState.closeModal('viewDetailsModal');

                // Re-bind quick actions
                viewDetailsModal.querySelectorAll('.quick-action-btn').forEach(btn => {
                    if (btn.onclick.toString().includes('markAsResolvedFromViewDetails')) btn.onclick = () => appState.markAsResolvedFromViewDetails();
                    if (btn.onclick.toString().includes('escalateMessageFromViewDetails')) btn.onclick = () => appState.escalateMessageFromViewDetails();
                    if (btn.onclick.toString().includes('createOrderFromViewDetails')) btn.onclick = () => appState.createOrderFromViewDetails();
                    if (btn.onclick.toString().includes('scheduleFollowUpFromViewDetails')) btn.onclick = () => appState.scheduleFollowUpFromViewDetails();
                });

                // Re-bind attachment downloads
                viewDetailsModal.querySelectorAll('.attachment-item').forEach(item => {
                    const filenameMatch = item.onclick.toString().match(/downloadAttachment\('([^']+)'\)/);
                    if (filenameMatch && filenameMatch[1]) {
                        item.onclick = () => appState.downloadAttachment(filenameMatch[1]);
                    }
                });

                // Re-bind related messages
                viewDetailsModal.querySelectorAll('.related-message').forEach(item => {
                    const relatedIdMatch = item.onclick.toString().match(/viewRelatedMessage\((\d+)\)/);
                    if (relatedIdMatch && relatedIdMatch[1]) {
                        item.onclick = () => appState.viewRelatedMessage(relatedIdMatch[1]);
                    }
                });

                lucide.createIcons();
            },

            // --- Archive Modal Specific Functions (prefixed with archive) ---
            archiveSearch: function() {
                const searchTerm = this.value.toLowerCase();
                const rows = document.querySelectorAll('#archiveModalContent #archiveTableBody tr');

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
            },

            archiveApplyFilters: function() {
                const archiveModal = document.getElementById('archiveModalContent');
                const dateFilter = archiveModal.querySelector('#dateFilter').value;
                const typeFilter = archiveModal.querySelector('#typeFilter').value;
                const reasonFilter = archiveModal.querySelector('#reasonFilter').value;
                const sortFilter = archiveModal.querySelector('#sortFilter').value;

                // Apply filters (simplified for demo)
                console.log('Applying filters:', { dateFilter, typeFilter, reasonFilter, sortFilter });
                appState.showNotification('Filters applied successfully', 'info');
            },

            archiveToggleSelectAll: function() {
                const selectAll = document.getElementById('archiveModalContent').querySelector('#selectAll');
                const checkboxes = document.querySelectorAll('#archiveModalContent .message-checkbox');

                checkboxes.forEach(checkbox => {
                    checkbox.checked = selectAll.checked;
                });
                appState.archiveUpdateBulkActions();
            },

            archiveUpdateBulkActions: function() {
                const checkboxes = document.querySelectorAll('#archiveModalContent .message-checkbox:checked');
                const restoreBtn = document.getElementById('archiveModalContent').querySelector('#restoreBtn');
                const deleteBtn = document.getElementById('archiveModalContent').querySelector('#deleteBtn');

                appState.selectedArchiveMessages = Array.from(checkboxes).map(cb => cb.dataset.id);

                if (appState.selectedArchiveMessages.length > 0) {
                    restoreBtn.disabled = false;
                    deleteBtn.disabled = false;
                } else {
                    restoreBtn.disabled = true;
                    deleteBtn.disabled = true;
                }
            },

            archiveViewArchivedMessage: function(id) {
                appState.viewRequest(id, true); // Pass true for isArchived
            },

            archiveRestoreMessage: function(id) {
                if (confirm('Are you sure you want to restore this message to the inbox?')) {
                    appState.showNotification('Message restored successfully', 'success');
                    appState.archiveRemoveMessageRow(id);
                }
            },

            archiveDeleteMessage: function(id) {
                appState.deleteTarget = [id];
                document.getElementById('archiveModalContent').querySelector('#deleteModal').classList.add('active');
            },

            archiveBulkRestore: function() {
                if (appState.selectedArchiveMessages.length === 0) return;
                document.getElementById('archiveModalContent').querySelector('#restoreModal').classList.add('active');
            },

            archiveBulkDelete: function() {
                if (appState.selectedArchiveMessages.length === 0) return;
                appState.deleteTarget = appState.selectedArchiveMessages.slice();
                document.getElementById('archiveModalContent').querySelector('#deleteModal').classList.add('active');
            },

            archiveHandleBulkRestore: function(event) {
                event.preventDefault();
                const formData = new FormData(event.target);
                const restoreTo = formData.get('restoreTo');
                const reason = formData.get('reason');

                appState.showNotification(`${appState.selectedArchiveMessages.length} messages restored to ${restoreTo}`, 'success');
                appState.closeModal('restoreModal'); // Close the nested modal
                appState.selectedArchiveMessages.forEach(id => appState.archiveRemoveMessageRow(id));
                appState.selectedArchiveMessages = [];
                appState.archiveUpdateBulkActions();
            },

            archiveConfirmDelete: function() {
                appState.showNotification(`${appState.deleteTarget.length} message(s) deleted permanently`, 'success');
                appState.closeModal('deleteModal'); // Close the nested modal
                appState.deleteTarget.forEach(id => appState.archiveRemoveMessageRow(id));
                appState.deleteTarget = null;
                appState.selectedArchiveMessages = [];
                appState.archiveUpdateBulkActions();
            },

            archiveRemoveMessageRow: function(id) {
                const checkbox = document.querySelector(`#archiveModalContent .message-checkbox[data-id="${id}"]`);
                if (checkbox) {
                    checkbox.closest('tr').remove();
                }
            },

            // --- Templates Modal Specific Functions (prefixed with templates) ---
            templatesSearch: function() {
                const searchTerm = this.value.toLowerCase();
                const cards = document.querySelectorAll('#templatesModalContent .template-card');

                cards.forEach(card => {
                    const title = card.querySelector('.template-title').textContent.toLowerCase();
                    const preview = card.querySelector('.template-preview').textContent.toLowerCase();

                    if (title.includes(searchTerm) || preview.includes(searchTerm)) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                });
            },

            templatesFilterByCategory: function(e) {
                e.preventDefault();
                const templatesModal = document.getElementById('templatesModalContent');

                // Update active category
                templatesModal.querySelectorAll('.category-link').forEach(l => l.classList.remove('active'));
                e.currentTarget.classList.add('active');

                const category = e.currentTarget.dataset.category;
                const cards = templatesModal.querySelectorAll('.template-card');

                let visibleCount = 0;
                cards.forEach(card => {
                    if (category === 'all' || card.dataset.category === category) {
                        card.style.display = '';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Update panel title
                const panelTitle = templatesModal.querySelector('.panel-title');
                const categoryName = e.currentTarget.querySelector('span').textContent;
                panelTitle.textContent = `${categoryName} (${visibleCount})`;
            },

            templatesSwitchView: function(view, event) {
                const templatesModal = document.getElementById('templatesModalContent');
                const grid = templatesModal.querySelector('#templateGrid');
                const toggleBtns = templatesModal.querySelectorAll('.toggle-btn');

                toggleBtns.forEach(btn => btn.classList.remove('active'));
                event.currentTarget.classList.add('active');

                if (view === 'list') {
                    grid.classList.add('list-view');
                    grid.style.display = 'block'; // Ensure it's block for list layout
                } else {
                    grid.classList.remove('list-view');
                    grid.style.display = 'grid'; // Revert to grid for grid layout
                }
            },

            templatesUseTemplate: function(templateId) {
                const template = appState.templates[templateId];
                if (!template) {
                    appState.showNotification('Template not found!', 'error');
                    return;
                }

                // If a targetReplyTextarea is set (meaning it was opened from the main reply section)
                if (appState.targetReplyTextarea) {
                    let content = template.content;
                    const currentMessage = appState.messageData[appState.currentMessageId];

                    // Robust variable replacement
                    if (currentMessage) {
                        content = content.replace(/{{customer_name}}/g, currentMessage.customer || 'Customer');
                        content = content.replace(/{{product_name}}/g, currentMessage.subject.includes('Product Availability') ? 'our products' : 'the item');
                        content = content.replace(/{{order_id}}/g, 'N/A');
                        content = content.replace(/{{issue_description}}/g, currentMessage.subject);
                        content = content.replace(/{{quantity}}/g, 'N/A');
                        content = content.replace(/{{discount}}/g, 'N/A');
                        content = content.replace(/{{delivery_date}}/g, 'N/A');
                        content = content.replace(/{{tracking_number}}/g, 'N/A');
                        content = content.replace(/{{company_name}}/g, 'M & E Team');
                        content = content.replace(/{{product_service}}/g, 'our service');
                        content = content.replace(/{{custom_item}}/g, currentMessage.subject);
                        content = content.replace(/{{quote_details}}/g, 'Details to be provided');
                        content = content.replace(/{{delivery_timeline}}/g, '2-3 weeks');
                        content = content.replace(/{{delivery_address}}/g, currentMessage.location || 'N/A');
                        content = content.replace(/{{order_details}}/g, 'See attached order summary');
                    }
                    // Remove any remaining {{variables}} that weren't replaced
                    content = content.replace(/{{[a-zA-Z_]+}}/g, '');

                    appState.targetReplyTextarea.value = content;
                    appState.showNotification(`Template "${template.name}" applied to reply.`, 'info');
                    appState.closeModal('templatesModal');
                    appState.targetReplyTextarea = null; // Reset target
                } else {
                    // Otherwise, open the nested use template modal
                    const templatesModal = document.getElementById('templatesModalContent');
                    const useTemplateModal = templatesModal.querySelector('#useTemplateModal');

                    // Populate the use template modal
                    const currentMessage = appState.messageData[appState.currentMessageId];
                    let populatedSubject = template.subject;
                    let populatedContent = template.content;

                    if (currentMessage) {
                        populatedSubject = populatedSubject.replace(/{{customer_name}}/g, currentMessage.customer || 'Customer');
                        populatedSubject = populatedSubject.replace(/{{order_id}}/g, 'N/A');
                        populatedSubject = populatedSubject.replace(/{{complaint_subject}}/g, currentMessage.subject);

                        populatedContent = populatedContent.replace(/{{customer_name}}/g, currentMessage.customer || 'Customer');
                        populatedContent = populatedContent.replace(/{{product_name}}/g, currentMessage.subject.includes('Product Availability') ? 'our products' : 'the item');
                        populatedContent = populatedContent.replace(/{{order_id}}/g, 'N/A');
                        populatedContent = populatedContent.replace(/{{issue_description}}/g, currentMessage.subject);
                        populatedContent = populatedContent.replace(/{{quantity}}/g, 'N/A');
                        populatedContent = populatedContent.replace(/{{discount}}/g, 'N/A');
                        populatedContent = populatedContent.replace(/{{delivery_date}}/g, 'N/A');
                        populatedContent = populatedContent.replace(/{{tracking_number}}/g, 'N/A');
                        populatedContent = populatedContent.replace(/{{company_name}}/g, 'M & E Team');
                        populatedContent = populatedContent.replace(/{{product_service}}/g, 'our service');
                        populatedContent = populatedContent.replace(/{{custom_item}}/g, currentMessage.subject);
                        populatedContent = populatedContent.replace(/{{quote_details}}/g, 'Details to be provided');
                        populatedContent = populatedContent.replace(/{{delivery_timeline}}/g, '2-3 weeks');
                        populatedContent = populatedContent.replace(/{{delivery_address}}/g, currentMessage.location || 'N/A');
                        populatedContent = populatedContent.replace(/{{order_details}}/g, 'See attached order summary');
                    }
                    populatedSubject = populatedSubject.replace(/{{[a-zA-Z_]+}}/g, '');
                    populatedContent = populatedContent.replace(/{{[a-zA-Z_]+}}/g, '');


                    useTemplateModal.querySelector('#templateSubject').value = populatedSubject;
                    useTemplateModal.querySelector('#templateMessage').value = populatedContent;
                    useTemplateModal.querySelector('input[name="recipient"]').value = currentMessage ? currentMessage.email : 'recipient@example.com';


                    // Show modal
                    useTemplateModal.classList.add('active');
                }
            },

            templatesEditTemplate: function(templateId) {
                const template = appState.templates[templateId] || {
                    name: '',
                    category: 'inquiry',
                    subject: '',
                    content: '',
                    notes: ''
                };

                const templatesModal = document.getElementById('templatesModalContent');
                const templateEditorModal = templatesModal.querySelector('#templateModal');
                const form = templateEditorModal.querySelector('#templateForm');

                // Populate form
                form.name.value = template.name;
                form.category.value = template.category;
                form.subject.value = template.subject;
                form.content.value = template.content;
                form.notes.value = template.notes;

                // Update modal title
                templateEditorModal.querySelector('#modalTitle').textContent = templateId ? 'Edit Template' : 'Create New Template';

                // Show modal
                templateEditorModal.classList.add('active');
            },

            templatesCreateTemplate: function() {
                appState.templatesEditTemplate(null); // Pass null to indicate new template
            },

            templatesInsertVariable: function(variable) {
                const templatesModal = document.getElementById('templatesModalContent');
                const textarea = templatesModal.querySelector('#templateContent');
                if (!textarea) return; // Ensure textarea exists

                const cursorPos = textarea.selectionStart;
                const textBefore = textarea.value.substring(0, cursorPos);
                const textAfter = textarea.value.substring(cursorPos);

                textarea.value = textBefore + variable + textAfter;
                textarea.focus();
                textarea.setSelectionRange(cursorPos + variable.length, cursorPos + variable.length);
            },

            templatesSaveTemplate: function(event) {
                event.preventDefault();
                const formData = new FormData(event.target);
                const templateName = formData.get('name');
                // In a real app, you'd save this to a backend and update appState.templates
                console.log('Saving template:', Object.fromEntries(formData.entries()));

                appState.showNotification(`Template "${templateName}" saved successfully!`, 'success');
                appState.closeModal('templateModal'); // Close the nested modal
            },

            templatesSendTemplateResponse: function(event) {
                event.preventDefault();
                const formData = new FormData(event.target);
                // In a real app, you'd send this email/message
                console.log('Sending template response:', Object.fromEntries(formData.entries()));

                appState.showNotification('Response sent successfully!', 'success');
                appState.closeModal('useTemplateModal'); // Close the nested modal
                appState.closeModal('templatesModal'); // Close the main templates modal
            },

            // --- View Details Modal Specific Functions (prefixed with fromViewDetails) ---
            openResponseModalFromViewDetails: function() {
                appState.openResponseModal();
                appState.closeModal('viewDetailsModal');
            },

            archiveMessageFromViewDetails: function() {
                if (confirm('Are you sure you want to archive this message?')) {
                    appState.showNotification('Message archived successfully', 'success');
                    appState.closeModal('viewDetailsModal');
                    // In a real app, you'd move the message from messageData to an archivedMessagesData
                    // and update the main message list.
                }
            },

            markAsResolvedFromViewDetails: function() {
                if (confirm('Are you sure you want to mark this message as resolved?')) {
                    appState.showNotification('Message marked as resolved', 'success');
                    const statusElement = document.getElementById('viewDetailsModalContent').querySelector('#messageStatus');
                    if (statusElement) statusElement.textContent = 'Resolved';
                    // In a real app, update the message status in appState.messageData
                }
            },

            escalateMessageFromViewDetails: function() {
                appState.showNotification('Message escalated to supervisor', 'info');
            },

            createOrderFromViewDetails: function() {
                appState.showNotification('Redirecting to order creation...', 'info');
                const currentMessage = appState.messageData[appState.currentMessageId];
                if (currentMessage) {
                    window.open(`../orders/create.php?customer=${encodeURIComponent(currentMessage.customer)}&email=${encodeURIComponent(currentMessage.email)}`, '_blank');
                } else {
                    window.open('../orders/create.php', '_blank');
                }
            },

            scheduleFollowUpFromViewDetails: function() {
                appState.showNotification('Follow-up scheduled', 'success');
            },

            downloadAttachment: function(filename) {
                appState.showNotification('Downloading ' + filename + '...', 'info');
                // Simulate download logic here
            },

            viewRelatedMessage: function(id) {
                appState.viewRequest(id); // Reload the viewDetailsModal with the related message
            }
        };

        // Event delegation for message list items
        document.getElementById('messagesContainer').addEventListener('click', function(event) {
            const messageItem = event.target.closest('.message-item');
            if (messageItem) {
                // Update active message
                document.querySelectorAll('.message-item').forEach(i => i.classList.remove('active'));
                messageItem.classList.add('active');

                // Get message ID and load data
                const messageId = messageItem.dataset.id;
                appState.currentMessageId = messageId;
                appState.loadMessageDetail(messageId);

                // Remove unread status
                if (messageItem.classList.contains('unread')) {
                    messageItem.classList.remove('unread');
                    appState.updateUnreadCount();
                }
            }
        });

        // Close modals when clicking outside
        document.querySelectorAll('.app-modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', function(e) {
                if (e.target === this) {
                    appState.closeModal(this.id);
                }
            });
        });

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            appState.updateUnreadCount();
            appState.loadMessageDetail(appState.currentMessageId);
        });
    </script>
</body>
</html>
