document.addEventListener("DOMContentLoaded", () => {
  // Header & nav elements
  const hamburger = document.querySelector(".hamburger");
  const hamburgerIcon = document.querySelector(".hamburger-icon");
  const nav = document.querySelector("header nav");

  // Search elements
  const searchBar = document.querySelector(".header-actions .search-bar");
  const searchInput = document.querySelector("#search-input");
  const searchIcon = document.querySelector(".search-bar .search-icon");
  const suggestionsBox = document.querySelector(".search-suggestions");

  // Other UI
  const cart = document.querySelector(".cart");
  const heroCTA = document.querySelector(".hero-cta");
  const faqQuestions = document.querySelectorAll(".faq-question");
  const header = document.querySelector("header");

  // Login modal elements (if present)
  const loginModal = document.getElementById("loginModal");
  const btnLogin = document.querySelector(".btn-login a");
  const closeBtn = document.getElementById("closeLoginModal");
  const loginForm = document.getElementById("loginForm");
  const openLoginModalLink = document.getElementById("openLoginModal");

  // Signup modal elements (IDs expected in your HTML)
  const signupModal = document.getElementById("signupModal");
  const openSignupModalLink = document.getElementById("openSignupModal");
  const closeSignupModal = document.getElementById("closeSignupModal");
  const signupForm = document.getElementById("signupForm");

  // Signup specific inputs (IDs expected)
  const firstNameInput = document.getElementById("firstName");
  const lastNameInput = document.getElementById("lastName");
  // use "email", "password", "confirmPassword" as IDs for signup inputs
  const signupEmailInput = document.getElementById("email");
  const signupPasswordInput = document.getElementById("password");
  const signupConfirmPasswordInput = document.getElementById("confirmPassword");
  const termsCheckbox = document.getElementById("termsCheckbox");
  const verifyEmailBtn = document.getElementById("verifyEmailBtn");

  // Terms modal (optional)
  const termsModal = document.getElementById("termsModal");
  // search for a trigger anchor with id or fallback to any link pointing to #termsModal
  const openTermsModal =
    document.getElementById("openTermsModal") ||
    document.querySelector('a[href="#termsModal"]');
  const closeTermsModal =
    (termsModal && termsModal.querySelector(".close")) ||
    document.getElementById("closeTermsModal");

  // Hamburger (mobile) toggle
  if (hamburger && nav && hamburgerIcon) {
    hamburger.addEventListener("click", () => {
      nav.classList.toggle("active");
      hamburger.classList.toggle("active");

      // Swap icons (make sure these file paths are correct for your project)
      hamburgerIcon.src = nav.classList.contains("active")
        ? "../assets/svg/hamburger-menu-active.svg"
        : "../assets/svg/hamburger-menu.svg";
    });

    // Close nav when clicking a link (mobile)
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
    // Ensure mobile behavior toggles the compact circle -> expanded search input
    searchIcon.addEventListener("click", (e) => {
      // only do this expand behavior on small screens
      if (window.innerWidth <= 768) {
        e.preventDefault();
        searchBar.classList.toggle("active");

        if (searchBar.classList.contains("active")) {
          // show input and focus
          searchInput.style.display = "block";
          searchInput.focus();
        } else {
          searchInput.style.display = "none";
          if (suggestionsBox) suggestionsBox.style.display = "none";
        }
      } else {
        // On desktop you may want the icon to focus the input
        if (searchInput) searchInput.focus();
      }
    });

    // If page loads on mobile and you want the input hidden initially:
    if (window.innerWidth <= 768 && !searchBar.classList.contains("active")) {
      searchInput.style.display = "none";
    }
  }

  // Search suggestions logic
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
          // Replace this with real search/redirection in your app:
          // location.href = `/search?q=${encodeURIComponent(product)}`;
          alert("Searching for: " + product);
        });

        suggestionsBox.appendChild(item);
      });

      suggestionsBox.style.display = "block";
    });

    // Hide suggestions when clicking outside search-bar
    document.addEventListener("click", (e) => {
      if (!e.target.closest(".search-bar")) {
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

  // FAQ accordion (single open)
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

  // Cart badge updater (demo)
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

  // Smooth scroll for in-page links
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

  // Header color transition on scroll
  if (header) {
    window.addEventListener("scroll", () => {
      // threshold can be adjusted (100, 200, 700, etc.)
      if (window.scrollY > 700) {
        header.classList.add("scrolled");
      } else {
        header.classList.remove("scrolled");
      }
    });
  }

  // Login modal handlers (defensive)
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

  if (window && loginModal) {
    window.addEventListener("click", (event) => {
      if (event.target === loginModal) {
        loginModal.style.display = "none";
      }
    });
  }

  if (loginForm) {
    loginForm.addEventListener("submit", (e) => {
      e.preventDefault();
      // Your login inputs: 'username' and 'password' expected on the login form
      const username = loginForm.username ? loginForm.username.value.trim() : "";
      const password = loginForm.password ? loginForm.password.value.trim() : "";

      if (username && password) {
        // TODO: Replace with real login call
        alert(`Logging in as ${username}`);
        if (loginModal) loginModal.style.display = "none";
        loginForm.reset();
      } else {
        alert("Please fill out all fields.");
      }
    });
  }

  // Signup modal open/close logic
  if (openSignupModalLink && signupModal) {
    openSignupModalLink.addEventListener("click", (e) => {
      e.preventDefault();
      if (loginModal) loginModal.style.display = "none";
      signupModal.style.display = "block";
    });
  }

  if (closeSignupModal && signupModal) {
    closeSignupModal.addEventListener("click", () => {
      signupModal.style.display = "none";
    });
  }

  if (window && signupModal) {
    window.addEventListener("click", (event) => {
      if (event.target === signupModal) {
        signupModal.style.display = "none";
      }
    });
  }

  // allow switching between login/signup modals (if links present)
  if (openLoginModalLink && signupModal && loginModal) {
    openLoginModalLink.addEventListener("click", (e) => {
      e.preventDefault();
      signupModal.style.display = "none";
      loginModal.style.display = "block";
    });
  }

  // SIGNUP form logic (first/last name, terms checkbox)
  if (termsCheckbox && verifyEmailBtn) {
    // Initially button is disabled in HTML; toggle based on checkbox
    verifyEmailBtn.disabled = !termsCheckbox.checked;

    termsCheckbox.addEventListener("change", () => {
      verifyEmailBtn.disabled = !termsCheckbox.checked;
    });
  }

  if (signupForm) {
    signupForm.addEventListener("submit", (e) => {
      e.preventDefault();

      // pull values from inputs (IDs expected)
      const firstName = firstNameInput ? firstNameInput.value.trim() : "";
      const lastName = lastNameInput ? lastNameInput.value.trim() : "";
      const email = signupEmailInput ? signupEmailInput.value.trim() : "";
      const password = signupPasswordInput ? signupPasswordInput.value.trim() : "";
      const confirmPassword = signupConfirmPasswordInput
        ? signupConfirmPasswordInput.value.trim()
        : "";
      const agreed = termsCheckbox ? termsCheckbox.checked : false;

      // validation
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

      // Replace this with real sign-up / send verification email backend call
      alert(`Verification email sent to ${email}`);

      // reset UI
      signupForm.reset();
      if (verifyEmailBtn) verifyEmailBtn.disabled = true;
      if (signupModal) signupModal.style.display = "none";
    });
  }

  /* ---------------------------
     Terms modal open/close
     (openTermsModal can be an ID or an <a href="#termsModal">)
     --------------------------- */
  if (openTermsModal && termsModal) {
    openTermsModal.addEventListener("click", (e) => {
      e.preventDefault();
      // open the terms modal (must exist in HTML)
      termsModal.style.display = "block";
    });
  }

  if (closeTermsModal && termsModal) {
    closeTermsModal.addEventListener("click", () => {
      termsModal.style.display = "none";
    });
  }

  if (termsModal) {
    window.addEventListener("click", (event) => {
      if (event.target === termsModal) {
        termsModal.style.display = "none";
      }
    });
  }

  // Terms & Verify Email Button
  if (termsCheckbox && verifyEmailBtn) {
    // Disable button initially
    verifyEmailBtn.disabled = true;

    // Enable/disable based on checkbox state
    termsCheckbox.addEventListener("change", () => {
      verifyEmailBtn.disabled = !termsCheckbox.checked;
    });
  }

  // Footer auto-year
  const footerCopy = document.querySelector(".footer-copy p");
  if (footerCopy) {
    footerCopy.innerHTML = `© Copyright ${new Date().getFullYear()} M&E Interior Supplies Trading, All rights reserved.`;
  }
});
