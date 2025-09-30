<?php
session_start();
$user = null;
if (isset($_SESSION['user_id'])) {
    $pdo = connect();
    $stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = :id LIMIT 1");
    $stmt->execute([':id' => $_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}
$profileImage = !empty($user['profile_image'])
    ? "../assets/profile-pics/" . htmlspecialchars($user['profile_image'])
    : "../assets/images/default.png";
 ?>
