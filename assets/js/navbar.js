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

        nav.querySelectorAll("a").forEach((link) => {
            link.addEventListener("click", (e) => {

                if (link.id === 'mobileLoginLink') {
                    return;
                }

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

            nav.classList.remove("active");
            hamburger.classList.remove("active");

            const loginModal = document.getElementById('loginModal');
            if (loginModal) {
                loginModal.style.display = 'block';
            }
        });
    }

    // Mobile user menu toggle
    const mobileUserMenu = document.querySelector('.mobile-user-menu');
    if (mobileUserMenu) {
        const userAvatar = mobileUserMenu.querySelector('.user-avatar');
        const dropdown = mobileUserMenu.querySelector('.dropdown');

        if (userAvatar && dropdown) {
            userAvatar.addEventListener('click', (e) => {
                e.preventDefault();
                dropdown.classList.toggle('expanded');
            });
        }
    }
    function fetchCart() {
    fetch("../ajax/fetch-cart.php")
      .then((res) => res.json())
      .then((data) => {
        const countElement = document.querySelector(".cart-count");
        if (countElement) {
          countElement.textContent = data.count > 0 ? data.count : "";
          countElement.classList.add("loaded");
        }
      })
      .catch((err) => console.error("Fetch cart failed:", err));
  }

  fetchCart();
  setInterval(fetchCart, 15000);

});
