<?php
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../auth/mainpage-auth.php';

  try {
    $featured_products = $pdo->query("SELECT product_id, product_name, price, product_image FROM products WHERE is_featured = 1")->fetchAll(PDO::FETCH_ASSOC);
    // var_dump($featured_products);
  } catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage();
  }


 ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" content="width=device-width, initial-scale=1.0" name="viewport"/>
        <link href="../assets/css/homepage.css" rel="stylesheet"/>
        <link href="../assets/css/navbar.css" rel="stylesheet"/>
        <title>M&E: Interior Supplies Trading</title>
    </head>

    <body>
        <?php include('../includes/navbar.php') ?>
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
                          <a href="products.php">
                              <img alt="right" class="right-icon" src="../assets/svg/right-icon.svg"/>
                          </a>
                      </div>
                  </div>
              </div>

              <div class="product-grid">
                  <?php foreach ($featured_products as $products): ?>
                      <div class="product-card">
                          <a class="card-link" href="#">
                              <img alt="<?= htmlspecialchars($products['product_name']); ?>" src="../assets/images/products/<?= htmlspecialchars($products['product_image']) ?>"/>

                              <div class="product-info">
                                  <h3><?= htmlspecialchars($products['product_name']); ?></h3>
                                  <p>PHP <?= number_format($products['price'], 2); ?></p>
                              </div>
                          </a>

                          <!-- <div class="cart-btn">
                              <a href="#">
                                  <img alt="cart" src="../assets/svg/bag.svg"/>
                              </a>
                          </div> -->
                          <form action="../auth/add_to_cart.php" method="post">
                            <input type="hidden" name="product_id" value="<?= $products['product_id'] ?>">
                            <button type="submit" class="cart-btn">
                              <img alt="cart" src="../assets/svg/bag.svg"/>
                            </button>
                        </form>
                      </div>
                  <?php endforeach; ?>
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

                <button id="floatingRequestBtn" class="floating-request-btn" title="Send Custom Request">
                  <img src="../assets/svg/chat-text.svg" alt="chat-text" width="24" height="24">
            <span>Request</span>
        </button>


      <div id="customRequestModal" class="modal">
          <div class="modal-content request-modal-content">
              <span class="close-btn" id="closeRequestModal">&times;</span>

              <img src="../assets/images/M&E_LOGO-semi-transparent.png" alt="M&E Logo">

              <h2>Custom Request</h2>
              <p class="request-subtitle">Send us your inquiries, complaints, or custom orders</p>


              <form id="customRequestForm" action="../auth/custom_request.php" method="post">
                  <label for="requestType">Request Type <span style="color:red;">*</span></label>
                  <select id="requestType" name="request_type" required>
                      <option value="" disabled selected>Select request type</option>
                      <option value="inquiry">Inquiry</option>
                      <option value="complaint">Complaint</option>
                      <option value="custom_order">Custom Order</option>
                      <option value="other">Others</option>
                  </select>

                  <label for="requestSubject">Subject <span style="color:red;">*</span></label>
                  <input type="text" id="requestSubject" name="subject" placeholder="Brief description of your request" required maxlength="100">

                  <label for="requestMessage">Message <span style="color:red;">*</span></label>
                  <textarea id="requestMessage" name="message" placeholder="Provide detailed information about your request..." required rows="6" maxlength="1000"></textarea>

                  <div class="char-counter">
                      <span id="charCount">0</span> / 1000 characters
                  </div>

                  <button type="submit" id="submitRequestBtn">Submit Request</button>

                  <p class="request-note">
                      <strong>Note:</strong> We typically respond within 24-48 hours during business days.
                  </p>
              </form>
          </div>
      </div>

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
                    <a href="faq.php">More about FAQs
                        <img alt="More" src="../assets/svg/right-arrow.svg"/>
                    </a>
                </div>
            </div>
        </section>



        <script src="../bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/js/homepage.js"></script>
        <script src="../assets/js/navbar.js"></script>
        <?php include '../includes/footer.php';?>
        <?php include '../includes/login-modal.php';?>
    </body>
</html>
