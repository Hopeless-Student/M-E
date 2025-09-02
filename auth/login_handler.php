<?php
  session_start();
  include("..\includes\database.php");
  $pdo = connect();
  // $loginFailed ="";
  // $showModal = false;
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $login_id = trim($_POST["login_id"]);
        $password = $_POST["password"];

        try {
            // $sql = "SELECT * FROM users WHERE (username=:login_id OR email=:login_id) LIMIT 1";
            // $stmt = $pdo->prepare($sql);
            // $stmt-> execute(["login_id"=>$login_id]);
            $sql = "SELECT * FROM users WHERE (username= :login_id_username OR email= :login_id_email) LIMIT 1";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['login_id_username' => $login_id,'login_id_email' => $login_id]);


            $user = $stmt->fetch(PDO::FETCH_ASSOC); // nagiging assoc array siya
            if($user){
              if (password_verify($password, $user['password'])) {
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
