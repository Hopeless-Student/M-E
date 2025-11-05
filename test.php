<?php
$status = isset($_GET['status']) ? $_GET['status'] : 'invalid';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Email Verification Status</title>
  <link rel="icon" href="../assets/images/M&E_LOGO_transparent.png">
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #e3f2fd, #ffffff);
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    .container {
      background: white;
      padding: 40px 30px;
      border-radius: 16px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
      max-width: 420px;
      width: 90%;
      text-align: center;
      transition: all 0.3s ease;
    }

    .logo {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      margin-bottom: 20px;
    }

    .logo img {
      width: 50px;
      height: 50px;
      object-fit: contain;
    }

    .logo h1 {
      font-size: 20px;
      color: #0d47a1;
      font-weight: 600;
      margin: 0;
    }

    .status-icon {
      font-size: 60px;
      margin-bottom: 15px;
    }

    .expired {
      color: #e53935;
    }

    .invalid {
      color: #f57c00;
    }

    h2 {
      color: #111827;
      margin: 10px 0;
    }

    p {
      color: #555;
      font-size: 15px;
      margin-bottom: 20px;
    }

    a.button {
      display: inline-block;
      text-decoration: none;
      background-color: #0d47a1;
      color: white;
      padding: 10px 20px;
      border-radius: 6px;
      font-weight: 600;
      transition: background 0.3s;
    }

    a.button:hover {
      background-color: #1565c0;
    }

    @media (max-width: 480px) {
      .container {
        padding: 30px 20px;
      }

      .logo h1 {
        font-size: 18px;
      }

      h2 {
        font-size: 18px;
      }
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="logo">
      <img src="assets/images/M&E_LOGO_transparent.png" alt="M&E Logo">
      <h1>M&E Interior Supplies</h1>
    </div>

    <?php if ($status === 'expired'): ?>
      <div class="status-icon expired">⏰</div>
      <h2>Verification Link Expired</h2>
      <p>Your verification link has expired. Please register your account.</p>
      <a href=" pages/index.php" class="button">Register</a>

    <?php else: ?>
      <div class="status-icon invalid">⚠️</div>
      <h2>Invalid or Unauthorized Access</h2>
      <p>The verification link is invalid or already used. Please check your email or log in again.</p>
    <?php endif; ?>
  </div>

</body>
</html>
