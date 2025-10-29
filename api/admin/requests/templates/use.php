<?php
/**
 * Use Template - Increment usage count and return processed template
 */

header('Content-Type: application/json');
require_once __DIR__ . '/../../../../config/config.php';
require_once __DIR__ . '/../../../../config/mailer.php';

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
$variables = $input['variables'] ?? [];

try {
    // Get template
    $sql = "SELECT * FROM response_templates WHERE template_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $templateId, PDO::PARAM_INT);
    $stmt->execute();
    $template = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$template) {
        throw new Exception('Template not found');
    }

    // Process template variables
    $processedSubject = processTemplate($template['subject'], $variables);
    $processedContent = processTemplate($template['content'], $variables);

    // Increment usage count
    $updateSql = "UPDATE response_templates SET usage_count = usage_count + 1 WHERE template_id = :id";
    $updateStmt = $pdo->prepare($updateSql);
    $updateStmt->bindValue(':id', $templateId, PDO::PARAM_INT);
    $updateStmt->execute();

    echo json_encode([
        'success' => true,
        'template' => [
            'id' => (int)$template['template_id'],
            'name' => $template['name'],
            'subject' => $processedSubject,
            'content' => $processedContent
        ]
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Failed to use template',
        'message' => $e->getMessage()
    ]);
}
