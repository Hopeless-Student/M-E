<?php
   ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>About us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../test-files/homepage.css">
  </head>
  <body>
    <nav class="navbar navbar-expand-lg bg-transparent sticky-top px-4 py-2 custom-navbar">
      <a class="navbar-brand" href="#"> <img src="../assets/images/M&E_LOGO_transparent.png" class="img-fluid" alt="M&E Logo"> </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

        <div class="collapse navbar-collapse align-items-center" id="navbarNav">
      <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="order_form.php">Products</a></li>
        <li class="nav-item"><a class="nav-link active" href="about.php">About</a></li>
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
</html>
