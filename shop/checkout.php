<?php
require_once __DIR__ . '/../includes/database.php';
require_once __DIR__ . '/../auth/mainpage-auth.php';

if($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['selectedItems'])){
    header("Location: cart.php");
    exit;
}

$selectedItems = json_decode($_POST['selectedItems'], true);

if(empty($selectedItems)){
    echo "<script>alert('No items selected. Redirecting to cart.'); window.location.href='cart.php';</script>";
    exit;
}

$pdo = connect();
$totalAmount = 0;

$productIds = array_column($selectedItems, 'id');
$placeholders = implode(',', array_fill(0, count($productIds), '?'));
$stmt = $pdo->prepare("SELECT * FROM products WHERE product_id IN ($placeholders)");
$stmt->execute($productIds);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// megre quantiyt info
$cartItems = [];
$categoryIds = [];
foreach($products as $prod){
    foreach($selectedItems as $sel){
        if($sel['id'] == $prod['product_id']){
            $prod['quantity'] = $sel['quantity'];
            $prod['subtotal'] = $prod['price'] * $sel['quantity'];
            $totalAmount += $prod['subtotal'];
            $cartItems[] = $prod;
            $categoryIds[] = $prod['category_id'];
        }
    }
}
$categoryIds = array_unique($categoryIds);

$shippingFee = 75.00;
$finalAmount = $totalAmount + $shippingFee;

