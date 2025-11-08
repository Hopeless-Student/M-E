<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Edit Modal</title>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js?v=<?php echo time(); ?>"></script>
    <style>
        /* Base styles for all modals */
        .customer-edit-modal-base {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
        }

        .customer-edit-modal-base.show {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            animation: customerEditFadeIn 0.3s ease;
        }

        @keyframes customerEditFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .customer-edit-modal-content {
            background: white;
            border-radius: 16px;
            width: 100%;
            max-width: 1000px;
            max-height: 90vh;
            overflow: hidden;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);
            animation: customerEditSlideIn 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        @keyframes customerEditSlideIn {
            from { transform: translateY(-30px) scale(0.95); opacity: 0; }
            to { transform: translateY(0) scale(1); opacity: 1; }
        }

        /* Modal Header */
        .customer-edit-modal-header {
            padding: 1rem 2rem; /* Slightly reduced padding */
            border-bottom: 1px solid #e2e8f0;
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
        }

        .customer-edit-modal-title {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .customer-edit-avatar-large {
            width: 50px; /* Slightly smaller avatar */
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.1rem; /* Slightly smaller font */
        }

        .customer-edit-modal-title h3 {
            font-size: 1.3rem; /* Slightly smaller font */
            font-weight: 600;
            margin: 0;
        }

        .customer-edit-modal-title p {
            opacity: 0.9;
            font-size: 0.85rem; /* Slightly smaller font */
            margin: 0;
        }

        .customer-edit-close-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: white;
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.2s ease;
            width: 36px; /* Slightly smaller button */
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .customer-edit-close-btn:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        /* Modal Body */
        .customer-edit-modal-body {
            flex: 1;
            overflow-y: auto;
            padding: 2rem;
        }

        /* Customer Stats */
        .customer-edit-customer-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: #f8fafc;
            border-radius: 12px;
        }

        .customer-edit-stat-item {
            text-align: center;
        }

        .customer-edit-stat-value {
            font-size: 1.3rem;
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 0.25rem;
        }

        .customer-edit-stat-label {
            font-size: 0.8rem;
            color: #64748b;
            font-weight: 500;
        }

        /* Section Headers */
        .customer-edit-section-header {
            margin: 2rem 0 1rem;
            color: #1e40af;
            font-size: 1.1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .customer-edit-section-header:first-child {
            margin-top: 0;
        }

        .customer-edit-section-header .lucide {
            width: 20px;
            height: 20px;
        }

        /* Form Sections */
        .customer-edit-form-section {
            background: #f8fafc;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .customer-edit-form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .customer-edit-form-group {
            display: flex;
            flex-direction: column;
        }

        .customer-edit-form-label {
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .customer-edit-form-input, .customer-edit-form-select, .customer-edit-form-textarea {
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 0.9rem;
            transition: border-color 0.2s ease;
            background: white;
        }

        .customer-edit-form-input:focus, .customer-edit-form-select:focus, .customer-edit-form-textarea:focus {
            outline: none;
            border-color: #1e40af;
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
        }

        .customer-edit-form-textarea {
            resize: vertical;
            min-height: 100px;
            font-family: inherit;
        }

        .customer-edit-form-help {
            color: #64748b;
            font-size: 0.8rem;
            margin-top: 0.25rem;
        }

        /* Info Display */
        .customer-edit-info-display {
            background: #f8fafc;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }

        .customer-edit-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .customer-edit-info-item {
            display: flex;
            flex-direction: column;
        }

        .customer-edit-info-label {
            color: #64748b;
            font-size: 0.8rem;
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .customer-edit-info-value {
            color: #1e293b;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .customer-edit-notice-box {
            margin-top: 1rem;
            padding: 1rem;
            background: white;
            border-radius: 6px;
            border-left: 4px solid #fbbf24;
        }

        .customer-edit-notice-box p {
            color: #92400e;
            font-size: 0.9rem;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .customer-edit-notice-box .lucide {
            width: 14px;
            height: 14px;
        }

        /* Checkbox Group */
        .customer-edit-checkbox-group {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .customer-edit-checkbox-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem;
            border-radius: 6px;
            transition: background-color 0.2s ease;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .customer-edit-checkbox-item:hover {
            background-color: #f1f5f9;
        }

        .customer-edit-checkbox-item input[type="checkbox"] {
            margin: 0;
            width: 16px;
            height: 16px;
            accent-color: #1e40af;
        }

        /* Financial Summary */
        .customer-edit-financial-summary {
            background: #f8fafc;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 2rem;
        }

        .customer-edit-financial-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
        }

        .customer-edit-financial-item {
            display: flex;
            flex-direction: column;
        }

        .customer-edit-financial-label {
            color: #64748b;
            font-size: 0.8rem;
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .customer-edit-financial-value {
            font-weight: 700;
            font-size: 1rem;
        }

        .customer-edit-financial-value.positive { color: #059669; }
        .customer-edit-financial-value.negative { color: #dc2626; }
        .customer-edit-financial-value.primary { color: #1e40af; }

        /* Quick Actions */
        .customer-edit-quick-actions {
            background: #f8fafc;
            padding: 1.5rem;
            border-radius: 8px;
            margin-top: 2rem;
        }

        .customer-edit-quick-actions h5 {
            margin-bottom: 1rem;
            color: #1e40af;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1rem;
        }

        .customer-edit-quick-actions .lucide {
            width: 18px;
            height: 18px;
        }

        .customer-edit-quick-actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem;
        }

        /* Modal Footer */
        .customer-edit-modal-footer {
            padding: 1rem 2rem; /* Slightly reduced padding */
            border-top: 1px solid #e2e8f0;
            background: #f8fafc;
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            flex-shrink: 0;
        }

        .customer-edit-btn {
            padding: 0.6rem 1.2rem; /* Slightly reduced padding */
            border: none;
            border-radius: 8px;
            font-size: 0.85rem; /* Slightly smaller font */
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .customer-edit-btn .lucide {
            width: 14px; /* Slightly smaller icon */
            height: 14px;
        }

        .customer-edit-btn-primary {
            background-color: #1e40af;
            color: white;
        }

        .customer-edit-btn-primary:hover {
            background-color: #1e3a8a;
        }

        .customer-edit-btn-secondary {
            background-color: #64748b;
            color: white;
        }

        .customer-edit-btn-secondary:hover {
            background-color: #475569;
        }

        .customer-edit-btn-danger {
            background-color: #dc2626;
            color: white;
        }

        .customer-edit-btn-danger:hover {
            background-color: #b91c1c;
        }

        /* Sub-modals */
        .customer-edit-sub-modal {
            display: none;
            position: fixed;
            z-index: 1001;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(4px);
        }

        .customer-edit-sub-modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .customer-edit-sub-modal-content {
            background: white;
            border-radius: 12px;
            width: 100%;
            max-width: 500px;
            max-height: 80vh;
            overflow-y: auto;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3);
        }

        .customer-edit-sub-modal-header {
            padding: 1.2rem 1.5rem; /* Slightly reduced padding */
            border-bottom: 1px solid #e2e8f0;
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .customer-edit-sub-modal-header h4 {
            color: #1e40af;
            font-size: 1.05rem; /* Slightly smaller font */
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .customer-edit-sub-modal-body {
            padding: 1.5rem;
        }

        .customer-edit-sub-modal-footer {
            padding: 1.2rem 1.5rem; /* Slightly reduced padding */
            border-top: 1px solid #e2e8f0;
            background: #f8fafc;
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }

        .customer-edit-warning-box {
            padding: 1rem;
            background: #fef3c7;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            border-left: 4px solid #f59e0b;
        }

        .customer-edit-warning-box p {
            color: #92400e;
            margin: 0;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .customer-edit-danger-box {
            padding: 1rem;
            background: #fee2e2;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            border-left: 4px solid #dc2626;
        }

        .customer-edit-danger-box p {
            color: #dc2626;
            margin: 0;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .customer-edit-modal-content {
                max-width: 95vw;
                margin: 0.5rem;
            }

            .customer-edit-form-grid {
                grid-template-columns: 1fr;
            }

            .customer-edit-customer-stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .customer-edit-checkbox-group {
                grid-template-columns: 1fr;
            }

            .customer-edit-quick-actions-grid {
                grid-template-columns: 1fr;
            }

            .customer-edit-modal-footer {
                flex-direction: column-reverse;
            }

            .customer-edit-btn {
                width: 100%;
                justify-content: center;
            }
            .customer-edit-modal-header {
                flex-direction: column;
                text-align: center;
                gap: 0.8rem;
                padding: 1rem;
            }
            .customer-edit-modal-title {
                flex-direction: column;
                gap: 0.5rem;
            }
            .customer-edit-modal-title h3 {
                font-size: 1.2rem;
            }
            .customer-edit-modal-title p {
                font-size: 0.8rem;
            }
            .customer-edit-avatar-large {
                width: 45px;
                height: 45px;
                font-size: 1rem;
            }
            .customer-edit-modal-body {
                padding: 1rem;
            }
            .customer-edit-sub-modal-header {
                padding: 1rem;
            }
            .customer-edit-sub-modal-body {
                padding: 1rem;
            }
            .customer-edit-sub-modal-footer {
                padding: 1rem;
            }
        }

        @media (max-width: 480px) {
            .customer-edit-customer-stats {
                grid-template-columns: 1fr;
            }

            .customer-edit-financial-grid {
                grid-template-columns: 1fr;
            }

            .customer-edit-info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <!-- Customer Edit Modal -->
    <div id="customerEditModal" class="customer-edit-modal-base" onclick="closeCustomerEditModal(event)">
        <div class="customer-edit-modal-content" onclick="event.stopPropagation()">
            <div class="customer-edit-modal-header">
                <div class="customer-edit-modal-title">
                    <div class="customer-edit-avatar-large">JD</div>
                    <div>
                        <h3>Edit Customer - Juan Dela Cruz</h3>
                        <p>Customer ID: <span id="customerEditID">#CUS-001</span>
                        </p>
                    </div>
                </div>
                <button class="customer-edit-close-btn" onclick="closeCustomerEditModal()">&times;</button>
            </div>

            <div class="customer-edit-modal-body">
                <form id="editCustomerForm">
                    <!-- Customer Stats -->
                    <div class="customer-edit-customer-stats">
                        <div class="customer-edit-stat-item">
                            <div class="customer-edit-stat-value">8</div>
                            <div class="customer-edit-stat-label">Total Orders</div>
                        </div>
                        <div class="customer-edit-stat-item">
                            <div class="customer-edit-stat-value">₱4,250</div>
                            <div class="customer-edit-stat-label">Total Spent</div>
                        </div>
                        <div class="customer-edit-stat-item">
                            <div class="customer-edit-stat-value">Aug 2024</div>
                            <div class="customer-edit-stat-label">Member Since</div>
                        </div>
                        <div class="customer-edit-stat-item">
                            <div class="customer-edit-stat-value">2 days ago</div>
                            <div class="customer-edit-stat-label">Last Order</div>
                        </div>
                    </div>

                    <!-- Customer Information (Read-Only) -->
                    <h4 class="customer-edit-section-header">
                        <i data-lucide="user"></i>
                        Customer Information
                    </h4>
                    <div class="customer-edit-info-display">
                        <div class="customer-edit-info-grid">
                            <div class="customer-edit-info-item">
                                <label class="customer-edit-info-label">Full Name</label>
                                <span class="customer-edit-info-value">Juan Dela Cruz</span>
                            </div>
                            <div class="customer-edit-info-item">
                                <label class="customer-edit-info-label">Email Address</label>
                                <span class="customer-edit-info-value">juan.delacruz@email.com</span>
                            </div>
                            <div class="customer-edit-info-item">
                                <label class="customer-edit-info-label">Phone Number</label>
                                <span class="customer-edit-info-value">+63 917 123 4567</span>
                            </div>
                            <div class="customer-edit-info-item">
                                <label class="customer-edit-info-label">Registration Date</label>
                                <span class="customer-edit-info-value">August 15, 2024</span>
                            </div>
                            <div class="customer-edit-info-item">
                                <label class="customer-edit-info-label">Location</label>
                                <span class="customer-edit-info-value">Olongapo City, Zambales</span>
                            </div>
                            <div class="customer-edit-info-item">
                                <label class="customer-edit-info-label">Last Login</label>
                                <span class="customer-edit-info-value">August 30, 2025 - 2:45 PM</span>
                            </div>
                        </div>
                        <div class="customer-edit-notice-box">
                            <p>
                                <i data-lucide="info"></i>
                                <strong>Note:</strong> Personal information can only be updated by the customer through their account settings. Admins can only modify account status, permissions, and business-related settings.
                            </p>
                        </div>
                    </div>

                    <!-- Admin Controls -->
                    <!-- <h4 class="customer-edit-section-header">
                        <i data-lucide="settings"></i>
                        Admin Controls
                    </h4>
                    <div class="customer-edit-form-section">
                        <div class="customer-edit-form-grid">
                            <div class="customer-edit-form-group">
                                <label class="customer-edit-form-label">Account Status</label>
                                <select class="customer-edit-form-select" name="account_status">
                                    <option value="active" selected>Active</option>
                                    <option value="suspended">Suspended</option>
                                    <option value="banned">Banned</option>
                                    <option value="under_review">Under Review</option>
                                </select>
                            </div>
                            <div class="customer-edit-form-group">
                                <label class="customer-edit-form-label">Customer Type</label>
                                <select class="customer-edit-form-select" name="customer_type">
                                    <option value="regular" selected>Regular Customer</option>
                                    <option value="vip">VIP Customer</option>
                                    <option value="wholesale">Wholesale Customer</option>
                                    <option value="corporate">Corporate Account</option>
                                </select>
                            </div>
                            <div class="customer-edit-form-group">
                                <label class="customer-edit-form-label">Credit Limit</label>
                                <input type="number" class="customer-edit-form-input" value="10000" name="credit_limit" placeholder="0">
                                <small class="customer-edit-form-help">Credit limit for wholesale/corporate accounts (₱)</small>
                            </div>
                            <div class="customer-edit-form-group">
                                <label class="customer-edit-form-label">Discount Rate</label>
                                <input type="number" class="customer-edit-form-input" value="5" name="discount_rate" min="0" max="50" step="0.1">
                                <small class="customer-edit-form-help">Special discount percentage (%)</small>
                            </div>
                            <div class="customer-edit-form-group">
                                <label class="customer-edit-form-label">Payment Terms</label>
                                <select class="customer-edit-form-select" name="payment_terms">
                                    <option value="immediate">Immediate Payment</option>
                                    <option value="net7">Net 7 Days</option>
                                    <option value="net15">Net 15 Days</option>
                                    <option value="net30" selected>Net 30 Days</option>
                                    <option value="net60">Net 60 Days</option>
                                </select>
                            </div>
                            <div class="customer-edit-form-group">
                                <label class="customer-edit-form-label">Sales Representative</label>
                                <select class="customer-edit-form-select" name="sales_rep">
                                    <option value="">No assigned rep</option>
                                    <option value="1" selected>Maria Santos</option>
                                    <option value="2">John Reyes</option>
                                    <option value="3">Ana Garcia</option>
                                </select>
                            </div>
                        </div>
                    </div> -->

                    <!-- Permissions & Restrictions -->
                    <h4 class="customer-edit-section-header">
                        <i data-lucide="shield-check"></i>
                        Permissions & Restrictions
                    </h4>
                    <div class="customer-edit-form-section">
                        <div class="customer-edit-checkbox-group">
                            <label class="customer-edit-checkbox-item">
                                <input type="checkbox" checked> Allow Bulk Orders
                            </label>
                            <label class="customer-edit-checkbox-item">
                                <input type="checkbox" checked> Allow Credit Purchases
                            </label>
                            <label class="customer-edit-checkbox-item">
                                <input type="checkbox"> Require Order Approval
                            </label>
                            <label class="customer-edit-checkbox-item">
                                <input type="checkbox"> Block New Orders
                            </label>
                            <label class="customer-edit-checkbox-item">
                                <input type="checkbox" checked> Receive Marketing Emails
                            </label>
                            <label class="customer-edit-checkbox-item">
                                <input type="checkbox" checked> Access to Wholesale Prices
                            </label>
                        </div>
                    </div>

                    <!-- Financial Summary -->
                    <h4 class="customer-edit-section-header">
                        <i data-lucide="dollar-sign"></i>
                        Financial Summary
                    </h4>
                    <div class="customer-edit-financial-summary">
                        <div class="customer-edit-financial-grid">
                            <div class="customer-edit-financial-item">
                                <label class="customer-edit-financial-label">Outstanding Balance</label>
                                <span class="customer-edit-financial-value negative">₱0.00</span>
                            </div>
                            <div class="customer-edit-financial-item">
                                <label class="customer-edit-financial-label">Available Credit</label>
                                <span class="customer-edit-financial-value positive">₱10,000.00</span>
                            </div>
                            <div class="customer-edit-financial-item">
                                <label class="customer-edit-financial-label">Total Lifetime Value</label>
                                <span class="customer-edit-financial-value primary">₱4,250.00</span>
                            </div>
                            <div class="customer-edit-financial-item">
                                <label class="customer-edit-financial-label">Last Payment</label>
                                <span class="customer-edit-financial-value">August 30, 2025</span>
                            </div>
                        </div>
                    </div>

                    <!-- Admin Notes -->
                    <h4 class="customer-edit-section-header">
                        <i data-lucide="file-text"></i>
                        Admin Notes & Actions
                    </h4>
                    <div class="customer-edit-form-section">
                        <div class="customer-edit-form-group">
                            <label class="customer-edit-form-label">Internal Notes</label>
                            <textarea class="customer-edit-form-textarea" name="admin_notes" placeholder="Add internal notes about this customer... (Not visible to customer)">Customer requested VIP status. Good payment history. Potential for bulk orders.</textarea>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="customer-edit-quick-actions">
                        <h5>
                            <i data-lucide="zap"></i>
                            Quick Actions
                        </h5>
                        <div class="customer-edit-quick-actions-grid">
                            <button type="button" class="customer-edit-btn customer-edit-btn-secondary" onclick="showCustomerEditSubModal('emailModal')">
                                <i data-lucide="mail"></i> Send Email
                            </button>
                            <button type="button" class="customer-edit-btn customer-edit-btn-secondary" id="UserOrder"onclick="openCustomerOrdersModal()">
                                <i data-lucide="clipboard-list"></i> View Orders
                            </button>
                            <button type="button" class="customer-edit-btn customer-edit-btn-secondary" onclick="showCustomerEditSubModal('reportModal')">
                                <i data-lucide="bar-chart-3"></i> Generate Report
                            </button>
                            <button type="button" class="customer-edit-btn customer-edit-btn-secondary" onclick="showCustomerEditSubModal('passwordModal')">
                                <i data-lucide="key"></i> Reset Password
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="customer-edit-modal-footer">
                <button class="customer-edit-btn customer-edit-btn-secondary" onclick="closeCustomerEditModal()">
                    <i data-lucide="x"></i> Cancel
                </button>
                <button type="button" class="customer-edit-btn customer-edit-btn-danger" onclick="showCustomerEditSubModal('deleteModal')">
                    <i data-lucide="trash-2"></i> Delete Customer
                </button>
                <button type="submit" form="editCustomerForm" class="customer-edit-btn customer-edit-btn-primary" onclick="showCustomerEditSubModal('updateModal')">
                    <i data-lucide="save"></i> Save Changes
                </button>
            </div>
        </div>
    </div>

    <!-- Email Sub-Modal -->
    <div id="emailModal" class="customer-edit-sub-modal">
        <div class="customer-edit-sub-modal-content">
            <div class="customer-edit-sub-modal-header">
                <h4><i data-lucide="mail"></i>Send Email to Customer</h4>
                <button class="customer-edit-close-btn" onclick="closeCustomerEditSubModal('emailModal')">&times;</button>
            </div>
            <div class="customer-edit-sub-modal-body">
                <form id="emailForm">
                    <div class="customer-edit-form-group">
                        <label class="customer-edit-form-label">To</label>
                        <input type="email" class="customer-edit-form-input" value="juan.delacruz@email.com" readonly>
                    </div>
                    <div class="customer-edit-form-group">
                        <label class="customer-edit-form-label">Subject</label>
                        <input type="text" class="customer-edit-form-input" placeholder="Enter email subject" required>
                    </div>
                    <div class="customer-edit-form-group">
                        <label class="customer-edit-form-label">Message</label>
                        <textarea class="customer-edit-form-textarea" placeholder="Enter your message here..." rows="5" required></textarea>
                    </div>
                </form>
            </div>
            <div class="customer-edit-sub-modal-footer">
                <button class="customer-edit-btn customer-edit-btn-secondary" onclick="closeCustomerEditSubModal('emailModal')">
                    <i data-lucide="x"></i> Cancel
                </button>
                <button type="submit" form="emailForm" class="customer-edit-btn customer-edit-btn-primary">
                    <i data-lucide="send"></i> Send Email
                </button>
            </div>
        </div>
    </div>

    <!-- Report Sub-Modal -->
    <div id="reportModal" class="customer-edit-sub-modal">
        <div class="customer-edit-sub-modal-content">
            <div class="customer-edit-sub-modal-header">
                <h4><i data-lucide="file-text"></i>Generate Customer Report</h4>
                <button class="customer-edit-close-btn" onclick="closeCustomerEditSubModal('reportModal')">&times;</button>
            </div>
            <div class="customer-edit-sub-modal-body">
                <form id="reportForm">
                    <div class="customer-edit-form-group">
                        <label class="customer-edit-form-label">Report Type</label>
                        <select class="customer-edit-form-select" required>
                            <option value="">Select Report Type</option>
                            <option value="summary">Customer Summary</option>
                            <option value="orders">Order History</option>
                            <option value="financial">Financial Report</option>
                            <option value="activity">Activity Log</option>
                        </select>
                    </div>
                    <div class="customer-edit-form-group">
                        <label class="customer-edit-form-label">Date Range</label>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem;">
                            <input type="date" class="customer-edit-form-input">
                            <input type="date" class="customer-edit-form-input">
                        </div>
                    </div>
                    <div class="customer-edit-form-group">
                        <label class="customer-edit-form-label">Format</label>
                        <select class="customer-edit-form-select" required>
                            <option value="pdf">PDF Document</option>
                            <option value="excel">Excel Spreadsheet</option>
                            <option value="csv">CSV File</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="customer-edit-sub-modal-footer">
                <button class="customer-edit-btn customer-edit-btn-secondary" onclick="closeCustomerEditSubModal('reportModal')">
                    <i data-lucide="x"></i> Cancel
                </button>
                <button type="submit" form="reportForm" class="customer-edit-btn customer-edit-btn-primary">
                    <i data-lucide="download"></i> Generate Report
                </button>
            </div>
        </div>
    </div>

    <!-- Password Reset Sub-Modal -->
    <div id="passwordModal" class="customer-edit-sub-modal">
        <div class="customer-edit-sub-modal-content">
            <div class="customer-edit-sub-modal-header">
                <h4><i data-lucide="key"></i>Reset Customer Password</h4>
                <button class="customer-edit-close-btn" onclick="closeCustomerEditSubModal('passwordModal')">&times;</button>
            </div>
            <div class="customer-edit-sub-modal-body">
                <div class="customer-edit-warning-box">
                    <p>
                        <i data-lucide="alert-triangle"></i>
                        <strong>Warning:</strong> This will invalidate the customer's current password.
                    </p>
                </div>
                <form id="passwordForm">
                    <div class="customer-edit-form-group">
                        <label class="customer-edit-form-label">Customer Email</label>
                        <input type="email" class="customer-edit-form-input" value="juan.delacruz@email.com" readonly>
                    </div>
                    <div class="customer-edit-form-group">
                        <label class="customer-edit-form-label">Reset Method</label>
                        <select class="customer-edit-form-select" required>
                            <option value="email">Send Reset Link via Email</option>
                            <option value="temporary">Generate Temporary Password</option>
                        </select>
                    </div>
                    <div class="customer-edit-form-group">
                        <label class="customer-edit-form-label">Reason for Reset</label>
                        <select class="customer-edit-form-select" required>
                            <option value="">Select Reason</option>
                            <option value="customer_request">Customer Request</option>
                            <option value="security_concern">Security Concern</option>
                            <option value="account_recovery">Account Recovery</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="customer-edit-sub-modal-footer">
                <button class="customer-edit-btn customer-edit-btn-secondary" onclick="closeCustomerEditSubModal('passwordModal')">
                    <i data-lucide="x"></i> Cancel
                </button>
                <button type="submit" form="passwordForm" class="customer-edit-btn customer-edit-btn-primary">
                    <i data-lucide="key"></i> Reset Password
                </button>
            </div>
        </div>
    </div>

    <!-- Update Confirmation Sub-Modal -->
    <div id="updateModal" class="customer-edit-sub-modal">
        <div class="customer-edit-sub-modal-content">
            <div class="customer-edit-sub-modal-header">
                <h4><i data-lucide="save"></i>Confirm Changes</h4>
                <button class="customer-edit-close-btn" onclick="closeCustomerEditSubModal('updateModal')">&times;</button>
            </div>
            <div class="customer-edit-sub-modal-body">
                <div class="customer-edit-notice-box">
                    <p>
                        <i data-lucide="info"></i>
                        Are you sure you want to save these changes to the customer profile?
                    </p>
                </div>
                <p style="color: #64748b; font-size: 0.9rem; margin-top: 1rem;">
                    This will update the customer's permissions, settings, and admin notes.
                </p>
            </div>
            <div class="customer-edit-sub-modal-footer">
                <button class="customer-edit-btn customer-edit-btn-secondary" onclick="closeCustomerEditSubModal('updateModal')">
                    <i data-lucide="x"></i> Cancel
                </button>
                <button class="customer-edit-btn customer-edit-btn-primary confirm-update-btn">
                    <i data-lucide="check"></i> Confirm & Save
                </button>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Sub-Modal -->
    <div id="deleteModal" class="customer-edit-sub-modal">
        <div class="customer-edit-sub-modal-content">
            <div class="customer-edit-sub-modal-header">
                <h4 style="color: #dc2626;"><i data-lucide="trash-2"></i>Delete Customer</h4>
                <button class="customer-edit-close-btn">&times;</button>
            </div>
            <div class="customer-edit-sub-modal-body">
                <div class="customer-edit-danger-box">
                    <p>
                        <i data-lucide="alert-triangle"></i>
                        <strong>Danger Zone:</strong> This action cannot be undone. The customer will be deactivated.
                    </p>
                </div>
                <form id="deleteForm">
                    <div class="customer-edit-form-group">
                        <label class="customer-edit-form-label">Reason for Deletion</label>
                        <select class="customer-edit-form-select" required>
                            <option value="">Select Reason</option>
                            <option value="customer_request">Customer Request (GDPR)</option>
                            <option value="duplicate_account">Duplicate Account</option>
                            <option value="fraudulent">Fraudulent Account</option>
                            <option value="inactive">Long-term Inactive</option>
                            <option value="gdpr">GDPR Compliance</option>
                        </select>
                    </div>
                    <div class="customer-edit-form-group">
                        <label class="customer-edit-form-label">Type "DELETE" to confirm</label>
                        <input type="text" class="customer-edit-form-input" placeholder="Type DELETE to confirm" required>
                    </div>
                </form>
            </div>
            <div class="customer-edit-sub-modal-footer">
                <button class="customer-edit-btn customer-edit-btn-secondary">
                    <i data-lucide="x"></i> Cancel
                </button>
                <button type="submit" name="delete_confirm" form="deleteForm" class="customer-edit-btn customer-edit-btn-danger">
                    <i data-lucide="trash-2"></i> Delete Customer
                </button>
            </div>
        </div>
    </div>
</body>
</html>
