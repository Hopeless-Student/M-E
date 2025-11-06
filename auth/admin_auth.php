<?php
session_start();
require_once __DIR__ . '/../includes/database.php';

// Get full request URI (e.g. /admin/index.php or /admin/pages/index.php)
$request_uri = $_SERVER['REQUEST_URI'];

// Check if the current file is in a subdirectory of /admin/
$in_admin_subdir = preg_match('#/admin/[^/]+/#', $request_uri);

// If admin is not logged in
if (!isset($_SESSION['admin_id'])) {
    // Redirect path depends on current location
    if ($in_admin_subdir) {
        // If inside /admin/pages/ or deeper → go up to /admin/pages/index.php
        header("Location: ../../pages/index.php");
    } else {
        // If inside /admin/ → go to /admin/pages/index.php
        header("Location: ../pages/index.php");
    }
    exit;
}

// Ensure admin username is available in session for display across admin pages
if (!isset($_SESSION['admin_username']) || !$_SESSION['admin_username']) {
    try {
        $pdo = connect();
        if ($pdo) {
            $stmt = $pdo->prepare('SELECT username FROM admin_users WHERE admin_id = ? LIMIT 1');
            $stmt->execute([$_SESSION['admin_id']]);
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($admin && isset($admin['username'])) {
                $_SESSION['admin_username'] = $admin['username'];
            }
        }
    } catch (Throwable $e) {
        // Silently ignore to avoid breaking auth flow; pages will fallback to default label
    }
}
?>
