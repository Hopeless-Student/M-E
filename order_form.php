<?php
session_start();
include('C:\xampp\htdocs\M&E-Website\includes\header.php');
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
  <?php
  if (!isset($_SESSION["user"])) {
      echo "What product are you looking for?";
  } else {
    echo "Complete your order! {$_SESSION["user"]}";
  }
  ?>
  </body>
</html>
