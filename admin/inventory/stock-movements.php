<!-- Stock Movements Modal -->
<div id="stockMovementsModal" class="modal-base">
    <div class="modal-content extra-large-modal">
        <div class="modal-header">
            <h3 class="modal-title"><i data-lucide="activity"></i> Stock Movements</h3>
            <button class="modal-close-btn" onclick="closeModal('stockMovementsModal')"><i data-lucide="x"></i></button>
        </div>

        <div class="stock-movements-summary">
            <div class="stock-movements-summary-card add">
                <div class="stock-movements-summary-icon"><i data-lucide="plus-circle"></i></div>
                <div class="stock-movements-summary-title">Total Additions</div>
                <div class="stock-movements-summary-value" id="totalAdditions">0</div>
                <div class="stock-movements-summary-subtitle">Units added</div>
            </div>
            <div class="stock-movements-summary-card remove">
                <div class="stock-movements-summary-icon"><i data-lucide="minus-circle"></i></div>
                <div class="stock-movements-summary-title">Total Removals</div>
                <div class="stock-movements-summary-value" id="totalRemovals">0</div>
                <div class="stock-movements-summary-subtitle">Units removed</div>
            </div>
            <div class="stock-movements-summary-card adjust">
                <div class="stock-movements-summary-icon"><i data-lucide="arrow-left-right"></i></div>
                <div class="stock-movements-summary-title">Total Adjustments</div>
                <div class="stock-movements-summary-value" id="totalAdjustments">0</div>
                <div class="stock-movements-summary-subtitle">Manual corrections</div>
            </div>
            <div class="stock-movements-summary-card net">
                <div class="stock-movements-summary-icon"><i data-lucide="trending-up"></i></div>
                <div class="stock-movements-summary-title">Net Change</div>
                <div class="stock-movements-summary-value" id="netChange">0</div>
                <div class="stock-movements-summary-subtitle">Overall stock impact</div>
            </div>
        </div>

        <div class="stock-movements-controls">
            <h3 class="stock-movements-controls-title">Filter Movements</h3>
            <div class="stock-movements-filter-grid">
                <div class="form-group stock-movements-form-group">
                    <label class="stock-movements-form-label">Product</label>
                    <select class="form-select stock-movements-form-select" id="movementProductFilter">
                        <option value="">All Products</option>
                        <!-- Options populated by JS -->
                    </select>
                </div>
                <div class="form-group stock-movements-form-group">
                    <label class="stock-movements-form-label">Movement Type</label>
                    <select class="form-select stock-movements-form-select" id="movementTypeFilter">
                        <option value="">All Types</option>
                        <option value="add">Add</option>
                        <option value="remove">Remove</option>
                        <option value="adjust">Adjust</option>
                        <option value="transfer">Transfer</option>
                    </select>
                </div>
                <div class="form-group stock-movements-form-group">
                    <label class="stock-movements-form-label">Reason</label>
                    <select class="form-select stock-movements-form-select" id="movementReasonFilter">
                        <option value="">All Reasons</option>
                        <option value="delivery">New Delivery</option>
                        <option value="sale">Sale</option>
                        <option value="damaged">Damaged</option>
                        <option value="recount">Recount</option>
                        <option value="return">Customer Return</option>
                        <option value="theft">Theft</option>
                    </select>
                </div>
                <div class="form-group stock-movements-form-group">
                    <label class="stock-movements-form-label">Date Range</label>
                    <div class="stock-movements-date-range">
                        <input type="date" class="form-input stock-movements-form-input" id="movementStartDate">
                        <input type="date" class="form-input stock-movements-form-input" id="movementEndDate">
                    </div>
                </div>
                <button class="stock-movements-apply-btn" onclick="applyStockMovementFilters()">Apply Filters</button>
            </div>
        </div>

        <div class="stock-movements-table-section">
            <div class="stock-movements-table-container">
                <table class="stock-movements-table">
                    <thead>
                        <tr>
                            <th>Movement ID</th>
                            <th>Product</th>
                            <th>Type</th>
                            <th>Quantity</th>
                            <th>Previous Stock</th>
                            <th>New Stock</th>
                            <th>Reason</th>
                            <th>User</th>
                            <th>Timestamp</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="stockMovementsTableBody">
                        <!-- Movements populated by JS -->
                    </tbody>
                </table>
            </div>

            <div class="stock-movements-pagination">
                <div class="stock-movements-pagination-info">
                    Showing <span id="movementStartItem">1</span>-<span id="movementEndItem">10</span> of <span id="movementTotalItems">0</span> movements
                </div>
                <div class="stock-movements-pagination-controls">
                    <button class="stock-movements-page-btn" id="movementPrevBtn" onclick="changeStockMovementPage('prev')">← Previous</button>
                    <span id="movementPageNumbers"></span>
                    <button class="stock-movements-page-btn" id="movementNextBtn" onclick="changeStockMovementPage('next')">Next →</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Movement Details Modal -->
