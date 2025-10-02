<?php
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../auth/auth.php';
include('../includes/user-sidebar.php');
$user_id = $_SESSION['user_id'];
  $stmt = $pdo->prepare("SELECT * FROM customer_request WHERE user_id =:user_id");
  // var_dump($stmt);
  $stmt->execute([':user_id'=>$user_id]);
  $request = $stmt->fetchAll(PDO::FETCH_ASSOC);
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Custom Request</title>
    <link href="../bootstrap-5.3.8-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/user-sidebar.css">
  </head>
  <body>
    <div class="container">
      <div class="text-center">
        <p>Coming Soon</p>
        <h1>Your Custom Request</h1>
        <div class="container-md" style="background:lightblue;">
          <?php foreach ($request as $customer_request): ?>
            <p>Request type: <?= htmlspecialchars($customer_request['request_type']); ?></p>
            <p>Subject     : <?= htmlspecialchars($customer_request['subject']); ?></p>
            <p>Message     : <?= htmlspecialchars($customer_request['message']); ?></p>
            <p>Status      : <?= htmlspecialchars($customer_request['status']); ?></p> <br>
            <!-- <p>Admin Response: <?= htmlspecialchars($customer_request['admin_response']); ?></p> -->
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </body>
</html>
