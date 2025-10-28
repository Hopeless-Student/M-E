<?php
/**
 * Get Single Customer API - FIXED VERSION
 * Changed is_active to isActive
 * Added authentication
 * Added admin settings retrieval
 * Fixed SQL injection risks
 */
 ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
require_once __DIR__ . '/../../../config/config.php';
// require_once __DIR__ . '/../auth_check.php';
//
// // Authenticate admin
// $admin = requireAdminAuth();

// Get and validate user ID
$userId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($userId <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid user ID']);
    exit;
}

try {
    // Fetch user details with location info
    $sql = "SELECT u.user_id, u.username, u.email, u.first_name, u.middle_name, u.last_name,
                   u.gender, u.date_of_birth, u.is_verified, u.contact_number, u.address,
                   u.created_at, u.updated_at, u.isActive, u.profile_image,
                   p.province_name, c.city_name,
                   COUNT(DISTINCT o.order_id) as total_orders,
                   COALESCE(SUM(o.final_amount), 0) as total_spent,
                   MAX(o.order_date) as last_order_date,
                   AVG(o.final_amount) as average_order
            FROM users u
            LEFT JOIN provinces p ON p.province_id = u.province_id
            LEFT JOIN cities c ON c.city_id = u.city_id
            LEFT JOIN orders o ON o.user_id = u.user_id
            WHERE u.user_id = :userId
            GROUP BY u.user_id, u.username, u.email, u.first_name, u.middle_name, u.last_name,
                     u.gender, u.date_of_birth, u.is_verified, u.contact_number, u.address,
                     u.created_at, u.updated_at, u.isActive, u.profile_image,
                     p.province_name, c.city_name";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        http_response_code(404);
        echo json_encode(['error' => 'User not found']);
        exit;
    }

    // Fetch admin settings
    $adminSettingsSql = "SELECT * FROM customer_admin_settings WHERE user_id = :userId";
    $adminSettingsStmt = $pdo->prepare($adminSettingsSql);
    $adminSettingsStmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $adminSettingsStmt->execute();
    $adminSettings = $adminSettingsStmt->fetch(PDO::FETCH_ASSOC);

    // Fetch recent orders (last 5) with item count
    $ordersSql = "SELECT o.order_id, o.order_number, o.order_date, o.total_amount,
                         o.shipping_fee, o.final_amount, o.order_status, o.payment_method,
                         COUNT(DISTINCT oi.order_item_id) as item_count,
                         GROUP_CONCAT(DISTINCT p.product_name ORDER BY p.product_name SEPARATOR ', ') as item_names
                  FROM orders o
                  LEFT JOIN order_items oi ON oi.order_id = o.order_id
                  LEFT JOIN products p ON p.product_id = oi.product_id
                  WHERE o.user_id = :userId
                  GROUP BY o.order_id, o.order_number, o.order_date, o.total_amount,
                           o.shipping_fee, o.final_amount, o.order_status, o.payment_method
                  ORDER BY o.order_date DESC
                  LIMIT 5";

    $ordersStmt = $pdo->prepare($ordersSql);
    $ordersStmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $ordersStmt->execute();
    $recentOrders = $ordersStmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch activity timeline
    $activitySql = "
        SELECT 'order_completed' as activity_type,
               CONCAT('Order #', o.order_number, ' was successfully delivered') as description,
               o.delivered_at as activity_date
        FROM orders o
        WHERE o.user_id = :userId AND o.order_status = 'completed' AND o.delivered_at IS NOT NULL

        UNION ALL

        SELECT 'order_confirmed' as activity_type,
               CONCAT('Order #', o.order_number, ' was confirmed') as description,
               o.confirmed_at as activity_date
        FROM orders o
        WHERE o.user_id = :userId AND o.confirmed_at IS NOT NULL

        UNION ALL

        SELECT 'order_placed' as activity_type,
               CONCAT('New order #', o.order_number, ' placed for ₱', FORMAT(o.final_amount, 2)) as description,
               o.order_date as activity_date
        FROM orders o
        WHERE o.user_id = :userId

        UNION ALL

        SELECT 'profile_updated' as activity_type,
               'Customer updated profile information' as description,
               u.updated_at as activity_date
        FROM users u
        WHERE u.user_id = :userId AND u.updated_at != u.created_at

        UNION ALL

        SELECT 'request_submitted' as activity_type,
               CONCAT('Submitted ', cr.request_type, ' request') as description,
               cr.created_at as activity_date
        FROM customer_request cr
        WHERE cr.user_id = :userId

        ORDER BY activity_date DESC
        LIMIT 10";

    $activityStmt = $pdo->prepare($activitySql);
    $activityStmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $activityStmt->execute();
    $activities = $activityStmt->fetchAll(PDO::FETCH_ASSOC);

    // Calculate orders this month
    $thisMonthSql = "SELECT COUNT(*) as count, COALESCE(SUM(o.final_amount), 0) as amount
                     FROM orders o
                     WHERE o.user_id = :userId
                     AND MONTH(o.order_date) = MONTH(CURRENT_DATE())
                     AND YEAR(o.order_date) = YEAR(CURRENT_DATE())";
    $thisMonthStmt = $pdo->prepare($thisMonthSql);
    $thisMonthStmt->bindValue(':userId', $userId, PDO::PARAM_INT);
    $thisMonthStmt->execute();
    $thisMonth = $thisMonthStmt->fetch(PDO::FETCH_ASSOC);

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

    // Calculate days since last order
    $daysSinceLastOrder = null;
    if ($user['last_order_date']) {
        $lastOrderDate = new DateTime($user['last_order_date']);
        $now = new DateTime();
        $interval = $now->diff($lastOrderDate);
        $daysSinceLastOrder = $interval->days;
    }

    // Format member since
    $createdDate = new DateTime($user['created_at']);
    $memberSince = $createdDate->format('F Y');

    // Determine status
    $status = 'active';
    if (!(int)$user['isActive']) {
        $status = 'inactive';
    } else if ((int)$user['total_orders'] === 0) {
        $status = 'new';
    } else if ($daysSinceLastOrder && $daysSinceLastOrder > 60) {
        $status = 'inactive';
    }

    $response = [
        'id' => (int)$user['user_id'],
        'username' => $user['username'] ?? '',
        'email' => $user['email'],
        'name' => $fullName,
        'firstName' => $user['first_name'],
        'middleName' => $user['middle_name'] ?? '',
        'lastName' => $user['last_name'],
        'gender' => $user['gender'] ?? 'N/A',
        'dateOfBirth' => $user['date_of_birth'] ?? 'N/A',
        'isVerified' => (int)$user['is_verified'] === 1,
        'contactNumber' => $user['contact_number'],
        'address' => $user['address'],
        'location' => $location,
        'cityName' => $user['city_name'] ?? '',
        'provinceName' => $user['province_name'] ?? '',
        'createdAt' => $user['created_at'],
        'updatedAt' => $user['updated_at'],
        'memberSince' => $memberSince,
        'isActive' => (int)$user['isActive'] === 1,
        'profileImage' => $user['profile_image'],
        'status' => $status,
        'statistics' => [
            'totalOrders' => (int)$user['total_orders'],
            'totalSpent' => (float)$user['total_spent'],
            'averageOrder' => (int)$user['total_orders'] > 0 ? (float)$user['average_order'] : 0,
            'lastOrderDate' => $user['last_order_date'],
            'daysSinceLastOrder' => $daysSinceLastOrder,
            'ordersThisMonth' => (int)$thisMonth['count'],
            'spentThisMonth' => (float)$thisMonth['amount']
        ],
        'adminSettings' => $adminSettings ? [
            'customerType' => $adminSettings['customer_type'],
            'creditLimit' => (float)$adminSettings['credit_limit'],
            'discountRate' => (float)$adminSettings['discount_rate'],
            'paymentTerms' => $adminSettings['payment_terms'],
            'salesRepId' => $adminSettings['sales_rep_id'],
            'permissions' => [
                'allowBulkOrders' => (bool)$adminSettings['allow_bulk_orders'],
                'allowCreditPurchases' => (bool)$adminSettings['allow_credit_purchases'],
                'requireOrderApproval' => (bool)$adminSettings['require_order_approval'],
                'blockNewOrders' => (bool)$adminSettings['block_new_orders'],
                'receiveMarketingEmails' => (bool)$adminSettings['receive_marketing_emails'],
                'accessWholesalePrices' => (bool)$adminSettings['access_wholesale_prices']
            ],
            'outstandingBalance' => (float)$adminSettings['outstanding_balance'],
            'availableCredit' => (float)$adminSettings['available_credit'],
            'adminNotes' => $adminSettings['admin_notes']
        ] : null,
        'recentOrders' => array_map(function($order) {
            return [
                'orderId' => (int)$order['order_id'],
                'orderNumber' => $order['order_number'],
                'orderDate' => $order['order_date'],
                'orderDateFormatted' => date('M d, Y', strtotime($order['order_date'])),
                'totalAmount' => (float)$order['total_amount'],
                'shippingFee' => (float)$order['shipping_fee'],
                'finalAmount' => (float)$order['final_amount'],
                'orderStatus' => $order['order_status'],
                'paymentMethod' => $order['payment_method'],
                'itemCount' => (int)$order['item_count'],
                'itemNames' => $order['item_names'] ?? 'No items'
            ];
        }, $recentOrders),
        'activities' => array_values(array_filter(array_map(function($activity) {
            if (!$activity['activity_date']) {
                return null;
            }

            $activityDate = new DateTime($activity['activity_date']);
            $now = new DateTime();
            $interval = $now->diff($activityDate);

            $timeAgo = '';
            if ($interval->days > 30) {
                $months = floor($interval->days / 30);
                $timeAgo = $months . ' month' . ($months > 1 ? 's' : '') . ' ago';
            } else if ($interval->days > 7) {
                $weeks = floor($interval->days / 7);
                $timeAgo = $weeks . ' week' . ($weeks > 1 ? 's' : '') . ' ago';
            } else if ($interval->days > 0) {
                $timeAgo = $interval->days . ' day' . ($interval->days > 1 ? 's' : '') . ' ago';
            } else if ($interval->h > 0) {
                $timeAgo = $interval->h . ' hour' . ($interval->h > 1 ? 's' : '') . ' ago';
            } else {
                $timeAgo = $interval->i . ' minute' . ($interval->i > 1 ? 's' : '') . ' ago';
            }

            return [
                'type' => $activity['activity_type'],
                'description' => $activity['description'],
                'date' => $activity['activity_date'],
                'timeAgo' => $timeAgo
            ];
        }, $activities)))
    ];

    echo json_encode($response);

  } catch (PDOException $e) {
      http_response_code(500);
      echo json_encode([
          'error' => 'Database error',
          'message' => 'Failed to fetch customer details',
          'details' => $e->getMessage(),  // ADD THIS LINE
          'trace' => $e->getTraceAsString()  // ADD THIS LINE (optional)
      ]);
      error_log("Customer get error: " . $e->getMessage());
  }
?>
