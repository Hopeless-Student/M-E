/**
 * Customer Request Management System - Main Application Logic
 * This file contains all the frontend logic for the request management system
 */

// Global application state
const appState = {
    // Data storage
    currentMessageId: null,
    currentFilter: 'all',
    currentPage: 1,
    pageSize: 50,
    messages: [],
    selectedArchiveMessages: [],
    deleteTarget: null,
    targetReplyTextarea: null,
    currentMessageIdToArchive: null,
    templates: [],
    debounceTimer: null,

    // ============ INITIALIZATION ============

    async init() {
        await this.loadStats();
        await this.loadMessages();
        await this.loadTemplates();
        this.setupEventListeners();
        this.startAutoRefresh();
    },

    setupEventListeners() {
        // Search with debounce
        const searchInput = document.getElementById('mainSearchInput');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                clearTimeout(this.debounceTimer);
                this.debounceTimer = setTimeout(() => {
                    this.searchMessages(e.target.value);
                }, 500);
            });
        }

        // Filter tabs
        document.querySelectorAll('.filter-tabs .tab-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const filter = btn.dataset.filter;
                this.filterMessages(filter);
            });
        });

        // Close modals on outside click
        document.querySelectorAll('.app-modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', (e) => {
                if (e.target === overlay) {
                    this.closeModal(overlay.id);
                }
            });
        });
    },

    startAutoRefresh() {
        // Refresh stats and message list every 30 seconds
        setInterval(async () => {
            await this.loadStats();
            if (!document.querySelector('.app-modal-overlay.active')) {
                await this.loadMessages();
            }
        }, 30000);
    },

    // ============ DATA LOADING ============

    async loadStats() {
        try {
            const result = await API.getStats();
            if (result.success) {
                document.getElementById('totalMessages').textContent = result.stats.totalMessages;
                document.getElementById('unreadMessages').textContent = result.stats.unreadMessages;
                document.getElementById('customOrders').textContent = result.stats.customOrders;
                document.getElementById('avgResponseTime').textContent = result.stats.avgResponseTime;
                document.getElementById('unreadBadge').textContent = result.stats.unreadMessages;
            }
        } catch (error) {
            console.error('Failed to load stats:', error);
        }
    },

    async loadMessages(params = {}) {
        try {
            const defaultParams = {
                page: this.currentPage,
                pageSize: this.pageSize
            };

            const result = await API.getRequests({ ...defaultParams, ...params });

            if (result.items) {
                this.messages = result.items;
                this.renderMessages();
            }
        } catch (error) {
            console.error('Failed to load messages:', error);
            this.showNotification('Failed to load messages', 'error');
        }
    },

    async loadTemplates() {
        try {
            const result = await API.getTemplates();
            if (result.success) {
                this.templates = result.templates;
                this.populateTemplateSelect();
            }
        } catch (error) {
            console.error('Failed to load templates:', error);
        }
    },

    populateTemplateSelect() {
        const select = document.getElementById('templateSelect');
        if (!select) return;

        select.innerHTML = '<option value="">Select template</option>';

        this.templates.forEach(template => {
            const option = document.createElement('option');
            option.value = template.id;
            option.textContent = template.name;
            select.appendChild(option);
        });

        select.addEventListener('change', async (e) => {
            if (e.target.value) {
                await this.loadTemplateIntoForm(parseInt(e.target.value));
            }
        });
    },

    async loadTemplateIntoForm(templateId) {
        try {
            const currentMessage = this.messages.find(m => m.id === this.currentMessageId);
            const variables = {
                customer_name: currentMessage?.customerName || 'Customer',
                subject: currentMessage?.subject || '',
                request_id: this.currentMessageId || '',
                company_name: 'M & E Team'
            };

            const result = await API.useTemplate(templateId, variables);
            if (result.success) {
                document.getElementById('responseSubject').value = result.template.subject;
                document.getElementById('responseText').value = result.template.content;
            }
        } catch (error) {
            this.showNotification('Failed to load template', 'error');
        }
    },

    // ============ RENDERING ============

    renderMessages() {
        const container = document.getElementById('messagesContainer');

        if (this.messages.length === 0) {
            container.innerHTML = '<p style="text-align: center; padding: 2rem; color: #64748b;">No messages found</p>';
            return;
        }

        container.innerHTML = '';

        this.messages.forEach(message => {
            const messageEl = this.createMessageElement(message);
            container.appendChild(messageEl);
        });

        lucide.createIcons();
    },

    createMessageElement(message) {
        const div = document.createElement('div');
        div.className = `message-item ${message.status === 'pending' ? 'unread' : ''}`;
        div.dataset.id = message.id;
        div.dataset.type = message.type;

        const timeAgo = this.formatTimeAgo(message.createdAt);
        const preview = message.message.substring(0, 100) + (message.message.length > 100 ? '...' : '');

        div.innerHTML = `
            <div class="message-header">
                <span class="message-from">${this.escapeHtml(message.customerName)}</span>
                <span class="message-time">${timeAgo}</span>
            </div>
            <div class="message-subject">${this.escapeHtml(message.subject)}</div>
            <div class="message-preview">${this.escapeHtml(preview)}</div>
            <div class="message-type ${message.type}">${this.formatType(message.type)}</div>
        `;

        div.addEventListener('click', () => {
            this.selectMessage(message.id);
        });

        return div;
    },

    async selectMessage(id) {
        // Update UI
        document.querySelectorAll('.message-item').forEach(i => i.classList.remove('active'));
        const selectedEl = document.querySelector(`.message-item[data-id="${id}"]`);
        if (selectedEl) {
            selectedEl.classList.add('active');
            selectedEl.classList.remove('unread');
        }

        this.currentMessageId = id;

        // Load full details
        await this.loadMessageDetail(id);

        // Update stats
        await this.loadStats();
    },

    async loadMessageDetail(id) {
        try {
            this.showLoading();
            const result = await API.getRequest(id, false);

            if (result.success) {
                this.renderMessageDetail(result.request);
            }
        } catch (error) {
            console.error('Failed to load message detail:', error);
            this.showNotification('Failed to load message details', 'error');
        } finally {
            this.hideLoading();
        }
    },

    renderMessageDetail(request) {
        const detailPanel = document.getElementById('messageDetail');
        const avatar = this.getInitials(request.customerName);

        detailPanel.innerHTML = `
            <div class="message-detail-header">
                <div class="detail-customer">
                    <div class="customer-avatar">${avatar}</div>
                    <div class="customer-details">
                        <h3>${this.escapeHtml(request.customerName)}</h3>
                        <p>${this.escapeHtml(request.customerEmail)} • ${this.escapeHtml(request.customerContact || 'No contact')}</p>
                    </div>
                </div>
                <div class="message-actions">
                    <button class="icon-btn" onclick="appState.viewRequest()" title="View Details">
                        <i data-lucide="eye" width="16" height="16"></i>
                    </button>
                    <button class="icon-btn" onclick="appState.openResponseModal()" title="Quick Response">
                        <i data-lucide="reply" width="16" height="16"></i>
                    </button>
                    <button class="icon-btn" onclick="appState.openSingleArchiveModal(${request.id})" title="Archive">
                        <i data-lucide="archive" width="16" height="16"></i>
                    </button>
                </div>
                <div class="message-meta">
                    <div class="message-type ${request.type}">${this.formatType(request.type)}</div>
                    <span class="message-time">${this.formatDateTime(request.createdAt)}</span>
                </div>
            </div>

            <div class="message-content">
                <h4 style="color: #1e40af; margin-bottom: 1rem;">${this.escapeHtml(request.subject)}</h4>
                <div class="message-text">
                    ${this.formatMessageText(request.message)}
                </div>
            </div>

            <div class="reply-section">
                <form class="reply-form" onsubmit="appState.sendReply(event)">
                    <textarea class="reply-textarea" placeholder="Type your reply here..." required></textarea>
                    <div class="reply-actions">
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
        `;

        lucide.createIcons();
    },

    // ============ SEARCH & FILTER ============

    async searchMessages(query) {
        await this.loadMessages({ q: query });
    },

    async filterMessages(filter) {
        this.currentFilter = filter;

        // Update UI
        document.querySelectorAll('.filter-tabs .tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelector(`.filter-tabs .tab-btn[data-filter="${filter}"]`).classList.add('active');

        // Load filtered messages
        const params = {};
        if (filter === 'pending') {
            params.status = 'pending';
        } else if (filter === 'custom_order') {
            params.type = 'custom_order';
        }

        await this.loadMessages(params);
    },

    // ============ RESPONSE HANDLING ============

    openResponseModal() {
        if (!this.currentMessageId) {
            this.showNotification('Please select a message first', 'error');
            return;
        }

        const currentMessage = this.messages.find(m => m.id === this.currentMessageId);
        if (currentMessage) {
            document.getElementById('responseSubject').value = 'RE: ' + currentMessage.subject;
        }

        document.getElementById('responseModal').classList.add('active');
    },

    async handleQuickResponse(event) {
        event.preventDefault();

        if (!this.currentMessageId) {
            this.showNotification('No message selected', 'error');
            return;
        }

        const formData = new FormData(event.target);
        const response = formData.get('response');
        const subject = formData.get('subject');
        const status = formData.get('status');
        const priority = formData.get('priority');

        try {
            this.showLoading();

            const result = await API.sendResponse(
                this.currentMessageId,
                response,
                subject,
                status,
                priority,
                currentMessage.template_id
            );

            if (result.success) {
                this.showNotification('Response sent successfully!', 'success');
                this.closeModal('responseModal');

                // Refresh messages and stats
                await this.loadMessages();
                await this.loadStats();
                await this.loadMessageDetail(this.currentMessageId);
            }
        } catch (error) {
            this.showNotification(error.message || 'Failed to send response', 'error');
        } finally {
            this.hideLoading();
        }
    },

    async sendReply(event) {
        event.preventDefault();

        const replyText = document.querySelector('.reply-textarea').value;
        const currentMessage = this.messages.find(m => m.id === this.currentMessageId);

        if (!replyText.trim() || !currentMessage) {
            this.showNotification('Please enter a reply message', 'error');
            return;
        }

        try {
            this.showLoading();

            const result = await API.sendResponse(
                this.currentMessageId,
                replyText,
                'RE: ' + currentMessage.subject,
                'in-progress',
                'normal'

            );

            if (result.success) {
                this.showNotification('Reply sent successfully!', 'success');
                document.querySelector('.reply-textarea').value = '';

                // Refresh
                await this.loadMessages();
                await this.loadStats();
                await this.loadMessageDetail(this.currentMessageId);
            }
        } catch (error) {
            this.showNotification(error.message || 'Failed to send reply', 'error');
        } finally {
            this.hideLoading();
        }
    },

    // ============ ARCHIVE HANDLING ============

    openSingleArchiveModal(messageId) {
        this.currentMessageIdToArchive = messageId || this.currentMessageId;

        if (!this.currentMessageIdToArchive) {
            this.showNotification('No message selected', 'error');
            return;
        }

        const modal = document.getElementById('singleArchiveModal');
        modal.querySelector('#archiveMessageIdDisplay').textContent = `#MSG-${String(this.currentMessageIdToArchive).padStart(3, '0')}`;
        modal.classList.add('active');
    },

    async handleSingleArchive(event) {
        event.preventDefault();

        const formData = new FormData(event.target);
        const reason = formData.get('archiveReason');
        const notes = formData.get('archiveNotes');

        if (!reason) {
            this.showNotification('Please select an archive reason', 'error');
            return;
        }

        try {
            this.showLoading();

            const result = await API.archiveRequest(this.currentMessageIdToArchive, reason, notes);

            if (result.success) {
                this.showNotification(result.message || 'Message archived successfully', 'success');
                this.closeModal('singleArchiveModal');

                // Clear detail panel if archived message was selected
                if (this.currentMessageId === this.currentMessageIdToArchive) {
                    document.getElementById('messageDetail').innerHTML = '<p style="text-align: center; padding: 3rem; color: #64748b;">Select a message to view details</p>';
                    this.currentMessageId = null;
                }

                // Refresh
                await this.loadMessages();
                await this.loadStats();
            }
        } catch (error) {
            this.showNotification(error.message || 'Failed to archive message', 'error');
        } finally {
            this.hideLoading();
            this.currentMessageIdToArchive = null;
        }
    },

    async openArchiveModal() {
        try {
            this.showLoading();

            const response = await fetch('archive-request.php');
            const html = await response.text();

            document.getElementById('archiveModalContent').innerHTML = html;
            document.getElementById('archiveModal').classList.add('active');

            lucide.createIcons();
            await this.initArchiveModalListeners();
            await this.loadArchivedMessages();
        } catch (error) {
            console.error('Failed to load archive modal:', error);
            this.showNotification('Failed to load archive page', 'error');
        } finally {
            this.hideLoading();
        }
    },

    async loadArchivedMessages(params = {}) {
        try {
            const result = await API.listArchived(params);

            if (result.success) {
                this.renderArchivedMessages(result.items);
                this.updateArchiveStats(result);
            }
        } catch (error) {
            console.error('Failed to load archived messages:', error);
        }
    },

    renderArchivedMessages(items) {
        const tbody = document.querySelector('#archiveModalContent #archiveTableBody');
        if (!tbody) return;

        if (items.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" style="text-align: center; padding: 2rem; color: #64748b;">No archived messages</td></tr>';
            return;
        }

        tbody.innerHTML = '';

        items.forEach(item => {
            const row = document.createElement('tr');
            const preview = item.message.substring(0, 50) + '...';

            row.innerHTML = `
                <td class="checkbox-cell">
                    <input type="checkbox" class="message-checkbox" data-id="${item.id}">
                </td>
                <td class="message-cell">
                    <div class="message-from">${this.escapeHtml(item.customerName)}</div>
                    <div class="message-subject">${this.escapeHtml(item.subject)}</div>
                    <div class="message-preview">${this.escapeHtml(preview)}</div>
                </td>
                <td>
                    <div class="message-type ${item.type}">${this.formatType(item.type)}</div>
                </td>
                <td class="archive-date">${this.formatDate(item.createdAt)}</td>
                <td class="archive-date">${this.formatDate(item.archivedAt)}</td>
                <td class="archive-date">${this.formatArchiveReason(item.archiveReason)}</td>
                <td class="action-cell">
                    <div class="action-buttons">
                        <button class="icon-btn" onclick="appState.archiveViewArchivedMessage(${item.id})" title="View">
                            <i data-lucide="eye" width="14" height="14"></i>
                        </button>
                        <button class="icon-btn" onclick="appState.archiveRestoreMessage(${item.id})" title="Restore">
                            <i data-lucide="rotate-ccw" width="14" height="14"></i>
                        </button>
                        <button class="icon-btn danger" onclick="appState.archiveDeleteMessage(${item.id})" title="Delete Permanently">
                            <i data-lucide="trash-2" width="14" height="14"></i>
                        </button>
                    </div>
                </td>
            `;

            tbody.appendChild(row);
        });

        lucide.createIcons();
    },

    updateArchiveStats(result) {
        const statsCards = document.querySelectorAll('#archiveModalContent .stat-value');
        if (statsCards.length >= 3) {
            statsCards[0].textContent = result.total || 0;
        }
    },

    async initArchiveModalListeners() {
        const modal = document.getElementById('archiveModalContent');

        // Filters
        modal.querySelectorAll('.app-form-select').forEach(select => {
            select.addEventListener('change', async () => {
                const params = {
                    dateFilter: modal.querySelector('#dateFilter')?.value || '',
                    type: modal.querySelector('#typeFilter')?.value || '',
                    reason: modal.querySelector('#reasonFilter')?.value || '',
                    sortBy: modal.querySelector('#sortFilter')?.value || 'date_desc'
                };
                await this.loadArchivedMessages(params);
            });
        });

        // Checkboxes
        modal.querySelectorAll('.message-checkbox').forEach(cb => {
            cb.addEventListener('change', () => this.archiveUpdateBulkActions());
        });

        const selectAll = modal.querySelector('#selectAll');
        if (selectAll) {
            selectAll.addEventListener('change', () => this.archiveToggleSelectAll());
        }
    },

    archiveToggleSelectAll() {
        const modal = document.getElementById('archiveModalContent');
        const selectAll = modal.querySelector('#selectAll');
        const checkboxes = modal.querySelectorAll('.message-checkbox');

        checkboxes.forEach(cb => {
            cb.checked = selectAll.checked;
        });

        this.archiveUpdateBulkActions();
    },

    archiveUpdateBulkActions() {
        const modal = document.getElementById('archiveModalContent');
        const checkboxes = modal.querySelectorAll('.message-checkbox:checked');
        const restoreBtn = modal.querySelector('#restoreBtn');
        const deleteBtn = modal.querySelector('#deleteBtn');

        this.selectedArchiveMessages = Array.from(checkboxes).map(cb => parseInt(cb.dataset.id));

        if (restoreBtn && deleteBtn) {
            restoreBtn.disabled = this.selectedArchiveMessages.length === 0;
            deleteBtn.disabled = this.selectedArchiveMessages.length === 0;
        }
    },

    async archiveViewArchivedMessage(id) {
        await this.viewRequest(id, true);
    },

    async archiveRestoreMessage(id) {
        if (!confirm('Are you sure you want to restore this message to the inbox?')) {
            return;
        }

        try {
            this.showLoading();
            const result = await API.restoreRequest(id);

            if (result.success) {
                this.showNotification('Message restored successfully', 'success');
                await this.loadArchivedMessages();
                await this.loadMessages();
                await this.loadStats();
            }
        } catch (error) {
            this.showNotification(error.message || 'Failed to restore message', 'error');
        } finally {
            this.hideLoading();
        }
    },

    async archiveDeleteMessage(id) {
        this.deleteTarget = [id];
        const modal = document.getElementById('archiveModalContent');
        const deleteModal = modal.querySelector('#deleteModal');
        if (deleteModal) {
            deleteModal.classList.add('active');
        }
    },

    async archiveBulkRestore() {
        if (this.selectedArchiveMessages.length === 0) return;

        const modal = document.getElementById('archiveModalContent');
        const restoreModal = modal.querySelector('#restoreModal');
        if (restoreModal) {
            restoreModal.classList.add('active');
        }
    },

    async archiveBulkDelete() {
        if (this.selectedArchiveMessages.length === 0) return;

        this.deleteTarget = this.selectedArchiveMessages.slice();
        const modal = document.getElementById('archiveModalContent');
        const deleteModal = modal.querySelector('#deleteModal');
        if (deleteModal) {
            deleteModal.classList.add('active');
        }
    },

    async archiveHandleBulkRestore(event) {
        event.preventDefault();

        try {
            this.showLoading();
            const result = await API.bulkRestoreRequests(this.selectedArchiveMessages);

            if (result.success) {
                this.showNotification(`${result.restored} message(s) restored`, 'success');
                this.closeModal('restoreModal');
                await this.loadArchivedMessages();
                await this.loadMessages();
                await this.loadStats();
                this.selectedArchiveMessages = [];
                this.archiveUpdateBulkActions();
            }
        } catch (error) {
            this.showNotification(error.message || 'Failed to restore messages', 'error');
        } finally {
            this.hideLoading();
        }
    },

    async archiveConfirmDelete() {
        try {
            this.showLoading();
            const result = await API.bulkDeleteArchived(this.deleteTarget);

            if (result.success) {
                this.showNotification(`${result.deleted} message(s) deleted permanently`, 'success');
                this.closeModal('deleteModal');
                await this.loadArchivedMessages();
                this.deleteTarget = null;
                this.selectedArchiveMessages = [];
                this.archiveUpdateBulkActions();
            }
        } catch (error) {
            this.showNotification(error.message || 'Failed to delete messages', 'error');
        } finally {
            this.hideLoading();
        }
    },

    // ============ TEMPLATES ============

    async openTemplatesModal() {
        this.targetReplyTextarea = null;
        await this.loadTemplatesModalContent();
    },

    async openTemplatesModalForReply() {
        this.targetReplyTextarea = document.querySelector('.reply-textarea');
        await this.loadTemplatesModalContent();
    },

    async loadTemplatesModalContent() {
        try {
            this.showLoading();

            const response = await fetch('respond-request.php');
            const html = await response.text();

            document.getElementById('templatesModalContent').innerHTML = html;
            document.getElementById('templatesModal').classList.add('active');

            lucide.createIcons();
            await this.initTemplatesModalListeners();
            await this.loadTemplatesInModal();
        } catch (error) {
            console.error('Failed to load templates modal:', error);
            this.showNotification('Failed to load templates page', 'error');
        } finally {
            this.hideLoading();
        }
    },

    async loadTemplatesInModal() {
        try {
            const result = await API.getTemplates();

            if (result.success) {
                this.renderTemplatesInModal(result.templates);
                this.updateTemplateStats(result.stats, result.categoryCounts);
            }
        } catch (error) {
            console.error('Failed to load templates:', error);
        }
    },

    renderTemplatesInModal(templates) {
        const grid = document.querySelector('#templatesModalContent #templateGrid');
        if (!grid) return;

        if (templates.length === 0) {
            grid.innerHTML = '<p style="text-align: center; padding: 2rem; color: #64748b;">No templates found</p>';
            return;
        }

        grid.innerHTML = '';

        templates.forEach(template => {
            const card = document.createElement('div');
            card.className = 'template-card';
            card.dataset.category = template.category;
            card.dataset.templateId = template.id;

            const preview = template.content.substring(0, 150) + '...';
            const updatedDate = this.formatDate(template.updatedAt);

            card.innerHTML = `
                <div class="template-header">
                    <div class="template-title">
                        ${this.escapeHtml(template.name)}
                        ${template.usageCount > 20 ? '<span class="usage-badge">Popular</span>' : ''}
                    </div>
                    <div class="template-meta">
                        <span>Used ${template.usageCount} times</span>
                        <span>Updated: ${updatedDate}</span>
                    </div>
                </div>
                <div class="template-content">
                    <div class="template-preview">${this.escapeHtml(preview)}</div>
                    <div class="template-actions">
                        <button class="template-btn primary" onclick="appState.templatesUseTemplate(${template.id})">
                            <i data-lucide="send" width="14" height="14"></i>
                            Use Template
                        </button>
                        <button class="template-btn" onclick="appState.templatesEditTemplate(${template.id})">
                            <i data-lucide="edit-2" width="14" height="14"></i>
                            Edit
                        </button>
                    </div>
                </div>
            `;

            grid.appendChild(card);
        });

        lucide.createIcons();
    },

    updateTemplateStats(stats, categoryCounts) {
        const modal = document.getElementById('templatesModalContent');
        const statValues = modal.querySelectorAll('.stat-value');

        if (statValues.length >= 3) {
            statValues[0].textContent = stats.total || 0;
            statValues[1].textContent = stats.mostUsed || 'N/A';
            statValues[2].textContent = stats.thisMonthUsage || 0;
        }

        // Update category counts
        modal.querySelectorAll('.category-count').forEach(countEl => {
            const link = countEl.closest('.category-link');
            const category = link?.dataset?.category;
            if (category && categoryCounts[category] !== undefined) {
                countEl.textContent = categoryCounts[category];
            }
        });
    },

    async initTemplatesModalListeners() {
        const modal = document.getElementById('templatesModalContent');

        // Search
        const searchInput = modal.querySelector('.search-input');
        if (searchInput) {
            searchInput.addEventListener('input', async (e) => {
                clearTimeout(this.debounceTimer);
                this.debounceTimer = setTimeout(async () => {
                    const result = await API.getTemplates('', e.target.value);
                    if (result.success) {
                        this.renderTemplatesInModal(result.templates);
                    }
                }, 500);
            });
        }

        // Category filtering
        modal.querySelectorAll('.category-link').forEach(link => {
            link.addEventListener('click', async (e) => {
                e.preventDefault();
                modal.querySelectorAll('.category-link').forEach(l => l.classList.remove('active'));
                link.classList.add('active');

                const category = link.dataset.category;
                const result = await API.getTemplates(category === 'all' ? '' : category);
                if (result.success) {
                    this.renderTemplatesInModal(result.templates);
                }
            });
        });
    },

    async templatesUseTemplate(templateId) {
        try {
            const currentMessage = this.messages.find(m => m.id === this.currentMessageId);
            const variables = {
                customer_name: currentMessage?.customerName || 'Customer',
                subject: currentMessage?.subject || '',
                request_id: this.currentMessageId || '',
                company_name: 'M & E Team'
            };

            const result = await API.useTemplate(templateId, variables);

            if (result.success) {
                if (this.targetReplyTextarea) {
                    this.targetReplyTextarea.value = result.template.content;
                    this.showNotification('Template applied to reply', 'info');
                    this.closeModal('templatesModal');
                    this.targetReplyTextarea = null;
                } else {
                    // Open use template modal
                    const modal = document.getElementById('templatesModalContent');
                    const useModal = modal.querySelector('#useTemplateModal');
                    if (useModal) {
                        useModal.querySelector('#templateSubject').value = result.template.subject;
                        useModal.querySelector('#templateMessage').value = result.template.content;
                        useModal.querySelector('input[name="recipient"]').value = currentMessage?.customerEmail || '';
                        useModal.classList.add('active');
                    }
                }
            }
        } catch (error) {
            this.showNotification(error.message || 'Failed to use template', 'error');
        }
    },

    async templatesEditTemplate(templateId) {
        try {
            const template = this.templates.find(t => t.id === templateId);

            const modal = document.getElementById('templatesModalContent');
            const editorModal = modal.querySelector('#templateModal');

            if (editorModal && template) {
                const form = editorModal.querySelector('#templateForm');
                form.elements.name.value = template.name;
                form.elements.category.value = template.category;
                form.elements.subject.value = template.subject;
                form.elements.content.value = template.content;
                form.elements.notes.value = template.notes || '';

                editorModal.querySelector('#modalTitle').textContent = 'Edit Template';
                editorModal.dataset.templateId = templateId;
                editorModal.classList.add('active');
            }
        } catch (error) {
            this.showNotification('Failed to load template for editing', 'error');
        }
    },

    async templatesCreateTemplate() {
        const modal = document.getElementById('templatesModalContent');
        const editorModal = modal.querySelector('#templateModal');

        if (editorModal) {
            const form = editorModal.querySelector('#templateForm');
            form.reset();
            editorModal.querySelector('#modalTitle').textContent = 'Create New Template';
            delete editorModal.dataset.templateId;
            editorModal.classList.add('active');
        }
    },

    templatesInsertVariable(variable) {
        const modal = document.getElementById('templatesModalContent');
        const textarea = modal.querySelector('#templateContent');
        if (!textarea) return;

        const cursorPos = textarea.selectionStart;
        const textBefore = textarea.value.substring(0, cursorPos);
        const textAfter = textarea.value.substring(cursorPos);

        textarea.value = textBefore + variable + textAfter;
        textarea.focus();
        textarea.setSelectionRange(cursorPos + variable.length, cursorPos + variable.length);
    },

    async templatesSaveTemplate(event) {
        event.preventDefault();

        const modal = document.getElementById('templatesModalContent');
        const editorModal = modal.querySelector('#templateModal');
        const templateId = editorModal?.dataset?.templateId;

        const formData = new FormData(event.target);
        const data = {
            name: formData.get('name'),
            category: formData.get('category'),
            subject: formData.get('subject'),
            content: formData.get('content'),
            notes: formData.get('notes')
        };

        try {
            this.showLoading();

            let result;
            if (templateId) {
                result = await API.updateTemplate(parseInt(templateId), data.name, data.category, data.subject, data.content, data.notes);
            } else {
                result = await API.createTemplate(data.name, data.category, data.subject, data.content, data.notes);
            }

            if (result.success) {
                this.showNotification(result.message || 'Template saved successfully', 'success');
                this.closeModal('templateModal');
                await this.loadTemplates();
                await this.loadTemplatesInModal();
            }
        } catch (error) {
            this.showNotification(error.message || 'Failed to save template', 'error');
        } finally {
            this.hideLoading();
        }
    },

    async templatesSendTemplateResponse(event) {
        event.preventDefault();

        const formData = new FormData(event.target);
        const recipient = formData.get('recipient');
        const subject = formData.get('subject');
        const message = formData.get('message');
        const priority = formData.get('priority');

        if (!this.currentMessageId) {
            this.showNotification('No message selected', 'error');
            return;
        }

        try {
            this.showLoading();

            const result = await API.sendResponse(
                this.currentMessageId,
                message,
                subject,
                'in-progress',
                priority,
                currentMessage.template_id
            );

            if (result.success) {
                this.showNotification('Response sent successfully!', 'success');
                this.closeModal('useTemplateModal');
                this.closeModal('templatesModal');
                await this.loadMessages();
                await this.loadStats();
            }
        } catch (error) {
            this.showNotification(error.message || 'Failed to send response', 'error');
        } finally {
            this.hideLoading();
        }
    },

    templatesSwitchView(view, event) {
        const modal = document.getElementById('templatesModalContent');
        const grid = modal.querySelector('#templateGrid');
        const toggleBtns = modal.querySelectorAll('.toggle-btn');

        toggleBtns.forEach(btn => btn.classList.remove('active'));
        event.currentTarget.classList.add('active');

        if (view === 'list') {
            grid.classList.add('list-view');
            grid.style.display = 'block';
        } else {
            grid.classList.remove('list-view');
            grid.style.display = 'grid';
        }
    },

    // ============ VIEW DETAILS ============

    async viewRequest(messageId = this.currentMessageId, isArchived = false) {
        if (!messageId) {
            this.showNotification('No message selected', 'error');
            return;
        }

        try {
            this.showLoading();

            const response = await fetch(`view-request.php?id=${messageId}&archived=${isArchived}`);
            const html = await response.text();

            document.getElementById('viewDetailsModalContent').innerHTML = html;
            document.getElementById('viewDetailsModal').classList.add('active');

            lucide.createIcons();
            this.initViewDetailsModalListeners();
        } catch (error) {
            console.error('Failed to load view details modal:', error);
            this.showNotification('Failed to load message details', 'error');
        } finally {
            this.hideLoading();
        }
    },

    initViewDetailsModalListeners() {
        // Event listeners are bound inline in view-request.php
    },

    openResponseModalFromViewDetails() {
        this.openResponseModal();
        this.closeModal('viewDetailsModal');
    },

    async archiveMessageFromViewDetails() {
        this.openSingleArchiveModal(this.currentMessageId);
    },

    async markAsResolvedFromViewDetails() {
        if (!confirm('Mark this message as resolved?')) return;

        try {
            this.showLoading();
            const result = await API.updateRequest(this.currentMessageId, 'resolved');

            if (result.success) {
                this.showNotification('Message marked as resolved', 'success');
                await this.loadMessages();
                await this.loadStats();
            }
        } catch (error) {
            this.showNotification(error.message || 'Failed to update status', 'error');
        } finally {
            this.hideLoading();
        }
    },

    async escalateMessageFromViewDetails() {
        try {
            this.showLoading();
            const result = await API.updateRequest(this.currentMessageId, 'in-progress');

            if (result.success) {
                this.showNotification('Message escalated to supervisor', 'info');
                await this.loadMessages();
            }
        } catch (error) {
            this.showNotification(error.message || 'Failed to escalate', 'error');
        } finally {
            this.hideLoading();
        }
    },

    createOrderFromViewDetails() {
        const currentMessage = this.messages.find(m => m.id === this.currentMessageId);
        if (currentMessage) {
            window.open(`../orders/create.php?customer=${encodeURIComponent(currentMessage.customerName)}&email=${encodeURIComponent(currentMessage.customerEmail)}`, '_blank');
        } else {
            window.open('../orders/create.php', '_blank');
        }
    },

    scheduleFollowUpFromViewDetails() {
        this.showNotification('Follow-up scheduled', 'success');
    },

    downloadAttachment(filename) {
        this.showNotification('Downloading ' + filename + '...', 'info');
    },

    async viewRelatedMessage(id) {
        await this.viewRequest(id, false);
    },

    // ============ UTILITY FUNCTIONS ============

    showNotification(message, type = 'success') {
        const notification = document.getElementById('appNotification');
        notification.textContent = message;
        notification.className = `app-notification ${type}`;
        notification.classList.add('show');

        setTimeout(() => {
            notification.classList.remove('show');
        }, 3000);
    },

    closeModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.remove('active');

        // Clear content for dynamically loaded modals
        if (['archiveModal', 'templatesModal', 'viewDetailsModal'].includes(modalId)) {
            const content = document.getElementById(modalId + 'Content');
            if (content) {
                setTimeout(() => {
                    content.innerHTML = '';
                }, 300);
            }
        }
    },

    showLoading() {
        document.getElementById('loadingOverlay').classList.add('active');
    },

    hideLoading() {
        document.getElementById('loadingOverlay').classList.remove('active');
    },

    formatTimeAgo(dateString) {
        const date = new Date(dateString);
        const now = new Date();
        const seconds = Math.floor((now - date) / 1000);

        if (seconds < 60) return 'Just now';
        if (seconds < 3600) return Math.floor(seconds / 60) + ' minutes ago';
        if (seconds < 86400) return Math.floor(seconds / 3600) + ' hours ago';
        if (seconds < 604800) return Math.floor(seconds / 86400) + ' days ago';

        return date.toLocaleDateString();
    },

    formatDateTime(dateString) {
        const date = new Date(dateString);
        return date.toLocaleString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    },

    formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric'
        });
    },

    formatType(type) {
        return type.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
    },

    formatArchiveReason(reason) {
        return reason.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
    },

    formatMessageText(text) {
        return text.split('\n').map(line => {
            return line.trim() ? `<p>${this.escapeHtml(line)}</p>` : '<br>';
        }).join('');
    },

    getInitials(name) {
        const parts = name.split(' ');
        return (parts[0][0] + (parts[1]?.[0] || '')).toUpperCase();
    },

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
};

// Initialize application when DOM is ready
document.addEventListener('DOMContentLoaded', async function() {
    lucide.createIcons();
    await appState.init();
});
