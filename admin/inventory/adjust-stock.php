<!-- Adjust Stock Modal -->
<div id="adjustStockModal" class="modal-base">
    <div class="modal-content large-modal">
        <div class="modal-header">
            <h3 class="modal-title"><i data-lucide="plus-square"></i> Adjust Stock</h3>
            <button class="modal-close-btn" onclick="closeModal('adjustStockModal')"><i data-lucide="x"></i></button>
        </div>
        <div id="adjustStockAlertContainer"></div>
        <div class="adjust-stock-form-container">
            <div class="adjust-stock-form-header">
                <p>Modify product stock levels with tracking and reason</p>
            </div>
            <div class="adjust-stock-form-content">
                <form id="adjustStockForm">
                    <div class="adjust-stock-form-grid">
                        <div class="form-group">
                            <label class="form-label">Select Product</label>
                            <select class="form-select" id="adjustStockProductSelect" required>
                                <option value="">Choose a product...</option>
                                <!-- Options populated by JS -->
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Current Stock</label>
                            <div class="adjust-stock-current-stock-display">
                                <div class="adjust-stock-stock-number" id="adjustStockCurrentStock">-</div>
                                <div class="adjust-stock-stock-label">Current Quantity</div>
                            </div>
                        </div>
                    </div>

                    <div class="adjust-stock-form-grid">
                        <div class="form-group">
                            <label class="form-label">Adjustment Type</label>
                            <select class="form-select" id="adjustStockAdjustmentType" required>
                                <option value="">Select adjustment type...</option>
                                <option value="add">Add Stock (+)</option>
                                <option value="remove">Remove Stock (-)</option>
                                <option value="set">Set Stock Level (=)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Quantity</label>
                            <input type="number" class="form-input" id="adjustStockAdjustmentQuantity" min="1" placeholder="Enter quantity" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Reason for Adjustment</label>
                        <input type="text" class="form-input" id="adjustStockAdjustmentReason" placeholder="Enter reason for stock adjustment" required>
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

                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="resetAdjustStockForm()">Reset Form</button>
                        <button type="submit" class="btn btn-primary">Apply Adjustment</button>
                    </div>
                </form>
            </div>
        </div>

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
                    <!-- History populated by JS -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
// Adjust Stock Modal Functions with API Integration

let currentAdjustStockProductId = null;

function openAdjustStockModalFromIndex(productId = null) {
currentAdjustStockProductId = productId;
populateAdjustStockProductSelect();
if (productId) {
    document.getElementById('adjustStockProductSelect').value = productId;
    document.getElementById('adjustStockProductSelect').dispatchEvent(new Event('change'));
}
openModal('adjustStockModal');
}

function populateAdjustStockProductSelect() {
const select = document.getElementById('adjustStockProductSelect');
select.innerHTML = '<option value="">Choose a product...</option>';

if (typeof inventoryData !== 'undefined' && inventoryData.length > 0) {
    inventoryData.forEach(item => {
        const option = document.createElement('option');
        option.value = item.id;
        option.textContent = `${item.name} (${item.description || item.sku})`;
        option.dataset.stock = item.stock;
        option.dataset.min = item.minStock;
        select.appendChild(option);
    });
}
}

function setupAdjustStockModalListeners() {
const productSelect = document.getElementById('adjustStockProductSelect');
const currentStockElement = document.getElementById('adjustStockCurrentStock');
const adjustmentType = document.getElementById('adjustStockAdjustmentType');
const adjustmentQuantity = document.getElementById('adjustStockAdjustmentQuantity');
const adjustmentPreview = document.getElementById('adjustStockAdjustmentPreview');
const adjustStockForm = document.getElementById('adjustStockForm');

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

[adjustmentType, adjustmentQuantity].forEach(element => {
    element.addEventListener('input', updateAdjustStockPreview);
    element.addEventListener('change', updateAdjustStockPreview);
});

adjustStockForm.addEventListener('submit', async function(e) {
    e.preventDefault();

    const selectedOption = productSelect.options[productSelect.selectedIndex];
    const productId = parseInt(selectedOption.value);
    const type = adjustmentType.value;
    const quantity = parseInt(adjustmentQuantity.value);
    const reason = document.getElementById('adjustStockAdjustmentReason').value;

    if (!productId || !type || !quantity || !reason) {
        showNotification('Please fill in all required fields', 'error');
        return;
    }

    try {
        const response = await InventoryAPI.adjustStock({
            productId,
            type,
            quantity,
            reason,
            user: 'Admin'
        });

        if (response.success) {
            showNotification('Stock adjustment applied successfully!', 'success');

            // Update local data
            const itemIndex = inventoryData.findIndex(item => item.id === productId);
            if (itemIndex !== -1) {
                inventoryData[itemIndex].stock = response.data.newStock;
                selectedOption.dataset.stock = response.data.newStock;
            }

            await updateAllDataAndUI();
            resetAdjustStockForm();
        } else {
            showNotification(response.message || 'Error adjusting stock', 'error');
        }
    } catch (error) {
        console.error('Error adjusting stock:', error);
        showNotification('Error adjusting stock', 'error');
    }
});
}

function updateAdjustStockPreview() {
const productSelect = document.getElementById('adjustStockProductSelect');
const selectedOption = productSelect.options[productSelect.selectedIndex];
const currentStock = parseInt(selectedOption.dataset.stock || 0);
const type = document.getElementById('adjustStockAdjustmentType').value;
const quantity = parseInt(document.getElementById('adjustStockAdjustmentQuantity').value || 0);

const adjustmentPreview = document.getElementById('adjustStockAdjustmentPreview');

if (!type || !quantity || !selectedOption.value) {
    adjustmentPreview.style.display = 'none';
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
        adjustmentPreview.style.display = 'none';
        return;
}

document.getElementById('adjustStockPreviewCurrent').textContent = currentStock;
document.getElementById('adjustStockPreviewAdjustment').textContent = adjustmentText;
document.getElementById('adjustStockPreviewNew').textContent = newStock;

adjustmentPreview.style.display = 'block';
}

function resetAdjustStockForm() {
document.getElementById('adjustStockForm').reset();
document.getElementById('adjustStockCurrentStock').textContent = '-';
document.getElementById('adjustStockAdjustmentPreview').style.display = 'none';
currentAdjustStockProductId = null;
populateAdjustStockProductSelect();
}
</script>
