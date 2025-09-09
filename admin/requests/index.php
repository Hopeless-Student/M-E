<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages - M & E Dashboard</title>
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
        }

        .action-button:hover {
            background-color: #1e3a8a;
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

        /* Message Stats */
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
            border-left: 4px solid #1e40af;
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
            color: #1e40af;
            margin-top: 0.5rem;
        }

        /* Message Layout */
        .messages-layout {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 1.5rem;
            height: 600px;
        }

        /* Message List */
        .message-list {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .message-list-header {
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

        .filter-tabs {
            display: flex;
            gap: 0.5rem;
        }

        .tab-btn {
            padding: 0.5rem 1rem;
            border: none;
            background: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.85rem;
            transition: all 0.2s ease;
            position: relative;
        }

        .tab-btn.active {
            background-color: #1e40af;
            color: white;
        }

        .tab-btn .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #dc2626;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .messages-container {
            max-height: 500px;
            overflow-y: auto;
        }

        .message-item {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
        }

        .message-item:hover {
            background-color: #f8fafc;
        }

        .message-item.active {
            background-color: #e0e7ff;
            border-left: 4px solid #1e40af;
        }

        .message-item.unread {
            background-color: #fefce8;
            border-left: 4px solid #f59e0b;
        }

        .message-item.unread::before {
            content: '';
            position: absolute;
            left: 8px;
            top: 50%;
            transform: translateY(-50%);
            width: 8px;
            height: 8px;
            background-color: #f59e0b;
            border-radius: 50%;
        }

        .message-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .message-from {
            font-weight: 600;
            color: #1e40af;
        }

        .message-time {
            font-size: 0.8rem;
            color: #64748b;
        }

        .message-subject {
            font-size: 0.9rem;
            color: #334155;
            margin-bottom: 0.25rem;
            font-weight: 500;
        }

        .message-preview {
            font-size: 0.85rem;
            color: #64748b;
            line-height: 1.4;
        }

        .message-type {
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            font-size: 0.7rem;
            font-weight: 500;
            margin-top: 0.5rem;
            display: inline-block;
        }

        .message-type.inquiry { background-color: #dbeafe; color: #1d4ed8; }
        .message-type.custom-order { background-color: #fef3c7; color: #92400e; }
        .message-type.complaint { background-color: #fee2e2; color: #dc2626; }
        .message-type.feedback { background-color: #d1fae5; color: #065f46; }

        /* Message Detail */
        .message-detail {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }

        .message-detail-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .detail-customer {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .customer-avatar {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .customer-details h3 {
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 0.25rem;
        }

        .customer-details p {
            font-size: 0.9rem;
            color: #64748b;
        }

        .message-actions {
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
        }

        .icon-btn:hover {
            background-color: #f8fafc;
        }

        .message-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .message-content {
            flex: 1;
            padding: 1.5rem;
            overflow-y: auto;
        }

        .message-text {
            background-color: #f8fafc;
            padding: 1rem;
            border-radius: 8px;
            border-left: 4px solid #1e40af;
            margin-bottom: 1rem;
        }

        .reply-section {
            padding: 1.5rem;
            border-top: 1px solid #e2e8f0;
        }

        .reply-form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .reply-textarea {
            min-height: 100px;
            padding: 1rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            resize: vertical;
            font-family: inherit;
            transition: border-color 0.2s ease;
        }

        .reply-textarea:focus {
            outline: none;
            border-color: #1e40af;
        }

        .reply-actions {
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
            display: flex;
            align-items: center;
            gap: 0.5rem;
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

        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
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

        .form-group {
            margin-bottom: 1rem;
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
            min-height: 100px;
        }

        .modal-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 2rem;
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

            .messages-layout {
                grid-template-columns: 1fr;
                height: auto;
            }

            .stats-grid {
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
                <h2>Customer Messages</h2>
                <div class="header-actions">
                    <div class="search-box">
                        <i data-lucide="search" class="search-icon"></i>
                        <input type="text" class="search-input" placeholder="Search messages...">
                    </div>
                    <button class="action-button" onclick="openArchiveModal()">
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
                            <button class="tab-btn active" data-filter="all">All</button>
                            <button class="tab-btn" data-filter="unread">
                                Unread
                                <span class="badge" id="unreadBadge">12</span>
                            </button>
                            <button class="tab-btn" data-filter="custom">Custom Orders</button>
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
                            <button class="icon-btn" onclick="viewRequest()" title="View Details">
                                <i data-lucide="eye" width="16" height="16"></i>
                            </button>
                            <button class="icon-btn" onclick="openResponseModal()" title="Quick Response">
                                <i data-lucide="reply" width="16" height="16"></i>
                            </button>
                            <button class="icon-btn" onclick="archiveMessage()" title="Archive">
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
                        <form class="reply-form" onsubmit="sendReply(event)">
                            <textarea class="reply-textarea" placeholder="Type your reply here..." required></textarea>
                            <div class="reply-actions">
                                <button type="button" class="action-btn secondary" onclick="saveDraft()">
                                    <i data-lucide="save" width="16" height="16"></i>
                                    Save Draft
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

    <!-- Archive Modal -->
    <div class="modal-overlay" id="archiveModal">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title">Archive Messages</h3>
                <button class="close-btn" onclick="closeModal('archiveModal')">&times;</button>
            </div>
            <form onsubmit="handleArchive(event)">
                <div class="form-group">
                    <label class="form-label">Archive Criteria</label>
                    <select class="form-select" name="criteria" required>
                        <option value="">Select criteria</option>
                        <option value="older_than_30">Older than 30 days</option>
                        <option value="older_than_60">Older than 60 days</option>
                        <option value="older_than_90">Older than 90 days</option>
                        <option value="resolved">Resolved messages only</option>
                        <option value="all_read">All read messages</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Archive Reason</label>
                    <textarea class="form-textarea" name="reason" placeholder="Optional reason for archiving..."></textarea>
                </div>
                <div class="modal-actions">
                    <button type="button" class="action-btn secondary" onclick="closeModal('archiveModal')">Cancel</button>
                    <button type="submit" class="action-btn primary">Archive Messages</button>
                </div>
            </form>
        </div>
    </div>

  

    <script>
    lucide.createIcons();

    </script>

  </body>
  </html>
