<?php
/**
 * Delete Response Template
 */

session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../../../../config/config.php';

// Check admin authentication
if (!isset($_SESSION['admin_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['templateId'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Template ID required']);
    exit;
}

$templateId = (int)$input['templateId'];

try {
    $sql = "DELETE FROM response_templates WHERE template_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $templateId, PDO::PARAM_INT);

    if (!$stmt->execute() || $stmt->rowCount() === 0) {
        throw new Exception('Template not found');
    }

    echo json_encode([
        'success' => true,
        'message' => 'Template deleted successfully'
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Failed to delete template',
        'message' => $e->getMessage()
    ]);
}
