<?php
  session_start();
  include('includes/header.php');
  include('includes/database.php');
  // if (!isset($_SESSION["user"])) {
  //     header("Location: auth/login.php");
  //     exit();
  // }
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
        echo "Browse all you want! <br>";
    } else {
      echo "Hello, {$_SESSION['user']} <br>";
      echo "<form class='logoutbtn' action='auth/logout.php' method='post'>";
      echo "<input type='submit' name='logout' value='Log out'>";
      echo "</form>";
    }
     ?>
     <button type="button" name="button" style="width: 60px; height: 20px;">Item 1</button>
     <button type="button" name="button" style="width: 60px; height: 20px;">Item 2</button>
     <button type="button" name="button" style="width: 60px; height: 20px;">Item 3</button>
  </body>
</html>
