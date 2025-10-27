// API Configuration
const API_BASE = '/api/inventory';

// API Service Layer
const InventoryAPI = {
    // Get inventory list
    async getInventory(params = {}) {
        const queryString = new URLSearchParams(params).toString();
        const response = await fetch(`${API_BASE}/list.php?${queryString}`);
        return await response.json();
    },

    // Adjust stock
    async adjustStock(data) {
        const response = await fetch(`${API_BASE}/adjust-stock.php`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        return await response.json();
    },

    // Get stock movements
    async getMovements(params = {}) {
        const queryString = new URLSearchParams(params).toString();
        const response = await fetch(`${API_BASE}/get-movements.php?${queryString}`);
        return await response.json();
    },

    // Get low stock items
    async getLowStock(params = {}) {
        const queryString = new URLSearchParams(params).toString();
        const response = await fetch(`${API_BASE}/get-low-stock.php?${queryString}`);
        return await response.json();
    },

    // Bulk update
    async bulkUpdate(data) {
        const response = await fetch(`${API_BASE}/bulk-update.php`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        return await response.json();
    },

    // Get product details
    async getProductDetails(productId) {
        const response = await fetch(`${API_BASE}/product-details.php?id=${productId}`);
        return await response.json();
    },

    // Delete product
    async deleteProduct(productId) {
        const response = await fetch(`${API_BASE}/delete-product.php`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ productId })
        });
        return await response.json();
    },

    // Export report
    getExportURL(type, format = 'csv', filters = {}) {
        const params = new URLSearchParams({ type, format, ...filters });
        return `${API_BASE}/export-report.php?${params.toString()}`;
    }
};

// Global variables (will be populated from API)
window.inventoryData = [];
window.lowStockData = [];
window.stockMovementsData = [];
window.categoriesData = [
    { slug: 'office', name: 'Office Supplies' },
    { slug: 'school', name: 'School Supplies' },
    { slug: 'sanitary', name: 'Sanitary Supplies' }
];

// Load initial data
async function loadInitialData() {
    try {
        // Load inventory
        const inventoryResponse = await InventoryAPI.getInventory({ pageSize: 100 });
        if (inventoryResponse.success) {
            window.inventoryData = inventoryResponse.items;
        }

        // Load low stock
        const lowStockResponse = await InventoryAPI.getLowStock({ pageSize: 100 });
        if (lowStockResponse.success) {
            window.lowStockData = lowStockResponse.items;
        }

        // Load movements
        const movementsResponse = await InventoryAPI.getMovements({ pageSize: 50 });
        if (movementsResponse.success) {
            window.stockMovementsData = movementsResponse.movements;
        }

    } catch (error) {
        console.error('Error loading initial data:', error);
        showNotification('Error loading data from server', 'error');
    }
}

// Export API for global use
window.InventoryAPI = InventoryAPI;
