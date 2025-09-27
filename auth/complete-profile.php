<?php
  session_start();
  require_once __DIR__ .'/../includes/database.php';
  $pdo = connect();

  if($_SERVER["REQUEST_METHOD"] == "POST"){
    $fname = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_SPECIAL_CHARS);
    $mname = filter_input(INPUT_POST, 'middle_name', FILTER_SANITIZE_SPECIAL_CHARS);
    $lname = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_SPECIAL_CHARS);
    $gender= filter_input(INPUT_POST, 'genders', FILTER_SANITIZE_SPECIAL_CHARS);
    $dob= filter_input(INPUT_POST, 'dob', FILTER_SANITIZE_STRING);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $province = filter_input(INPUT_POST, 'province', FILTER_VALIDATE_INT);
    $city = filter_input(INPUT_POST, 'city', FILTER_VALIDATE_INT);
    $barangay = filter_input(INPUT_POST, 'barangay', FILTER_VALIDATE_INT);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS);

    $province = $province !== false ? $province : null;
    $city     = $city !== false ? $city : null;
    $barangay = $barangay !== false ? $barangay : null;
    if (is_null($province) || is_null($city) || is_null($barangay)) {
    $_SESSION['error'] = "Please select your full address (province, city, barangay).";
    header("Location: ../user/profile.php");
    exit;
}

    if ($dob) {
    $d = DateTime::createFromFormat('Y-m-d', $dob);
        if (!$d || $d->format('Y-m-d') !== $dob) {
            $_SESSION['error'] = "Invalid date format for Date of Birth.";
            header("Location: ../user/profile.php");
            exit;
        }
    }
    $contact_no = trim($_POST['contact-no']);
    if (preg_match('/^(?:\+63|0)\d{10}$/', $contact_no)) {
      if (strpos($contact_no, '0') === 0) {
          $contact_no = '+63' . substr($contact_no, 1);
      }
    } else {
        $_SESSION['error'] = "Invalid contact number. Use format +639XXXXXXXXX or 09XXXXXXXXX.";
        header("Location: ../user/profile.php");
        exit;
    }


    $password        = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm-password'] ?? '';
    $updateFields = [
      'first_name'     => $fname,
      'middle_name'      => $mname,
      'last_name'      => $lname,
      'gender'      => $gender,
      'dob'      => $dob,
      'username'       => $username,
      'province'       => $province,
      'city'       => $city,
      'barangay'       => $barangay,
      'address'        => $address,
      'contact_number' => $contact_no,
      'id'             => $_SESSION['user_id']
    ];


    try {
        $sql = "UPDATE users
        SET first_name=:first_name,
            middle_name=:middle_name,
            last_name=:last_name,
            gender=:gender,
            date_of_birth=:dob,
            username=:username,
            province_id=:province,
            city_id=:city,
            barangay_id=:barangay,
            address=:address,
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
      error_log("Database Error: " . $e->getMessage());
      $_SESSION['error'] = "Something went wrong. Please try again later.";
      header("Location: ../user/profile.php");
      exit;
    }

  } else {
    header("Location: ../test.php");
  }
 ?>
