<!-- Update Status Modal -->
<div class="modal-overlay" id="updateStatusModal" onclick="closeUpdateModal(event)">
    <div class="modal-container update-status-modal" onclick="event.stopPropagation()">
        <!-- Modal Header -->
        <div class="modal-header">
            <h2 class="modal-title">
                <i data-lucide="refresh-ccw"></i>
                Order Id - <span id="modalUpdateId">#ORD-001</span>
            </h2>
            <button class="close-btn" onclick="closeUpdateModal()">
                <i data-lucide="x"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="modal-body">
            <div class="update-status-container">
                <div class="two-column-layout">
                    <!-- Left Column: Current Order Information -->
                    <div class="current-order-info">
                        <h3 class="section-title">
                            <i data-lucide="clipboard-list"></i>
                            Current Order Information
                        </h3>

                        <div class="current-info-card">
                            <h4 id="updateOrderId">Order #ORD-001</h4>
                            <div class="info-grid">
                                <div class="info-item">
                                    <span class="info-label">Customer</span>
                                    <span class="info-value" id="updateCustomerName">Customer Name</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Amount</span>
                                    <span class="info-value" id="updateOrderAmount">₱0</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Current Status</span>
                                    <span class="status" id="updateCurrentStatus">Status</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Order Date</span>
                                    <span class="info-value" id="updateOrderDate">Date</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Status Update Form -->
                    <form id="updateStatusForm" onsubmit="return false;">
                        <div class="form-section">
                            <h3 class="section-title">
                                <i data-lucide="settings"></i>
                                Update Status
                            </h3>

                            <div class="form-group">
                                <label class="form-label">Select New Status</label>
                                <div class="status-options">
                                    <div class="status-option" data-status="pending">
                                        <input type="radio" name="orderStatus" value="pending" id="statusPending">
                                        <label for="statusPending">
                                            <div class="status-preview">
                                                <span class="status pending">Pending</span>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="status-option" data-status="confirmed">
                                        <input type="radio" name="orderStatus" value="confirmed" id="statusconfirmed">
                                        <label for="statusconfirmed">
                                            <div class="status-preview">
                                                <span class="status confirmed">Confirmed</span>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="status-option" data-status="shipped">
                                        <input type="radio" name="orderStatus" value="shipped" id="statusShipped">
                                        <label for="statusShipped">
                                            <div class="status-preview">
                                                <span class="status shipped">Shipped</span>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="status-option" data-status="delivered">
                                        <input type="radio" name="orderStatus" value="delivered" id="statusDelivered">
                                        <label for="statusDelivered">
                                            <div class="status-preview">
                                                <span class="status delivered">Delivered</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="updateTrackingNumber" class="form-label">Tracking Number (Optional)</label>
                                <input type="text" id="updateTrackingNumber" class="form-control" placeholder="ME-TRK-2025-XXX">
                            </div>

                            <div class="form-group">
                                <label for="updateEstimatedDelivery" class="form-label">Estimated Delivery Date</label>
                                <input type="date" id="updateEstimatedDelivery" class="form-control" onchange="validateDeliveryDate(this)">
                                <small id="deliveryDateError" style="color: #dc2626; display: none; margin-top: 0.25rem;">Delivery date cannot be in the past</small>
                            </div>

                            <div class="form-group">
                                <label for="updateStatusNotes" class="form-label">Status Update Notes</label>
                                <textarea id="updateStatusNotes" class="form-control" rows="4" placeholder="Add any notes about this status update..."></textarea>
                            </div>

                            <div class="form-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" id="updateNotifyCustomer" checked>
                                    <span class="checkmark"></span>
                                    Send notification to customer
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="modal-footer">
            <button class="action-btn-s secondary-s" onclick="closeUpdateModal()">Cancel</button>
            <button type="button" class="action-btn-s primary-s" onclick="submitStatusUpdate()">
                <i data-lucide="check-circle"></i>
                Update Status
            </button>
        </div>
    </div>
</div>

<style>
/* Modal base styles */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    padding: 2rem;
    backdrop-filter: blur(4px);
}

.modal-overlay.active {
    display: flex;
}

.modal-container {
    background: white;
    border-radius: 16px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    overflow: hidden;
    max-height: 90vh;
    display: flex;
    flex-direction: column;
}

.modal-header {
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #f9fafb;
}

.modal-title {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 600;
    color: #111827;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.close-btn {
    background: none;
    border: none;
    padding: 0.5rem;
    cursor: pointer;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6b7280;
    transition: all 0.2s ease;
}

.close-btn:hover {
    background-color: #f3f4f6;
    color: #374151;
}

.modal-body {
    padding: 1.5rem;
    overflow-y: auto;
    flex: 1;
}

