<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../../config/config.php';

$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$pageSize = isset($_GET['pageSize']) ? min(100, max(1, (int)$_GET['pageSize'])) : 12;
$q = trim($_GET['q'] ?? '');
$status = trim($_GET['status'] ?? ''); // pending|in-progress|resolved|closed
$type = trim($_GET['type'] ?? ''); // inquiry|complaint|custom_order|other
$priority = trim($_GET['priority'] ?? ''); // low|medium|high|urgent
$sortBy = trim($_GET['sortBy'] ?? 'created_at'); // created_at|status|priority|type

$offset = ($page - 1) * $pageSize;

$where = [];
$params = [];

if ($q !== '') {
    $where[] = '(cr.subject LIKE :q OR cr.message LIKE :q OR u.first_name LIKE :q OR u.last_name LIKE :q OR u.email LIKE :q)';
    $params[':q'] = "%$q%";
}

if ($status !== '') {
    $where[] = 'cr.status = :status';
    $params[':status'] = $status;
}

if ($type !== '') {
    $where[] = 'cr.request_type = :type';
    $params[':type'] = $type;
}

if ($priority !== '') {
    $where[] = 'cr.priority = :priority';
    $params[':priority'] = $priority;
}

$whereSql = count($where) ? ('WHERE ' . implode(' AND ', $where)) : '';

// Count
$countSql = "SELECT COUNT(*) FROM customer_request cr 
             INNER JOIN users u ON u.user_id = cr.user_id 
             $whereSql";
$stmt = $pdo->prepare($countSql);
foreach ($params as $k => $v) { $stmt->bindValue($k, $v); }
$stmt->execute();
$total = (int)$stmt->fetchColumn();

// Data
$sql = "SELECT cr.request_id, cr.user_id, cr.request_type, cr.subject, cr.message, 
               cr.status, cr.priority, cr.admin_response, cr.responded_by, 
               cr.created_at, cr.responded_at,
               u.first_name, u.middle_name, u.last_name, u.email, u.contact_number,
               au.first_name as admin_first_name, au.last_name as admin_last_name
        FROM customer_request cr
        INNER JOIN users u ON u.user_id = cr.user_id
        LEFT JOIN admin_user au ON au.admin_id = cr.responded_by
        $whereSql
        ORDER BY ";

// Apply sorting
switch ($sortBy) {
    case 'status':
        $sql .= "FIELD(cr.status, 'pending', 'in-progress', 'resolved', 'closed'), cr.created_at DESC";
        break;
    case 'priority':
        $sql .= "FIELD(cr.priority, 'urgent', 'high', 'medium', 'low'), cr.created_at DESC";
        break;
    case 'type':
        $sql .= "cr.request_type ASC, cr.created_at DESC";
        break;
    default:
        $sql .= "cr.created_at DESC";
        break;
}

$sql .= " LIMIT :limit OFFSET :offset";

$stmt = $pdo->prepare($sql);
foreach ($params as $k => $v) { $stmt->bindValue($k, $v); }
$stmt->bindValue(':limit', $pageSize, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$items = array_map(function ($r) {
    $customerName = trim($r['first_name'] . ' ' . $r['middle_name'] . ' ' . $r['last_name']);
    $adminName = '';
    if ($r['admin_first_name'] && $r['admin_last_name']) {
        $adminName = trim($r['admin_first_name'] . ' ' . $r['admin_last_name']);
    }
    
    return [
        'id' => (int)$r['request_id'],
        'userId' => (int)$r['user_id'],
        'type' => $r['request_type'],
        'subject' => $r['subject'],
        'message' => $r['message'],
        'status' => $r['status'],
        'priority' => $r['priority'],
        'adminResponse' => $r['admin_response'],
        'respondedBy' => $r['responded_by'] ? (int)$r['responded_by'] : null,
        'respondedByName' => $adminName,
        'createdAt' => $r['created_at'],
        'respondedAt' => $r['responded_at'],
        'customerName' => $customerName,
        'customerEmail' => $r['email'],
        'customerContact' => $r['contact_number'],
    ];
}, $rows);

echo json_encode([
    'items' => $items,
    'total' => $total,
    'page' => $page,
    'pageSize' => $pageSize,
    'totalPages' => max(1, (int)ceil($total / $pageSize)),
]);
?>
