<?php
include('../includes/database.php');
  $pdo = connect();
  if(isset($_GET['email'],$_GET['token'])){
    $email = $_GET['email'];
    $token = $_GET['token'];

      try {
        $sql = "SELECT email, verification_token FROM users
                WHERE email=:email AND verification_token=:token
                AND is_verified=0 AND token_created_at >= NOW() - INTERVAL 1 DAY";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':email'=>$email, ':token'=>$token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

          if($user){
            $update = $pdo->prepare("UPDATE users SET is_verified=1, verification_token=NULL WHERE email=:email");
            $update->execute([':email' => $email]);
            header('Location: ../order_form.php');
            echo "Email verified! You can now log in.";
          } else {
            echo "Invalid or expired verification link.";
          }
      } catch (PDOException $e) {
        echo "Error connection: " . $e->getMessage();
      }

  } else {
    echo "No verification parameters provided!";
  }
 ?>
