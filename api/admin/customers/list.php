<?php


header('Content-Type: application/json');
require_once __DIR__ . '/../../../config/config.php';
// require_once __DIR__ . '/../auth_check.php';
//
//
// $admin = requireAdminAuth();

// Validate and sanitize parameters
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$pageSize = isset($_GET['pageSize']) ? min(100, max(1, (int)$_GET['pageSize'])) : 8;
$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$status = isset($_GET['status']) ? trim($_GET['status']) : '';
$location = isset($_GET['location']) ? trim($_GET['location']) : '';
$sortBy = isset($_GET['sortBy']) ? trim($_GET['sortBy']) : 'created_at';

// Validate sortBy to prevent SQL injection
$allowedSorts = ['created_at', 'name', 'email', 'last_order', 'total_spent'];
if (!in_array($sortBy, $allowedSorts)) {
    $sortBy = 'created_at';
}

// Validate status
$allowedStatuses = ['active', 'inactive', 'new'];
if ($status !== '' && !in_array($status, $allowedStatuses)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid status filter']);
    exit;
}

$offset = ($page - 1) * $pageSize;

try {
    // Build WHERE clause
    $where = ['1=1']; // Always true to simplify AND logic
    $params = [];

    // Search filter
    if ($q !== '') {
        $where[] = '(u.first_name LIKE :q OR u.last_name LIKE :q OR u.email LIKE :q OR u.username LIKE :q)';
        $params[':q'] = "%$q%";
    }

    // Location filter
    if ($location !== '') {
        $where[] = '(c.city_name LIKE :location OR p.province_name LIKE :location)';
        $params[':location'] = "%$location%";
    }

    // Status filter - note: we determine status in application logic
    // For database filtering, we can only filter by isActive
    if ($status === 'inactive') {
        $where[] = 'u.isActive = 0';
    } else if ($status === 'active' || $status === 'new') {
        $where[] = 'u.isActive = 1';
    }

    $whereSql = 'WHERE ' . implode(' AND ', $where);

    // Count total
    $countSql = "SELECT COUNT(DISTINCT u.user_id) FROM users u
                 LEFT JOIN provinces p ON p.province_id = u.province_id
                 LEFT JOIN cities c ON c.city_id = u.city_id
                 $whereSql";

    $countStmt = $pdo->prepare($countSql);
    foreach ($params as $k => $v) {
        $countStmt->bindValue($k, $v);
    }
    $countStmt->execute();
    $total = (int)$countStmt->fetchColumn();

    // Fetch data with order statistics
    $sql = "SELECT u.user_id, u.username, u.email, u.first_name, u.middle_name, u.last_name,
                   u.gender, u.date_of_birth, u.is_verified, u.contact_number, u.address,
                   u.created_at, u.updated_at, u.isActive, u.profile_image,
                   p.province_name, c.city_name,
                   COUNT(DISTINCT o.order_id) as total_orders,
                   COALESCE(SUM(o.final_amount), 0) as total_spent,
                   MAX(o.order_date) as last_order_date
            FROM users u
            LEFT JOIN provinces p ON p.province_id = u.province_id
            LEFT JOIN cities c ON c.city_id = u.city_id
            LEFT JOIN orders o ON o.user_id = u.user_id
            $whereSql
            GROUP BY u.user_id, u.username, u.email, u.first_name, u.middle_name, u.last_name,
                     u.gender, u.date_of_birth, u.is_verified, u.contact_number, u.address,
                     u.created_at, u.updated_at, u.isActive, u.profile_image,
                     p.province_name, c.city_name
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
            $sql .= "last_order_date DESC NULLS LAST";
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
    foreach ($params as $k => $v) {
        $stmt->bindValue($k, $v);
    }
    $stmt->bindValue(':limit', $pageSize, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Format items
    $items = array_map(function ($r) use ($status) {
        $fullName = trim(implode(' ', array_filter([
            $r['first_name'],
            $r['middle_name'],
            $r['last_name']
        ])));

        $location = '';
        if ($r['city_name']) {
            $location = $r['city_name'];
            if ($r['province_name']) {
                $location .= ', ' . $r['province_name'];
            }
        }

        // Calculate days since last order
        $daysSinceLastOrder = null;
        if ($r['last_order_date']) {
            $lastOrderDate = new DateTime($r['last_order_date']);
            $now = new DateTime();
            $daysSinceLastOrder = $now->diff($lastOrderDate)->days;
        }

        // Determine status
        $itemStatus = 'active';
        if (!(int)$r['isActive']) {
            $itemStatus = 'inactive';
        } else if ((int)$r['total_orders'] === 0) {
            $itemStatus = 'new';
        } else if ($daysSinceLastOrder && $daysSinceLastOrder > 60) {
            $itemStatus = 'inactive';
        }

        // Apply status filter at application level for 'new' status
        if ($status === 'new' && $itemStatus !== 'new') {
            return null;
        }
        if ($status === 'active' && $itemStatus !== 'active') {
            return null;
        }

        // Format member since
        $createdDate = new DateTime($r['created_at']);
        $memberSince = $createdDate->format('M Y');

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
            'memberSince' => $memberSince,
            'isActive' => (int)$r['isActive'] === 1,
            'profileImage' => $r['profile_image'],
            'totalOrders' => (int)$r['total_orders'],
            'totalSpent' => (float)$r['total_spent'],
            'lastOrderDate' => $r['last_order_date'],
            'status' => $itemStatus
        ];
    }, $rows);

    // Filter out null items (from status filtering)
    $items = array_values(array_filter($items));

    // Recalculate total if status filtering removed items
    if ($status !== '' && $status !== 'inactive') {
        $total = count($items);
    }

    echo json_encode([
        'items' => $items,
        'total' => $total,
        'page' => $page,
        'pageSize' => $pageSize,
        'totalPages' => max(1, (int)ceil($total / $pageSize)),
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Database error',
        'message' => 'Failed to fetch customers'
    ]);
    error_log("Customer list error: " . $e->getMessage());
}
