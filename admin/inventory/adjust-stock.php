<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adjust Stock - M & E Dashboard</title>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <style>
        /* Base styles */
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

        .adjust-stock-dashboard {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar (assuming external styling or handled by admin_sidebar.php) */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 280px;
            height: 100vh;
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            color: white;
            padding: 2rem 0;
            box-shadow: 4px 0 10px rgba(30, 58, 138, 0.1);
            z-index: 1000;
            overflow-y: auto;
            transition: transform 0.3s ease;
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
        .adjust-stock-main-content {
            flex: 1;
            padding: 2rem;
            margin-left: 280px;
        }

        .adjust-stock-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            background: white;
            padding: 1.5rem 2rem;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .adjust-stock-header h2 {
            font-size: 2rem;
            font-weight: 600;
            color: #1e40af;
        }

        .adjust-stock-header-actions {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .adjust-stock-back-btn {
            background: #64748b;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .adjust-stock-back-btn:hover {
            background: #475569;
            color: white;
        }

        .adjust-stock-user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .adjust-stock-avatar {
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

        /* Form Container */
        .adjust-stock-form-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 800px;
            margin: 0 auto;
        }

        .adjust-stock-form-header {
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .adjust-stock-form-header h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .adjust-stock-form-header p {
            opacity: 0.9;
        }

        .adjust-stock-form-content {
            padding: 2rem;
        }

        .adjust-stock-form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .adjust-stock-form-group {
            margin-bottom: 1.5rem;
        }

        .adjust-stock-form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #475569;
        }

        .adjust-stock-form-input, .adjust-stock-form-select {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.2s;
        }

        .adjust-stock-form-input:focus, .adjust-stock-form-select:focus {
            outline: none;
            border-color: #1e40af;
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
        }

        .adjust-stock-current-stock-display {
            background: #f1f5f9;
            padding: 1rem;
            border-radius: 8px;
            border: 2px solid #cbd5e1;
            text-align: center;
        }

        .adjust-stock-stock-number {
            font-size: 2rem;
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 0.5rem;
        }

        .adjust-stock-stock-label {
            color: #64748b;
            font-size: 0.9rem;
        }

        .adjust-stock-adjustment-preview {
            background: #eff6ff;
            border: 2px solid #3b82f6;
            border-radius: 8px;
            padding: 1.5rem;
            margin: 1.5rem 0;
        }

        .adjust-stock-preview-title {
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 1rem;
        }

        .adjust-stock-preview-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .adjust-stock-preview-row.total {
            border-top: 2px solid #3b82f6;
            padding-top: 0.5rem;
            font-weight: 600;
            color: #1e40af;
        }

        .adjust-stock-form-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            padding-top: 2rem;
            border-top: 2px solid #e2e8f0;
        }

        .adjust-stock-btn {
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s;
            font-size: 1rem;
        }

        .adjust-stock-btn-primary {
            background: #1e40af;
            color: white;
        }

        .adjust-stock-btn-primary:hover {
            background: #1e3a8a;
            transform: translateY(-1px);
        }

        .adjust-stock-btn-secondary {
            background: #e2e8f0;
            color: #475569;
        }

        .adjust-stock-btn-secondary:hover {
            background: #cbd5e1;
        }

        .adjust-stock-alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            border-left: 4px solid;
        }

        .adjust-stock-alert-success {
            background: #ecfdf5;
            border-color: #10b981;
            color: #065f46;
        }

        .adjust-stock-alert-error {
            background: #fef2f2;
            border-color: #ef4444;
            color: #991b1b;
        }

        /* Recent Adjustments */
        .adjust-stock-recent-adjustments {
            margin-top: 2rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }

        .adjust-stock-section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 1rem;
        }

        .adjust-stock-adjustments-table {
            width: 100%;
            border-collapse: collapse;
        }

        .adjust-stock-adjustments-table th {
            background-color: #f8fafc;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #475569;
            border-bottom: 2px solid #e2e8f0;
        }

        .adjust-stock-adjustments-table td {
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .adjust-stock-adjustments-table tr:hover {
            background-color: #f8fafc;
        }

        .adjust-stock-adjustment-type {
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .adjust-stock-adjustment-type.add {
            background: #dcfce7;
            color: #166534;
        }

        .adjust-stock-adjustment-type.remove {
            background: #fee2e2;
            color: #991b1b;
        }

        .adjust-stock-adjustment-type.set {
            background: #e0e7ff;
            color: #1e40af;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: static;
                height: auto;
            }

            .adjust-stock-main-content {
                margin-left: 0;
            }

            .adjust-stock-dashboard {
                flex-direction: column;
            }

            .adjust-stock-form-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .adjust-stock-form-actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="adjust-stock-dashboard">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="logo">
                <img src="../../assets/images/logo/ME logo.png" alt="M&E Logo">

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
                    <a href="index.php" class="nav-link active">
                        <i data-lucide="clipboard-list"></i> Inventory
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../requests/index.php" class="nav-link">
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
        <main class="adjust-stock-main-content">
            <div class="adjust-stock-header">
                <h2>Adjust Stock</h2>
                <div class="adjust-stock-header-actions">
                    <a href="index.php" class="adjust-stock-back-btn">
                        <span>←</span> Back to Inventory
                    </a>
                    <div class="adjust-stock-user-info">
                        <span>Admin Panel</span>
                        <div class="adjust-stock-avatar">A</div>
                    </div>
                </div>
            </div>

            <div id="adjustStockAlertContainer"></div>

            <!-- Adjust Stock Form -->
            <div class="adjust-stock-form-container">
                <div class="adjust-stock-form-header">
                    <h3>Stock Adjustment</h3>
                    <p>Modify product stock levels with tracking and reason</p>
                </div>
                <div class="adjust-stock-form-content">
                    <form id="adjustStockForm">
                        <div class="adjust-stock-form-grid">
                            <div class="adjust-stock-form-group">
                                <label class="adjust-stock-form-label">Select Product</label>
                                <select class="adjust-stock-form-select" id="adjustStockProductSelect" required>
                                    <option value="">Choose a product...</option>
                                    <option value="1" data-stock="150" data-min="20">Ballpoint Pens (Pack of 12)</option>
                                    <option value="2" data-stock="85" data-min="30">Bond Paper (A4 Ream)</option>
                                    <option value="3" data-stock="45" data-min="15">File Folders</option>
                                    <option value="4" data-stock="12" data-min="25">Staplers</option>
                                    <option value="5" data-stock="8" data-min="20">Notebooks</option>
                                </select>
                            </div>
                            <div class="adjust-stock-form-group">
                                <label class="adjust-stock-form-label">Current Stock</label>
                                <div class="adjust-stock-current-stock-display">
                                    <div class="adjust-stock-stock-number" id="adjustStockCurrentStock">-</div>
                                    <div class="adjust-stock-stock-label">Current Quantity</div>
                                </div>
                            </div>
                        </div>

                        <div class="adjust-stock-form-grid">
                            <div class="adjust-stock-form-group">
                                <label class="adjust-stock-form-label">Adjustment Type</label>
                                <select class="adjust-stock-form-select" id="adjustStockAdjustmentType" required>
                                    <option value="">Select adjustment type...</option>
                                    <option value="add">Add Stock (+)</option>
                                    <option value="remove">Remove Stock (-)</option>
                                    <option value="set">Set Stock Level (=)</option>
                                </select>
                            </div>
                            <div class="adjust-stock-form-group">
                                <label class="adjust-stock-form-label">Quantity</label>
                                <input type="number" class="adjust-stock-form-input" id="adjustStockAdjustmentQuantity" min="1" placeholder="Enter quantity" required>
                            </div>
                        </div>

                        <div class="adjust-stock-form-group">
                            <label class="adjust-stock-form-label">Reason for Adjustment</label>
                            <input type="text" class="adjust-stock-form-input" id="adjustStockAdjustmentReason" placeholder="Enter reason for stock adjustment" required>
                        </div>

                        <div class="adjust-stock-adjustment-preview" id="adjustStockAdjustmentPreview" style="display: none;">
                            <div class="adjust-stock-preview-title">Adjustment Preview</div>
                            <div class="adjust-stock-preview-row">
                                <span>Current Stock:</span>
                                <span id="adjustStockPreviewCurrent">-</span>
                            </div>
                            <div class="adjust-stock-preview-row">
                                <span>Adjustment:</span>
                                <span id="adjustStockPreviewAdjustment">-</span>
                            </div>
                            <div class="adjust-stock-preview-row total">
                                <span>New Stock Level:</span>
                                <span id="adjustStockPreviewNew">-</span>
                            </div>
                        </div>

                        <div class="adjust-stock-form-actions">
                            <button type="button" class="adjust-stock-btn adjust-stock-btn-secondary" onclick="resetAdjustStockForm()">Reset Form</button>
                            <button type="submit" class="adjust-stock-btn adjust-stock-btn-primary">Apply Adjustment</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Recent Adjustments -->
            <div class="adjust-stock-recent-adjustments">
                <h3 class="adjust-stock-section-title">Recent Stock Adjustments</h3>
                <table class="adjust-stock-adjustments-table">
                    <thead>
                        <tr>
                            <th>Date/Time</th>
                            <th>Product</th>
                            <th>Type</th>
                            <th>Quantity</th>
                            <th>Previous</th>
                            <th>New</th>
                            <th>Reason</th>
                            <th>User</th>
                        </tr>
                    </thead>
                    <tbody id="adjustStockAdjustmentsHistory">
                        <tr>
                            <td>2024-11-15 10:30 AM</td>
                            <td>Ballpoint Pens</td>
                            <td><span class="adjust-stock-adjustment-type add">Add</span></td>
                            <td>+50</td>
                            <td>100</td>
                            <td>150</td>
                            <td>New stock delivery</td>
                            <td>Admin</td>
                        </tr>
                        <tr>
                            <td>2024-11-15 09:15 AM</td>
                            <td>Bond Paper</td>
                            <td><span class="adjust-stock-adjustment-type remove">Remove</span></td>
                            <td>-15</td>
                            <td>100</td>
                            <td>85</td>
                            <td>Damaged items</td>
                            <td>Admin</td>
                        </tr>
                        <tr>
                            <td>2024-11-14 02:45 PM</td>
                            <td>Staplers</td>
                            <td><span class="adjust-stock-adjustment-type set">Set</span></td>
                            <td>=12</td>
                            <td>8</td>
                            <td>12</td>
                            <td>Stock count correction</td>
                            <td>Admin</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script>
        lucide.createIcons();
        // Form handling and preview functionality
        document.addEventListener('DOMContentLoaded', function() {
            const productSelect = document.getElementById('adjustStockProductSelect');
            const currentStockElement = document.getElementById('adjustStockCurrentStock');
            const adjustmentType = document.getElementById('adjustStockAdjustmentType');
            const adjustmentQuantity = document.getElementById('adjustStockAdjustmentQuantity');
            const adjustmentPreview = document.getElementById('adjustStockAdjustmentPreview');
            const adjustStockForm = document.getElementById('adjustStockForm');

            // Update current stock when product is selected
            productSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const stock = selectedOption.dataset.stock;

                if (stock) {
                    currentStockElement.textContent = stock;
                    updateAdjustStockPreview();
                } else {
                    currentStockElement.textContent = '-';
                    adjustmentPreview.style.display = 'none';
                }
            });

            // Update preview when adjustment details change
            [adjustmentType, adjustmentQuantity].forEach(element => {
                element.addEventListener('input', updateAdjustStockPreview);
                element.addEventListener('change', updateAdjustStockPreview);
            });

            function updateAdjustStockPreview() {
                const selectedOption = adjustStockProductSelect.options[adjustStockProductSelect.selectedIndex];
                const currentStock = parseInt(selectedOption.dataset.stock || 0);
                const type = adjustStockAdjustmentType.value;
                const quantity = parseInt(adjustStockAdjustmentQuantity.value || 0);

                if (!type || !quantity || !currentStock) {
                    adjustStockAdjustmentPreview.style.display = 'none';
                    return;
                }

                let newStock;
                let adjustmentText;

                switch (type) {
                    case 'add':
                        newStock = currentStock + quantity;
                        adjustmentText = `+${quantity}`;
                        break;
                    case 'remove':
                        newStock = Math.max(0, currentStock - quantity);
                        adjustmentText = `-${quantity}`;
                        break;
                    case 'set':
                        newStock = quantity;
                        adjustmentText = `Set to ${quantity}`;
                        break;
                    default:
                        return;
                }

                document.getElementById('adjustStockPreviewCurrent').textContent = currentStock;
                document.getElementById('adjustStockPreviewAdjustment').textContent = adjustmentText;
                document.getElementById('adjustStockPreviewNew').textContent = newStock;

                adjustStockAdjustmentPreview.style.display = 'block';
            }

            // Form submission
            adjustStockForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = {
                    productId: productSelect.value,
                    productName: productSelect.options[productSelect.selectedIndex].text,
                    type: adjustmentType.value,
                    quantity: adjustmentQuantity.value,
                    reason: document.getElementById('adjustStockAdjustmentReason').value,
                    currentStock: productSelect.options[productSelect.selectedIndex].dataset.stock
                };

                // Simulate API call
                showAdjustStockAlert('Stock adjustment applied successfully!', 'success');

                // Add to recent adjustments table
                addAdjustStockToAdjustmentsHistory(formData);

                // Reset form
                setTimeout(() => {
                    resetAdjustStockForm();
                }, 1500);
            });
        });

        function resetAdjustStockForm() {
            document.getElementById('adjustStockForm').reset();
            document.getElementById('adjustStockCurrentStock').textContent = '-';
            document.getElementById('adjustStockAdjustmentPreview').style.display = 'none';
        }

        function showAdjustStockAlert(message, type) {
            const alertContainer = document.getElementById('adjustStockAlertContainer');
            const alertClass = type === 'success' ? 'adjust-stock-alert-success' : 'adjust-stock-alert-error';

            alertContainer.innerHTML = `
                <div class="adjust-stock-alert ${alertClass}">
                    ${message}
                </div>
            `;

            setTimeout(() => {
                alertContainer.innerHTML = '';
            }, 5000);
        }

        function addAdjustStockToAdjustmentsHistory(data) {
            const tbody = document.getElementById('adjustStockAdjustmentsHistory');
            const now = new Date();
            const formattedDate = now.toLocaleDateString() + ' ' + now.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});

            let typeSpan, quantityText;
            const currentStock = parseInt(data.currentStock);
            const quantity = parseInt(data.quantity);
            let newStock;

            switch (data.type) {
                case 'add':
                    typeSpan = '<span class="adjust-stock-adjustment-type add">Add</span>';
                    quantityText = `+${quantity}`;
                    newStock = currentStock + quantity;
                    break;
                case 'remove':
                    typeSpan = '<span class="adjust-stock-adjustment-type remove">Remove</span>';
                    quantityText = `-${quantity}`;
                    newStock = Math.max(0, currentStock - quantity);
                    break;
                case 'set':
                    typeSpan = '<span class="adjust-stock-adjustment-type set">Set</span>';
                    quantityText = `=${quantity}`;
                    newStock = quantity;
                    break;
            }

            const newRow = tbody.insertRow(0);
            newRow.innerHTML = `
                <td>${formattedDate}</td>
                <td>${data.productName}</td>
                <td>${typeSpan}</td>
                <td>${quantityText}</td>
                <td>${currentStock}</td>
                <td>${newStock}</td>
                <td>${data.reason}</td>
                <td>Admin</td>
            `;
        }
    </script>
</body>
</html>
