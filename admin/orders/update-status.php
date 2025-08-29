<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Order Status - M & E Dashboard</title>
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

        .dashboard {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
            color: white;
            padding: 2rem 0;
            box-shadow: 4px 0 10px rgba(30, 58, 138, 0.1);
        }

        .logo {
            padding: 0 2rem 2rem;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 2rem;
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

        .nav-link i {
            margin-right: 1rem;
            width: 20px;
            font-size: 1.2rem;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 2rem;
            max-width: 800px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .back-btn {
            padding: 0.5rem 1rem;
            background-color: #64748b;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .back-btn:hover {
            background-color: #475569;
        }

        .header h2 {
            font-size: 2rem;
            font-weight: 600;
            color: #1e40af;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .avatar {
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

        /* Form Styles */
        .form-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }

        .form-section {
            margin-bottom: 2rem;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .current-info {
            background-color: #f8fafc;
            padding: 1.5rem;
            border-radius: 8px;
            border-left: 4px solid #1e40af;
            margin-bottom: 2rem;
        }

        .current-info h4 {
            color: #475569;
            margin-bottom: 1rem;
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
            font-size: 0.8rem;
            color: #64748b;
            margin-bottom: 0.25rem;
            text-transform: uppercase;
            font-weight: 600;
        }

        .info-value {
            font-size: 1rem;
            font-weight: 500;
        }

        .status {
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            display: inline-block;
        }

        .status.pending { background-color: #fef3c7; color: #92400e; }
        .status.processing { background-color: #dbeafe; color: #1d4ed8; }
        .status.delivered { background-color: #d1fae5; color: #065f46; }
        .status.shipped { background-color: #e0e7ff; color: #3730a3; }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #374151;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.2s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: #1e40af;
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
        }

        .status-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 1rem;
            margin-top: 0.5rem;
        }

        .status-option {
            display: flex;
            align-items: center;
            padding: 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .status-option:hover {
            border-color: #1e40af;
        }

        .status-option.selected {
            border-color: #1e40af;
            background-color: #eff6ff;
        }

        .status-option input[type="radio"] {
            margin-right: 0.5rem;
        }

        .status-preview {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            justify-content: flex-end;
        }

        .action-btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            transition: all 0.2s ease;
            font-size: 1rem;
        }

        .action-btn.primary {
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            color: white;
        }

        .action-btn.primary:hover {
            transform: translateY(-1px);
        }

        .action-btn.secondary {
            background-color: #64748b;
            color: white;
        }

        .action-btn.secondary:hover {
            background-color: #475569;
        }

        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            display: none;
        }

        .alert.success {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #34d399;
        }

        .alert.error {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #f87171;
        }

        @media (max-width: 768px) {
            .dashboard {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
            }

            .status-options {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <nav class="sidebar">
            <div class="logo">
                <h1>M & E</h1>
                <p>Supply Management</p>
            </div>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="../index.php" class="nav-link">
                        <i>📊</i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./index.php" class="nav-link active">
                        <i>📦</i> Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../products/index.php" class="nav-link">
                        <i>🛍️</i> Products
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../users/index.php" class="nav-link">
                        <i>👥</i> Customers
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../inventory/index.php" class="nav-link">
                        <i>📋</i> Inventory
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../requests/index.php" class="nav-link">
                        <i>💬</i> Messages
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../settings/index.php" class="nav-link">
                        <i>⚙️</i> Settings
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="main-content">
            <div class="header">
                <div class="header-left">
                    <a href="./index.php" class="back-btn">← Back to Orders</a>
                    <h2>Update Order Status</h2>
                </div>
                <div class="user-info">
                    <span>Elbar Como</span>
                    <div class="avatar">E</div>
                </div>
            </div>

            <div class="form-container">
                <div id="alert" class="alert"></div>

                <!-- Current Order Information -->
                <div class="form-section">
                    <h3 class="section-title">
                        <span>📋</span> Current Order Information
                    </h3>

                    <div class="current-info">
                        <h4>Order #ORD-001</h4>
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="info-label">Customer</span>
                                <span class="info-value">Cjay Gonzales</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Amount</span>
                                <span class="info-value">₱1,250</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Current Status</span>
                                <span class="status processing">Processing</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Last Updated</span>
                                <span class="info-value">August 21, 2025 - 9:00 AM</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Update Form -->
                <form id="updateStatusForm">
                    <div class="form-section">
                        <h3 class="section-title">
                            <span>🔄</span> Update Status
                        </h3>

                        <div class="form-group">
                            <label class="form-label">Select New Status</label>
                            <div class="status-options">
                                <div class="status-option" data-status="pending">
                                    <input type="radio" name="orderStatus" value="pending" id="pending">
                                    <label for="pending">
                                        <div class="status-preview">
                                            <span class="status pending">Pending</span>
                                        </div>
                                    </label>
                                </div>
                                <div class="status-option selected" data-status="processing">
                                    <input type="radio" name="orderStatus" value="processing" id="processing" checked>
                                    <label for="processing">
                                        <div class="status-preview">
                                            <span class="status processing">Processing</span>
                                        </div>
                                    </label>
                                </div>
                                <div class="status-option" data-status="shipped">
                                    <input type="radio" name="orderStatus" value="shipped" id="shipped">
                                    <label for="shipped">
                                        <div class="status-preview">
                                            <span class="status shipped">Shipped</span>
                                        </div>
                                    </label>
                                </div>
                                <div class="status-option" data-status="delivered">
                                    <input type="radio" name="orderStatus" value="delivered" id="delivered">
                                    <label for="delivered">
                                        <div class="status-preview">
                                            <span class="status delivered">Delivered</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="trackingNumber" class="form-label">Tracking Number (Optional)</label>
                            <input type="text" id="trackingNumber" class="form-control" placeholder="ME-TRK-2025-XXX" value="ME-TRK-2025-001">
                        </div>

                        <div class="form-group">
                            <label for="estimatedDelivery" class="form-label">Estimated Delivery Date</label>
                            <input type="date" id="estimatedDelivery" class="form-control" value="2025-08-22">
                        </div>

                        <div class="form-group">
                            <label for="statusNotes" class="form-label">Status Update Notes</label>
                            <textarea id="statusNotes" class="form-control" rows="4" placeholder="Add any notes about this status update...">Items are being prepared for shipping. Customer will receive tracking information within 24 hours.</textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <input type="checkbox" id="notifyCustomer" checked style="margin-right: 0.5rem;">
                                Send notification to customer
                            </label>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <a href="./index.php" class="action-btn secondary">Cancel</a>
                        <button type="submit" class="action-btn primary">Update Status</button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>

        document.querySelectorAll('.status-option').forEach(option => {
            option.addEventListener('click', function() {
                document.querySelectorAll('.status-option').forEach(opt => opt.classList.remove('selected'));
                this.classList.add('selected');
                this.querySelector('input[type="radio"]').checked = true;
            });
        });

        // Handle form submission
        document.getElementById('updateStatusForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const status = formData.get('orderStatus');
            const trackingNumber = document.getElementById('trackingNumber').value;
            const estimatedDelivery = document.getElementById('estimatedDelivery').value;
            const notes = document.getElementById('statusNotes').value;
            const notifyCustomer = document.getElementById('notifyCustomer').checked;

            // Show loading state
            const submitBtn = document.querySelector('.action-btn.primary');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Updating...';
            submitBtn.disabled = true;

            // Simulate API call
            setTimeout(() => {
                // Reset button
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;

                // Show success message
                showAlert('Status updated successfully!', 'success');

                // Redirect after a short delay
                setTimeout(() => {
                    window.location.href = './index.php';
                }, 1500);
            }, 1000);
        });

        function showAlert(message, type) {
            const alert = document.getElementById('alert');
            alert.textContent = message;
            alert.className = `alert ${type}`;
            alert.style.display = 'block';

            setTimeout(() => {
                alert.style.display = 'none';
            }, 3000);
        }


        const urlParams = new URLSearchParams(window.location.search);
        const orderId = urlParams.get('id');

        if (orderId) {
            document.title = `Update Status - Order #ORD-${orderId} - M & E Dashboard`;


            const orderData = {
                '001': { customer: 'Cjay Gonzales', amount: '₱1,250', status: 'processing' },
                '002': { customer: 'Joshua Lapitan', amount: '₱890', status: 'shipped' },
                '003': { customer: 'Prince Ace Masinsin', amount: '₱675', status: 'delivered' },
                '004': { customer: 'Gillian Lorenzo', amount: '₱1,420', status: 'pending' }
            };

            if (orderData[orderId]) {
                const data = orderData[orderId];
                document.querySelector('.current-info h4').textContent = `Order #ORD-${orderId}`;
                document.querySelector('.info-value').textContent = data.customer;
                document.querySelectorAll('.info-value')[1].textContent = data.amount;


                document.querySelectorAll('input[name="orderStatus"]').forEach(radio => {
                    if (radio.value === data.status) {
                        radio.checked = true;
                        radio.closest('.status-option').classList.add('selected');
                    } else {
                        radio.closest('.status-option').classList.remove('selected');
                    }
                });
            }
        }
    </script>
</body>
</html>
