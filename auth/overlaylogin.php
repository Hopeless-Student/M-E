<?php
  session_start();
  include("..\includes\database.php");
  $pdo = connect();
  $loginFailed ="";
  $showModal = false;
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $sql = "SELECT id, users, password FROM users WHERE users = :username";
        $stmt = $pdo->prepare($sql);
        $stmt-> execute(["username"=>$username]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC); // nagiging assoc array siya
        if($user){
            if($user && password_verify($password, $user["password"])){
              $_SESSION["id"] = $user["id"];
              $_SESSION["user"] = $user["users"];
              header("Location: ..\index.php");
              exit();
            } else {
              $loginFailed = "Incorrect password";
              $showModal = true;
            }
        } else {
            $loginFailed = "User not found";
            $showModal = true;
        }
      }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login Modal</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body, html {
      margin: 0;
      padding: 0;
      height: 100%;
      font-family: Arial, sans-serif;
      background-color: #f0f2f5;
    }

    /* Show/Hide overlay */
    .overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      background-color: rgba(0, 0, 0, 0.5);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 9999;
      display: none; /* hidden by default */
    }

    .overlay.active {
      display: flex;
    }

    .formbox {
      background-color: lightblue;
      width: 350px;
      padding: 30px 20px;
      border-radius: 20px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
      position: relative;
    }

    .formbox h2 {
      margin-top: 0;
      text-align: center;
    }

    .inputbox {
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      border: none;
      border-radius: 5px;
    }

    .submitbtn {
      width: 100%;
      padding: 10px;
      background-color: #007BFF;
      border: none;
      border-radius: 5px;
      color: white;
      font-weight: bold;
      cursor: pointer;
    }

    .submitbtn:hover {
      background-color: #0056b3;
    }

    .close-btn {
      position: absolute;
      top: 10px;
      right: 15px;
      font-size: 24px;
      font-weight: bold;
      color: #333;
      cursor: pointer;
    }

    .open-login-btn {
      margin: 100px auto;
      display: block;
      padding: 10px 20px;
      font-size: 16px;
      background-color: #28a745;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
  </style>
</head>
<body>

  <button class="open-login-btn" onclick="showLogin()">Log in</button>

  <!-- Login Overlay -->
  <div id="loginOverlay" class="overlay">
    <div class="formbox">
      <span class="close-btn" onclick="hideLogin()">&times;</span>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
        <h2>Login</h2>
        <div class="inputbox">
          <label for="username">Username</label>
          <input type="text" name="username" id="username" placeholder="Enter your username" required>
        </div>
        <div class="inputbox">
          <label for="password">Password</label>
          <input type="password" name="password" id="password" placeholder="Enter your password" required>
        </div>
        <?php if (!empty($loginFailed)) : ?>
          <div style="color: red; margin-bottom: 10px; text-align: center;">
            <?php echo $loginFailed; ?>
          </div>
        <?php endif; ?>
        <button type="submit" class="submitbtn">Log In</button>
      </form>
    </div>
  </div>
  <script>
      function showLogin() {
        document.getElementById('loginOverlay').classList.add('active');
      }

      function hideLogin() {
        document.getElementById('loginOverlay').classList.remove('active');
      }

      <?php if ($showModal): ?>
        document.addEventListener('DOMContentLoaded', function () {
          showLogin();
        });
      <?php endif; ?>
  </script>

</body>
</html>
