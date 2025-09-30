<?php
// This file is now designed to be loaded dynamically into a modal.
// It should not have full HTML structure (<html>, <head>, <body>)
// as it will be inserted into an existing document.
// Only the content relevant to the modal body should be here.
?>
<div class="app-modal-header">
    <h3 class="app-modal-title">Response Templates</h3>
    <button class="app-modal-close-btn" onclick="appState.closeModal('templatesModal')">&times;</button>
</div>
<div class="app-modal-body">
    <!-- Template Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-title">Total Templates</div>
            <div class="stat-value">24</div>
        </div>
        <div class="stat-card">
            <div class="stat-title">Most Used</div>
            <div class="stat-value">Product Info</div>
        </div>
        <div class="stat-card">
            <div class="stat-title">This Month Usage</div>
            <div class="stat-value">156</div>
        </div>
        <div class="stat-card">
            <div class="stat-title">Avg Response Time</div>
            <div class="stat-value">45s</div>
        </div>
    </div>

    <!-- Template Layout -->
    <div class="template-layout">
        <!-- Categories -->
        <div class="template-categories">
            <div class="categories-header">
                <h3 class="categories-title">Categories</h3>
                <button class="action-button primary small" onclick="appState.templatesCreateTemplate()">
                    <i data-lucide="plus" width="16" height="16"></i>
                    New
                </button>
            </div>
            <ul class="category-list">
                <li class="category-item">
                    <a href="#" class="category-link active" data-category="all">
                        <div class="category-info">
                            <i data-lucide="folder" width="16" height="16"></i>
                            <span>All Templates</span>
                        </div>
                        <span class="category-count">24</span>
                    </a>
                </li>
                <li class="category-item">
                    <a href="#" class="category-link" data-category="inquiry">
                        <div class="category-info">
                            <i data-lucide="help-circle" width="16" height="16"></i>
                            <span>Product Inquiry</span>
                        </div>
                        <span class="category-count">8</span>
                    </a>
                </li>
                <li class="category-item">
                    <a href="#" class="category-link" data-category="orders">
                        <div class="category-info">
                            <i data-lucide="shopping-bag" width="16" height="16"></i>
                            <span>Order Related</span>
                        </div>
                        <span class="category-count">6</span>
                    </a>
                </li>
                <li class="category-item">
                    <a href="#" class="category-link" data-category="support">
                        <div class="category-info">
                            <i data-lucide="headphones" width="16" height="16"></i>
                            <span>Customer Support</span>
                        </div>
                        <span class="category-count">5</span>
                    </a>
                </li>
                <li class="category-item">
                    <a href="#" class="category-link" data-category="feedback">
                        <div class="category-info">
                            <i data-lucide="star" width="16" height="16"></i>
                            <span>Feedback Response</span>
                        </div>
                        <span class="category-count">3</span>
                    </a>
                </li>
                <li class="category-item">
                    <a href="#" class="category-link" data-category="custom">
                        <div class="category-info">
                            <i data-lucide="edit-3" width="16" height="16"></i>
                            <span>Custom Orders</span>
                        </div>
                        <span class="category-count">2</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Templates Panel -->
        <div class="template-panel">
            <div class="panel-header">
                <h3 class="panel-title">All Templates (24)</h3>
                <div class="panel-actions">
                    <div class="search-box">
                        <i data-lucide="search" class="search-icon"></i>
                        <input type="text" class="search-input" placeholder="Search templates..." oninput="appState.templatesSearch.call(this)">
                    </div>
                    <div class="view-toggle">
                        <button class="toggle-btn active" data-view="grid" onclick="appState.templatesSwitchView('grid', event)" title="Grid View">
                            <i data-lucide="grid-3x3" width="16" height="16"></i>
                        </button>
                        <button class="toggle-btn" data-view="list" onclick="appState.templatesSwitchView('list', event)" title="List View">
                            <i data-lucide="list" width="16" height="16"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="templates-container">
                <div class="template-grid" id="templateGrid">
                    <!-- Product Availability Template -->
                    <div class="template-card" data-category="inquiry" data-template-id="availability">
                        <div class="template-header">
                            <div class="template-title">
                                Product Availability
                                <span class="usage-badge">Most Used</span>
                            </div>
                            <div class="template-meta">
                                <span>Used 45 times</span>
                                <span>Last updated: Aug 15</span>
                            </div>
                        </div>
                        <div class="template-content">
                            <div class="template-preview">
                                Dear {{customer_name}},

