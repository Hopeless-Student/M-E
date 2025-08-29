<?php
  session_start();
  include("..\includes\database.php");
  $pdo = connect();
  $loginFailed ="";
  $showModal = false;
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $password = $_POST["password"];

        try {
            $sql = "SELECT id, users, password FROM users WHERE users = :username";
            $stmt = $pdo->prepare($sql);
            $stmt-> execute(["username"=>$username]);

            $user = $stmt->fetch(PDO::FETCH_ASSOC); // nagiging assoc array siya
            if($user){
              if($user && password_verify($password, $user["password"])){

                $_SESSION["id"] = $user["id"];
                $_SESSION["user"] = $user["users"];

                header("Location: ../index.php");
                exit();
              } else {
                $loginFailed = "Incorrect password";
                $showModal = true;
              }
            } else {
              $loginFailed = "User not found";
              $showModal = true;
            }
        } catch (PDOException $e) {
          echo "Database failed: " . $e->getMessage();
          $showModal = true;
          return null;
        }
      }
?>
