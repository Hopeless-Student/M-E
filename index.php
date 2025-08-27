<?php

if(isset($_SESSION['email'])){
  $email = $_SESSION['email'];
} else {
  header("Location: register.php");
  exit;
}
 ?>
