<?php
// THIS IS THE INITIAL MOVEMENT OF DATA: FROM CART TO ORDERS TO ORDER ITEMS SEP 25 2025 BEFORE REFACTOR
require_once __DIR__ .'/../includes/database.php';
require_once __DIR__ .'/../auth/auth.php';
require_once __DIR__ .'/paymongo.php';

$pdo = connect();
$user_id = $user['user_id'];

try {
    $pdo->beginTransaction();
    // galing sa cart --> transfer kay order table: state na binigay na kay cashier yung item
    $insertToOrder = "INSERT INTO orders(user_id, order_number, total_amount,
                                        shipping_fee, final_amount, payment_method,
                                        order_status, delivery_address, contact_number,
                                        special_instructions, confirmed_at, admin_notes)
                      VALUES(:user_id, :order_number, :total_amount,
                      :shipping_fee, :final_amount, :payment_method,
                      :order_status, :delivery_address, :contact_number,
                      :special_instructions, :confirmed_at, :admin_notes)";
      $insertStmt = $pdo->prepare($insertToOrder);
      $insertStmt->execute([
        ':user_id'=>$user_id,
        ':order_number'=>'ORD-' . date("YmdHis"). '-' .  uniqid(),
        ':total_amount'=>0,
        ':shipping_fee'=>0.00,
        ':final_amount'=>0,
        ':payment_method'=>'COD',
        ':order_status'=>'Pending',
        ':delivery_address'=>$user['address'],
        ':contact_number'=>$user['contact_number'],
        ':special_instructions'=>null,
        ':confirmed_at'=>null,
        ':admin_notes'=>"Testing move cart to order"
      ]);

      $orderId = $pdo->lastInsertId();

      // tapos kunin yung cart details: state na scan na ni cashier yung items
      $getCart = "SELECT
                        c.cart_id,
                        c.product_id,
                        u.user_id AS user_id,
                        p.product_name,
                        p.price,
                        c.quantity,
                        (p.price * c.quantity) AS subtotal,
                        c.added_at
                    FROM shopping_cart c
                    JOIN users u ON c.user_id = u.user_id
                    JOIN products p ON c.product_id = p.product_id
                    WHERE c.user_id = ?";
        $stmt = $pdo->prepare($getCart);
        $stmt->execute([$user_id]);
        $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //var_dump($getCart);
        //var_dump($cartItems);

        // insert na sa order items: state na ilalagay na sa resibo ni cashier
        $insertToOrderItems ="INSERT INTO order_items
          (order_id, product_id, product_name, product_price, quantity, subtotal)
          VALUES (:order_id, :product_id, :product_name, :product_price, :quantity, :subtotal)";
        $insertItemStmt = $pdo->prepare($insertToOrderItems);

        $total_amount = 0;
        foreach ($cartItems as $item) {
          $total_amount+= $item['subtotal'];

          $insertItemStmt->execute([
            ':order_id' => $orderId,
            ':product_id' => $item['product_id'],
            ':product_name' => $item['product_name'],
            ':product_price' => $item['price'],
            ':quantity' => $item['quantity'],
            ':subtotal' => $item['subtotal']
          ]);
        }
        $shipping_fee = 75.00;
        $final_amount = $total_amount+$shipping_fee;

        $updateOrder = "UPDATE orders
          SET total_amount = :total_amount,
              shipping_fee = :shipping_fee,
              final_amount = :final_amount
        WHERE order_id = :order_id";
        $updateStmt = $pdo->prepare($updateOrder);
        $updateStmt->execute([
          ':total_amount'=>$total_amount,
          ':shipping_fee'=>$shipping_fee,
          ':final_amount'=>$final_amount,
          ':order_id'=>$orderId
        ]);

        $link = createPaymentLink($final_amount, "Order ID: $orderId", "Checkout for Order ID: $orderId");
        if(isset($link['data']['attributes']['checkout_url'])){
           $checkoutUrl = $link['data']['attributes']['checkout_url'];
           header("Location: $checkoutUrl"); // Redirect customer to PayMongo Checkout
           exit;
        } else {
           echo "Failed to create payment link.";
           echo "<pre>" . print_r($link, true) . "</pre>";
        }
        // var_dump($updateStmt);

        // $clearCart = "DELETE FROM shopping_cart WHERE user_id = ?";
        // $stmt = $pdo->prepare($clearCart);
        // $stmt->execute([$user_id]);

    // $sql = "SELECT c.cart_id,
    //             p.product_name,
    //             p.price,
    //             c.quantity,
    //             (p.price * c.quantity) AS subtotal
    //         FROM shopping_cart c
    //         JOIN products p ON c.product_id = p.product_id
    //         WHERE c.user_id = ?";
    //
    // $stmt = $pdo->prepare($sql);
    // $stmt->execute([$user_id]);
    // $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $pdo->commit();
} catch (Exception $e) {
    $pdo->rollBack();
    echo "Transaction Failed: Database Error-> " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link href="../bootstrap-5.3.8-dist/css/bootstrap.css" rel="stylesheet">
    <link href="../ui/homepage.css" rel="stylesheet"/>
    <style>
        body {
            background-color: #f4f7fa;
            font-family: 'Segoe UI', sans-serif;
        }

        h2, h4 {
            color: #002366;
        }

        .checkout-container {
            display: flex;
            justify-content: space-between;
            gap: 30px;
            margin-top: 50px;
        }

        .order-summary, .billing-info {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.05);
        }

        .order-summary {
            flex: 0 0 55%;
        }

        .billing-info {
            flex: 0 0 40%;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .total {
            font-weight: bold;
            font-size: 18px;
        }

        .form-control:focus {
            border-color: #002366;
            box-shadow: none;
        }

        .btn-pay {
            background-color: #002366;
            color: white;
            font-weight: 500;
            padding: 12px;
            border: none;
            width: 100%;
            border-radius: 8px;
            margin-top: 20px;
        }

        .btn-pay:hover {
            background-color: #001f4d;
        }
    </style>
</head>
<body>

<div class="container checkout-container">
    <!-- Order Summary -->
    <div class="order-summary">
        <h2>Order Summary</h2>
        <?php $grandTotal = 0; ?>
        <?php foreach ($cartItems as $item): ?>
            <?php $grandTotal += $item['subtotal']; ?>
            <div class="summary-item">
                <div>
                    <strong><?= htmlspecialchars($item['product_name']) ?></strong><br>
                    <small>₱<?= number_format($item['price'], 2) ?> x <?= $item['quantity'] ?></small>
                </div>
                <div>
                    ₱<?= number_format($item['subtotal'], 2) ?>
                </div>
            </div>
        <?php endforeach; ?>
        <?php if (!$cartItems): ?>
          <p>Cart is empty...</p>
        <?php endif; ?>

        <div class="summary-item total">
            <span>Total:</span>
            <span>₱<?= number_format($grandTotal, 2) ?></span>
        </div>
        <p class="mt-3 text-muted">Delivery: <strong>Free</strong> (Standard 3-5 days)</p>
    </div>

    <!-- Billing & Payment Info -->
    <div class="billing-info">
        <h4>Billing Information</h4>
        <form action="process-payment.php" method="POST">
            <div class="mb-3">
                <label for="fullname" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="fullname" name="fullname" value="<?= htmlspecialchars($user['first_name'].' '.$user['last_name']); ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="<?= htmlspecialchars($user['address']); ?>" readonly>
            </div>

            <div class="mb-3">
                <label for="instructions" class="form-label">Special Instructions</label>
                <textarea class="form-control" id="instructions" name="instructions" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <!-- <label for="paymentMethod" class="form-label">Payment Method</label> -->
                <!-- <select class="form-control" id="paymentMethod" name="paymentMethod" required>
                    <option value="">Select...</option>
                    <option value="COD">COD</option>
                    <option value="credit_card">Credit Card</option>
                    <option value="paypal">PayPal</option>
                    <option value="gcash">GCash</option>
                </select> -->
                <form class="" action="paymongo.php" method="post">
                <label><input type="radio" name="payment_method" value="GCash" required> GCash</label>
                <label><input type="radio" name="payment_method" value="Card"> Credit/Debit Card</label>
                <label><input type="radio" name="payment_method" value="COD"> Cash on Delivery</label>
              </form>

            </div>

            <button type="submit" class="btn-pay">Confirm & Pay ₱<?= number_format($final_amount, 2) ?></button>
        </form>
    </div>
</div>

<script src="../bootstrap-5.3.8-dist/js/bootstrap.min.js"></script>
</body>
</html>
