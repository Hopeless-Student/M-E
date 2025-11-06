<?php

?>
<div class="app-modal-header">
    <h3 class="app-modal-title">Archived Messages</h3>
    <button class="app-modal-close-btn" onclick="appState.closeModal('archiveModal')">&times;</button>
</div>
<div class="app-modal-body">
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
            <div class="app-form-group">
                <label class="app-form-label">Archive Date</label>
                <select class="app-form-select" id="dateFilter">
                    <option value="">All dates</option>
                    <option value="today">Today</option>
                    <option value="week">This week</option>
                    <option value="month">This month</option>
                    <option value="quarter">Last 3 months</option>
                    <option value="year">This year</option>
                </select>
            </div>
            <div class="app-form-group">
                <label class="app-form-label">Message Type</label>
                <select class="app-form-select" id="typeFilter">
                    <option value="">All types</option>
                    <option value="inquiry">Inquiry</option>
                    <option value="custom-order">Custom Order</option>
                    <option value="complaint">Complaint</option>
                    <option value="feedback">Feedback</option>
                </select>
            </div>
            <div class="app-form-group">
                <label class="app-form-label">Archive Reason</label>
                <select class="app-form-select" id="reasonFilter">
                    <option value="">All reasons</option>
                    <option value="resolved">Resolved</option>
                    <option value="auto">Auto-archived</option>
                    <option value="manual">Manually archived</option>
                    <option value="expired">Expired</option>
                </select>
            </div>
            <div class="app-form-group">
                <label class="app-form-label">Sort By</label>
                <select class="app-form-select" id="sortFilter">
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
                <input type="checkbox" class="select-all-checkbox" id="selectAll" onchange="appState.archiveToggleSelectAll()">
                <label for="selectAll" style="margin-right: 1rem; font-size: 0.9rem;">Select All</label>
                <button class="bulk-btn" onclick="appState.archiveBulkRestore()" id="restoreBtn" disabled>
                    <i data-lucide="rotate-ccw" width="14" height="14"></i>
                    Restore
                </button>
                <button class="bulk-btn danger" onclick="appState.archiveBulkDelete()" id="deleteBtn" disabled>
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
                        <input type="checkbox" class="message-checkbox" data-id="1" onchange="appState.archiveUpdateBulkActions()">
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
                            <button class="icon-btn" onclick="appState.archiveViewArchivedMessage(1)" title="View">
                                <i data-lucide="eye" width="14" height="14"></i>
                            </button>
                            <button class="icon-btn" onclick="appState.archiveRestoreMessage(1)" title="Restore">
                                <i data-lucide="rotate-ccw" width="14" height="14"></i>
                            </button>
                            <button class="icon-btn danger" onclick="appState.archiveDeleteMessage(1)" title="Delete Permanently">
                                <i data-lucide="trash-2" width="14" height="14"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="checkbox-cell">
                        <input type="checkbox" class="message-checkbox" data-id="2" onchange="appState.archiveUpdateBulkActions()">
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
                            <button class="icon-btn" onclick="appState.archiveViewArchivedMessage(2)" title="View">
                                <i data-lucide="eye" width="14" height="14"></i>
                            </button>
                            <button class="icon-btn" onclick="appState.archiveRestoreMessage(2)" title="Restore">
                                <i data-lucide="rotate-ccw" width="14" height="14"></i>
                            </button>
                            <button class="icon-btn danger" onclick="appState.archiveDeleteMessage(2)" title="Delete Permanently">
                                <i data-lucide="trash-2" width="14" height="14"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="checkbox-cell">
                        <input type="checkbox" class="message-checkbox" data-id="3" onchange="appState.archiveUpdateBulkActions()">
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
                            <button class="icon-btn" onclick="appState.archiveViewArchivedMessage(3)" title="View">
                                <i data-lucide="eye" width="14" height="14"></i>
                            </button>
                            <button class="icon-btn" onclick="appState.archiveRestoreMessage(3)" title="Restore">
                                <i data-lucide="rotate-ccw" width="14" height="14"></i>
                            </button>
                            <button class="icon-btn danger" onclick="appState.archiveDeleteMessage(3)" title="Delete Permanently">
                                <i data-lucide="trash-2" width="14" height="14"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="checkbox-cell">
                        <input type="checkbox" class="message-checkbox" data-id="4" onchange="appState.archiveUpdateBulkActions()">
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
                            <button class="icon-btn" onclick="appState.archiveViewArchivedMessage(4)" title="View">
                                <i data-lucide="eye" width="14" height="14"></i>
                            </button>
                            <button class="icon-btn" onclick="appState.archiveRestoreMessage(4)" title="Restore">
                                <i data-lucide="rotate-ccw" width="14" height="14"></i>
                            </button>
                            <button class="icon-btn danger" onclick="appState.archiveDeleteMessage(4)" title="Delete Permanently">
                                <i data-lucide="trash-2" width="14" height="14"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="checkbox-cell">
                        <input type="checkbox" class="message-checkbox" data-id="5" onchange="appState.archiveUpdateBulkActions()">
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
                            <button class="icon-btn" onclick="appState.archiveViewArchivedMessage(5)" title="View">
                                <i data-lucide="eye" width="14" height="14"></i>
                            </button>
                            <button class="icon-btn" onclick="appState.archiveRestoreMessage(5)" title="Restore">
                                <i data-lucide="rotate-ccw" width="14" height="14"></i>
                            </button>
                            <button class="icon-btn danger" onclick="appState.archiveDeleteMessage(5)" title="Delete Permanently">
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
</div>

