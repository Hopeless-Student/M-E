<?php
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../auth/mainpage-auth.php';

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" content="width=device-width, initial-scale=1.0" name="viewport"/>
      <link rel="icon" type="image/x-icon" href="../assets/images/M&E_LOGO-semi-transparent.ico">
        <link rel="stylesheet" href="../assets/css/contact.css"/>
        <link rel="stylesheet" href="../assets/css/navbar.css"/>
        <title>M&E: Contact Us</title>
    </head>

    <body>
        <?php include '../includes/navbar.php'; ?>
        <?php if (isset($_SESSION['request_success'])): ?>
            <div class="alert-message success">
                <?= htmlspecialchars($_SESSION['request_success']) ?>
            </div>
            <?php unset($_SESSION['request_success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['request_error'])): ?>
            <div class="alert-message error">
                <?= htmlspecialchars($_SESSION['request_error']) ?>
            </div>
            <?php unset($_SESSION['request_error']); ?>
        <?php endif; ?>

        <section class="contact-hero">
            <div class="contact-hero-content">
                <h1>Contact Us</h1>
                <p>We're here to help with inquiries, feedback, or bulk order requests.</p>
            </div>
        </section>

        <section class="contact-section">
            <div class="contact-container">

                <div id="location" class="contact-info">
                    <h2>Contact Information</h2>
                    <p>Get in touch with us through the details below, or use the form to send a quick message.</p>

                    <div class="info-item">
                        <img src="../assets/svg/location.svg" alt="Location">

                        <div>
                            <h4>Address</h4>
                            <p>Upper Banaba St. Brgy. Barretto<br/>Olongapo City, Zambales 2200</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <img src="../assets/svg/phone.svg" alt="Phone">

                        <div>
                            <h4>Phone</h4>
                            <p>+63 916 635 1911<br>+63 917 155 7523</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <img src="../assets/svg/email.svg" alt="Email">

                        <div>
                            <h4>Email</h4>
                            <p>elbarcoma@gmail.com</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <img src="../assets/svg/clock.svg" alt="Availability">

                        <div>
                            <h4>Availability</h4>
                            <p>Mon, Wed, Fri<br>8 AM - 5 PM</p>
                        </div>
                    </div>
                </div>

                <div class="contact-form-box">
                    <h2>Send Us a Message</h2>
                    <p>Got a quick question? Send us a message below!
                      <br> <br> For order-related concerns, please log in to your account and use the Custom Request form.</p>

                    <form id="contactForm" method="post" action="../auth/contact-message.php">
                        <input type="text" name="name" placeholder="Your Name" required>

                        <input type="email" name="email" placeholder="Your Email" required>

                        <input type="text" name="subject" placeholder="Subject" required>

                        <textarea name="message" rows="6" placeholder="Your Message" required></textarea>

                        <button type="submit">Send Message</button>
                    </form>
                </div>
            </div>
        </section>

        <section class="contact-map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3856.5010984589194!2d120.2723978373993!3d14.85323255591572!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x339671000668be23%3A0xaaca2feb1012df17!2sUpper%20Banaba%20St.%2C%20Barretto%2C%20Olongapo%20City!5e0!3m2!1sen!2sph!4v1761722139726!5m2!1sen!2sph" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </section>

        <section id="bulk-orders" class="contact-cta">
            <h2>Need Custom Orders or Bulk Pricing?</h2>
            <p>We'll provide quotes and tailored service for your school or office needs.</p>
            <a href="products.php" class="btn btn-primary">Browse Products</a>
            <a href="index.php" class="btn btn-outline-primary">Send a Request</a>
        </section>

        <?php include '../includes/footer.php'; ?>
        <?php include '../includes/login-modal.php'; ?>
        <script src="../assets/js/navbar.js"></script>
        <script src="../assets/js/login-modal.js"></script>
        <script src="../assets/js/contact.js"></script>
        <script src="../assets/js/homepage.js"></script>
    </body>
</html>
