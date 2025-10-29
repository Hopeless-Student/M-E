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

            <!-- Mobile Cart Link -->
            <a href="../shop/cart.php" class="mobile-only mobile-nav-cart" data-logged-in="<?php echo isset($_SESSION['user_id']) ? '1' : '0'; ?>">Cart</a>

            <!-- Mobile User Menu (logged in) or Login Link (logged out) -->
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="user-menu mobile-user-menu mobile-only">
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
                <a href="#" class="mobile-only" id="mobileLoginLink">Login</a>
            <?php endif; ?>
        </nav>

        <!-- Desktop Header Actions -->
        <div class="header-actions">
            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="cart">
                    <a href="../shop/cart.php">
                        <img alt="cart" class="cart-img" src="../assets/svg/bag.svg"/>
                        <span id="cartCount" class="cart-count"></span>
                    </a>
                </div>
            <?php else: ?>
                <div class="cart">
                    <a href="../shop/cart.php" id="toggleLogin">
                        <img alt="cart" class="cart-img" src="../assets/svg/bag.svg"/>
                        <span id="cartCount" class="cart-count"></span>
                    </a>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['user_id'])): ?>
                <div class="user-menu">
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
                <div class="btn-login">
                    <a href="#" id="openLoginModal">
                        <img class="login-img" src="../assets/svg/person.svg" alt="Log in">
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</header>
