<style media="screen">
      header {
          position: sticky;
          top: 0;
          z-index: 1000;
          padding: 0 35px;
          height: 80px;
          background-color: #4169E1;
          display: flex;
          align-items: center;
          justify-content: space-between;
      }

      header .logo img {
          height: 70px;
      }

      .hamburger {
          display: none;
      }

      header nav {
          display: flex;
          flex: 1;
          justify-content: center;
          gap: 32px;
      }

      header nav a {
          font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
          color: #FFFFFF;
          font-weight: bold;
          font-size: 15px;
          text-decoration: none;
      }

      header nav a:hover {
          transition: 400ms;
          color: #C6D7FF;
          text-decoration: underline;
          text-underline-offset: 5px;
      }

      header nav a:active {
          color: #002366;
      }

      header .header-actions {
          display: flex;
          align-items: center;
          gap: 20px;
      }

      .header-actions .cart {
          position: relative;
          background-color: #FFFFFF;
          border-radius: 70%;
          padding: 9px 11px;
      }

      .header-actions .cart::after {
          content: attr(data-count);
          position: absolute;
          top: -5px;
          right: -5px;
          background: red;
          color: white;
          font-size: 12px;
          border-radius: 50%;
          padding: 2px 6px;
          display: none;
      }

      .header-actions .cart[data-count]:not([data-count="0"])::after {
          display: block;
      }

      .header-actions .cart-img {
          height: 26px;
      }

      .header-actions .cart:hover {
          background-color: #A6BAFF;
          transition: 400ms;
      }

      .header-actions .cart:active {
          background-color: #4169E1;
          transition: 400ms;
      }

      .header-actions .btn-login a {
          display: flex;
          align-items: center;
          justify-content: center;
          background-color: #FFFFFF;
          border-radius: 70%;
          padding: 9px 11px;
          height: 49px;
          width: 49px;
      }

      .header-actions .btn-login img {
          height: 26px;
          width: 26px;
          object-fit: contain;
      }

      .header-actions .btn-login a:hover {
          background-color: #A6BAFF;
          transition: 400ms;
      }

      .header-actions .btn-login a:active {
          background-color: #4169E1;
          transition: 400ms;
      }

      header.scrolled {
          background-color: #ffffff;
          transition: background-color 400ms ease;
      }

      header.scrolled nav a {
          transition: 400ms ease;
          color: #4169E1;
      }

      header.scrolled nav a:hover {
          color: #A6BAFF;
      }

      header.scrolled nav a:active {
          color: #E8E8E8;
      }

      header.scrolled .btn-login a {
          transition: 400ms ease;
          border: 1px solid #4169E1;
      }

      header.scrolled .btn-login a:hover {
          background-color: #FFFFFF;
          color: #4169E1;
      }

      header.scrolled .search-bar,
      .cart {
          border: 1px solid #4169E1;
      }
      nav .mobile-only {
          display: none !important;
      }

      .nav-content {
          max-width: 1280px;
          margin: 0 auto;
          width: 100%;
          display: flex;
          align-items: center;
          justify-content: space-between;
          gap: 24px;
      }

      header .logo {
        min-width: 140px;
        display: flex;
        align-items: center;
        }

      .cart-count {
          position: absolute;
          top: -6px;
          right: -6px;
          background: #ef4444;
          color: #ffffff;
          border-radius: 50%;
          min-width: 20px;
          height: 20px;
          display: flex;
          align-items: center;
          justify-content: center;
          font-size: 12px;
          font-weight: normal;
          line-height: 1;
          padding: 0 6px;
      }

      @media (max-width: 1024px) {
          header { padding: 0 20px; }
          header nav { gap: 20px; }
          .nav-content { gap: 16px; }
      }

      @media (max-width: 768px) {
        .header-actions .user-menu {
        display: none !important;
        }

    nav .mobile-user-menu {
        display: block !important;
        width: 100%;
        text-align: center;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid rgba(255, 255, 255, 0.2);
    }

    nav .mobile-user-menu .user-avatar .avatar {
        width: 40px;
        height: 40px;
        margin: 0 auto 10px auto;
        display: block;
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    nav .mobile-user-menu .dropdown {
        position: static !important;
        display: block !important;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        margin-top: 10px;
        box-shadow: none;
        backdrop-filter: blur(10px);
    }

    nav .mobile-user-menu .dropdown li a {
        color: #fff !important;
        padding: 12px 15px;
        font-size: 16px;
        font-weight: bold;
        display: block;
        width: 100%;
        text-align: center;
    }

    nav .mobile-user-menu .dropdown li a:hover {
        background: rgba(255, 255, 255, 0.2);
        color: #4169E1 !important;
        font-weight: bold;
    }

    header.scrolled nav .mobile-user-menu .dropdown {
        background: rgba(65, 105, 225, 0.1);
        border: 1px solid rgba(65, 105, 225, 0.2);
    }

    header.scrolled nav .mobile-user-menu .dropdown li a {
        color: #4169E1 !important;
    }

    header.scrolled nav .mobile-user-menu .dropdown li a:hover {
        background: rgba(65, 105, 225, 0.1);
        color: #002366 !important;
    }

    header.scrolled nav .mobile-user-menu .user-avatar .avatar {
        border-color: rgba(65, 105, 225, 0.3);
    }
          header {
            display: flex;
            align-items: center;
        }
        header .logo {
            margin-right: auto;
        }
        header .logo img {
            height: 70px;
        }
        header nav {
            position: absolute;
            top: 80px;
            gap: 0;
            left: 0;
            width: 100%;
            flex-direction: column;
            align-items: center;
            background-color: #4169E1;
            border-radius: 0 0 20px 20px;
            max-height: 0;
            transition: max-height 400ms ease;
            z-index: 999;
            overflow: hidden;
            box-shadow: none;
        }
        header nav.active {
            max-height: 500px;
            padding: 15px 0;
            box-shadow: 0 15px 15px rgba(0, 0, 0, 0.25);
        }
        header nav a {
            display: block;
            width: 100%;
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            padding: 12px 0;
            background: transparent;
            transition: color 400ms, background 400ms;
        }
        header nav a:hover {
            background-color: #4169E1;
            color: #C6D7FF;
        }
        header.scrolled nav {
            transition: 400ms ease;
            background-color: #fff !important;
        }
        header.scrolled nav a {
            transition: 400ms ease;
            color: #4169E1 !important;
            background: transparent !important;
        }
        header.scrolled nav a:hover {
            background-color: #f0f4ff !important;
            color: #002366 !important;
        }
        .header-actions {
            display: none !important;
        }
        nav .mobile-only {
            display: block !important;
        }
        .hamburger {
            display: flex;
            align-items: center;
            cursor: pointer;
            border-radius: 50%;
            padding: 8px;
            margin-left: auto;
        }
        .hamburger img {
            height: 35px;
        }
        .hamburger:active {
            transition: 400ms ease;
            background: transparent;
        }
        .hamburger.active {
            transition: rotate 400ms ease;
            rotate: -90deg;
            height: 50px;
            content: url("../assets/svg/x-button-white.svg");
        }
        header.scrolled .hamburger img {
            height: 35px;
            content: url("../assets/svg/hamburger-menu-active.svg");
        }
        header.scrolled .hamburger:active {
            background: transparent;
        }
        header.scrolled .hamburger.active {
            transition: rotate 400ms ease;
            rotate: -90deg;
            height: 50px;
            content: url("../assets/svg/x-button-blue.svg");
        }
        .header-actions {
            display: none !important;
        }
        nav .mobile-nav-cart,
        nav #mobileLoginLink {
            display: block;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            margin-top: 10px;
        }
        nav .mobile-nav-cart:hover,
        nav #mobileLoginLink:hover {
            color: #C6D7FF;
        }
        .header-actions .cart {
            padding: 6px 8px;
            border-radius: 50%;
            background-color: #fff;
        }
        .header-actions .cart-img {
            height: 22px;
        }
        .header-actions .btn-login a {
            padding: 7px 20px;
        }
      }
