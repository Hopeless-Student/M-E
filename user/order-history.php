<?php

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Order History</title>
    <link href="../bootstrap-5.3.8-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/user-sidebar.css">
    <style media="screen">
      .order-content{
        margin-left: 240px;
        padding: 40px 20px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        background-color: #f8f9fa;
        border-radius: 5px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
      }
      /* .order-content p.display-5 {
        background-color: #4169e1;
        color: white;
        padding: 15px;
        border-radius: 5px;
        text-align: center;
        margin-bottom: 20px;
      } */
      .status {
        padding: 2%;
        display: flex;
        justify-content: left;
        gap: 10px;
      }
      .status a{
        text-decoration: none;
        color: black;
      }
      .status a:hover{
        color: #4169e1;
      }
      .items-container{
        border: 1px solid #ddd;
        padding: 20px;
        background-color: white;
        border-radius: 8px;
        margin-top: 2%;
      }
      .item-status{
        background-color: #ffc107;
        color: white;
        width: 10%;
        padding-left: 2%;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        border: 1px solid #ffc107;
      }
      .item{
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
      }
      .item img{
        width: 25%;
        max-width: 300px;
        border-radius: 5px;
        object-fit: cover;
      }
      .item{
        flex: 1;
        margin-left: 20px;
      }
      .item-text{
        margin-left: 20px;
        flex: 1;
      }
      .item-text p {
        margin: 0;
        font-weight: bold;
      }
    </style>
  </head>
  <body>
        <?php include('../includes/user-sidebar.php'); ?>
        <div class="container py-4">
          <div class="order-content" style="border: 1px solid;">
            <p class="display-6">Order History</p>
            <hr>
            <div class="status">
              <a href="#">All | </a>
              <a href="#"> Pending | </a>
              <a href="#"> Delivered </a>
            </div>
            <div class="items-container">
              <p class="item-status">Pending</p>
              <div class="d-flex justify-content-between">
                <p class="mb-0">09/09/2025 | Order no: 123456789</p>
                <p class="mb-0">Total: PHP 800</p>
              </div>
              <hr>
              <div class="item">
                <img src="../assets/images/Hard-Copy.jpg" alt="item sample">
                <div class="item-text">
                  <p>Bond paper ream</p>
                  <sub>PHP 800 x 1</sub>
                </div>
                <button type="button" name="button" class="btn btn-primary">Order Details</button>
                <div class="modal-dialog modal-dialog-centered">
                </div>
              </div>
            </div>
            <div class="items-container">
              <p class="item-status">Pending</p>
              <div class="d-flex justify-content-between">
                <p class="mb-0">09/09/2025 | Order no: 123456789</p>
                <p class="mb-0">Total: PHP 800</p>
              </div>
              <hr>
              <div class="item">
                <img src="../assets/images/Hard-Copy.jpg" alt="item sample">
                <div class="item-text">
                  <p>Bond paper ream</p>
                  <sub>PHP 800 x 1</sub>
                </div>
                <button type="button" name="button" class="btn btn-primary">Order Details</button>
              </div>
            </div>
            <div class="items-container">
              <p class="item-status">Pending</p>
              <div class="d-flex justify-content-between">
                <p class="mb-0">09/09/2025 | Order no: 123456789</p>
                <p class="mb-0">Total: PHP 800</p>
              </div>
              <hr>
              <div class="item">
                <img src="../assets/images/Hard-Copy.jpg" alt="item sample">
                <div class="item-text">
                  <p>Bond paper ream</p>
                  <sub>PHP 800 x 1</sub>
                </div>
                <button type="button" name="button" class="btn btn-primary">Order Details</button>
              </div>
            </div>
            <div class="items-container">
              <p class="item-status">Pending</p>
              <div class="d-flex justify-content-between">
                <p class="mb-0">09/09/2025 | Order no: 123456789</p>
                <p class="mb-0">Total: PHP 800</p>
              </div>
              <hr>
              <div class="item">
                <img src="../assets/images/Hard-Copy.jpg" alt="item sample">
                <div class="item-text">
                  <p>Bond paper ream</p>
                  <sub>PHP 800 x 1</sub>
                </div>
                <button type="button" name="button" class="btn btn-primary">Order Details</button>
              </div>
            </div>
          </div>
        </div>
        <script src="../bootstrap-5.3.8-dist/js/bootstrap.min.js"> </script>
  </body>
</html>
