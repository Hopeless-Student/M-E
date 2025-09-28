<?php
// Current output is for testing
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>M&E Interior Supplies</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../test-files/homepage.css">
</head>
<body>

<!-- Navbar -->
  <nav class="navbar navbar-expand-lg bg-transparent sticky-top px-4 py-2 custom-navbar">
    <a class="navbar-brand" href="#"> <img src="../assets/images/M&E_LOGO_transparent.png" class="img-fluid" alt="M&E Logo"> </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

      <div class="collapse navbar-collapse align-items-center" id="navbarNav">
    <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
      <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
      <li class="nav-item"><a class="nav-link" href="order_form.php">Products</a></li>
      <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
    </ul>

    <!-- Cart & Login -->
      <div class="d-flex flex-column flex-lg-row align-items-center mt-3 mt-lg-0">
        <a href="#" class="cart-icon mb-2 mb-lg-0 me-lg-3">
          <img src="../assets/icons/bag.svg" alt="Cart" class="img-fluid">
        </a>
        <button class="btn btn-primary d-flex align-items-center login-btn"
                data-bs-toggle="modal" data-bs-target="#loginModal">
          <img src="../assets/icons/person.svg" alt="Login" class="me-2 login-icon">
          Login
        </button>
      </div>
  </div>
  </nav>

<!-- Hero Section -->
<section class="hero">
  <h1>Office, School & Sanitary Supplies</h1>
  <p>Reliable, fast, and hassle-free ordering delivered straight to your door.</p>
  <a href="#products" class="btn btn-light px-4 py-2">Shop Now</a>
</section>

<!-- Top Ordered Products -->
<section class="py-5 text-center" id="products">
  <div class="container">
    <h2 class="mb-5">Top Products</h2>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card">
          <img src="../assets/images/default.png" class="card-img-top" alt="Product">
          <div class="card-body">
            <h5 class="card-title">Kiko Barzaga</h5>
            <p class="card-text">₱100.00</p>
            <a href="#" class="btn btn-primary w-100">Buy Now</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <img src="../assets/images/warning.png" class="card-img-top" alt="Product">
          <div class="card-body">
            <h5 class="card-title">Bawal Bastos</h5>
            <p class="card-text">₱120.00</p>
            <a href="#" class="btn btn-primary w-100">Buy Now</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <img src="../assets/images/Hard-Copy.jpg" class="card-img-top" alt="Product">
          <div class="card-body">
            <h5 class="card-title">Product Name</h5>
            <p class="card-text">₱150.00</p>
            <a href="#" class="btn btn-primary w-100">Buy Now</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Categories -->
<section class="py-5 bg-light text-center">
  <div class="container">
    <h2 class="mb-5">Shop by Category</h2>
    <div class="row g-4">
      <div class="col-md-4">
        <a href="#" class="text-decoration-none text-dark">
          <div class="card category-card">
            <img src="../ui/Assets/school-supplies.png" alt="School Supplies" class="category-img">
            <div class="card-body">
              <h5 class="card-title">School Supplies</h5>
            </div>
          </div>
        </a>
      </div>
      <div class="col-md-4">
        <a href="#" class="text-decoration-none text-dark">
          <div class="card category-card">
            <img src="../ui/Assets/office-supplies.png" alt="Office Supplies" class="category-img">
            <div class="card-body">
              <h5 class="card-title">Office Supplies</h5>
            </div>
          </div>
        </a>
      </div>
      <div class="col-md-4">
        <a href="#" class="text-decoration-none text-dark">
          <div class="card category-card">
            <img src="../ui/Assets/sanitary-supplies.png" alt="Sanitary Supplies" class="category-img">
            <div class="card-body">
              <h5 class="card-title">Sanitary Supplies</h5>
            </div>
          </div>
        </a>
      </div>
    </div>
  </div>
</section>

<!-- About Us -->
<section class="py-5 text-center">
  <div class="container">
    <h2 class="mb-4">About Us</h2>
    <p>We provide quality school, office, and sanitary essentials with reliable service and great value. Perfect for students, teachers, and offices.</p>
    <a href="#about" class="btn btn-primary mt-3">Read More</a>
  </div>
</section>

<!-- FAQ -->
<section class="py-5 bg-light">
  <div class="container">
    <h2 class="text-center mb-4">FAQs</h2>
    <div class="accordion" id="faqAccordion">
      <div class="accordion-item">
        <h2 class="accordion-header" id="faq1">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#answer1">
            Do you accept bulk orders?
          </button>
        </h2>
        <div id="answer1" class="accordion-collapse collapse show">
          <div class="accordion-body">Yes, we accept bulk orders for schools, offices, and organizations.</div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header" id="faq2">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#answer2">
            What are the delivery options?
          </button>
        </h2>
        <div id="answer2" class="accordion-collapse collapse">
          <div class="accordion-body">We offer same-day delivery within Olongapo City.</div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header" id="faq3">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#answer3">
            Returns & refunds?
          </button>
        </h2>
        <div id="answer3" class="accordion-collapse collapse">
          <div class="accordion-body">Please contact us for our return and refund policy details.</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="footer text-center">
  <div class="container">
    <h5 class="mb-2">M&E Interior Supplies</h5>
    <p class="mb-3 small">© 2025 All Rights Reserved</p>
    <div class="row mt-3">
      <div class="col-md-3"><a href="#">School</a></div>
      <div class="col-md-3"><a href="#">Office</a></div>
      <div class="col-md-3"><a href="#">Sanitary</a></div>
      <div class="col-md-3"><a href="#contact">Contact</a></div>
    </div>
  </div>
</footer>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4">
      <form id="loginForm" action="../auth/login_handler.php" method="post">
        <div class="modal-header border-0 pb-0 d-flex flex-column align-items-center">
          <div class="logo text-center">
            <img src="../assets/images/M&E_LOGO_transparent.png" alt="M&E Logo" style="width:40%; height:auto;">
          </div>
          <h5 class="modal-title fs-3 fw-bold text-center" id="loginModalLabel">Log In</h5>
          <button type="button" class="btn-close position-absolute" style="top: 10px; right: 10px;" data-bs-dismiss="modal"aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="form-group mb-3">
            <input type="text" id="login_id" name="login_id" placeholder="Username or Email" class="form-control" required>
          </div>
          <div class="form-group mb-3">
            <input type="password" id="password" name="password" placeholder="Password" class="form-control" required>
          </div>
          <!-- <div class="input-group">
            <input type="password" id="password" name="password" placeholder="Password" class="form-control" required>
            <button type="button" class="btn btn-outline-secondary" id="togglePassword"><i class="bi bi-eye"></i></button>
        </div> -->

          <p id="message">
            <?php
              if (isset($_SESSION['error'])) {
                echo "<span style='color: red; font-size: 14px;'>".$_SESSION['error']."</span>";
                unset($_SESSION['error']);
              }
            ?>
          </p>
          <button type="submit" class="btn btn-primary w-100">Login</button>
          <div class="extra mb-3 text-center">
            <p>Don’t have an account? <a href="../register.php">Create one</a></p>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
  <!-- <script>
      document.getElementById('togglePassword').addEventListener('click', function() {
      const passwordField = document.getElementById('password');
      const type = passwordField.type === 'password' ? 'text' : 'password';
      passwordField.type = type;
      this.querySelector('i').classList.toggle('bi-eye-slash');
  });
  </script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
