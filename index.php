<?php
include('includes/header.php');
session_start();

if (!isset($_SESSION["id"])) {
    header("Location: auth/overlaylogin.php");
    exit();
}
?>
<h2>Welcome to our homepage! <?php  echo "{$_SESSION["user"]}"?></h2>
<p>We sell office, school, and sanitary supplies.</p>
<p>Testing the PR!</p>
<p>Testing the Pulling and merging!</p>
  <form action="auth/logout.php" method="post">
    <button type="submit">Logout</button>
  </form>

<?php
include('includes/footer.php');
 ?>
