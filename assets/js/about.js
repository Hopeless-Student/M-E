document.addEventListener("DOMContentLoaded", () => {
  // Header & nav elements
  const hamburger = document.querySelector(".hamburger");
  const hamburgerIcon = document.querySelector(".hamburger-icon");
  const nav = document.querySelector("header nav");
  const header = document.querySelector("header");

// Header color transition
  if (header) {
    window.addEventListener("scroll", () => {
      if (window.scrollY > 400) {
        header.classList.add("scrolled");
      } else {
        header.classList.remove("scrolled");
      }
    });
  }

  if (hamburger && nav && hamburgerIcon) {
    hamburger.addEventListener("click", () => {
      nav.classList.toggle("active");
      hamburger.classList.toggle("active");

      // Switch icon
      hamburgerIcon.src = nav.classList.contains("active")
        ? "../assets/svg/hamburger-menu-active.svg"
        : "../assets/svg/hamburger-menu.svg";
    });

    // Close nav when a link is clicked
    nav.querySelectorAll("a").forEach((link) => {
      link.addEventListener("click", () => {
        nav.classList.remove("active");
        hamburger.classList.remove("active");
        hamburgerIcon.src = "../assets/svg/hamburger-menu.svg";
      });
    });
  }
});