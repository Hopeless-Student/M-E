<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

require_once __DIR__ .'/../includes/database.php';
require_once __DIR__ .'/sendUsMessage.php';

  if($_SERVER['REQUEST_METHOD'] == "POST"){
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    // var_dump($request_type);
    $errors = [];
    if (empty($name) || strlen($name) < 5) {
        $errors[] = "Invalid Name! Enter a proper name to contact!";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors[] = "Invalid email format.";
    }

    if (strlen($subject) < 5 || strlen($subject) > 100) {
        $errors[] = "Subject must be between 5–100 characters";
    }

    if (strlen($message) < 10 || strlen($message) > 1000) {
        $errors[] = "Message must be between 10–1000 characters";
    }


    if (!empty($errors)) {
    $_SESSION['request_error'] = implode(', ', $errors);
    header('Location: ../pages/contact.php');
    exit;
}
      try {
        $emailSent = sendUsMessage($name, $email, $subject, $message);

        if($emailSent){
          $_SESSION['request_success'] = "Your request has been submitted successfully! We'll get back to you soon.";

        } else {
          $_SESSION['request_error'] = "Your request has been saved, but we couldn't send a confirmation email. Please check back in your account requests.";

        }

      } catch (PDOException $e) {
        $_SESSION['request_error'] = "Error submitting request. Please try again later.";
        echo "Database Error: " . $e->getMessage();
      }
      header('Location: ../pages/contact.php');
      exit;

  }
  header("Location: ../pages/index.php");
  exit;
 ?>
