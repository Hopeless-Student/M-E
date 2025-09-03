<?php
  session_start();
  require_once __DIR__ .'/../includes/database.php';
  $pdo = connect();

  if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS);
    $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_SPECIAL_CHARS);
    $contact_no = filter_input(INPUT_POST, 'contact-no', FILTER_SANITIZE_NUMBER_INT);
    $password        = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm-password'] ?? '';
    $updateFields = [
      'username'       => $username,
      'address'        => $address,
      'city'           => $city,
      'contact_number' => $contact_no,
      'id'             => $_SESSION['user_id']
    ];


    try {
        $sql = "UPDATE users
        SET username=:username,
            address=:address,
            city=:city,
            contact_number=:contact_number,
            updated_at= NOW(),
            isActive= 1";
            if(!empty($password) && !empty($confirmPassword)){
              if ($password !== $confirmPassword) {
                die("Passwords do not match!");
              }
              $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
              $sql .= ", password=:password";
              $updateFields['password'] = $hashedPassword;
            }
            $sql .= " WHERE id=:id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($updateFields);

        $_SESSION['update_status'] = "Updated profile successfully!";
        header('Location: ../user/profile.php');
        exit;
    } catch (PDOException $e) {
      echo "Database Error: " . $e->getMessage();
    }

  } else {
    header("Location: ../test.php");
  }
 ?>
