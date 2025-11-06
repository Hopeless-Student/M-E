<?php
/**
 * Archive Management API
 * Handles archive, restore, delete operations
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

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['action'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Missing action']);
    exit;
}

$action = $input['action'];
$adminId = (int)$_SESSION['admin_id'];

try {
    switch ($action) {
        case 'archive':
            echo json_encode(archiveRequest($pdo, $input, $adminId));
            break;
        case 'bulk-archive':
            echo json_encode(bulkArchiveRequests($pdo, $input, $adminId));
            break;
        case 'restore':
            echo json_encode(restoreRequest($pdo, $input, $adminId));
            break;
        case 'bulk-restore':
            echo json_encode(bulkRestoreRequests($pdo, $input, $adminId));
            break;
        case 'delete':
            echo json_encode(deleteArchived($pdo, $input, $adminId));
            break;
        case 'bulk-delete':
            echo json_encode(bulkDeleteArchived($pdo, $input, $adminId));
            break;
        case 'list':
            echo json_encode(listArchived($pdo, $input));
            break;
        default:
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Invalid action']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}

/**
 * Archive a single request
 */
function archiveRequest($pdo, $input, $adminId) {
    if (!isset($input['requestId'])) {
        throw new Exception('Request ID required');
    }

    $requestId = (int)$input['requestId'];
    $reason = trim($input['reason'] ?? 'manual');
    $notes = trim($input['notes'] ?? '');

    $pdo->beginTransaction();

    // Get request data
    $sql = "SELECT cr.*, u.first_name, u.middle_name, u.last_name, u.email, u.contact_number
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

    // Insert into archive
    $archiveSql = "INSERT INTO customer_request_archive
                   (request_id, user_id, request_type, subject, message, status, priority,
                    admin_response, responded_by, created_at, responded_at, archived_by,
                    archive_reason, archive_notes, customer_name, customer_email, customer_contact)
                   VALUES (:requestId, :userId, :type, :subject, :message, :status, :priority,
                           :response, :respondedBy, :createdAt, :respondedAt, :adminId,
                           :reason, :notes, :name, :email, :contact)";
    $archiveStmt = $pdo->prepare($archiveSql);
    $archiveStmt->bindValue(':requestId', $requestId, PDO::PARAM_INT);
    $archiveStmt->bindValue(':userId', $request['user_id'], PDO::PARAM_INT);
    $archiveStmt->bindValue(':type', $request['request_type']);
    $archiveStmt->bindValue(':subject', $request['subject']);
    $archiveStmt->bindValue(':message', $request['message']);
    $archiveStmt->bindValue(':status', $request['status']);
    $archiveStmt->bindValue(':priority', $request['priority']);
    $archiveStmt->bindValue(':response', $request['admin_response']);
    $archiveStmt->bindValue(':respondedBy', $request['responded_by'], PDO::PARAM_INT);
    $archiveStmt->bindValue(':createdAt', $request['created_at']);
    $archiveStmt->bindValue(':respondedAt', $request['responded_at']);
    $archiveStmt->bindValue(':adminId', $adminId, PDO::PARAM_INT);
    $archiveStmt->bindValue(':reason', $reason);
    $archiveStmt->bindValue(':notes', $notes);
    $archiveStmt->bindValue(':name', $customerName);
    $archiveStmt->bindValue(':email', $request['email']);
    $archiveStmt->bindValue(':contact', $request['contact_number']);

    if (!$archiveStmt->execute()) {
        throw new Exception('Failed to archive request');
    }

    // Add to history
    $historySql = "INSERT INTO request_history
                   (request_id, action_type, action_by, action_by_type, notes)
                   VALUES (:requestId, 'archived', :adminId, 'admin', :notes)";
    $historyStmt = $pdo->prepare($historySql);
    $historyStmt->bindValue(':requestId', $requestId, PDO::PARAM_INT);
    $historyStmt->bindValue(':adminId', $adminId, PDO::PARAM_INT);
    $historyStmt->bindValue(':notes', "Archived: $reason - $notes");
    $historyStmt->execute();

    // Delete from active requests
    $deleteSql = "DELETE FROM customer_request WHERE request_id = :id";
    $deleteStmt = $pdo->prepare($deleteSql);
    $deleteStmt->bindValue(':id', $requestId, PDO::PARAM_INT);

    if (!$deleteStmt->execute()) {
        throw new Exception('Failed to delete request from active');
    }

    $pdo->commit();

    return [
        'success' => true,
        'message' => 'Request archived successfully'
    ];
}

/**
 * Bulk archive requests
 */
