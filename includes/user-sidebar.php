  <?php require_once __DIR__ .'/../auth/auth.php';
  $profileImage = !empty($user['profile_image'])
      ? "../assets/profile-pics/" . htmlspecialchars($user['profile_image'])
      : "../assets/images/default.png";
  ?>
    <button id="sidebarToggle" class="sidebar-toggle d-lg-none">
    ☰ Menu
  </button>
        <aside class="sidebar" id="sidebar">
        <div class="profile text-center">
            <img src="<?php echo $profileImage; ?>"
                 alt="User Avatar"
                 class="avatar">

            <h2 class="username mt-2">
                <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?>
            </h2>
            <p class="role">Customer</p>
        </div>
        <nav class="sidebar-nav">
            <ul>
                <li>  <a href="../pages/index.php"><img src="../assets/svg/home.svg" alt="home icon"> Home</a></li>
                <li>  <a href="profile.php"><img src="../assets/svg/profile.svg" alt="profile icon"> Profile</a></li>
                <li>  <a href="../user/order-history.php"><img src="../assets/svg/orders.svg" alt="orders icon"> Orders</a></li>
                <li>  <a href="../user/request.php"><img src="../assets/svg/request.svg" alt="request icon"> Request</a></li>
                <li>  <a href="../auth/logout.php"><img src="../assets/svg/logout.svg" alt="logout icon"> Logout</a></li>
            </ul>
        </nav>
      </aside>
      <div class="sidebar-overlay d-lg-none"></div>

      <script>
document.addEventListener("DOMContentLoaded", () => {
  const toggleBtn = document.getElementById("sidebarToggle");
  const sidebar = document.getElementById("sidebar");
  const overlay = document.querySelector(".sidebar-overlay");

  toggleBtn.addEventListener("click", () => {
    sidebar.classList.toggle("active");
    toggleBtn.style.display = sidebar.classList.contains("active") ? "none" : "block";
  });

  if (overlay) {
    overlay.addEventListener("click", () => {
      sidebar.classList.remove("active");
      toggleBtn.style.display = "block";
    });
  }
  document.addEventListener('hidden.bs.modal', function (event) {

  document.activeElement.blur();

  const toggleBtn = document.querySelector('.sidebar-toggle');
  if (toggleBtn) toggleBtn.focus();
});

});
</script>
