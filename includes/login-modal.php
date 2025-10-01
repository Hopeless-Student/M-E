<div id="loginModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" id="closeLoginModal">&times;</span>

        <img src="../assets/images/M&E_LOGO-semi-transparent.png" alt="M&E Logo">

        <h2>Login</h2>

        <form id="loginForm" action="../auth/login_handler.php" method="post">
            <input type="text" placeholder="Username or Email" name="login_id" id="username" required/>

            <input type="password" placeholder="Password" id="loginpassword" name="password" required/>

            <button type="submit">Log In</button>

            <p class="modal-switch-text">
                Don't have an account?
                <a href="#" id="openSignupModal">Create Your Account here</a>
            </p>
        </form>
    </div>
</div>
