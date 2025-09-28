<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Edit Modal</title>
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
            padding: 2rem;
        }
        /* Modal Styles */
        .modal {
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

        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-content {
            background: white;
            border-radius: 16px;
            width: 100%;
            max-width: 1000px;
            max-height: 90vh;
            overflow: hidden;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);
            animation: slideIn 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        @keyframes slideIn {
            from { transform: translateY(-30px) scale(0.95); opacity: 0; }
            to { transform: translateY(0) scale(1); opacity: 1; }
        }

        /* Modal Header */
        .modal-header {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #e2e8f0;
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink: 0;
        }

        .modal-title {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .customer-avatar-large {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.3rem;
        }

        .modal-title h3 {
            font-size: 1.4rem;
            font-weight: 600;
            margin: 0;
        }

        .modal-title p {
            opacity: 0.9;
            font-size: 0.9rem;
            margin: 0;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: white;
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.2s ease;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .close-btn:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        /* Modal Body */
        .modal-body {
            flex: 1;
            overflow-y: auto;
            padding: 2rem;
        }

        /* Customer Stats */
        .customer-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: #f8fafc;
            border-radius: 12px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-value {
            font-size: 1.3rem;
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.8rem;
            color: #64748b;
            font-weight: 500;
        }

        /* Section Headers */
        .section-header {
            margin: 2rem 0 1rem;
            color: #1e40af;
            font-size: 1.1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .section-header:first-child {
            margin-top: 0;
        }

        .section-header .lucide {
            width: 20px;
            height: 20px;
        }

        /* Form Sections */
        .form-section {
            background: #f8fafc;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-label {
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .form-input, .form-select, .form-textarea {
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 0.9rem;
            transition: border-color 0.2s ease;
            background: white;
        }

        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: #1e40af;
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
        }

        .form-textarea {
            resize: vertical;
            min-height: 100px;
            font-family: inherit;
        }

        .form-help {
            color: #64748b;
            font-size: 0.8rem;
            margin-top: 0.25rem;
        }

        /* Info Display */
        .info-display {
            background: #f8fafc;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            color: #64748b;
            font-size: 0.8rem;
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .info-value {
            color: #1e293b;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .notice-box {
            margin-top: 1rem;
            padding: 1rem;
            background: white;
            border-radius: 6px;
            border-left: 4px solid #fbbf24;
        }

        .notice-box p {
            color: #92400e;
            font-size: 0.9rem;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .notice-box .lucide {
            width: 14px;
            height: 14px;
        }

        /* Checkbox Group */
        .checkbox-group {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem;
            border-radius: 6px;
            transition: background-color 0.2s ease;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .checkbox-item:hover {
            background-color: #f1f5f9;
        }

        .checkbox-item input[type="checkbox"] {
            margin: 0;
            width: 16px;
            height: 16px;
            accent-color: #1e40af;
        }

        /* Financial Summary */
        .financial-summary {
            background: #f8fafc;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 2rem;
        }

        .financial-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
        }

        .financial-item {
            display: flex;
            flex-direction: column;
        }

        .financial-label {
            color: #64748b;
            font-size: 0.8rem;
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .financial-value {
            font-weight: 700;
            font-size: 1rem;
        }

        .financial-value.positive { color: #059669; }
        .financial-value.negative { color: #dc2626; }
        .financial-value.primary { color: #1e40af; }

        /* Quick Actions */
        .quick-actions {
            background: #f8fafc;
            padding: 1.5rem;
            border-radius: 8px;
            margin-top: 2rem;
        }

        .quick-actions h5 {
            margin-bottom: 1rem;
            color: #1e40af;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1rem;
        }

        .quick-actions .lucide {
            width: 18px;
            height: 18px;
        }

        .quick-actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem;
        }

        /* Modal Footer */
        .modal-footer {
            padding: 1.5rem 2rem;
            border-top: 1px solid #e2e8f0;
            background: #f8fafc;
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            flex-shrink: 0;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn .lucide {
            width: 16px;
            height: 16px;
        }

        .btn-primary {
            background-color: #1e40af;
            color: white;
        }

        .btn-primary:hover {
            background-color: #1e3a8a;
        }

        .btn-secondary {
            background-color: #64748b;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #475569;
        }

        .btn-danger {
            background-color: #dc2626;
            color: white;
        }

        .btn-danger:hover {
            background-color: #b91c1c;
        }

        /* Sub-modals */
        .sub-modal {
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

        .sub-modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .sub-modal-content {
            background: white;
            border-radius: 12px;
            width: 100%;
            max-width: 500px;
            max-height: 80vh;
            overflow-y: auto;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3);
        }

        .sub-modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .sub-modal-header h4 {
            color: #1e40af;
            font-size: 1.1rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .sub-modal-body {
            padding: 1.5rem;
        }

        .sub-modal-footer {
            padding: 1.5rem;
            border-top: 1px solid #e2e8f0;
            background: #f8fafc;
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
        }

        .warning-box {
            padding: 1rem;
            background: #fef3c7;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            border-left: 4px solid #f59e0b;
        }

        .warning-box p {
            color: #92400e;
            margin: 0;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .danger-box {
            padding: 1rem;
            background: #fee2e2;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            border-left: 4px solid #dc2626;
        }

        .danger-box p {
            color: #dc2626;
            margin: 0;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .modal-content {
                max-width: 95vw;
                margin: 0.5rem;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .customer-stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .checkbox-group {
                grid-template-columns: 1fr;
            }

            .quick-actions-grid {
                grid-template-columns: 1fr;
            }

            .modal-footer {
                flex-direction: column-reverse;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .customer-stats {
                grid-template-columns: 1fr;
            }

            .financial-grid {
                grid-template-columns: 1fr;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <!-- Customer Edit Modal -->
    <div id="customerEditModal" class="modal" onclick="closeModal(event)">
        <div class="modal-content" onclick="event.stopPropagation()">
            <div class="modal-header">
                <div class="modal-title">
                    <div class="customer-avatar-large">JD</div>
                    <div>
                        <h3>Edit Customer - Juan Dela Cruz</h3>
                        <p>Customer ID: <span id="customerID">#CUS-001</span>
                        </p>
                    </div>
                </div>
                <button class="close-btn" onclick="closeCustomerEditModal()">&times;</button>
            </div>

            <div class="modal-body">
                <form id="editCustomerForm">
                    <!-- Customer Stats -->
                    <div class="customer-stats">
                        <div class="stat-item">
                            <div class="stat-value">8</div>
                            <div class="stat-label">Total Orders</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">₱4,250</div>
                            <div class="stat-label">Total Spent</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">Aug 2024</div>
                            <div class="stat-label">Member Since</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">2 days ago</div>
                            <div class="stat-label">Last Order</div>
                        </div>
                    </div>

                    <!-- Customer Information (Read-Only) -->
                    <h4 class="section-header">
                        <i data-lucide="user"></i>
                        Customer Information
                    </h4>
                    <div class="info-display">
                        <div class="info-grid">
                            <div class="info-item">
                                <label class="info-label">Full Name</label>
                                <span class="info-value">Juan Dela Cruz</span>
                            </div>
                            <div class="info-item">
                                <label class="info-label">Email Address</label>
                                <span class="info-value">juan.delacruz@email.com</span>
                            </div>
                            <div class="info-item">
                                <label class="info-label">Phone Number</label>
                                <span class="info-value">+63 917 123 4567</span>
                            </div>
                            <div class="info-item">
                                <label class="info-label">Registration Date</label>
                                <span class="info-value">August 15, 2024</span>
                            </div>
                            <div class="info-item">
                                <label class="info-label">Location</label>
                                <span class="info-value">Olongapo City, Zambales</span>
                            </div>
                            <div class="info-item">
                                <label class="info-label">Last Login</label>
                                <span class="info-value">August 30, 2025 - 2:45 PM</span>
                            </div>
                        </div>
                        <div class="notice-box">
                            <p>
                                <i data-lucide="info"></i>
                                <strong>Note:</strong> Personal information can only be updated by the customer through their account settings. Admins can only modify account status, permissions, and business-related settings.
                            </p>
                        </div>
                    </div>

                    <!-- Admin Controls -->
                    <h4 class="section-header">
                        <i data-lucide="settings"></i>
                        Admin Controls
                    </h4>
                    <div class="form-section">
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Account Status</label>
                                <select class="form-select" name="account_status">
                                    <option value="active" selected>Active</option>
                                    <option value="suspended">Suspended</option>
                                    <option value="banned">Banned</option>
                                    <option value="under_review">Under Review</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Customer Type</label>
                                <select class="form-select" name="customer_type">
                                    <option value="regular" selected>Regular Customer</option>
                                    <option value="vip">VIP Customer</option>
                                    <option value="wholesale">Wholesale Customer</option>
                                    <option value="corporate">Corporate Account</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Credit Limit</label>
                                <input type="number" class="form-input" value="10000" name="credit_limit" placeholder="0">
                                <small class="form-help">Credit limit for wholesale/corporate accounts (₱)</small>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Discount Rate</label>
                                <input type="number" class="form-input" value="5" name="discount_rate" min="0" max="50" step="0.1">
                                <small class="form-help">Special discount percentage (%)</small>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Payment Terms</label>
                                <select class="form-select" name="payment_terms">
                                    <option value="immediate">Immediate Payment</option>
                                    <option value="net7">Net 7 Days</option>
                                    <option value="net15">Net 15 Days</option>
                                    <option value="net30" selected>Net 30 Days</option>
                                    <option value="net60">Net 60 Days</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Sales Representative</label>
                                <select class="form-select" name="sales_rep">
                                    <option value="">No assigned rep</option>
                                    <option value="1" selected>Maria Santos</option>
                                    <option value="2">John Reyes</option>
                                    <option value="3">Ana Garcia</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Permissions & Restrictions -->
                    <h4 class="section-header">
                        <i data-lucide="shield-check"></i>
                        Permissions & Restrictions
                    </h4>
                    <div class="form-section">
                        <div class="checkbox-group">
                            <label class="checkbox-item">
                                <input type="checkbox" checked> Allow Bulk Orders
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" checked> Allow Credit Purchases
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox"> Require Order Approval
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox"> Block New Orders
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" checked> Receive Marketing Emails
                            </label>
                            <label class="checkbox-item">
                                <input type="checkbox" checked> Access to Wholesale Prices
                            </label>
                        </div>
                    </div>

                    <!-- Financial Summary -->
                    <h4 class="section-header">
                        <i data-lucide="dollar-sign"></i>
                        Financial Summary
                    </h4>
                    <div class="financial-summary">
                        <div class="financial-grid">
                            <div class="financial-item">
                                <label class="financial-label">Outstanding Balance</label>
                                <span class="financial-value negative">₱0.00</span>
                            </div>
                            <div class="financial-item">
                                <label class="financial-label">Available Credit</label>
                                <span class="financial-value positive">₱10,000.00</span>
                            </div>
                            <div class="financial-item">
                                <label class="financial-label">Total Lifetime Value</label>
                                <span class="financial-value primary">₱4,250.00</span>
                            </div>
                            <div class="financial-item">
                                <label class="financial-label">Last Payment</label>
                                <span class="financial-value">August 30, 2025</span>
                            </div>
                        </div>
                    </div>

                    <!-- Admin Notes -->
                    <h4 class="section-header">
                        <i data-lucide="file-text"></i>
                        Admin Notes & Actions
                    </h4>
                    <div class="form-section">
                        <div class="form-group">
                            <label class="form-label">Internal Notes</label>
                            <textarea class="form-textarea" name="admin_notes" placeholder="Add internal notes about this customer... (Not visible to customer)">Customer requested VIP status. Good payment history. Potential for bulk orders.</textarea>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="quick-actions">
                        <h5>
                            <i data-lucide="zap"></i>
                            Quick Actions
                        </h5>
                        <div class="quick-actions-grid">
                            <button type="button" class="btn btn-secondary" onclick="showSubModal('emailModal')">
                                <i data-lucide="mail"></i> Send Email
                            </button>
                            <button type="button" class="btn btn-secondary">
                                <i data-lucide="clipboard-list"></i> View Orders
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="showSubModal('reportModal')">
                                <i data-lucide="bar-chart-3"></i> Generate Report
                            </button>
                            <button type="button" class="btn btn-secondary" onclick="showSubModal('passwordModal')">
                                <i data-lucide="key"></i> Reset Password
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeModal()">
                    <i data-lucide="x"></i> Cancel
                </button>
                <button type="button" class="btn btn-danger" onclick="showSubModal('deleteModal')">
                    <i data-lucide="trash-2"></i> Delete Customer
                </button>
                <button type="submit" form="editCustomerForm" class="btn btn-primary">
                    <i data-lucide="save"></i> Save Changes
                </button>
            </div>
        </div>
    </div>

    <!-- Email Sub-Modal -->
    <div id="emailModal" class="sub-modal">
        <div class="sub-modal-content">
            <div class="sub-modal-header">
                <h4><i data-lucide="mail"></i>Send Email to Customer</h4>
                <button class="close-btn" onclick="closeSubModal('emailModal')">&times;</button>
            </div>
            <div class="sub-modal-body">
                <form id="emailForm">
                    <div class="form-group">
                        <label class="form-label">To</label>
                        <input type="email" class="form-input" value="juan.delacruz@email.com" readonly>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Subject</label>
                        <input type="text" class="form-input" placeholder="Enter email subject" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Message</label>
                        <textarea class="form-textarea" placeholder="Enter your message here..." rows="5" required></textarea>
                    </div>
                </form>
            </div>
            <div class="sub-modal-footer">
                <button class="btn btn-secondary" onclick="closeSubModal('emailModal')">
                    <i data-lucide="x"></i> Cancel
                </button>
                <button type="submit" form="emailForm" class="btn btn-primary">
                    <i data-lucide="send"></i> Send Email
                </button>
            </div>
        </div>
    </div>

    <!-- Report Sub-Modal -->
    <div id="reportModal" class="sub-modal">
        <div class="sub-modal-content">
            <div class="sub-modal-header">
                <h4><i data-lucide="file-text"></i>Generate Customer Report</h4>
                <button class="close-btn" onclick="closeSubModal('reportModal')">&times;</button>
            </div>
            <div class="sub-modal-body">
                <form id="reportForm">
                    <div class="form-group">
                        <label class="form-label">Report Type</label>
                        <select class="form-select" required>
                            <option value="">Select Report Type</option>
                            <option value="summary">Customer Summary</option>
                            <option value="orders">Order History</option>
                            <option value="financial">Financial Report</option>
                            <option value="activity">Activity Log</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Date Range</label>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem;">
                            <input type="date" class="form-input">
                            <input type="date" class="form-input">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Format</label>
                        <select class="form-select" required>
                            <option value="pdf">PDF Document</option>
                            <option value="excel">Excel Spreadsheet</option>
                            <option value="csv">CSV File</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="sub-modal-footer">
                <button class="btn btn-secondary" onclick="closeSubModal('reportModal')">
                    <i data-lucide="x"></i> Cancel
                </button>
                <button type="submit" form="reportForm" class="btn btn-primary">
                    <i data-lucide="download"></i> Generate Report
                </button>
            </div>
        </div>
    </div>

    <!-- Password Reset Sub-Modal -->
    <div id="passwordModal" class="sub-modal">
        <div class="sub-modal-content">
            <div class="sub-modal-header">
                <h4><i data-lucide="key"></i>Reset Customer Password</h4>
                <button class="close-btn" onclick="closeSubModal('passwordModal')">&times;</button>
            </div>
            <div class="sub-modal-body">
                <div class="warning-box">
                    <p>
                        <i data-lucide="alert-triangle"></i>
                        <strong>Warning:</strong> This will invalidate the customer's current password.
                    </p>
                </div>
                <form id="passwordForm">
                    <div class="form-group">
                        <label class="form-label">Customer Email</label>
                        <input type="email" class="form-input" value="juan.delacruz@email.com" readonly>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Reset Method</label>
                        <select class="form-select" required>
                            <option value="email">Send Reset Link via Email</option>
                            <option value="temporary">Generate Temporary Password</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Reason for Reset</label>
                        <select class="form-select" required>
                            <option value="">Select Reason</option>
                            <option value="customer_request">Customer Request</option>
                            <option value="security_concern">Security Concern</option>
                            <option value="account_recovery">Account Recovery</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="sub-modal-footer">
                <button class="btn btn-secondary" onclick="closeSubModal('passwordModal')">
                    <i data-lucide="x"></i> Cancel
                </button>
                <button type="submit" form="passwordForm" class="btn btn-primary">
                    <i data-lucide="key"></i> Reset Password
                </button>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Sub-Modal -->
    <div id="deleteModal" class="sub-modal">
        <div class="sub-modal-content">
            <div class="sub-modal-header">
                <h4 style="color: #dc2626;"><i data-lucide="trash-2"></i>Delete Customer</h4>
                <button class="close-btn" onclick="closeSubModal('deleteModal')">&times;</button>
            </div>
            <div class="sub-modal-body">
                <div class="danger-box">
                    <p>
                        <i data-lucide="alert-triangle"></i>
                        <strong>Danger Zone:</strong> This action cannot be undone. All customer data will be permanently deleted.
                    </p>
                </div>
                <form id="deleteForm">
                    <div class="form-group">
                        <label class="form-label">Reason for Deletion</label>
                        <select class="form-select" required>
                            <option value="">Select Reason</option>
                            <option value="customer_request">Customer Request (GDPR)</option>
                            <option value="duplicate_account">Duplicate Account</option>
                            <option value="fraudulent">Fraudulent Account</option>
                            <option value="inactive">Long-term Inactive</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Type "DELETE" to confirm</label>
                        <input type="text" class="form-input" placeholder="Type DELETE to confirm" required>
                    </div>
                </form>
            </div>
            <div class="sub-modal-footer">
                <button class="btn btn-secondary" onclick="closeSubModal('deleteModal')">
                    <i data-lucide="x"></i> Cancel
                </button>
                <button type="submit" form="deleteForm" class="btn btn-danger">
                    <i data-lucide="trash-2"></i> Delete Customer
                </button>
            </div>
        </div>
    </div>
</body>
</html>
