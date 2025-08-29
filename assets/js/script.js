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
