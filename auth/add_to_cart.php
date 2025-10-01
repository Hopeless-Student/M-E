<?php
require_once __DIR__ .'/../includes/database.php';
require_once __DIR__ .'/mainpage-auth.php';

if($_SERVER['REQUEST_METHOD']=="POST"){
  $user_id = $_SESSION['user_id'];
  // if (!isset($_SESSION['cart'])) {
  //   $_SESSION['cart'] = [];
  // }
  $product_id = $_POST['product_id'] ?? null;

    try {
      if(isset($_SESSION['user_id'])){

        $checkCart =  "SELECT * FROM shopping_cart WHERE user_id = :user_id AND product_id = :product_id";
        $stmtCheck = $pdo->prepare($checkCart);
        $stmtCheck->execute([':user_id' =>$user_id, ':product_id'=>$product_id]);

        if ($stmtCheck->rowCount() > 0) {

          $pdo->prepare("UPDATE shopping_cart
            SET quantity = quantity + ?
            WHERE user_id = ? AND product_id = ?")
            ->execute([1, $user_id, $product_id]);
          } else {

            $pdo->prepare("INSERT INTO shopping_cart (user_id, product_id, quantity)
            VALUES (?, ?, ?)")
            ->execute([$user_id, $product_id, 1]);
          }
      } else {
        if ($product_id) {
          if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity']++;
          } else {
            $_SESSION['cart'][$product_id] = [
              'quantity' => 1
            ];
          }
        }
    }
  } catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
    }
}

header("Location: ../pages/index.php");
exit;
 ?>
