<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../../config/config.php';

// Require admin session
session_start();
if (!isset($_SESSION['admin_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

$query = isset($_GET['q']) ? trim($_GET['q']) : '';
$limit = isset($_GET['limit']) ? min(20, max(1, (int)$_GET['limit'])) : 10;

if (empty($query)) {
    echo json_encode(['success' => true, 'customers' => []]);
    exit;
}

try {
    $sql = "SELECT u.user_id, u.first_name, u.middle_name, u.last_name, u.email, 
                   u.contact_number, u.address,
                   c.city_name, p.province_name
            FROM users u
            LEFT JOIN cities c ON c.city_id = u.city_id
            LEFT JOIN provinces p ON p.province_id = u.province_id
            WHERE u.isActive = 1
              AND (u.first_name LIKE :query 
                   OR u.last_name LIKE :query 
                   OR u.email LIKE :query
                   OR u.contact_number LIKE :query
                   OR CONCAT(u.first_name, ' ', u.last_name) LIKE :query)
            ORDER BY u.first_name, u.last_name
            LIMIT :limit";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':query', "%$query%", PDO::PARAM_STR);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $customers = array_map(function($r) {
        $middleInitial = !empty($r['middle_name']) ? ' ' . substr($r['middle_name'], 0, 1) . '.' : '';
        $fullName = $r['first_name'] . $middleInitial . ' ' . $r['last_name'];
        
        $location = '';
        if (!empty($r['city_name']) && !empty($r['province_name'])) {
            $location = $r['city_name'] . ', ' . $r['province_name'];
        } elseif (!empty($r['city_name'])) {
            $location = $r['city_name'];
        } elseif (!empty($r['province_name'])) {
            $location = $r['province_name'];
        }

        return [
            'id' => (int)$r['user_id'],
            'name' => $fullName,
            'email' => $r['email'],
            'contact_number' => $r['contact_number'] ?? '',
            'address' => $r['address'] ?? '',
            'location' => $location
        ];
    }, $rows);

    echo json_encode([
        'success' => true,
        'customers' => $customers
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Error searching customers'
    ]);
}
