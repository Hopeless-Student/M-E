<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulk Actions - M & E Dashboard</title>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <link rel="stylesheet" href="../assets/css/admin/products/bulk.css">
</head>
<body>
    <div class="dashboard">
        <!-- Sidebar -->
        <?php include '../../includes/admin_sidebar.php'; ?>

        <!-- Main Content -->
        <main class="main-content">
            <div class="header">
                <h2>Bulk Actions</h2>
                <div class="user-info">
                    <span>Admin Panel</span>
                    <div class="avatar">A</div>
                </div>
            </div>

            <div class="breadcrumb">
                <a href="./index.php">Products</a>
                <span>></span>
                <span>Bulk Actions</span>
            </div>

            <div class="bulk-container">

                <div class="bulk-controls">
                    <div class="selection-info">
                        <span class="selected-count" id="selectedCount">0 selected</span>
                        <button class="action-btn" onclick="selectAll()">
                            <span data-lucide="mouse-pointer-click"></span>
                            Select All
                        </button>
                        <button class="action-btn" onclick="clearSelection()">
                            <span data-lucide="circle-x"></span>
                            Clear
                        </button>
                    </div>
                    <div class="bulk-actions">
                        <button class="action-btn primary" onclick="openModal('edit')" id="editBtn" disabled>
                            <span data-lucide="pencil"></span>
                            Edit Selected
                        </button>
                        <button class="action-btn warning" onclick="openModal('stock')" id="stockBtn" disabled>
                            <span data-lucide="refresh-ccw-dot"></span>
                            Update Stock
                        </button>
                        <button class="action-btn danger" onclick="openModal('delete')" id="deleteBtn" disabled>
                            <span data-lucide="trash"></span>
                            Delete Selected
                        </button>
                    </div>
                </div>

                <table class="products-table">
                    <thead class="table-header">
                        <tr>
                            <th class="checkbox-cell">
                                <input type="checkbox" id="selectAllCheckbox" class="product-checkbox" onchange="toggleSelectAll()">
                            </th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="productsTableBody">
                        <!-- Products will be loaded here -->
                    </tbody>
                </table>
                <div class="pagination">
                    <div class="pagination-info">
                        Showing 1-8 of 267 orders
                    </div>
                    <div class="pagination-controls">
                        <button class="page-btn">Previous</button>
                        <button class="page-btn active">1</button>
                        <button class="page-btn">2</button>
                        <button class="page-btn">3</button>
                        <button class="page-btn">4</button>
                        <button class="page-btn">Next</button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Edit Modal -->
    <div class="modal" id="editModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit Selected Products</h3>
                <p class="modal-subtitle">Changes will be applied to all selected products</p>
            </div>
            <form id="editForm">
                <div class="form-group">
                    <label class="form-label">Category</label>
                    <select class="form-select" id="editCategory">
                        <option value="">Keep current category</option>
                        <option value="office">Office Supplies</option>
                        <option value="school">School Supplies</option>
                        <option value="sanitary">Sanitary Supplies</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Price Adjustment (%)</label>
                    <input type="number" class="form-input" id="priceAdjustment" placeholder="e.g., 10 for 10% increase, -5 for 5% decrease">
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('edit')">Cancel</button>
                    <button type="submit" class="btn btn-primary">Apply Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Stock Update Modal -->
    <div class="modal" id="stockModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Update Stock</h3>
                <p class="modal-subtitle">Update stock quantities for selected products</p>
            </div>
            <form id="stockForm">
                <div class="form-group">
                    <label class="form-label">Action</label>
                    <select class="form-select" id="stockAction" onchange="toggleStockInput()">
                        <option value="add">Add to current stock</option>
                        <option value="subtract">Subtract from current stock</option>
                        <option value="set">Set exact stock quantity</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" id="stockLabel">Quantity to add</label>
                    <input type="number" class="form-input" id="stockQuantity" min="0" required>
                </div>
                <div class="modal-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('stock')">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Stock</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal" id="deleteModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Delete Products</h3>
                <p class="modal-subtitle">Are you sure you want to delete the selected products?</p>
            </div>
            <div style="margin: 1.5rem 0;">
                <p style="color: #dc2626; font-weight: 500;">⚠️ This action cannot be undone!</p>
                <p style="color: #64748b; margin-top: 0.5rem;">This will permanently delete <span id="deleteCount">0</span> products and all associated data.</p>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" onclick="closeModal('delete')">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="confirmDelete()">Delete Products</button>
            </div>
        </div>
    </div>

    <!-- Alert Container -->
    <div class="alert" id="alertContainer"></div>

    <script>
        lucide.createIcons();
        // Products data loaded from API
        let products = [];

        let selectedProducts = new Set();

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            loadProducts();
            setupEventListeners();
        });

        async function loadProducts() {
            try {
                const res = await fetch(`../../api/admin/products/list.php?page=1&pageSize=200&_=${Date.now()}` , { headers: { 'Accept': 'application/json' }, cache: 'no-store' });
                if (!res.ok) throw new Error('Failed to load products');
                const data = await res.json();
                products = (data.items || []).map(p => ({
                    id: p.id,
                    name: p.name,
                    category: (p.category || '').toLowerCase().includes('office') ? 'office' : (p.category || '').toLowerCase().includes('school') ? 'school' : 'sanitary',
                    categoryLabel: p.categoryLabel || p.category || '',
                    price: Number(p.price || 0),
                    stock: Number(p.stock || 0),
                    image: p.image ? `<img src="${p.image}" alt="${p.name}" style="width:24px;height:24px;border-radius:4px;object-fit:cover;" />` : '📦'
                }));
                // reset selection after reload
                selectedProducts.clear();
                renderProducts();
                updateSelectionUI();
            } catch (e) {
                console.error(e);
                showAlert('Failed to load products', 'error');
            }
        }

        function setupEventListeners() {
            document.getElementById('editForm').addEventListener('submit', handleEdit);
            document.getElementById('stockForm').addEventListener('submit', handleStockUpdate);
        }

        function renderProducts() {
            const tbody = document.getElementById('productsTableBody');
            tbody.innerHTML = products.map(product => {
                const stockStatus = getStockStatus(product.stock);
                const stockLabel = getStockLabel(product.stock);

                return `
                    <tr class="table-row" id="row-${product.id}">
                        <td class="table-cell checkbox-cell">
                            <input type="checkbox" class="product-checkbox"
                                   value="${product.id}"
                                   onchange="toggleProduct(${product.id})">
                        </td>
                        <td class="table-cell">
                            <div class="product-info">
                                <div class="product-image">${product.image}</div>
                                <div class="product-details">
                                    <h4>${product.name}</h4>
                                    <p>ID: ${product.id}</p>
                                </div>
                            </div>
                        </td>
                        <td class="table-cell">
                            <span class="category-badge">${product.categoryLabel}</span>
                        </td>
                        <td class="table-cell">
                            <span class="price">₱${product.price}</span>
                        </td>
                        <td class="table-cell">
                            ${product.stock} units
                        </td>
                        <td class="table-cell">
                            <span class="stock-status ${stockStatus}">${stockLabel}</span>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        function getStockStatus(stock) {
            if (stock === 0) return 'out-of-stock';
            if (stock <= 15) return 'low-stock';
            return 'in-stock';
        }

        function getStockLabel(stock) {
            if (stock === 0) return 'Out of Stock';
            if (stock <= 15) return 'Low Stock';
            return 'In Stock';
        }

        function toggleProduct(productId) {
            const checkbox = document.querySelector(`input[value="${productId}"]`);
            const row = document.getElementById(`row-${productId}`);

            if (checkbox.checked) {
                selectedProducts.add(productId);
                row.classList.add('selected');
            } else {
                selectedProducts.delete(productId);
                row.classList.remove('selected');
            }

            updateSelectionUI();
        }

        function toggleSelectAll() {
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            const productCheckboxes = document.querySelectorAll('.product-checkbox:not(#selectAllCheckbox)');

            productCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
                const productId = parseInt(checkbox.value);
                const row = document.getElementById(`row-${productId}`);

                if (selectAllCheckbox.checked) {
                    selectedProducts.add(productId);
                    row.classList.add('selected');
                } else {
                    selectedProducts.delete(productId);
                    row.classList.remove('selected');
                }
            });

            updateSelectionUI();
        }

        function selectAll() {
            document.getElementById('selectAllCheckbox').checked = true;
            toggleSelectAll();
        }

        function clearSelection() {
            selectedProducts.clear();
            document.querySelectorAll('.product-checkbox').forEach(checkbox => {
                checkbox.checked = false;
            });
            document.querySelectorAll('.table-row').forEach(row => {
                row.classList.remove('selected');
            });
            updateSelectionUI();
        }

        function updateSelectionUI() {
            const count = selectedProducts.size;
            document.getElementById('selectedCount').textContent = `${count} selected`;

            const hasSelection = count > 0;
            document.getElementById('editBtn').disabled = !hasSelection;
            document.getElementById('stockBtn').disabled = !hasSelection;
            document.getElementById('deleteBtn').disabled = !hasSelection;

            // Update select all checkbox state
            const totalProducts = products.length;
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');

            if (count === 0) {
                selectAllCheckbox.indeterminate = false;
                selectAllCheckbox.checked = false;
            } else if (count === totalProducts) {
                selectAllCheckbox.indeterminate = false;
                selectAllCheckbox.checked = true;
            } else {
                selectAllCheckbox.indeterminate = true;
            }
        }

        function openModal(type) {
            if (selectedProducts.size === 0) return;

            if (type === 'edit') {
                document.getElementById('editModal').classList.add('show');
            } else if (type === 'stock') {
                document.getElementById('stockModal').classList.add('show');
            } else if (type === 'delete') {
                document.getElementById('deleteCount').textContent = selectedProducts.size;
                document.getElementById('deleteModal').classList.add('show');
            }
        }

        function closeModal(type) {
            if (type === 'edit') {
                document.getElementById('editModal').classList.remove('show');
                document.getElementById('editForm').reset();
            } else if (type === 'stock') {
                document.getElementById('stockModal').classList.remove('show');
                document.getElementById('stockForm').reset();
            } else if (type === 'delete') {
                document.getElementById('deleteModal').classList.remove('show');
            }
        }

        function toggleStockInput() {
            const action = document.getElementById('stockAction').value;
            const label = document.getElementById('stockLabel');

            switch(action) {
                case 'add':
                    label.textContent = 'Quantity to add';
                    break;
                case 'subtract':
                    label.textContent = 'Quantity to subtract';
                    break;
                case 'set':
                    label.textContent = 'New stock quantity';
                    break;
            }
        }

        async function handleEdit(e) {
            e.preventDefault();

            const category = document.getElementById('editCategory').value;
            const priceAdjustment = document.getElementById('priceAdjustment').value;

            try {
                const res = await fetch('../../api/admin/products/bulk-update.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        ids: Array.from(selectedProducts),
                        category,
                        priceAdjustment: priceAdjustment ? parseFloat(priceAdjustment) : null
                    })
                });
                if (!res.ok) throw new Error('Bulk update failed');
                showAlert(`Successfully updated ${selectedProducts.size} products!`, 'success');
                closeModal('edit');
                await loadProducts();
            } catch (err) {
                console.error(err);
                showAlert('Bulk update failed', 'error');
            }
        }

        async function handleStockUpdate(e) {
            e.preventDefault();

            const action = document.getElementById('stockAction').value;
            const quantity = parseInt(document.getElementById('stockQuantity').value);

            try {
                const res = await fetch('../../api/admin/products/bulk-stock.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        ids: Array.from(selectedProducts),
                        action,
                        quantity
                    })
                });
                if (!res.ok) throw new Error('Bulk stock update failed');
                showAlert(`Stock ${action === 'set' ? 'set' : action === 'add' ? 'increased' : 'decreased'} for ${selectedProducts.size} products!`, 'success');
                closeModal('stock');
                await loadProducts();
            } catch (err) {
                console.error(err);
                showAlert('Bulk stock update failed', 'error');
            }
        }

        async function confirmDelete() {
            try {
                const res = await fetch('../../api/admin/products/delete.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ ids: Array.from(selectedProducts) })
                });
                if (!res.ok) throw new Error('Bulk delete failed');
                showAlert(`Successfully deleted ${selectedProducts.size} products!`, 'success');
                selectedProducts.clear();
                updateSelectionUI();
                closeModal('delete');
                await loadProducts();
            } catch (err) {
                console.error(err);
                showAlert('Bulk delete failed', 'error');
            }
        }

        function showAlert(message, type) {
            const alert = document.getElementById('alertContainer');
            alert.textContent = message;
            alert.className = `alert ${type}`;
            alert.classList.add('show');

            setTimeout(() => {
                alert.classList.remove('show');
            }, 3000);
        }

        // Close modals on backdrop click
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal')) {
                const modalId = e.target.id;
                if (modalId === 'editModal') closeModal('edit');
                else if (modalId === 'stockModal') closeModal('stock');
                else if (modalId === 'deleteModal') closeModal('delete');
            }
        });

        // Close modals on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const openModal = document.querySelector('.modal.show');
                if (openModal) {
                    const modalId = openModal.id;
                    if (modalId === 'editModal') closeModal('edit');
                    else if (modalId === 'stockModal') closeModal('stock');
                    else if (modalId === 'deleteModal') closeModal('delete');
                }
            }
        });
    </script>
</body>
</html>
