<?php
require_once __DIR__ . '/../includes/database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
  echo json_encode(['success' => false, 'message' => 'Not logged in']);
  exit;
}

$user_id = $_SESSION['user_id'];
$request_id = $_POST['request_id'] ?? null;

if (!$request_id) {
  echo json_encode(['success' => false, 'message' => 'Missing request ID']);
  exit;
}

try {
  $pdo = connect();
  $stmt = $pdo->prepare("
    UPDATE customer_request
    SET user_seen_reply = 1
    WHERE request_id = :id AND user_id = :user_id
  ");
  $stmt->execute([':id' => $request_id, ':user_id' => $user_id]);

  echo json_encode(['success' => true]);
} catch (Exception $e) {
  echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
