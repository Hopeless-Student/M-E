document.addEventListener("DOMContentLoaded", () => {
  const hamburger = document.querySelector(".hamburger");
  const hamburgerIcon = document.querySelector(".hamburger-icon");
  const nav = document.querySelector("header nav");
  const searchBar = document.querySelector(".header-actions .search-bar");
  const searchInput = document.querySelector("#search-input");
  const searchIcon = document.querySelector(".search-bar .search-icon");
  const suggestionsBox = document.querySelector(".search-suggestions");
  const cart = document.querySelector(".cart");
  const heroCTA = document.querySelector(".hero-cta");
  const faqQuestions = document.querySelectorAll(".faq-question");
  const header = document.querySelector("header");

  // Hamburger toggle
  if (hamburger && nav && hamburgerIcon) {
    hamburger.addEventListener("click", () => {
      nav.classList.toggle("active");
      hamburger.classList.toggle("active");

      // Swap icons
      hamburgerIcon.src = nav.classList.contains("active")
        ? "../assets/svg/hamburger-menu-active.svg"
        : "../assets/svg/hamburger-menu.svg";
    });

    // Close nav when clicking a link
    nav.querySelectorAll("a").forEach(link => {
      link.addEventListener("click", () => {
        nav.classList.remove("active");
        hamburger.classList.remove("active");
        hamburgerIcon.src = "../assets/svg/hamburger-menu.svg";
      });
    });
  }

  // Mobile search toggle
  if (searchBar && searchIcon) {
    searchIcon.addEventListener("click", (e) => {
      // On mobile, toggle search bar expand
      if (window.innerWidth <= 768) {
        e.preventDefault();
        searchBar.classList.toggle("active");

        if (searchBar.classList.contains("active")) {
          searchInput.style.display = "block";
          searchInput.focus();
        } else {
          searchInput.style.display = "none";
          suggestionsBox.style.display = "none";
        }
      }
    });
  }

  // Search functionality
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
    "Correction Tape"
  ];

  if (searchInput && suggestionsBox) {
    searchInput.addEventListener("input", () => {
      const query = searchInput.value.toLowerCase().trim();
      suggestionsBox.innerHTML = "";

      if (query.length === 0) {
        suggestionsBox.style.display = "none";
        return;
      }

      const filtered = products.filter(product =>
        product.toLowerCase().includes(query)
      );

      if (filtered.length === 0) {
        const noResult = document.createElement("div");
        noResult.textContent = "No results found";
        suggestionsBox.appendChild(noResult);
        suggestionsBox.style.display = "block";
        return;
      }

      filtered.forEach(product => {
        const item = document.createElement("div");
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

    // Hide suggestions when clicking outside
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
      document.querySelector(".products")
        .scrollIntoView({ behavior: "smooth" });
    });
  }

  // FAQ accordion (only one open)
  if (faqQuestions.length > 0) {
    faqQuestions.forEach(q => {
      q.addEventListener("click", () => {
        faqQuestions.forEach(el => {
          if (el !== q) el.nextElementSibling.classList.remove("open");
        });
        q.nextElementSibling.classList.toggle("open");
      });
    });
  }

  // Cart badge updater
  if (cart) {
    let cartCount = 0;

    const updateCartBadge = () => {
      cart.setAttribute("data-count", cartCount);
    };

    updateCartBadge();

    // Increment on "Add to Cart"
    document.querySelectorAll(".cart-btn a").forEach(btn => {
      btn.addEventListener("click", (e) => {
        e.preventDefault();
        cartCount++;
        updateCartBadge();
      });
    });
  }

    // Smooth scroll for nav
    document.querySelectorAll("header nav a").forEach(link => {
      link.addEventListener("click", function(e) {
        if (this.getAttribute("href").startsWith("#")) {
          e.preventDefault();
          document.querySelector(this.getAttribute("href"))
            .scrollIntoView({ behavior: "smooth" });
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

  // Footer year auto-update
  const footerCopy = document.querySelector(".footer-copy p");
  if (footerCopy) {
    footerCopy.innerHTML = `© Copyright ${new Date().getFullYear()} M&E Interior Supplies Trading, All rights reserved.`;
  }
});
