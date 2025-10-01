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

                    try {
                      $pdo->beginTransaction();

                      if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as $product_id => $item) {

                          $checkStmt = $pdo->prepare("SELECT * FROM shopping_cart WHERE user_id = ? AND product_id = ?");
                          $checkStmt->execute([$user['user_id'], $product_id]);

                          if ($checkStmt->rowCount() > 0) {

                            $pdo->prepare("UPDATE shopping_cart
                              SET quantity = quantity + ?
                              WHERE user_id = ? AND product_id = ?")
                              ->execute([$item['quantity'], $user['user_id'], $product_id]);
                            } else {

                              $pdo->prepare("INSERT INTO shopping_cart (user_id, product_id, quantity)
                              VALUES (?, ?, ?)")
                              ->execute([$user['user_id'], $product_id, $item['quantity']]);
                            }
                          }

                        }

                      $pdo->commit();
                      unset($_SESSION['cart']);
                    } catch (Exception $e) {
                      $pdo->rollBack();
                      error_log("Cart merge failed: " . $e->getMessage());
                    }

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
?>
