document.addEventListener("DOMContentLoaded", () => {
    // Header & nav elements
    const hamburger = document.querySelector(".hamburger");
    const hamburgerIcon = document.querySelector(".hamburger-icon");
    const nav = document.querySelector("header nav");
    const header = document.querySelector("header");

    // Header color transition on scroll
    if (header) {
        window.addEventListener("scroll", () => {
            if (window.scrollY > 400) {
                header.classList.add("scrolled");
            } else {
                header.classList.remove("scrolled");
            }
        });
    }

    // Hamburger menu toggle
    if (hamburger && nav && hamburgerIcon) {
        hamburger.addEventListener("click", () => {
            nav.classList.toggle("active");
            hamburger.classList.toggle("active");
        });

        // Close nav when a link is clicked (except mobile user menu)
        nav.querySelectorAll("a").forEach((link) => {
            link.addEventListener("click", (e) => {
                // Don't close if it's the mobile login link
                if (link.id === 'mobileLoginLink') {
                    return;
                }
                // Don't close if it's inside the mobile user menu
                if (link.closest('.mobile-user-menu')) {
                    return;
                }
                nav.classList.remove("active");
                hamburger.classList.remove("active");
            });
        });
    }

    // Mobile login link handler
    const mobileLoginLink = document.getElementById('mobileLoginLink');
    if (mobileLoginLink) {
        mobileLoginLink.addEventListener('click', (e) => {
            e.preventDefault();
            // Close mobile menu
            nav.classList.remove("active");
            hamburger.classList.remove("active");
            // Open login modal
            const loginModal = document.getElementById('loginModal');
            if (loginModal) {
                loginModal.style.display = 'block';
            }
        });
    }

    // Mobile user menu toggle (NEW)
    const mobileUserMenu = document.querySelector('.mobile-user-menu');
    if (mobileUserMenu) {
        const userAvatar = mobileUserMenu.querySelector('.user-avatar');
        const dropdown = mobileUserMenu.querySelector('.dropdown');

        if (userAvatar && dropdown) {
            // Make dropdown visible by default on mobile (already in CSS)
            // But add toggle functionality if you want to collapse/expand it
            userAvatar.addEventListener('click', (e) => {
                e.preventDefault();
                dropdown.classList.toggle('expanded');
            });
        }
    }
});
