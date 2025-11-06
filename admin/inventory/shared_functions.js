// --- SHARED MODAL FUNCTIONS ---
function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('show');
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
        if (typeof lucide !== 'undefined') {
            lucide.createIcons(); // Re-create icons for new modal content
        }
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('show');
        document.body.style.overflow = 'auto'; // Restore background scrolling
        // Optional: Reset form within the modal if it has one
        const form = modal.querySelector('form');
        if (form) {
            form.reset();
        }
    }
}

// Function to set up click outside listener for all modals
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.modal-base').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) { // Only close if clicking on the backdrop
                closeModal(this.id);
            }
        });
    });
});

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;

    document.body.appendChild(notification);

    // Trigger reflow to enable transition
    void notification.offsetWidth;
    notification.classList.add('show');

    setTimeout(() => {
        notification.classList.remove('show');
        notification.addEventListener('transitionend', () => notification.remove());
    }, 3000);
}

function capitalizeFirst(str) {
    if (!str) return ''; // Handle empty or null strings
    return str.charAt(0).toUpperCase() + str.slice(1);
}

function formatDate(dateString) {
    if (!dateString) return ''; // Handle empty or null date strings
    const date = new Date(dateString);
    // Check if the date is valid
    if (isNaN(date.getTime())) {
        return 'Invalid Date';
    }
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}

function addMobileTableLabels() {
    // Main inventory table
    const inventoryTable = document.querySelector('.inventory-table');
    if (inventoryTable) {
        addLabelsToTable(inventoryTable, [
            'Product', 'Category', 'SKU', 'Stock',
            'Min', 'Price', 'Value', 'Actions'
        ]);
    }

    // Stock movements table
    const movementsTable = document.querySelector('.stock-movements-table');
    if (movementsTable) {
        addLabelsToTable(movementsTable, [
            'Date/Time', 'Product', 'Movement Type', 'Quantity',
            'Previous Stock', 'New Stock', 'Stock Impact',
            'Reason', 'User', 'Actions'
        ]);
    }

    // Low stock alerts table
    const alertsTable = document.querySelector('.low-stock-alerts-alerts-table');
    if (alertsTable) {
        addLabelsToTable(alertsTable, [
            'Product', 'Alert Level', 'Current/Min Stock',
            'Stock Level', 'Days Supply', 'Last Restock', 'Actions'
        ]);
    }

    // Adjust stock history table
    const adjustStockTable = document.querySelector('.adjust-stock-adjustments-table');
    if (adjustStockTable) {
        addLabelsToTable(adjustStockTable, [
            'Date/Time', 'Product', 'Type', 'Quantity',
            'Previous', 'New', 'Reason', 'User'
        ]);
    }
}

/**
 * Helper function to add data-label attributes to table cells
 */
function addLabelsToTable(table, labels) {
    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        cells.forEach((cell, index) => {
            if (labels[index]) {
                cell.setAttribute('data-label', labels[index]);
            }
        });
    });
}

/**
 * Initialize mobile helpers on page load and after table updates
 */
function initMobileHelpers() {
    addMobileTableLabels();

    // Add touch-friendly interactions
    addTouchFeedback();

    // Handle sidebar toggle for mobile
    setupMobileSidebar();
}

/**
 * Add visual feedback for touch interactions
 */
function addTouchFeedback() {
    const buttons = document.querySelectorAll('button, .action-btn, .quick-action-btn');

    buttons.forEach(button => {
        button.addEventListener('touchstart', function() {
            this.style.opacity = '0.7';
        });

        button.addEventListener('touchend', function() {
            setTimeout(() => {
                this.style.opacity = '1';
            }, 150);
        });
    });
}

/**
 * Setup mobile sidebar toggle functionality
 */
function setupMobileSidebar() {
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.querySelector('.main-content');

    if (mobileMenuBtn && sidebar) {
        mobileMenuBtn.addEventListener('click', function() {
            sidebar.classList.toggle('active');

            // Close sidebar when clicking outside
            if (sidebar.classList.contains('active')) {
                document.addEventListener('click', closeSidebarOnClickOutside);
            }
        });
    }

    function closeSidebarOnClickOutside(e) {
        if (!sidebar.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
            sidebar.classList.remove('active');
            document.removeEventListener('click', closeSidebarOnClickOutside);
        }
    }

    // Close sidebar on link click (for mobile)
    const sidebarLinks = sidebar?.querySelectorAll('a');
    sidebarLinks?.forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth <= 1024) {
                sidebar.classList.remove('active');
            }
        });
    });
}

/**
 * Optimize modals for mobile
 */
function optimizeModalsForMobile() {
    const modals = document.querySelectorAll('.modal-base');

    modals.forEach(modal => {
        // Prevent body scroll when modal is open
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.attributeName === 'class') {
                    if (modal.classList.contains('show')) {
                        document.body.style.overflow = 'hidden';
                    } else {
                        document.body.style.overflow = '';
                    }
                }
            });
        });

        observer.observe(modal, { attributes: true });
    });
}

/**
 * Improve touch scrolling for tables
 */
function improveTouchScrolling() {
    const scrollContainers = document.querySelectorAll(
        '.table-container, .stock-movements-table-container, .low-stock-alerts-item-list'
    );

    scrollContainers.forEach(container => {
        // Add smooth scrolling
        container.style.webkitOverflowScrolling = 'touch';

        // Add scroll indicators
        container.addEventListener('scroll', function() {
            if (this.scrollLeft > 0) {
                this.classList.add('is-scrolled');
            } else {
                this.classList.remove('is-scrolled');
            }

            if (this.scrollLeft < this.scrollWidth - this.clientWidth - 10) {
                this.classList.add('has-more');
            } else {
                this.classList.remove('has-more');
            }
        });

        // Trigger initial check
        container.dispatchEvent(new Event('scroll'));
    });
}

/**
 * Add orientation change handler
 */
function handleOrientationChange() {
    window.addEventListener('orientationchange', function() {
        // Recalculate layouts after orientation change
        setTimeout(() => {
            addMobileTableLabels();
            improveTouchScrolling();
        }, 200);
    });
}

/**
 * Viewport height fix for mobile browsers
 */
function fixMobileViewportHeight() {
    const setViewportHeight = () => {
        const vh = window.innerHeight * 0.01;
        document.documentElement.style.setProperty('--vh', `${vh}px`);
    };

    setViewportHeight();
    window.addEventListener('resize', setViewportHeight);
}

// Initialize all mobile helpers when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initMobileHelpers);
} else {
    initMobileHelpers();
}

// Initialize other mobile optimizations
optimizeModalsForMobile();
improveTouchScrolling();
handleOrientationChange();
fixMobileViewportHeight();

// Export functions for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        addMobileTableLabels,
        initMobileHelpers,
        optimizeModalsForMobile
    };
}
