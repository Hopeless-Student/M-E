<!-- Low Stock Alerts Modal -->
<div id="lowStockAlertsModal" class="modal-base">
    <div class="modal-content extra-large-modal">
        <div class="modal-header">
            <h3 class="modal-title" style="color: #dc2626;"><i data-lucide="siren"></i> Low Stock Alerts</h3>
            <button class="modal-close-btn" onclick="closeModal('lowStockAlertsModal')"><i data-lucide="x"></i></button>
        </div>

        <!-- Alert Summary -->
        <div class="low-stock-alerts-summary">
            <div class="low-stock-alerts-summary-card critical">
                <div class="low-stock-alerts-summary-icon"><i data-lucide="siren" style="color:red;"></i></div>
                <div class="low-stock-alerts-summary-title">Critical Alerts</div>
                <div class="low-stock-alerts-summary-value" id="criticalAlertsCount">0</div>
                <div class="low-stock-alerts-summary-subtitle">Out of stock</div>
            </div>
            <div class="low-stock-alerts-summary-card warning">
                <div class="low-stock-alerts-summary-icon"><i data-lucide="triangle-alert" style="color: orange;"></i></div>
                <div class="low-stock-alerts-summary-title">Warning Alerts</div>
                <div class="low-stock-alerts-summary-value" id="warningAlertsCount">0</div>
                <div class="low-stock-alerts-summary-subtitle">Below minimum stock</div>
            </div>
            <div class="low-stock-alerts-summary-card info">
                <div class="low-stock-alerts-summary-icon"><i data-lucide="chart-no-axes-column-increasing" style="color: #4169e1;"></i></div>
                <div class="low-stock-alerts-summary-title">Total Items</div>
                <div class="low-stock-alerts-summary-value" id="totalAlertItemsCount">0</div>
                <div class="low-stock-alerts-summary-subtitle">Requiring attention</div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="low-stock-alerts-quick-actions">
            <h3 class="low-stock-alerts-actions-title">Quick Actions</h3>
            <div class="low-stock-alerts-actions-grid">
                <button class="low-stock-alerts-action-btn primary" onclick="openBulkRestockModal()">
                    <i data-lucide="package-plus"></i> Create Bulk Restock Request
                </button>
                <button class="low-stock-alerts-action-btn" onclick="openMinimumLevelsModal()">
                    <i data-lucide="ruler"></i> Adjust Min Levels
                </button>
                <button class="low-stock-alerts-action-btn" onclick="exportLowStockReport()">
                    <i data-lucide="download"></i> Export Report
                </button>
                <button class="low-stock-alerts-action-btn" onclick="openEmailAlertsModal()">
                    <i data-lucide="mail"></i> Send Email Alerts
                </button>
            </div>
        </div>

        <!-- Alerts Table -->
        <div class="low-stock-alerts-alerts-section">
            <div class="low-stock-alerts-section-header">
                <h3 class="low-stock-alerts-section-title">Low Stock Items</h3>
                <span id="lowStockAlertsCount">0 items need attention</span>
            </div>

            <div class="low-stock-alerts-controls">
                <div class="low-stock-alerts-search-box">
                    <input type="text" class="form-input" placeholder="Search products..." id="lowStockSearchInput">
                </div>
                <select class="form-select" id="lowStockCategoryFilter">
                    <option value="">All Categories</option>
                    <option value="office">Office Supplies</option>
                    <option value="school">School Supplies</option>
                    <option value="sanitary">Sanitary Supplies</option>
                </select>
                <select class="form-select" id="lowStockAlertLevelFilter">
                    <option value="">All Alert Levels</option>
                    <option value="critical">Critical</option>
                    <option value="warning">Warning</option>
                    <option value="low">Low</option>
                </select>
            </div>

            <table class="low-stock-alerts-alerts-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Alert Level</th>
                        <th>Current/Min Stock</th>
                        <th>Stock Level</th>
                        <th>Days Supply</th>
                        <th>Last Restock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="lowStockAlertsTableBody">
                    <!-- Alert data will be populated here -->
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="low-stock-alerts-pagination">
                <div class="low-stock-alerts-pagination-info">
                    Showing <span id="lowStockStartItem">1</span>-<span id="lowStockEndItem">0</span> of <span id="lowStockTotalAlerts">0</span> alerts
                </div>
                <div class="low-stock-alerts-pagination-controls">
                    <button class="low-stock-alerts-page-btn" id="lowStockPrevBtn" onclick="changeLowStockAlertsPage('prev')">Previous</button>
                    <div id="lowStockPageNumbers"></div>
                    <button class="low-stock-alerts-page-btn" id="lowStockNextBtn" onclick="changeLowStockAlertsPage('next')">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Restock Modal -->
