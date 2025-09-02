<?php
session_start();
  require_once __DIR__ . '/../includes/database.php';
require 'sendEmail.php';
$pdo = connect();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $_SESSION['error'] = "Invalid request method!";
    header("Location: ../checkyouremail.php");
    exit;
}

if (!isset($_SESSION['email'])) {
    $_SESSION['error'] = "Invalid input data!";
    header("Location: ../register.php");
    exit;
}

      $email = $_SESSION['email'];
      $fname  = $_SESSION['first_name'] ?? '';
      $lname  = $_SESSION['last_name'] ?? '';
      $token  = bin2hex(random_bytes(32));
      $cooldown = 60;

      try { // check ng cooldown if 1 min na sa SQL

        $sql = "SELECT is_verified, token_created_at
                FROM users WHERE
                email=:email LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':email'=>$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$user){
          $_SESSION['error'] = "Email not found!";
        }
        elseif ($user['is_verified']) {
          $_SESSION['error'] = "Your email is already verified.";
        } else {
              $sql = "SELECT (token_created_at >= NOW() - INTERVAL {$cooldown} SECOND) AS recent
              FROM users
              WHERE email = :email AND is_verified = 0
              LIMIT 1";
              $stmt = $pdo->prepare($sql);
              $stmt->execute([':email' => $email]);
              $recent = $stmt->fetchColumn();

              if ($recent) {
                $_SESSION['error'] = "Please wait a minute before requesting another verification email.";
              } else {
                // next overwrite old token sa db
                $update = "UPDATE users
                SET verification_token = :token,
                token_created_at = NOW()
                WHERE email = :email";
                $updateToken = $pdo->prepare($update);
                $updateToken->execute([':token' => $token, ':email' => $email]);

                // send email
                if (sendVerificationToEmail($email, $fname, $lname, $token)) {
                  $_SESSION['success'] = "A new verification email has been sent!";
                  $_SESSION['last_sent_at'] = time();
                } else {
                  $_SESSION['error'] = "Failed to send verification email. Please try again later.";
                }
              }

        } // end ng else top

      } catch (PDOException $e) {
          $_SESSION['error'] = "Database error: " . $e->getMessage();
      }

header("Location: ../checkyouremail.php");
exit;
