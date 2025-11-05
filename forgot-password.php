<?php
session_start();
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Forgot Password</title>
  <link href="bootstrap-5.3.8-dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="icon" type="image/x-icon" href="assets/images/M&E_LOGO-semi-transparent.ico">
  <link rel="stylesheet" href="assets/css/forgot-pass.css">
</head>
<body>

  <div class="forgot-container">
    <div class="image-section"></div>

    <div class="form-section">
      <div class="form-box">
        <img src="assets/images/M&E_LOGO_transparent.png" alt="M&E Logo" class="img-fluid">

        <h4>Forgot Your Password?</h4>
        <p class="text-muted mb-4">
          No worries! Enter your email below, and we’ll send you a link to reset your password.
        </p>

        <form action="auth/forgot-password.php" method="POST" novalidate>
          <div class="mb-3 text-start">
            <label for="email" class="form-label fw-semibold">Email address</label>
            <input type="email" name="email" id="email" class="form-control" placeholder="your@email.com" required>
          </div>
          <button type="submit" class="btn btn-primary w-100 py-2">
            Send Reset Link <i class="bi bi-arrow-right ms-1"></i>
          </button>
        </form>
        <?php if (isset($_SESSION['error'])): ?>
          <p class="error-message" style="color:red; margin-top:10px; font-size:0.9rem; text-align:center">
            <?php
              echo $_SESSION['error'];
              unset($_SESSION['error']);
            ?>
          </p>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
          <p class="success-message" style="color:green; margin-top:10px; font-size:0.9rem; text-align:center">
            <?php
              echo $_SESSION['success'];
              unset($_SESSION['success']);
            ?>
          </p>
        <?php endif; ?>
        <p class="text-muted mt-4">
          Remember your password? <a href="pages/index.php">Back to Login</a>
        </p>
      </div>
    </div>
  </div>

</body>
</html>
