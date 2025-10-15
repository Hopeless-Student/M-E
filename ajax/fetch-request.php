<?php

require_once __DIR__ . '/../includes/database.php';
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
$pdo = connect();
header('Content-Type: application/json');
  try {
    $type = isset($_GET['type']) ? trim($_GET['type']) : null;
    $status = isset($_GET['status']) ? trim($_GET['status']) : null;
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT request_id, request_type, subject, message, status, created_at, admin_response, user_seen_reply FROM customer_request WHERE user_id = :user_id";
    $requestFilter = [':user_id'=>$user_id];

    if($type){
      $sql .= " AND request_type = :type"; $requestFilter[':type'] = $type;
    }
    if($status){
      $sql .= " AND status = :status"; $requestFilter[':status'] = $status;
    }
    $stmtRequest = $pdo->prepare($sql);
    $stmtRequest->execute($requestFilter);
    $requests = $stmtRequest->fetchAll(PDO::FETCH_ASSOC);

    // $currentType = $type ? ucfirst(str_replace("_", " ", $type)) : "All Types";
    // $currentStatus = $status ? ucfirst(str_replace("-", " ", $status)) : "All Status";

    echo json_encode(['success' => true, 'requests' => $requests]);
  } catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    echo "Database Error: " . $e->getMessage();
  }

 ?>
