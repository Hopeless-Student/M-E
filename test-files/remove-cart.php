<!-- <?php
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ .'/../auth/auth.php';
$pdo = connect();

  if($_SERVER['REQUEST_METHOD'] == "POST"){

    try {
      $cart_id = $_POST['cart_id'];
      $sql = "DELETE FROM shopping_cart WHERE cart_id = ?";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([$cart_id]);
      header("Location: order-history-test.php");
      exit;
    } catch (PDOException $e) {
      echo "Database Error: " . $e->getMessage();
    }

  }
 ?> -->
