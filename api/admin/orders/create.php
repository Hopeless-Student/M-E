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

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

// Validate required fields
$userId = isset($input['user_id']) ? (int)$input['user_id'] : 0;
$items = isset($input['items']) ? $input['items'] : [];
$shippingFee = isset($input['shipping_fee']) ? (float)$input['shipping_fee'] : 70.00;
$paymentMethod = isset($input['payment_method']) ? trim($input['payment_method']) : 'cod';
$deliveryAddress = isset($input['delivery_address']) ? trim($input['delivery_address']) : '';
$contactNumber = isset($input['contact_number']) ? trim($input['contact_number']) : '';
$specialInstructions = isset($input['special_instructions']) ? trim($input['special_instructions']) : '';
$adminNotes = isset($input['admin_notes']) ? trim($input['admin_notes']) : '';
$orderStatus = isset($input['order_status']) ? trim($input['order_status']) : 'pending';

// Validation
if ($userId <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid customer ID']);
    exit;
}

if (empty($items) || !is_array($items)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Order must contain at least one item']);
    exit;
}

if (empty($deliveryAddress)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Delivery address is required']);
    exit;
}

if (empty($contactNumber)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Contact number is required']);
    exit;
}

// Validate payment method
$allowedPaymentMethods = ['COD', 'Bank Transfer', 'GCash', 'Other'];
if (!in_array($paymentMethod, $allowedPaymentMethods)) {
    $paymentMethod = 'COD';
}

// Validate order status
$allowedStatuses = ['Pending', 'Confirmed', 'Shipped', 'Delivered', 'Cancelled'];
if (!in_array($orderStatus, $allowedStatuses)) {
    $orderStatus = 'Pending';
}

try {
    $pdo->beginTransaction();

    // Verify user exists
    $userCheck = $pdo->prepare("SELECT user_id, first_name, last_name, email FROM users WHERE user_id = :userId AND isActive = 1");
    $userCheck->execute([':userId' => $userId]);
    $user = $userCheck->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        throw new Exception('Customer not found or inactive');
    }

    // Generate unique order number
    $orderPrefix = 'ME';
    $timestamp = date('ymd');
    $random = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
    $orderNumber = $orderPrefix . $timestamp . $random;

    // Check if order number exists (very unlikely, but handle it)
    $checkOrder = $pdo->prepare("SELECT order_id FROM orders WHERE order_number = :orderNumber");
    $checkOrder->execute([':orderNumber' => $orderNumber]);
    if ($checkOrder->fetch()) {
        // Generate a new one with microseconds
        $orderNumber = $orderPrefix . $timestamp . substr(microtime(false), 2, 4);
    }

    // Calculate totals and validate products
    $totalAmount = 0;
    $validatedItems = [];

    foreach ($items as $item) {
        $productId = isset($item['product_id']) ? (int)$item['product_id'] : 0;
        $quantity = isset($item['quantity']) ? (int)$item['quantity'] : 0;

        if ($productId <= 0 || $quantity <= 0) {
            throw new Exception('Invalid product or quantity');
        }

        // Fetch product details
        $productStmt = $pdo->prepare("
            SELECT product_id, product_name, price, stock_quantity 
            FROM products 
            WHERE product_id = :productId AND isActive = 1
        ");
        $productStmt->execute([':productId' => $productId]);
        $product = $productStmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            throw new Exception('Product ID ' . $productId . ' not found or inactive');
        }

        // Check stock availability
        if ($product['stock_quantity'] < $quantity) {
            throw new Exception('Insufficient stock for ' . $product['product_name'] . '. Available: ' . $product['stock_quantity']);
        }

        $price = (float)$product['price'];
        $subtotal = $price * $quantity;
        $totalAmount += $subtotal;

        $validatedItems[] = [
            'product_id' => $product['product_id'],
            'product_name' => $product['product_name'],
            'product_price' => $price,
            'quantity' => $quantity,
            'subtotal' => $subtotal
        ];
    }

    $finalAmount = $totalAmount + $shippingFee;

    // Insert order
    $orderSql = "INSERT INTO orders (
        user_id, order_number, total_amount, shipping_fee, final_amount,
        payment_method, order_status, delivery_address, contact_number,
        special_instructions, admin_notes, order_date
    ) VALUES (
        :userId, :orderNumber, :totalAmount, :shippingFee, :finalAmount,
        :paymentMethod, :orderStatus, :deliveryAddress, :contactNumber,
        :specialInstructions, :adminNotes, NOW()
    )";

    $orderStmt = $pdo->prepare($orderSql);
    $orderStmt->execute([
        ':userId' => $userId,
        ':orderNumber' => $orderNumber,
        ':totalAmount' => $totalAmount,
        ':shippingFee' => $shippingFee,
        ':finalAmount' => $finalAmount,
        ':paymentMethod' => $paymentMethod,
        ':orderStatus' => $orderStatus,
        ':deliveryAddress' => $deliveryAddress,
        ':contactNumber' => $contactNumber,
        ':specialInstructions' => $specialInstructions,
        ':adminNotes' => $adminNotes
    ]);

    $orderId = (int)$pdo->lastInsertId();

    // Insert order items
    $itemSql = "INSERT INTO order_items (
        order_id, product_id, product_name, product_price, quantity, subtotal
    ) VALUES (
        :orderId, :productId, :productName, :productPrice, :quantity, :subtotal
    )";
    $itemStmt = $pdo->prepare($itemSql);

    foreach ($validatedItems as $item) {
        $itemStmt->execute([
            ':orderId' => $orderId,
            ':productId' => $item['product_id'],
            ':productName' => $item['product_name'],
            ':productPrice' => $item['product_price'],
            ':quantity' => $item['quantity'],
            ':subtotal' => $item['subtotal']
        ]);
    }

    // If order is confirmed, update stock immediately
    if ($orderStatus === 'Confirmed') {
        foreach ($validatedItems as $item) {
            $updateStockSql = "UPDATE products 
                              SET stock_quantity = stock_quantity - :quantity 
                              WHERE product_id = :productId";
            $updateStockStmt = $pdo->prepare($updateStockSql);
            $updateStockStmt->execute([
                ':quantity' => $item['quantity'],
                ':productId' => $item['product_id']
            ]);

            // Log stock movement
            $movementSql = "INSERT INTO stock_movements (
                product_id, movement_type, quantity, previous_stock, new_stock,
                reason, user_name, created_at
            ) SELECT 
                :productId, 'remove', :quantity, stock_quantity + :quantity, stock_quantity,
                :reason, :userName, NOW()
            FROM products WHERE product_id = :productId";
            
            $movementStmt = $pdo->prepare($movementSql);
            $movementStmt->execute([
                ':productId' => $item['product_id'],
                ':quantity' => -$item['quantity'],
                ':reason' => 'Manual Order: ' . $orderNumber,
                ':userName' => $_SESSION['admin_username'] ?? 'Admin'
            ]);
        }
    }

    $pdo->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Order created successfully',
        'order' => [
            'order_id' => $orderId,
            'order_number' => $orderNumber,
            'customer_name' => $user['first_name'] . ' ' . $user['last_name'],
            'customer_email' => $user['email'],
            'total_amount' => $totalAmount,
            'shipping_fee' => $shippingFee,
            'final_amount' => $finalAmount,
            'order_status' => $orderStatus,
            'items_count' => count($validatedItems)
        ]
    ]);

} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
