document.addEventListener("DOMContentLoaded", () => {
  // Header & nav elements
  const hamburger = document.querySelector(".hamburger");
  const hamburgerIcon = document.querySelector(".hamburger-icon");
  const nav = document.querySelector("header nav");

  // Search elements (fix: target .hero-search-bar, not .search-bar)
  const searchBar =
    document.querySelector(".hero-search-bar") ||
    document.querySelector(".header-actions .search-bar");
  const searchInput = document.querySelector("#search-input");
  const searchIcon = document.querySelector(".hero-search-bar .search-icon");
  const suggestionsBox = document.querySelector(".search-suggestions");

  // Other UI
  const cart = document.querySelector(".cart");
  const heroCTA = document.querySelector(".hero-cta");
  const faqQuestions = document.querySelectorAll(".faq-question");
  const header = document.querySelector("header");

  // Login modal elements
  const loginModal = document.getElementById("loginModal");
  const btnLogin = document.querySelector(".btn-login a");
  const closeBtn = document.getElementById("closeLoginModal");
  const loginForm = document.getElementById("loginForm");
  const openLoginModalLink = document.getElementById("openLoginModal");

  // Signup modal elements
  const signupModal = document.getElementById("signupModal");
  const openSignupModalLink = document.getElementById("openSignupModal");
  const closeSignupModal = document.getElementById("closeSignupModal");
  const signupForm = document.getElementById("signupForm");

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

  // Hamburger toggle
  if (hamburger && nav && hamburgerIcon) {
    hamburger.addEventListener("click", () => {
      nav.classList.toggle("active");
      hamburger.classList.toggle("active");
      hamburgerIcon.src = nav.classList.contains("active")
        ? "../assets/svg/hamburger-menu-active.svg"
        : "../assets/svg/hamburger-menu.svg";
    });

    nav.querySelectorAll("a").forEach((link) => {
      link.addEventListener("click", () => {
        nav.classList.remove("active");
        hamburger.classList.remove("active");
        hamburgerIcon.src = "../assets/svg/hamburger-menu.svg";
      });
    });
  }

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

    // Fix: properly detect clicks outside hero-search-bar
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
    let cartCount = 0;
    const updateCartBadge = () => {
      cart.setAttribute("data-count", cartCount);
    };
    updateCartBadge();

    document.querySelectorAll(".cart-btn a").forEach((btn) => {
      btn.addEventListener("click", (e) => {
        e.preventDefault();
        cartCount++;
        updateCartBadge();
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

  // Header color transition
  if (header) {
    window.addEventListener("scroll", () => {
      if (window.scrollY > 700) {
        header.classList.add("scrolled");
      } else {
        header.classList.remove("scrolled");
      }
    });
  }

  /* ---------------------------
     Login modal logic
     --------------------------- */
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

  if (loginForm) {
    loginForm.addEventListener("submit", (e) => {
      e.preventDefault();
      const username = loginForm.username?.value.trim() || "";
      const password = loginForm.password?.value.trim() || "";

      if (username && password) {
        alert(`Logging in as ${username}`);
        loginModal.style.display = "none";
        loginForm.reset();
      } else {
        alert("Please fill out all fields.");
      }
    });
  }

  /* ---------------------------
     Signup modal logic
     --------------------------- */
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

  if (openLoginModalLink && signupModal && loginModal) {
    openLoginModalLink.addEventListener("click", (e) => {
      e.preventDefault();
      signupModal.style.display = "none";
      loginModal.style.display = "block";
    });
  }

  if (termsCheckbox && verifyEmailBtn) {
    verifyEmailBtn.disabled = !termsCheckbox.checked;
    termsCheckbox.addEventListener("change", () => {
      verifyEmailBtn.disabled = !termsCheckbox.checked;
    });
  }

  if (signupForm) {
    signupForm.addEventListener("submit", (e) => {
      e.preventDefault();
      const firstName = firstNameInput?.value.trim() || "";
      const lastName = lastNameInput?.value.trim() || "";
      const email = signupEmailInput?.value.trim() || "";
      const password = signupPasswordInput?.value.trim() || "";
      const confirmPassword = signupConfirmPasswordInput?.value.trim() || "";
      const agreed = termsCheckbox?.checked || false;

      if (!firstName || !lastName || !email || !password || !confirmPassword) {
        alert("Please fill out all fields.");
        return;
      }

      if (password !== confirmPassword) {
        alert("Passwords do not match.");
        return;
      }

      if (!agreed) {
        alert("You must agree to the Terms and Conditions.");
        return;
      }

      alert(`Verification email sent to ${email}`);
      signupForm.reset();
      verifyEmailBtn.disabled = true;
      signupModal.style.display = "none";
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

  /* ---------------------------
     Terms modal open/close
     --------------------------- */
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
