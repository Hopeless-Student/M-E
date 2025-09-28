<?php
  session_start();
  include('includes/database.php');
  $pdo = connect();

  if(isset($_GET["email"],$_GET['token'])){
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
          // $update = $pdo->prepare("UPDATE users SET is_verified=1, verification_token=NULL, token_created_at=NULL WHERE email=:email");
          // $update->execute([':email' => $email]);
          // header('Location: ../testing.php');
          $$delete = $pdo->prepare("DELETE FROM users WHERE email=:email
              AND verification_token=:token
              AND token_created_at < NOW() - INTERVAL 2 MINUTE");
          $delete->execute([':email'=>$email, ':token'=>$token]);
            echo "Deleted the record in db";
        } else {
          echo "Invalid or expired verification link.";
        }
    } catch (PDOException $e) {
      echo "Error connection: " . $e->getMessage();
    }
  }
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <form class="" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <label>
        Delete Record in DB: <input type="submit" name="delete" value="Delete">
      </label>
    </form>
    <h1>Testing conflict to main to create a pull request</h1>
  </body>
</html>
