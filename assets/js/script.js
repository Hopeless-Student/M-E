
//script for Register
document.getElementById('verifyBtn').addEventListener('click', () => {
  const email = document.getElementById('email').value.trim();
  const message = document.getElementById('message');

  if (email && validateEmail(email)) {
    message.textContent = 'Verification email sent!';
    message.style.color = 'green';
  } else {
    message.textContent = 'Please enter a valid email.';
    message.style.color = 'red';
  }
  });

  function validateEmail(email) {
  const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return re.test(email.toLowerCase());
  }
