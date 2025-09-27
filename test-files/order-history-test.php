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
        font-weight: 700;
    }
    .cart-container {
        display: flex;
        justify-content: space-between;
        margin-top: 50px;
        gap: 30px;
    }
    .cart-items, .cart-summary {
        background-color: #ffffff;
        padding: 25px;
        border-radius: 16px;
        box-shadow: 0 8px 24px rgba(0,0,0,0.05);
    }
    .cart-items { flex: 0 0 65%; }
    .cart-summary { flex: 0 0 30%; }

    .cart-product {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border: 1px solid #eee;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 20px;
        transition: all 0.2s ease-in-out;
    }
    .cart-product:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.08);
    }
    .product-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 10px;
        margin-right: 20px;
    }
    .product-info {
        flex-grow: 1;
    }
    .product-title {
        font-weight: 600;
        font-size: 1.05rem;
        color: #222;
    }
    .product-price {
        color: #666;
        font-size: 0.9rem;
    }
    .quantity-control {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 8px;
    }
    .quantity-btn {
        border: none;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        font-size: 16px;
        background-color: #e6ebf5;
        color: #002366;
        cursor: pointer;
        transition: background 0.2s;
    }
    .quantity-btn:hover {
        background-color: #cbd5e9;
    }
    .btn-remove {
        font-size: 13px;
        color: #dc3545;
        background: none;
        border: none;
        margin-top: 5px;
        cursor: pointer;
    }
    .product-subtotal {
        font-weight: 600;
        color: #002366;
    }
    .summary-line {
        display: flex;
        justify-content: space-between;
        margin: 12px 0;
        font-size: 0.95rem;
    }
    .btn-checkout {
        background-color: #002366;
        color: white;
        font-weight: 500;
        width: 100%;
        padding: 14px;
        border: none;
        border-radius: 10px;
        margin-top: 20px;
        transition: 0.2s;
    }
    .btn-checkout:hover {
        background-color: #001c4d;
    }
    @media (max-width: 576px) {
  .cart-product {
    flex-direction: column;
    align-items: flex-start;
    text-align: left;
  }

  .product-img {
    width: 100%;
    height: auto;
    margin-bottom: 10px;
  }

  .product-subtotal {
    align-self: flex-end;
    margin-top: 10px;
  }
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

  <div class="container my-5">
  <div class="row gy-4">

    <div class="col-12 col-lg-8">
      <div class="cart-items">
        <h2 class="text-center">Your Shopping Cart</h2>
        <?php $grandTotal = 0; ?>
        <?php foreach ($cartItems as $item):
            $grandTotal += $item['subtotal']; ?>
            <div class="cart-product">
                <img src="../assets/images/Hard-Copy.jpg" alt="Product Image" class="product-img">
                <div class="product-info">
                  <div class="product-title"><?= htmlspecialchars($item['product_name']) ?></div>
                  <div class="product-price">₱<?= number_format($item['price'], 2) ?></div>
                  <form action="cart-actions.php" method="post" class="d-inline">
                      <input type="hidden" name="cart_id" value="<?= $item['cart_id'] ?>">
                      <div class="quantity-control">
                          <button type="submit" class="quantity-btn" name="action" value="decrease">-</button>
                          <span><?= $item['quantity'] ?></span>
                          <button type="submit" class="quantity-btn" name="action" value="increase">+</button>
                      </div>
                  </form>
                  <form method="post" action="cart-actions.php" class="mt-2">
                      <input type="hidden" name="cart_id" value="<?= $item['cart_id'] ?>">
                        <button type="submit" name="action" value="remove" class="btn-remove">Remove</button>
                  </form>
              </div>

                <div class="product-subtotal">
                    ₱<?= number_format($item['subtotal'], 2) ?>
                </div>
            </div>
        <?php endforeach; ?>

        <?php if (!$cartItems): ?>
          <div class="text-center">
            <img src="../assets/images/empty-cart.png" class="img-fluid" style="max-height:250px;" alt="">
            <p class="fs-3 fw-bold" style="color: #002366;">Your Cart Is Currently Empty!</p>
            <small>Before checking out, add some items first on your cart. <br>Browse our "Product page"!</small>
            <button class="btn-checkout">Shop Now!</button>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <div class="col-12 col-lg-4">
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
        <?php if ($cartItems): ?>
            <form action="checkout-test.php" method="post">
              <input type="submit" name="Checkout" value="Proceed to Checkout" class="btn-checkout">
            </form>
          <?php else: ?>
            <button class="btn-checkout"
                    style="background-color: gray;"
                    disabled
                    data-bs-toggle="tooltip"
                    data-bs-placement="bottom"
                    title="Add items to your cart before proceeding to checkout.">
                Proceed to Checkout
            </button>
          <?php endif; ?>

        <div class="mt-4 text-center">
            <p class="text-muted">Enjoy your shopping with us 💙</p>
        </div>
      </div>
    </div>
  </div>
</div>


  <script src="../bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
  <script>
  const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
  const tooltipList = [...tooltipTriggerList].map(el => new bootstrap.Tooltip(el));
</script>

</body>
</html>
