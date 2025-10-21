<style media="screen">
footer {
    background-color: #002366;
    color: #fff;
    padding: 60px 100px 30px 100px;
    font-family: 'Inter', sans-serif;
}

.footer-container {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    max-width: 1200px;
    gap: 50px;
}

.footer-brand {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    max-width: 300px;
}

.footer-brand .brand-top {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 15px;
}

.footer-logo {
    height: 100px;
}

.footer-brand h3 {
    font-size: 30px;
    font-weight: bold;
    color: #C6D7FF;
    letter-spacing: 5px;
}

.footer-links {
    display: flex;
    justify-content: space-between;
    gap: 100px;
    flex-wrap: wrap;
    text-align: left;
}

.footer-column h4 {
    font-weight: bold;
    font-size: 22px;
    color: #fff;
    margin-bottom: 30px;
}

.footer-column ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-column ul li {
    margin-bottom: 20px;
}

.footer-column ul li a {
    font-weight: normal;
    font-size: 18px;
    color: #A6BAFF;
    text-decoration: none;
}

.footer-column ul li a:hover {
    text-decoration: underline;
}

.footer-divider {
    border: none;
    border-top: 2px solid #4169E1;
    margin: 30px 0;
}

.footer-socials {
    text-align: center;
    margin-bottom: 30px;
}

.footer-socials h4 {
    font-weight: bold;
    font-size: 24px;
    margin-bottom: 8px;
}

.footer-socials p {
    color: #A6BAFF;
    font-size: 16px;
    margin-bottom: 20px;
}

.footer-socials .fb-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background-color: #0866FF;
    color: #fff;
    padding: 10px 20px;
    border-radius: 6px;
    font-weight: bold;
    text-decoration: none;
}

.footer-socials .fb-btn:hover {
    text-decoration: underline;
}

.footer-socials .fb-btn img {
    height: 30px;
    width: 30px;
}

.footer-copy p {
    margin-top: 60px;
    font-size: 14px;
    color: #A6BAFF;
    text-align: center;
}

@media (max-width: 768px) {
    footer {
        padding: 20px 20px;
        text-align: center;
    }
    .footer-container {
        flex-direction: column;
        text-align: left;
        gap: 30px;
    }
    .footer-brand .brand-top {
        gap: 20px;
        margin-bottom: 15px;
    }
    .brand-top h3 {
        white-space: nowrap;
        direction: ltr;
    }
    .footer-links {
        margin: 0 60px;
        flex-direction: row;
        gap: 80px;
        align-content: center;
        text-align: left;
    }
    .footer-column h4 {
        font-size: 17px;
    }
    .footer-column ul li a {
        font-size: 15px;
    }
    .footer-copy p {
        margin-top: 60px;
    }
}
</style>

<footer>
    <div class="footer-container">
        <div class="footer-brand">
            <div class="brand-top">
                <img alt="M&E Logo" class="footer-logo" src="../assets/images/M&E_LOGO-semi-transparent.png"/>
                <h3>Interior Supplies Trading</h3>
            </div>
        </div>

        <div class="footer-links">
            <div class="footer-column">
                <h4>Navigation</h4>
                <ul>
                    <li><a href="../pages/products.php">School</a></li>
                    <li><a href="../pages/products.php">Office</a></li>
                    <li><a href="../pages/products.php">Sanitary</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h4>Customer Support</h4>
                <ul>
                    <li><a href="../pages/index.php">FAQs</a></li>
                    <li><a href="../pages/index.php">Shipping</a></li>
                    <li><a href="../pages/contact.php">Contact Us</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h4>Company Info</h4>
                <ul>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="#">Our Store</a></li>
                    <li><a href="../pages/products.php">Bulk Orders</a></li>
                    <li><a href="../pages/terms-of-service.php">Return & Refund Policy</a></li>
                </ul>
            </div>
        </div>
    </div>

    <hr class="footer-divider"/>

    <div class="footer-socials">
        <h4>Stay Connected</h4>
        <p>Follow us for the latest deals & updates!</p>

        <a class="fb-btn" href="https://www.facebook.com/youronlineshooping" target="_blank">
            <img alt="Facebook Link" src="../assets/images/Facebook_Logo_2023.png"/>
            <span>Follow us on Facebook</span>
        </a>
    </div>

    <div class="footer-copy">
        <p>© Copyright <?php echo date("Y"); ?> M&E Interior Supplies Trading, All rights reserved.</p>
    </div>
</footer>
<?php