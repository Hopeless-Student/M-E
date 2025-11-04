document.addEventListener("DOMContentLoaded", () => {
  const loginModal = document.getElementById("loginModal");
  const signupModal = document.getElementById("signupModal");


  const loginTriggers = [
    document.getElementById("openLoginModal"),
    document.querySelector(".btn-login a"),
    document.getElementById("mobileLoginLink"),
    document.getElementById("toggleLogin")
  ];

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

  const termsCheckbox = document.getElementById("termsCheckbox");
  const verifyEmailBtn = document.getElementById("verifyEmailBtn");
  if (termsCheckbox && verifyEmailBtn) {
    verifyEmailBtn.disabled = !termsCheckbox.checked;
    termsCheckbox.addEventListener("change", () => {
      verifyEmailBtn.disabled = !termsCheckbox.checked;
    });
  }
});
