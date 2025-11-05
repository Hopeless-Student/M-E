document.addEventListener("DOMContentLoaded", () => {
  const loginModal = document.getElementById("loginModal");
  const signupModal = document.getElementById("signupModal");

  const mobileCart = document.querySelector(".mobile-nav-cart");
  const isLoggedIn = mobileCart?.dataset.loggedIn === "1";
  const loginTriggers = [
    document.getElementById("openLoginModal"),
    document.querySelector(".btn-login a"),
    document.getElementById("mobileLoginLink"),
    document.getElementById("toggleLogin"),
    document.getElementById("mobileCartLink"),
    document.querySelector(".mobile-cart-icon"),
    document.getElementById("mobileCheckoutBtn")
  ];
if (mobileCart && !isLoggedIn) loginTriggers.push(mobileCart);
  loginTriggers.forEach(trigger => {
    if (trigger) {
      trigger.addEventListener("click", (e) => {
        e.preventDefault();
        // console.log('Login trigger clicked:', trigger.id || trigger.className);
        if (signupModal) signupModal.style.display = "none";
        if (loginModal) loginModal.style.display = "block";
      });
    }
  });

  const closeLoginBtn = document.getElementById("closeLoginModal");
  if (closeLoginBtn && loginModal) {
    closeLoginBtn.addEventListener("click", () => {
      loginModal.style.display = "none";
    });
  }

  const signupTrigger = document.getElementById("openSignupModal");
  if (signupTrigger && signupModal && loginModal) {
    signupTrigger.addEventListener("click", (e) => {
      e.preventDefault();
      loginModal.style.display = "none";
      signupModal.style.display = "block";
    });
  }

  const closeSignupBtn = document.getElementById("closeSignupModal");
  if (closeSignupBtn && signupModal) {
    closeSignupBtn.addEventListener("click", () => {
      signupModal.style.display = "none";
    });
  }

  const signupToLoginLink = document.querySelector("#signupModal .modal-switch-text a");
  if (signupToLoginLink && signupModal && loginModal) {
    signupToLoginLink.addEventListener("click", (e) => {
      e.preventDefault();
      signupModal.style.display = "none";
      loginModal.style.display = "block";
    });
  }

  window.addEventListener("click", (e) => {
    if (e.target === loginModal) loginModal.style.display = "none";
    if (e.target === signupModal) signupModal.style.display = "none";
  });

  // password toggle
function initLoginToggle() {
  const togglePassword = document.getElementById("togglePassword");
  const loginPassword = document.getElementById("loginpassword");

  if (togglePassword && loginPassword) {
    togglePassword.addEventListener("click", () => {
      const isPassword = loginPassword.type === "password";
      loginPassword.type = isPassword ? "text" : "password";
      togglePassword.src = isPassword
        ? "../assets/svg/eye.svg"
        : "../assets/svg/eye-slash.svg";
    });
  }
}

function initSignupToggle() {
  const signupPasswordInput = document.getElementById("password");
  const signupConfirmPasswordInput = document.getElementById("confirmPassword");
  const toggleSignUpPassword = document.getElementById("toggleSignUpPassword");
  const toggleConfirmPassword = document.getElementById("toggleConfirmPassword");

  if (!signupPasswordInput || !signupConfirmPasswordInput) return;

  function toggleBothPasswords() {
    const isPassword = signupPasswordInput.type === "password";
    const newType = isPassword ? "text" : "password";
    signupPasswordInput.type = newType;
    signupConfirmPasswordInput.type = newType;

    const newIcon = isPassword
      ? "../assets/svg/eye.svg"
      : "../assets/svg/eye-slash.svg";

    if (toggleSignUpPassword) toggleSignUpPassword.src = newIcon;
    if (toggleConfirmPassword) toggleConfirmPassword.src = newIcon;
  }

  if (toggleSignUpPassword) toggleSignUpPassword.addEventListener("click", toggleBothPasswords);
  if (toggleConfirmPassword) toggleConfirmPassword.addEventListener("click", toggleBothPasswords);
}

initLoginToggle();
initSignupToggle();


  const termsCheckbox = document.getElementById("termsCheckbox");
  const verifyEmailBtn = document.getElementById("verifyEmailBtn");
  if (termsCheckbox && verifyEmailBtn) {
    verifyEmailBtn.disabled = !termsCheckbox.checked;
    termsCheckbox.addEventListener("change", () => {
      verifyEmailBtn.disabled = !termsCheckbox.checked;
    });
  }
});