.modal-footer {
    padding: 1.5rem;
    border-top: 1px solid #e5e7eb;
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    background: #f9fafb;
}

.section-title {
    margin: 0 0 1rem 0;
    font-size: 1.1rem;
    font-weight: 600;
    color: #374151;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.info-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 0.75rem;
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    border-bottom: 1px solid #f3f4f6;
}

.info-item:last-child {
    border-bottom: none;
}

.info-label {
    font-weight: 500;
    color: #6b7280;
    font-size: 0.9rem;
}

.info-value {
    font-weight: 500;
    color: #111827;
}

.status {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.status.pending {
    background-color: #fef3c7;
    color: #92400e;
}

.status.confirmed {
    background-color: #dbeafe;
    color: #1e40af;
}

.status.shipped {
    background-color: #e0e7ff;
    color: #5b21b6;
}

.status.delivered {
    background-color: #d1fae5;
    color: #065f46;
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

/* Update Status Modal Specific Styles */
.update-status-modal {
    max-width: 700px;
    width: 90%;
}

.update-status-container {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.two-column-layout {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

.current-order-info {
    display: flex;
    flex-direction: column;
}

.current-info-card {
    background-color: #f8fafc;
    padding: 1.5rem;
    border-radius: 12px;
    border-left: 4px solid #1e40af;
    margin-top: 1rem;
    flex: 1;
}

.current-info-card h4 {
    color: #1e40af;
    margin-bottom: 1rem;
    font-size: 1.25rem;
    font-weight: 600;
}

.form-section {
    background: #f9fafb;
    border-radius: 12px;
    padding: 1.5rem;
    border: 1px solid #e5e7eb;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #374151;
    font-size: 0.9rem;
}

.form-control {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.2s ease;
    font-family: inherit;
    box-sizing: border-box;
}

.form-control:focus {
    outline: none;
    border-color: #1e40af;
    box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
}

.form-control.error {
    border-color: #dc2626;
}

.status-options {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.5rem;
    margin-top: 0.5rem;
}

.status-option {
    display: flex;
    align-items: center;
    padding: 0.5rem;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s ease;
    background: white;
}

.status-option:hover {
    border-color: #1e40af;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.status-option input[type="radio"]:checked ~ label {
    font-weight: 600;
}

.status-option:has(input[type="radio"]:checked) {
    border-color: #1e40af;
    background-color: #eff6ff;
    box-shadow: 0 2px 8px rgba(30, 64, 175, 0.2);
}

.status-option input[type="radio"] {
    margin-right: 0.5rem;
    accent-color: #1e40af;
}

.status-option label {
    cursor: pointer;
    margin: 0;
    flex: 1;
}

.status-preview {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.checkbox-label {
    display: flex;
    align-items: center;
    cursor: pointer;
    font-weight: 500;
    color: #374151;
}

.checkbox-label input[type="checkbox"] {
    margin-right: 0.5rem;
    accent-color: #1e40af;
    width: 18px;
    height: 18px;
}

/* Responsive Design for Update Modal */
@media (max-width: 768px) {
    .update-status-modal {
        width: 95%;
        max-width: none;
        margin: 1rem;
        max-height: 90vh;
    }

    .modal-body {
        max-height: calc(90vh - 140px);
    }

    .two-column-layout {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .status-options {
        grid-template-columns: 1fr;
    }

    .info-grid {
        grid-template-columns: 1fr;
    }

    .modal-footer {
        flex-direction: column;
        gap: 0.5rem;
    }

    .modal-footer .action-btn-s {
        width: 100%;
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .update-status-modal {
        width: 100%;
        height: 100vh;
        max-height: 100vh;
        border-radius: 0;
    }

    .modal-body {
        max-height: calc(100vh - 140px);
        padding: 1rem;
    }

    .current-info-card,
    .form-section {
        padding: 1rem;
    }
}
</style>

<script>
function validateDeliveryDate(input) {
    const selectedDate = new Date(input.value);
    const today = new Date();
    today.setHours(0, 0, 0, 0); // Reset time to start of day

    const errorMsg = document.getElementById('deliveryDateError');

    if (selectedDate < today) {
        input.classList.add('error');
        errorMsg.style.display = 'block';
        input.value = ''; // Clear the invalid date
        return false;
    } else {
        input.classList.remove('error');
        errorMsg.style.display = 'none';
        return true;
    }
}

// Set minimum date on modal open
document.addEventListener('DOMContentLoaded', function() {
    const deliveryInput = document.getElementById('updateEstimatedDelivery');
    if (deliveryInput) {
        const today = new Date().toISOString().split('T')[0];
        deliveryInput.min = today;
    }
});
</script>
