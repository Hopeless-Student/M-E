<?php
  if($_SERVER['REQUEST_METHOD'] == "POST"){
    $selected = $_POST['genders'];
    echo $selected;
  }
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
        <link href="bootstrap-5.3.8-dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <div class="main-content">
      <form class="" action="testing2.php" method="post">
        <div class="col-md-4">
          <label for="gender" class="form-label">Genders</label>
          <select id="gender" name="genders" class="form-select" required>
            <option value="option1">Select gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="prefer_not_to_say">Prefer not to say</option>
          </select>
          <input type="submit" name="submit" value="Submit" class="btn btn-primary px-4">
        </div>
      </form>

    </div>
  </body>
</html>
