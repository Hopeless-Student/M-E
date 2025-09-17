<?php
require_once __DIR__ .'/../includes/database.php';
require_once __DIR__ .'/../auth/auth.php';

$pdo = connect();
  if($_SERVER['REQUEST_METHOD']=="POST"){

    $user_id = $user['user_id'];
    try {

      $sql = "INSERT INTO orders(
        user_id, order_number, total_amount,
        shipping_fee, final_amount, payment_method,
        order_status, delivery_address, contact_number,
        special_instructions, confirmed_at, admin_notes
      )VALUES (:user_id, :order_number, :total_amount,
      :shipping_fee, :final_amount, :payment_method,
      :order_status, :delivery_address, :contact_number,
      :special_instructions, :confirmed_at, :admin_notes)";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([
        ':user_id'=>$user_id,
        ':order_number'=>'ORD-' . date("YmdHis"),
        ':total_amount'=>0,
        ':shipping_fee'=>0.00,
        ':final_amount'=>0,
        ':payment_method'=>'COD',
        ':order_status'=>'Pending',
        ':delivery_address'=>$user['address'],
        ':contact_number'=>$user['contact_number'],
        ':special_instructions'=>'None',
        ':confirmed_at'=>null,
        ':admin_notes'=>'Testing checkout order'
      ]);
      echo "Inserted in Order!";
      $orderId = $pdo->lastInsertId();

      $getCart = "SELECT
                        c.cart_id,
                        c.product_id,
                        u.user_id AS user_id,
                        u.username,
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

      $clearCart = "DELETE FROM shopping_cart WHERE user_id = ?";
      $stmt = $pdo->prepare($clearCart);
      $stmt->execute([$user_id]);

        echo "Order Placed Succesfully!";
        header("Location: confirmpage-test.php");
        exit;
    } catch (PDOException $e) {
      echo "Database Connection Failed: " . $e->getMessage();
    }

  }
  else {
    header("Location: ../test.php");
    exit;
  }
