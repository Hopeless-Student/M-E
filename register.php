<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="assets/style.css">
    <title>Register User</title>
  </head>
  <body>
    <div class="form-container">
      <form id="userForm" action="auth/register_process.php" method="post">
        <h2>User Info</h2>
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
    <script src="assets/script.js"></script>
  </body>
</html>
