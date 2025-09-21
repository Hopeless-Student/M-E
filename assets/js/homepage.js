document.addEventListener("DOMContentLoaded", () => {
  const hamburger = document.querySelector(".hamburger");
  const hamburgerIcon = document.querySelector(".hamburger-icon");
  const nav = document.querySelector("header nav");
  const searchInput = document.querySelector("#search-input");
  const suggestionsBox = document.querySelector(".search-suggestions");

  if (hamburger && nav && hamburgerIcon) {
    hamburger.addEventListener("click", () => {
      nav.classList.toggle("active");
      hamburger.classList.toggle("active");

      if (nav.classList.contains("active")) {
        hamburgerIcon.src = "../assets/svg/hamburger-menu-active.svg";
      } else {
        hamburgerIcon.src = "../assets/svg/hamburger-menu.svg";
      }
    });
  }

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
        suggestionsBox.style.display = "none";
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

    document.addEventListener("click", (e) => {
      if (!e.target.closest(".search-bar")) {
        suggestionsBox.style.display = "none";
      }
    });
  }
});
