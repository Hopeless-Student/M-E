<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
      require_once __DIR__ .'/../includes/database.php';
      $pdo = connect();

      if (!isset($_SESSION['user_id'])) {
          header("Location: ../pages/homepage.php");
          exit;
      }

      $stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = :id LIMIT 1");
      $stmt->execute([':id' => $_SESSION['user_id']]);
      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$user) {
          // echo "User not found!";
          header("Location: ../pages/index.php");
          exit;
      } else {
        $_SESSION['isActive'] = $user['isActive'];
      }
?>