<!-- Restore Modal (Nested within archive modal content) -->
<div class="app-modal-overlay" id="restoreModal">
    <div class="app-modal">
        <div class="app-modal-header">
            <h3 class="app-modal-title">Bulk Restore Messages</h3>
            <button class="app-modal-close-btn" onclick="appState.closeModal('restoreModal')">&times;</button>
        </div>
        <form onsubmit="appState.archiveHandleBulkRestore(event)">
            <div class="app-form-group">
                <label class="app-form-label">Restore To</label>
                <select class="app-form-select" name="restoreTo" required>
                    <option value="">Select destination</option>
                    <option value="inbox">Main Inbox</option>
                    <option value="priority">Priority Queue</option>
                    <option value="follow-up">Follow-up Required</option>
                </select>
            </div>
            <div class="app-form-group">
                <label class="app-form-label">Restore Reason (Optional)</label>
                <textarea class="app-form-textarea" name="reason" placeholder="Enter reason for restoring these messages..."></textarea>
            </div>
            <div class="app-modal-actions">
                <button type="button" class="app-action-btn secondary" onclick="appState.closeModal('restoreModal')">Cancel</button>
                <button type="submit" class="app-action-btn primary">Restore Messages</button>
            </div>
        </form>
    </div>
</div>

<!-- Single Message Archive Modal -->



<!-- Delete Confirmation Modal (Nested within archive modal content) -->
<div class="app-modal-overlay" id="deleteModal">
    <div class="app-modal">
        <div class="app-modal-header">
            <h3 class="app-modal-title">Confirm Deletion</h3>
            <button class="app-modal-close-btn" onclick="appState.closeModal('deleteModal')">&times;</button>
        </div>
        <p style="margin-bottom: 1.5rem; color: #64748b;">
            Are you sure you want to permanently delete the selected messages? This action cannot be undone.
        </p>
        <div class="app-modal-actions">
            <button type="button" class="app-action-btn secondary" onclick="appState.closeModal('deleteModal')">Cancel</button>
            <button type="button" class="app-action-btn danger" onclick="appState.archiveConfirmDelete()">Delete Permanently</button>
        </div>
    </div>
</div>