<div id="bulkRestockModal" class="modal-base">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title"><i data-lucide="package-plus"></i> Create Bulk Restock Request</h3>
            <button class="modal-close-btn" onclick="closeModal('bulkRestockModal')"><i data-lucide="x"></i></button>
        </div>
        <form id="bulkRestockForm">
            <div class="low-stock-alerts-modal-section">
                <div class="low-stock-alerts-modal-section-title">Request Details</div>
                <div class="form-group">
                    <label class="form-label">Request Priority</label>
                    <select class="form-select" id="bulkRestockRequestPriority" required>
                        <option value="urgent">Urgent (Within 24 hours)</option>
                        <option value="high">High Priority (2-3 days)</option>
                        <option value="normal">Normal (1 week)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Requested By</label>
                    <input type="text" class="form-input" id="bulkRestockRequestedBy" value="Admin User" readonly>
                </div>
                <div class="form-group">
                    <label class="form-label">Department</label>
                    <select class="form-select" id="bulkRestockDepartment" required>
                        <option value="inventory">Inventory Management</option>
                        <option value="purchasing">Purchasing Department</option>
                        <option value="operations">Operations</option>
                    </select>
                </div>
            </div>

            <div class="low-stock-alerts-modal-section">
                <div class="low-stock-alerts-modal-section-title">Items to Restock</div>
                <div class="low-stock-alerts-item-list" id="bulkRestockItemsList">
                    <!-- Items will be populated here -->
                </div>
            </div>

            <div class="low-stock-alerts-modal-section">
                <div class="low-stock-alerts-modal-section-title">Additional Notes</div>
                <div class="form-group">
                    <label class="form-label">Special Instructions</label>
                    <textarea class="form-textarea" id="bulkRestockNotes" placeholder="Any special handling requirements or notes..."></textarea>
                </div>
            </div>

            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="closeModal('bulkRestockModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Submit Restock Request</button>
            </div>
        </form>
    </div>
</div>

<!-- Individual Restock Modal -->
<div id="individualRestockModal" class="modal-base">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title"><i data-lucide="rotate-cw"></i> Restock Item</h3>
            <button class="modal-close-btn" onclick="closeModal('individualRestockModal')"><i data-lucide="x"></i></button>
        </div>
        <form id="individualRestockForm">
            <div class="low-stock-alerts-modal-section">
                <div class="low-stock-alerts-modal-section-title">Product Information</div>
                <div class="low-stock-alerts-info-grid">
                    <div class="low-stock-alerts-info-card">
                        <div class="low-stock-alerts-info-label">Product Name</div>
                        <div class="low-stock-alerts-info-value" id="individualRestockProductName">-</div>
                    </div>
                    <div class="low-stock-alerts-info-card">
                        <div class="low-stock-alerts-info-label">Current Stock</div>
                        <div class="low-stock-alerts-info-value" id="individualRestockCurrentStock">-</div>
                    </div>
                    <div class="low-stock-alerts-info-card">
                        <div class="low-stock-alerts-info-label">Minimum Stock</div>
                        <div class="low-stock-alerts-info-value" id="individualRestockMinStock">-</div>
                    </div>
                    <div class="low-stock-alerts-info-card">
                        <div class="low-stock-alerts-info-label">Recommended Qty</div>
                        <div class="low-stock-alerts-info-value" id="individualRestockRecommended">-</div>
                    </div>
                </div>
            </div>

            <div class="low-stock-alerts-modal-section">
                <div class="low-stock-alerts-modal-section-title">Restock Details</div>
                <div class="form-group">
                    <label class="form-label">Restock Quantity</label>
                    <input type="number" class="form-input" id="individualRestockQuantity" min="1" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Priority Level</label>
                    <select class="form-select" id="individualRestockPriority" required>
                        <option value="urgent">Urgent - Critical Stock</option>
                        <option value="high">High Priority</option>
                        <option value="normal">Normal Priority</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Reason for Restock</label>
                    <select class="form-select" id="individualRestockReason" required>
                        <option value="low_stock">Below Minimum Stock Level</option>
                        <option value="out_of_stock">Out of Stock</option>
                        <option value="high_demand">High Demand Expected</option>
                        <option value="seasonal">Seasonal Preparation</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Notes</label>
                    <textarea class="form-textarea" id="individualRestockItemNotes" placeholder="Additional notes or special requirements..."></textarea>
                </div>
            </div>

            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="closeModal('individualRestockModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Submit Restock Request</button>
            </div>
        </form>
    </div>
