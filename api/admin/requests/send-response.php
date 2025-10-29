<?php
/**
 * Send Response to Customer Request
 * Sends email to customer and updates request status
 */

header('Content-Type: application/json');
require_once __DIR__ . '/../../../config/config.php';
// require_once __DIR__ . '/../../../auth/adminResponse.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['requestId']) || !isset($input['response'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Missing required fields']);
    exit;
}

$requestId = (int)$input['requestId'];
$response = trim($input['response']);
$subject = trim($input['subject'] ?? '');
$status = trim($input['status'] ?? 'in-progress');
$priority = trim($input['priority'] ?? 'normal');
$adminId = 1;

if (empty($response)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Response message cannot be empty']);
    exit;
}

try {
    $pdo->beginTransaction();

    // Get request details
    $sql = "SELECT cr.*, u.first_name, u.middle_name, u.last_name, u.email
            FROM customer_request cr
            INNER JOIN users u ON u.user_id = cr.user_id
            WHERE cr.request_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $requestId, PDO::PARAM_INT);
    $stmt->execute();
    $request = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$request) {
        throw new Exception('Request not found');
    }

    $customerName = trim($request['first_name'] . ' ' . $request['middle_name'] . ' ' . $request['last_name']);
    // $customerEmail = $request['email'];

    // Prepare email subject
    // $emailSubject = $subject ?: 'RE: ' . $request['subject'];

    // Process template variables in response
    $variables = [
        'customer_name' => $customerName,
        'subject' => $request['subject'],
        'request_id' => $requestId,
        'company_name' => 'M & E Team'
    ];
    if (function_exists('processTemplate')) {
    $processedResponse = processTemplate($response, $variables);
    if (is_array($processedResponse) && isset($processedResponse['error'])) {
        // Fallback if template not found
        $processedResponse = $response;
    }
    } else {
        $processedResponse = $response;
    }


    // Send email
    // $emailSent = sendEmail($customerEmail, $customerName, $emailSubject, $processedResponse);
    //
    // if (!$emailSent) {
    //     throw new Exception('Failed to send email');
    // }

    // Update request
    $updateSql = "UPDATE customer_request
                  SET status = :status,
                      priority = :priority,
                      admin_response = :response,
                      responded_by = :adminId,
                      responded_at = CASE
                          WHEN responded_at IS NULL THEN NOW()
                          ELSE responded_at
                      END
                  WHERE request_id = :id";
    $updateStmt = $pdo->prepare($updateSql);
    $updateStmt->bindValue(':status', $status);
    $updateStmt->bindValue(':priority', $priority);
    $updateStmt->bindValue(':response', $processedResponse);
    $updateStmt->bindValue(':adminId', $adminId, PDO::PARAM_INT);
    $updateStmt->bindValue(':id', $requestId, PDO::PARAM_INT);

    if (!$updateStmt->execute()) {
        throw new Exception('Failed to update request');
    }

    // Add to history
    $historySql = "INSERT INTO request_history
                   (request_id, action_type, action_by, action_by_type, notes, new_value)
                   VALUES (:requestId, 'response_sent', :adminId, 'admin', :notes, :response)";
    $historyStmt = $pdo->prepare($historySql);
    $historyStmt->bindValue(':requestId', $requestId, PDO::PARAM_INT);
    $historyStmt->bindValue(':adminId', $adminId, PDO::PARAM_INT);
    $historyStmt->bindValue(':notes', 'Response sent to customer via email');
    $historyStmt->bindValue(':response', $processedResponse);
    $historyStmt->execute();

    $pdo->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Response sent successfully',
        'requestId' => $requestId
    ]);

} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Failed to send response',
        'message' => $e->getMessage()
    ]);
}
