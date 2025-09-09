<?php
// // Correct the path to the cacert.pem file
// echo "Your token is expired or deleted already!";
// $currentTimeInSeconds = time();
// echo $currentTimeInSeconds. "<br>";
// date_default_timezone_set('Asia/Manila');
// echo "<span style='color:red;font-weight:bold;'>Date: </span>". date('F j, Y g:i:a  '). "<br>";
// $expires_at = date("Y-m-d h:i:s", strtotime("+30 minutes"));
// echo "{$expires_at} <br>";
// $cacert_path = "C:/xampp/php/cacert.pem";  // Update this path accordingly
// // Check OpenSSL version
// echo "OpenSSL version: " . OPENSSL_VERSION_TEXT . "\n";
//
// // Check if the cacert.pem file can be loaded
// if (file_get_contents($cacert_path)) {
//     echo "cacert.pem is being loaded correctly.\n";
// } else {
//     echo "Error loading cacert.pem.\n";
// }
// echo __DIR__;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Token Expired</title>
  <style>
    body {
      margin: 0;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background-image: linear-gradient(to bottom, #4169E1, #C6D7FF);
      font-family: Arial, sans-serif;
      color: #fff;
    }

    .card {
      background: #132c7a;
      padding: 2rem;
      border-radius: 1rem;
      box-shadow: 0 6px 20px rgba(0,0,0,0.3);
      text-align: center;
      max-width: 400px;
    }

    .card h1 {
      font-size: 1.6rem;
      margin-bottom: 1rem;
    }

    .card p {
      font-size: 1rem;
      line-height: 1.5;
      color: #dbe4ff;
    }

    .btn {
      display: inline-block;
      margin-top: 1.5rem;
      padding: 0.6rem 1.2rem;
      background: #1e40af;
      color: #fff;
      border: none;
      border-radius: 0.5rem;
      text-decoration: none;
      font-size: 0.95rem;
      transition: background 0.3s ease;
    }

    .btn:hover {
      background: #2563eb;
    }
  </style>
</head>
<body>
  <div class="card">
    <?php if (isset($_GET['status']) && $_GET['status'] === 'expired'): ?>
      <img src="assets/images/expired.png" alt="expired warning" style="width:30%; height:auto;">
    <h1>Token Expired</h1>
    <p>Your token has expired and your account has been deleted since the interval was overdue.</p>
    <a href="register.php" class="btn">Register a new account</a>
    <?php else: ?>
      <img src="assets/images/warning.png" alt="restricted warning" style="width:30%; height:auto;">
    <h1>Invalid Access</h1>
    <p>You accessed this page without a valid status.</p>
<?php endif; ?>
  </div>
</body>
</html>
