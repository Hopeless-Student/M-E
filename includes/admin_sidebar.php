<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sidebar</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background-color: #f8fafc;
        }

        /* Overlay Styles */
        .sidebar-overlay {
            position: fixed;
            inset: 0;
            z-index: 40;
            background-color: rgba(0, 0, 0, 0.5);
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.2s ease, visibility 0.2s ease;
        }

        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 50;
            width: 230px;
            background-color: #0f172a;
            color: #f1f5f9;
            transform: translateX(-100%);
            transition: transform 0.2s ease-out;
            display: flex;
            flex-direction: column;
        }

        .sidebar.open {
            transform: translateX(0);
        }

        .sidebar-header {
            padding: 16px;
        }

        .logo-container {
            width: 120px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 1rem auto;
            margin-bottom: 16px;
        }

        .logo-container img {
            width: 150px;
            height: auto;
            object-fit: contain;
        }

        .logo-text {
            font-size: 24px;
            font-weight: bold;
            color: white;
        }

        .panel-title {
            display: flex;
            flex-direction: column;
            align-items: center;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 16px;
        }

        /* Navigation Styles */
        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 16px 12px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 8px 12px;
            border-radius: 8px;
            color: #cbd5e1;
            text-decoration: none;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .nav-item:hover {
            color: white;
            background-color: #1e293b;
        }

        .nav-item.active {
            color: white;
            background-color: #1e293b;
        }

        .nav-item svg {
            width: 24px;
            height: 24px;
            flex-shrink: 0;
        }

        .nav-item.small-icon svg {
            width: 20px;
            height: 20px;
        }

        /* Sidebar Footer */
        .sidebar-footer {
            border-top: 1px solid #334155;
            padding: 12px;
        }

        .logout-btn {
            display: block;
            width: 100%;
            text-align: center;
            border-radius: 8px;
            background-color: #1e293b;
            padding: 8px 12px;
            font-size: 14px;
            font-weight: 500;
            color: #f1f5f9;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s ease;
            text-decoration: none;
        }

        .logout-btn:hover {
            background-color: #334155;
        }

        /* Custom Scrollbar with Sidebar Gradient */
        ::-webkit-scrollbar {
          width: 8px;
        }

        ::-webkit-scrollbar-track {
          background: #0f172a; /* dark navy to blend with page background */
        }

        ::-webkit-scrollbar-thumb {
          background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%);
          border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
          background: linear-gradient(135deg, #1e40af 0%, #2563eb 100%);
        }

        /* Firefox support */
        * {
          scrollbar-width: thin;
          scrollbar-color: #1e40af #0f172a;
        }

        /* Responsive Design */
        @media (min-width: 1024px) {
            .sidebar {
                transform: translateX(0);
            }

            .sidebar-overlay {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Overlay (mobile) -->
    <div class="sidebar-overlay" id="sidebar-overlay"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar" aria-hidden="true">
        <div class="sidebar-header">
            <div class="logo-container">
              <?php
              // Get the current page to set active state
              $current_page = basename($_SERVER['REQUEST_URI']);
              $current_dir = basename(dirname($_SERVER['REQUEST_URI']));

              // Define the base path - adjust this based on where your files are located
              $base_path = '';

              // If we're in a subdirectory, we need to go back to admin root
              if ($current_dir !== 'admin') {
                  $base_path = '/../';
              }
              ?>
                <img src="<?php echo $base_path ?>../assets/images/logo/ME logo.png" alt="">
            </div>

        </div>

        <!-- Navigation Links -->
        <nav class="sidebar-nav">
            <?php
            // Get the current page to set active state
            $current_page = basename($_SERVER['REQUEST_URI']);
            $current_dir = basename(dirname($_SERVER['REQUEST_URI']));

            // Define the base path - adjust this based on where your files are located
            $base_path = '';

            // If we're in a subdirectory, we need to go back to admin root
            if ($current_dir !== 'admin') {
                $base_path = '/../';
            }
            ?>

            <a href="<?php echo $base_path; ?>index.php"
               class="nav-item <?php echo ($current_page == 'index.php' && $current_dir == 'admin') ? 'active' : ''; ?>"
               data-page="Dashboard">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h2a2 2 0 012 2v6H8V5z"></path>
                </svg>
                Overview
            </a>

            <a href="<?php echo $base_path; ?>orders/index.php"
               class="nav-item <?php echo ($current_dir == 'orders') ? 'active' : ''; ?>"
               data-page="Orders">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                </svg>
                Orders
            </a>

            <a href="<?php echo $base_path; ?>products/index.php"
               class="nav-item <?php echo ($current_dir == 'products') ? 'active' : ''; ?>"
               data-page="Products">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M9 21V9l3-1.5M15 9v12l-3-1.5"></path>
                </svg>
                Products
            </a>

            <a href="<?php echo $base_path; ?>users/index.php"
               class="nav-item <?php echo ($current_dir == 'users') ? 'active' : ''; ?>"
               data-page="Customer">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                Customer
            </a>

            <a href="<?php echo $base_path; ?>inventory/index.php"
               class="nav-item <?php echo ($current_dir == 'inventory') ? 'active' : ''; ?>"
               data-page="Inventory">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                </svg>
                Inventory
            </a>

            <a href="<?php echo $base_path; ?>requests/index.php"
               class="nav-item <?php echo ($current_dir == 'requests') ? 'active' : ''; ?>"
               data-page="Messages">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                Messages
            </a>

            <a href="<?php echo $base_path; ?>settings/index.php"
               class="nav-item <?php echo ($current_dir == 'settings') ? 'active' : ''; ?>"
               data-page="Settings">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Settings
            </a>
        </nav>

        <!-- Footer -->
        <div class="sidebar-footer">
            <a href="../auth/logout.php" class="logout-btn">Log out</a>
        </div>
    </aside>

    <script>
        (function () {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const openBtns = document.querySelectorAll('[data-sidebar-toggle="open"]');
            const navItems = document.querySelectorAll('.nav-item');

            function openSidebar() {
                overlay.classList.add('active');
                sidebar.classList.add('open');
                document.body.style.overflow = 'hidden';
            }

            function closeSidebar() {
                overlay.classList.remove('active');
                sidebar.classList.remove('open');
                document.body.style.overflow = '';
            }

            // Mobile toggle buttons (external buttons with data-sidebar-toggle="open")
            openBtns.forEach(btn => btn.addEventListener('click', openSidebar));

            // Close on overlay click
            overlay.addEventListener('click', closeSidebar);

            // Navigation item clicks - removed preventDefault() to allow normal navigation
            navItems.forEach(item => {
                item.addEventListener('click', function(e) {
                    // Don't prevent default - allow normal navigation

                    // Update active state
                    navItems.forEach(nav => nav.classList.remove('active'));
                    this.classList.add('active');

                    // Close mobile sidebar after navigation
                    if (window.innerWidth < 1024) {
                        closeSidebar();
                    }
                });
            });

            // Keyboard shortcuts
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    closeSidebar();
                }
            });
        })();
    </script>
</body>
</html>
