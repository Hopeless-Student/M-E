<style media="screen">
.modal {
    display: none;
    position: fixed;
    z-index: 2000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
    background-color: #fff;
    margin: 10% auto;
    padding: 30px;
    border-radius: 10px;
    max-width: 500px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
    font-family: 'Poppins', sans-serif;
}

.close-btn {
    color: #4169E1;
    float: right;
    font-size: 30px;
    font-weight: bold;
    cursor: pointer;
}

.close-btn:hover {
    transition: 400ms ease;
    color: #002366;
}

.modal-content img {
    height: 150px;
    margin: 30px 147px 15px;
    display: block;
}

.modal-content h2 {
    text-align: center;
    font-size: 32px;
    margin: 20px 0;
    color: #4169E1;
}

.modal-content label {
    display: block;
    margin: 10px 0 5px;
    font-weight: 600;
}

.modal-content input {
    width: 100%;
    padding: 10px;
    border: 1px solid #4169E1;
    border-radius: 5px;
    margin-bottom: 15px;
    font-size: 16px;
}

.modal-content button {
    width: 100%;
    padding: 12px;
    background-color: #4169E1;
    color: white;
    border: none;
    font-weight: bold;
    font-size: 18px;
    border-radius: 25px;
    cursor: pointer;
    transition: background-color 0.4s ease;
}

.modal-content button:hover {
    background-color: #002366;
}

.modal-switch-text {
    margin-top: 15px;
    font-size: 14px;
    color: #666;
    text-align: center;
}

.modal-switch-text a {
    color: #4169E1;
    cursor: pointer;
    font-weight: 600;
    text-decoration: none;
}

.modal-switch-text a:hover {
    text-decoration: underline;
}

#signupModal input {
    width: 100%;
    margin-bottom: 12px;
    padding: 10px;
    font-size: 14px;
}

#signupModal .terms {
    margin: 10px 0;
    font-size: 13px;
}

#signupModal .terms-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    color: #303030;
}

#signupModal .terms-label input[type="checkbox"] {
    width: auto;
    height: auto;
    margin: 0;
}

#signupModal .terms-label a {
    color: #4169E1;
    text-decoration: none;
    font-weight: 600;
}

#signupModal .terms-label a:hover {
    transition: 400ms;
    text-decoration: underline;
    color: #002366;
}

#verifyEmailBtn[disabled] {
    background: #D1D1D1;
    cursor: not-allowed;
}

#termsModal .modal-content {
    max-width: 60%;
    margin: auto;
    padding: 20px 40px;
}

#termsModal ol li {
    color: #4169E1;
    font-weight: bold;
}
.eye-icon {
  position: absolute;
  top: 0%;
  right: -30%;
  transform: translateY(-55%);
  cursor: pointer;
  width: 24px;
  height: 24px;
}

.user-avatar .avatar {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  object-fit: cover;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  vertical-align: middle;
  margin-top: -2px;
  margin-right: 8px;
  display: block;
}
.user-menu .dropdown {
  font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
  display: none;
  position: absolute;
  right: 0;
  top: 100%;
  background: white;
  border: 1px solid #ddd;
  border-radius: 8px;
  list-style: none;
  padding: 8px 0;
  margin: 0;
  box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
  min-width: 160px;
  z-index: 999;
}

.user-menu .dropdown {
  font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
  display: none;
  position: absolute;
  right: 0;
  top: 100%;
  background: white;
  border: 1px solid #ddd;
  border-radius: 8px;
  list-style: none;
  padding: 8px 0;
  margin: 0;
  box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
  min-width: 160px;
  z-index: 999;
}
.user-menu .dropdown li a {
  display: block;
  padding: 10px 15px;
  text-decoration: none;
  color: #333;
  font-size: 14px;
}
.user-menu .dropdown li a:hover {
  background: #f5f5f5;
  color: #4169E1;
  font-weight: bold;
}

.avatar:hover{
  background-color: rgb(166, 186, 255);
}
.user-menu:hover .dropdown {
  display: block;
}
.user-menu {
  position: relative;
  display: inline-block;
  padding-top: 10px;
}
.user-avatar .avatar {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  object-fit: cover;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  vertical-align: middle;
  margin-top: -2px;
  margin-right: 8px;
  display: block;
}

nav .mobile-user-menu {
    display: none;
}

</style>
<div id="loginModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" id="closeLoginModal">&times;</span>

        <img src="../assets/images/M&E_LOGO-semi-transparent.png" alt="M&E Logo">

        <h2>Login</h2>

        <form id="loginForm" action="../auth/login_handler.php" method="post">
            <input type="text" placeholder="Username or Email" name="login_id" id="username" required/>
            <!-- <input type="password" placeholder="Password" id="loginpassword" name="password" required/> -->
            <div class="password-wrapper" style="position: relative;">
              <input type="password" placeholder="Password" id="loginpassword" name="password"
                     style="padding-right: 40px;" required />
              <img id="togglePassword" class="eye-icon" src="../assets/svg/eye-slash.svg" alt="Toggle Password" />
            </div>
                                <button type="submit">Log In</button>
            <?php if (isset($_SESSION['loginFailed'])): ?>
              <p class="error-message" style="color:red; margin-top:10px; font-size:0.9rem; text-align:center"> <?php echo $_SESSION['loginFailed']; unset($_SESSION['loginFailed']);?> </p>
            <?php endif; ?>
            <p class="modal-switch-text">
                Don't have an account?
                <a href="#" id="openSignupModal">Create Your Account here</a>
            </p>
        </form>
    </div>
</div>

<div id="signupModal" class="modal">
    <div class="modal-content">
        <span id="closeSignupModal" class="close-btn">&times;</span>

        <img src="../assets/images/M&E_LOGO-semi-transparent.png" alt="M&E Logo">

        <h2>Create Your Account</h2>

        <form id="signupForm" action="../auth/register_process.php" method="post">
            <input type="text" placeholder="First Name" id="firstName" name="firstName" required>

            <input type="text" placeholder="Last Name" id="lastName" name="lastName" required>

            <input type="email" placeholder="Email" id="email" name="email" required>

            <input type="password" placeholder="Password" id="password" name="password" required>

            <input type="password" placeholder="Confirm Password" id="confirmPassword" name="confirm-password" required>

            <div class="terms">
                <label class="terms-label">
                    <input type="checkbox" id="termsCheckbox" required>
                    <span>I confirm agree to our <a href="terms-of-service.php" target="_blank" id="openTermsModal">Terms and Conditions</a></span>
                </label>
            </div>

            <button type="submit" id="verifyEmailBtn" disabled>Verify Email</button>

            <p class="modal-switch-text">
                Already have an account?
                <a href="#" id="signupToLoginLink">Log in here</a>
            </p>
        </form>
    </div>
</div>
