<?php
  session_start();
  include('../includes/database.php');
  require 'sendEmail.php';
  $pdo = connect();

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_SPECIAL_CHARS);
    $lname = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $token = bin2hex(random_bytes(32));
      if(!empty($fname) && !empty($lname) && !empty($email)){
        $_SESSION["first_name"] = $fname;
        $_SESSION["last_name"] = $lname;
        $_SESSION["email"] = $email;

          try {
            $sql = "INSERT INTO users(first_name, last_name, email, verification_token)
                    VALUES(:fname, :lname, :email, :token)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
              ":fname"=>$fname,
              ":lname"=>$lname,
              ":email"=>$email,
              ":token"=>$token
            ]);
            if(sendVerificationToEmail($email,$fname,$lname,$token)){
              echo "Registration successful! Check your email to verify your account.";
            } else {
              echo "Registration successful, but failed to send verification email.";
            }
          } catch (PDOException $e) {
            echo "Error connection: " . $e->getMessage();
          }
      }
  } else {
    echo "Invalid input data!";
  }
 ?>
