<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../../config/config.php';

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON input']);
    exit;
}

$userId = isset($input['userId']) ? (int)$input['userId'] : 0;

if ($userId <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid user ID']);
    exit;
}

try {
    // Check if user exists
    $checkSql = "SELECT user_id FROM users WHERE user_id = :userId";
    $checkStmt = $pdo->prepare($checkSql);
    $checkStmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $checkStmt->execute();

    if (!$checkStmt->fetch()) {
        http_response_code(404);
        echo json_encode(['error' => 'User not found']);
        exit;
    }

    // Build update query based on provided fields
    $updateFields = [];
    $params = [':userId' => $userId];

    // Admin-modifiable fields based on schema
    if (isset($input['isActive'])) {
        $updateFields[] = 'is_active = :isActive';
        $params[':isActive'] = $input['isActive'] ? 1 : 0;
    }

    if (isset($input['accountStatus'])) {
        // Map account status to is_active field
        $isActive = in_array($input['accountStatus'], ['active', 'under_review']) ? 1 : 0;
        $updateFields[] = 'is_active = :isActive';
        $params[':isActive'] = $isActive;
    }

    // Note: Based on the schema, users table only has basic fields
    // Additional admin settings like customer type, credit limit, etc.
    // would need to be stored in a separate admin_users table or similar

    if (empty($updateFields)) {
        http_response_code(400);
        echo json_encode(['error' => 'No fields to update']);
        exit;
    }

    // Add updated_at timestamp
    $updateFields[] = 'updated_at = NOW()';

    // Build and execute update query
    $updateSql = "UPDATE users SET " . implode(', ', $updateFields) . " WHERE user_id = :userId";
    $updateStmt = $pdo->prepare($updateSql);

    foreach ($params as $key => $value) {
        $updateStmt->bindValue($key, $value);
    }

    $updateStmt->execute();

    // Fetch updated user data
    $fetchSql = "SELECT u.user_id, u.username, u.email, u.first_name, u.last_name,
                        u.contact_number, u.address, u.city,
                        u.created_at, u.updated_at, u.is_active
                 FROM users u
                 WHERE u.user_id = :userId";

    $fetchStmt = $pdo->prepare($fetchSql);
    $fetchStmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $fetchStmt->execute();
    $user = $fetchStmt->fetch(PDO::FETCH_ASSOC);

    // Format response
    $fullName = trim($user['first_name'] . ' ' . $user['last_name']);
    $location = $user['city'] ?? '';

    $response = [
        'success' => true,
        'message' => 'User updated successfully',
        'user' => [
            'id' => (int)$user['user_id'],
            'username' => $user['username'] ?? '',
            'email' => $user['email'],
            'name' => $fullName,
            'firstName' => $user['first_name'],
            'lastName' => $user['last_name'],
            'contactNumber' => $user['contact_number'],
            'address' => $user['address'],
            'location' => $location,
            'city' => $user['city'],
            'createdAt' => $user['created_at'],
            'updatedAt' => $user['updated_at'],
            'isActive' => (int)$user['is_active'] === 1
        ]
    ];

    echo json_encode($response);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