</div>

<!-- Adjust Stock Modal (Nested within Low Stock Alerts, distinct from main Adjust Stock Modal) -->
<div id="lowStockAdjustStockModal" class="modal-base">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title"><i data-lucide="pencil-line"></i> Adjust Stock Level</h3>
            <button class="modal-close-btn" onclick="closeModal('lowStockAdjustStockModal')"><i data-lucide="x"></i></button>
        </div>
        <form id="lowStockAdjustStockModalForm">
            <div class="low-stock-alerts-modal-section">
                <div class="low-stock-alerts-modal-section-title">Product Information</div>
                <div class="low-stock-alerts-info-grid">
                    <div class="low-stock-alerts-info-card">
                        <div class="low-stock-alerts-info-label">Product Name</div>
                        <div class="low-stock-alerts-info-value" id="lowStockAdjustStockModalProductName">-</div>
                    </div>
                    <div class="low-stock-alerts-info-card">
                        <div class="low-stock-alerts-info-label">Current Stock</div>
                        <div class="low-stock-alerts-info-value" id="lowStockAdjustStockModalCurrentStock">-</div>
                    </div>
                </div>
            </div>

            <div class="low-stock-alerts-modal-section">
                <div class="low-stock-alerts-modal-section-title">Stock Adjustment</div>
                <div class="form-group">
                    <label class="form-label">Adjustment Type</label>
                    <select class="form-select" id="lowStockAdjustStockModalAdjustmentType" required>
                        <option value="add">Add Stock (+)</option>
                        <option value="remove">Remove Stock (-)</option>
                        <option value="set">Set Exact Amount</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Quantity</label>
                    <input type="number" class="form-input" id="lowStockAdjustStockModalQuantity" min="0" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Reason for Adjustment</label>
                    <select class="form-select" id="lowStockAdjustStockModalReason" required>
                        <option value="recount">Physical Recount</option>
                        <option value="damaged">Damaged Items</option>
                        <option value="expired">Expired Items</option>
                        <option value="found">Items Found</option>
                        <option value="transfer">Transfer Between Locations</option>
                        <option value="correction">Data Correction</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Notes</label>
                    <textarea class="form-textarea" id="lowStockAdjustStockModalNotes" placeholder="Detailed explanation for this adjustment..." required></textarea>
                </div>
            </div>

            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="closeModal('lowStockAdjustStockModal')">Cancel</button>
                <button type="submit" class="btn btn-warning">Apply Adjustment</button>
            </div>
        </form>
    </div>
</div>

<!-- Minimum Levels Modal -->
<div id="minimumLevelsModal" class="modal-base">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title"><i data-lucide="ruler"></i> Adjust Minimum Stock Levels</h3>
            <button class="modal-close-btn" onclick="closeModal('minimumLevelsModal')"><i data-lucide="x"></i></button>
        </div>
        <div class="low-stock-alerts-modal-section">
            <div class="low-stock-alerts-modal-section-title">Bulk Adjustment Options</div>
            <div class="form-group">
                <label class="form-label">Adjustment Method</label>
                <select class="form-select" id="minimumLevelsBulkAdjustMethod">
                    <option value="percentage">Percentage Increase/Decrease</option>
                    <option value="fixed">Fixed Amount Increase/Decrease</option>
                    <option value="individual">Individual Item Adjustment</option>
                </select>
            </div>
            <div class="form-group" id="minimumLevelsPercentageGroup">
                <label class="form-label">Percentage Change (%)</label>
                <input type="number" class="form-input" id="minimumLevelsPercentageChange" placeholder="e.g., 20 for 20% increase, -10 for 10% decrease">
            </div>
            <div class="form-group" id="minimumLevelsFixedGroup" style="display:none;">
                <label class="form-label">Fixed Amount Change</label>
                <input type="number" class="form-input" id="minimumLevelsFixedChange" placeholder="e.g., 5 to add 5 to each minimum, -3 to subtract 3">
            </div>
        </div>

        <div class="low-stock-alerts-modal-section" id="minimumLevelsIndividualAdjustSection" style="display:none;">
            <div class="low-stock-alerts-modal-section-title">Individual Adjustments</div>
            <div class="low-stock-alerts-item-list" id="minimumLevelsList">
                <!-- Items will be populated here -->
            </div>
        </div>

        <div class="form-actions">
            <button type="button" class="btn btn-secondary" onclick="closeModal('minimumLevelsModal')">Cancel</button>
            <button type="button" class="btn btn-primary" onclick="applyMinimumLevelChanges()">Apply Changes</button>
        </div>
    </div>
