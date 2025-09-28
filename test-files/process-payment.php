<?php
require __DIR__ . '/../vendor/autoload.php';
use Dotenv\Dotenv;
require_once __DIR__ .'/../includes/database.php';
require_once __DIR__ .'/../auth/auth.php';
require_once __DIR__ .'/paymongo.php';

  if($_SERVER['REQUEST_METHOD'] == "POST"){
    $pdo = connect();
    $user_id = $user['user_id'];
    $payment_method = $_POST['payment_method'];
    $special_instructions = $_POST['instructions'];
    $orderNumber = 'ORD-' . date("YmdHis"). '-' .  uniqid();
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
            ':order_number'=> $orderNumber,
            ':total_amount'=>0,
            ':shipping_fee'=>0.00,
            ':final_amount'=>0,
            ':payment_method'=>$payment_method,
            ':order_status'=>'Pending',
            ':delivery_address'=>$user['address'],
            ':contact_number'=>$user['contact_number'],
            ':special_instructions'=>$special_instructions,
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

          switch ($payment_method) {
            case 'GCash':
            case 'Card':
              $link = createPaymentLink($final_amount, "Order ID: $orderId", "Checkout for Order ID: $orderId", $orderId, $orderNumber);
              if(isset($link['data']['attributes']['checkout_url'])){
                $checkoutUrl = $link['data']['attributes']['checkout_url'];
                $pdo->commit();
                // echo "<pre>" . print_r($link, true) . "</pre>";
                // echo $checkoutUrl;
                header("Location: $checkoutUrl");
                exit;
              } else {
                echo "Failed to create payment link.";
                echo "<pre>" . print_r($link, true) . "</pre>";
              }

              break;
            case 'COD':
                $clearCart = "DELETE FROM shopping_cart WHERE user_id = ?";
                $stmt = $pdo->prepare($clearCart);
                $stmt->execute([$user_id]);
                $pdo->commit();
              header("Location: cod.php");
              exit;
            break;
            default:
              $pdo->rollBack();
              echo "Invalid payment method selected.";
              break;
          }



    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Transaction Failed: Database Error-> " . $e->getMessage();
    }
  }


 ?>
