<?php
  session_start();
  require_once __DIR__ . '/includes/database.php';

  if(isset($_SESSION['email'])){
    $email = $_SESSION['email'];
  } else {
    echo "hehe";
    header("Location: register.php");
    exit;
  }

    $cooldown = 60;
    $remaining = 0;

    if (isset($_SESSION['last_sent_at'])) {
        $elapsed = time() - $_SESSION['last_sent_at'];
        if ($elapsed < $cooldown) {
            $remaining = $cooldown - $elapsed;
        }
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
      <form class="form-check" action="auth/resend-verification.php" method="post">
        <h1>Check Your Email</h1>
        <p id="confirmEmail">To verify your identity, a confirmation email has been sent to <b style="color: black;"><?php echo $email; ?></b>. Please check your inbox.</p>
        <button id="resendBtn" class="resendBtn" type="submit">Resend Email</button>
        <p id="timer" class="timer">You can resend now!</p>
        <?php
        //$countdownStart = false;
        if (isset($_SESSION['success'])) {
            echo "<p class='success'>" . $_SESSION['success'] . "</p>";
            //$countdownStart = true;
            unset($_SESSION['success']);
          }
          if (isset($_SESSION['error'])) {
            echo "<p class='error'>" . $_SESSION['error'] . "</p>";
            unset($_SESSION['error']);
          }

         ?>
      </form>
    </div>
<!-- <script src="assets/js/resend.js">
</script> -->
<script>
let remainingTime = <?php echo $remaining; ?>;
const timerText = document.getElementById('timer');
const resendBtn = document.getElementById('resendBtn');

  if (remainingTime > 0) {
  timerText.style.display = 'block';
  resendBtn.disabled = true;

  let countdown = setInterval(() => {
      if (remainingTime <= 0) {
          clearInterval(countdown);
          resendBtn.disabled = false;
          timerText.style.display = 'none';
      } else {
          timerText.textContent = "You can resend in: " + remainingTime + " seconds";
          remainingTime--;
      }
  }, 1000);
}
</script>

</body>
</html>