if(!empty($categoryIds)){
    $catPlaceholders = implode(',', array_fill(0, count($categoryIds), '?'));
    $stmt = $pdo->prepare("SELECT * FROM products WHERE category_id IN ($catPlaceholders) AND product_id NOT IN ($placeholders) LIMIT 4");
    $stmt->execute(array_merge($categoryIds, $productIds));
    $recommendedProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="icon" type="image/x-icon" href="../assets/images/M&E_LOGO-semi-transparent.ico">
<title>Checkout</title>
<link href="../bootstrap-5.3.8-dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<style>
:root { --primary:#0d6efd; --primary-light:#e7f1ff; --secondary:#f8f9fa; }

body {
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #e3f2fd 0%, #ffffff 100%);
}

.checkout-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    padding: 2rem;
    margin-bottom: 2rem;
    transition: transform 0.2s;
}
.checkout-card:hover { transform: translateY(-2px); }

.checkout-summary {
    background: var(--secondary);
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: inset 0 0 8px rgba(0,0,0,0.05);
    margin-top: 1.5rem;
}
.checkout-summary div { margin-bottom:0.75rem; font-size:1.1rem; }

.payment-option {
    padding: 1rem;
    border: 1px solid #dee2e6;
    border-radius: 12px;
    margin-bottom: 0.75rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    transition: all 0.2s;
    background: var(--secondary);
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}
.payment-option:hover { background: var(--primary-light); box-shadow: 0 4px 12px rgba(13,110,253,0.2); }
.payment-option.active { border-color: var(--primary); background: var(--primary-light); box-shadow:0 4px 12px rgba(13,110,253,0.3); }

.btn-primary { background-color: var(--primary); border:none; font-weight:600; transition: all 0.2s; }
.btn-primary:hover { background-color: #094ec0; }

.table td, .table th { vertical-align: middle; }
.quantity-badge { font-size:0.85rem; background: var(--primary); color:#fff; padding:0.3rem 0.6rem; border-radius:0.5rem; }

.sticky-payment { position: sticky; top:20px; }
h2 { color: var(--primary); font-weight:600; margin-bottom:1.5rem; }
.btn-back { margin-bottom:1rem; }
img.product-thumb { width:50px; height:50px; object-fit:cover; border-radius:5px; }

.recommendation-card {
    display: flex;
    flex-direction: column;
    border-radius:12px;
    overflow:hidden;
    box-shadow:0 6px 15px rgba(0,0,0,0.08);
    transition: transform 0.2s;
}
.recommendation-card .p-2 {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.recommendation-card:hover { transform: translateY(-3px); }
.recommendation-card img { width:100%; object-fit:cover; height: auto; aspect-ratio: 1 / 1; display: block;}
.recommendation-title { font-weight:600; font-size:0.95rem; margin-top:0.5rem; }
.payment-logo {
    width: 40px;
    height: auto;
}
.payment-option span {
    font-weight: 600;
    font-size: 1rem;
}
</style>
</head>
<body>
<div class="container mt-5">
    <h2>Checkout</h2>
    <a href="cart.php" class="btn btn-outline-secondary btn-back">&larr; Back to Cart</a>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="checkout-card">
                <h4 class="mb-3">Order Summary</h4>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                              <th class="text-center">Product</th>
                              <th class="text-center">Price</th>
                              <th class="text-center">Qty</th>
                              <th class="text-center">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($cartItems as $item): ?>
                            <tr>
                                <td class="d-flex align-items-center">
                                    <img src="../assets/images/products/<?= htmlspecialchars($item['product_image'] ?? 'default.png') ?>" class="product-thumb me-2">
                                    <?= htmlspecialchars($item['product_name']) ?>
                                </td>
                                <td class="text-center">₱<?= number_format($item['price'],2) ?></td>
                                <td class="text-center"><span class="quantity-badge"><?= $item['quantity'] ?></span></td>
                                <td class="text-center">₱<?= number_format($item['subtotal'],2) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="checkout-summary">
                    <div><strong>Subtotal:</strong> ₱<?= number_format($totalAmount,2) ?></div>
                    <div><strong>Shipping Fee:</strong> ₱<?= number_format($shippingFee,2) ?></div>
                    <div class="fw-bold"><strong>Total Amount:</strong> ₱<?= number_format($finalAmount,2) ?></div>
                </div>
            </div>

            <?php if(!empty($recommendedProducts)): ?>
            <h4 class="mb-3">You might also like</h4>
            <div class="row g-3 mb-4">
                <?php foreach($recommendedProducts as $rec): ?>
                <div class="col-6 col-md-3">
                    <div class="recommendation-card">
                        <img src="../assets/images/products/<?= htmlspecialchars($rec['product_image'] ?? 'default.png') ?>" alt="">
                        <div class="p-2">
                            <div class="recommendation-title"><?= htmlspecialchars($rec['product_name']) ?></div>
                            <div class="text-primary fw-bold">₱<?= number_format($rec['price'],2) ?></div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

        <div class="col-lg-4">
            <div class="checkout-card sticky-payment">
                <h4 class="mb-3">Payment & Delivery</h4>
                <form action="process-payment.php" method="POST">
                    <input type="hidden" name="final_amount" value="<?= $finalAmount ?>">
                    <input type="hidden" name="selectedItems" value='<?= json_encode($cartItems) ?>'>

                    <div class="form-section">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control-plaintext fw-bold" value="<?= htmlspecialchars($user['first_name'].' '.$user['last_name']) ?>" readonly>
                    </div>

                    <div class="form-section">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-control-plaintext fw-bold" value="<?= htmlspecialchars($user['address']) ?>" readonly>
                    </div>

                    <div class="form-section">
                        <label class="form-label">Special Instructions</label>
                        <textarea class="form-control" name="instructions" rows="3" placeholder="Add special instructions..."></textarea>
                    </div>

                    <div class="form-section">
                        <label class="form-label">Payment Method</label>
                        <div class="payment-option"><input type="radio" name="payment_method" value="GCash" required> <img src="../assets/svg/GCash.svg" alt="gcash logo" class="payment-logo img-fluid"> <span>GCash</span></div>
                        <div class="payment-option"><input type="radio" name="payment_method" value="Card"> <img src="../assets/svg/credit-debit.svg" alt="credit-debit logo" class="payment-logo img-fluid"> <span>Credit/Debit Card</span> </div>
                        <div class="payment-option"><input type="radio" name="payment_method" value="COD"> <img src="../assets/svg/cod.svg" alt="cod logo" class="payment-logo img-fluid"> <span> Cash on Delivery</span> </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100 mt-2">
                        Confirm & Pay ₱<?= number_format($finalAmount, 2) ?>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="../bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
<script>
document.querySelectorAll('.payment-option').forEach(option => {
    option.addEventListener('click', () => {
        document.querySelectorAll('.payment-option').forEach(el => el.classList.remove('active'));
        option.classList.add('active');
        option.querySelector('input[type=radio]').checked = true;
    });
});
</script>
<footer class="mt-5 py-3 text-center text-muted">
    &copy; <?= date('Y') ?> M&E: Interior Supplies Trading. All Rights Reserved.
</footer>
</body>
</html>
