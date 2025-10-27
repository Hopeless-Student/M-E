<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../../config/config.php';

$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$pageSize = isset($_GET['pageSize']) ? min(100, max(1, (int)$_GET['pageSize'])) : 12;
$q = trim($_GET['q'] ?? '');
$status = trim($_GET['status'] ?? ''); // active|inactive|verified|unverified
$sortBy = trim($_GET['sortBy'] ?? 'created_at'); // created_at|name|email|last_order

$offset = ($page - 1) * $pageSize;

$where = ['u.isActive = 1'];
$params = [];

if ($q !== '') {
    $where[] = '(u.first_name LIKE :q OR u.last_name LIKE :q OR u.email LIKE :q OR u.username LIKE :q)';
    $params[':q'] = "%$q%";
}

if ($status !== '') {
    if ($status === 'active') {
        $where[] = 'u.isActive = 1';
    } else if ($status === 'inactive') {
        $where[] = 'u.isActive = 0';
    } else if ($status === 'verified') {
        $where[] = 'u.is_verified = 1';
    } else if ($status === 'unverified') {
        $where[] = 'u.is_verified = 0';
    }
}

$whereSql = count($where) ? ('WHERE ' . implode(' AND ', $where)) : '';

// Count
$countSql = "SELECT COUNT(*) FROM users u $whereSql";
$stmt = $pdo->prepare($countSql);
foreach ($params as $k => $v) { $stmt->bindValue($k, $v); }
$stmt->execute();
$total = (int)$stmt->fetchColumn();

// Data with order statistics
$sql = "SELECT u.user_id, u.username, u.email, u.first_name, u.middle_name, u.last_name,
               u.gender, u.date_of_birth, u.is_verified, u.contact_number, u.address,
               u.created_at, u.updated_at, u.isActive, u.profile_image,
               p.province_name, c.city_name,
               COUNT(o.order_id) as total_orders,
               COALESCE(SUM(o.final_amount), 0) as total_spent,
               MAX(o.order_date) as last_order_date
        FROM users u
        LEFT JOIN provinces p ON p.province_id = u.province_id
        LEFT JOIN cities c ON c.city_id = u.city_id
        LEFT JOIN orders o ON o.user_id = u.user_id
        $whereSql
        GROUP BY u.user_id
        ORDER BY ";

// Apply sorting
switch ($sortBy) {
    case 'name':
        $sql .= "u.first_name ASC, u.last_name ASC";
        break;
    case 'email':
        $sql .= "u.email ASC";
        break;
    case 'last_order':
        $sql .= "last_order_date DESC";
        break;
    case 'total_spent':
        $sql .= "total_spent DESC";
        break;
    default:
        $sql .= "u.created_at DESC";
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
    $fullName = trim($r['first_name'] . ' ' . $r['middle_name'] . ' ' . $r['last_name']);
    $location = '';
    if ($r['city_name']) {
        $location = $r['city_name'];
        if ($r['province_name']) {
            $location .= ', ' . $r['province_name'];
        }
    }

    return [
        'id' => (int)$r['user_id'],
        'username' => $r['username'] ?? '',
        'email' => $r['email'],
        'name' => $fullName,
        'firstName' => $r['first_name'],
        'middleName' => $r['middle_name'],
        'lastName' => $r['last_name'],
        'gender' => $r['gender'],
        'dateOfBirth' => $r['date_of_birth'],
        'isVerified' => (int)$r['is_verified'] === 1,
        'contactNumber' => $r['contact_number'],
        'address' => $r['address'],
        'location' => $location,
        'createdAt' => $r['created_at'],
        'updatedAt' => $r['updated_at'],
        'isActive' => (int)$r['isActive'] === 1,
        'profileImage' => $r['profile_image'],
        'totalOrders' => (int)$r['total_orders'],
        'totalSpent' => (float)$r['total_spent'],
        'lastOrderDate' => $r['last_order_date'],
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
