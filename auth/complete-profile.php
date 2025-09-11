<?php
  session_start();
  require_once __DIR__ .'/../includes/database.php';
  $pdo = connect();

  if($_SERVER["REQUEST_METHOD"] == "POST"){
    $fname = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_SPECIAL_CHARS);
    $lname = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_SPECIAL_CHARS);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS);
    $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_SPECIAL_CHARS);
    $contact_no = filter_input(INPUT_POST, 'contact-no', FILTER_SANITIZE_NUMBER_INT);
    $password        = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm-password'] ?? '';
    $updateFields = [
      'first_name'     => $fname,
      'last_name'      => $lname,
      'username'       => $username,
      'address'        => $address,
      'city'           => $city,
      'contact_number' => $contact_no,
      'id'             => $_SESSION['user_id']
    ];


    try {
        $sql = "UPDATE users
        SET first_name=:first_name,
            last_name=:last_name,
            username=:username,
            address=:address,
            city=:city,
            contact_number=:contact_number,
            updated_at= NOW(),
            isActive= 1";
            if(!empty($password) && !empty($confirmPassword)){
              if ($password !== $confirmPassword) {
                $_SESSION['update_status'] = "Passwords do not match!";
                header("Location: ../user/profile.php");
                exit;
                //die("Passwords do not match!");
              }
              $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
              $sql .= ", password=:password";
              $updateFields['password'] = $hashedPassword;
            }
            if(isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK){
              $fileSize = $_FILES['profile_pic']['size'];
              $maxSize = 2 * 1024 *1024;

              if($fileSize >$maxSize){
                $_SESSION['error'] = "File is too large! Max size allowed is 2MB.";
                header("Location: ../user/profile.php");
                exit;
              }

               $fileTmp  = $_FILES['profile_pic']['tmp_name'];
               $fileName = $_FILES['profile_pic']['name'];
               $fileExt  = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
               $allowed  = ['jpg','jpeg','png','gif'];

               if(in_array($fileExt,$allowed)){
                 $newName = "user_" . $_SESSION['user_id'] . "_" . time() . "." . $fileExt;
                 $uploadDir = __DIR__ . '/../assets/profile-pics/';
                 $uploadFile = $uploadDir . $newName;

                 if(move_uploaded_file($fileTmp, $uploadFile)){
                   $sql .= ", profile_image=:profile_image";
                   $updateFields['profile_image'] = $newName;
                 }
               } else {
                 $_SESSION['error'] = "Invalid file type. Please upload JPG, or PNG.";
                 header('Location: ../user/profile.php');
                 exit;
               }
            }
            $sql .= " WHERE user_id=:id";
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