function bulkArchiveRequests($pdo, $input, $adminId) {
    if (!isset($input['requestIds']) || !is_array($input['requestIds'])) {
        throw new Exception('Request IDs array required');
    }

    $requestIds = array_map('intval', $input['requestIds']);
    $reason = trim($input['reason'] ?? 'manual');
    $notes = trim($input['notes'] ?? '');

    $archived = 0;
    $errors = [];

    foreach ($requestIds as $requestId) {
        try {
            $result = archiveRequest($pdo, [
                'requestId' => $requestId,
                'reason' => $reason,
                'notes' => $notes
            ], $adminId);

            if ($result['success']) {
                $archived++;
            }
        } catch (Exception $e) {
            $errors[] = "Request $requestId: " . $e->getMessage();
        }
    }

    return [
        'success' => true,
        'message' => "Archived $archived request(s)",
        'archived' => $archived,
        'errors' => $errors
    ];
}

/**
 * Restore archived request
 */
function restoreRequest($pdo, $input, $adminId) {
    if (!isset($input['archiveId'])) {
        throw new Exception('Archive ID required');
    }

    $archiveId = (int)$input['archiveId'];

    $pdo->beginTransaction();

    // Get archived data
    $sql = "SELECT * FROM customer_request_archive WHERE archive_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $archiveId, PDO::PARAM_INT);
    $stmt->execute();
    $archived = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$archived) {
        throw new Exception('Archived request not found');
    }

    // Check if request already exists in active table
    $checkSql = "SELECT request_id FROM customer_request WHERE request_id = :id";
    $checkStmt = $pdo->prepare($checkSql);
    $checkStmt->bindValue(':id', $archived['request_id'], PDO::PARAM_INT);
    $checkStmt->execute();

    if ($checkStmt->fetch()) {
        throw new Exception('Request already exists in active requests');
    }

    // Restore to active table
    $restoreSql = "INSERT INTO customer_request
                   (request_id, user_id, request_type, subject, message, status, priority,
                    admin_response, responded_by, created_at, responded_at)
                   VALUES (:requestId, :userId, :type, :subject, :message, :status, :priority,
                           :response, :respondedBy, :createdAt, :respondedAt)";
    $restoreStmt = $pdo->prepare($restoreSql);
    $restoreStmt->bindValue(':requestId', $archived['request_id'], PDO::PARAM_INT);
    $restoreStmt->bindValue(':userId', $archived['user_id'], PDO::PARAM_INT);
    $restoreStmt->bindValue(':type', $archived['request_type']);
    $restoreStmt->bindValue(':subject', $archived['subject']);
    $restoreStmt->bindValue(':message', $archived['message']);
    $restoreStmt->bindValue(':status', $archived['status']);
    $restoreStmt->bindValue(':priority', $archived['priority']);
    $restoreStmt->bindValue(':response', $archived['admin_response']);
    $restoreStmt->bindValue(':respondedBy', $archived['responded_by'], PDO::PARAM_INT);
    $restoreStmt->bindValue(':createdAt', $archived['created_at']);
    $restoreStmt->bindValue(':respondedAt', $archived['responded_at']);

    if (!$restoreStmt->execute()) {
        throw new Exception('Failed to restore request');
    }

    // Delete from archive
    $deleteSql = "DELETE FROM customer_request_archive WHERE archive_id = :id";
    $deleteStmt = $pdo->prepare($deleteSql);
    $deleteStmt->bindValue(':id', $archiveId, PDO::PARAM_INT);

    if (!$deleteStmt->execute()) {
        throw new Exception('Failed to delete from archive');
    }

    $pdo->commit();

    return [
        'success' => true,
        'message' => 'Request restored successfully'
    ];
}

/**
 * Bulk restore requests
 */
function bulkRestoreRequests($pdo, $input, $adminId) {
    if (!isset($input['archiveIds']) || !is_array($input['archiveIds'])) {
        throw new Exception('Archive IDs array required');
    }

    $archiveIds = array_map('intval', $input['archiveIds']);

    $restored = 0;
    $errors = [];

    foreach ($archiveIds as $archiveId) {
        try {
            $result = restoreRequest($pdo, ['archiveId' => $archiveId], $adminId);
            if ($result['success']) {
                $restored++;
            }
        } catch (Exception $e) {
            $errors[] = "Archive $archiveId: " . $e->getMessage();
        }
    }

    return [
        'success' => true,
        'message' => "Restored $restored request(s)",
        'restored' => $restored,
        'errors' => $errors
    ];
}

/**
 * Permanently delete archived request
 */
function deleteArchived($pdo, $input, $adminId) {
    if (!isset($input['archiveId'])) {
        throw new Exception('Archive ID required');
    }

    $archiveId = (int)$input['archiveId'];

    $sql = "DELETE FROM customer_request_archive WHERE archive_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $archiveId, PDO::PARAM_INT);

    if (!$stmt->execute() || $stmt->rowCount() === 0) {
        throw new Exception('Failed to delete archived request');
    }

    return [
        'success' => true,
        'message' => 'Archived request deleted permanently'
    ];
}

