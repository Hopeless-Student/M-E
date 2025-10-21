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
  

  // Search suggestions
  const products = [
    "Scotch Tape Roll",
    "Ballpen Black",
    "Ballpen Blue",
    "Bond Paper A4",
    "Bond Paper Short",
    "Stapler",
    "Staple Wires",
    "Notebook",
    "Marker",
    "Highlighter",
    "Folder Manila",
    "Correction Tape",
  ];

  

  if (searchInput && suggestionsBox) {
    searchInput.addEventListener("input", () => {
      const query = searchInput.value.toLowerCase().trim();
      suggestionsBox.innerHTML = "";

      if (query.length === 0) {
        suggestionsBox.style.display = "none";
        return;
      }

      const filtered = products.filter((p) =>
        p.toLowerCase().includes(query)
      );

      if (filtered.length === 0) {
        const noResult = document.createElement("div");
        noResult.textContent = "No results found";
        suggestionsBox.appendChild(noResult);
        suggestionsBox.style.display = "block";
        return;
      }

      filtered.forEach((product) => {
        const item = document.createElement("div");
        item.className = "suggestion-item";
        item.textContent = product;

        item.addEventListener("click", () => {
          searchInput.value = product;
          suggestionsBox.style.display = "none";
          alert("Searching for: " + product);
        });

        suggestionsBox.appendChild(item);
      });

      suggestionsBox.style.display = "block";
    });

    document.addEventListener("click", (e) => {
      if (!e.target.closest(".hero-search-bar")) {
        suggestionsBox.style.display = "none";
      }
    });
  }

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
        const target = document.querySelector(href);
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

  // Mobile cart link
  const mobileCartLink = document.querySelector(".mobile-nav-cart");
  if (mobileCartLink) {
    mobileCartLink.addEventListener("click", (event) => {
      event.preventDefault();
      alert("Cart clicked (mobile). You can connect this to a modal or cart page.");
      nav.classList.remove("active");
      hamburger.classList.remove("active");
      hamburgerIcon.src = "../assets/svg/hamburger-menu.svg";
    });
  }

  // Terms modal open/close
  if (openTermsModal && termsModal) {
    openTermsModal.addEventListener("click", (e) => {
      e.preventDefault();
      termsModal.style.display = "block";
    });
  }

  if (closeTermsModal && termsModal) {
    closeTermsModal.addEventListener("click", () => {
      termsModal.style.display = "none";
    });
  }

  // Footer auto-year
  const footerCopy = document.querySelector(".footer-copy p");
  if (footerCopy) {
    footerCopy.innerHTML = `© Copyright ${new Date().getFullYear()} M&E Interior Supplies Trading, All rights reserved.`;
  }
});
