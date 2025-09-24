<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages - M & E Dashboard</title>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <link rel="stylesheet" href="../assets/css/admin/requests/index.css">

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
                        <input type="text" class="search-input" placeholder="Search messages...">
                    </div>
                    <a href="./respond-request.php" class="action-button secondary">
                        <i data-lucide="file-text" width="16" height="16"></i>
                        Templates
                    </a>
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
                                <p>juan.delacruz@email.com â€¢ +63 917 123 4567</p>
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
            document.querySelector('.customer-details p').textContent = `${data.email} â€¢ ${data.phone}`;

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
- Regular price: â‚±25 per pack (12 pieces)
- Bulk price: â‚±21.25 per pack
- Total for 17 packs: â‚±361.25
- Delivery to Olongapo City: â‚±150

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
- Metro Manila: 1-2 business days (â‚±100)
- Provincial areas: 2-3 business days (â‚±150-200)
- Free delivery for orders above â‚±1,500

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
