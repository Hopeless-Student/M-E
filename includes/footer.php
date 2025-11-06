<style media="screen">
footer {
    background-color: #002366;
    color: #fff;
    padding: 60px 100px 30px;
    font-family: 'Inter', sans-serif;
}

.footer-container {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    max-width: 1200px;
    gap: 50px;
    margin: 0 auto;
}

.footer-brand {
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: 300px;
}

.footer-brand .brand-top {
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 20px;
    margin-bottom: 15px;
    width: 100%;
    text-align: center;
}

.footer-logo {
    height: 100px;
}

.footer-brand h3 {
    white-space: normal;
    text-align: left;
    max-width: 150px;
    font-size: 24px;
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
    font-size: 18px;
    color: #fff;
    margin-bottom: 20px;
}

.footer-column ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-column ul li {
    margin-bottom: 10px;
}

.footer-column ul li a {
    font-weight: normal;
    font-size: 16px;
    color: #A6BAFF;
    text-decoration: none;
}

.footer-column ul li a:hover {
    text-decoration: underline;
}

.footer-divider {
    border: none;
    border-top: 1px solid #4169E1;
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



@media (min-width: 769px) {
    .footer-brand h3 {
        max-width: 200px;
        word-wrap: break-word;
        line-height: 1.4;
    }
}

@media (max-width: 768px) and (min-width: 481px) {
    footer {
        padding: 20px 20px;
        text-align: center;
    }
    .footer-container {
        flex-direction: column;
        text-align: left;
        gap: 30px;
    }
    .footer-brand {
        align-items: flex-start;
    }
    .footer-brand .brand-top {
        flex-direction: row !important;
        align-items: center;
        justify-content: flex-start;
        width: auto;
        min-width: 280px;
    }
    .footer-brand h3 {
        text-align: left;
        max-width: none;
    }
    .footer-brand .brand-top h3 {
        font-size: 20px;
        text-align: left;
        letter-spacing: 3px;
    }
    .footer-links {
        margin: 0 30px;
        flex-direction: row;
        gap: 20px;
        align-content: center;
        text-align: left;
    }
    .footer-column h4 {
        font-size: 17px;
    }
    .footer-column ul li {
        margin-bottom: 5px;
    }
    .footer-column ul li a {
        font-size: 14px;
    }
    .footer-socials {
        text-align: center;
        margin-bottom: 30px;
    }
    .footer-socials h4 {
        font-weight: bold;
        font-size: 18px;
        margin-bottom: 8px;
    }
    .footer-socials p {
        color: #A6BAFF;
        font-size: 14px;
        margin-bottom: 20px;
    }
    .footer-socials .fb-btn {
        gap: 10px;
        padding: 7px 15px;
    }
    .footer-socials .fb-btn:hover {
        text-decoration: underline;
    }
    .footer-socials .fb-btn img {
        height: 30px;
        width: 30px;
    }
    .footer-socials .fb-btn span {
        font-size: 12px;
    }
    .footer-copy p {
        margin-top: 60px;
        font-size: 10px;
    }
}

@media (max-width: 480px) {
    .footer-logo {
        height: 80px;
    }
    .footer-brand {
        min-width: auto;
        width: 100%;
        align-items: center;
    }
    .footer-brand .brand-top {
        flex-direction: column !important;
        align-items: center;
        gap: 12px;
        width: 100%;
        justify-content: center;
    }
    .footer-brand .brand-top h3 {
        font-size: 18px;
        letter-spacing: 2px;
        text-align: center;
        margin: 0;
    }
    .footer-links {
        gap: 30px;
    }
    .footer-column h4 {
        font-size: 14px;
        margin-bottom: 15px;
    }
    .footer-column ul li a {
        font-weight: normal;
        font-size: 12px;
        color: #A6BAFF;
        text-decoration: none;
    }
    .footer-socials {
        text-align: center;
        margin-bottom: 30px;
    }
    .footer-socials h4 {
        font-weight: bold;
        font-size: 18px;
        margin-bottom: 8px;
    }
    .footer-socials p {
        color: #A6BAFF;
        font-size: 14px;
        margin-bottom: 20px;
    }
    .footer-socials .fb-btn {
        gap: 10px;
        padding: 7px 15px;
    }
    .footer-socials .fb-btn:hover {
        text-decoration: underline;
    }
    .footer-socials .fb-btn img {
        height: 30px;
        width: 30px;
    }
    .footer-socials .fb-btn span {
        font-size: 12px;
    }
    .footer-copy p {
        margin-top: 60px;
        font-size: 10px;
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
                    <li><a href="../pages/faq.php">FAQs</a></li>
                    <li><a href="../pages/shipping.php">Shipping</a></li>
                    <li><a href="../pages/contact.php">Contact Us</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h4>Company Info</h4>
                <ul>
                    <li><a href="../pages/about.php">About Us</a></li>
                    <li><a href="../pages/contact.php#location">Our Store</a></li>
                    <li><a href="../pages/contact.php#bulk-orders">Bulk Orders</a></li>
                    <li><a href="../pages/terms-of-service.php" target="_blank">Return & Refund Policy</a></li>
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
