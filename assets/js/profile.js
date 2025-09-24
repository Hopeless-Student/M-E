
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
    const gender = document.getElementById('gender');
    const dob = document.getElementById('dob');
    const province = document.getElementById('inputProvince');
    const city = document.getElementById('inputCity');
    const barangay = document.getElementById('inputBarangay');
    gender.disabled = true;
    dob.disabled = true;
    province.disabled = true;
    city.disabled = true;
    barangay.disabled = true;

    password.style.display = 'none';
    confirmPassword.style.display = 'none';
    cancel.style.display = 'none';
    saveBtn.style.display = 'none';
    uploadBtn.style.display = 'none';
    uploadBtn.disabled = true;

      uploadBtn.addEventListener('click', () => {
        profilePicInput.click();
      });

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
        gender.disabled = false;
        dob.disabled = false;
        province.disabled = false;
        city.disabled = false;
        barangay.disabled = false;

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
        gender.disabled = true;
        dob.disabled = true;
        province.disabled = true;
        city.disabled = true;
        barangay.disabled = true;
        inputs.forEach(input => {
          if (!input.classList.contains('readonly-fixed')) {
            input.setAttribute('readonly', true);
          }
        });
        window.location.reload();
      });

      const cities = window.appData.cities;
      const barangays = window.appData.barangays;
      const provinceSelect = document.getElementById('inputProvince');
      const citySelect = document.getElementById('inputCity');
      const barangaySelect = document.getElementById("inputBarangay");

      function populateCities(provinceId, selectedCityId = null) {
      citySelect.innerHTML = '<option value="">Select City</option>';
      barangaySelect.innerHTML = '<option value="">Select Barangay</option>';

      cities.filter(city => city.province_id == provinceId)
        .forEach(city => {
          let option = document.createElement('option');
          option.value = city.city_id;
          option.textContent = city.city_name;
          if (city.city_id == selectedCityId) {
            option.selected = true;
          }
          citySelect.appendChild(option);
        });
    }

    function populateBarangays(cityId, selectedBarangayId = null) {
      barangaySelect.innerHTML = '<option value="">Select Barangay</option>';

      barangays.filter(b => b.city_id == cityId)
        .forEach(b => {
          let opt = document.createElement("option");
          opt.value = b.barangay_id;
          opt.textContent = b.barangay_name;
          if (b.barangay_id == selectedBarangayId) {
            opt.selected = true;
          }
          barangaySelect.appendChild(opt);
        });
    }

    // --- Event listeners ---
    provinceSelect.addEventListener('change', function () {
      populateCities(this.value);
    });

    citySelect.addEventListener("change", function () {
      populateBarangays(this.value);
    });

    // --- Auto-select user values on load ---
    if (window.appData.userProvince) {
      provinceSelect.value = window.appData.userProvince;
      populateCities(window.appData.userProvince, window.appData.userCity);

      if (window.appData.userCity) {
        populateBarangays(window.appData.userCity, window.appData.userBarangay);
      }
      // if (window.appData.userCity) {
      //   populateBarangays(window.appData.userCity, window.appData.userBarangay);
      // }
    }
