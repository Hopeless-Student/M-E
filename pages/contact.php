<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" content="width=device-width, initial-scale=1.0" name="viewport"/>
        <link rel="stylesheet" href="../assets/css/contact.css"/>
        <title>M&E: Contact Us</title>
    </head>

    <body>
        <?php include '../includes/navbar.php'; ?>

        <section class="contact-hero">
            <div class="contact-hero-content">
                <h1>Contact Us</h1>
                <p>We're here to help with inquiries, feedback, or bulk order requests.</p>
            </div>
        </section>

        <section class="contact-section">
            <div class="contact-container">
                
                <div class="contact-info">
                    <h2>Contact Information</h2>
                    <p>Get in touch with us through the details below, or use the form to send a quick message.</p>

                    <div class="info-item">
                        <img src="../assets/svg/location.svg" alt="Location">

                        <div>
                            <h4>Address</h4>
                            <p>Purok 4 Banaba St Bo. Barretto, Olongapo City</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <img src="../assets/svg/phone.svg" alt="Phone">

                        <div>
                            <h4>Phone</h4>
                            <p>+63 916 635 1911</p>
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
                    <p>Have questions or requests? Fill out the form below, and we'll get back within 24-48 hours.</p>
                    
                    <form id="contactForm" method="post" action="../auth/contact_form.php">
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
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3856.5030650599197!2d120.26674307473081!3d14.853122385663681!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x339671a5c5ff84f5%3A0xea44c7bbc0cbd32c!2sBanaba%20St.!5e0!3m2!1sen!2sph!4v1761070864356!5m2!1sen!2sph" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </section>

        <section class="contact-cta">
            <h2>Need Custom Orders or Bulk Pricing?</h2>
            <p>We'll provide quotes and tailored service for your school or office needs.</p>
            <a href="products.php" class="btn btn-primary">Browse Products</a>
            <a href="request.php" class="btn btn-outline-primary">Send a Request</a>
        </section>

        <?php include '../includes/footer.php'; ?>
        <script src="../assets/js/contact.js"></script>
    </body>
</html>