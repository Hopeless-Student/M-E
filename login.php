<?php?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <link href="bootstrap-5.3.8-dist/css/bootstrap.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
  <title>Login</title>
</head>
<body>
  <div class="form-container">
    <div class="logo">
      <img src="assets/images/M&E_LOGO_transparent.png" alt="M&E Logo">
    </div>
    <form id="loginForm" action="auth/login_handler.php" method="post">
      <h2>Log In</h2>
      <div class="form-group">
        <input type="text" id="login_id" name="login_id" placeholder="Username or Email" required>
      </div>
      <div class="form-group">
        <input type="password" id="password" name="password" placeholder="Password" required>
      </div>
      <button type="submit">Login</button>
      <div class="extra">
        <p>Don’t have an account? <a href="register.php">Create one</a></p>
      </div>
      <p id="message" style="text-align: center; margin-top: 10px;">
        <?php
          if (isset($_SESSION['error'])) {
            echo "<span style='color: red; font-size: 14px;'>".$_SESSION['error']."</span>";
            unset($_SESSION['error']);
          }
        ?>
      </p>
    </form>
  </div>
</body>
</html>