</div>

<!-- Email Alerts Modal -->
<div id="emailAlertsModal" class="modal-base">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title"><i data-lucide="mail"></i> Send Email Alerts</h3>
            <button class="modal-close-btn" onclick="closeModal('emailAlertsModal')"><i data-lucide="x"></i></button>
        </div>
        <form id="emailAlertsForm">
            <div class="low-stock-alerts-modal-section">
                <div class="low-stock-alerts-modal-section-title">Recipients</div>
                <div class="form-group">
                    <label class="form-label">
                        <input type="checkbox" id="emailAlertsManagersCheckbox" checked>
                        All Managers (3 recipients)
                    </label>
                </div>
                <div class="form-group">
                    <label class="form-label">
                        <input type="checkbox" id="emailAlertsPurchasingCheckbox" checked>
                        Purchasing Department (2 recipients)
                    </label>
                </div>
                <div class="form-group">
                    <label class="form-label">
                        <input type="checkbox" id="emailAlertsInventoryCheckbox">
                        Inventory Team (4 recipients)
                    </label>
                </div>
                <div class="form-group">
                    <label class="form-label">Additional Recipients</label>
                    <textarea class="form-textarea" id="emailAlertsAdditionalEmails" placeholder="Enter additional email addresses, separated by commas..."></textarea>
                </div>
            </div>

            <div class="low-stock-alerts-modal-section">
                <div class="low-stock-alerts-modal-section-title">Alert Settings</div>
                <div class="form-group">
                    <label class="form-label">Alert Level Filter</label>
                    <select class="form-select" id="emailAlertsEmailAlertLevel">
                        <option value="all">All Alert Levels</option>
                        <option value="critical">Critical Only</option>
                        <option value="critical_warning">Critical & Warning</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Email Format</label>
                    <select class="form-select" id="emailAlertsEmailFormat">
                        <option value="summary">Summary Report</option>
                        <option value="detailed">Detailed Report</option>
                        <option value="both">Both Summary & Detailed</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">
                        <input type="checkbox" id="emailAlertsIncludeActions">
                        Include Suggested Actions
                    </label>
                </div>
            </div>

            <div class="low-stock-alerts-modal-section">
                <div class="low-stock-alerts-modal-section-title">Custom Message</div>
                <div class="form-group">
                    <label class="form-label">Additional Message (Optional)</label>
                    <textarea class="form-textarea" id="emailAlertsCustomMessage" placeholder="Add any additional context or instructions..."></textarea>
                </div>
            </div>

            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="closeModal('emailAlertsModal')">Cancel</button>
                <button type="submit" class="btn btn-success">Send Alerts</button>
            </div>
        </form>
    </div>
</div>

