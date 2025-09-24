<?php
include('../includes/user-sidebar.php');
require_once __DIR__ . '/../includes/database.php';
$pdo = connect();
$provinces = $pdo->query("SELECT province_id, province_name FROM provinces ORDER BY province_name")->fetchAll(PDO::FETCH_ASSOC);
$cities = $pdo->query("SELECT city_id, city_name, province_id FROM cities ORDER BY city_name")->fetchAll(PDO::FETCH_ASSOC);
$barangays = $pdo->query("SELECT barangay_id, barangay_name, city_id FROM barangays ORDER BY barangay_name")->fetchAll(PDO::FETCH_ASSOC);
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Edit User Profile</title>
    <link href="../bootstrap-5.3.8-dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/user-sidebar.css">
  </head>
  <body>

    <div class="main-content">
      <div class="card shadow-sm p-4 profile-card position-relative">
        <?php if(!isset($_SESSION['update_status']) && $_SESSION['isActive'] == 0): ?>
          <div class="alert alert-warning alert-dismissible fade show mx-auto text-center"
          role="alert" style="max-width: 600px;">
          <strong>⚠️ Please complete your profile!</strong> before proceeding.
          <?php unset($_SESSION['update_status']); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php elseif(!empty($_SESSION['update_status'])): ?>
        <div class="alert alert-success alert-dismissible fade show mx-auto text-center"
        role="alert" style="max-width: 600px;">
        ✅ <?php echo htmlspecialchars($_SESSION['update_status']);
        unset($_SESSION['update_status']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
      <div class="alert alert-danger alert-dismissible fade show mx-auto text-center"
      role="alert" style="max-width: 600px;">
      ❌ <?php
      echo htmlspecialchars($_SESSION['error']);
      unset($_SESSION['error']);
      ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif; ?>
        <h3 class="mb-4 text-center" id="header-text">Profile Info</h3>
        <form class="row g-3" method="POST" action="../auth/complete-profile.php" enctype="multipart/form-data">

          <!-- Profile Picture -->
          <div class="col-12 text-center">
            <?php
              $profileImage = !empty($user['profile_image'])
                  ? "../assets/profile-pics/" . htmlspecialchars($user['profile_image'])
                  : "../assets/images/default.png";
              ?>
              <img id="profilePreview" src="<?php echo $profileImage; ?>"
                class="profile-img mb-2 rounded-circle">
               <br>
            <input type="file" name="profile_pic" id="profilePicInput" accept="image/*" style="display: none;">

            <button type="button" class="btn btn-outline-primary" id="uploadBtn">Upload New Photo</button>
            <button type="button" class="btn btn-primary px-4" id="edit">Edit</button>
            <button type="button" class="btn btn-primary px-4" id="cancel">Cancel</button>
          </div>
          <!-- First Name -->
          <div class="col-md-4">
            <label for="firstName" class="form-label">First Name</label>
            <input type="text" class="form-control" id="firstName" name="first_name"
                   value="<?php echo htmlspecialchars($user['first_name']); ?>" readonly>
          </div>
          <div class="col-md-4">
            <label for="middleName" class="form-label">Middle Name</label>
            <input type="text" class="form-control" id="middleName" name="middle_name"
                   value="<?php echo htmlspecialchars($user['middle_name']); ?>" readonly>
          </div>

          <!-- Last Name -->
          <div class="col-md-4">
            <label for="lastName" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="lastName" name="last_name"
                   value="<?php echo htmlspecialchars($user['last_name']); ?>" readonly>
          </div>
          <!-- Gender  -->
          <div class="col-md-4">
            <label for="gender" class="form-label">Gender</label>
            <select id="gender" name="genders" class="form-select">
              <option value="">Select gender</option>
              <option value="Male"   <?php echo ($user['gender'] === 'Male') ? 'selected' : ''; ?>>Male</option>
              <option value="Female" <?php echo ($user['gender'] === 'Female') ? 'selected' : ''; ?>>Female</option>
              <option value="Prefer not to say" <?php echo ($user['gender'] === 'Prefer not to say') ? 'selected' : ''; ?>>Prefer not to say</option>
            </select>
          </div>

          <!-- DOB -->
          <div class="col-md-4">
            <label for="dob" class="form-label">Date of Birth</label>
            <input type="date" id="dob" name="dob" class="form-control" value="<?php echo htmlspecialchars($user['date_of_birth']); ?>" required readonly>
          </div>
          <!-- Contact no -->
          <div class="col-md-4">
            <label for="inputContact" class="form-label">Contact No.</label>
            <input type="tel" class="form-control"
            maxlength="13"
            placeholder="+639123456789"
            name="contact-no" pattern="^(\+63|0)\d{10}$"
            value="<?php echo htmlspecialchars($user['contact_number']); ?>" readonly required>
            <!-- <small class="form-text text-muted">Format: +639xxxxxxxxx or 09xxxxxxxxx</small> -->
          </div>
          <!-- Email -->
          <div class="col-md-6">
            <label for="inputEmail" class="form-label">Email</label>
            <input type="email" class="form-control" id="inputEmail" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
          </div>

          <!-- Username -->
          <div class="col-md-6">
            <label for="inputUsername" class="form-label">Username</label>
            <input type="text" class="form-control" id="inputUsername" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" readonly required>
          </div>
          <!-- Password -->
          <div class="col-md-6" id="pass">
            <label for="inputPassword" class="form-label">Password</label>
            <input type="password" class="form-control" id="inputPassword" name="password" value="" readonly>
          </div>

          <!-- Confirm Password -->
          <div class="col-md-6" id="confirmPass">
            <label for="inputConfirmPassword" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="inputConfirmPassword" name="confirm-password" value=""readonly>
          </div>

          <!-- Province -->
          <div class="col-4">
            <label for="inputProvince" class="form-label">Province</label>
            <select class="form-select" id="inputProvince" name="province" required>
              <option value="">Select Province</option>
              <?php foreach ($provinces as $province): ?>
                <option value="<?= $province['province_id'] ?>"><?= htmlspecialchars($province['province_name']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <!-- City -->
          <div class="col-md-4">
            <label for="inputCity" class="form-label">City</label>
            <select class="form-select" id="inputCity" name="city" required>
              <option value="<?php echo htmlspecialchars($user['city_id']) ?>">Select City</option>

            </select>
          </div>
          <!-- Barangays -->
          <div class="col-md-4">
            <label for="inputBarangay" class="form-label">Barangay</label>
            <select class="form-select" id="inputBarangay" name="barangay" required>
              <option value="">Select Barangay</option>

            </select>
          </div>
          <!-- Address -->
          <div class="col-4">
            <label for="inputAddress" class="form-label">Address</label>
            <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" readonly required>
          </div>

          <!-- <div class="col-12">
            <label for="inputAddress2" class="form-label">Address 2 (optional)</label>
            <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor" value="" readonly>
          </div> -->

          <!-- City / Contact no. / Zip -->
          <!-- Created At -->
          <div class="col-md-3">
            <label class="form-label">Created At</label>
            <input type="text" class="form-control readonly-fixed"
                   value="<?php echo date("M d, Y h:i A", strtotime($user['created_at'])); ?>" readonly>
          </div>

          <!-- Updated At -->
          <div class="col-md-3">
            <label class="form-label">Updated At</label>
            <input type="text" class="form-control readonly-fixed"
                   value="<?php echo date("M d, Y h:i A", strtotime($user['updated_at'])); ?>" readonly>
          </div>


          <!-- Submit -->
          <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary px-4" id="saveBtn" name="save">Save Changes</button>
          </div>
          <div id="passwordError"
          class="alert alert-danger mt-3 d-none"
          role="alert">
          Passwords do not match!
        </div>
        </form>
      </div>
    </div>
    <!-- <script src="bootstrap-5.3.8-dist\js\bootstrap.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script> -->
    <script>
    window.appData = {
      cities: <?= json_encode($cities) ?>,
      barangays: <?= json_encode($barangays)?>,
      userProvince: <?= (int)$user['province_id'] ?>,
      userCity: <?= (int)$user['city_id'] ?>,
      userBarangay: <?= (int)$user['barangay_id'] ?>
    };
    </script>
    <script src="../assets/js/profile.js"></script>

    <script src="../bootstrap-5.3.8-dist/js/bootstrap.min.js"></script>
  </body>
</html>
