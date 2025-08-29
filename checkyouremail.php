<?php
  session_start();
  include('includes/database.php');

  if(isset($_SESSION['email'])){
    $email = $_SESSION['email'];
  } else {
    echo "hehe";
    header("Location: register.php");
    exit;
  }
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Your Email</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <div class="check-email-container">
      <div class="logo">
        <img src="assets/images/check mark.jpg" alt="checkmark">
      </div>
      <form class="" action="auth/logout.php" method="post">
        <h1>Check Your Email</h1>
        <p>To verify your identity, a confirmation email has been sent to <?php echo $email; ?>. Please check your inbox.</p>
        <button id="resendBtn" class="resendBtn" type="submit">Resend Email</button>
        <p id="timer" class="timer">You can send in: 60 seconds</p>
      </form>
    </div>
<!--<script src="assets/js/resend.js"></script>-->
</body>
</html>
