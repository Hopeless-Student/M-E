<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Register User</title>
  </head>
  <body>
    <div class="form-container">
      <form id="userForm" action="auth/register_process.php" method="post">
        <div class="logo">
          <img src="assets/images/M&E_LOGO_transparent.png" alt="M&E Logo">
        </div>
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
        <button type="submit" id="verifyBtn">Verify Email</button>
        <p id="message"></p>
      </form>
    </div>
    <script src="assets/js/script.js"></script>
  </body>
</html>
