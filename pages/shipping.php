<?php require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../auth/mainpage-auth.php'; ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" content="width=device-width, initial-scale=1.0" name="viewport"/>
      <link rel="icon" type="image/x-icon" href="../assets/images/M&E_LOGO-semi-transparent.ico">        
    <link rel="stylesheet" href="../assets/css/contact.css"/>
    <link rel="stylesheet" href="../assets/css/navbar.css"/>
    <link rel="stylesheet" href="../assets/css/shipping.css"/>
        <title>M&E: Shipping & Delivery</title>
    </head>

    <body>
        <?php include '../includes/navbar.php'; ?>

        <section class="shipping-hero">
            <div class="shipping-hero-content">
                <h1>Shipping & Delivery</h1>
                <p>Information about our shipping options, delivery times, and rates.</p>
            </div>
        </section>

        <section class="shipping-container">
            <div class="shipping-content">
                <h2>Delivery Areas</h2>
                <p>We provide fast and reliable delivery services across:</p>
                <ul>
                    <li><strong>Primary Area:</strong> Olongapo City (Same-day delivery available)</li>
                    <li><strong>Extended Areas:</strong> Surrounding areas of Zambales (1-2 business days)</li>
                </ul>

                <h3>Shipping Rates</h3>
                <p>Our competitive shipping rates are structured as follows:</p>
                <ul>
                    <li>Standard Delivery (Olongapo City): ₱70-75</li>
                    <li>Extended Area Delivery: ₱100</li>
                    <li>Free Shipping: Available for qualifying orders (minimum purchase may apply)</li>
                </ul>

                <h3>Delivery Options</h3>
                <p>Choose from our flexible delivery services:</p>
                <ul>
                    <li><strong>Same-day Delivery:</strong> Available within Olongapo City for orders placed before 2 PM</li>
                    <li><strong>Standard Delivery:</strong> 1-2 business days</li>
                    <li><strong>Store Pickup:</strong> Available at our Olongapo City location</li>
                </ul>

                <h3>Bulk Orders</h3>
                <p>We welcome bulk orders from schools, offices, and organizations:</p>
                <ul>
                    <li>Special shipping rates for bulk orders</li>
                    <li>Dedicated support for large deliveries</li>
                    <li>Flexible delivery scheduling for bulk shipments</li>
                </ul>

                <h3>Payment & Order Processing</h3>
                <ul>
                    <li><strong>Payment Methods:</strong> Cash on Delivery (COD), Bank Transfer, GCash</li>
                    <li><strong>Processing Time:</strong> Orders are processed within 24 hours</li>
                    <li><strong>Order Tracking:</strong> Track your delivery through email updates and your account dashboard</li>
                </ul>

                <h3>Special Instructions</h3>
                <p>During checkout, you can provide:</p>
                <ul>
                    <li>Specific delivery time preferences</li>
                    <li>Alternative contact numbers</li>
                    <li>Detailed delivery instructions or landmarks</li>
                </ul>
            </div>
        </section>

        <?php include '../includes/login-modal.php';?>
        <?php include '../includes/footer.php'; ?>
        <script src="../assets/js/navbar.js"></script>
        <script src="../assets/js/homepage.js"></script>
    </body>
</html>