Thank you for your inquiry about {{product_name}}. Yes, we have the quantity you need available in stock. For bulk orders of {{quantity}}+ pieces, we offer a {{discount}}% discount...
                            </div>
                            <div class="template-actions">
                                <button class="template-btn primary" onclick="appState.templatesUseTemplate('availability')">
                                    <i data-lucide="send" width="14" height="14"></i>
                                    Use Template
                                </button>
                                <button class="template-btn" onclick="appState.templatesEditTemplate('availability')">
                                    <i data-lucide="edit-2" width="14" height="14"></i>
                                    Edit
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Order Confirmation Template -->
                    <div class="template-card" data-category="orders" data-template-id="order-confirmation">
                        <div class="template-header">
                            <div class="template-title">Order Confirmation</div>
                            <div class="template-meta">
                                <span>Used 32 times</span>
                                <span>Last updated: Aug 12</span>
                            </div>
                        </div>
                        <div class="template-content">
                            <div class="template-preview">
                                Dear {{customer_name}},

Thank you for your order #{{order_id}}. We have received your order and it is being processed. Your order details:

{{order_details}}

Estimated delivery: {{delivery_date}}
                            </div>
                            <div class="template-actions">
                                <button class="template-btn primary" onclick="appState.templatesUseTemplate('order-confirmation')">
                                    <i data-lucide="send" width="14" height="14"></i>
                                    Use Template
                                </button>
                                <button class="template-btn" onclick="appState.templatesEditTemplate('order-confirmation')">
                                    <i data-lucide="edit-2" width="14" height="14"></i>
                                    Edit
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Complaint Resolution Template -->
                    <div class="template-card" data-category="support" data-template-id="complaint-resolution">
                        <div class="template-header">
                            <div class="template-title">Complaint Resolution</div>
                            <div class="template-meta">
                                <span>Used 28 times</span>
                                <span>Last updated: Aug 10</span>
                            </div>
                        </div>
                        <div class="template-content">
                            <div class="template-preview">
                                Dear {{customer_name}},

We sincerely apologize for the inconvenience you've experienced with {{issue_description}}. We take all customer concerns seriously and will investigate this matter immediately...
                            </div>
                            <div class="template-actions">
                                <button class="template-btn primary" onclick="appState.templatesUseTemplate('complaint-resolution')">
                                    <i data-lucide="send" width="14" height="14"></i>
                                    Use Template
                                </button>
                                <button class="template-btn" onclick="appState.templatesEditTemplate('complaint-resolution')">
                                    <i data-lucide="edit-2" width="14" height="14"></i>
                                    Edit
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Delivery Information Template -->
                    <div class="template-card" data-category="orders" data-template-id="delivery-info">
                        <div class="template-header">
                            <div class="template-title">Delivery Information</div>
                            <div class="template-meta">
                                <span>Used 25 times</span>
                                <span>Last updated: Aug 8</span>
                            </div>
                        </div>
                        <div class="template-content">
                            <div class="template-preview">
                                Dear {{customer_name}},

Your order #{{order_id}} has been shipped and is on its way to {{delivery_address}}.

Tracking Number: {{tracking_number}}
Estimated Delivery: {{delivery_date}}...
                            </div>
                            <div class="template-actions">
                                <button class="template-btn primary" onclick="appState.templatesUseTemplate('delivery-info')">
                                    <i data-lucide="send" width="14" height="14"></i>
                                    Use Template
                                </button>
                                <button class="template-btn" onclick="appState.templatesEditTemplate('delivery-info')">
                                    <i data-lucide="edit-2" width="14" height="14"></i>
                                    Edit
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Thank You Response Template -->
                    <div class="template-card" data-category="feedback" data-template-id="thank-you">
                        <div class="template-header">
                            <div class="template-title">Thank You Response</div>
                            <div class="template-meta">
                                <span>Used 22 times</span>
                                <span>Last updated: Aug 5</span>
                            </div>
                        </div>
                        <div class="template-content">
                            <div class="template-preview">
                                Dear {{customer_name}},

Thank you so much for your positive feedback! We're delighted to hear that you're satisfied with {{product_service}}.

Customer satisfaction is our top priority...
                            </div>
                            <div class="template-actions">
                                <button class="template-btn primary" onclick="appState.templatesUseTemplate('thank-you')">
                                    <i data-lucide="send" width="14" height="14"></i>
                                    Use Template
                                </button>
                                <button class="template-btn" onclick="appState.templatesEditTemplate('thank-you')">
                                    <i data-lucide="edit-2" width="14" height="14"></i>
                                    Edit
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Custom Order Quote Template -->
                    <div class="template-card" data-category="custom" data-template-id="custom-order">
                        <div class="template-header">
                            <div class="template-title">Custom Order Quote</div>
                            <div class="template-meta">
                                <span>Used 18 times</span>
                                <span>Last updated: Aug 3</span>
                            </div>
                        </div>
                        <div class="template-content">
                            <div class="template-preview">
                                Dear {{customer_name}},

Thank you for your custom order inquiry for {{custom_item}}. Based on your requirements, here's our detailed quote:

{{quote_details}}

