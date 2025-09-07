<?php

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Edit User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
    rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB"
    crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/user-sidebar.css">
  </head>
  <body>
    <?php include('../includes/user-sidebar.php'); ?>

    <?php if(!isset($_SESSION['update_status']) && $_SESSION['isActive'] == 0): ?>
    <div class="alert alert-warning alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3 shadow"
     role="alert" style="z-index: 1050; max-width: 600px;">
      <strong>⚠️ Please complete your profile!</strong> before proceeding.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif; ?>
  <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3 shadow"
         role="alert" style="z-index: 1050; max-width: 600px;">
         <?php
             echo htmlspecialchars($_SESSION['error']);
             unset($_SESSION['error']);
          ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
  <?php endif; ?>

    <div class="main-content">
      <div class="card shadow-sm p-4 profile-card">
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
          <div class="col-md-6">
            <label for="firstName" class="form-label">First Name</label>
            <input type="text" class="form-control" id="firstName" name="first_name"
                   value="<?php echo htmlspecialchars($user['first_name']); ?>" readonly>
          </div>

          <!-- Last Name -->
          <div class="col-md-6">
            <label for="lastName" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="lastName" name="last_name"
                   value="<?php echo htmlspecialchars($user['last_name']); ?>" readonly>
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

          <!-- Address -->
          <div class="col-12">
            <label for="inputAddress" class="form-label">Address</label>
            <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" readonly required>
          </div>

          <!-- <div class="col-12">
            <label for="inputAddress2" class="form-label">Address 2 (optional)</label>
            <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor" value="" readonly>
          </div> -->

          <!-- City / Contact no. / Zip -->
          <div class="col-md-2">
            <label for="inputCity" class="form-label">City</label>
            <input type="text" class="form-control" id="inputCity" name="city" value="<?php echo htmlspecialchars($user['city']); ?>" readonly required>
          </div>
          <div class="col-md-4">
            <label for="inputContact" class="form-label">Contact No.</label>
            <input type="text" name="contact-no" class="form-control" placeholder="+63" name="contact-no" value="<?php echo htmlspecialchars($user['contact_number']); ?>" readonly required>
          </div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>

    <script>

      const profilePicInput = document.getElementById('profilePicInput');
      const uploadBtn = document.getElementById('uploadBtn');
      const profilePreview = document.getElementById('profilePreview');
      const edit = document.getElementById('edit');
      const cancel = document.getElementById('cancel');
      const headerText = document.getElementById('header-text');
      const saveBtn = document.querySelector("form button[type='submit']");
      const inputs = document.querySelectorAll("form input");
      const password = document.getElementById('pass');
      const confirmPassword = document.getElementById('confirmPass');
      password.style.display = 'none';
      confirmPassword.style.display = 'none';
      cancel.style.display = 'none';
      saveBtn.style.display = 'none';
      uploadBtn.style.display = 'none';
      uploadBtn.disabled = true;

      uploadBtn.addEventListener('click', () => {
        profilePicInput.click();
      });

      // Preview the selected image
      profilePicInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
          const reader = new FileReader();
          reader.onload = function(e) {
            profilePreview.src = e.target.result;
          }
          reader.readAsDataURL(file);
        }
      });

      document.querySelector("form").addEventListener("submit", function(e) {
          const pass = document.getElementById('inputPassword').value;
          const confirm = document.getElementById('inputConfirmPassword').value;
          const errorBox = document.getElementById("passwordError");
        if (pass !== confirm) {
          e.preventDefault();
          errorBox.classList.remove("d-none");
          document.getElementById("inputPassword").classList.add("is-invalid");
          document.getElementById("inputConfirmPassword").classList.add("is-invalid");
          //alert("Passwords do not match!");
        } else {
          errorBox.classList.add("d-none");
          document.getElementById("inputPassword").classList.remove("is-invalid");
          document.getElementById("inputConfirmPassword").classList.remove("is-invalid");
        }
      });

      edit.addEventListener('click', ()=>{
        edit.style.display = 'none';
        cancel.style.display = '';
        saveBtn.style.display = '';
        uploadBtn.style.display = '';
        password.style.display = '';
        confirmPass.style.display = '';
        headerText.textContent = "Edit Profile";
        uploadBtn.disabled = false;

        inputs.forEach(input => {
          if (input.hasAttribute('readonly') && !input.classList.contains('readonly-fixed')) {
            input.removeAttribute('readonly');
          }
        });
      });

      cancel.addEventListener('click', ()=>{
        edit.style.display = '';
        cancel.style.display = 'none';
        saveBtn.style.display = 'none';
        uploadBtn.style.display = 'none';
        headerText.textContent = "Profile Info";
        uploadBtn.disabled = true;

        inputs.forEach(input => {
          if (!input.classList.contains('readonly-fixed')) {
            input.setAttribute('readonly', true);
          }
        });
        window.location.reload();
      });


      </script>

  </body>
</html>
