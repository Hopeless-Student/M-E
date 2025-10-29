<?php
/**
 * Create New Response Template
 */

header('Content-Type: application/json');
require_once __DIR__ . '/../../../../config/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['name']) || !isset($input['content'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Missing required fields']);
    exit;
}

$name = trim($input['name']);
$category = trim($input['category'] ?? 'inquiry');
$subject = trim($input['subject'] ?? '');
$content = trim($input['content']);
$notes = trim($input['notes'] ?? '');
$adminId = 1; // TODO: Get from session

if (empty($name) || empty($content)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Name and content are required']);
    exit;
}

// Validate category
$validCategories = ['inquiry', 'orders', 'support', 'feedback', 'custom'];
if (!in_array($category, $validCategories)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid category']);
    exit;
}

try {
    $sql = "INSERT INTO response_templates (name, category, subject, content, notes, created_by)
            VALUES (:name, :category, :subject, :content, :notes, :adminId)";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':category', $category);
    $stmt->bindValue(':subject', $subject);
    $stmt->bindValue(':content', $content);
    $stmt->bindValue(':notes', $notes);
    $stmt->bindValue(':adminId', $adminId, PDO::PARAM_INT);

    if (!$stmt->execute()) {
        throw new Exception('Failed to create template');
    }

    $templateId = $pdo->lastInsertId();

    echo json_encode([
        'success' => true,
        'message' => 'Template created successfully',
        'templateId' => (int)$templateId
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Failed to create template',
        'message' => $e->getMessage()
    ]);
}
