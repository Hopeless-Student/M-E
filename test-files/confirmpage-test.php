<?php
require_once __DIR__ .'/../includes/database.php';
require_once __DIR__ .'/../auth/auth.php';
$pdo = connect();
 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Order Summary - Minimalist</title>
    <link href="../bootstrap-5.3.8-dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
      :root{
        --royal-blue: #2b4eff; /* royal blue tone */
      }
      body{background:#f6f7fb;}
      .card-min{border:0;border-radius:12px;box-shadow:0 6px 18px rgba(40,44,63,0.08)}
      .product-line{display:flex;align-items:center;justify-content:space-between;gap:12px}
      .product-meta{display:flex;gap:12px;align-items:center}
      .product-thumb{width:56px;height:48px;border-radius:8px;object-fit:cover;background:#fff;border:1px solid #eee}
      .muted{color:#6b6f85;font-size:0.9rem}
      .btn-royal{
        background:var(--royal-blue);
        border:none;
        color:#fff;
        box-shadow:0 6px 18px rgba(43,78,255,0.16);
        border-radius:10px;
        padding:0.6rem 1.05rem;
      }
      .btn-royal:hover{filter:brightness(.95)}
      .small-chip{font-size:0.8rem;padding:0.15rem 0.5rem;border-radius:999px;background:#eef0ff;color:var(--royal-blue)}
      @media (max-width:420px){
        .product-thumb{width:48px;height:40px}
      }
    </style>
  </head>
  <body>
    <main class="container py-5">
      <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">

          <div class="card card-min p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <div>
                <h5 class="mb-0">Order Summary</h5>
                <div class="muted">Order #<strong>20250917-001</strong> • <span class="muted">Placed Sep 17, 2025</span></div>
              </div>
              <div class="small-chip">3 items</div>
            </div>

            <hr>

            <!-- Product lines -->
            <div class="mb-3">
              <div class="product-line mb-3">
                <div class="product-meta">
                  <img src="../assets/images/Hard-Copy.jpg" alt="Bond Paper" class="product-thumb">
                  <div>
                    <div><strong>Bond Paper A4 80gsm</strong></div>
                    <div class="muted">Qty 2 • BP-A480</div>
                  </div>
                </div>
                <div class="text-end">
                  <div><strong>₱500.00</strong></div>
                  <div class="muted">₱250.00 ea</div>
                </div>
              </div>

              <div class="product-line mb-3">
                <div class="product-meta">
                  <img src="../assets/images/Hard-Copy.jpg" alt="Ballpen" class="product-thumb">
                  <div>
                    <div><strong>Ballpen Black (Box)</strong></div>
                    <div class="muted">Qty 1 • BP-BLK01</div>
                  </div>
                </div>
                <div class="text-end">
                  <div><strong>₱12.00</strong></div>
                  <div class="muted">₱12.00 ea</div>
                </div>
              </div>

              <div class="product-line mb-3">
                <div class="product-meta">
                  <img src="../assets/images/Hard-Copy.jpg" alt="Sanitary" class="product-thumb">
                  <div>
                    <div><strong>Hand Sanitizer 250ml</strong></div>
                    <div class="muted">Qty 1 • HS-250</div>
                  </div>
                </div>
                <div class="text-end">
                  <div><strong>₱75.00</strong></div>
                  <div class="muted">₱75.00 ea</div>
                </div>
              </div>
            </div>

            <hr>

            <!-- Summary -->
            <div class="d-flex justify-content-between align-items-center mb-3">
              <div class="muted">Subtotal</div>
              <div><strong>₱587.00</strong></div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
              <div class="muted">Shipping</div>
              <div><strong>₱50.00</strong></div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
              <div class="muted">Discount</div>
              <div class="muted">- ₱0.00</div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
              <div><strong>Total</strong></div>
              <div style="font-size:1.15rem"><strong>₱637.00</strong></div>
            </div>

            <div class="d-flex gap-2 mt-3">
              <button class="btn-royal btn w-100" id="payBtn" data-bs-toggle="modal" data-bs-target="#payModal">Pay</button>
              <button class="btn btn-outline-secondary w-100" id="cancelBtn">Cancel</button>
            </div>

            <div class="text-center mt-3 muted small">Payment secure • No payment will be processed in this demo</div>
          </div>

          <!-- Modal -->
          <div class="modal fade" id="payModal" tabindex="-1" aria-labelledby="payModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="payModalLabel">Proceed to Payment</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <p class="mb-2">Choose a payment method:</p>
                  <div class="d-grid gap-2">
                    <button class="btn btn-outline-primary">Cash on Delivery (COD)</button>
                    <button class="btn btn-royal" id="confirmPay">Pay with Card</button>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </main>

  <script src="../bootstrap-5.3.8-dist/js/bootstrap.min.js"></script>
    <script>
      document.getElementById('cancelBtn').addEventListener('click', function(){
        // simple cancel action
        alert('Order cancelled (demo)');
      });
      document.getElementById('confirmPay').addEventListener('click', function(){
        // simulate payment success
        var modalEl = document.getElementById('payModal');
        var modal = bootstrap.Modal.getInstance(modalEl);
        modal.hide();
        setTimeout(function(){
          alert('Payment successful! (demo)');
        }, 250);
      });
    </script>
  </body>
</html>
