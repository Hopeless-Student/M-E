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

    <div class="main-content">
      <div class="card shadow-sm p-4 profile-card">
        <h3 class="mb-4 text-center" id="header-text">Profile Info</h3>
        <form class="row g-3" method="POST" action="update_profile.php" enctype="multipart/form-data">

          <!-- Profile Picture -->
          <div class="col-12 text-center">
            <img id="profilePreview" src="../assets/images/reirei.jpg"
               class="profile-img mb-2 rounded-circle img-thumbnail">
               <br>
            <input type="file" name="profile_pic" id="profilePicInput" accept="image/*" style="display: none;">
            <button type="button" class="btn btn-outline-primary" id="uploadBtn">Upload New Photo</button>
            <button type="button" class="btn btn-primary px-4" id="edit">Edit</button>
            <button type="button" class="btn btn-primary px-4" id="cancel">Cancel</button>
          </div>
          <!-- Email -->
          <div class="col-md-6">
            <label for="inputEmail" class="form-label">Email</label>
            <input type="email" class="form-control" id="inputEmail" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
          </div>

          <!-- Username -->
          <div class="col-md-6">
            <label for="inputUsername" class="form-label">Username</label>
            <input type="text" class="form-control" id="inputUsername" name="username" value="<?php echo htmlspecialchars($user['username'].' id='.$user['id']); ?>" readonly>
          </div>

          <!-- Password -->
          <div class="col-md-6">
            <label for="inputPassword" class="form-label">Password</label>
            <input type="password" class="form-control" id="inputPassword" name="password" value="" readonly>
          </div>

          <!-- Confirm Password -->
          <div class="col-md-6">
            <label for="inputConfirmPassword" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="inputConfirmPassword" name="confirm-password" value=""readonly>
          </div>

          <!-- Address -->
          <div class="col-12">
            <label for="inputAddress" class="form-label">Address</label>
            <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" readonly>
          </div>

          <div class="col-12">
            <label for="inputAddress2" class="form-label">Address 2 (optional)</label>
            <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor" value="" readonly>
          </div>

          <!-- City / Contact no. / Zip -->
          <div class="col-md-6">
            <label for="inputCity" class="form-label">City</label>
            <input type="text" class="form-control" id="inputCity" name="city" value="<?php echo htmlspecialchars($user['city']); ?>" readonly>
          </div>
          <div class="col-md-4">
            <label for="inputContact" class="form-label">Contact No.</label>
            <input type="text" name="contact-no" class="form-control" placeholder="+63" name="contact-no" value="<?php echo htmlspecialchars($user['contact_number']); ?>" readonly>
          </div>

          <!-- Submit -->
          <div class="col-12 text-center">
            <button type="submit" class="btn btn-primary px-4" id="saveBtn" name="save">Save Changes</button>
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
        const pass = document.getElementById("inputPassword").value;
        const confirm = document.getElementById("inputConfirmPassword").value;
        if (pass !== confirm) {
          e.preventDefault();
          alert("Passwords do not match!");
        }
      });

      edit.addEventListener('click', ()=>{
        edit.style.display = 'none';
        cancel.style.display = '';
        saveBtn.style.display = '';
        uploadBtn.style.display = '';
        headerText.textContent = "Edit Profile";
        uploadBtn.disabled = false;

        inputs.forEach(input => {
          if(input.hasAttribute('readonly')){
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
          input.setAttribute('readonly', true);
          input.value = "";
          });
      });

      </script>

  </body>
</html>
