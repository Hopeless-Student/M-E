<?php
 require_once __DIR__ . '/../../auth/admin_auth.php';
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Requests - M & E Dashboard</title>
    <link rel="icon" type="image/x-icon" href="../assets/images/M&E_LOGO-semi-transparent.ico">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <link rel="stylesheet" href="../assets/css/admin/requests/index.css">
    <style>
        /* General Modal Styles */
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
            max-width: 700px;
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

        /* Form Group Styles */
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

        /* Action Button Styles */
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

        /* Specific modal sizes */
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

        /* Archive Modal */
        #archiveModal .app-modal {
            max-width: 900px;
        }

        /* View Details Modal */
        #viewDetailsModal .app-modal {
            max-width: 1000px;
            padding: 0;
        }
        #viewDetailsModal .app-modal-body {
            padding: 0;
        }

        /* Templates Modal */
        #templatesModal .app-modal {
            max-width: 1100px;
        }

        /* Loading spinner */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(30, 64, 175, 0.3);
            border-radius: 50%;
            border-top-color: #1e40af;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            display: none;
        }

        .loading-overlay.active {
            display: flex;
        }

        .loading-content {
            text-align: center;
        }

        .loading-spinner-large {
            width: 50px;
            height: 50px;
            border: 4px solid rgba(30, 64, 175, 0.3);
            border-radius: 50%;
            border-top-color: #1e40af;
            animation: spin 1s ease-in-out infinite;
            margin: 0 auto 1rem;
        }
    </style>
</head>
<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-content">
            <div class="loading-spinner-large"></div>
            <p>Loading...</p>
        </div>
    </div>

    <div class="dashboard">
      <button class="mobile-menu-btn" data-sidebar-toggle="open">
          <i data-lucide="menu"></i>
      </button>
        <?php include '../../includes/admin_sidebar.php' ?>

        <!-- Main Content -->
        <main class="main-content">
            <div class="header">
                <h2>Customer Messages</h2>
                <div class="header-actions">
                    <div class="search-box">
                        <i data-lucide="search" class="search-icon"></i>
                        <input type="text" class="search-input" id="mainSearchInput" placeholder="Search messages...">
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
                        <span><?= htmlspecialchars($_SESSION['admin_username'] ?? 'Admin') ?></span>
                        <div class="avatar"><?= htmlspecialchars(strtoupper(substr($_SESSION['admin_username'] ?? 'A', 0, 1))) ?></div>
                    </div>
                </div>
            </div>

            <!-- Message Stats -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-title">Total Messages</div>
                    <div class="stat-value" id="totalMessages">-</div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">Unread Messages</div>
                    <div class="stat-value" id="unreadMessages">-</div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">Custom Orders</div>
                    <div class="stat-value" id="customOrders">-</div>
                </div>
                <div class="stat-card">
                    <div class="stat-title">Avg Response Time</div>
                    <div class="stat-value" id="avgResponseTime">-</div>
                </div>
            </div>

            <!-- Messages Layout -->
            <div class="messages-layout">
                <!-- Message List -->
                <div class="message-list">
                    <div class="message-list-header">
                        <h3 class="list-title">Customer Messages</h3>
                        <div class="filter-tabs">
                            <button class="tab-btn active" data-filter="all">All</button>
                            <button class="tab-btn" data-filter="pending">
                                Unread
                                <span class="badge" id="unreadBadge">0</span>
                            </button>
                            <button class="tab-btn" data-filter="custom_order">Custom Orders</button>
                        </div>
                    </div>
                    <div class="messages-container" id="messagesContainer">
                        <p style="text-align: center; padding: 2rem; color: #64748b;">Loading messages...</p>
                    </div>
                </div>

                <!-- Message Detail -->
                <div class="message-detail" id="messageDetail">
                    <p style="text-align: center; padding: 3rem; color: #64748b;">Select a message to view details</p>
                </div>
            </div>
        </main>
    </div>

    <!-- Archive Modal -->
    <div class="app-modal-overlay" id="archiveModal">
        <div class="app-modal" id="archiveModalContent"></div>
    </div>

    <!-- Response Modal -->
    <div class="app-modal-overlay" id="responseModal">
        <div class="app-modal">
            <div class="app-modal-header">
                <h3 class="app-modal-title">Quick Response</h3>
                <button class="app-modal-close-btn" onclick="appState.closeModal('responseModal')">&times;</button>
            </div>
            <form id="quickResponseForm" onsubmit="appState.handleQuickResponse(event)">
                <div class="app-form-group">
                    <label class="app-form-label">Response Template</label>
                    <select class="app-form-select" name="template" id="templateSelect">
                        <option value="">Select template</option>
                    </select>
                </div>
                <div class="app-form-group">
                    <label class="app-form-label">Subject</label>
                    <input type="text" class="app-form-input" name="subject" id="responseSubject" placeholder="Email subject">
                </div>
                <div class="app-form-group">
                    <label class="app-form-label">Response Message</label>
                    <textarea class="app-form-textarea" name="response" id="responseText" placeholder="Type your response here..." required></textarea>
                </div>
                <div class="app-form-group">
                    <label class="app-form-label">Status</label>
                    <select class="app-form-select" name="status">
                        <option value="in-progress">In Progress</option>
                        <option value="resolved">Resolved</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>
                <div class="app-form-group">
                    <label class="app-form-label">Priority</label>
                    <select class="app-form-select" name="priority">
                        <option value="low">Low</option>
                        <option value="medium" selected>Medium</option>
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

    <!-- Templates Modal -->
    <div class="app-modal-overlay" id="templatesModal">
        <div class="app-modal" id="templatesModalContent"></div>
    </div>

    <!-- View Details Modal -->
    <div class="app-modal-overlay" id="viewDetailsModal">
        <div class="app-modal" id="viewDetailsModalContent"></div>
    </div>

    <!-- Single Archive Modal -->
    <div class="app-modal-overlay" id="singleArchiveModal">
        <div class="app-modal">
            <div class="app-modal-header">
                <h3 class="app-modal-title">Archive Message</h3>
                <button class="app-modal-close-btn" onclick="appState.closeModal('singleArchiveModal')">&times;</button>
            </div>
            <form id="singleArchiveForm" onsubmit="appState.handleSingleArchive(event)">
                <p style="margin-bottom: 1.5rem; color: #64748b;">
                    You are about to archive message <span id="archiveMessageIdDisplay" style="font-weight: 600;"></span>.
                </p>
                <div class="app-form-group">
                    <label class="app-form-label">Archive Reason</label>
                    <select class="app-form-select" name="archiveReason" required>
                        <option value="">Select reason</option>
                        <option value="resolved">Resolved</option>
                        <option value="auto">Auto-archived (System)</option>
                        <option value="manual">Manually archived</option>
                        <option value="expired">Expired/Outdated</option>
                        <option value="spam">Spam</option>
                    </select>
                </div>
                <div class="app-form-group">
                    <label class="app-form-label">Notes (Optional)</label>
                    <textarea class="app-form-textarea" name="archiveNotes" placeholder="Add any relevant notes..."></textarea>
                </div>
                <div class="app-modal-actions">
                    <button type="button" class="app-action-btn secondary" onclick="appState.closeModal('singleArchiveModal')">Cancel</button>
                    <button type="submit" class="app-action-btn primary">Archive Message</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Notification -->
    <div class="app-notification" id="appNotification"></div>

    <!-- Load the JavaScript app logic -->
    <script src="../assets/js/app.js"></script>
    <script>
        lucide.createIcons();
    </script>
    <script src="../assets/js/api.js"></script>
</body>
</html>
