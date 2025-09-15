<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Details - M & E Dashboard</title>
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

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 2rem;
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .header-left {
            flex: 1;
        }

        .header h1 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 0.5rem;
        }

        .header p {
            color: #64748b;
            font-size: 0.9rem;
        }

        .header-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .action-button {
            padding: 0.75rem 1.5rem;
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

        .action-button.primary {
            background-color: #1e40af;
            color: white;
        }

        .action-button.primary:hover {
            background-color: #1e3a8a;
        }

        .action-button.secondary {
            background-color: #e2e8f0;
            color: #64748b;
        }

        .action-button.secondary:hover {
            background-color: #cbd5e1;
        }

        .action-button.danger {
            background-color: #dc2626;
            color: white;
        }

        .action-button.danger:hover {
            background-color: #b91c1c;
        }

        .main-layout {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .message-panel {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .message-header {
            padding: 2rem;
            border-bottom: 1px solid #e2e8f0;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .customer-info {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .customer-avatar {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.5rem;
        }

        .customer-details h2 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 0.5rem;
        }

        .customer-contact {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #64748b;
            font-size: 0.9rem;
        }

        .message-meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .meta-item {
            display: flex;
            flex-direction: column;
        }

        .meta-label {
            font-size: 0.8rem;
            color: #64748b;
            margin-bottom: 0.25rem;
            font-weight: 500;
        }

        .meta-value {
            font-size: 0.9rem;
            color: #374151;
            font-weight: 500;
        }

        .message-type-badge {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-block;
        }

        .message-type-badge.inquiry { background-color: #dbeafe; color: #1d4ed8; }
        .message-type-badge.custom-order { background-color: #fef3c7; color: #92400e; }
        .message-type-badge.complaint { background-color: #fee2e2; color: #dc2626; }
        .message-type-badge.feedback { background-color: #d1fae5; color: #065f46; }

        .priority-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .priority-badge.normal { background-color: #e2e8f0; color: #64748b; }
        .priority-badge.high { background-color: #fef3c7; color: #92400e; }
        .priority-badge.urgent { background-color: #fee2e2; color: #dc2626; }

        .message-content {
            padding: 2rem;
        }

        .content-section {
            margin-bottom: 2rem;
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .message-text {
            background-color: #f8fafc;
            padding: 1.5rem;
            border-radius: 8px;
            border-left: 4px solid #1e40af;
            white-space: pre-wrap;
            font-family: inherit;
        }

        .attachments {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .attachment-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            transition: all 0.2s ease;
            cursor: pointer;
            min-width: 200px;
        }

        .attachment-item:hover {
            background-color: #e2e8f0;
        }

        .attachment-icon {
            width: 40px;
            height: 40px;
            background-color: #1e40af;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .attachment-info {
            flex: 1;
        }

        .attachment-name {
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.25rem;
        }

        .attachment-size {
            font-size: 0.8rem;
            color: #64748b;
        }

        .response-history {
            border-top: 1px solid #e2e8f0;
            padding: 2rem;
        }

        .response-item {
            padding: 1.5rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .response-item:last-child {
            margin-bottom: 0;
        }

        .response-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .response-author {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .author-avatar {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #64748b, #94a3b8);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .author-info {
            display: flex;
            flex-direction: column;
        }

        .author-name {
            font-weight: 600;
            color: #374151;
            font-size: 0.9rem;
        }

        .response-time {
            font-size: 0.8rem;
            color: #64748b;
        }

        .response-text {
            background-color: #f8fafc;
            padding: 1rem;
            border-radius: 6px;
            border-left: 3px solid #64748b;
            white-space: pre-wrap;
        }

        .sidebar-panel {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .info-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .card-header {
            padding: 1.5rem 1.5rem 0;
        }

        .card-title {
            font-size: 1rem;
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 1rem;
        }

        .card-content {
            padding: 0 1.5rem 1.5rem;
        }

        .info-list {
            list-style: none;
        }

        .info-item {
            display: flex;
            justify-content: between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            font-size: 0.85rem;
            color: #64748b;
            font-weight: 500;
        }

        .info-value {
            font-size: 0.85rem;
            color: #374151;
            font-weight: 500;
        }

        .timeline {
            position: relative;
        }

        .timeline-item {
            position: relative;
            padding-left: 2rem;
            padding-bottom: 1.5rem;
        }

        .timeline-item:last-child {
            padding-bottom: 0;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: 0.5rem;
            top: 0;
            bottom: 0;
            width: 2px;
            background-color: #e2e8f0;
        }

        .timeline-item:last-child::before {
            display: none;
        }

        .timeline-dot {
            position: absolute;
            left: 0;
            top: 0.25rem;
            width: 1rem;
            height: 1rem;
            background-color: #1e40af;
            border-radius: 50%;
            border: 2px solid white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .timeline-content {
            background-color: #f8fafc;
            padding: 1rem;
            border-radius: 8px;
        }

        .timeline-title {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.25rem;
            font-size: 0.9rem;
        }

        .timeline-desc {
            font-size: 0.8rem;
            color: #64748b;
            margin-bottom: 0.5rem;
        }

        .timeline-time {
            font-size: 0.75rem;
            color: #64748b;
        }

        .quick-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
        }

        .quick-action-btn {
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            background: white;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
            text-align: center;
        }

        .quick-action-btn:hover {
            background-color: #f8fafc;
            border-color: #1e40af;
        }

        .quick-action-icon {
            width: 32px;
            height: 32px;
            background-color: #1e40af;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .quick-action-label {
            font-size: 0.8rem;
            font-weight: 500;
            color: #374151;
        }

        /* Related Messages */
        .related-message {
            padding: 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            margin-bottom: 0.75rem;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .related-message:hover {
            background-color: #f8fafc;
            border-color: #1e40af;
        }

        .related-message:last-child {
            margin-bottom: 0;
        }

        .related-subject {
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.25rem;
            font-size: 0.9rem;
        }

        .related-meta {
            font-size: 0.8rem;
            color: #64748b;
            display: flex;
            justify-content: between;
            align-items: center;
        }

        .print-button {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 56px;
            height: 56px;
            background-color: #1e40af;
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 8px 15px rgba(30, 64, 175, 0.3);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .print-button:hover {
            background-color: #1e3a8a;
            transform: translateY(-2px);
            box-shadow: 0 12px 20px rgba(30, 64, 175, 0.4);
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
            justify-content: between;
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
            min-height: 120px;
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
            .container {
                padding: 1rem;
            }

            .header {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }

            .header-actions {
                width: 100%;
                justify-content: flex-start;
            }

            .main-layout {
                grid-template-columns: 1fr;
            }

            .customer-info {
                flex-direction: column;
                text-align: center;
            }

            .message-meta {
                grid-template-columns: 1fr;
            }

            .quick-actions {
                grid-template-columns: 1fr;
            }

            .print-button {
                bottom: 1rem;
                right: 1rem;
            }
        }

        @media print {
            .header-actions,
            .sidebar-panel,
            .print-button,
            .action-button {
                display: none !important;
            }

            .main-layout {
                grid-template-columns: 1fr;
            }

            .container {
                max-width: none;
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="header-left">
                <h1>Message Details</h1>
                <p>View complete message information and history</p>
            </div>
            <div class="header-actions">
                <a href="javascript:history.back()" class="action-button secondary">
                    <i data-lucide="arrow-left" width="16" height="16"></i>
                    Back
                </a>
                <button class="action-button primary" onclick="openResponseModal()">
                    <i data-lucide="reply" width="16" height="16"></i>
                    Reply
                </button>
                <button class="action-button danger" onclick="archiveMessage()">
                    <i data-lucide="archive" width="16" height="16"></i>
                    Archive
                </button>
            </div>
        </div>

        <!-- Main Layout -->
        <div class="main-layout">
            <!-- Message Panel -->
            <div class="message-panel">
                <!-- Message Header -->
                <div class="message-header">
                    <div class="customer-info">
                        <div class="customer-avatar">JD</div>
                        <div class="customer-details">
                            <h2>Juan Dela Cruz</h2>
                            <div class="customer-contact">
                                <div class="contact-item">
                                    <i data-lucide="mail" width="16" height="16"></i>
                                    <span>juan.delacruz@email.com</span>
                                </div>
                                <div class="contact-item">
                                    <i data-lucide="phone" width="16" height="16"></i>
                                    <span>+63 917 123 4567</span>
                                </div>
                                <div class="contact-item">
                                    <i data-lucide="map-pin" width="16" height="16"></i>
                                    <span>Olongapo City, Philippines</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="message-meta">
                        <div class="meta-item">
                            <div class="meta-label">Message Type</div>
                            <div class="meta-value">
                                <div class="message-type-badge inquiry">Product Inquiry</div>
                            </div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Priority</div>
                            <div class="meta-value">
                                <div class="priority-badge normal">Normal</div>
                            </div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Received</div>
                            <div class="meta-value">August 20, 2025 - 2:15 PM</div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-label">Status</div>
                            <div class="meta-value">Active</div>
                        </div>
                    </div>
                </div>

                <!-- Message Content -->
                <div class="message-content">
                    <div class="content-section">
                        <div class="section-title">
                            <i data-lucide="message-square" width="20" height="20"></i>
                            Subject: Product Availability Inquiry
                        </div>
                        <div class="message-text">Hi M & E Team,

I'm looking for bulk ballpoint pens for our office. We need at least 200 pieces (around 16-17 packs of 12). Do you have this quantity available? Also, would there be any discount for bulk orders?

We're located in Olongapo City, so delivery should be within your service area. Please let me know the availability and total cost including delivery.

Thank you!
Juan Dela Cruz</div>
                    </div>

                    <div class="content-section">
                        <div class="section-title">
                            <i data-lucide="paperclip" width="20" height="20"></i>
                            Attachments (2)
                        </div>
                        <div class="attachments">
                            <div class="attachment-item" onclick="downloadAttachment('company-logo.png')">
                                <div class="attachment-icon">
                                    <i data-lucide="image" width="20" height="20"></i>
                                </div>
                                <div class="attachment-info">
                                    <div class="attachment-name">company-logo.png</div>
                                    <div class="attachment-size">245 KB</div>
                                </div>
                                <i data-lucide="download" width="16" height="16" style="color: #64748b;"></i>
                            </div>
                            <div class="attachment-item" onclick="downloadAttachment('office-layout.pdf')">
                                <div class="attachment-icon">
                                    <i data-lucide="file-text" width="20" height="20"></i>
                                </div>
                                <div class="attachment-info">
                                    <div class="attachment-name">office-layout.pdf</div>
                                    <div class="attachment-size">1.2 MB</div>
                                </div>
                                <i data-lucide="download" width="16" height="16" style="color: #64748b;"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Response History -->
                <div class="response-history">
                    <div class="section-title">
                        <i data-lucide="clock" width="20" height="20"></i>
                        Response History
                    </div>

                    <div class="response-item">
                        <div class="response-header">
                            <div class="response-author">
                                <div class="author-avatar">AD</div>
                                <div class="author-info">
                                    <div class="author-name">Admin (M & E Team)</div>
                                    <div class="response-time">August 20, 2025 - 4:30 PM</div>
                                </div>
                            </div>
                            <div class="priority-badge normal">Response Sent</div>
                        </div>
                        <div class="response-text">Dear Juan,

Thank you for your inquiry about our ballpoint pens. Yes, we have the quantity you need available in stock. For bulk orders of 200+ pieces, we offer a 15% discount.

Here are the details:
- Regular price: ₱25 per pack (12 pieces)
- Bulk price: ₱21.25 per pack
- Total for 17 packs: ₱361.25
- Delivery to Olongapo City: ₱150

Would you like to proceed with this order?

Best regards,
M & E Team</div>
                    </div>

                    <div class="response-item">
                        <div class="response-header">
                            <div class="response-author">
                                <div class="author-avatar" style="background: linear-gradient(135deg, #1e40af, #3b82f6);">JD</div>
                                <div class="author-info">
                                    <div class="author-name">Juan Dela Cruz</div>
                                    <div class="response-time">August 20, 2025 - 6:15 PM</div>
                                </div>
                            </div>
                            <div class="priority-badge normal">Customer Reply</div>
                        </div>
                        <div class="response-text">Hi M & E Team,

Perfect! The pricing looks good. I'd like to proceed with the order of 17 packs of ballpoint pens.

Can you arrange delivery for this Friday? Also, do you accept bank transfer for payment?

Thanks!
Juan</div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="sidebar-panel">
                <!-- Message Info -->
                <div class="info-card">
                    <div class="card-header">
                        <div class="card-title">Message Information</div>
                    </div>
                    <div class="card-content">
                        <ul class="info-list">
                            <li class="info-item">
                                <span class="info-label">Message ID</span>
                                <span class="info-value">#MSG-001</span>
                            </li>
                            <li class="info-item">
                                <span class="info-label">Category</span>
                                <span class="info-value">Product Inquiry</span>
                            </li>
                            <li class="info-item">
                                <span class="info-label">Source</span>
                                <span class="info-value">Contact Form</span>
                            </li>
                            <li class="info-item">
                                <span class="info-label">Assigned To</span>
                                <span class="info-value">Admin Team</span>
                            </li>
                            <li class="info-item">
                                <span class="info-label">Tags</span>
                                <span class="info-value">Bulk Order, Pens</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="info-card">
                    <div class="card-header">
                        <div class="card-title">Quick Actions</div>
                    </div>
                    <div class="card-content">
                        <div class="quick-actions">
                            <button class="quick-action-btn" onclick="markAsResolved()">
                                <div class="quick-action-icon">
                                    <i data-lucide="check" width="16" height="16"></i>
                                </div>
                                <div class="quick-action-label">Mark Resolved</div>
                            </button>
                            <button class="quick-action-btn" onclick="escalateMessage()">
                                <div class="quick-action-icon">
                                    <i data-lucide="trending-up" width="16" height="16"></i>
                                </div>
                                <div class="quick-action-label">Escalate</div>
                            </button>
                            <button class="quick-action-btn" onclick="createOrder()">
                                <div class="quick-action-icon">
                                    <i data-lucide="shopping-cart" width="16" height="16"></i>
                                </div>
                                <div class="quick-action-label">Create Order</div>
                            </button>
                            <button class="quick-action-btn" onclick="scheduleFollowUp()">
                                <div class="quick-action-icon">
                                    <i data-lucide="calendar" width="16" height="16"></i>
                                </div>
                                <div class="quick-action-label">Follow-up</div>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Activity Timeline -->
                <div class="info-card">
                    <div class="card-header">
                        <div class="card-title">Activity Timeline</div>
                    </div>
                    <div class="card-content">
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-dot"></div>
                                <div class="timeline-content">
                                    <div class="timeline-title">Customer Replied</div>
                                    <div class="timeline-desc">Juan confirmed order details</div>
                                    <div class="timeline-time">August 20, 2025 - 6:15 PM</div>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-dot"></div>
                                <div class="timeline-content">
                                    <div class="timeline-title">Response Sent</div>
                                    <div class="timeline-desc">Pricing and availability provided</div>
                                    <div class="timeline-time">August 20, 2025 - 4:30 PM</div>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-dot"></div>
                                <div class="timeline-content">
                                    <div class="timeline-title">Message Received</div>
                                    <div class="timeline-desc">Initial inquiry about ballpoint pens</div>
                                    <div class="timeline-time">August 20, 2025 - 2:15 PM</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Related Messages -->
                <div class="info-card">
                    <div class="card-header">
                        <div class="card-title">Related Messages</div>
                    </div>
                    <div class="card-content">
                        <div class="related-message" onclick="viewRelatedMessage(2)">
                            <div class="related-subject">Previous Order - Notebooks</div>
                            <div class="related-meta">
                                <span>Juan Dela Cruz</span>
                                <span>Aug 10, 2025</span>
                            </div>
                        </div>
                        <div class="related-message" onclick="viewRelatedMessage(3)">
                            <div class="related-subject">Delivery Inquiry</div>
                            <div class="related-meta">
                                <span>Juan Dela Cruz</span>
                                <span>Jul 25, 2025</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Button -->
    <button class="print-button" onclick="window.print()" title="Print Message">
        <i data-lucide="printer" width="24" height="24"></i>
    </button>

    <!-- Response Modal -->
    <div class="modal-overlay" id="responseModal">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title">Reply to Message</h3>
                <button class="close-btn" onclick="closeModal('responseModal')">&times;</button>
            </div>
            <form onsubmit="sendResponse(event)">
                <div class="form-group">
                    <label class="form-label">To:</label>
                    <div class="form-input" style="background: #f8fafc; cursor: not-allowed;">
                        Juan Dela Cruz (juan.delacruz@email.com)
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Subject:</label>
                    <input type="text" class="form-input" value="RE: Product Availability Inquiry" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Response:</label>
                    <textarea class="form-textarea" name="response" placeholder="Type your response here..." required></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Priority:</label>
                    <select class="form-select" name="priority">
                        <option value="normal">Normal</option>
                        <option value="high">High</option>
                        <option value="urgent">Urgent</option>
                    </select>
                </div>
                <div class="modal-actions">
                    <button type="button" class="action-button secondary" onclick="closeModal('responseModal')">Cancel</button>
                    <button type="submit" class="action-button primary">Send Response</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Notification -->
    <div class="notification" id="notification"></div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Get URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        const messageId = urlParams.get('id');
        const isArchived = urlParams.get('archived');

        // Open response modal
        function openResponseModal() {
            document.getElementById('responseModal').classList.add('active');
        }

        // Close modal
        function closeModal(modalId) {
            document.getElementById(modalId).classList.remove('active');
        }

        // Send response
        function sendResponse(event) {
            event.preventDefault();
            const formData = new FormData(event.target);
            const response = formData.get('response');
            const priority = formData.get('priority');

            setTimeout(() => {
                showNotification('Response sent successfully!', 'success');
                closeModal('responseModal');

                // Add new response to history
                addResponseToHistory('Admin (M & E Team)', response, new Date().toLocaleString());
            }, 1000);
        }

        // Add response to history
        function addResponseToHistory(author, text, time) {
            const historyContainer = document.querySelector('.response-history');
            const newResponse = document.createElement('div');
            newResponse.className = 'response-item';
            newResponse.innerHTML = `
                <div class="response-header">
                    <div class="response-author">
                        <div class="author-avatar">AD</div>
                        <div class="author-info">
                            <div class="author-name">${author}</div>
                            <div class="response-time">${time}</div>
                        </div>
                    </div>
                    <div class="priority-badge normal">Response Sent</div>
                </div>
                <div class="response-text">${text}</div>
            `;
            historyContainer.appendChild(newResponse);
        }

        // Quick actions
        function markAsResolved() {
            if (confirm('Are you sure you want to mark this message as resolved?')) {
                showNotification('Message marked as resolved', 'success');
                setTimeout(() => {
                    window.location.href = 'respond-request.php?id=' + messageId + '&action=resolved';
                }, 1500);
            }
        }

        function escalateMessage() {
            showNotification('Message escalated to supervisor', 'success');
        }

        function createOrder() {
            window.open('../orders/create.php?customer=' + encodeURIComponent('Juan Dela Cruz') + '&email=' + encodeURIComponent('juan.delacruz@email.com'), '_blank');
        }

        function scheduleFollowUp() {
            showNotification('Follow-up scheduled', 'success');
        }

        function archiveMessage() {
            if (confirm('Are you sure you want to archive this message?')) {
                showNotification('Message archived successfully', 'success');
                setTimeout(() => {
                    window.location.href = 'archive-request.php';
                }, 1500);
            }
        }

        // Download attachment
        function downloadAttachment(filename) {
            showNotification('Downloading ' + filename + '...', 'success');
            // Simulate download
        }

        // View related message
        function viewRelatedMessage(id) {
            window.open('view-request.php?id=' + id, '_blank');
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

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            // Update page title based on archived status
            if (isArchived === 'true') {
                document.title = 'Archived Message Details - M & E Dashboard';
                document.querySelector('.header h1').textContent = 'Archived Message Details';

                // Add archived badge to header
                const headerLeft = document.querySelector('.header-left');
                const archivedBadge = document.createElement('div');
                archivedBadge.style.cssText = 'padding: 0.5rem 1rem; background: #fef3c7; color: #92400e; border-radius: 6px; font-size: 0.85rem; font-weight: 500; margin-top: 0.5rem; display: inline-block;';
                archivedBadge.textContent = 'Archived Message';
                headerLeft.appendChild(archivedBadge);
            }
        });
    </script>
</body>
</html>
