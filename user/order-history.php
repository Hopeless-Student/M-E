<?php

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Order History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
    rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
    crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/user-sidebar.css">
    <style media="screen">
      .order-content{
        margin-left: 240px;
        padding: 40px 20px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        box-shadow:
      }
      .status{
        padding: 2%;
        display: flex;
        justify-content: center;
      }
      .items-container{
        border: 1px solid black;
        padding: 2%;
      }
      .item{
        display: flex;
      }
      .item img{
        width: 20%;
        max-width: 500px;
      }
      .item{
        
      }
    </style>
  </head>
  <body>
        <?php include('../includes/user-sidebar.php'); ?>
        <div class="container">
          <div class="order-content" style="border: 1px solid black;">
            <p class="display-5 text-primary">Order History</p>
            <div class="status">
              <a href="#">All</a>
              <a href="#">Pending</a>
              <a href="#">Delivered</a>
            </div>
            <hr>
            <div class="items-container">
              <p class="text-warning">Pending</p>
              <p>09/09/2025 | Order no: 123456789</p> <span><p class="text-end">Total:PHP 800</p></span>
              <hr>
              <div class="item">
                <img src="../assets/images/Hard-Copy.jpg" alt="item sample">
                <p>Bond paper ream</p>
                <p>PHP 800 x 1</p>
                <button type="button" name="button">Details</button>
              </div>
            </div>
          </div>
        </div>
  </body>
</html>
