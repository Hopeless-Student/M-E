document.addEventListener('DOMContentLoaded', function() {
    const faqItems = document.querySelectorAll('.faq-item');
    
    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        const answer = item.querySelector('.faq-answer');

        // Make the question focusable and accessible
        question.setAttribute('tabindex', '0');
        question.setAttribute('role', 'button');
        question.setAttribute('aria-expanded', 'false');

        function closeOtherItems() {
            faqItems.forEach(otherItem => {
                if (otherItem !== item) {
                    otherItem.classList.remove('active');
                    const q = otherItem.querySelector('.faq-question');
                    if (q) q.setAttribute('aria-expanded', 'false');
                }
            });
        }

        function toggleItem() {
            const isOpen = item.classList.contains('active');
            if (!isOpen) {
                closeOtherItems();
            }
            item.classList.toggle('active');
            question.setAttribute('aria-expanded', item.classList.contains('active') ? 'true' : 'false');
            // If open, move focus to the answer for screen readers
            if (item.classList.contains('active') && answer) {
                answer.setAttribute('tabindex', '-1');
                answer.focus({ preventScroll: true });
            }
        }

        question.addEventListener('click', toggleItem);

        // Keyboard accessibility: Enter or Space toggles the item
        question.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                toggleItem();
            }
        });
    });

    // Smooth scroll for quick links
    document.querySelectorAll('.faq-quick-links a').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            const targetSection = document.querySelector(targetId);
            
            if (targetSection) {
                const headerOffset = 100; // Adjust this value based on your fixed header height
                const elementPosition = targetSection.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Custom Request Button functionality
    const customRequestBtn = document.getElementById('customRequestBtn');
    if (customRequestBtn) {
        customRequestBtn.addEventListener('click', () => {
            // Trigger the floating request button if it exists
            const floatingRequestBtn = document.getElementById('floatingRequestBtn');
            if (floatingRequestBtn) {
                floatingRequestBtn.click();
            }
        });
    }
});
