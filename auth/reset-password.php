<?php
session_start();
require_once __DIR__ . '/../includes/database.php';

$pdo = connect();

if (!isset($_GET['token']) || empty($_GET['token'])) {
    $_SESSION['error'] = "Invalid password reset link.";
    header("Location: ../pages/index.php");
    exit;
}

$token = $_GET['token'];

$stmt = $pdo->prepare("SELECT * FROM users WHERE reset_token = ? AND forgot_token_expires >= NOW() LIMIT 1");
$stmt->execute([$token]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    $_SESSION['error'] = "Reset link is invalid or expired. Please request a new one.";
    header("Location: ../forgot-password.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if (empty($password) || empty($confirm)) {
        $_SESSION['error'] = "Both fields are required.";
    } elseif ($password !== $confirm) {
        $_SESSION['error'] = "Passwords do not match.";
    } else {

        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $update = $pdo->prepare("UPDATE users SET password = ?, reset_token = NULL, forgot_token_expires = NULL WHERE email = ?");
        $update->execute([$hashed, $user['email']]);

        $_SESSION['success'] = "Password successfully updated. You can now log in.";
        header("Location: ../pages/index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reset Password</title>
  <link href="../bootstrap-5.3.8-dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="icon" type="image/x-icon" href="../assets/images/M&E_LOGO-semi-transparent.ico">
  <style>
    body {
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(135deg, #e0f0ff, #f1f3f5);
      margin: 0;
    }

    .reset-card {
      background: white;
      padding: 2.5rem;
      border-radius: 16px;
      box-shadow: 0 12px 30px rgba(0,0,0,0.12);
      max-width: 420px;
      width: 100%;
      position: relative;
      overflow: hidden;
    }


    .reset-card::before, .reset-card::after {
      content: '';
      position: absolute;
      border-radius: 50%;
      z-index: 0;
    }
    .reset-card::before {
      width: 150px;
      height: 150px;
      background: rgba(13, 71, 161, 0.08);
      top: -50px;
      right: -50px;
    }
    .reset-card::after {
      width: 100px;
      height: 100px;
      background: rgba(25, 118, 210, 0.08);
      bottom: -30px;
      left: -30px;
    }

    h4 {
      color: #0d47a1;
      font-weight: 700;
      margin-bottom: 1rem;
      text-align: center;
      z-index: 1;
      position: relative;
    }

    .alert {
      z-index: 1;
      position: relative;
    }

    .form-control {
      border-radius: 12px;
      padding: 0.75rem 1rem;
      box-shadow: inset 0 1px 3px rgba(0,0,0,0.05);
      border: 1px solid #cfd8dc;
      transition: all 0.2s;
    }
    .form-control:focus {
      border-color: #1976d2;
      box-shadow: 0 0 0 0.2rem rgba(25, 118, 210, 0.25);
    }

    .btn-primary {
      background: linear-gradient(90deg, #4169E1, #5A7CFA);
      border: none;
      border-radius: 12px;
      font-weight: 600;
      padding: 0.75rem;
      transition: all 0.3s;
    }
    .btn-primary:hover {
      background: linear-gradient(90deg, #3655c7, #4a6ae0);
    }

    .password-toggle {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: #6c757d;
    }

    .position-relative {
      position: relative;
    }

    .text-center a {
      color: #1976d2;
      text-decoration: none;
    }
    .text-center a:hover {
      text-decoration: underline;
    }

    @media(max-width:576px){
      .reset-card { padding:2rem 1.5rem; }
    }
  </style>
</head>
<body>

  <div class="reset-card">
    <h4>Reset Your Password</h4>


    <form method="POST">
      <div class="mb-3 position-relative">
        <input type="password" name="password" id="password" class="form-control" placeholder="Enter new password" required>
        <i class="bi bi-eye-slash password-toggle" onclick="togglePassword('password', this)"></i>
      </div>
      <div class="mb-3 position-relative">
        <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm new password" required>
        <i class="bi bi-eye-slash password-toggle" onclick="togglePassword('confirm_password', this)"></i>
      </div>
      <?php if(isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
      <?php endif; ?>
      <button type="submit" class="btn btn-primary w-100">Reset Password</button>
    </form>

    <p class="text-center mt-3"><a href="../pages/index.php">Back to Login</a></p>
  </div>

  <script>
    function togglePassword(id, icon){
      const input = document.getElementById(id);
      if(input.type === "password"){
        input.type = "text";
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
      } else {
        input.type = "password";
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
      }
    }
  </script>
</body>
</html>
