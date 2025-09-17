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
              if ($user && password_verify($password, $user['password'])) {
                    $_SESSION["user_id"] = $user["user_id"];

                    if ($user['isActive'] == 0) {
                        header("Location: ../user/profile.php");
                        exit;
                    }

                    header("Location: ../pages/index.php");
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
