<?php require_once __DIR__ .'/../auth/auth.php';
?>
  <aside class="sidebar">
      <div class="profile">
          <img src="../assets/images/reirei.jpg" alt="User Avatar" class="avatar">
          <h2 class="username"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></h2>
          <p class="role">Customer</p>
      </div>
      <nav class="sidebar-nav">
          <ul>
              <li><a href="dashboard.php">Dashboard</a></li>
              <li><a href="profile.php">Profile</a></li>
              <li><a href="edit-profile.php">Settings</a></li>
              <li><a href="../auth/logout.php">Logout</a></li>
          </ul>
      </nav>
  </aside>
