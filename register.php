<?php session_start();

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
    rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
    crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Register User</title>
  </head>
  <body>
    <div class="form-container">
      <div class="logo">
        <img src="assets/images/M&E_LOGO_transparent.png" alt="M&E Logo">
      </div>
      <form id="userForm" action="auth/register_process.php" method="post">
        <h2>Create your account</h2>
        <div class="form-group">
          <input type="text" id="firstName" name="firstName" placeholder="First Name" required>
        </div>
        <div class="form-group">
          <input type="text" id="lastName" name="lastName" placeholder="Last Name" required>
        </div>
        <div class="form-group">
          <input type="email" id="email" name="email" placeholder="Email" required>
        </div>
        <div class="form-group">
          <input type="password" id="password" name="password" placeholder="Password" required>
          <div class="invalid-feedback"><small>Passwords do not match.</small></div>
        </div>
        <div class="form-group">
          <input type="password" id="confirm" name="confirm-password" placeholder="Confirm Password" required>
          <div class="invalid-feedback"><small>Passwords do not match.</small></div>
        </div>
        <button type="submit" id="verifyBtn">Verify Email</button>
        <div class="extra">
          <p>Already have an account? <a href="login.php">Log in</a></p>
        </div>
        <p id="message" style="text-align: center; margin-top: 10px;">
          <?php
            if (isset($_SESSION['error'])) {
              echo "<span style='color: red; font-size: 14px;'>".$_SESSION['error']."</span>";
              unset($_SESSION['error']);
            }
          ?>
       </p>
       <!-- <div id="passwordError"
       class="alert alert-danger mt-3 d-none"
       role="alert">
       Passwords do not match!
     </div> -->
      </form>
    </div>
    <script src="assets/js/script.js"></script>
  </body>
</html>
