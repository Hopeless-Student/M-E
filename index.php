<?php
include('includes/header.php');
include("includes/database.php");
session_start();
$pdo = connect();

if (!isset($_SESSION["id"])) {
    header("Location: auth/overlaylogin.php");
    exit();
}
  try {
    $sql = "SELECT COUNT(*) FROM users";
    $numberOfUsers = $pdo->prepare($sql);
    $numberOfUsers->execute();
    $count =$numberOfUsers->fetchColumn();
    //echo $count;
  } catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    return null;
  }


?>
<style media="screen">
  .container{
    background-color: lightblue;
    height: 30px;
    width: 300px;
    border-radius: 20px;
  }
  .numberofusers{
    text-align: center;
  }
</style>
<h2>Welcome to our homepage! <?php  echo "{$_SESSION["user"]}"?></h2>
<p>We sell office, school, and sanitary supplies.</p>
<p>Testing the PR!</p>
<p>Testing the Pulling and merging!</p>
<div class="container">
  <div class="numberofusers">
    <?php
    echo "Number of active users on database: {$count}";
    ?>
  </div>
</div>
  <form action="auth/logout.php" method="post">
    <button type="submit">Logout</button>
  </form>
<?php
include('includes/footer.php');
 ?>
