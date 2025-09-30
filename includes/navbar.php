<header>
    <div class="logo">
        <img alt="M&E Logo" src="../assets/images/M&E_LOGO-semi-transparent.png"/>
    </div>

    <div class="hamburger">
        <img src="../assets/svg/hamburger-menu.svg" alt="Menu" class="hamburger-icon"/>
    </div>

    <nav>
        <a href="index.php">Home</a>
        <a href="products.php">Products</a>
        <a href="about.php">About Us</a>
        <a href="../test-files/order-history-test.php" class="mobile-only mobile-nav-cart">Cart</a>
        <?php if (isset($_SESSION['user_id'])): ?>
        <div class="user-menu mobile-user-menu">
            <a href="../user/profile.php" class="user-avatar">
                <img src="<?php echo $profileImage; ?>" alt="User Avatar" class="avatar">
            </a>
            <ul class="dropdown">
                <li><a href="../user/profile.php">My Profile</a></li>
                <li><a href="../user/order-history.php">My Orders</a></li>
                <li><a href="../auth/logout.php">Logout</a></li>
            </ul>
        </div>
    <?php else: ?>
        <a href="#" id="mobileLoginLink" class="mobile-only">Login</a>
    <?php endif; ?>
    </nav>

    <div class="header-actions">
        <div class="cart">
            <a href="../test-files/order-history-test.php">
                <img alt="cart" class="cart-img" src="../assets/svg/bag.svg"/>
            </a>
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
</header>
