<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M & E Interior Supplies Trading - Quality Office, School & Sanitary Supplies</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            overflow-x: hidden;
        }
        /* Header */
        header {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            color: white;
            padding: 0;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
        }

        .header-top {
            background: rgba(0,0,0,0.1);
            padding: 8px 0;
            font-size: 0.9rem;
        }

        .header-top .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .contact-info {
            display: flex;
            gap: 20px;
        }

        .contact-info span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .auth-links a {
            color: white;
            text-decoration: none;
            margin-left: 15px;
            transition: color 0.3s;
        }

        .auth-links a:hover {
            color: #f39c12;
        }

        .navbar {
            padding: 15px 0;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo i {
            font-size: 2rem;
            color: #f39c12;
        }

        .nav-menu {
            display: flex;
            list-style: none;
            gap: 30px;
        }

        .nav-menu a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
            position: relative;
        }

        .nav-menu a:hover {
            color: #f39c12;
        }

        .nav-menu a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: #f39c12;
            transition: width 0.3s;
        }

        .nav-menu a:hover::after {
            width: 100%;
        }

        .search-cart {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .search-box {
            position: relative;
        }

        .search-box input {
            padding: 10px 15px;
            border: none;
            border-radius: 25px;
            width: 250px;
            outline: none;
        }

        .search-box i {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
        }

        .cart-icon {
            position: relative;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            transition: color 0.3s;
        }

        .cart-icon:hover {
            color: #f39c12;
        }

        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #e74c3c;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 180px 0 100px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .hero-content {
            position: relative;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            z-index: 2;
        }

        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 20px;
            font-weight: 700;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            animation: fadeInUp 1s ease-out;
        }

        .hero p {
            font-size: 1.3rem;
            margin-bottom: 40px;
            opacity: 0.9;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            animation: fadeInUp 1s ease-out 0.3s both;
        }

        .cta-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
            animation: fadeInUp 1s ease-out 0.6s both;
        }

        .btn {
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 30px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            background: #f39c12;
            color: white;
            box-shadow: 0 4px 15px rgba(243, 156, 18, 0.4);
        }

        .btn-primary:hover {
            background: #e67e22;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(243, 156, 18, 0.6);
        }

        .btn-secondary {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-secondary:hover {
            background: white;
            color: #667eea;
            transform: translateY(-2px);
        }

        /* Categories Section */
        .categories {
            padding: 100px 0;
            background: #f8f9fa;
        }

        .section-title {
            text-align: center;
            margin-bottom: 80px;
        }

        .section-title h2 {
            font-size: 2.8rem;
            color: #2c3e50;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .section-title p {
            font-size: 1.2rem;
            color: #666;
            max-width: 600px;
            margin: 0 auto;
        }

        .categories-grid {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 40px;
        }

        .category-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s;
            cursor: pointer;
            position: relative;
        }

        .category-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .category-icon {
            padding: 40px;
            text-align: center;
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            position: relative;
            overflow: hidden;
        }

        .category-icon::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.1);
            transform: rotate(45deg);
            transition: all 0.5s;
        }

        .category-card:hover .category-icon::before {
            right: 100%;
        }

        .category-icon i {
            font-size: 4rem;
            margin-bottom: 20px;
            position: relative;
            z-index: 2;
        }

        .category-icon h3 {
            font-size: 1.5rem;
            font-weight: 600;
            position: relative;
            z-index: 2;
        }

        .category-content {
            padding: 30px;
        }

        .category-content p {
            color: #666;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .category-features {
            list-style: none;
            margin-bottom: 25px;
        }

        .category-features li {
            padding: 8px 0;
            color: #555;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .category-features li i {
            color: #27ae60;
            width: 16px;
        }

        .category-btn {
            background: #3498db;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .category-btn:hover {
            background: #2980b9;
            transform: translateX(5px);
        }

        /* Features Section */
        .features {
            padding: 100px 0;
            background: white;
        }

        .features-grid {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
        }

        .feature-card {
            text-align: center;
            padding: 40px 20px;
            border-radius: 15px;
            transition: all 0.3s;
            border: 2px solid transparent;
        }

        .feature-card:hover {
            border-color: #3498db;
            transform: translateY(-5px);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #3498db, #2980b9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            color: white;
            font-size: 2rem;
        }

        .feature-card h3 {
            font-size: 1.4rem;
            margin-bottom: 15px;
            color: #2c3e50;
        }

        .feature-card p {
            color: #666;
            line-height: 1.6;
        }

        /* Footer */
        footer {
            background: #2c3e50;
            color: white;
            padding: 60px 0 20px;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
        }

        .footer-section h3 {
            font-size: 1.3rem;
            margin-bottom: 20px;
            color: #f39c12;
        }

        .footer-section p,
        .footer-section li {
            color: #bdc3c7;
            margin-bottom: 10px;
            line-height: 1.6;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section a {
            color: #bdc3c7;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-section a:hover {
            color: #f39c12;
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .social-links a {
            width: 40px;
            height: 40px;
            background: #34495e;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .social-links a:hover {
            background: #f39c12;
            transform: translateY(-3px);
        }

        .footer-bottom {
            border-top: 1px solid #34495e;
            margin-top: 40px;
            padding-top: 20px;
            text-align: center;
            color: #95a5a6;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .nav-menu {
                display: none;
            }

            .search-box input {
                width: 200px;
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .hero p {
                font-size: 1.1rem;
            }

            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }

            .categories-grid {
                grid-template-columns: 1fr;
            }

            .section-title h2 {
                font-size: 2.2rem;
            }
        }

        @media (max-width: 480px) {
            .header-top {
                display: none;
            }

            .hero {
                padding: 150px 0 80px;
            }

            .hero h1 {
                font-size: 2rem;
            }

            .search-box input {
                width: 150px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="header-top">
            <div class="container">
                <div class="contact-info">
                    <span><i class="fas fa-phone"></i> +63 123 456 7890</span>
                    <span><i class="fas fa-envelope"></i> info@meinteriorsupplies.com</span>
                    <span><i class="fas fa-map-marker-alt"></i> Olongapo City</span>
                </div>
                <div class="auth-links">
                    <a href="#" onclick="showLogin()"><i class="fas fa-sign-in-alt"></i> Login</a>
                    <a href="#" onclick="showRegister()"><i class="fas fa-user-plus"></i> Register</a>
                </div>
            </div>
        </div>

        <nav class="navbar">
            <div class="nav-container">
                <a href="#" class="logo">
                    <i class="fas fa-store"></i>
                    M & E Interior Supplies
                </a>

                <ul class="nav-menu">
                    <li><a href="#home">Home</a></li>
                    <li><a href="#products">Products</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#contact">Contact</a></li>
                    <li><a href="#faq">FAQ</a></li>
                </ul>

                <div class="search-cart">
                    <div class="search-box">
                        <input type="text" placeholder="Search products..." id="searchInput">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="cart-icon" onclick="showCart()">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-count">0</span>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-content">
            <h1>Quality Supplies for Every Need</h1>
            <p>Your trusted partner for office, school, and sanitary supplies in Olongapo. Professional quality, competitive prices, and reliable delivery service.</p>
            <div class="cta-buttons">
                <a href="#products" class="btn btn-primary">
                    <i class="fas fa-shopping-bag"></i>
                    Shop Now
                </a>
                <a href="#about" class="btn btn-secondary">
                    <i class="fas fa-info-circle"></i>
                    Learn More
                </a>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="categories" id="products">
        <div class="section-title">
            <h2>Our Product Categories</h2>
            <p>Discover our comprehensive range of quality supplies tailored to meet your specific needs</p>
        </div>

        <div class="categories-grid">
            <div class="category-card" onclick="viewCategory('office')">
                <div class="category-icon">
                    <i class="fas fa-briefcase"></i>
                    <h3>Office Supplies</h3>
                </div>
                <div class="category-content">
                    <p>Professional-grade office supplies to keep your workplace efficient and organized.</p>
                    <ul class="category-features">
                        <li><i class="fas fa-check"></i> Stationery & Writing Tools</li>
                        <li><i class="fas fa-check"></i> Filing & Organization</li>
                        <li><i class="fas fa-check"></i> Technology Accessories</li>
                        <li><i class="fas fa-check"></i> Desk Essentials</li>
                    </ul>
                    <a href="#" class="category-btn">
                        Browse Office Supplies
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="category-card" onclick="viewCategory('school')">
                <div class="category-icon">
                    <i class="fas fa-graduation-cap"></i>
                    <h3>School Supplies</h3>
                </div>
                <div class="category-content">
                    <p>Complete range of educational materials and supplies for students of all ages.</p>
                    <ul class="category-features">
                        <li><i class="fas fa-check"></i> Notebooks & Paper Products</li>
                        <li><i class="fas fa-check"></i> Writing & Drawing Materials</li>
                        <li><i class="fas fa-check"></i> Educational Tools</li>
                        <li><i class="fas fa-check"></i> Art & Craft Supplies</li>
                    </ul>
                    <a href="#" class="category-btn">
                        Browse School Supplies
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="category-card" onclick="viewCategory('sanitary')">
                <div class="category-icon">
                    <i class="fas fa-hands-wash"></i>
                    <h3>Sanitary Supplies</h3>
                </div>
                <div class="category-content">
                    <p>Essential cleaning and hygiene products for maintaining a safe, clean environment.</p>
                    <ul class="category-features">
                        <li><i class="fas fa-check"></i> Cleaning Solutions</li>
                        <li><i class="fas fa-check"></i> Personal Hygiene Products</li>
                        <li><i class="fas fa-check"></i> Sanitizers & Disinfectants</li>
                        <li><i class="fas fa-check"></i> Protective Equipment</li>
                    </ul>
                    <a href="#" class="category-btn">
                        Browse Sanitary Supplies
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="section-title">
            <h2>Why Choose M & E Interior Supplies?</h2>
            <p>We're committed to providing exceptional service and quality products</p>
        </div>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-truck"></i>
                </div>
                <h3>Fast Delivery</h3>
                <p>Quick and reliable delivery service within Olongapo City. Standard shipping rates of ₱70-₱100 with flexible delivery options.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <h3>Cash on Delivery</h3>
                <p>Convenient COD payment method. Pay when you receive your order - no advance payments required, ensuring your peace of mind.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Quality Guaranteed</h3>
                <p>We source only high-quality products from trusted suppliers. Your satisfaction is our priority with every purchase.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <h3>Customer Support</h3>
                <p>Dedicated customer service team ready to assist you with orders, inquiries, and custom requests. We're here to help!</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-tags"></i>
                </div>
                <h3>Competitive Prices</h3>
                <p>Best prices in the market without compromising quality. Regular promotions and bulk order discounts available.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <h3>Order Tracking</h3>
                <p>Keep track of your orders from placement to delivery. Real-time status updates to keep you informed throughout the process.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>M & E Interior Supplies Trading</h3>
                <p>Your trusted partner for quality office, school, and sanitary supplies in Olongapo City. We're committed to providing excellent products and outstanding customer service.</p>
                <div class="social-links">
                    <a href="https://www.facebook.com/youronlineshooping" target="_blank">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#products">Products</a></li>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#contact">Contact</a></li>
                    <li><a href="#faq">FAQ</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>Product Categories</h3>
                <ul>
                    <li><a href="#">Office Supplies</a></li>
                    <li><a href="#">School Supplies</a></li>
                    <li><a href="#">Sanitary Supplies</a></li>
                    <li><a href="#">Custom Orders</a></li>
                    <li><a href="#">Bulk Orders</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h3>Contact Info</h3>
                <p><i class="fas fa-map-marker-alt"></i> Olongapo City, Philippines</p>
                <p><i class="fas fa-phone"></i> +63 123 456 7890</p>
                <p><i class="fas fa-envelope"></i> info@meinteriorsupplies.com</p>
                <p><i class="fas fa-clock"></i> Mon-Fri: 8:00 AM - 6:00 PM<br>Sat: 8:00 AM - 4:00 PM</p>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2024 M & E Interior Supplies Trading. All rights reserved. | Developed by University of Caloocan City Students</p>
        </div>
    </footer>

    <script>
        // Cart functionality
        let cartCount = 0;
        const cartCountElement = document.querySelector('.cart-count');

        function updateCartCount() {
            cartCountElement.textContent = cartCount;
            cartCountElement.style.display = cartCount > 0 ? 'flex' : 'none';
        }

        function showCart() {
            alert('Cart functionality will be implemented in the full system. Current items: ' + cartCount);
        }

        function showLogin() {
            alert('Login page will redirect to the authentication system.');
        }

        function showRegister() {
            alert('Registration page will redirect to the user registration system.');
        }

        function viewCategory(category) {
            alert(`Redirecting to ${category} supplies category page...`);
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const searchTerm = this.value.trim();
                if (searchTerm) {
                    alert(`Searching for: "${searchTerm}"\nSearch results will be displayed on the products page.`);
                    this.value = '';
                }
            }
        });

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Header background change on scroll
        window.addEventListener('scroll', function() {
            const header = document.querySelector('header');
            if (window.scrollY > 100) {
                header.style.background = 'rgba(44, 62, 80, 0.95)';
                header.style.backdropFilter = 'blur(10px)';
            } else {
                header.style.background = 'linear-gradient(135deg, #2c3e50 0%, #3498db 100%)';
                header.style.backdropFilter = 'none';
            }
        });

        // Initialize cart count
        updateCartCount();

        // Add some interactive demo functionality
        document.querySelectorAll('.category-card').forEach(card => {
            card.addEventListener('mouseover', function() {
                this.style.transform = 'translateY(-10px) scale(1.02)';
            });

            card.addEventListener('mouseout', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Demo: Add items to cart (for demonstration)
        document.querySelectorAll('.category-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                cartCount++;
                updateCartCount();

                // Show a brief notification
                const notification = document.createElement('div');
                notification.textContent = 'Category viewed! (Demo)';
                notification.style.cssText = `
                    position: fixed;
                    top: 100px;
                    right: 20px;
                    background: #27ae60;
                    color: white;
                    padding: 10px 20px;
                    border-radius: 5px;
                    z-index: 10000;
                    font-weight: 500;
                    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
                    transform: translateX(300px);
                    transition: all 0.3s ease;
                `;

                document.body.appendChild(notification);

                // Animate in
                setTimeout(() => {
                    notification.style.transform = 'translateX(0)';
                }, 100);

                // Remove after 3 seconds
                setTimeout(() => {
                    notification.style.transform = 'translateX(300px)';
                    setTimeout(() => {
                        document.body.removeChild(notification);
                    }, 300);
                }, 3000);
            });
        });

        // Animate elements on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe category cards and feature cards
        document.querySelectorAll('.category-card, .feature-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            card.style.transition = 'all 0.6s ease-out';
            observer.observe(card);
        });

        // Mobile menu toggle (for responsive design)
        function toggleMobileMenu() {
            const navMenu = document.querySelector('.nav-menu');
            navMenu.style.display = navMenu.style.display === 'flex' ? 'none' : 'flex';
        }

        // Add mobile menu button for smaller screens
        if (window.innerWidth <= 768) {
            const mobileMenuBtn = document.createElement('button');
            mobileMenuBtn.innerHTML = '<i class="fas fa-bars"></i>';
            mobileMenuBtn.style.cssText = `
                background: none;
                border: none;
                color: white;
                font-size: 1.5rem;
                cursor: pointer;
                display: none;
            `;
            mobileMenuBtn.addEventListener('click', toggleMobileMenu);
            document.querySelector('.nav-container').appendChild(mobileMenuBtn);

            // Show mobile menu button on small screens
            const mediaQuery = window.matchMedia('(max-width: 768px)');
            function handleMediaQuery(e) {
                if (e.matches) {
                    mobileMenuBtn.style.display = 'block';
                    document.querySelector('.nav-menu').style.display = 'none';
                } else {
                    mobileMenuBtn.style.display = 'none';
                    document.querySelector('.nav-menu').style.display = 'flex';
                }
            }
            mediaQuery.addListener(handleMediaQuery);
            handleMediaQuery(mediaQuery);
        }

        console.log('M & E Interior Supplies Trading - Homepage loaded successfully!');
        console.log('This is a demo homepage. Full functionality will be implemented in the complete system.');
>>>>>>> 30650e3 (testing switching branch)
<?php
include('includes/footer.php');
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
    if (!isset($_SESSION["user"])) {
        echo "Browse all you want! <br>";
    } else {
      echo "Hello, {$_SESSION['user']} <br>";
      echo "<form class='logoutbtn' action='auth/logout.php' method='post'>";
      echo "<input type='submit' name='logout' value='Log out'>";
      echo "</form>";
    }
     ?>
     <button type="button" name="button" style="width: 60px; height: 20px;">Item 1</button>
     <button type="button" name="button" style="width: 60px; height: 20px;">Item 2</button>
     <button type="button" name="button" style="width: 60px; height: 20px;">Item 3</button>
  </body>
</html>
