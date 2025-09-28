<?php
// This file is now designed to be loaded dynamically into a modal.
// It should not have full HTML structure (<html>, <head>, <body>)
// as it will be inserted into an existing document.
// Only the content relevant to the modal body should be here.
?>
<style>
    /* Specific styles for the view-request modal content */
    .view-details-container {
        display: flex;
        flex-direction: column;
        height: 100%; /* Ensure container takes full height of modal body */
        padding: 1.5rem; /* Add padding here instead of modal itself */
    }

    .view-details-container .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .view-details-container .header-left {
        display: flex;
        flex-direction: column;
    }

    .view-details-container .header-left h1 {
        font-size: 1.8rem;
        font-weight: 700;
        color: #1e40af;
        margin-bottom: 0.25rem;
    }

    .view-details-container .header-left p {
        font-size: 0.9rem;
        color: #64748b;
    }

    .view-details-container .header-actions {
        display: flex;
        gap: 0.75rem;
    }

    .view-details-container .action-button {
        padding: 0.6rem 1.2rem;
        border-radius: 8px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        transition: background-color 0.2s ease, border-color 0.2s ease;
        font-size: 0.9rem;
    }

    .view-details-container .action-button.primary {
        background-color: #1e40af;
        color: white;
        border: 1px solid #1e40af;
    }

    .view-details-container .action-button.primary:hover {
        background-color: #1e3a8a;
        border-color: #1e3a8a;
    }

    .view-details-container .action-button.secondary {
        background-color: #e2e8f0;
        color: #374151;
        border: 1px solid #e2e8f0;
    }

    .view-details-container .action-button.secondary:hover {
        background-color: #cbd5e1;
        border-color: #cbd5e1;
    }

    .view-details-container .action-button.danger {
        background-color: #fee2e2;
        color: #dc2626;
        border: 1px solid #fca5a5;
    }

    .view-details-container .action-button.danger:hover {
        background-color: #fecaca;
        border-color: #fca5a5;
    }

    .view-details-container .action-button:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .view-details-container .main-layout {
        display: flex;
        gap: 1.5rem;
        flex-grow: 1;
        min-height: 0; /* Allow flex item to shrink */
    }

    .view-details-container .message-panel {
        flex: 3;
        background-color: white;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        padding: 1.5rem;
        overflow-y: auto; /* Make message panel scrollable */
        display: flex;
        flex-direction: column;
    }

    .view-details-container .sidebar-panel {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        overflow-y: auto; /* Make sidebar panel scrollable */
    }

    .view-details-container .message-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e2e8f0;
        flex-wrap: wrap; /* Allow items to wrap on smaller screens */
    }

    .view-details-container .customer-info {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem; /* For wrapping */
    }

    .view-details-container .customer-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background-color: #1e40af;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        font-weight: 600;
        flex-shrink: 0;
    }

    .view-details-container .customer-details h2 {
        font-size: 1.2rem;
        font-weight: 600;
        color: #1e40af;
        margin-bottom: 0.25rem;
    }

    .view-details-container .customer-contact {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem 1.5rem;
        font-size: 0.85rem;
        color: #64748b;
    }

    .view-details-container .contact-item {
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .view-details-container .message-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-top: 0.5rem; /* For alignment when wrapped */
    }

    .view-details-container .meta-item {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
    }

    .view-details-container .meta-label {
        font-size: 0.75rem;
        color: #64748b;
        margin-bottom: 0.2rem;
    }

    .view-details-container .meta-value {
        font-size: 0.9rem;
        font-weight: 500;
        color: #374151;
    }

    .view-details-container .message-type-badge,
    .view-details-container .priority-badge {
        padding: 0.3rem 0.6rem;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 500;
        display: inline-block;
    }

    .view-details-container .message-type-badge.inquiry { background-color: #dbeafe; color: #1d4ed8; }
    .view-details-container .message-type-badge.custom-order { background-color: #fef3c7; color: #92400e; }
    .view-details-container .message-type-badge.complaint { background-color: #fee2e2; color: #dc2626; }
    .view-details-container .message-type-badge.feedback { background-color: #d1fae5; color: #065f46; }

    .view-details-container .priority-badge.normal { background-color: #e0e7ff; color: #3f51b5; }
    .view-details-container .priority-badge.high { background-color: #fff3e0; color: #ff9800; }
    .view-details-container .priority-badge.urgent { background-color: #ffe0b2; color: #f57c00; }


    .view-details-container .message-content {
        margin-bottom: 1.5rem;
    }

    .view-details-container .content-section {
        margin-bottom: 1.5rem;
    }

    .view-details-container .section-title {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 1.1rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 1rem;
    }

    .view-details-container .message-text p {
        margin-bottom: 0.5rem;
        line-height: 1.6;
        color: #475569;
    }

    .view-details-container .attachments {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .view-details-container .attachment-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background-color: #f8fafc;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .view-details-container .attachment-item:hover {
        background-color: #f0f4f8;
    }

    .view-details-container .attachment-icon {
        color: #1e40af;
    }

    .view-details-container .attachment-info {
        display: flex;
        flex-direction: column;
    }

    .view-details-container .attachment-name {
        font-size: 0.9rem;
        font-weight: 500;
        color: #374151;
    }

    .view-details-container .attachment-size {
        font-size: 0.75rem;
        color: #64748b;
    }

    .view-details-container .response-history {
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e2e8f0;
    }

    .view-details-container .response-item {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .view-details-container .response-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
    }

    .view-details-container .response-author {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .view-details-container .author-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background-color: #64748b;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .view-details-container .author-info {
        display: flex;
        flex-direction: column;
    }

    .view-details-container .author-name {
        font-weight: 600;
        color: #374151;
        font-size: 0.9rem;
    }

    .view-details-container .response-time {
        font-size: 0.75rem;
        color: #64748b;
    }

    .view-details-container .response-text {
        font-size: 0.9rem;
        color: #475569;
        line-height: 1.5;
    }

    .view-details-container .info-card {
        background-color: white;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        padding: 1.5rem;
    }

    .view-details-container .card-header {
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #e2e8f0;
    }

    .view-details-container .card-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #374151;
    }

    .view-details-container .info-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .view-details-container .info-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.75rem;
        font-size: 0.9rem;
    }

    .view-details-container .info-label {
        color: #64748b;
        font-weight: 500;
    }

    .view-details-container .info-value {
        color: #374151;
        text-align: right;
    }

    .view-details-container .quick-actions {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    .view-details-container .quick-action-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 1rem 0.5rem;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        background-color: #f8fafc;
        cursor: pointer;
        transition: background-color 0.2s ease, border-color 0.2s ease;
        text-align: center;
    }

    .view-details-container .quick-action-btn:hover {
        background-color: #f0f4f8;
        border-color: #cbd5e1;
    }

    .view-details-container .quick-action-icon {
        color: #1e40af;
        margin-bottom: 0.5rem;
    }

    .view-details-container .quick-action-label {
        font-size: 0.85rem;
        font-weight: 500;
        color: #374151;
    }

    .view-details-container .timeline {
        position: relative;
        padding-left: 1.5rem;
    }

    .view-details-container .timeline::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 2px;
        background-color: #e2e8f0;
    }

    .view-details-container .timeline-item {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .view-details-container .timeline-dot {
        position: absolute;
        left: -8px;
        top: 0;
        width: 16px;
        height: 16px;
        border-radius: 50%;
        background-color: #1e40af;
        border: 3px solid white;
        box-shadow: 0 0 0 2px #1e40af;
    }

    .view-details-container .timeline-content {
        margin-left: 0.5rem;
    }

    .view-details-container .timeline-title {
        font-weight: 600;
        color: #374151;
        font-size: 0.95rem;
        margin-bottom: 0.2rem;
    }

    .view-details-container .timeline-desc {
        font-size: 0.85rem;
        color: #64748b;
        margin-bottom: 0.2rem;
    }

    .view-details-container .timeline-time {
        font-size: 0.75rem;
        color: #94a3b8;
    }

    .view-details-container .related-message {
        padding: 0.75rem 0;
        border-bottom: 1px solid #f0f4f8;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    .view-details-container .related-message:last-child {
        border-bottom: none;
    }

    .view-details-container .related-message:hover {
        background-color: #f8fafc;
    }

    .view-details-container .related-subject {
        font-weight: 500;
        color: #1e40af;
        font-size: 0.9rem;
        margin-bottom: 0.2rem;
    }

    .view-details-container .related-meta {
        font-size: 0.8rem;
        color: #64748b;
    }

    .view-details-container .print-button {
        position: absolute;
        bottom: 20px;
        right: 20px;
        background-color: #1e40af;
        color: white;
        border: none;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        cursor: pointer;
        transition: background-color 0.2s ease;
        z-index: 10;
    }

    .view-details-container .print-button:hover {
        background-color: #1e3a8a;
    }

    .view-details-container .archived-badge {
        padding: 0.5rem 1rem;
        background: #fef3c7;
        color: #92400e;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 500;
        margin-top: 0.5rem;
        display: inline-block;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .view-details-container .main-layout {
            flex-direction: column;
        }
        .view-details-container .message-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .view-details-container .message-meta {
            margin-top: 1rem;
            width: 100%;
            justify-content: space-between;
        }
        .view-details-container .meta-item {
            align-items: flex-start;
        }
        .view-details-container .header-actions {
            flex-wrap: wrap;
            justify-content: flex-end;
        }
    }
</style>

<div class="view-details-container">
    <!-- Header -->
    <div class="header">
        <div class="header-left">
            <h1>Message Details</h1>
            <p>View complete message information and history</p>
        </div>
        <div class="header-actions">
            <button class="action-button secondary" onclick="appState.closeModal('viewDetailsModal')">
                <i data-lucide="arrow-left" width="16" height="16"></i>
                Back
            </button>
            <button class="action-button primary" onclick="appState.openResponseModalFromViewDetails()">
                <i data-lucide="reply" width="16" height="16"></i>
                Reply
            </button>
            <button class="action-button danger" onclick="appState.archiveMessageFromViewDetails()">
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
                    <div class="customer-avatar" id="customerAvatar">JD</div>
                    <div class="customer-details">
                        <h2 id="customerName">Juan Dela Cruz</h2>
                        <div class="customer-contact">
                            <div class="contact-item">
                                <i data-lucide="mail" width="16" height="16"></i>
                                <span id="customerEmail">juan.delacruz@email.com</span>
                            </div>
                            <div class="contact-item">
                                <i data-lucide="phone" width="16" height="16"></i>
                                <span id="customerPhone">+63 917 123 4567</span>
                            </div>
                            <div class="contact-item">
                                <i data-lucide="map-pin" width="16" height="16"></i>
                                <span id="customerLocation">Olongapo City, Philippines</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="message-meta">
                    <div class="meta-item">
                        <div class="meta-label">Message Type</div>
                        <div class="meta-value">
                            <div class="message-type-badge inquiry" id="messageTypeBadge">Product Inquiry</div>
                        </div>
                    </div>
                    <div class="meta-item">
                        <div class="meta-label">Priority</div>
                        <div class="meta-value">
                            <div class="priority-badge normal" id="messagePriority">Normal</div>
                        </div>
                    </div>
                    <div class="meta-item">
                        <div class="meta-label">Received</div>
                        <div class="meta-value" id="messageReceivedTime">August 20, 2025 - 2:15 PM</div>
                    </div>
                    <div class="meta-item">
                        <div class="meta-label">Status</div>
                        <div class="meta-value" id="messageStatus">Active</div>
                    </div>
                </div>
            </div>

            <!-- Message Content -->
            <div class="message-content">
                <div class="content-section">
                    <div class="section-title">
                        <i data-lucide="message-square" width="20" height="20"></i>
                        Subject: <span id="messageSubject">Product Availability Inquiry</span>
                    </div>
                    <div class="message-text" id="messageBody">Hi M & E Team,

I'm looking for bulk ballpoint pens for our office. We need at least 200 pieces (around 16-17 packs of 12). Do you have this quantity available? Also, would there be any discount for bulk orders?

We're located in Olongapo City, so delivery should be within your service area. Please let me know the availability and total cost including delivery.

Thank you!
Juan Dela Cruz</div>
                </div>

                <div class="content-section">
                    <div class="section-title">
                        <i data-lucide="paperclip" width="20" height="20"></i>
                        Attachments (<span id="attachmentCount">2</span>)
                    </div>
                    <div class="attachments" id="attachmentsContainer">
                        <div class="attachment-item" onclick="appState.downloadAttachment('company-logo.png')">
                            <div class="attachment-icon">
                                <i data-lucide="image" width="20" height="20"></i>
                            </div>
                            <div class="attachment-info">
                                <div class="attachment-name">company-logo.png</div>
                                <div class="attachment-size">245 KB</div>
                            </div>
                            <i data-lucide="download" width="16" height="16" style="color: #64748b;"></i>
                        </div>
                        <div class="attachment-item" onclick="appState.downloadAttachment('office-layout.pdf')">
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
            <div class="response-history" id="responseHistory">
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
                            <span class="info-value" id="infoMessageId">#MSG-001</span>
                        </li>
                        <li class="info-item">
                            <span class="info-label">Category</span>
                            <span class="info-value" id="infoCategory">Product Inquiry</span>
                        </li>
                        <li class="info-item">
                            <span class="info-label">Source</span>
                            <span class="info-value" id="infoSource">Contact Form</span>
                        </li>
                        <li class="info-item">
                            <span class="info-label">Assigned To</span>
                            <span class="info-value" id="infoAssignedTo">Admin Team</span>
                        </li>
                        <li class="info-item">
                            <span class="info-label">Tags</span>
                            <span class="info-value" id="infoTags">Bulk Order, Pens</span>
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
                        <button class="quick-action-btn" onclick="appState.markAsResolvedFromViewDetails()">
                            <div class="quick-action-icon">
                                <i data-lucide="check" width="16" height="16"></i>
                            </div>
                            <div class="quick-action-label">Mark Resolved</div>
                        </button>
                        <button class="quick-action-btn" onclick="appState.escalateMessageFromViewDetails()">
                            <div class="quick-action-icon">
                                <i data-lucide="trending-up" width="16" height="16"></i>
                            </div>
                            <div class="quick-action-label">Escalate</div>
                        </button>
                        <button class="quick-action-btn" onclick="appState.createOrderFromViewDetails()">
                            <div class="quick-action-icon">
                                <i data-lucide="shopping-cart" width="16" height="16"></i>
                            </div>
                            <div class="quick-action-label">Create Order</div>
                        </button>
                        <button class="quick-action-btn" onclick="appState.scheduleFollowUpFromViewDetails()">
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
                    <div class="timeline" id="activityTimeline">
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
                <div class="card-content" id="relatedMessagesContainer">
                    <div class="related-message" onclick="appState.viewRelatedMessage(2)">
                        <div class="related-subject">Previous Order - Notebooks</div>
                        <div class="related-meta">
                            <span>Juan Dela Cruz</span>
                            <span>Aug 10, 2025</span>
                        </div>
                    </div>
                    <div class="related-message" onclick="appState.viewRelatedMessage(3)">
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

<script>
    // Initialize Lucide icons
    lucide.createIcons();

    // Function to load message details into this modal
    function loadMessageDetailsIntoModal(id, isArchived = false) {
        // Access parent's appState.messageData safely
        const message = parent.appState.messageData[id];
        if (!message) {
            document.querySelector('.view-details-container').innerHTML = '<p style="text-align: center; padding: 50px;">Message not found.</p>';
            return;
        }

        // Update Customer Info
        document.getElementById('customerAvatar').textContent = message.avatar;
        document.getElementById('customerName').textContent = message.customer;
        document.getElementById('customerEmail').textContent = message.email || 'N/A';
        document.getElementById('customerPhone').textContent = message.phone || 'N/A';
        document.getElementById('customerLocation').textContent = message.location || 'N/A';

        // Update Message Meta
        const messageTypeBadge = document.getElementById('messageTypeBadge');
        messageTypeBadge.textContent = (message.type || 'N/A').replace('-', ' ').replace(/\b\w/g, l => l.toUpperCase());
        messageTypeBadge.className = `message-type-badge ${message.type || 'default'}`;
        const messagePriorityElement = document.getElementById('messagePriority');
        messagePriorityElement.textContent = (message.priority || 'normal').replace(/\b\w/g, l => l.toUpperCase());
        messagePriorityElement.className = `priority-badge ${message.priority || 'normal'}`;
        document.getElementById('messageReceivedTime').textContent = message.time || 'N/A';
        document.getElementById('messageStatus').textContent = message.status || 'N/A';

        // Update Message Content
        document.getElementById('messageSubject').textContent = message.subject || 'No Subject';
        document.getElementById('messageBody').innerHTML = (message.content || 'No content available.').split('\n').map(line => line.trim() ? `<p>${line}</p>` : '<br>').join('');

        // Update Attachments
        const attachmentsContainer = document.getElementById('attachmentsContainer');
        attachmentsContainer.innerHTML = '';
        if (message.attachments && message.attachments.length > 0) {
            document.getElementById('attachmentCount').textContent = message.attachments.length;
            message.attachments.forEach(attachment => {
                const attachmentItem = document.createElement('div');
                attachmentItem.className = 'attachment-item';
                // Ensure parent.appState.downloadAttachment is called
                attachmentItem.onclick = () => parent.appState.downloadAttachment(attachment.name);
                attachmentItem.innerHTML = `
                    <div class="attachment-icon">
                        <i data-lucide="${attachment.icon || 'file'}" width="20" height="20"></i>
                    </div>
                    <div class="attachment-info">
                        <div class="attachment-name">${attachment.name}</div>
                        <div class="attachment-size">${attachment.size}</div>
                    </div>
                    <i data-lucide="download" width="16" height="16" style="color: #64748b;"></i>
                `;
                attachmentsContainer.appendChild(attachmentItem);
            });
        } else {
            document.getElementById('attachmentCount').textContent = '0';
            attachmentsContainer.innerHTML = '<p style="color: #64748b;">No attachments.</p>';
        }
        lucide.createIcons(); // Re-initialize icons

        // Update Response History
        const responseHistoryContainer = document.getElementById('responseHistory');
        responseHistoryContainer.innerHTML = `
            <div class="section-title">
                <i data-lucide="clock" width="20" height="20"></i>
                Response History
            </div>
        `;
        if (message.history && message.history.length > 0) {
            message.history.forEach(item => {
                const responseItem = document.createElement('div');
                responseItem.className = 'response-item';
                responseItem.innerHTML = `
                    <div class="response-header">
                        <div class="response-author">
                            <div class="author-avatar" style="${item.avatarBg || ''}">${item.avatar}</div>
                            <div class="author-info">
                                <div class="author-name">${item.author}</div>
                                <div class="response-time">${item.time}</div>
                            </div>
                        </div>
                        <div class="priority-badge normal">${item.type}</div>
                    </div>
                    <div class="response-text">${item.text}</div>
                `;
                responseHistoryContainer.appendChild(responseItem);
            });
        } else {
            responseHistoryContainer.innerHTML += '<p style="color: #64748b; padding: 1rem;">No response history.</p>';
        }
        lucide.createIcons(); // Re-initialize icons

        // Update Message Information (Sidebar)
        document.getElementById('infoMessageId').textContent = `#MSG-${String(id).padStart(3, '0')}`;
        document.getElementById('infoCategory').textContent = message.category || 'N/A';
        document.getElementById('infoSource').textContent = message.source || 'N/A';
        document.getElementById('infoAssignedTo').textContent = message.assignedTo || 'N/A';
        document.getElementById('infoTags').textContent = message.tags || 'N/A';

        // Update Activity Timeline
        const activityTimelineContainer = document.getElementById('activityTimeline');
        activityTimelineContainer.innerHTML = '';
        if (message.history && message.history.length > 0) {
            // Reverse history to show newest first in timeline
            const reversedHistory = [...message.history].reverse();
            reversedHistory.forEach(item => {
                const timelineItem = document.createElement('div');
                timelineItem.className = 'timeline-item';
                timelineItem.innerHTML = `
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <div class="timeline-title">${item.type}</div>
                        <div class="timeline-desc">${item.text.split('\n')[0]}</div> <!-- Use first line as description -->
                        <div class="timeline-time">${item.time}</div>
                    </div>
                `;
                activityTimelineContainer.appendChild(timelineItem);
            });
        } else {
            activityTimelineContainer.innerHTML = '<p style="color: #64748b; padding: 1rem;">No activity yet.</p>';
        }
        lucide.createIcons(); // Re-initialize icons

        // Update Related Messages
        const relatedMessagesContainer = document.getElementById('relatedMessagesContainer');
        relatedMessagesContainer.innerHTML = '';
        if (message.related && message.related.length > 0) {
            message.related.forEach(relatedMsg => {
                const relatedItem = document.createElement('div');
                relatedItem.className = 'related-message';
                // Ensure parent.appState.viewRelatedMessage is called
                relatedItem.onclick = () => parent.appState.viewRelatedMessage(relatedMsg.id);
                relatedItem.innerHTML = `
                    <div class="related-subject">${relatedMsg.subject}</div>
                    <div class="related-meta">
                        <span>${relatedMsg.customer}</span>
                        <span>${relatedMsg.date}</span>
                    </div>
                `;
                relatedMessagesContainer.appendChild(relatedItem);
            });
        } else {
            relatedMessagesContainer.innerHTML = '<p style="color: #64748b; padding: 1rem;">No related messages.</p>';
        }

        // Handle archived status
        const headerLeft = document.querySelector('.header-left');
        let archivedBadge = headerLeft.querySelector('.archived-badge');

        if (isArchived) {
            document.querySelector('.header h1').textContent = 'Archived Message Details';

            if (!archivedBadge) {
                archivedBadge = document.createElement('div');
                archivedBadge.className = 'archived-badge';
                headerLeft.appendChild(archivedBadge);
            }
            archivedBadge.textContent = 'Archived Message';

            // Disable reply/archive buttons for archived messages
            const replyBtn = document.querySelector('.header-actions .action-button.primary');
            const archiveBtn = document.querySelector('.header-actions .action-button.danger');


        if (replyBtn) {
            replyBtn.disabled = true;
            // Clear existing content and set text, then re-add icon
            replyBtn.innerHTML = ''; // Clear existing icon
            const iconReply = document.createElement('i');
            iconReply.setAttribute('data-lucide', 'reply');
            iconReply.setAttribute('width', '16');
            iconReply.setAttribute('height', '16');
            replyBtn.appendChild(iconReply);
            replyBtn.appendChild(document.createTextNode(' Cannot Reply'));
        }
        if (archiveBtn) {
            archiveBtn.disabled = true;
            // Clear existing content and set text, then re-add icon
            archiveBtn.innerHTML = ''; // Clear existing icon
            const iconArchive = document.createElement('i');
            iconArchive.setAttribute('data-lucide', 'archive');
            iconArchive.setAttribute('width', '16');
            iconArchive.setAttribute('height', '16');
            archiveBtn.appendChild(iconArchive);
            archiveBtn.appendChild(document.createTextNode(' Already Archived'));
        }

        lucide.createIcons(); // Re-initialize icons after changing innerHTML

        } else {
            document.querySelector('.header h1').textContent = 'Message Details';
            // Ensure buttons are enabled and badge is removed if not archived
            const replyBtn = document.querySelector('.header-actions .action-button.primary');
            const archiveBtn = document.querySelector('.header-actions .action-button.danger');
            if (replyBtn) {
              replyBtn.disabled = false;
              replyBtn.innerHTML = ''; // Clear existing icon
              const iconReply = document.createElement('i');
              iconReply.setAttribute('data-lucide', 'reply');
              iconReply.setAttribute('width', '16');
              iconReply.setAttribute('height', '16');
              replyBtn.appendChild(iconReply);
              replyBtn.appendChild(document.createTextNode(' Reply'));
          }
          if (archiveBtn) {
              archiveBtn.disabled = false;
              archiveBtn.innerHTML = ''; // Clear existing icon
              const iconArchive = document.createElement('i');
              iconArchive.setAttribute('data-lucide', 'archive');
              iconArchive.setAttribute('width', '16');
              iconArchive.setAttribute('height', '16');
              archiveBtn.appendChild(iconArchive);
              archiveBtn.appendChild(document.createTextNode(' Archive'));
          }
          // Add this line after the above changes:
          lucide.createIcons(); // Re-initialize icons after changing innerHTML
            if (archivedBadge) {
                archivedBadge.remove();
            }
        }

        lucide.createIcons(); // Ensure icons are created after content load
    }

    // Initialize page when loaded into the modal
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const messageId = urlParams.get('id');
        const isArchived = urlParams.get('archived') === 'true';

        if (messageId) {
            // Call the local function to populate the modal content
            // Access parent.appState to get messageData
            if (parent.appState && parent.appState.messageData) {
                loadMessageDetailsIntoModal(messageId, isArchived);
            } else {
                document.querySelector('.view-details-container').innerHTML = '<p style="text-align: center; padding: 50px;">Application state not available. Cannot load message details.</p>';
            }
        } else {
            document.querySelector('.view-details-container').innerHTML = '<p style="text-align: center; padding: 50px;">No message ID provided.</p>';
        }
    });
</script>
