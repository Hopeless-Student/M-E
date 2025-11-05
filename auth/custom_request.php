<?php
require_once __DIR__ .'/../includes/database.php';
require_once __DIR__ .'/mainpage-auth.php';
require_once __DIR__ .'/sendRequestEmail.php';

  if($_SERVER['REQUEST_METHOD'] == "POST"){
    $request_type = trim($_POST['request_type'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $user_id = $_SESSION['user_id'] ?? null;
    // var_dump($request_type);
    $errors = [];
    if (empty($request_type) || !in_array($request_type, ['inquiry', 'complaint', 'custom_order', 'other'])) {
        $errors[] = "Invalid request type";
    }

    if (strlen($subject) < 5 || strlen($subject) > 100) {
        $errors[] = "Subject must be between 5–100 characters";
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
                  // var_dump($sql);
          $stmt = $pdo->prepare($sql);
          $stmt->execute([
            ':user_id'=>$user_id,
            ':request_type'=>$request_type,
            ':subject'=>$subject,
            ':message'=>$message,
          ]);
          $sqlSelect = "SELECT first_name, last_name, email FROM users WHERE user_id = ?";
          $stmtSelect = $pdo->prepare($sqlSelect);
          $stmtSelect->execute([$user_id]);
          $user = $stmtSelect->fetch(PDO::FETCH_ASSOC);
          if($user){
            $emailSent = sendRequestEmail($user['email'], $user['first_name'], $user['last_name'], $subject, $message, $request_type);

            if($emailSent){
              $_SESSION['request_success'] = "Your request has been submitted successfully! We'll get back to you soon.";
            } else {
              $_SESSION['request_warning'] = "Your request has been saved, but we couldn't send a confirmation email. Please check back in your account requests.";
            }
          }
      } catch (PDOException $e) {
        $_SESSION['request_error'] = "Error submitting request. Please try again later.";
        echo "Database Error: " . $e->getMessage();
      }
      header('Location: ../pages/index.php');
      exit;

  }
  header('Location: ../pages/index.php');
  exit;
 ?>