<div id="movementDetailsModal" class="modal-base">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title"><i data-lucide="file-text"></i> Movement Details</h3>
            <button class="modal-close-btn" onclick="closeModal('movementDetailsModal')"><i data-lucide="x"></i></button>
        </div>
        <div id="movementDetailsContent">
            <!-- Details will be populated here -->
        </div>
        <div class="form-actions">
            <button type="button" class="btn btn-secondary" onclick="closeModal('movementDetailsModal')">Close</button>
        </div>
    </div>
</div>

<script>
    let currentStockMovementProductId = null;
    let currentStockMovementReason = null;
    let currentStockMovementType = null;
    let currentStockMovementStartDate = null;
    let currentStockMovementEndDate = null;
    let currentStockMovementPage = 1;
    const stockMovementsPerPage = 10;
    // Ensure stockMovementsData is defined before spreading
    let filteredStockMovementsData = (typeof window.stockMovementsData !== 'undefined' && window.stockMovementsData.length > 0) ? [...window.stockMovementsData] : [];
    let currentMovementDetails = null; // For movement details modal

    function openStockMovementsModal() {
        populateMovementProductFilter();
        applyStockMovementFilters(); // Initial population and filtering
        openModal('stockMovementsModal');
    }

    function populateMovementProductFilter() {
        const select = document.getElementById('movementProductFilter');
        select.innerHTML = '<option value="">All Products</option>';
        // Ensure inventoryData is available before using it
        if (typeof inventoryData !== 'undefined' && inventoryData.length > 0) {
            inventoryData.forEach(item => {
                const option = document.createElement('option');
                option.value = item.id;
                option.textContent = item.name;
                select.appendChild(option);
            });
        }
    }

    function setupStockMovementsModalListeners() {
        document.getElementById('movementProductFilter').addEventListener('change', applyStockMovementFilters);
        document.getElementById('movementTypeFilter').addEventListener('change', applyStockMovementFilters);
        document.getElementById('movementReasonFilter').addEventListener('change', applyStockMovementFilters);
        document.getElementById('movementStartDate').addEventListener('change', applyStockMovementFilters);
        document.getElementById('movementEndDate').addEventListener('change', applyStockMovementFilters);
    }

    function applyStockMovementFilters() {
        const productId = document.getElementById('movementProductFilter').value;
        const type = document.getElementById('movementTypeFilter').value;
        const reason = document.getElementById('movementReasonFilter').value;
        const startDate = document.getElementById('movementStartDate').value;
        const endDate = document.getElementById('movementEndDate').value;

        // Ensure stockMovementsData is defined before filtering
        const dataToFilter = (typeof window.stockMovementsData !== 'undefined' && window.stockMovementsData.length > 0) ? window.stockMovementsData : [];

        filteredStockMovementsData = dataToFilter.filter(movement => {
            const matchesProduct = !productId || movement.productId == productId;
            const matchesType = !type || movement.type === type;
            const matchesReason = !reason || movement.reason === reason;

            let matchesDate = true;
            if (startDate) {
                matchesDate = matchesDate && new Date(movement.timestamp) >= new Date(startDate);
            }
            if (endDate) {
                // Set end date to end of day for inclusive filtering
                const endOfDay = new Date(endDate);
                endOfDay.setHours(23, 59, 59, 999);
                matchesDate = matchesDate && new Date(movement.timestamp) <= endOfDay;
            }
            return matchesProduct && matchesType && matchesReason && matchesDate;
        });

        currentStockMovementPage = 1;
        populateStockMovementsTable(filteredStockMovementsData);
        updateStockMovementsSummary(filteredStockMovementsData);
    }

    function populateStockMovementsTable(data) {
        const tbody = document.getElementById('stockMovementsTableBody');
        tbody.innerHTML = '';

        const startIndex = (currentStockMovementPage - 1) * stockMovementsPerPage;
        const endIndex = startIndex + stockMovementsPerPage;
        const pageData = data.slice(startIndex, endIndex);

        if (pageData.length === 0) {
            tbody.innerHTML = `<tr><td colspan="10" style="text-align: center; padding: 2rem; color: #64748b;">No stock movements found matching your criteria.</td></tr>`;
            updateStockMovementPagination(data.length);
            return;
        }

        pageData.forEach(movement => {
            const row = tbody.insertRow();
            // Ensure inventoryData is available before using it
            const product = typeof inventoryData !== 'undefined' ? inventoryData.find(item => item.id === movement.productId) : null;
            const icon = product ? product.icon : '📦'; // Default icon if product not found

            let typeClass = '';
            let quantityClass = '';
            let quantitySign = '';
            let impactClass = '';

            switch (movement.type) {
                case 'add':
                    typeClass = 'add';
                    quantityClass = 'add';
                    quantitySign = '+';
                    impactClass = 'positive';
                    break;
                case 'remove':
                    typeClass = 'remove';
                    quantityClass = 'remove';
                    quantitySign = '-';
                    impactClass = 'negative';
                    break;
                case 'adjust':
                    typeClass = 'adjust';
                    quantityClass = movement.quantity > 0 ? 'add' : 'remove';
                    quantitySign = movement.quantity > 0 ? '+' : '';
                    impactClass = movement.quantity > 0 ? 'positive' : 'negative';
                    break;
                case 'transfer':
                    typeClass = 'transfer';
                    quantityClass = movement.quantity > 0 ? 'add' : 'remove';
                    quantitySign = movement.quantity > 0 ? '+' : '';
                    impactClass = movement.quantity > 0 ? 'positive' : 'negative';
                    break;
            }

            row.innerHTML = `
                <td>${movement.id}</td>
                <td>
                    <div class="stock-movements-movement-cell">
                        <div class="stock-movements-movement-icon ${typeClass}">${icon}</div>
                        <div class="stock-movements-movement-details">
                            <h4>${movement.productName}</h4>
                            <p>${movement.productSKU}</p>
                        </div>
                    </div>
                </td>
                <td><span class="stock-movements-movement-type ${typeClass}">${capitalizeFirst(movement.type)}</span></td>
                <td><span class="stock-movements-quantity ${quantityClass}">${quantitySign}${Math.abs(movement.quantity)}</span></td>
                <td>${movement.previousStock}</td>
                <td>${movement.newStock}</td>
                <td>${movement.reason}</td>
                <td>${movement.user}</td>
                <td>${movement.timestamp}</td>
                <td>
                    <div class="stock-movements-actions-container">
                        <button class="stock-movements-action-btn view" onclick="openMovementDetailsModal(${movement.id})">
                            <i data-lucide="eye" style="width:16px; height:16px;"></i> View
                        </button>
                        <button class="stock-movements-action-btn reverse" onclick="confirmReverseMovement(${movement.id})">
                            <i data-lucide="rotate-ccw" style="width:16px; height:16px;"></i> Reverse
                        </button>
                    </div>
                </td>
            `;
        });
        updateStockMovementPagination(data.length);
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }

    function updateStockMovementsSummary(data) {
        let totalAdditions = 0;
        let totalRemovals = 0;
        let totalAdjustments = 0;
        let netChange = 0;

        data.forEach(movement => {
            if (movement.type === 'add') {
                totalAdditions += movement.quantity;
                netChange += movement.quantity;
            } else if (movement.type === 'remove') {
                totalRemovals += movement.quantity;
                netChange -= movement.quantity;
            } else if (movement.type === 'adjust') {
                totalAdjustments += Math.abs(movement.quantity);
                netChange += movement.quantity; // Adjustments can be positive or negative
            } else if (movement.type === 'transfer') {
                // For simplicity, transfers are counted as adjustments in summary
                totalAdjustments += Math.abs(movement.quantity);
                netChange += movement.quantity;
            }
        });

        document.getElementById('totalAdditions').textContent = totalAdditions;
        document.getElementById('totalRemovals').textContent = totalRemovals;
        document.getElementById('totalAdjustments').textContent = totalAdjustments;
        document.getElementById('netChange').textContent = netChange;
    }

    function updateStockMovementPagination(totalItems) {
        const totalPages = Math.ceil(totalItems / stockMovementsPerPage);
        const startItem = totalItems === 0 ? 0 : (currentStockMovementPage - 1) * stockMovementsPerPage + 1;
        const endItem = Math.min(currentStockMovementPage * stockMovementsPerPage, totalItems);

        document.getElementById('movementStartItem').textContent = startItem;
        document.getElementById('movementEndItem').textContent = endItem;
        document.getElementById('movementTotalItems').textContent = totalItems;

        const prevBtn = document.getElementById('movementPrevBtn');
        const nextBtn = document.getElementById('movementNextBtn');
        const pageNumbersContainer = document.getElementById('movementPageNumbers');

        prevBtn.disabled = currentStockMovementPage === 1;
        nextBtn.disabled = currentStockMovementPage === totalPages || totalPages === 0;

        pageNumbersContainer.innerHTML = '';
        for (let i = 1; i <= totalPages; i++) {
            const pageBtn = document.createElement('button');
            pageBtn.className = `stock-movements-page-btn ${i === currentStockMovementPage ? 'active' : ''}`;
            pageBtn.textContent = i;
            pageBtn.onclick = () => changeStockMovementPage(i);
            pageNumbersContainer.appendChild(pageBtn);
        }
    }

    function changeStockMovementPage(page) {
        const totalPages = Math.ceil(filteredStockMovementsData.length / stockMovementsPerPage);

        if (page === 'prev' && currentStockMovementPage > 1) {
            currentStockMovementPage--;
        } else if (page === 'next' && currentStockMovementPage < totalPages) {
            currentStockMovementPage++;
        } else if (typeof page === 'number' && page >= 1 && page <= totalPages) {
            currentStockMovementPage = page;
        }
        populateStockMovementsTable(filteredStockMovementsData);
    }

    function openMovementDetailsModal(movementId) {
        // Ensure stockMovementsData is available
        if (typeof stockMovementsData === 'undefined') {
            showNotification('Error: Stock movements data not loaded.', 'error');
            return;
        }
        const movement = stockMovementsData.find(m => m.id === movementId);
        if (movement) {
            const detailsContent = document.getElementById('movementDetailsContent');
            detailsContent.innerHTML = `
                <div class="product-details-grid">
                    <div class="product-details-card">
                        <div class="product-details-label">Movement ID</div>
                        <div class="product-details-value">${movement.id}</div>
                    </div>
                    <div class="product-details-card">
                        <div class="product-details-label">Product Name</div>
                        <div class="product-details-value">${movement.productName}</div>
                    </div>
                    <div class="product-details-card">
                        <div class="product-details-label">Product SKU</div>
                        <div class="product-details-value">${movement.productSKU}</div>
                    </div>
                    <div class="product-details-card">
                        <div class="product-details-label">Type</div>
                        <div class="product-details-value">${capitalizeFirst(movement.type)}</div>
                    </div>
                    <div class="product-details-card">
                        <div class="product-details-label">Quantity</div>
                        <div class="product-details-value">${movement.quantity > 0 ? '+' : ''}${movement.quantity}</div>
                    </div>
                    <div class="product-details-card">
                        <div class="product-details-label">Previous Stock</div>
                        <div class="product-details-value">${movement.previousStock}</div>
                    </div>
                    <div class="product-details-card">
                        <div class="product-details-label">New Stock</div>
                        <div class="product-details-value">${movement.newStock}</div>
                    </div>
                    <div class="product-details-card">
                        <div class="product-details-label">Reason</div>
                        <div class="product-details-value">${movement.reason}</div>
                    </div>
                    <div class="product-details-card">
                        <div class="product-details-label">User</div>
                        <div class="product-details-value">${movement.user}</div>
                    </div>
                    <div class="product-details-card">
                        <div class="product-details-label">Timestamp</div>
                        <div class="product-details-value">${movement.timestamp}</div>
                    </div>
                </div>
            `;
            openModal('movementDetailsModal');
        } else {
            showNotification('Error: Movement details not found.', 'error');
        }
    }

    function confirmReverseMovement(movementId) {
        // Ensure stockMovementsData is available
        if (typeof stockMovementsData === 'undefined') {
            showNotification('Error: Stock movements data not loaded.', 'error');
            return;
        }
        const movement = stockMovementsData.find(m => m.id === movementId);
        if (movement) {
            openConfirmationModal(`Are you sure you want to reverse movement ID ${movement.id} for "${movement.productName}"? This will adjust stock back to ${movement.previousStock}.`, () => {
                reverseMovement(movementId);
            });
        } else {
            showNotification('Error: Movement not found for reversal.', 'error');
        }
    }

    function reverseMovement(movementId) {
        // Ensure stockMovementsData and inventoryData are available
        if (typeof stockMovementsData === 'undefined' || typeof inventoryData === 'undefined') {
            showNotification('Error: Required data not loaded for reversal.', 'error');
            return;
        }

        const movementIndex = stockMovementsData.findIndex(m => m.id === movementId);
        if (movementIndex !== -1) {
            const movement = stockMovementsData[movementIndex];
            const productIndex = inventoryData.findIndex(item => item.id === movement.productId);

            if (productIndex !== -1) {
                const product = inventoryData[productIndex];
                // Revert stock to previous state
                product.stock = movement.previousStock;

                // Add a new movement entry for the reversal
                const newMovement = {
                    id: stockMovementsData.length + 1, // Simple ID generation
                    productId: movement.productId,
                    productName: movement.productName,
                    productSKU: movement.productSKU,
                    type: 'adjust', // Reversal is a type of adjustment
                    quantity: movement.previousStock - movement.newStock, // Quantity to add/remove to revert
                    previousStock: movement.newStock,
                    newStock: movement.previousStock,
                    reason: `Reversal of Movement ID ${movement.id} (${movement.reason})`,
                    user: 'Admin (Reversal)',
                    timestamp: new Date().toLocaleString([], {hour: '2-digit', minute:'2-digit', year: 'numeric', month: '2-digit', day: '2-digit'})
                };
                stockMovementsData.unshift(newMovement); // Add to beginning

                showNotification(`Movement ID ${movementId} reversed successfully!`, 'success');
                updateAllDataAndUI(); // Refresh all dashboard data and UI
                applyStockMovementFilters(); // Re-apply filters for movements modal
            } else {
                showNotification('Error: Product for movement not found.', 'error');
            }
        } else {
            showNotification('Error: Movement not found.', 'error');
        }
    }
</script>
