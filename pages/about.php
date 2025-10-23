<?php require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../auth/mainpage-auth.php'; ?>
<!DOCTYPE html>
<html lang="en">
    <?php
        $pageTitle = "About Us - M&E";
        include '../includes/header.php';
    ?>

    <link rel="stylesheet" href="../assets/css/about.css">

    <body>
        <?php include '../includes/navbar.php'; ?>

        <section class="about-hero">
            <div class="about-hero-overlay"></div>

            <div class="about-hero-content">
                <h1>About Us</h1>
                <p class="lead">M&E Trading is your trusted e-commerce platform for quality office, school, and sanitary supplies—delivered fast, priced right, and always reliable.</p>
            </div>
        </section>



        <section class="our-journey">
            <div class="journey-content">
                <h2>Our Journey</h2>
                <p>
                    Founded in 2022, M&E Trading started as a small local shop with a big vision:
                    to make high-quality supplies accessible to every Filipino household, school,
                    and business. Today, we serve thousands of customers with fast and reliable delivery.
                </p>

                <ul class="timeline">
                    <li>
                        <span class="timeline-year">2022</span>
                        <p>Launched our first online store.</p>
                    </li>
                    <li>
                        <span class="timeline-year">2023</span>
                        <p>Expanded product catalog to 5,000+ items and partnered with schools.</p>
                    </li>
                    <li>
                        <span class="timeline-year">2024</span>
                        <p>Introduced bulk order discounts and next-day delivery.</p>
                    </li>
                    <li>
                        <span class="timeline-year">2025</span>
                        <p>Surpassed 10,000 products sold and 1,500+ happy customers.</p>
                    </li>
                </ul>
            </div>

            <div class="journey-image" style="background-image:url('../assets/images/mockup-image.png');"></div>
        </section>



        <section class="mission-values py-5 bg-light">
            <div class="container text-center">
                <h2 class="fw-bold mb-5">Our Mission & Values</h2>

                <div class="row justify-content-center">

                    <div class="col-md-4 mb-4">
                        <div class="value-card animated-card h-100">
                            <div class="icon-circle">
                                <img src="../assets/svg/workspace-trusted.svg" alt="Quality Products">
                            </div>
                            <h3 class="fw-bold">Quality Products</h3>
                            <p>We carefully curate our products from trusted manufacturers and suppliers to ensure you get the best quality.</p>
                        </div>
                    </div>

                    <div class="col-md-4 mb-4">
                        <div class="value-card animated-card h-100">
                            <div class="icon-circle">
                                <img src="../assets/svg/delivery.svg" alt="Fast Delivery">
                            </div>
                            <h3 class="fw-bold">Fast Delivery</h3>
                            <p>We ensure quick processing and efficient delivery of your orders, getting your supplies to you when you need them.</p>
                        </div>
                    </div>

                    <div class="col-md-4 mb-4">
                        <div class="value-card animated-card h-100">
                            <div class="icon-circle">
                                <img src="../assets/svg/customer-support-1-solid.svg" alt="24/7 Support">
                            </div>
                            <h3 class="fw-bold">24/7 Support</h3>
                            <p>Our dedicated customer service team is always ready to assist you with any questions or concerns.</p>
                        </div>
                    </div>

                </div>
            </div>
        </section>



        <section class="team py-5">
            <div class="container text-center">
                <h2 class="fw-bold mb-5">Meet the Team</h2>

                <div class="row justify-content-center">

                    <div class="col-md-3 mb-4">
                        <div class="team-member">
                            <img src="../assets/svg/person.svg" alt="Elbar Coma" class="rounded-circle shadow" style="width:160px;height:160px;object-fit:cover;">
                            <h3 class="mt-3">Elbar Coma</h3>
                            <p>Founder & Owner</p>
                            <span class="badge bg-primary">E-commerce Visionary</span>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="team-member">
                            <img src="../assets/svg/person.svg" alt="Maria Santos" class="rounded-circle shadow" style="width:160px;height:160px;object-fit:cover;">
                            <h3 class="mt-3">Maria Santos</h3>
                            <p>Sales Manager</p>
                            <span class="badge bg-success">Customer Champion</span>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="team-member">
                            <img src="../assets/svg/person.svg" alt="Daniel Cruz" class="rounded-circle shadow" style="width:160px;height:160px;object-fit:cover;">
                            <h3 class="mt-3">Daniel Cruz</h3>
                            <p>Logistics Lead</p>
                            <span class="badge bg-warning text-dark">Delivery Expert</span>
                        </div>
                    </div>

                </div>
            </div>
        </section>



        <section class="testimonials py-5 bg-primary text-white">
            <div class="container text-center">
                <h2 class="fw-bold mb-5">What Our Customers Say</h2>

                <div class="row justify-content-center">

                    <div class="col-md-5 mb-4">
                        <div class="testimonial p-4 rounded bg-white text-dark shadow">
                            <p class="mb-2">"Fast delivery and reliable service. Highly recommend!"</p>
                            <span class="text-primary">- Maria, School Principal</span>
                        </div>
                    </div>

                    <div class="col-md-5 mb-4">
                        <div class="testimonial p-4 rounded bg-white text-dark shadow">
                            <p class="mb-2">"Affordable prices and great product quality. We always buy here."</p>
                            <span class="text-primary">- Daniel, Office Admin</span>
                        </div>
                    </div>

                </div>

                <div class="row justify-content-center mt-4">

                    <div class="col-md-5 mb-4">
                        <div class="testimonial p-4 rounded bg-white text-dark shadow">
                            <p class="mb-2">"Bulk ordering for our school was so easy. The support team was very helpful!"</p>
                            <span class="text-primary">- Principal Reyes</span>
                        </div>
                    </div>

                    <div class="col-md-5 mb-4">
                        <div class="testimonial p-4 rounded bg-white text-dark shadow">
                            <p class="mb-2">"I love the real-time tracking and fast delivery. Will order again!"</p>
                            <span class="text-primary">- Office Manager, ABC Corp</span>
                        </div>
                    </div>

                </div>

            </div>
        </section>



        <section class="about-cta">
            <div class="container text-center">
                <h2 class="fw-bold mb-3">Ready to Order?</h2>
                <p class="mb-4">Visit our shop or contact us for bulk orders and inquiries.<br>We're here to help you get the supplies you need, fast.</p>

                <div class="cta">
                    <a href="products.php" class="btn btn-primary">Browse Products</a>
                    <a href="contact.php" class="btn btn-outline-primary">Contact Us</a>
                </div>
            </div>
        </section>
        <div id="loginModal" class="modal">
            <div class="modal-content">
                <span class="close-btn" id="closeLoginModal">&times;</span>

                <img src="../assets/images/M&E_LOGO-semi-transparent.png" alt="M&E Logo">

                <h2>Login</h2>

                <form id="loginForm" action="../auth/login_handler.php" method="post">
                    <input type="text" placeholder="Username or Email" name="login_id" id="username" required/>
                    <!-- <input type="password" placeholder="Password" id="loginpassword" name="password" required/> -->
                    <div class="password-wrapper" style="position: relative;">
                      <input type="password" placeholder="Password" id="loginpassword" name="password"
                             style="padding-right: 40px;" required />
                      <img id="togglePassword" class="eye-icon" src="../assets/svg/eye.svg" alt="Toggle Password" />
                    </div>
                                        <button type="submit">Log In</button>
                    <?php if (isset($_SESSION['loginFailed'])): ?>
                      <p class="error-message" style="color:red; margin-top:10px; font-size:0.9rem; text-align:center"> <?php echo $_SESSION['loginFailed']; unset($_SESSION['loginFailed']);?> </p>
                    <?php endif; ?>
                    <p class="modal-switch-text">
                        Don't have an account?
                        <a href="#" id="openSignupModal">Create Your Account here</a>
                    </p>
                </form>
            </div>
        </div>
        <!-- Para ma-trigger yung condition sa header pre na log in modal  -->
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
        <?php include '../includes/footer.php'; ?>
        <?php include '../includes/login-modal.php'; ?>
        <script src="../assets/js/homepage.js"></script>
    </body>
</html>
