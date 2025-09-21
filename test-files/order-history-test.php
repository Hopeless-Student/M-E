<?php
require_once __DIR__ .'/../includes/database.php';
require_once __DIR__ .'/../auth/auth.php';

$pdo = connect();
$user_id = $user['user_id'];

try {
    $sql = "SELECT c.cart_id,
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

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Database Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="../bootstrap-5.3.8-dist/css/bootstrap.css" rel="stylesheet">
    <link href="../ui/homepage.css" rel="stylesheet"/>
    <style>
    body {
        background-color: #f4f7fa;
        font-family: 'Segoe UI', sans-serif;
    }

    h2, h5 {
        color: #002366; /* Royal Blue */
    }

    .cart-container {
        display: flex;
        justify-content: space-between;
        margin-top: 50px;
        gap: 30px;
    }

    .cart-items, .cart-summary {
        background-color: #ffffff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
    }

    .cart-items {
        flex: 0 0 65%;
    }

    .cart-summary {
        flex: 0 0 30%;
    }

    .cart-product {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #eaeaea;
        padding: 15px 0;
    }

    .product-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        margin-right: 20px;
    }

    .product-info {
        flex-grow: 1;
    }

    .product-title {
        font-weight: 600;
        color: #222;
    }

    .product-price {
        color: #888;
    }

    .quantity-control {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .quantity-btn {
        border: 1px solid #ccc;
        padding: 2px 8px;
        border-radius: 4px;
        background: none;
        color: #002366;
        cursor: pointer;
    }

    .btn-remove {
        font-size: 12px;
        color: red;
        background: none;
        border: none;
        margin-top: 5px;
        cursor: pointer;
    }

    .summary-line {
        display: flex;
        justify-content: space-between;
        margin: 10px 0;
    }

    .btn-checkout {
        background-color: #002366;
        color: white;
        font-weight: 500;
        width: 100%;
        padding: 12px;
        border: none;
        border-radius: 8px;
        margin-top: 20px;
    }

    .btn-checkout:hover {
        background-color: #001f4d;
    }

    .payment-options img {
        width: 35px;
        margin-right: 10px;
        margin-top: 10px;
    }
</style>

</head>
<body>
  <header>
      <div class="logo">
          <img alt="M&amp;E Logo" src="../ui/Assets/logo.png"/>
      </div>

      <nav>
          <a href="homepage-sample.html">Home</a>
          <a href="#">Products</a>
          <a href="#">About Us</a>
      </nav>

      <div class="header-actions">
          <div class="search-bar">
              <img alt="search" class="search-icon" src="../ui/Assets/search.svg"/>
              <input placeholder="Search products..." type="text"/>
          </div>

          <div class="cart">
              <a href="#">
                  <img alt="cart" class="cart-img" src="../ui/Assets/cart-button_default.svg"/>
              </a>
          </div>

          <div class="btn-login">
              <a href="#">Log in</a>
          </div>
      </div>
  </header>
  <div class="container cart-container">
      <!-- Cart Items Section -->
      <div class="cart-items">
          <h2>Your Shopping Cart</h2>

          <?php
          $grandTotal = 0;
          foreach ($cartItems as $item):
              $grandTotal += $item['subtotal'];
          ?>
          <div class="cart-product">
              <img src="../assets/images/Hard-Copy.jpg" alt="Product Image" class="product-img">
              <div class="product-info">
                  <div class="product-title"><?= htmlspecialchars($item['product_name']) ?></div>
                  <div class="product-price">₱<?= number_format($item['price'], 2) ?></div>
                  <div class="quantity-control mt-2">
                      <button class="quantity-btn">-</button>
                       <?= $item['quantity'] ?>
                      <button class="quantity-btn">+</button>
                  </div>
                  <button class="btn-remove">Remove</button>
              </div>
              <div class="product-subtotal">
                  ₱<?= number_format($item['subtotal'], 2) ?>
              </div>
          </div>
          <?php endforeach; ?>
      </div>

      <!-- Cart Summary Section -->
      <div class="cart-summary">
          <h5>Order Summary</h5>
          <div class="summary-line">
              <span>Subtotal:</span>
              <span>₱<?= number_format($grandTotal, 2) ?></span>
          </div>
          <div class="summary-line">
              <span>Standard Delivery:</span>
              <span>Free</span>
          </div>
          <hr>
          <div class="summary-line fw-bold">
              <span>Total:</span>
              <span>₱<?= number_format($grandTotal, 2) ?></span>
          </div>
          <button class="btn-checkout">Checkout</button>

          <div class="mt-4 text-center ">
            <p>Enjoy our product and happy shopping!</p>
          </div>
          <!-- <div class="mt-4">
              <small class="text-muted">We Accept:</small>
              <div class="payment-options">
                  <img src="path/to/paypal-icon.png" alt="PayPal">
                  <img src="path/to/stripe-icon.png" alt="Stripe">
                  <img src="path/to/visa-icon.png" alt="Visa">
                  <img src="path/to/mastercard-icon.png" alt="MasterCard">
              </div>
          </div> -->
      </div>
  </div>


    <script>

    </script>
    <script src="../bootstrap-5.3.2-dist/js/bootstrap.min.js"></script>
</body>
</html>
