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

// Validate required userId
if (!isset($input['userId']) || (int)$input['userId'] <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid user ID']);
    exit;
}

$userId = (int)$input['userId'];

try {
    // Check if user exists and get current data
    $checkSql = "SELECT u.*, cas.*
                 FROM users u
                 LEFT JOIN customer_admin_settings cas ON cas.user_id = u.user_id
                 WHERE u.user_id = :userId";
    $checkStmt = $pdo->prepare($checkSql);
    $checkStmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $checkStmt->execute();
    $currentData = $checkStmt->fetch(PDO::FETCH_ASSOC);

    if (!$currentData) {
        http_response_code(404);
        echo json_encode(['error' => 'User not found']);
        exit;
    }

    // Start transaction
    $pdo->beginTransaction();

    // Track changes for logging
    $changes = [];

    // ====== UPDATE USERS TABLE ======
    $userUpdateFields = [];
    $userParams = [':userId' => $userId];

    // Account status / isActive
    if (isset($input['isActive'])) {
        $isActive = filter_var($input['isActive'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
        if ($isActive !== (int)$currentData['isActive']) {
            $userUpdateFields[] = 'isActive = :isActive';
            $userParams[':isActive'] = $isActive;
            $changes['isActive'] = ['old' => (int)$currentData['isActive'], 'new' => $isActive];
        }
    }

    if (isset($input['accountStatus'])) {
        // Map account status to isActive field
        $statusMap = [
            'active' => 1,
            'suspended' => 0,
            'banned' => 0,
            'under_review' => 1
        ];

        if (isset($statusMap[$input['accountStatus']])) {
            $isActive = $statusMap[$input['accountStatus']];
            if ($isActive !== (int)$currentData['isActive']) {
                $userUpdateFields[] = 'isActive = :isActive';
                $userParams[':isActive'] = $isActive;
                $changes['accountStatus'] = ['old' => $currentData['isActive'] ? 'active' : 'inactive', 'new' => $input['accountStatus']];
            }
        }
    }

    // Update users table if there are changes
    if (!empty($userUpdateFields)) {
        $userUpdateFields[] = 'updated_at = NOW()';
        $userUpdateSql = "UPDATE users SET " . implode(', ', $userUpdateFields) . " WHERE user_id = :userId";
        $userUpdateStmt = $pdo->prepare($userUpdateSql);
        foreach ($userParams as $key => $value) {
            $userUpdateStmt->bindValue($key, $value);
        }
        $userUpdateStmt->execute();
    }

    // ====== UPDATE/INSERT ADMIN SETTINGS ======
    $adminUpdateFields = [];
    $adminParams = [':userId' => $userId];

    // Customer Type
    if (isset($input['customerType'])) {
        $allowedTypes = ['regular', 'vip', 'wholesale', 'corporate'];
        if (in_array($input['customerType'], $allowedTypes)) {
            $adminUpdateFields[] = 'customer_type = :customerType';
            $adminParams[':customerType'] = $input['customerType'];
            if ($currentData['customer_type'] !== $input['customerType']) {
                $changes['customerType'] = ['old' => $currentData['customer_type'], 'new' => $input['customerType']];
            }
        }
    }

    // Credit Limit
    if (isset($input['creditLimit'])) {
        $creditLimit = max(0, (float)$input['creditLimit']);
        $adminUpdateFields[] = 'credit_limit = :creditLimit';
        $adminParams[':creditLimit'] = $creditLimit;
        if ((float)$currentData['credit_limit'] !== $creditLimit) {
            $changes['creditLimit'] = ['old' => (float)$currentData['credit_limit'], 'new' => $creditLimit];
        }

        // Update available credit
        $adminUpdateFields[] = 'available_credit = :creditLimit';
    }

    // Discount Rate
    if (isset($input['discountRate'])) {
        $discountRate = max(0, min(100, (float)$input['discountRate']));
        $adminUpdateFields[] = 'discount_rate = :discountRate';
        $adminParams[':discountRate'] = $discountRate;
        if ((float)$currentData['discount_rate'] !== $discountRate) {
            $changes['discountRate'] = ['old' => (float)$currentData['discount_rate'], 'new' => $discountRate];
        }
    }

    // Payment Terms
    if (isset($input['paymentTerms'])) {
        $allowedTerms = ['immediate', 'net7', 'net15', 'net30', 'net60'];
        if (in_array($input['paymentTerms'], $allowedTerms)) {
            $adminUpdateFields[] = 'payment_terms = :paymentTerms';
            $adminParams[':paymentTerms'] = $input['paymentTerms'];
            if ($currentData['payment_terms'] !== $input['paymentTerms']) {
                $changes['paymentTerms'] = ['old' => $currentData['payment_terms'], 'new' => $input['paymentTerms']];
            }
        }
    }

    // Sales Representative
    if (isset($input['salesRepId'])) {
        $salesRepId = $input['salesRepId'] === '' || $input['salesRepId'] === null ? null : (int)$input['salesRepId'];
        $adminUpdateFields[] = 'sales_rep_id = :salesRepId';
        $adminParams[':salesRepId'] = $salesRepId;
        if ($currentData['sales_rep_id'] !== $salesRepId) {
            $changes['salesRepId'] = ['old' => $currentData['sales_rep_id'], 'new' => $salesRepId];
        }
    }

    // Permissions
    $permissions = [
        'allowBulkOrders' => 'allow_bulk_orders',
        'allowCreditPurchases' => 'allow_credit_purchases',
        'requireOrderApproval' => 'require_order_approval',
        'blockNewOrders' => 'block_new_orders',
        'receiveMarketingEmails' => 'receive_marketing_emails',
        'accessWholesalePrices' => 'access_wholesale_prices'
    ];

    foreach ($permissions as $inputKey => $dbColumn) {
        if (isset($input[$inputKey])) {
            $value = filter_var($input[$inputKey], FILTER_VALIDATE_BOOLEAN) ? 1 : 0;
            $adminUpdateFields[] = "$dbColumn = :$inputKey";
            $adminParams[":$inputKey"] = $value;
            if ((int)$currentData[$dbColumn] !== $value) {
                $changes[$inputKey] = ['old' => (int)$currentData[$dbColumn], 'new' => $value];
            }
        }
    }

    // Admin Notes
    if (isset($input['adminNotes'])) {
        $adminNotes = trim($input['adminNotes']);
        $adminUpdateFields[] = 'admin_notes = :adminNotes';
        $adminParams[':adminNotes'] = $adminNotes;
        if ($currentData['admin_notes'] !== $adminNotes) {
            $changes['adminNotes'] = ['old' => $currentData['admin_notes'], 'new' => $adminNotes];
        }
    }

    // Update or insert admin settings
    if (!empty($adminUpdateFields)) {
        if ($currentData['setting_id']) {
            // Update existing settings
            $adminUpdateFields[] = 'updated_at = NOW()';
            $adminUpdateSql = "UPDATE customer_admin_settings SET " . implode(', ', $adminUpdateFields) . " WHERE user_id = :userId";
        } else {
            // Insert new settings - need to add default values
            $defaultFields = [
                'customer_type' => 'regular',
                'credit_limit' => 0,
                'discount_rate' => 0,
                'payment_terms' => 'immediate',
                'sales_rep_id' => null,
                'allow_bulk_orders' => 1,
                'allow_credit_purchases' => 0,
                'require_order_approval' => 0,
                'block_new_orders' => 0,
                'receive_marketing_emails' => 1,
                'access_wholesale_prices' => 0,
                'outstanding_balance' => 0,
                'available_credit' => 0,
                'admin_notes' => ''
            ];

            // Merge defaults with provided values
            foreach ($defaultFields as $field => $default) {
                if (!isset($adminParams[":$field"]) && !in_array("$field = :$field", $adminUpdateFields)) {
                    $adminUpdateFields[] = "$field = :$field";
                    $adminParams[":$field"] = $default;
                }
            }

            $columns = [];
            $placeholders = [];
            foreach ($adminUpdateFields as $field) {
                $parts = explode(' = ', $field);
                $columns[] = $parts[0];
                $placeholders[] = $parts[1];
            }

            $columns[] = 'user_id';
            $placeholders[] = ':userId';

            $adminUpdateSql = "INSERT INTO customer_admin_settings (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $placeholders) . ")";
        }

        $adminUpdateStmt = $pdo->prepare($adminUpdateSql);
        foreach ($adminParams as $key => $value) {
            $adminUpdateStmt->bindValue($key, $value);
        }
        $adminUpdateStmt->execute();
    }

    // Commit transaction
    $pdo->commit();

    // Fetch updated user data
    $fetchSql = "SELECT u.user_id, u.username, u.email, u.first_name, u.middle_name, u.last_name,
                        u.contact_number, u.address, u.created_at, u.updated_at, u.isActive,
                        c.city_name, p.province_name,
                        cas.*
                 FROM users u
                 LEFT JOIN cities c ON c.city_id = u.city_id
                 LEFT JOIN provinces p ON p.province_id = u.province_id
                 LEFT JOIN customer_admin_settings cas ON cas.user_id = u.user_id
                 WHERE u.user_id = :userId";

    $fetchStmt = $pdo->prepare($fetchSql);
    $fetchStmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $fetchStmt->execute();
    $user = $fetchStmt->fetch(PDO::FETCH_ASSOC);

    // Format response
    $fullName = trim(implode(' ', array_filter([
        $user['first_name'],
        $user['middle_name'],
        $user['last_name']
    ])));

    $location = '';
    if ($user['city_name']) {
        $location = $user['city_name'];
        if ($user['province_name']) {
            $location .= ', ' . $user['province_name'];
        }
    }

    $response = [
        'success' => true,
        'message' => 'Customer updated successfully',
        'changes' => $changes,
        'user' => [
            'id' => (int)$user['user_id'],
            'username' => $user['username'] ?? '',
            'email' => $user['email'],
            'name' => $fullName,
            'firstName' => $user['first_name'],
            'middleName' => $user['middle_name'] ?? '',
            'lastName' => $user['last_name'],
            'contactNumber' => $user['contact_number'],
            'address' => $user['address'],
            'location' => $location,
            'cityName' => $user['city_name'] ?? '',
            'provinceName' => $user['province_name'] ?? '',
            'createdAt' => $user['created_at'],
            'updatedAt' => $user['updated_at'],
            'isActive' => (int)$user['isActive'] === 1,
            'adminSettings' => [
                'customerType' => $user['customer_type'] ?? 'regular',
                'creditLimit' => (float)($user['credit_limit'] ?? 0),
                'discountRate' => (float)($user['discount_rate'] ?? 0),
                'paymentTerms' => $user['payment_terms'] ?? 'immediate',
                'salesRepId' => $user['sales_rep_id'],
                'permissions' => [
                    'allowBulkOrders' => (bool)($user['allow_bulk_orders'] ?? 1),
                    'allowCreditPurchases' => (bool)($user['allow_credit_purchases'] ?? 0),
                    'requireOrderApproval' => (bool)($user['require_order_approval'] ?? 0),
                    'blockNewOrders' => (bool)($user['block_new_orders'] ?? 0),
                    'receiveMarketingEmails' => (bool)($user['receive_marketing_emails'] ?? 1),
                    'accessWholesalePrices' => (bool)($user['access_wholesale_prices'] ?? 0)
                ],
                'outstandingBalance' => (float)($user['outstanding_balance'] ?? 0),
                'availableCredit' => (float)($user['available_credit'] ?? 0),
                'adminNotes' => $user['admin_notes'] ?? ''
            ]
        ]
    ];

    echo json_encode($response);

} catch (PDOException $e) {
    // Rollback transaction on error
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    http_response_code(500);
    echo json_encode([
        'error' => 'Database error',
        'message' => 'Failed to update customer',
        'details' => $e->getMessage()
    ]);
    error_log("Customer update error: " . $e->getMessage());
} catch (Exception $e) {
    // Rollback transaction on any error
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    http_response_code(500);
    echo json_encode([
        'error' => 'Server error',
        'message' => 'An unexpected error occurred',
        'details' => $e->getMessage()
    ]);
    error_log("Customer update error: " . $e->getMessage());
}
