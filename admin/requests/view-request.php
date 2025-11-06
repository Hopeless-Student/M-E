<?php
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

<div class="view-details-container" data-message-id="" data-is-archived="false">
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
                    <div class="customer-avatar" id="customerAvatar">...</div>
                    <div class="customer-details">
                        <h2 id="customerName">Loading...</h2>
                        <div class="customer-contact">
                            <div class="contact-item">
                                <i data-lucide="mail" width="16" height="16"></i>
                                <span id="customerEmail">Loading...</span>
                            </div>
                            <div class="contact-item">
                                <i data-lucide="phone" width="16" height="16"></i>
                                <span id="customerPhone">Loading...</span>
                            </div>
                            <div class="contact-item">
                                <i data-lucide="map-pin" width="16" height="16"></i>
                                <span id="customerLocation">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="message-meta">
                    <div class="meta-item">
                        <div class="meta-label">Message Type</div>
                        <div class="meta-value">
                            <div class="message-type-badge inquiry" id="messageTypeBadge">Loading...</div>
                        </div>
                    </div>
                    <div class="meta-item">
                        <div class="meta-label">Priority</div>
                        <div class="meta-value">
                            <div class="priority-badge normal" id="messagePriority">Loading...</div>
                        </div>
                    </div>
                    <div class="meta-item">
                        <div class="meta-label">Received</div>
                        <div class="meta-value" id="messageReceivedTime">Loading...</div>
                    </div>
                    <div class="meta-item">
                        <div class="meta-label">Status</div>
                        <div class="meta-value" id="messageStatus">Loading...</div>
                    </div>
                </div>
            </div>

            <!-- Message Content -->
            <div class="message-content">
                <div class="content-section">
                    <div class="section-title">
                        <i data-lucide="message-square" width="20" height="20"></i>
                        Subject: <span id="messageSubject">Loading...</span>
                    </div>
                    <div class="message-text" id="messageBody"><p>Loading message content...</p></div>
                </div>

                <div class="content-section">
                    <div class="section-title">
                        <i data-lucide="paperclip" width="20" height="20"></i>
                        Attachments (<span id="attachmentCount">0</span>)
                    </div>
                    <div class="attachments" id="attachmentsContainer">
                        <p style="color: #64748b;">Loading attachments...</p>
                    </div>
                </div>
            </div>

            <!-- Response History -->
            <div class="response-history" id="responseHistory">
                <div class="section-title">
                    <i data-lucide="clock" width="20" height="20"></i>
                    Response History
                </div>
                <p style="color: #64748b; padding: 1rem;">Loading response history...</p>
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
                            <span class="info-value" id="infoMessageId">Loading...</span>
                        </li>
                        <li class="info-item">
                            <span class="info-label">Category</span>
                            <span class="info-value" id="infoCategory">Loading...</span>
                        </li>
                        <li class="info-item">
                            <span class="info-label">Source</span>
                            <span class="info-value" id="infoSource">Loading...</span>
                        </li>
                        <li class="info-item">
                            <span class="info-label">Assigned To</span>
                            <span class="info-value" id="infoAssignedTo">Loading...</span>
                        </li>
                        <li class="info-item">
                            <span class="info-label">Tags</span>
                            <span class="info-value" id="infoTags">Loading...</span>
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
                        <p style="color: #64748b; padding: 1rem;">Loading activity...</p>
                    </div>
                </div>
            </div>

            <!-- Related Messages -->
            <div class="info-card">
                <div class="card-header">
                    <div class="card-title">Related Messages</div>
                </div>
                <div class="card-content" id="relatedMessagesContainer">
                    <p style="color: #64748b; padding: 1rem;">Loading related messages...</p>
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

    // Function to load message details from API
    async function loadMessageDetailsIntoModal(id, isArchived = false) {
        try {
            // Fetch data from API
            console.log('Fetching message details for ID:', id, 'Archived:', isArchived);
            const apiUrl = `../../api/admin/requests/get-single.php?id=${id}&archived=${isArchived}`;
            console.log('API URL:', apiUrl);
            
            const response = await fetch(apiUrl);
            console.log('Response status:', response.status);
            console.log('Response headers:', response.headers.get('content-type'));
            
            const responseText = await response.text();
            console.log('Response text (first 200 chars):', responseText.substring(0, 200));
            
            const data = JSON.parse(responseText);
            
            if (!data.success || !data.request) {
                document.querySelector('.view-details-container').innerHTML = '<p style="text-align: center; padding: 50px;">Message not found.</p>';
                return;
            }

            const message = data.request;
            const attachments = data.attachments || [];
            const history = data.history || [];

            // Update Customer Info
            document.getElementById('customerAvatar').textContent = message.avatar || 'NA';
            document.getElementById('customerName').textContent = message.customerName || 'N/A';
            document.getElementById('customerEmail').textContent = message.customerEmail || 'N/A';
            document.getElementById('customerPhone').textContent = message.customerContact || 'N/A';
            document.getElementById('customerLocation').textContent = 'N/A'; // Not in API response

            // Update Message Meta
            const messageTypeBadge = document.getElementById('messageTypeBadge');
            messageTypeBadge.textContent = (message.type || 'N/A').replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
            messageTypeBadge.className = `message-type-badge ${message.type || 'inquiry'}`;
            
            const messagePriorityElement = document.getElementById('messagePriority');
            messagePriorityElement.textContent = (message.priority || 'normal').replace(/\b\w/g, l => l.toUpperCase());
            messagePriorityElement.className = `priority-badge ${message.priority || 'normal'}`;
            
            document.getElementById('messageReceivedTime').textContent = formatDateTime(message.createdAt) || 'N/A';
            document.getElementById('messageStatus').textContent = (message.status || 'N/A').replace(/-/g, ' ').replace(/\b\w/g, l => l.toUpperCase());

            // Update Message Content
            document.getElementById('messageSubject').textContent = message.subject || 'No Subject';
            document.getElementById('messageBody').innerHTML = (message.message || 'No content available.').split('\n').map(line => line.trim() ? `<p>${escapeHtml(line)}</p>` : '<br>').join('');

            // Update Attachments
            const attachmentsContainer = document.getElementById('attachmentsContainer');
            attachmentsContainer.innerHTML = '';
            if (attachments && attachments.length > 0) {
                document.getElementById('attachmentCount').textContent = attachments.length;
                attachments.forEach(attachment => {
                    const attachmentItem = document.createElement('div');
                    attachmentItem.className = 'attachment-item';
                    attachmentItem.onclick = () => parent.appState.downloadAttachment(attachment.filename);
                    attachmentItem.innerHTML = `
                        <div class="attachment-icon">
                            <i data-lucide="${attachment.icon || 'file'}" width="20" height="20"></i>
                        </div>
                        <div class="attachment-info">
                            <div class="attachment-name">${escapeHtml(attachment.filename)}</div>
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
            if (history && history.length > 0) {
                history.forEach(item => {
                    const responseItem = document.createElement('div');
                    responseItem.className = 'response-item';
                    const avatarBg = item.actorType === 'customer' ? 'background: linear-gradient(135deg, #1e40af, #3b82f6);' : '';
                    responseItem.innerHTML = `
                        <div class="response-header">
                            <div class="response-author">
                                <div class="author-avatar" style="${avatarBg}">${escapeHtml(item.avatar)}</div>
                                <div class="author-info">
                                    <div class="author-name">${escapeHtml(item.actorName)}</div>
                                    <div class="response-time">${formatDateTime(item.createdAt)}</div>
                                </div>
                            </div>
                            <div class="priority-badge normal">${escapeHtml(item.actionType.replace(/_/g, ' '))}</div>
                        </div>
                        <div class="response-text">${escapeHtml(item.notes || 'No details')}</div>
                    `;
                    responseHistoryContainer.appendChild(responseItem);
                });
            } else {
                responseHistoryContainer.innerHTML += '<p style="color: #64748b; padding: 1rem;">No response history.</p>';
            }
            lucide.createIcons(); // Re-initialize icons

            // Update Message Information (Sidebar)
            document.getElementById('infoMessageId').textContent = `#${message.id}`;
            document.getElementById('infoCategory').textContent = (message.type || 'N/A').replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
            document.getElementById('infoSource').textContent = 'Contact Form';
            document.getElementById('infoAssignedTo').textContent = message.respondedByName || 'Unassigned';
            document.getElementById('infoTags').textContent = message.type || 'N/A';

            // Update Activity Timeline
            const activityTimelineContainer = document.getElementById('activityTimeline');
            activityTimelineContainer.innerHTML = '';
            if (history && history.length > 0) {
                // Show newest first in timeline
                history.forEach(item => {
                    const timelineItem = document.createElement('div');
                    timelineItem.className = 'timeline-item';
                    timelineItem.innerHTML = `
                        <div class="timeline-dot"></div>
                        <div class="timeline-content">
                            <div class="timeline-title">${escapeHtml(item.actionType.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase()))}</div>
                            <div class="timeline-desc">${escapeHtml(item.actorName)}</div>
                            <div class="timeline-time">${formatDateTime(item.createdAt)}</div>
                        </div>
                    `;
                    activityTimelineContainer.appendChild(timelineItem);
                });
            } else {
                activityTimelineContainer.innerHTML = '<p style="color: #64748b; padding: 1rem;">No activity yet.</p>';
            }
            lucide.createIcons(); // Re-initialize icons

            // Update Related Messages (not available from API, show placeholder)
            const relatedMessagesContainer = document.getElementById('relatedMessagesContainer');
            relatedMessagesContainer.innerHTML = '<p style="color: #64748b; padding: 1rem;">No related messages.</p>';

            // Handle archived status
            const headerLeft = document.querySelector('.header-left');
            let archivedBadge = headerLeft.querySelector('.archived-badge');

            if (isArchived || message.archived) {
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
                    replyBtn.innerHTML = '<i data-lucide="reply" width="16" height="16"></i> Cannot Reply';
                }
                if (archiveBtn) {
                    archiveBtn.disabled = true;
                    archiveBtn.innerHTML = '<i data-lucide="archive" width="16" height="16"></i> Already Archived';
                }
            } else {
                document.querySelector('.header h1').textContent = 'Message Details';
                const replyBtn = document.querySelector('.header-actions .action-button.primary');
                const archiveBtn = document.querySelector('.header-actions .action-button.danger');
                
                if (replyBtn) {
                    replyBtn.disabled = false;
                    replyBtn.innerHTML = '<i data-lucide="reply" width="16" height="16"></i> Reply';
                }
                if (archiveBtn) {
                    archiveBtn.disabled = false;
                    archiveBtn.innerHTML = '<i data-lucide="archive" width="16" height="16"></i> Archive';
                }
                if (archivedBadge) {
                    archivedBadge.remove();
                }
            }

            lucide.createIcons(); // Ensure icons are created after content load
        } catch (error) {
            console.error('Error loading message details:', error);
            document.querySelector('.view-details-container').innerHTML = '<p style="text-align: center; padding: 50px; color: #dc2626;">Error loading message details: ' + error.message + '</p>';
        }
    }

    // Helper functions
    function formatDateTime(dateString) {
        if (!dateString) return 'N/A';
        const date = new Date(dateString);
        return date.toLocaleString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Make function globally accessible so app.js can call it
    window.loadMessageDetailsIntoModal = loadMessageDetailsIntoModal;
</script>
