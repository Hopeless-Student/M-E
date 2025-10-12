<?php
require_once __DIR__ .'/../includes/database.php';
require_once __DIR__ .'/../auth/mainpage-auth.php';

  if($_SERVER['REQUEST_METHOD'] == "POST"){
    $request_type = trim($_POST['request_type'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $user_id = $_SESSION['user_id'] ?? null;
    var_dump($request_type);
    $errors = [];
    if (empty($request_type) || !in_array($request_type, ['inquiry', 'complaint', 'custom_order', 'other'])) {
        $errors[] = "Invalid request type";
    }

    if (strlen($subject) < 5 || strlen($subject) > 100) {
        $errors[] = "Subject must be between 1–100 characters";
    }

    if (strlen($message) < 10 || strlen($message) > 1000) {
        $errors[] = "Message must be between 10–1000 characters";
    }
    if(empty($_SESSION['user_id']) && $user_id == null){
      $errors[] = "You must login first before sending a request!";
    }

    if (!empty($errors)) {
    $_SESSION['request_error'] = implode(', ', $errors);
    header('Location: ../pages/index.php');
    exit;
}
      try {

          $sql = "INSERT INTO customer_request(user_id, request_type, subject, message, created_at)
                  VALUES(:user_id, :request_type, :subject, :message, NOW())";
                  var_dump($sql);
          $stmt = $pdo->prepare($sql);
          $stmt->execute([
            ':user_id'=>$user_id,
            ':request_type'=>$request_type,
            ':subject'=>$subject,
            ':message'=>$message,
          ]);

          // $_SESSION['request_success'] = "Your request has been submitted successfully! We'll get back to you soon.";
          // header('Location: ../pages/index.php');
          // exit;
      } catch (PDOException $e) {
        $_SESSION['request_error'] = "Error submitting request. Please try again later.";
        echo "Database Error: " . $e->getMessage();
      }

  }

 ?>
