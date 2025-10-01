<?php
require_once __DIR__ . '/../includes/database.php';
  session_start();
$user = null;
if (isset($_SESSION['user_id'])) {
    $pdo = connect();
    $stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = :id LIMIT 1");
    $stmt->execute([':id' => $_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}
$profileImage = !empty($user['profile_image'])
    ? "../assets/profile-pics/" . htmlspecialchars($user['profile_image'])
    : "../assets/images/default.png";
 ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" content="width=device-width, initial-scale=1.0" name="viewport"/>
        <link href="../assets/css/homepage.css" rel="stylesheet"/>
        <title>M&E: Interior Supplies Trading</title>
    </head>

    <body>
        <!-- <header>
            <div class="logo">
                <img alt="M&E Logo" src="../assets/images/M&E_LOGO-semi-transparent.png"/>
            </div>

            <div class="hamburger">
                <img src="../assets/svg/hamburger-menu.svg" alt="Menu" class="hamburger-icon"/>
            </div>

            <nav>
                <a href="homepage.php">Home</a>
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
                   <p> NO USER</p>
                  <div class="btn-login">
                    <a href="#" id="openLoginModal">
                      <img class="login-img" src="../assets/svg/person.svg" alt="Log in">
                    </a>
                  </div>
                <?php endif; ?>
            </div>
        </header> -->

        <?php include('../includes/navbar.php') ?>


        <section class="hero">
                <div class="hero-content">
                    <h1>
                        Your One-stop Shop for <span class="highlight">Office, School,</span> and <span class="highlight">Sanitary Supplies</span>
                    </h1>
                    <p>Fast, reliable, and hassle-free ordering - delivered straight to your door.</p>

                    <div class="hero-search-bar">
                        <img alt="search" class="search-icon" src="../assets/svg/search.svg"/>
                        <input placeholder="Search products..." type="text" id="search-input"/>
                        <div class="search-suggestions"></div>
                    </div>
                    <a href="#" class="hero-cta">Shop Now</a>
                </div>
        </section>



        <section class="products">
            <div class="products-header">
                <h2>Top Ordered Products</h2>

                <div class="products-actions">
                <p>See products</p>

                    <div class="right-btn">
                        <a href="#">
                            <img alt="right" class="right-icon" src="../assets/svg/right-icon.svg"/>
                        </a>
                    </div>
                </div>
            </div>

            <div class="product-grid">
                <div class="product-card">
                    <a class="card-link" href="#">
                        <img alt="Scotch Tape Roll" src="../assets/images/scotch-tape-roll.png"/>

                        <div class="product-info">
                            <h3>Scotch Tape Roll</h3>
                            <p>PHP 50.00</p>
                        </div>
                    </a>

                <div class="cart-btn">
                    <a href="#">
                        <img alt="cart" src="../assets/svg/bag.svg"/>
                    </a>
                </div>
            </div>


            <div class="product-card">
                <a class="card-link" href="#">
                    <img alt="Scotch Tape Roll" src="../assets/images/scotch-tape-roll.png"/>

                    <div class="product-info">
                        <h3>Scotch Tape Roll</h3>
                        <p>PHP 50.00</p>
                    </div>
                </a>

                <div class="cart-btn">
                    <a href="#">
                        <img alt="cart" src="../assets/svg/bag.svg"/>
                    </a>
                </div>
            </div>


            <div class="product-card">
                <a class="card-link" href="#">
                    <img alt="Scotch Tape Roll" src="../assets/images/scotch-tape-roll.png"/>

                    <div class="product-info">
                        <h3>Scotch Tape Roll</h3>
                        <p>PHP 50.00</p>
                    </div>
                </a>

                <div class="cart-btn">
                    <a href="#">
                        <img alt="cart" src="../assets/svg/bag.svg"/>
                    </a>
                </div>
            </div>


            <div class="product-card">
                <a class="card-link" href="#">
                    <img alt="Scotch Tape Roll" src="../assets/images/scotch-tape-roll.png"/>

                    <div class="product-info">
                        <h3>Scotch Tape Roll</h3>
                        <p>PHP 50.00</p>
                    </div>
                </a>

                <div class="cart-btn">
                    <a href="#">
                        <img alt="cart" src="../assets/svg/bag.svg"/>
                    </a>
                </div>
            </div>


            <div class="product-card">
                <a class="card-link" href="#">
                    <img alt="Scotch Tape Roll" src="../assets/images/scotch-tape-roll.png"/>

                    <div class="product-info">
                        <h3>Scotch Tape Roll</h3>
                        <p>PHP 50.00</p>
                    </div>
                </a>

                <div class="cart-btn">
                    <a href="#">
                        <img alt="cart" src="../assets/svg/bag.svg"/>
                    </a>
                </div>
            </div>


            <div class="product-card">
                <a class="card-link" href="#">
                    <img alt="Scotch Tape Roll" src="../assets/images/scotch-tape-roll.png"/>

                    <div class="product-info">
                        <h3>Scotch Tape Roll</h3>
                        <p>PHP 50.00</p>
                    </div>
                </a>

                <div class="cart-btn">
                    <a href="#">
                        <img alt="cart" src="../assets/svg/bag.svg"/>
                    </a>
                </div>
            </div>


            <div class="product-card">
                <a class="card-link" href="#">
                    <img alt="Scotch Tape Roll" src="../assets/images/scotch-tape-roll.png"/>

                    <div class="product-info">
                        <h3>Scotch Tape Roll</h3>
                        <p>PHP 50.00</p>
                    </div>
                </a>

                <div class="cart-btn">
                    <a href="#">
                        <img alt="cart" src="../assets/svg/bag.svg"/>
                    </a>
                </div>
            </div>


            <div class="product-card">
                <a class="card-link" href="#">
                    <img alt="Scotch Tape Roll" src="../assets/images/scotch-tape-roll.png"/>

                    <div class="product-info">
                        <h3>Scotch Tape Roll</h3>
                        <p>PHP 50.00</p>
                    </div>
                </a>

                <div class="cart-btn">
                    <a href="#">
                        <img alt="cart" src="../assets/svg/bag.svg"/>
                    </a>
                </div>
            </div>


            <div class="product-card">
                <a class="card-link" href="#">
                    <img alt="Scotch Tape Roll" src="../assets/images/scotch-tape-roll.png"/>

                    <div class="product-info">
                        <h3>Scotch Tape Roll</h3>
                        <p>PHP 50.00</p>
                    </div>
                </a>

                <div class="cart-btn">
                    <a href="#">
                        <img alt="cart" src="../assets/svg/bag.svg"/>
                    </a>
                </div>
            </div>


            <div class="product-card">
                <a class="card-link" href="#">
                    <img alt="Scotch Tape Roll" src="../assets/images/scotch-tape-roll.png"/>

                    <div class="product-info">
                        <h3>Scotch Tape Roll</h3>
                        <p>PHP 50.00</p>
                    </div>
                </a>

                <div class="cart-btn">
                    <a href="#">
                        <img alt="cart" src="../assets/svg/bag.svg"/>
                    </a>
                </div>
            </div>
        </section>



        <section class="categories">
            <div class="categ-header">
                <h2>Shop by Category</h2>
            </div>

            <div class="categ-grid">
                <div class="categ-card">
                    <a href="#">
                        <img alt="School Supplies" src="../assets/images/school-supplies.png"/>

                        <div class="overlay">
                            <span>School Supplies</span>
                        </div>
                    </a>
                </div>

                <div class="categ-card">
                    <a href="#">
                        <img alt="Office Supplies" src="../assets/images/office-supplies.png"/>

                        <div class="overlay">
                            <span>Office Supplies</span>
                        </div>
                    </a>
                </div>

                <div class="categ-card">
                    <a href="#">
                        <img alt="Sanitary Supplies" src="../assets/images/sanitary-supplies.png"/>

                        <div class="overlay">
                            <span>Sanitary Supplies</span>
                        </div>
                    </a>
                </div>
            </div>
        </section>



        <section class="trust">
            <div class="trust-content">
                <h2>Why Choose Us?</h2>
                <p>We are committed to providing the best service and quality products to our customers.</p>
            </div>

            <div class="trust-grid">
                <div class="trust-card">

                    <div class="icon-circle">
                        <img alt="Affordable Prices" src="../assets/svg/price-tag.svg"/>
                    </div>

                    <h3>Affordable & Competitive Prices</h3>
                </div>

                <div class="trust-card">
                    <div class="icon-circle">
                        <img alt="Bulk Orders" src="../assets/svg/order-approve-rounded.svg"/>
                    </div>

                    <h3>Bulk Orders for Schools & Offices</h3>
                </div>

                <div class="trust-card">
                    <div class="icon-circle">
                        <img alt="Quality Trust" src="../assets/svg/workspace-trusted.svg"/>
                    </div>

                    <h3>Trusted Quality Supplies</h3>
                </div>
            </div>
        </section>



        <section class="about-us">
            <div class="about-us-grid">
                <div class="about-us-image">
                    <img alt="About Us Image" src="../assets/images/about-us-image.jpg"/>
                </div>

                <div class="about-us-text">
                    <h2>About Us</h2>
                    <p>We supply quality school, office, and sanitary essentials to local customers. Our focus is reliable service and value - perfect for students, teachers, and offices.</p>

                    <a class="about-btn" href="about.php">Read more About Us</a>
                </div>
            </div>
        </section>



        <section class="contact">
            <div class="contact-content">
                <h2>Contact Us</h2>
                <p>We'd love to hear from you! Reach out via the details or send us a quick message.</p>
            </div>

            <div class="contact-grid">
                <div class="contact-card">
                    <img alt="Store Address" src="../assets/svg/location.svg"/>

                    <div>
                        <h3>Store Address:</h3>
                        <p>Purok 4 Banaba St Bo.<br/>Barretto Olongapo City</p>
                    </div>
                </div>

                <div class="contact-card">
                    <img alt="Contact No" src="../assets/svg/phone.svg"/>

                    <div>
                        <h3>Contact No.:</h3>
                        <p>+63 916 635 1911</p>
                    </div>
                </div>

                <div class="contact-card">
                    <img alt="Email" src="../assets/svg/email.svg"/>

                <div>
                    <h3>Email:</h3>
                    <p>elbarcoma@gmail.com</p>
                </div>
            </div>
        </section>



        <section class="faqs">
            <div class="faqs-content">
                <h2>
                    <span class="faqs-highlight">F</span>requently
                    <br>
                    <span class="faqs-highlight">A</span>sked
                    <br>
                    <span class="faqs-highlight">Q</span>uestions
                </h2>
            </div>

            <div class="faqs-column">
                <div class="faqs-list">
                    <div class="faq-item">
                        <p class="faq-question"><strong>Q:</strong> Do you accept bulk orders?</p>
                        <p class="faq-answer">Yes, we accept bulk orders for schools, offices, and organizations.</p>
                    </div>

                    <div class="faq-item">
                        <p class="faq-question"><strong>Q:</strong> What are delivery options?</p>
                        <p class="faq-answer">We offer same-day delivery within Olongapo City.</p>
                    </div>

                    <div class="faq-item">
                        <p class="faq-question"><strong>Q:</strong> Returns & refunds?</p>
                        <p class="faq-answer">Items cannot be returned after checking out or after the product request. Items must ensure before checking out.</p>
                    </div>
                </div>

                <div class="faqs-more">
                    <a href="#">More about FAQs
                        <img alt="More" src="../assets/svg/right-arrow.svg"/>
                    </a>
                </div>
            </div>
        </section>



        <?php include '../includes/footer.php';?>

        <!-- <?php include('login-modal.php'); ?> -->


        <div id="loginModal" class="modal">
            <div class="modal-content">
                <span class="close-btn" id="closeLoginModal">&times;</span>

                <img src="../assets/images/M&E_LOGO-semi-transparent.png" alt="M&E Logo">

                <h2>Login</h2>

                <form id="loginForm" action="../auth/login_handler.php" method="post">
                    <input type="text" placeholder="Username or Email" name="login_id" id="username" required/>

                    <input type="password" placeholder="Password" id="loginpassword" name="password" required/>

                    <button type="submit">Log In</button>

                    <p class="modal-switch-text">
                        Don't have an account?
                        <a href="#" id="openSignupModal">Create Your Account here</a>
                    </p>
                </form>
            </div>
        </div>

        <div id="signupModal" class="modal">
            <div class="modal-content">
                <span id="closeSignupModal" class="close-btn">&times;</span>

                <img src="../assets/images/M&E_LOGO-semi-transparent.png" alt="M&E Logo">

                <h2>Create Your Account</h2>

                <form id="signupForm" action="../auth/register_process.php" method="post">
                    <input type="text" placeholder="First Name" id="firstName" name="firstName" required>

                    <input type="text" placeholder="Last Name" id="lastName" name="lastName" required>

                    <input type="email" placeholder="Email" id="email" name="email" required>

                    <input type="password" placeholder="Password" id="password" name="password" required>

                    <input type="password" placeholder="Confirm Password" id="confirmPassword" name="confirm-password" required>

                    <div class="terms">
                        <label class="terms-label">
                            <input type="checkbox" id="termsCheckbox" required>
                            <span>I confirm agree to our <a href="terms-of-service.php" target="_blank" id="openTermsModal">Terms and Conditions</a></span>
                        </label>
                    </div>

                    <button type="submit" id="verifyEmailBtn" disabled>Verify Email</button>

                    <p class="modal-switch-text">
                        Already have an account?
                        <a href="#" id="signupToLoginLink">Log in here</a>
                    </p>
                </form>
            </div>
        </div>

        <!-- <div id="termsModal" class="modal">
            <div class="modal-content">
                <span id="closeTermsModal" class="close-btn">&times;</span>
                <h2>Terms and Conditions</h2>
                <ol>
                    <li>Introduction</li>
                    <p>Welcome to M&E Interior Trading Supplies. By using our website and services, you agree to these Terms & Conditions. Please read them carefully.</p>
                    <br>
                    <li>Using our service</li>
                    <p>Customers must be at least 18 years old or have parental consent. You agree to provide accurate information when placing orders.</p>
                    <br>
                    <li>Orders & Payment</li>
                    <p>Prices are displayed in your local currency. Payments are processed through third-party providers — M&E Interior Trading Supplies does not store payment details.</p>
                    <br>
                    <li>Shipping & Returns</li>
                    <p>Shipping times vary by location. Cancellation are not accepted unless otherwise stated on the product page.</p>
                    <br>
                    <li>intellectual Property</li>
                    <p>All content on this site is owned or licensed by M&E Interior Trading Supplies. You may not reuse our content without permission.</p>
                    <br>
                    <li>Limitation of Liability</li>
                    <p>To the fullest extent permitted by law, M&E Interior Trading Supplies is not liable for indirect or consequential loss arising from use of the site.</p>
                    <br>
                    <li>Changes</li>
                    <p>We may update these Terms from time to time. We will publish changes on this page with a revised date.</p>
                </ol>
            </div>
        </div> -->

        <script src="../bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
        <script src="../bootstrap-5.3.8-dist/js/bootstrap.bundle.js"></script>
        <script src="../assets/js/homepage.js"></script>
    </body>
</html>
