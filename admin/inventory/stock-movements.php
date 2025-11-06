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
// Stock Movements Modal Functions with API Integration

let currentStockMovementPage = 1;
const stockMovementsPerPage = 10;
let filteredStockMovementsData = [];

function normalizeImagePath(path) {
  if (!path) return '';
  // Absolute URLs or already absolute-from-root
  if (path.startsWith('http://') || path.startsWith('https://') || path.startsWith('/')) return path;
  // If API already returns a '../' prefixed relative path, keep as-is
  if (path.startsWith('../')) return path;
  // From /admin/inventory/* to project root path for plain relative paths
  return `../../${path.replace(/^\.\/?/, '')}`;
}

async function openStockMovementsModal() {
populateMovementProductFilter();
await applyStockMovementFilters();
openModal('stockMovementsModal');
}

function populateMovementProductFilter() {
const select = document.getElementById('movementProductFilter');
select.innerHTML = '<option value="">All Products</option>';

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

async function applyStockMovementFilters() {
const productId = document.getElementById('movementProductFilter').value;
const type = document.getElementById('movementTypeFilter').value;
const reason = document.getElementById('movementReasonFilter').value;
const startDate = document.getElementById('movementStartDate').value;
const endDate = document.getElementById('movementEndDate').value;

try {
    const params = {
        page: currentStockMovementPage,
        pageSize: stockMovementsPerPage
    };

    if (productId) params.productId = productId;
    if (type) params.type = type;
    if (reason) params.reason = reason;
    if (startDate) params.startDate = startDate;
    if (endDate) params.endDate = endDate;

    const response = await InventoryAPI.getMovements(params);

    if (response.success) {
        filteredStockMovementsData = response.movements;
        populateStockMovementsTable(response.movements, response.total);
        updateStockMovementsSummary(response.summary);
    }
} catch (error) {
    console.error('Error loading movements:', error);
    showNotification('Error loading stock movements', 'error');
}
}

function populateStockMovementsTable(data, total) {
const tbody = document.getElementById('stockMovementsTableBody');
tbody.innerHTML = '';

if (data.length === 0) {
    tbody.innerHTML = `<tr><td colspan="10" style="text-align: center; padding: 2rem; color: #64748b;">No stock movements found matching your criteria.</td></tr>`;
    updateStockMovementPagination(0);
    return;
}

data.forEach(movement => {
    const row = tbody.insertRow();
    const product = inventoryData.find(item => item.id === movement.productId);
    const icon = product ? (product.icon || '📦') : '📦';
    const imgSrc = movement.productImage
        ? normalizeImagePath(movement.productImage)
        : (product && product.image ? normalizeImagePath(product.image) : '');

    let typeClass = '';
    let quantityClass = '';
    let quantitySign = '';

    switch (movement.type) {
        case 'add':
            typeClass = 'add';
            quantityClass = 'add';
            quantitySign = '+';
            break;
        case 'remove':
            typeClass = 'remove';
            quantityClass = 'remove';
            quantitySign = '-';
            break;
        case 'adjust':
            typeClass = 'adjust';
            quantityClass = movement.quantity > 0 ? 'add' : 'remove';
            quantitySign = movement.quantity > 0 ? '+' : '';
            break;
    }

    row.innerHTML = `
        <td>${movement.id}</td>
        <td>
            <div class="stock-movements-movement-cell">
                <div class="stock-movements-movement-icon ${typeClass}">
                  ${imgSrc
                    ? `<img src="${imgSrc}" alt="${movement.productName}" style="width:40px;height:40px;object-fit:cover;border-radius:4px;" onerror="this.style.display='none'; this.closest('.stock-movements-movement-icon').textContent='📦';">`
                    : `${icon}`}
                </div>
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
            </div>
        </td>
    `;
});

updateStockMovementPagination(total);
if (typeof lucide !== 'undefined') {
    lucide.createIcons();
}
}

function updateStockMovementsSummary(summary) {
document.getElementById('totalAdditions').textContent = summary.totalAdditions || 0;
document.getElementById('totalRemovals').textContent = summary.totalRemovals || 0;
document.getElementById('totalAdjustments').textContent = summary.totalAdjustments || 0;
document.getElementById('netChange').textContent = summary.netChange || 0;
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

async function changeStockMovementPage(page) {
const totalPages = Math.ceil(filteredStockMovementsData.length / stockMovementsPerPage);

if (page === 'prev' && currentStockMovementPage > 1) {
    currentStockMovementPage--;
} else if (page === 'next' && currentStockMovementPage < totalPages) {
    currentStockMovementPage++;
} else if (typeof page === 'number' && page >= 1 && page <= totalPages) {
    currentStockMovementPage = page;
}

await applyStockMovementFilters();
}

async function openMovementDetailsModal(movementId) {
const movement = filteredStockMovementsData.find(m => m.id === movementId);

if (movement) {
    const detailsContent = document.getElementById('movementDetailsContent');
    const product = inventoryData.find(item => item.id === movement.productId);
    const imgSrc = movement.productImage
        ? normalizeImagePath(movement.productImage)
        : (product && product.image ? normalizeImagePath(product.image) : '');
    detailsContent.innerHTML = `
        <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1rem;">
            ${imgSrc ? `<img src="${imgSrc}" alt="${movement.productName}" style="width:64px;height:64px;object-fit:cover;border-radius:8px;" onerror="this.style.display='none';">` : ''}
            <div>
                <div style="font-weight:600;color:#1e293b;">${movement.productName}</div>
                <div style="color:#64748b;">${movement.productSKU}</div>
            </div>
        </div>
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
</script>
