<?php require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../auth/mainpage-auth.php'; ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" content="width=device-width, initial-scale=1.0" name="viewport"/>
        <link href="../assets/css/about.css" rel="stylesheet"/>
        <link href="../assets/css/navbar.css" rel="stylesheet"/>
        <title>M&E: About Us</title>
    </head>

    <body>
        <?php include '../includes/navbar.php'; ?>

        <section class="about-hero">
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



        <section class="mission-values">
            <h2>Our Mission & Values</h2>

            <div class="value-card">
                <div class="icon-circle">
                    <img src="../assets/svg/workspace-trusted.svg" alt="Quality Products">
                </div>
                <h3>Quality Products</h3>
                <p>We carefully curate our products from trusted manufacturers and suppliers to ensure you get the best quality.</p>
            </div>

            <div class="value-card">
                <div class="icon-circle">
                    <img src="../assets/svg/delivery.svg" alt="Fast Delivery">
                </div>
                <h3>Fast Delivery</h3>
                <p>We ensure quick processing and efficient delivery of your orders, getting your supplies to you when you need them.</p>
            </div>

            <div class="value-card">
                <div class="icon-circle">
                    <img src="../assets/svg/customer-support-1-solid.svg" alt="24/7 Support">
                </div>
                <h3>24/7 Support</h3>
                <p>Our dedicated customer service team is always ready to assist you with any questions or concerns.</p>
            </div>
        </section>



        <section class="team">
            <h2>Meet the Team</h2>

            <div class="row">
                <div class="team-member">
                    <img src="../assets/svg/person.svg" alt="Elbar Coma">
                    <h3>Elbar Coma</h3>
                    <p>Founder & Owner</p>
                    <span class="badge">E-commerce Visionary</span>
                </div>

                <div class="team-member">
                    <img src="../assets/svg/person.svg" alt="Maria Santos">
                    <h3>Maria Santos</h3>
                    <p>Sales Manager</p>
                    <span class="badge">Customer Champion</span>
                </div>

                <div class="team-member">
                    <img src="../assets/svg/person.svg" alt="Daniel Cruz">
                    <h3>Daniel Cruz</h3>
                    <p>Logistics Lead</p>
                    <span class="badge">Delivery Expert</span>
                </div>
            </div>
        </section>



        <section class="testimonials">
            <h2>What Our Customers Say</h2>
    
            <div class="feedback">
                <p>"Fast delivery and reliable service. Highly recommend!"</p>
                <span class="text-primary">- Maria, School Principal</span>
            </div>

            <div class="feedback">
                <p>"Affordable prices and great product quality. We always buy here."</p>
                <span class="text-primary">- Daniel, Office Admin</span>
            </div>

            <div class="feedback">
                <p>"Bulk ordering for our school was so easy. The support team was very helpful!"</p>
                <span class="text-primary">- Principal Reyes</span>
            </div>

            <div class="feedback">
                <p>"I love the real-time tracking and fast delivery. Will order again!"</p>
                <span class="text-primary">- Office Manager, ABC Corp</span>
            </div>
        </section>



        <section class="company-documents">
            <h2>Our Credentials</h2>
            <p>Authorized and Registered Business Entity</p>
            
            <div class="documents-grid">
                <div class="document-card">
                    <h3>Business Registration</h3>

                    <div class="document-image">
                        <img src="../assets/images/DTI.jpg" alt="DTI Business Registration">
                    </div>

                    <div class="document-info">
                        <p>Certificate of Business Name Registration</p>
                        <p>Valid until February 16, 2029</p>
                    </div>
                </div>

                <div class="document-card">
                    <h3>BIR Registration</h3>

                    <div class="document-image">
                        <img src="../assets/images/cert-of-registration-edited.jpg" alt="BIR Registration Certificate">
                    </div>

                    <div class="document-info">
                        <p>BIR Certificate of Registration</p>
                        <p>TIN: 463-960-815-00000</p>
                    </div>
                </div>

                <div class="document-card">
                    <h3>Business Permit</h3>
                    
                    <div class="document-image">
                        <img src="../assets/images/BIR-edited.jpg" alt="Business Permit">
                    </div>

                    <div class="document-info">
                        <p>Official Business Notice</p>
                        <p>M&E Interior Supplies Trading</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="about-cta">
            <h2>Ready to Order?</h2>
            <p>Visit our shop or contact us for bulk orders and inquiries.<br>We're here to help you get the supplies you need, fast.</p>

            <div class="cta-buttons">
                <a href="products.php" class="btn btn-primary">Browse Products</a>
                <a href="contact.php" class="btn btn-outline-primary">Contact Us</a>
            </div>
        </section>
        <?php include '../includes/footer.php'; ?>
        <?php include '../includes/login-modal.php'; ?>
        <script src="../assets/js/navbar.js"></script>
    </body>
</html>
