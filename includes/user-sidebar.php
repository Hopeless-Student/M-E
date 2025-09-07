  <?php require_once __DIR__ .'/../auth/auth.php';
  $profileImage = !empty($user['profile_image'])
      ? "../assets/profile-pics/" . htmlspecialchars($user['profile_image'])
      : "../assets/images/default.png";
  ?>
        <aside class="sidebar">
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
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="../pages/index.php">Settings</a></li>
                <li><a href="../auth/logout.php">Logout</a></li>
            </ul>
        </nav>
      </aside>
