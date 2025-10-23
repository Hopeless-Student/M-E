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
                <li><a href="../pages/index.php">Home</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="../user/order-history.php">Orders</a></li>
                <li><a href="../user/request.php">Request</a></li>
                <li><a href="../auth/logout.php">Logout</a></li>
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
});
</script>
