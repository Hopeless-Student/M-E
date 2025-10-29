document.addEventListener("DOMContentLoaded", () => {
  // Header & nav elements


  // Search elements
  const searchBar = document.querySelector(".hero-search-bar")
  const searchInput = document.querySelector("#search-input");
  const searchIcon = document.querySelector(".hero-search-bar .search-icon");
  const suggestionsBox = document.querySelector(".search-suggestions");

  // Other UI
  const cart = document.querySelector(".cart");
  const heroCTA = document.querySelector(".hero-cta");
  const faqQuestions = document.querySelectorAll(".faq-question");

  // Login modal elements
  const loginModal = document.getElementById("loginModal");
  const btnLogin = document.querySelector(".btn-login a");
  const closeBtn = document.getElementById("closeLoginModal");
  const loginForm = document.getElementById("loginForm");
  const openLoginModalLink = document.getElementById("openLoginModal"); // Eto para sa header letche

  // Signup modal elements
  const signupModal = document.getElementById("signupModal");
  const openSignupModalLink = document.getElementById("openSignupModal");
  const closeSignupModal = document.getElementById("closeSignupModal");
  const signupForm = document.getElementById("signupForm");

  // fixed: get the "Log in here" link from signup modal using a more specific selector
  const signupToLoginLink = document.querySelector("#signupModal .modal-switch-text a");

  // Signup inputs
  const firstNameInput = document.getElementById("firstName");
  const lastNameInput = document.getElementById("lastName");
  const signupEmailInput = document.getElementById("email");
  const signupPasswordInput = document.getElementById("password");
  const signupConfirmPasswordInput = document.getElementById("confirmPassword");
  const termsCheckbox = document.getElementById("termsCheckbox");
  const verifyEmailBtn = document.getElementById("verifyEmailBtn");

  // Terms modal
  const termsModal = document.getElementById("termsModal");
  const openTermsModal =
    document.getElementById("openTermsModal") ||
    document.querySelector('a[href="#termsModal"]');
  const closeTermsModal =
    (termsModal && termsModal.querySelector(".close")) ||
    document.getElementById("closeTermsModal");



  // Mobile search toggle
  if (searchBar && searchIcon && searchInput) {
    searchIcon.addEventListener("click", (e) => {
      if (window.innerWidth <= 768) {
        e.preventDefault();
        searchBar.classList.toggle("active");

        if (searchBar.classList.contains("active")) {
          searchInput.style.display = "block";
          searchInput.focus();
        } else {
          searchInput.style.display = "none";
          if (suggestionsBox) suggestionsBox.style.display = "none";
        }
      } else {
        searchInput.focus();
      }
    });

    if (window.innerWidth <= 768 && !searchBar.classList.contains("active")) {
      searchInput.style.display = "none";
    }
  }
  initSearchSuggestions("#search-input", ".search-suggestions");
  // Hero CTA smooth scroll
  if (heroCTA) {
    heroCTA.addEventListener("click", (e) => {
      e.preventDefault();
      const productsSection = document.querySelector(".products");
      if (productsSection) {
        productsSection.scrollIntoView({ behavior: "smooth" });
      }
    });
  }

  // FAQ accordion
  if (faqQuestions.length > 0) {
    faqQuestions.forEach((q) => {
      q.addEventListener("click", () => {
        faqQuestions.forEach((el) => {
          if (el !== q && el.nextElementSibling) {
            el.nextElementSibling.classList.remove("open");
          }
        });
        const ans = q.nextElementSibling;
        if (ans) ans.classList.toggle("open");
      });
    });
  }

  // Cart badge demo
  if (cart) {
    let cartCount = parseInt(cart.getAttribute("data-count")) || 0;

    const updateCartBadge = () => {
      cart.setAttribute("data-count", cartCount);
    };
    updateCartBadge();

    document.querySelectorAll(".cart-btn, .cart-btn a, .cart-btn button").forEach((btn) => {
      btn.addEventListener("click", (e) => {

        if (btn.tagName === "A") {
          e.preventDefault();
          cartCount++;
          updateCartBadge();
        }

      });
    });
  }

  // Smooth scroll for anchor links
  document.querySelectorAll("header nav a").forEach((link) => {
    link.addEventListener("click", function (e) {
      const href = this.getAttribute("href");
      if (href && href.startsWith("#")) {
        e.preventDefault();
        const target = document.querySelector("href");
        if (target) target.scrollIntoView({ behavior: "smooth" });
      }
    });
  });



  // Login modal logic
  if (btnLogin && loginModal) {
    btnLogin.addEventListener("click", (event) => {
      event.preventDefault();
      loginModal.style.display = "block";
    });
  }

  if (closeBtn && loginModal) {
    closeBtn.addEventListener("click", () => {
      loginModal.style.display = "none";
    });
  }

  window.addEventListener("click", (event) => {
    if (event.target === loginModal) {
      loginModal.style.display = "none";
    }
    if (event.target === signupModal) {
      signupModal.style.display = "none";
    }
    if (event.target === termsModal) {
      termsModal.style.display = "none";
    }
  });

  // Signup modal logic
  if (openSignupModalLink && signupModal) {
    openSignupModalLink.addEventListener("click", (e) => {
      e.preventDefault();
      loginModal.style.display = "none";
      signupModal.style.display = "block";
    });
  }

  if (closeSignupModal && signupModal) {
    closeSignupModal.addEventListener("click", () => {
      signupModal.style.display = "none";
    });
  }

  // fixed: Separate event listener for the "Log in here" link in signup modal
  if (signupToLoginLink && signupModal && loginModal) {
    signupToLoginLink.addEventListener("click", (e) => {
      e.preventDefault();
      signupModal.style.display = "none";
      loginModal.style.display = "block";
    });
  }
  const loginError = document.querySelector("#loginModal .error-message");
  if (loginError) {
    loginModal.style.display = "block";
  }
  const togglePassword = document.getElementById("togglePassword");
  const loginPassword = document.getElementById("loginpassword");

  if (togglePassword && loginPassword) {
  togglePassword.addEventListener("click", () => {
    const isPassword = loginPassword.type === "password";
    loginPassword.type = isPassword ? "text" : "password";

    togglePassword.src = isPassword
      ? "../assets/svg/eye.svg"
      : "../assets/svg/eye-slash.svg";
  });
}
  if (termsCheckbox && verifyEmailBtn) {
    verifyEmailBtn.disabled = !termsCheckbox.checked;
    termsCheckbox.addEventListener("change", () => {
      verifyEmailBtn.disabled = !termsCheckbox.checked;
    });
  }

  // Mobile login link inside hamburger
  const nav = document.querySelector("header nav");
const hamburger = document.querySelector(".hamburger");
const hamburgerIcon = document.querySelector(".hamburger-icon");

    const mobileLoginLink = document.getElementById("mobileLoginLink");
    if (mobileLoginLink) {
        mobileLoginLink.addEventListener("click", (event) => {
            event.preventDefault();
            signupModal.style.display = "none";
            loginModal.style.display = "block";
            nav.classList.remove("active");
            hamburger.classList.remove("active");
            hamburgerIcon.src = "../assets/svg/hamburger-menu.svg";
        });
    }

  const toggleLogin = document.getElementById("toggleLogin");
  if (toggleLogin) {
    toggleLogin.addEventListener("click", (event) => {
      event.preventDefault();
      signupModal.style.display = "none";
      loginModal.style.display = "block";
      nav.classList.remove("active");
      hamburger.classList.remove("active");
      hamburgerIcon.src = "../assets/svg/hamburger-menu.svg";
    });
  }
  const mobileUserMenu = document.querySelector('.mobile-user-menu');
  if (mobileUserMenu) {
    const userAvatar = mobileUserMenu.querySelector('.user-avatar');
    const dropdown = mobileUserMenu.querySelector('.dropdown');

    userAvatar.addEventListener('click', (e) => {
      e.preventDefault();
      dropdown.classList.toggle('active');
    });
  }
  // Mobile cart link inside hamburger
  const mobileCartLink = document.querySelector(".mobile-nav-cart");
  if (mobileCartLink) {
      const loggedIn = mobileCartLink.dataset.loggedIn === "1"; // true if user logged in
      mobileCartLink.addEventListener("click", (event) => {
          if (!loggedIn) { // if user is not logged in
              event.preventDefault();
              signupModal.style.display = "none";
              loginModal.style.display = "block";
              nav.classList.remove("active");
              hamburger.classList.remove("active");
              hamburgerIcon.src = "../assets/svg/hamburger-menu.svg";
          }
      });
  }


  const floatingRequestBtn = document.getElementById("floatingRequestBtn");
const customRequestModal = document.getElementById("customRequestModal");
const closeRequestModal = document.getElementById("closeRequestModal");
const customRequestForm = document.getElementById("customRequestForm");
const requestMessage = document.getElementById("requestMessage");
const charCount = document.getElementById("charCount");

if (floatingRequestBtn && customRequestModal) {
  floatingRequestBtn.addEventListener("click", () => {
    customRequestModal.style.display = "block";
  });
}

if (closeRequestModal && customRequestModal) {
  closeRequestModal.addEventListener("click", () => {
    customRequestModal.style.display = "none";
  });
}

if (requestMessage && charCount) {
  requestMessage.addEventListener("input", () => {
    const count = requestMessage.value.length;
    charCount.textContent = count;

    if (count > 900) {
      charCount.style.color = "#ff0000";
    } else if (count > 800) {
      charCount.style.color = "#ff9900";
    } else {
      charCount.style.color = "#999";
    }
  });
}

const alerts = document.querySelectorAll(".alert-message");
  alerts.forEach(alert => {
    alert.addEventListener("animationend", (e) => {
      if (e.animationName === "fadeOut") {
        alert.remove();
      }
    });

    alert.addEventListener("click", () => {
      alert.remove();
    });
  });

// Close modals when clicking outside
window.addEventListener("click", (event) => {
  if (event.target === customRequestModal) {
    customRequestModal.style.display = "none";
  }
});

// Hide floating button when modals are open to avoid overlap
const allModals = [loginModal, signupModal, customRequestModal];
const observer = new MutationObserver(() => {
  const anyModalOpen = allModals.some(modal =>
    modal && modal.style.display === "block"
  );

  if (floatingRequestBtn) {
    if (anyModalOpen && customRequestModal.style.display !== "block") {
      floatingRequestBtn.style.opacity = "0.3";
      floatingRequestBtn.style.pointerEvents = "none";
    } else {
      floatingRequestBtn.style.opacity = "1";
      floatingRequestBtn.style.pointerEvents = "auto";
    }
  }
});

// Observe each modal for display changes
allModals.forEach(modal => {
  if (modal) {
    observer.observe(modal, { attributes: true, attributeFilter: ['style'] });
  }
});

  // Footer auto-year
  const footerCopy = document.querySelector(".footer-copy p");
  if (footerCopy) {
    footerCopy.innerHTML = `© Copyright ${new Date().getFullYear()} M&E Interior Supplies Trading, All rights reserved.`;
  }
});

// add to cart copy
function addToCart(product_id, quantity = 1) {
  const product = products.find(p => p.id === product_id);
  //   console.log("addToCart triggered:", product_id);
  // // intentionally break here for debug
  // console.log("Sending request with:", product_id, quantity);
  // // debugger;
  fetch('../ajax/add-to-cart.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: new URLSearchParams({ product_id: product_id, quantity: 1 })
  })
  .then(res => res.json())
  .then(data => {
    // console.log("Response from server:", data);
    if (data.success) {
      showToast(`${product ? product.title : 'Item'} added to cart`);
      fetchCart();
    } else {
      showToast(data.message || 'Failed to add to cart');
    }
  })
  .catch(err => console.error(err));
}

// fetch cart copy
function fetchCart() {
  fetch('../ajax/fetch-cart.php')
  .then(res => res.json())
  .then(data => {
    const cartCount = document.getElementById('cartCount');
    cartCount.textContent = data.count || 0;
  });
}
// show toast copy
function showToast(message) {
  const toast = document.getElementById('toast');
  toast.textContent = message;
  toast.classList.add('show');

  setTimeout(() => {
    toast.classList.remove('show');
  }, 2000);
}
