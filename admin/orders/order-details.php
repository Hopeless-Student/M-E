<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details Modal</title>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <style>
        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            padding: 1rem;
            backdrop-filter: blur(4px);
        }

        .modal-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            max-width: 750px;
            width: 100%;
            max-height: 80vh;
            overflow: hidden;
            position: relative;
            animation: modalSlideIn 0.3s ease-out;
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(20px);
            }
            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 1.25rem;
            background: #0f172a;
            color: white;
        }

        .modal-title {
            font-size: 1.1rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .close-btn {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }

        .close-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .modal-body {
            max-height: calc(80vh - 120px);
            overflow-y: auto;
            padding: 1.25rem;
        }

        .order-details-container {
            display: grid;
            grid-template-columns: 1.6fr 1fr;
            gap: 1.25rem;
        }

        .card {
            background: #f9fafb;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            padding: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .card-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .section-title {
            margin: 1rem 0 0.5rem 0;
            color: #475569;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .order-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-label {
            font-size: 0.65rem;
            color: #6b7280;
            margin-bottom: 0.2rem;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .info-value {
            font-size: 0.8rem;
            font-weight: 500;
            color: #1f2937;
        }

        .info-value.amount {
            font-size: 1rem;
            font-weight: 700;
            color: #1e40af;
        }

        .status {
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            display: inline-block;
            width: fit-content;
        }

        .category-badge {
            padding: 0.25rem 0.5rem;
            background-color: #e0e7ff;
            color: #1e40af;
            border-radius: 4px;
            font-size: 0.75rem;
            display: inline-block;
            width: fit-content;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0.75rem;
            background: white;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .items-table th {
            background-color: #f8fafc;
            padding: 0.5rem;
            text-align: left;
            font-weight: 600;
            color: #475569;
            font-size: 0.75rem;
            border-bottom: 2px solid #e2e8f0;
        }

        .items-table td {
            padding: 0.5rem;
            border-bottom: 1px solid #e2e8f0;
            font-size: 0.8rem;
        }

        .items-table tr:hover {
            background-color: #f8fafc;
        }

        .order-timeline {
            margin-top: 1rem;
        }

        .timeline-item {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
            padding: 0.5rem;
            background-color: white;
            border-radius: 6px;
            border-left: 3px solid #1e40af;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .timeline-date {
            font-size: 0.7rem;
            color: #6b7280;
            min-width: 85px;
            font-weight: 500;
        }

        .timeline-status {
            font-weight: 600;
            margin-left: 0.5rem;
            color: #1f2937;
            font-size: 0.75rem;
        }

        .notes-section {
            margin-top: 1rem;
        }

        .notes-textarea {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            resize: vertical;
            min-height: 50px;
            font-family: inherit;
            background: white;
            font-size: 0.8rem;
        }

        .notes-textarea:focus {
            outline: none;
            border-color: #1e40af;
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
        }

        .modal-footer {
            padding: 1rem 1.5rem;
            background-color: #f9fafb;
            border-top: 1px solid #e5e7eb;
            display: flex;
            gap: 0.75rem;
            justify-content: flex-end;
        }

        .action-btn-s {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.6rem 1rem;
            border: none;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            min-width: 120px;
        }

        .action-btn-s.primary-s {
            background-color: #1e40af;
            color: white;
        }

        .action-btn-s.primary-s:hover {
            background-color: #1d4ed8;
            transform: translateY(-1px);
        }

        .action-btn-s.secondary-s {
            background-color: #6b7280;
            color: white;
        }

        .action-btn-s.secondary-s:hover {
            background-color: #4b5563;
            transform: translateY(-1px);
        }

        .action-btn-s.danger-s {
            background-color: #dc2626;
            color: white;
        }

        .action-btn-s.danger-s:hover {
            background-color: #b91c1c;
            transform: translateY(-1px);
        }

        .action-btn-s i {
            width: 16px;
            height: 16px;
        }

        @media (max-width: 768px) {
            .modal-container {
                max-width: 95vw;
                margin: 0.5rem;
            }

            .order-details-container {
                grid-template-columns: 1fr;
            }

            .modal-footer {
                flex-direction: column;
            }

            .order-info {
                grid-template-columns: 1fr;
            }

            .action-btn-s {
                min-width: auto;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Order Details Modal -->
    <div class="modal-overlay" id="orderModal" onclick="closeModal(event)">
        <div class="modal-container" onclick="event.stopPropagation()">
            <!-- Modal Header -->
            <div class="modal-header">
                <h2 class="modal-title">
                    <i data-lucide="clipboard-check"></i>
                    Order Details - <span id="modalOrderId">#ORD-001</span>
                </h2>
                <button class="close-btn" onclick="closeModal()">
                    <i data-lucide="x"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <div class="order-details-container">
                    <!-- Main Order Details -->
                    <div class="main-details">
                        <div class="card">
                            <h3 class="card-title">
                                <i data-lucide="clipboard"></i>
                                Order Information
                            </h3>

                            <div class="order-info">
                                <div class="info-item">
                                    <span class="info-label">Order ID</span>
                                    <span class="info-value" id="detailOrderId">#ORD-001</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Customer</span>
                                    <span class="info-value" id="detailCustomer">Carmen Lopez</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Category</span>
                                    <span class="category-badge" id="detailCategory">Electronics</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Total Amount</span>
                                    <span class="info-value amount" id="detailAmount">₱1,521</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Order Date</span>
                                    <span class="info-value" id="detailDate">Sept 20, 2025</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Status</span>
                                    <span class="status" id="detailStatus" style="background: #fef3c7; color: #92400e;">PENDING</span>
                                </div>
                            </div>

                            <!-- Order Items -->
                            <h4 class="section-title">Order Items</h4>
                            <div class="items-container">
                                <table class="items-table">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody id="orderItems">
                                        <tr>
                                            <td>Wireless Headphones</td>
                                            <td>2</td>
                                            <td>₱500</td>
                                            <td>₱1,000</td>
                                        </tr>
                                        <tr>
                                            <td>Phone Case</td>
                                            <td>1</td>
                                            <td>₱521</td>
                                            <td>₱521</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Order Timeline -->
                            <div class="order-timeline">
                                <h4 class="section-title">Order Timeline</h4>
                                <div id="orderTimeline">
                                    <div class="timeline-item">
                                        <div class="timeline-date">Sept 20, 2025</div>
                                        <div class="timeline-status">Order Placed</div>
                                    </div>
                                    <div class="timeline-item">
                                        <div class="timeline-date">Sept 20, 2025</div>
                                        <div class="timeline-status">Payment Confirmed</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Notes Section -->
                            <div class="notes-section">
                                <h4 class="section-title">Order Notes</h4>
                                <textarea class="notes-textarea" id="orderNotes" readonly>Please handle with care - fragile items included.</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Information -->
                    <div class="customer-details">
                        <div class="card">
                            <h3 class="card-title">
                                <i data-lucide="user"></i>
                                Customer Information
                            </h3>

                            <div class="info-item">
                                <span class="info-label">Customer Name</span>
                                <span class="info-value" id="customerName">Carmen Lopez</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Email</span>
                                <span class="info-value" id="customerEmail">carmen@example.com</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Phone</span>
                                <span class="info-value" id="customerPhone">+63 917 123 4567</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Company</span>
                                <span class="info-value" id="customerCompany">Tech Solutions Inc.</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Customer Since</span>
                                <span class="info-value" id="customerSince">Jan 2024</span>
                            </div>
                        </div>

                        <div class="card">
                            <h3 class="card-title">
                                <i data-lucide="map-pin"></i>
                                Delivery Information
                            </h3>

                            <div class="info-item">
                                <span class="info-label">Delivery Address</span>
                                <span class="info-value" id="deliveryAddress">
                                    123 Main St, Barangay Centro, Pasay City, Metro Manila 1300
                                </span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Delivery Method</span>
                                <span class="info-value" id="deliveryMethod">Standard Delivery</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Expected Delivery</span>
                                <span class="info-value" id="expectedDelivery">Sept 25, 2025</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Tracking Number</span>
                                <span class="info-value" id="trackingNumber">ME-TRK-2025-001</span>
                            </div>
                        </div>

                        <div class="card">
                            <h3 class="card-title">
                                <i data-lucide="credit-card"></i>
                                Payment Information
                            </h3>

                            <div class="info-item">
                                <span class="info-label">Payment Method</span>
                                <span class="info-value" id="paymentMethod">Credit Card</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Payment Status</span>
                                <span class="status" id="paymentStatus" style="background: #dcfce7; color: #166534;">PAID</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Transaction ID</span>
                                <span class="info-value" id="transactionId">TXN-2025092001</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Payment Date</span>
                                <span class="info-value" id="paymentDate">Sept 20, 2025</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button class="action-btn-s primary-s" id="updateModalBtn">
                    <i data-lucide="check-circle"></i>
                    Update Status
                </button>
                <button class="action-btn-s secondary-s" onclick="printInvoice()">
                    <i data-lucide="printer"></i>
                    Print Invoice
                </button>
                <button class="action-btn-s danger-s" id="deleteModalBtn">
                    <i data-lucide="x-circle"></i>
                    Cancel Order
                </button>
            </div>
        </div>
    </div>

    <script>
        function printInvoice() {
            const orderId = document.getElementById('modalOrderId').textContent.replace('#ORD-', '');
            window.open(`print-invoice.php?id=${orderId}`, '_blank');
        }
    </script>
</body>
</html>
