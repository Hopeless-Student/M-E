<?php
  session_start();
  require_once __DIR__ . '/includes/database.php';

  if(isset($_SESSION['email'])){
    $email = $_SESSION['email'];
  } else {
    header("Location: pages/index.php");
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
    <style media="screen">
    body {
  margin: 0;
  padding: 0;
  font-family: 'Segoe UI', Tahoma, sans-serif;
  background-color: #f4f6f8;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
}

.check-email-container {
  background: #ffffff;
  border-radius: 12px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.1);
  max-width: 450px;
  width: 90%;
  padding: 30px 25px;
  text-align: center;
  box-sizing: border-box;
}

.check-email-container .logo img {
  width: 80px;
  height: auto;
  margin-bottom: 20px;
}

.form-check h1 {
  font-size: 24px;
  color: #0d47a1;
  margin-bottom: 15px;
}

.form-check p {
  font-size: 15px;
  color: #333;
  line-height: 1.5;
  margin-bottom: 20px;
}

.resendBtn {
  background-color: #0d47a1;
  color: #fff;
  border: none;
  padding: 12px 25px;
  border-radius: 6px;
  font-size: 16px;
  font-weight: bold;
  cursor: pointer;
  transition: background 0.3s ease;
}

.resendBtn:disabled {
  background-color: #9bb0d3;
  cursor: not-allowed;
}

.resendBtn:hover:not(:disabled) {
  background-color: #09418c;
}

.timer {
  font-size: 14px;
  color: #6b7280;
  margin-top: 15px;
}

/* Success / Error messages */
.success {
  color: #16a34a;
  font-size: 14px;
  margin-top: 10px;
}

.error {
  color: #dc2626;
  font-size: 14px;
  margin-top: 10px;
}

/* Responsive design */
@media (max-width: 480px) {
  .check-email-container {
      padding: 25px 20px;
  }

  .form-check h1 {
      font-size: 20px;
  }

  .form-check p {
      font-size: 14px;
  }

  .resendBtn {
      font-size: 14px;
      padding: 10px 20px;
  }

  .check-email-container .logo img {
      width: 60px;
  }
}

@media (min-width: 768px) {
  .check-email-container {
      max-width: 500px;
      padding: 35px 30px;
  }

  .form-check h1 {
      font-size: 26px;
  }

  .resendBtn {
      font-size: 16px;
      padding: 12px 25px;
  }
}

@media (min-width: 1024px) {
  .check-email-container {
      max-width: 550px;
  }

  .form-check h1 {
      font-size: 28px;
  }
}
    </style>
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
