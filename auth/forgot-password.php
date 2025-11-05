<?php
session_start();

require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/sendForgotPassword.php';

$pdo = connect();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../forgot-password.php");
    exit;
}

$errors = [];

$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
if (!$email) {
    $_SESSION['error'] = "Please enter a valid email address.";
    header("Location: ../forgot-password.php");
    exit;
}

try {
    $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
      $token = bin2hex(random_bytes(32));
      $expires = date("Y-m-d H:i:s", strtotime("+1 hour"));
      $stmt = $pdo->prepare("UPDATE users SET reset_token = ?, forgot_token_expires = ? WHERE email = ?");
      $stmt->execute([$token, $expires, $user['email']]);
        $emailSent = sendForgotPassword(
            $user['email'],
            $user['first_name'],
            $user['last_name'],
            $token
        );

        if ($emailSent) {
            $_SESSION['success'] = "Reset link sent! Please check your email for instructions.";
        } else {
            $_SESSION['error'] = "Failed to send the reset email. Please try again later.";
        }
    } else {
        $_SESSION['error'] = "No account found with that email address.";
    }

} catch (PDOException $e) {
    $_SESSION['error'] = "Database error: " . $e->getMessage();
}

header("Location: ../forgot-password.php");
exit;
?>
