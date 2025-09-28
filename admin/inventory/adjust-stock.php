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
    let currentAdjustStockProductId = null;
    let adjustStockHistory = [
        {
            date: '2024-11-15 10:30 AM',
            productName: 'Ballpoint Pens',
            type: 'add',
            quantity: 50,
            previous: 100,
            new: 150,
            reason: 'New stock delivery',
            user: 'Admin'
        },
        {
            date: '2024-11-15 09:15 AM',
            productName: 'Bond Paper',
            type: 'remove',
            quantity: 15,
            previous: 100,
            new: 85,
            reason: 'Damaged items',
            user: 'Admin'
        },
        {
            date: '2024-11-14 02:45 PM',
            productName: 'Staplers',
            type: 'set',
            quantity: 12,
            previous: 8,
            new: 12,
            reason: 'Stock count correction',
            user: 'Admin'
        }
    ];

    function openAdjustStockModalFromIndex(productId = null) {
        currentAdjustStockProductId = productId;
        populateAdjustStockProductSelect();
        if (productId) {
            document.getElementById('adjustStockProductSelect').value = productId;
            document.getElementById('adjustStockProductSelect').dispatchEvent(new Event('change')); // Trigger change to update current stock
        }
        openModal('adjustStockModal');
    }

    function populateAdjustStockProductSelect() {
        const select = document.getElementById('adjustStockProductSelect');
        select.innerHTML = '<option value="">Choose a product...</option>';
        // Ensure inventoryData is available before using it
        if (typeof inventoryData !== 'undefined' && inventoryData.length > 0) {
            inventoryData.forEach(item => {
                const option = document.createElement('option');
                option.value = item.id;
                option.textContent = `${item.name} (${item.description})`;
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
            populateAdjustStockHistory(); // Refresh history when product changes
        });

        [adjustmentType, adjustmentQuantity].forEach(element => {
            element.addEventListener('input', updateAdjustStockPreview);
            element.addEventListener('change', updateAdjustStockPreview);
        });

        adjustStockForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const selectedOption = productSelect.options[productSelect.selectedIndex];
            const productId = parseInt(selectedOption.value);
            const productName = selectedOption.text;
            const type = adjustmentType.value;
            const quantity = parseInt(adjustmentQuantity.value);
            const reason = document.getElementById('adjustStockAdjustmentReason').value;
            const currentStock = parseInt(selectedOption.dataset.stock);

            // Update inventoryData
            // Ensure inventoryData is available before using it
            if (typeof inventoryData === 'undefined') {
                showNotification('Error: Inventory data not loaded.', 'error');
                return;
            }
            const itemIndex = inventoryData.findIndex(item => item.id === productId);
            if (itemIndex !== -1) {
                let newStock;
                switch (type) {
                    case 'add':
                        newStock = currentStock + quantity;
                        break;
                    case 'remove':
                        newStock = Math.max(0, currentStock - quantity);
                        break;
                    case 'set':
                        newStock = quantity;
                        break;
                    default:
                        return;
                }
                inventoryData[itemIndex].stock = newStock;
                // Update the data-stock attribute for the selected option
                selectedOption.dataset.stock = newStock;

                // Add to recent adjustments table
                addAdjustStockToAdjustmentsHistory({
                    productId,
                    productName,
                    type,
                    quantity,
                    reason,
                    currentStock: currentStock // Use the stock *before* adjustment for history
                }, newStock);

                showNotification('Stock adjustment applied successfully!', 'success');
                updateAllDataAndUI(); // Refresh all dashboard data and UI
                resetAdjustStockForm();
            } else {
                showNotification('Error: Product not found.', 'error');
            }
        });

        populateAdjustStockHistory(); // Initial population
    }

    function updateAdjustStockPreview() {
        const productSelect = document.getElementById('adjustStockProductSelect');
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        const currentStock = parseInt(selectedOption.dataset.stock || 0);
        const type = document.getElementById('adjustStockAdjustmentType').value;
        const quantity = parseInt(document.getElementById('adjustStockAdjustmentQuantity').value || 0);

        const adjustmentPreview = document.getElementById('adjustStockAdjustmentPreview');

        if (!type || !quantity || !selectedOption.value) { // Also check if a product is selected
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
        currentAdjustStockProductId = null; // Clear selected product ID
        populateAdjustStockProductSelect(); // Re-populate dropdown
        populateAdjustStockHistory(); // Refresh history
    }

    function addAdjustStockToAdjustmentsHistory(data, newStockValue) {
        const now = new Date();
        const formattedDate = now.toLocaleDateString() + ' ' + now.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});

        let quantityText;
        switch (data.type) {
            case 'add': quantityText = `+${data.quantity}`; break;
            case 'remove': quantityText = `-${data.quantity}`; break;
            case 'set': quantityText = `=${data.quantity}`; break;
        }

        adjustStockHistory.unshift({ // Add to the beginning of the array
            date: formattedDate,
            productName: data.productName,
            type: data.type,
            quantity: data.quantity,
            previous: data.currentStock,
            new: newStockValue,
            reason: data.reason,
            user: 'Admin'
        });

        populateAdjustStockHistory(); // Re-render history table
    }

    function populateAdjustStockHistory() {
        const tbody = document.getElementById('adjustStockAdjustmentsHistory');
        tbody.innerHTML = '';

        const selectedProductId = document.getElementById('adjustStockProductSelect').value;
        const filteredHistory = selectedProductId
            ? adjustStockHistory.filter(entry => {
                // Ensure inventoryData is available before using it
                const product = typeof inventoryData !== 'undefined' ? inventoryData.find(item => item.id == selectedProductId) : null;
                return product && entry.productName.includes(product.name);
            })
            : adjustStockHistory;

        filteredHistory.slice(0, 10).forEach(entry => { // Show only recent 10
            let typeSpan;
            switch (entry.type) {
                case 'add': typeSpan = '<span class="adjust-stock-adjustment-type add">Add</span>'; break;
                case 'remove': typeSpan = '<span class="adjust-stock-adjustment-type remove">Remove</span>'; break;
                case 'set': typeSpan = '<span class="adjust-stock-adjustment-type set">Set</span>'; break;
            }

            const newRow = tbody.insertCell();
            newRow.innerHTML = `
                <td>${entry.date}</td>
                <td>${entry.productName}</td>
                <td>${typeSpan}</td>
                <td>${entry.quantity}</td>
                <td>${entry.previous}</td>
                <td>${entry.new}</td>
                <td>${entry.reason}</td>
                <td>${entry.user}</td>
            `;
        });
    }
</script>
