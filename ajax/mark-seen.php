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

    $stmt = $pdo->prepare("SELECT admin_response, user_seen_reply FROM customer_request
                           WHERE request_id = :id AND user_id = :user_id");
    $stmt->execute([':id' => $request_id, ':user_id' => $user_id]);
    $request = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$request) {
        throw new Exception("Request not found.");
    }

    if (!empty(trim($request['admin_response'])) && $request['user_seen_reply'] == 0) {
        $updateStmt = $pdo->prepare("
            UPDATE customer_request
            SET user_seen_reply = 1
            WHERE request_id = :id AND user_id = :user_id
        ");
        $updateStmt->execute([':id' => $request_id, ':user_id' => $user_id]);
    }

    echo json_encode(['success' => true]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
