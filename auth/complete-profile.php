<?php
  session_start();
  include('../includes/database.php');

  $fname  = $_SESSION['first_name'] ?? '';
  $lname  = $_SESSION['last_name'] ?? '';
 ?>
