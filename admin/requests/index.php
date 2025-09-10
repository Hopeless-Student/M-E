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
            width: 250px;
            height: 250px;
        }

        .dashboard {
            display: flex;
            min-height: 100vh;
            align-items: stretch;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            color: white;
            padding: 2rem 0;
            box-shadow: 4px 0 10px rgba(30, 58, 138, 0.1);
            flex-shrink:0;
            overflow-y: auto;
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
                    <button class="action-button" onclick="window.location.href='./archive-request.php'">
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
                            <button class="icon-btn" onclick="openArchiveModal()" title="Archive">
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
                <!-- <div class="form-group"> -->
                    <!-- <label class="form-label">Archive Criteria</label> -->
                    <!-- <select class="form-select" name="criteria" required>
                        <option value="">Select criteria</option>
                        <option value="older_than_30">Older than 30 days</option>
                        <option value="older_than_60">Older than 60 days</option>
                        <option value="older_than_90">Older than 90 days</option>
                        <option value="resolved">Resolved messages only</option>
                        <option value="all_read">All read messages</option>
                    </select> -->
                <!-- </div> -->
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

    <!-- Response Modal -->
    <div class="modal-overlay" id="responseModal">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title">Quick Response</h3>
                <button class="close-btn" onclick="closeModal('responseModal')">&times;</button>
            </div>
            <form onsubmit="handleQuickResponse(event)">
                <div class="form-group">
                    <label class="form-label">Response Template</label>
                    <select class="form-select" name="template" onchange="loadTemplate(this.value)">
                        <option value="">Select template</option>
                        <option value="availability">Product Availability Response</option>
                        <option value="custom_order">Custom Order Response</option>
                        <option value="complaint">Complaint Resolution</option>
                        <option value="thank_you">Thank You Response</option>
                        <option value="delivery_info">Delivery Information</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Response Message</label>
                    <textarea class="form-textarea" name="response" id="responseText" placeholder="Type your response here..." required></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Priority</label>
                    <select class="form-select" name="priority">
                        <option value="normal">Normal</option>
                        <option value="high">High</option>
                        <option value="urgent">Urgent</option>
                    </select>
                </div>
                <div class="modal-actions">
                    <button type="button" class="action-btn secondary" onclick="closeModal('responseModal')">Cancel</button>
                    <button type="submit" class="action-btn primary">Send Response</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Notification -->
    <div class="notification" id="notification"></div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Message data for demo
        const messageData = {
            1: {
                customer: 'Juan Dela Cruz',
                email: 'juan.delacruz@email.com',
                phone: '+63 917 123 4567',
                avatar: 'JD',
                subject: 'Product Availability Inquiry',
                type: 'inquiry',
                time: 'August 20, 2025 - 2:15 PM',
                content: `Hi M & E Team,

I'm looking for bulk ballpoint pens for our office. We need at least 200 pieces (around 16-17 packs of 12). Do you have this quantity available? Also, would there be any discount for bulk orders?

We're located in Olongapo City, so delivery should be within your service area. Please let me know the availability and total cost including delivery.

Thank you!
Juan Dela Cruz`
            },
            2: {
                customer: 'Maria Santos',
                email: 'maria.santos@email.com',
                phone: '+63 918 234 5678',
                avatar: 'MS',
                subject: 'Custom Order Request',
                type: 'custom-order',
                time: 'August 20, 2025 - 12:30 PM',
                content: `Hello,

I need customized notebooks with our school logo. We need about 500 pieces for our incoming school year. The specifications are:
- Size: A5
- Pages: 100 pages each
- Cover: Hard cover with our logo
- Timeline: Need them by September 15

Can you provide a quote and timeline for this custom order?

Best regards,
Maria Santos`
            }
        };

        let currentMessageId = 1;

        // Message filtering
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                // Update active tab
                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const filter = this.dataset.filter;
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
            });
        });

        // Message selection
        document.querySelectorAll('.message-item').forEach(item => {
            item.addEventListener('click', function() {
                // Update active message
                document.querySelectorAll('.message-item').forEach(i => i.classList.remove('active'));
                this.classList.add('active');

                // Get message ID and load data
                const messageId = this.dataset.id;
                currentMessageId = messageId;
                loadMessageDetail(messageId);

                // Remove unread status
                if (this.classList.contains('unread')) {
                    this.classList.remove('unread');
                    updateUnreadCount();
                }
            });
        });

        // Load message detail
        function loadMessageDetail(messageId) {
            const data = messageData[messageId];
            if (!data) return;

            // Update customer info
            document.querySelector('.customer-avatar').textContent = data.avatar;
            document.querySelector('.customer-details h3').textContent = data.customer;
            document.querySelector('.customer-details p').textContent = `${data.email} • ${data.phone}`;

            // Update message info
            document.querySelector('.message-detail-header .message-type').textContent = data.type.replace('-', ' ').replace(/\b\w/g, l => l.toUpperCase());
            document.querySelector('.message-detail-header .message-time').textContent = data.time;
            document.querySelector('.message-content h4').textContent = data.subject;

            // Update message content
            const messageText = document.querySelector('.message-text');
            messageText.innerHTML = data.content.split('\n').map(line => line.trim() ? `<p>${line}</p>` : '<br>').join('');
        }

        // Update unread count
        function updateUnreadCount() {
            const unreadMessages = document.querySelectorAll('.message-item.unread');
            const count = unreadMessages.length;

            document.getElementById('unreadMessages').textContent = count;
            document.getElementById('unreadBadge').textContent = count;

            if (count === 0) {
                document.getElementById('unreadBadge').style.display = 'none';
            }
        }

        // Search functionality
        document.querySelector('.search-input').addEventListener('input', function() {
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
        });

        // Reply form
        function sendReply(event) {
            event.preventDefault();
            const replyText = document.querySelector('.reply-textarea').value;
            if (replyText.trim()) {
                showNotification('Reply sent successfully!', 'success');
                document.querySelector('.reply-textarea').value = '';

                // Mark message as read if it was unread
                const activeMessage = document.querySelector('.message-item.active');
                if (activeMessage && activeMessage.classList.contains('unread')) {
                    activeMessage.classList.remove('unread');
                    updateUnreadCount();
                }
            }
        }

        // Save draft functionality
        function saveDraft() {
            const replyText = document.querySelector('.reply-textarea').value;
            if (replyText.trim()) {
                showNotification('Draft saved successfully!', 'success');
            } else {
                showNotification('No content to save', 'error');
            }
        }

        // Modal functions
        function openArchiveModal() {
            document.getElementById('archiveModal').classList.add('active');
        }

        function openResponseModal() {
            document.getElementById('responseModal').classList.add('active');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('active');
        }

        // Archive functionality
        function handleArchive(event) {
            event.preventDefault();
            const formData = new FormData(event.target);
            const criteria = formData.get('criteria');
            const reason = formData.get('reason');

            // Simulate archive request
            setTimeout(() => {
                showNotification('Messages archived successfully!', 'success');
                closeModal('archiveModal');
                // Redirect to archive page
                // window.location.href = './archive-request.php';
            }, 1000);
        }

        // Quick response functionality
        function handleQuickResponse(event) {
            event.preventDefault();
            const formData = new FormData(event.target);
            const response = formData.get('response');
            const priority = formData.get('priority');

            if (response.trim()) {
                setTimeout(() => {
                    showNotification('Response sent successfully!', 'success');
                    closeModal('responseModal');

                    // Mark message as read
                    const activeMessage = document.querySelector('.message-item.active');
                    if (activeMessage && activeMessage.classList.contains('unread')) {
                        activeMessage.classList.remove('unread');
                        updateUnreadCount();
                    }
                }, 1000);
            }
        }

        // Load response templates
        function loadTemplate(templateType) {
            const responseText = document.getElementById('responseText');
            const templates = {
                availability: `Dear Customer,

Thank you for your inquiry about our ballpoint pens. Yes, we have the quantity you need available in stock. For bulk orders of 200+ pieces, we offer a 15% discount.

Here are the details:
- Regular price: ₱25 per pack (12 pieces)
- Bulk price: ₱21.25 per pack
- Total for 17 packs: ₱361.25
- Delivery to Olongapo City: ₱150

Would you like to proceed with this order?

Best regards,
M & E Team`,
                custom_order: `Dear Customer,

Thank you for your custom order inquiry. We'd be happy to help you with your customized notebooks.

Based on your requirements, here's our quote:
- Custom notebooks with logo printing
- Estimated cost: Will be provided after design review
- Timeline: 2-3 weeks from order confirmation

Please send us your logo file and we'll provide a detailed quote within 24 hours.

Best regards,
M & E Team`,
                complaint: `Dear Customer,

We sincerely apologize for the inconvenience you've experienced. We take all customer concerns seriously and will investigate this matter immediately.

We will:
1. Track your order status
2. Contact our delivery partner
3. Provide you with an update within 2 hours

Thank you for your patience.

Best regards,
M & E Team`,
                thank_you: `Dear Customer,

Thank you so much for your positive feedback! We're delighted to hear that you're satisfied with our service and products.

Customer satisfaction is our top priority, and reviews like yours motivate us to continue providing excellent service.

We look forward to serving you again!

Best regards,
M & E Team`,
                delivery_info: `Dear Customer,

Thank you for your inquiry about delivery options.

Our delivery information:
- Metro Manila: 1-2 business days (₱100)
- Provincial areas: 2-3 business days (₱150-200)
- Free delivery for orders above ₱1,500

You can track your order through our website using your order number.

Best regards,
M & E Team`
            };

            if (templates[templateType]) {
                responseText.value = templates[templateType];
            }
        }

        // View request functionality
        function viewRequest() {
            window.open('view-request.php?id=' + currentMessageId, '_blank');
        }

        // Archive single message
        function archiveMessage() {
            if (confirm('Are you sure you want to archive this message?')) {
                showNotification('Message archived successfully!', 'success');
                const activeMessage = document.querySelector('.message-item.active');
                if (activeMessage) {
                    activeMessage.remove();
                }
            }
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
            updateUnreadCount();
            loadMessageDetail(1);
        });
    </script>
</body>
</html>
