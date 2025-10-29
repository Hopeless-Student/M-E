<?php
require_once __DIR__ . '/../includes/database.php';
$pdo = connect();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? '';
  $request_id = $_POST['request_id'] ?? null;

  if (!$action || !$request_id) {
    echo json_encode(['success' => false, 'message' => 'Missing parameters']);
    exit;
  }

  if ($action === 'delete') {
    $stmt = $pdo->prepare("DELETE FROM customer_request WHERE request_id = :id");
    $stmt->execute(['id' => $request_id]);
    echo json_encode(['success' => true, 'message' => 'Request deleted successfully.']);
  } elseif ($action === 'edit') {
    $message = trim($_POST['message'] ?? '');
    $stmt = $pdo->prepare("UPDATE customer_request SET message = :message WHERE request_id = :id");
    $stmt->execute(['message' => $message, 'id' => $request_id]);

    echo json_encode(['success' => true]);
  } else {
    echo json_encode(['success' => false, 'message' => 'Invalid action.']);
  }
}
?>
