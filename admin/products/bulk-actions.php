<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulk Actions - M & E Dashboard</title>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
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

        .nav-link .lucide {
            margin-right: 1rem;
            width: 20px;
            height: 20px;
        }
        /* Main Content */
        .main-content {
            flex: 1;
            padding: 2rem;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .header h2 {
            font-size: 2rem;
            font-weight: 600;
            color: #1e40af;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 2rem;
            color: #64748b;
        }

        .breadcrumb a {
            color: #1e40af;
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
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

        /* Bulk Actions Container */
        .bulk-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .bulk-header {
            padding: 2rem;
            border-bottom: 1px solid #e5e7eb;
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
        }

        .bulk-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 0.5rem;
        }

        .bulk-subtitle {
            color: #64748b;
        }

        .bulk-controls {
            padding: 1.5rem 2rem;
            background: #f8fafc;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
        }

        .selection-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .selected-count {
            background: #1e40af;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .bulk-actions {
            display: flex;
            gap: 0.5rem;
        }

        .action-btn {
            padding: 0.5rem 1rem;
            border: 1px solid #d1d5db;
            background: white;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .action-btn:hover:not(:disabled) {
            background: #f8fafc;
            transform: translateY(-1px);
        }

        .action-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        .action-btn.primary {
            background: #1e40af;
            color: white;
            border-color: #1e40af;
        }

        .action-btn.primary:hover:not(:disabled) {
            background: #1e3a8a;
        }

        .action-btn.danger {
            background: #dc2626;
            color: white;
            border-color: #dc2626;
        }

        .action-btn.danger:hover:not(:disabled) {
            background: #b91c1c;
        }

        .action-btn.warning {
            background: #f59e0b;
            color: white;
            border-color: #f59e0b;
        }

        .action-btn.warning:hover:not(:disabled) {
            background: #d97706;
        }

        /* Products Table */
        .products-table {
            width: 100%;
        }

        .table-header {
            background: #f8fafc;
            border-bottom: 2px solid #e5e7eb;
        }

        .table-header th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #374151;
            font-size: 0.9rem;
        }

        .table-row {
            border-bottom: 1px solid #e5e7eb;
            transition: background-color 0.2s ease;
        }

        .table-row:hover {
            background: #f8fafc;
        }

        .table-row.selected {
            background: #eff6ff;
        }

        .table-cell {
            padding: 1rem;
            vertical-align: middle;
        }

        .checkbox-cell {
            width: 50px;
            text-align: center;
        }

        .product-checkbox {
            width: 18px;
            height: 18px;
            accent-color: #1e40af;
        }

        .product-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .product-image {
            width: 50px;
            height: 50px;
            background: #e2e8f0;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .product-details h4 {
            font-size: 0.95rem;
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 0.25rem;
        }

        .product-details p {
            font-size: 0.85rem;
            color: #64748b;
        }

        .category-badge {
            padding: 0.25rem 0.5rem;
            background: #e0e7ff;
            color: #1e40af;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .stock-status {
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .stock-status.in-stock {
            background: #d1fae5;
            color: #065f46;
        }

        .stock-status.low-stock {
            background: #fef3c7;
            color: #92400e;
        }

        .stock-status.out-of-stock {
            background: #fee2e2;
            color: #dc2626;
        }

        .price {
            font-weight: 600;
            color: #1e40af;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal.show {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 500px;
            padding: 2rem;
            transform: scale(0.9);
            transition: transform 0.3s ease;
        }

        .modal.show .modal-content {
            transform: scale(1);
        }

        .modal-header {
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 0.5rem;
        }

        .modal-subtitle {
            color: #64748b;
            font-size: 0.9rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #374151;
        }

        .form-input, .form-select {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 0.9rem;
        }

        .modal-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
            margin-top: 2rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-secondary {
            background: #64748b;
            color: white;
        }

        .btn-secondary:hover {
            background: #475569;
        }

        .btn-primary {
            background: #1e40af;
            color: white;
        }

        .btn-primary:hover {
            background: #1e3a8a;
        }

        .btn-danger {
            background: #dc2626;
            color: white;
        }

        .btn-danger:hover {
            background: #b91c1c;
        }

        /* Alert */
        .alert {
            position: fixed;
            top: 2rem;
            right: 2rem;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            z-index: 1100;
            transform: translateX(400px);
            transition: transform 0.3s ease;
        }

        .alert.show {
            transform: translateX(0);
        }

        .alert.success {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert.error {
            background: #fee2e2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        @media (max-width: 768px) {
            .dashboard {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
            }

            .bulk-controls {
                flex-direction: column;
                align-items: stretch;
            }

            .bulk-actions {
                justify-content: center;
            }

            .products-table {
                font-size: 0.85rem;
            }

            .table-cell {
                padding: 0.75rem 0.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="logo">
                <h1>M & E</h1>
                <p>Admin Dashboard</p>
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
                    <a href="./index.php" class="nav-link active">
                        <i data-lucide="shopping-cart"></i> Products
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../users/index.php" class="nav-link">
                        <i data-lucide="users"></i> Customers
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../inventory/index.php" class="nav-link">
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
                <div class="bulk-header">
                    <h3 class="bulk-title">Product Bulk Operations</h3>
                    <p class="bulk-subtitle">Select products and apply bulk actions to manage multiple items at once</p>
                </div>

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
        // Sample products data
        const products = [
            {
                id: 1,
                name: "Ballpoint Pens (Pack of 12)",
                category: "office",
                categoryLabel: "Office Supplies",
                price: 180,
                stock: 150,
                image: "🖊️"
            },
            {
                id: 2,
                name: "Bond Paper (1 Ream)",
                category: "office",
                categoryLabel: "Office Supplies",
                price: 320,
                stock: 75,
                image: "📄"
            },
            {
                id: 3,
                name: "File Folders (Pack of 10)",
                category: "office",
                categoryLabel: "Office Supplies",
                price: 250,
                stock: 8,
                image: "📁"
            },
            {
                id: 4,
                name: "Spiral Notebooks (Pack of 5)",
                category: "school",
                categoryLabel: "School Supplies",
                price: 125,
                stock: 200,
                image: "📓"
            },
            {
                id: 5,
                name: "No. 2 Pencils (Pack of 24)",
                category: "school",
                categoryLabel: "School Supplies",
                price: 95,
                stock: 120,
                image: "✏️"
            },
            {
                id: 6,
                name: "Hand Sanitizer (500ml)",
                category: "sanitary",
                categoryLabel: "Sanitary Supplies",
                price: 145,
                stock: 90,
                image: "🧴"
            }
        ];

        let selectedProducts = new Set();

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            renderProducts();
            setupEventListeners();
        });

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

        function handleEdit(e) {
            e.preventDefault();

            const category = document.getElementById('editCategory').value;
            const priceAdjustment = document.getElementById('priceAdjustment').value;

            // Simulate processing - in real app, send to backend
            let message = `Successfully updated ${selectedProducts.size} products!`;
            if (category) message += ` Category changed to ${category}.`;
            if (priceAdjustment) message += ` Price adjusted by ${priceAdjustment}%.`;

            showAlert(message, 'success');
            closeModal('edit');
        }

        function handleStockUpdate(e) {
            e.preventDefault();

            const action = document.getElementById('stockAction').value;
            const quantity = parseInt(document.getElementById('stockQuantity').value);

            // Simulate processing - in real app, send to backend
            let actionText = action === 'set' ? 'set' : action === 'add' ? 'increased' : 'decreased';
            showAlert(`Stock ${actionText} for ${selectedProducts.size} products!`, 'success');
            closeModal('stock');
        }

        function confirmDelete() {
            // Simulate deletion - in real app, send to backend
            showAlert(`Successfully deleted ${selectedProducts.size} products!`, 'success');

            // Clear selection and update UI
            selectedProducts.clear();
            updateSelectionUI();
            closeModal('delete');
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