</style>

<header>
    <div class="nav-content">
    <div class="logo">
        <img alt="M&E Logo" src="../assets/images/M&E_LOGO-semi-transparent.png"/>
    </div>

    <div class="hamburger">
        <img src="../assets/svg/hamburger-menu.svg" alt="Menu" class="hamburger-icon"/>
    </div>

    <nav>
        <a href="../pages/index.php">Home</a>
        <a href="../pages/products.php">Products</a>
        <a href="../pages/about.php">About Us</a>
        <a href="order-history-test.php" class="mobile-only mobile-nav-cart">Cart</a>
        <?php if (isset($_SESSION['user_id'])): ?>
        <div class="user-menu mobile-user-menu">
            <a href="../user/profile.php" class="user-avatar">
                <img src="<?php echo $profileImage; ?>" alt="User Avatar" class="avatar">
            </a>
            <ul class="dropdown">
                <li><a href="../user/profile.php">My Profile</a></li>
                <li><a href="../user/order-history.php">My Orders</a></li>
                <li><a href="../user/request.php">Request</a></li>
                <li><a href="../auth/logout.php">Logout</a></li>
            </ul>
        </div>
    <?php else: ?>
        <a href="#" id="mobileLoginLink" class="mobile-only">Login</a>
    <?php endif; ?>
    </nav>

    <div class="header-actions">
      <?php if (isset($_SESSION['user_id'])): ?>
        <div class="cart">
          <a href="../shop/cart.php">
            <img alt="cart" class="cart-img" src="../assets/svg/bag.svg"/>
            <span id="cartCount" class="cart-count">0</span>
          </a>
          <?php else: ?>
            <div class="cart">
              <a href="../shop/cart.php" id="toggleLogin">
                <img alt="cart" class="cart-img" src="../assets/svg/bag.svg"/>
                <span id="cartCount" class="cart-count">0</span>
              </a>
      <?php endif; ?>
        </div>

        <?php if (isset($_SESSION['user_id'])): ?>
          <div class="user-menu">
            <a href="../user/profile.php" class="user-avatar">
              <img src="<?php echo $profileImage; ?>"
              alt="User Avatar"
              class="avatar" style="">
            </a>
            <ul class="dropdown">
            <li><a href="../user/profile.php">My Profile</a></li>
            <li><a href="../user/order-history.php">My Orders</a></li>
            <li><a href="../user/request.php">Request</a></li>
            <li><a href="../auth/logout.php">Logout</a></li>
          </ul>
          </div>
        <?php else: ?>
          <!-- <p> NO USER</p> -->
          <div class="btn-login">
            <a href="#" id="openLoginModal">
              <img class="login-img" src="../assets/svg/person.svg" alt="Log in">
            </a>
          </div>
        <?php endif; ?>
    </div>
    </div>
</header>

<script>
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
        }
        else {
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
</script>