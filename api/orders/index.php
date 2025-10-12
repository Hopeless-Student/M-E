<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../config/config.php';

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

echo json_encode([
    'status' => 'ok',
    'message' => 'Orders API root',
    'method' => $method,
    'endpoints' => [
        'GET /api/orders' => 'List orders with pagination and filters',
        'GET /api/orders/show.php?id=...' => 'Get single order with items',
        'POST /api/orders/create.php' => 'Create order and items',
        'PATCH /api/orders/update-status.php' => 'Update order status/payment',
        'GET /api/orders/items.php?order_id=...' => 'List items for an order',
        'GET /api/orders/user.php?user_id=...' => 'List orders for a user',
    ],
]);
?>