<script>
    let currentLowStockAlertsPage = 1;
    let filteredLowStockAlertsData = [...lowStockData];
    let currentEditingLowStockItem = null; // For individual restock/adjust stock modals

    function openLowStockAlertsModal() {
        applyLowStockAlertsFilters(); // Initial population and filtering
        openModal('lowStockAlertsModal');
    }

    function setupLowStockAlertsModalListeners() {
        document.getElementById('lowStockSearchInput').addEventListener('input', applyLowStockAlertsFilters);
        document.getElementById('lowStockCategoryFilter').addEventListener('change', applyLowStockAlertsFilters);
        document.getElementById('lowStockAlertLevelFilter').addEventListener('change', applyLowStockAlertsFilters);

        // Minimum levels adjustment method change
        document.getElementById('minimumLevelsBulkAdjustMethod').addEventListener('change', function() {
            const method = this.value;
            document.getElementById('minimumLevelsPercentageGroup').style.display = method === 'percentage' ? 'block' : 'none';
            document.getElementById('minimumLevelsFixedGroup').style.display = method === 'fixed' ? 'block' : 'none';
            document.getElementById('minimumLevelsIndividualAdjustSection').style.display = method === 'individual' ? 'block' : 'none';

            if (method === 'individual') {
                populateMinimumLevelsList();
            }
        });

        document.getElementById('bulkRestockForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const priority = document.getElementById('bulkRestockRequestPriority').value;
            const department = document.getElementById('bulkRestockDepartment').value;
            const notes = document.getElementById('bulkRestockNotes').value;

            const items = [];
            document.querySelectorAll('#bulkRestockItemsList .low-stock-alerts-quantity-input').forEach(input => {
                const quantity = parseInt(input.value);
                if (quantity > 0) {
                    items.push({
                        id: input.dataset.itemId,
                        quantity: quantity
                    });
                }
            });

            showNotification(`Bulk restock request submitted!\n${items.length} items requested with ${priority} priority.`, 'success');
            closeModal('bulkRestockModal');
        });

        document.getElementById('individualRestockForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const quantity = document.getElementById('individualRestockQuantity').value;
            const priority = document.getElementById('individualRestockPriority').value;
            const reason = document.getElementById('individualRestockReason').value;

            showNotification(`Restock request submitted for ${currentEditingLowStockItem.name}\nQuantity: ${quantity} units\nPriority: ${capitalizeFirst(priority)}`, 'success');
            closeModal('individualRestockModal');
        });

        document.getElementById('lowStockAdjustStockModalForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const type = document.getElementById('lowStockAdjustStockModalAdjustmentType').value;
            const quantity = document.getElementById('lowStockAdjustStockModalQuantity').value;
            const reason = document.getElementById('lowStockAdjustStockModalReason').value;

            // Find the corresponding item in inventoryData and update its stock
            const itemIndex = inventoryData.findIndex(item => item.id === currentEditingLowStockItem.id);
            if (itemIndex !== -1) {
                let newStock;
                const currentStock = inventoryData[itemIndex].stock;
                switch (type) {
                    case 'add':
                        newStock = currentStock + parseInt(quantity);
                        break;
                    case 'remove':
                        newStock = Math.max(0, currentStock - parseInt(quantity));
                        break;
                    case 'set':
                        newStock = parseInt(quantity);
                        break;
                    default:
                        return;
                }
                inventoryData[itemIndex].stock = newStock;

                // Add to stock movements history
                stockMovementsData.unshift({
                    id: stockMovementsData.length + 1,
                    productId: currentEditingLowStockItem.id,
                    productName: currentEditingLowStockItem.name,
                    productSKU: currentEditingLowStockItem.sku,
                    type: type,
                    quantity: parseInt(quantity),
                    previousStock: currentStock,
                    newStock: newStock,
                    reason: reason,
                    user: 'Admin',
                    timestamp: new Date().toLocaleString([], {hour: '2-digit', minute:'2-digit', year: 'numeric', month: '2-digit', day: '2-digit'})
                });

                showNotification(`Stock adjustment applied for ${currentEditingLowStockItem.name}\nType: ${capitalizeFirst(type)}\nQuantity: ${quantity}\nReason: ${reason}`, 'success');
                closeModal('lowStockAdjustStockModal');
                updateAllDataAndUI(); // Refresh all dashboard data and UI
                applyLowStockAlertsFilters(); // Re-apply filters for alerts modal
            } else {
                showNotification('Error: Product not found for adjustment.', 'error');
            }
        });

        document.getElementById('emailAlertsForm').addEventListener('submit', function(e) {
            e.preventDefault();
            let recipientCount = 0;
            if (document.getElementById('emailAlertsManagersCheckbox').checked) recipientCount += 3;
            if (document.getElementById('emailAlertsPurchasingCheckbox').checked) recipientCount += 2;
            if (document.getElementById('emailAlertsInventoryCheckbox').checked) recipientCount += 4;

            showNotification(`Email alerts sent successfully to ${recipientCount} recipients!`, 'success');
            closeModal('emailAlertsModal');
        });
    }

    function applyLowStockAlertsFilters() {
        const searchTerm = document.getElementById('lowStockSearchInput').value.toLowerCase();
        const selectedCategory = document.getElementById('lowStockCategoryFilter').value;
        const selectedLevel = document.getElementById('lowStockAlertLevelFilter').value;

        filteredLowStockAlertsData = lowStockData.filter(item => {
            const matchesSearch = item.name.toLowerCase().includes(searchTerm) ||
                                item.sku.toLowerCase().includes(searchTerm);
            const matchesCategory = !selectedCategory || item.category === selectedCategory;
            const matchesLevel = !selectedLevel || item.alertLevel === selectedLevel;

            return matchesSearch && matchesCategory && matchesLevel;
        });

        currentLowStockAlertsPage = 1;
        populateLowStockAlertsTable(filteredLowStockAlertsData);
        updateLowStockSummaryCards();
        updateLowStockAlertsCount();
    }

    function populateLowStockAlertsTable(data) {
        const tbody = document.getElementById('lowStockAlertsTableBody');
        tbody.innerHTML = '';

        const startIndex = (currentLowStockAlertsPage - 1) * lowStockItemsPerPage;
        const endIndex = startIndex + lowStockItemsPerPage;
        const pageData = data.slice(startIndex, endIndex);

        if (pageData.length === 0) {
            tbody.innerHTML = `<tr><td colspan="7" style="text-align: center; padding: 2rem; color: #64748b;">No low stock items found matching your criteria.</td></tr>`;
            updateLowStockAlertsPagination(data.length);
            return;
        }

        pageData.forEach(item => {
            const row = tbody.insertRow();
            const stockPercentage = (item.currentStock / item.minStock) * 100;

            row.innerHTML = `
                <td>
                    <div class="low-stock-alerts-product-cell">
                        <div class="low-stock-alerts-product-icon">${item.icon}</div>
                        <div class="low-stock-alerts-product-info">
                            <h4>${item.name}</h4>
                            <p>${item.sku}</p>
                        </div>
                    </div>
                </td>
                <td>
                    <span class="low-stock-alerts-alert-level ${item.alertLevel}">${capitalizeFirst(item.alertLevel)}</span>
                </td>
                <td>
                    <div class="low-stock-alerts-stock-info">
                        <div class="low-stock-alerts-current-stock">${item.currentStock}</div>
                        <div class="low-stock-alerts-min-stock">Min: ${item.minStock}</div>
                        <div class="low-stock-alerts-stock-progress">
                            <div class="low-stock-alerts-stock-fill" style="width: ${Math.min(stockPercentage, 100)}%"></div>
                        </div>
                    </div>
                </td>
                <td>${stockPercentage.toFixed(0)}%</td>
                <td>
                    <div class="low-stock-alerts-days-supply ${item.daysSupply <= 3 ? 'critical' : item.daysSupply <= 7 ? 'warning' : ''}">
                        ${item.daysSupply} days
                    </div>
                </td>
                <td>${formatDate(item.lastRestock)}</td>
                <td>
                    <div class="low-stock-alerts-action-buttons-container">
                        <button class="low-stock-alerts-btn-sm btn-primary" onclick="openIndividualRestockModal(${item.id})">Restock</button>
                        <button class="low-stock-alerts-btn-sm btn-secondary" onclick="openLowStockAdjustStockModal(${item.id})">Adjust</button>
                    </div>
                </td>
            `;
        });
        updateLowStockAlertsPagination(data.length);
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }

    function updateLowStockSummaryCards() {
        const critical = filteredLowStockAlertsData.filter(item => item.alertLevel === 'critical').length;
        const warning = filteredLowStockAlertsData.filter(item => item.alertLevel === 'warning').length;

        document.getElementById('criticalAlertsCount').textContent = critical;
        document.getElementById('warningAlertsCount').textContent = warning;
        document.getElementById('totalAlertItemsCount').textContent = filteredLowStockAlertsData.length;
    }

    function updateLowStockAlertsCount() {
        document.getElementById('lowStockAlertsCount').textContent = `${filteredLowStockAlertsData.length} items need attention`;
    }

    function updateLowStockAlertsPagination(totalItems) {
        const totalPages = Math.ceil(totalItems / lowStockItemsPerPage);
        const startItem = totalItems === 0 ? 0 : (currentLowStockAlertsPage - 1) * lowStockItemsPerPage + 1;
        const endItem = Math.min(currentLowStockAlertsPage * lowStockItemsPerPage, totalItems);

        document.getElementById('lowStockStartItem').textContent = startItem;
        document.getElementById('lowStockEndItem').textContent = endItem;
        document.getElementById('lowStockTotalAlerts').textContent = totalItems;

        const prevBtn = document.getElementById('lowStockPrevBtn');
        const nextBtn = document.getElementById('lowStockNextBtn');
        const pageNumbersContainer = document.getElementById('lowStockPageNumbers');

        prevBtn.disabled = currentLowStockAlertsPage === 1;
        nextBtn.disabled = currentLowStockAlertsPage === totalPages || totalPages === 0;

        pageNumbersContainer.innerHTML = '';
        for (let i = 1; i <= totalPages; i++) {
            const pageBtn = document.createElement('button');
            pageBtn.className = `low-stock-alerts-page-btn ${i === currentLowStockAlertsPage ? 'active' : ''}`;
            pageBtn.textContent = i;
            pageBtn.onclick = () => changeLowStockAlertsPage(i);
            pageNumbersContainer.appendChild(pageBtn);
        }
    }

    function changeLowStockAlertsPage(page) {
        const totalPages = Math.ceil(filteredLowStockAlertsData.length / lowStockItemsPerPage);

        if (page === 'prev' && currentLowStockAlertsPage > 1) {
            currentLowStockAlertsPage--;
        } else if (page === 'next' && currentLowStockAlertsPage < totalPages) {
            currentLowStockAlertsPage++;
        } else if (typeof page === 'number' && page >= 1 && page <= totalPages) {
            currentLowStockAlertsPage = page;
        }
        populateLowStockAlertsTable(filteredLowStockAlertsData);
    }

    // Nested Modal Functions for Low Stock Alerts
    function openBulkRestockModal() {
        populateBulkRestockItemsList();
        openModal('bulkRestockModal');
    }

    function populateBulkRestockItemsList() {
        const itemsList = document.getElementById('bulkRestockItemsList');
        itemsList.innerHTML = '';

        filteredLowStockAlertsData.forEach(item => {
            const recommendedQty = Math.max(item.minStock * 2 - item.currentStock, 0);
            const itemEntry = document.createElement('div');
            itemEntry.className = 'low-stock-alerts-item-entry';
            itemEntry.innerHTML = `
                <div class="low-stock-alerts-item-info">
                    <div class="low-stock-alerts-item-name">${item.icon} ${item.name}</div>
                    <div class="low-stock-alerts-item-details">Current: ${item.currentStock} | Min: ${item.minStock} | SKU: ${item.sku}</div>
                </div>
                <div>
                    <input type="number" class="low-stock-alerts-quantity-input" value="${recommendedQty}" min="0"
                           data-item-id="${item.id}" placeholder="Qty">
                </div>
            `;
            itemsList.appendChild(itemEntry);
        });
    }

    function openIndividualRestockModal(itemId) {
        const item = lowStockData.find(i => i.id === itemId);
        currentEditingLowStockItem = item;

        document.getElementById('individualRestockProductName').textContent = item.name;
        document.getElementById('individualRestockCurrentStock').textContent = item.currentStock;
        document.getElementById('individualRestockMinStock').textContent = item.minStock;
        document.getElementById('individualRestockRecommended').textContent = Math.max(item.minStock * 2 - item.currentStock, 0);
        document.getElementById('individualRestockQuantity').value = Math.max(item.minStock * 2 - item.currentStock, 0);
        document.getElementById('individualRestockPriority').value = item.alertLevel === 'critical' ? 'urgent' : 'high';

        openModal('individualRestockModal');
    }

    function openLowStockAdjustStockModal(itemId) {
        const item = lowStockData.find(i => i.id === itemId);
        currentEditingLowStockItem = item;

        document.getElementById('lowStockAdjustStockModalProductName').textContent = item.name;
        document.getElementById('lowStockAdjustStockModalCurrentStock').textContent = item.currentStock;
        document.getElementById('lowStockAdjustStockModalQuantity').value = '';
        document.getElementById('lowStockAdjustStockModalNotes').value = '';

        openModal('lowStockAdjustStockModal');
    }

    function openMinimumLevelsModal() {
        populateMinimumLevelsList();
        openModal('minimumLevelsModal');
    }

    function populateMinimumLevelsList() {
        const itemsList = document.getElementById('minimumLevelsList');
        itemsList.innerHTML = '';

        filteredLowStockAlertsData.forEach(item => {
            const itemEntry = document.createElement('div');
            itemEntry.className = 'low-stock-alerts-item-entry';
            itemEntry.innerHTML = `
                <div class="low-stock-alerts-item-info">
                    <div class="low-stock-alerts-item-name">${item.icon} ${item.name}</div>
                    <div class="low-stock-alerts-item-details">Current Min: ${item.minStock} | SKU: ${item.sku}</div>
                </div>
                <div>
                    <input type="number" class="low-stock-alerts-quantity-input" value="${item.minStock}" min="1"
                           data-item-id="${item.id}" placeholder="New Min">
                </div>
            `;
            itemsList.appendChild(itemEntry);
        });
    }

    function applyMinimumLevelChanges() {
        const method = document.getElementById('minimumLevelsBulkAdjustMethod').value;
        let changesApplied = 0;

        if (method === 'percentage') {
            const percentage = parseFloat(document.getElementById('minimumLevelsPercentageChange').value);
            if (isNaN(percentage)) {
                showNotification('Please enter a valid percentage', 'error');
                return;
            }
            filteredLowStockAlertsData.forEach(item => {
                const inventoryItem = inventoryData.find(inv => inv.id === item.id);
                if (inventoryItem) {
                    inventoryItem.minStock = Math.round(inventoryItem.minStock * (1 + percentage / 100));
                    changesApplied++;
                }
            });
            showNotification(`Minimum levels adjusted by ${percentage}% for ${changesApplied} items`, 'success');
        } else if (method === 'fixed') {
            const fixedAmount = parseFloat(document.getElementById('minimumLevelsFixedChange').value);
            if (isNaN(fixedAmount)) {
                showNotification('Please enter a valid fixed amount', 'error');
                return;
            }
            filteredLowStockAlertsData.forEach(item => {
                const inventoryItem = inventoryData.find(inv => inv.id === item.id);
                if (inventoryItem) {
                    inventoryItem.minStock = Math.max(1, inventoryItem.minStock + fixedAmount);
                    changesApplied++;
                }
            });
            showNotification(`Minimum levels adjusted by ${fixedAmount} units for ${changesApplied} items`, 'success');
        } else if (method === 'individual') {
            const inputs = document.querySelectorAll('#minimumLevelsList .low-stock-alerts-quantity-input');
            inputs.forEach(input => {
                const itemId = parseInt(input.dataset.itemId);
                const newMin = parseInt(input.value);
                const inventoryItem = inventoryData.find(inv => inv.id === itemId);
                if (inventoryItem && !isNaN(newMin) && newMin >= 1) {
                    inventoryItem.minStock = newMin;
                    changesApplied++;
                }
            });
            showNotification(`Individual minimum levels updated for ${changesApplied} items`, 'success');
        }

        updateAllDataAndUI(); // Refresh all dashboard data and UI
        applyLowStockAlertsFilters(); // Re-apply filters for alerts modal
        closeModal('minimumLevelsModal');
    }

    function openEmailAlertsModal() {
        openModal('emailAlertsModal');
    }

    function exportLowStockReport() {
        let csvContent = "Product Name,SKU,Current Stock,Minimum Stock,Alert Level,Days Supply,Last Restock\n";

        filteredLowStockAlertsData.forEach(item => {
            csvContent += `"${item.name}",${item.sku},${item.currentStock},${item.minStock},${item.alertLevel},${item.daysSupply},${item.lastRestock}\n`;
        });

        const blob = new Blob([csvContent], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.setAttribute('hidden', '');
        a.setAttribute('href', url);
        a.setAttribute('download', 'low_stock_report_' + new Date().toISOString().split('T')[0] + '.csv');
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);

        showNotification('Low stock report exported successfully!', 'success');
    }
</script>
