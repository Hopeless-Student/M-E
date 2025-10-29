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
                    It was pandemic when the owner, Mr. Coma started to venture from different kinds of business.
                    He used to be an OFW in Dubai wayback 2019 - 2020 then pandemic happened,
                    he experiences company retrenchment and need to go back in the Philippines.
                    Together with his wife they start to sell online – healthy juices, pastries and beddings.
                    Just like any other small venture business, due to lack of manpower to produce customers need
                    they must stop the online business.
                </p>

                <ul class="timeline">
                    <li>
                        <span class="timeline-year">2023</span>
                        <p>Mr. Coma returned to his hometown Olongapo City Zambales for good.
                            Settling down with His wife and son, having work from home job under US account/night shift/weekend shift.
                            During weekdays he has nothing to do with his time while his wife work in Subic bay Freeport Zone.
                            This set up makes him think again about building new business.
                        </p>
                    </li>
                    <li>
                        <span class="timeline-year">2024</span>
                        <p>Since his previous business fail due to manpower & production – he tries trading business.
                            Trading is buying and selling different commodities, but he focusses on selling office supplies.
                            Their target market is the offices and companies inside Subic Bay Freeport Zone.
                            He also sells supplies to the different retail shops in Olongapo. In trading industry,
                            having a good relationship with your suppliers and customers is necessary.
                            This helps your business a good network.
                        </p>
                    </li>
                </ul>

                <p>
                    Now, Mr. Coma is no longer connected to His corporate job – instead he focus on building and expanding his business.
                    Truly that business is a trial and error process, just learn how to risk.
                </p>
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
                    <p>Owner</p>
                </div>

                <div class="team-member">
                    <img src="../assets/svg/person.svg" alt="Melody Coma">
                    <h3>Melody Coma</h3>
                    <p>Admin / Finance</p>
                </div>

                <div class="team-member">
                    <img src="../assets/svg/person.svg" alt="Omar">
                    <h3>Omar</h3>
                    <p>Deliveryman / Driver</p>
                </div>

                <div class="team-member">
                    <img src="../assets/svg/person.svg" alt="Rose">
                    <h3>Rose</h3>
                    <p>Book Keeper</p>
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
