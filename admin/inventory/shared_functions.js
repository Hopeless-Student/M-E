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
    return str.charAt(0).toUpperCase() + str.slice(1);
}

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
}
