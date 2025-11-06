<?php
/**
 * Get Single Request Details
 * Returns complete information for a single request including history and attachments
 */

session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../../../config/config.php';

// Check admin authentication
if (!isset($_SESSION['admin_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$archived = isset($_GET['archived']) && $_GET['archived'] === 'true';

if ($id === 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid request ID']);
    exit;
}

try {
    $table = $archived ? 'customer_request_archive' : 'customer_request';
    $idField = $archived ? 'archive_id' : 'request_id';

    // Get main request data
    if ($archived) {
        $sql = "SELECT a.*, a.request_id as original_request_id,
                       au.first_name as admin_first_name, au.last_name as admin_last_name
                FROM customer_request_archive a
                LEFT JOIN admin_user au ON au.admin_id = a.responded_by
                WHERE a.archive_id = :id";
    } else {
        $sql = "SELECT cr.*,
                       u.first_name, u.middle_name, u.last_name, u.email, u.contact_number,
                       au.first_name as admin_first_name, au.last_name as admin_last_name
                FROM customer_request cr
                INNER JOIN users u ON u.user_id = cr.user_id
                LEFT JOIN admin_user au ON au.admin_id = cr.responded_by
                WHERE cr.request_id = :id";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $request = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$request) {
        http_response_code(404);
        echo json_encode(['success' => false, 'error' => 'Request not found']);
        exit;
    }

    // Format customer name
    if ($archived) {
        $customerName = $request['customer_name'];
        $customerEmail = $request['customer_email'];
        $customerContact = $request['customer_contact'];
    } else {
        $customerName = trim($request['first_name'] . ' ' . $request['middle_name'] . ' ' . $request['last_name']);
        $customerEmail = $request['email'];
        $customerContact = $request['contact_number'];
    }

    // Get initials for avatar
    $nameParts = explode(' ', $customerName);
    $avatar = strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''));

    // Format admin name
    $adminName = '';
    if ($request['admin_first_name'] && $request['admin_last_name']) {
        $adminName = trim($request['admin_first_name'] . ' ' . $request['admin_last_name']);
    }

    // Get attachments (only for non-archived)
    $attachments = [];
    if (!$archived) {
        $attachSql = "SELECT * FROM request_attachments WHERE request_id = :id";
        $attachStmt = $pdo->prepare($attachSql);
        $attachStmt->bindValue(':id', $archived ? $request['original_request_id'] : $id, PDO::PARAM_INT);
        $attachStmt->execute();
        $attachments = $attachStmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get history (only for non-archived)
    $history = [];
    if (!$archived) {
        $historySql = "SELECT h.*,
                              CASE
                                  WHEN h.action_by_type = 'admin' THEN CONCAT(au.first_name, ' ', au.last_name)
                                  WHEN h.action_by_type = 'customer' THEN CONCAT(u.first_name, ' ', u.last_name)
                                  ELSE 'System'
                              END as actor_name
                       FROM request_history h
                       LEFT JOIN admin_user au ON h.action_by = au.admin_id AND h.action_by_type = 'admin'
                       LEFT JOIN users u ON h.action_by = u.user_id AND h.action_by_type = 'customer'
                       WHERE h.request_id = :id
                       ORDER BY h.created_at DESC";
        $historyStmt = $pdo->prepare($historySql);
        $historyStmt->bindValue(':id', $id, PDO::PARAM_INT);
        $historyStmt->execute();
        $history = $historyStmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Format response
    $response = [
        'success' => true,
        'request' => [
            'id' => (int)($archived ? $request['archive_id'] : $request['request_id']),
            'originalId' => $archived ? (int)$request['original_request_id'] : null,
            'userId' => (int)$request['user_id'],
            'type' => $request['request_type'],
            'subject' => $request['subject'],
            'message' => $request['message'],
            'status' => $request['status'],
            'priority' => $request['priority'],
            'adminResponse' => $request['admin_response'],
            'respondedBy' => $request['responded_by'] ? (int)$request['responded_by'] : null,
            'respondedByName' => $adminName,
            'createdAt' => $request['created_at'],
            'respondedAt' => $request['responded_at'],
            'customerName' => $customerName,
            'customerEmail' => $customerEmail,
            'customerContact' => $customerContact,
            'avatar' => $avatar,
            'archived' => $archived
        ],
        'attachments' => array_map(function($a) {
            return [
                'id' => (int)$a['attachment_id'],
                'filename' => $a['original_filename'],
                'size' => formatFileSize((int)$a['file_size']),
                'path' => $a['file_path'],
                'icon' => getFileIcon($a['mime_type'])
            ];
        }, $attachments),
        'history' => array_map(function($h) {
            $nameParts = explode(' ', $h['actor_name']);
            $avatar = strtoupper(substr($nameParts[0], 0, 1) . (isset($nameParts[1]) ? substr($nameParts[1], 0, 1) : ''));

            return [
                'id' => (int)$h['history_id'],
                'actionType' => $h['action_type'],
                'actorName' => $h['actor_name'],
                'actorType' => $h['action_by_type'],
                'avatar' => $avatar,
                'notes' => $h['notes'],
                'oldValue' => $h['old_value'],
                'newValue' => $h['new_value'],
                'createdAt' => $h['created_at']
            ];
        }, $history)
    ];

    if ($archived) {
        $response['request']['archivedAt'] = $request['archived_at'];
        $response['request']['archiveReason'] = $request['archive_reason'];
        $response['request']['archiveNotes'] = $request['archive_notes'];
    }

    echo json_encode($response);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Failed to fetch request details',
        'message' => $e->getMessage()
    ]);
}

/**
 * Format file size to human readable
 */
function formatFileSize($bytes) {
    if ($bytes < 1024) return $bytes . ' B';
    if ($bytes < 1048576) return round($bytes / 1024, 2) . ' KB';
    return round($bytes / 1048576, 2) . ' MB';
}

/**
 * Get icon name based on mime type
 */
function getFileIcon($mimeType) {
    if (strpos($mimeType, 'image/') === 0) return 'image';
    if (strpos($mimeType, 'video/') === 0) return 'video';
    if (strpos($mimeType, 'audio/') === 0) return 'music';
    if (strpos($mimeType, 'pdf') !== false) return 'file-text';
    if (strpos($mimeType, 'word') !== false || strpos($mimeType, 'document') !== false) return 'file-text';
    if (strpos($mimeType, 'sheet') !== false || strpos($mimeType, 'excel') !== false) return 'file-spreadsheet';
    return 'file';
}
