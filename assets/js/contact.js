document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('contactForm');
    if (form) {
    form.addEventListener('submit', (e) => {
        const inputs = form.querySelectorAll('input[required], textarea[required]');
        let valid = true;
        inputs.forEach(input => {
        if (!input.value.trim()) {
            input.style.borderColor = '#dc3545';
            valid = false;
        } else {
            input.style.borderColor = '#4169E1';
        }
        });
        if (!valid) {
        e.preventDefault();
        alert('Please fill out all required fields before submitting.');
        }
    });
    }

    // Smooth scroll for anchors
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
        window.scrollTo({
            top: target.offsetTop - 70,
            behavior: 'smooth'
        });
        }
    });
    });
});