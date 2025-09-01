// console.log("Script Loaded");
//
//     let remainingTime = 60;
//     const timerText = document.getElementById('timer');
//     const resendBtn = document.getElementById('resendBtn');
//     let countdownInterval;
//
//   resendBtn.addEventListener('click', function () {
//
//   if (countdownInterval) {
//     clearInterval(countdownInterval);
//   }
//   remainingTime = 60;
//   resendBtn.disabled = true;
//
//   countdownInterval = setInterval(function () {
//     if (remainingTime <= 0) {
//       clearInterval(countdownInterval);
//       timerText.style.display = 'none';
//       resendBtn.disabled = false;
//       timerText.style.color = '#888';
//       timerText.textContent = `You can send in: 60 seconds`;
//       //alert("Time's up!");
//     } else if (remainingTime <= 10) {
//       timerText.style.color = 'green';
//       timerText.textContent = `You can resend in: ${remainingTime} seconds`;
//       remainingTime--;
//     } else {
//       timerText.textContent = `You can resend in: ${remainingTime} seconds`;
//       remainingTime--;
//       }
//     }, 300);
//   });
