/*Script sa register validation*/
    document.getElementById('userForm').addEventListener('submit', function (e) {
      const emailInput = document.getElementById('email');
      const email = emailInput.value.trim();
      const message = document.getElementById('message');
      message.innerHTML = '';
      if (!validateEmail(email)) {
        e.preventDefault();
        message.textContent = 'Please enter a valid email.';
        message.style.color = 'red';
      }


    });

    function validateEmail(email) {
      const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return re.test(email.toLowerCase());
    }

    document.querySelector('form').addEventListener("submit", function(e){
      const pass = document.getElementById('password');
      const confirm = document.getElementById('confirm');
      //const errorBox = document.getElementById("passwordError");
      if (pass.value !== confirm.value) {
        e.preventDefault();
        //errorBox.classList.remove("d-none");
        pass.classList.add("is-invalid");
        confirm.classList.add("is-invalid");
        //alert("Passwords do not match!");
      } else {
        //errorBox.classList.add("d-none");
        pass.classList.remove("is-invalid");
        confirm.classList.remove("is-invalid");
      }

    })
