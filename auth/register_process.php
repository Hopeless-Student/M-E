<?php
session_start();
require_once __DIR__ .'/../includes/database.php';
require 'sendEmail.php';

$pdo = connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $fname = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_SPECIAL_CHARS);
  $lname = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_SPECIAL_CHARS);
  $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

  $password        = $_POST['password'] ?? '';
  $confirmPassword = $_POST['confirm-password'] ?? '';

  $token = bin2hex(random_bytes(32));

  if (!empty($fname) && !empty($lname) && !empty($email)) {
    $_SESSION["first_name"] = $fname;
    $_SESSION["last_name"] = $lname;
    $_SESSION["email"] = $email;

    if ($password !== $confirmPassword) {
      die("Passwords do not match!");
    }
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
      /*Register testing
      1st: Kapag nag register ka ng new account:
        1a. Delete unverified accounts longer than 2 mins -->
        2a. C-check kung duplicate email, if meron at verified, error message = Email is taken/registered ||
            if meron at hindi pa verified within 2 minutes error message = Email pending verification. Kapag wala at bago -->
        3a. Redirect sa checkyouremail.php
      2nd: Makalipas ang 2 mins pataas at nag register using same email account:
        1b. Delete emails longer than 2 mins including your previous registered email-->
        2b. Unverified? --> Redirect sa checkyouremail.php
      */
      $deleteUnverified = "DELETE FROM users WHERE is_verified = 0 AND token_created_at < NOW() - INTERVAL 2 MINUTE";
      $cleanup = $pdo->prepare($deleteUnverified);
      $cleanup->execute();

      $findDuplicate = "SELECT * FROM users WHERE email = :email LIMIT 1";
      $stmt = $pdo->prepare($findDuplicate);
      $stmt->execute([':email' => $email]);
      $duplicate = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($duplicate) {
        if ($duplicate['is_verified']) {
          $_SESSION['error'] = "Email is already registered or taken.";
        } else {
          $_SESSION['error'] = "Email is already pending verification. Please check your inbox or register again after 2 minutes.";
        }
        header("Location: ../register.php");
        exit;
      }

      $sql = "INSERT INTO users (first_name, last_name, email, verification_token, password, token_created_at)
              VALUES (:fname, :lname, :email, :token, :password, NOW())";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([
        ":fname" => $fname,
        ":lname" => $lname,
        ":email" => $email,
        ":token" => $token,
        ":password" => $hashedPassword
      ]);

      if (sendVerificationToEmail($email, $fname, $lname, $token)) {
        $_SESSION['success'] = "Verification email sent!";
        header("Location: ../checkyouremail.php");
        exit;
      } else {
        $pdo->prepare("DELETE FROM users WHERE email = :email")->execute([":email" => $email]);
        $_SESSION['error'] = "Failed to send verification email. Please try again.";
        header("Location: ../register.php");
        exit;
      }

    } catch (PDOException $e) {
      echo "Database error: " . $e->getMessage();
    }
  } else {
    $_SESSION['error'] = "Invalid input data!";
    header("Location: ../register.php");
    exit;
  }
} else {
  $_SESSION['error'] = "Invalid request method!";
  header("Location: ../register.php");
  exit;
}
?>