/**
 * Bulk delete archived requests
 */
function bulkDeleteArchived($pdo, $input, $adminId) {
    if (!isset($input['archiveIds']) || !is_array($input['archiveIds'])) {
        throw new Exception('Archive IDs array required');
    }

    $archiveIds = array_map('intval', $input['archiveIds']);

    $placeholders = implode(',', array_fill(0, count($archiveIds), '?'));
    $sql = "DELETE FROM customer_request_archive WHERE archive_id IN ($placeholders)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($archiveIds);

    $deleted = $stmt->rowCount();

    return [
        'success' => true,
        'message' => "Deleted $deleted archived request(s)",
        'deleted' => $deleted
    ];
}

/**
 * List archived requests with filters
 */
function listArchived($pdo, $input) {
    $page = isset($input['page']) ? max(1, (int)$input['page']) : 1;
    $pageSize = isset($input['pageSize']) ? min(100, max(1, (int)$input['pageSize'])) : 12;
    $q = trim($input['q'] ?? '');
    $type = trim($input['type'] ?? '');
    $reason = trim($input['reason'] ?? '');
    $dateFilter = trim($input['dateFilter'] ?? '');
    $sortBy = trim($input['sortBy'] ?? 'date_desc');

    $offset = ($page - 1) * $pageSize;

    $where = [];
    $params = [];

    if ($q !== '') {
        $where[] = '(a.subject LIKE :q OR a.message LIKE :q OR a.customer_name LIKE :q OR a.customer_email LIKE :q)';
        $params[':q'] = "%$q%";
    }

    if ($type !== '') {
        $where[] = 'a.request_type = :type';
        $params[':type'] = $type;
    }

    if ($reason !== '') {
        $where[] = 'a.archive_reason = :reason';
        $params[':reason'] = $reason;
    }

    if ($dateFilter !== '') {
        switch ($dateFilter) {
            case 'today':
                $where[] = 'DATE(a.archived_at) = CURDATE()';
                break;
            case 'week':
                $where[] = 'YEARWEEK(a.archived_at) = YEARWEEK(NOW())';
                break;
            case 'month':
                $where[] = 'MONTH(a.archived_at) = MONTH(NOW()) AND YEAR(a.archived_at) = YEAR(NOW())';
                break;
            case 'quarter':
                $where[] = 'a.archived_at >= DATE_SUB(NOW(), INTERVAL 3 MONTH)';
                break;
            case 'year':
                $where[] = 'YEAR(a.archived_at) = YEAR(NOW())';
                break;
        }
    }

    $whereSql = count($where) ? ('WHERE ' . implode(' AND ', $where)) : '';

    // Count
    $countSql = "SELECT COUNT(*) FROM customer_request_archive a $whereSql";
    $countStmt = $pdo->prepare($countSql);
    foreach ($params as $k => $v) {
        $countStmt->bindValue($k, $v);
    }
    $countStmt->execute();
    $total = (int)$countStmt->fetchColumn();

    // Data
    $sql = "SELECT a.*, au.first_name as admin_first_name, au.last_name as admin_last_name
            FROM customer_request_archive a
            LEFT JOIN admin_user au ON au.admin_id = a.archived_by
            $whereSql
            ORDER BY ";

    switch ($sortBy) {
        case 'date_asc':
            $sql .= "a.archived_at ASC";
            break;
        case 'customer':
            $sql .= "a.customer_name ASC";
            break;
        case 'type':
            $sql .= "a.request_type ASC";
            break;
        default:
            $sql .= "a.archived_at DESC";
            break;
    }

    $sql .= " LIMIT :limit OFFSET :offset";

    $stmt = $pdo->prepare($sql);
    foreach ($params as $k => $v) {
        $stmt->bindValue($k, $v);
    }
    $stmt->bindValue(':limit', $pageSize, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $items = array_map(function ($r) {
        return [
            'id' => (int)$r['archive_id'],
            'originalRequestId' => (int)$r['request_id'],
            'type' => $r['request_type'],
            'subject' => $r['subject'],
            'message' => $r['message'],
            'status' => $r['status'],
            'priority' => $r['priority'],
            'createdAt' => $r['created_at'],
            'archivedAt' => $r['archived_at'],
            'archiveReason' => $r['archive_reason'],
            'archiveNotes' => $r['archive_notes'],
            'customerName' => $r['customer_name'],
            'customerEmail' => $r['customer_email'],
        ];
    }, $rows);

    return [
        'success' => true,
        'items' => $items,
        'total' => $total,
        'page' => $page,
        'pageSize' => $pageSize,
        'totalPages' => max(1, (int)ceil($total / $pageSize))
    ];
}
