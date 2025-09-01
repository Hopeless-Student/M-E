<?php
session_start();
include('../includes/database.php');
  $pdo = connect();
  if(isset($_GET['email'],$_GET['token'])){
    $email = $_GET['email'];
    $token = $_GET['token'];
      try {
        $sql = "SELECT email, verification_token, token_created_at FROM users
                WHERE email=:email AND verification_token=:token
                AND is_verified=0 AND token_created_at >= NOW() - INTERVAL 2 MINUTE LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':email'=>$email, ':token'=>$token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

          if($user){
            $update = $pdo->prepare("UPDATE users
              SET is_verified=1,
              verification_token=NULL,
              token_created_at=NULL
              WHERE email=:email");
            $update->execute([':email' => $email]);
            header('Location: ../user/profile.php');
            exit;
          } else {
            echo "Token expired or invalid. Deleting user...";
            $delete = $pdo->prepare("DELETE FROM users
                WHERE email=:email
                AND is_verified=0
                AND verification_token=:token
                AND token_created_at < NOW() - INTERVAL 2 MINUTE");
            $delete->execute([':email'=>$email, ':token'=>$token]);
            header('Location: ../test.php?status=expired');
            exit;
          }
      } catch (PDOException $e) {
        echo "Error connection: " . $e->getMessage();
      }

  } else {
    echo "No verification parameters provided!";
    header("Location: ../register.php");
    exit;
  }
 ?>
