<?php
  session_start();
  include("..\includes\database.php");
  $pdo = connect();
  // $loginFailed ="";
  // $showModal = false;
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $password = $_POST["password"];

        try {
            $sql = "SELECT * FROM users WHERE username=:username LIMIT 1";
            $stmt = $pdo->prepare($sql);
            $stmt-> execute([":username"=>$username]);

            $user = $stmt->fetch(PDO::FETCH_ASSOC); // nagiging assoc array siya
            if($user){
              if($user && $user['password'] == $password){

                $_SESSION["user_id"] = $user["id"];

                header("Location: ../user/profile.php");
                exit;
              } else {
                $loginFailed = "Incorrect password";
                // $showModal = true;
              }
            } else {
              $loginFailed = "User not found";
              // $showModal = true;
            }
        } catch (PDOException $e) {
          echo "Database failed: " . $e->getMessage();
          $showModal = true;
          return null;
        }
      }
      // header('Location: ../test.php');
      // exit;
?>