Timeline: {{delivery_timeline}}...
                            </div>
                            <div class="template-actions">
                                <button class="template-btn primary" onclick="appState.templatesUseTemplate('custom-order')">
                                    <i data-lucide="send" width="14" height="14"></i>
                                    Use Template
                                </button>
                                <button class="template-btn" onclick="appState.templatesEditTemplate('custom-order')">
                                    <i data-lucide="edit-2" width="14" height="14"></i>
                                    Edit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Template Editor Modal (Nested within templates modal content) -->
<div class="app-modal-overlay" id="templateModal">
    <div class="app-modal">
        <div class="app-modal-header">
            <h3 class="app-modal-title" id="modalTitle">Edit Template</h3>
            <button class="app-modal-close-btn" onclick="appState.closeModal('templateModal')">&times;</button>
        </div>
        <div class="app-modal-body">
            <form id="templateForm" onsubmit="appState.templatesSaveTemplate(event)">
                <div class="app-form-group">
                    <label class="app-form-label">Template Name</label>
                    <input type="text" class="app-form-input" name="name" required>
                </div>

                <div class="app-form-group">
                    <label class="app-form-label">Category</label>
                    <select class="app-form-select" name="category" required>
                        <option value="inquiry">Product Inquiry</option>
                        <option value="orders">Order Related</option>
                        <option value="support">Customer Support</option>
                        <option value="feedback">Feedback Response</option>
                        <option value="custom">Custom Orders</option>
                    </select>
                </div>

                <div class="app-form-group">
                    <label class="app-form-label">Subject Line</label>
                    <input type="text" class="app-form-input" name="subject" placeholder="Email subject (optional)">
                </div>

                <div class="template-variables">
                    <div class="variables-title">Available Variables (click to insert)</div>
                    <div class="variables-list">
                        <span class="variable-tag" onclick="appState.templatesInsertVariable('{{customer_name}}')">{{customer_name}}</span>
                        <span class="variable-tag" onclick="appState.templatesInsertVariable('{{order_id}}')">{{order_id}}</span>
                        <span class="variable-tag" onclick="appState.templatesInsertVariable('{{product_name}}')">{{product_name}}</span>
                        <span class="variable-tag" onclick="appState.templatesInsertVariable('{{quantity}}')">{{quantity}}</span>
                        <span class="variable-tag" onclick="appState.templatesInsertVariable('{{price}}')">{{price}}</span>
                        <span class="variable-tag" onclick="appState.templatesInsertVariable('{{delivery_date}}')">{{delivery_date}}</span>
                        <span class="variable-tag" onclick="appState.templatesInsertVariable('{{tracking_number}}')">{{tracking_number}}</span>
                        <span class="variable-tag" onclick="appState.templatesInsertVariable('{{company_name}}')">{{company_name}}</span>
                    </div>
                </div>

                <div class="app-form-group">
                    <label class="app-form-label">Template Content</label>
                    <textarea class="app-form-textarea" name="content" id="templateContent" required placeholder="Enter your template content here..."></textarea>
                </div>

                <div class="app-form-group">
                    <label class="app-form-label">Usage Notes (Internal)</label>
                    <textarea class="app-form-textarea" name="notes" rows="3" placeholder="Optional notes about when to use this template..."></textarea>
                </div>
            </form>
        </div>
        <div class="app-modal-actions">
            <button type="button" class="app-action-btn secondary" onclick="appState.closeModal('templateModal')">Cancel</button>
            <button type="submit" form="templateForm" class="app-action-btn primary">Save Template</button>
        </div>
    </div>
</div>

<!-- Template Usage Modal (Nested within templates modal content) -->
<div class="app-modal-overlay" id="useTemplateModal">
    <div class="app-modal">
        <div class="app-modal-header">
            <h3 class="app-modal-title">Use Template</h3>
            <button class="app-modal-close-btn" onclick="appState.closeModal('useTemplateModal')">&times;</button>
        </div>
        <div class="app-modal-body">
            <form id="useTemplateForm" onsubmit="appState.templatesSendTemplateResponse(event)">
                <div class="app-form-group">
                    <label class="app-form-label">To:</label>
                    <input type="email" class="app-form-input" name="recipient" value="juan.delacruz@email.com" required>
                </div>

                <div class="app-form-group">
                    <label class="app-form-label">Subject:</label>
                    <input type="text" class="app-form-input" name="subject" id="templateSubject" required>
                </div>

                <div class="app-form-group">
                    <label class="app-form-label">Message:</label>
                    <textarea class="app-form-textarea" name="message" id="templateMessage" required></textarea>
                </div>

                <div class="app-form-group">
                    <label class="app-form-label">Priority:</label>
                    <select class="app-form-select" name="priority">
                        <option value="normal">Normal</option>
                        <option value="high">High</option>
                        <option value="urgent">Urgent</option>
                    </select>
                </div>
            </form>
        </div>
        <div class="app-modal-actions">
            <button type="button" class="app-action-btn secondary" onclick="appState.closeModal('useTemplateModal')">Cancel</button>
            <button type="submit" form="useTemplateForm" class="app-action-btn primary">Send Response</button>
        </div>
    </div>
</div>
