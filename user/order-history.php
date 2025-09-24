<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Order History</title>
  <link href="../bootstrap-5.3.8-dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/user-sidebar.css">
  <style>
    body {
      background-color: #f4f7fa;
      font-family: 'Segoe UI', sans-serif;
    }

    .order-content {
      margin-left: 240px;
      padding: 40px 20px;
    }

    .order-title {
      font-weight: 700;
      color: #002366;
      margin-bottom: 15px;
    }

    .status {
      margin-bottom: 25px;
    }

    .status a {
      text-decoration: none;
      color: #444;
      font-weight: 500;
      margin-right: 12px;
      transition: 0.2s;
    }

    .status a:hover {
      color: #002366;
    }

    .items-container {
      background-color: #ffffff;
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 25px;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
      transition: all 0.2s ease-in-out;
    }

    .items-container:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.08);
    }

    .order-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 15px;
    }

    .order-header p {
      margin: 0;
      font-size: 0.95rem;
      color: #555;
    }

    .order-status {
      font-size: 0.85rem;
      font-weight: 600;
      padding: 6px 12px;
      border-radius: 30px;
      color: white;
    }

    .status-pending { background-color: #ffc107; }
    .status-delivered { background-color: #28a745; }
    .status-cancelled { background-color: #dc3545; }

    .item {
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .item img {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border-radius: 8px;
      margin-right: 20px;
    }

    .item-text {
      flex-grow: 1;
    }

    .item-text p {
      margin: 0;
      font-weight: 600;
      color: #222;
    }

    .item-text sub {
      color: #666;
    }

    .btn-details {
      background-color: #002366;
      border: none;
      color: white;
      padding: 8px 14px;
      border-radius: 8px;
      transition: background 0.2s;
    }

    .btn-details:hover {
      background-color: #001c4d;
    }
  </style>
</head>
<body>
  <?php include('../includes/user-sidebar.php'); ?>
  <div class="container py-4">
    <div class="order-content">
      <h2 class="order-title">Order History</h2>
      <hr>
      <div class="status">
        <a href="#">All</a>|
        <a href="#">Pending</a>|
        <a href="#">Delivered</a>
      </div>

      <!-- Example Order Card -->
      <div class="items-container">
        <div class="order-header">
          <p>09/09/2025 | Order No: <strong>123456789</strong></p>
          <p>Total: <strong>₱800</strong></p>
        </div>
        <span class="order-status status-pending">Pending</span>
        <hr>
        <div class="item">
          <img src="../assets/images/Hard-Copy.jpg" alt="item sample">
          <div class="item-text">
            <p>Bond paper ream</p>
            <sub>₱800 × 1</sub>
          </div>
          <button class="btn-details">Order Details</button>
        </div>
      </div>

      <!-- Duplicate more items-container for demo -->
      <div class="items-container">
        <div class="order-header">
          <p>09/09/2025 | Order No: <strong>987654321</strong></p>
          <p>Total: <strong>₱1,200</strong></p>
        </div>
        <span class="order-status status-delivered">Delivered</span>
        <hr>
        <div class="item">
          <img src="../assets/images/Hard-Copy.jpg" alt="item sample">
          <div class="item-text">
            <p>Notebook Pack</p>
            <sub>₱400 × 3</sub>
          </div>
          <button class="btn-details">Order Details</button>
        </div>
      </div>
    </div>
  </div>

  <script src="../bootstrap-5.3.8-dist/js/bootstrap.min.js"></script>
</body>
</html>
