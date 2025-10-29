<?php
session_start();
include("../includes/database.php");
$pdo = connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login_id = trim($_POST["login_id"]);
    $password = $_POST["password"];

    try {
        // First, check the regular users table
        $sql = "SELECT user_id as id, username, email, password, 'user' as user_type, isActive as is_active
                FROM users
                WHERE (username = :login_id_username OR email = :login_id_email)
                LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['login_id_username' => $login_id, 'login_id_email' => $login_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // If not found in users table, check admin_user table
        if (!$user) {
            $sql = "SELECT admin_id as id, username, email, password_hash as password, 'admin' as user_type, role, is_active
                    FROM admin_user
                    WHERE (username = :login_id_username OR email = :login_id_email)
                    LIMIT 1";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['login_id_username' => $login_id, 'login_id_email' => $login_id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
        }

        // Check if user was found in either table
        if ($user) {
            if (password_verify($password, $user['password'])) {
                // Set session variables based on user type
                $_SESSION["user_type"] = $user["user_type"];

                if ($user['user_type'] === 'admin') {
                    $_SESSION["admin_id"] = $user["id"];
                    $_SESSION["admin_role"] = $user["role"];

                    // Redirect to admin dashboard
                    header("Location: ../admin/dashboard.php");
                    exit;
                } else {
                    $_SESSION["user_id"] = $user["id"];

                    // Handle cart merge for regular users
                    try {
                        $pdo->beginTransaction();

                        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                            foreach ($_SESSION['cart'] as $product_id => $item) {
                                $checkStmt = $pdo->prepare("SELECT * FROM shopping_cart WHERE user_id = ? AND product_id = ?");
                                $checkStmt->execute([$user['id'], $product_id]);

                                if ($checkStmt->rowCount() > 0) {
                                    $pdo->prepare("UPDATE shopping_cart
                                        SET quantity = quantity + ?
                                        WHERE user_id = ? AND product_id = ?")
                                        ->execute([$item['quantity'], $user['id'], $product_id]);
                                } else {
                                    $pdo->prepare("INSERT INTO shopping_cart (user_id, product_id, quantity)
                                        VALUES (?, ?, ?)")
                                        ->execute([$user['id'], $product_id, $item['quantity']]);
                                }
                            }
                        }

                        $pdo->commit();
                        unset($_SESSION['cart']);
                    } catch (Exception $e) {
                        $pdo->rollBack();
                        error_log("Cart merge failed: " . $e->getMessage());
                    }

                    // Check if user account is active
                    if ($user['is_active'] == 0) {
                        header("Location: ../user/profile.php");
                        exit;
                    }

                    // Redirect to user homepage
                    header("Location: ../pages/index.php");
                    exit;
                }
            } else {
                $_SESSION['loginFailed'] = "Incorrect password";
                header("Location: ../pages/index.php");
                exit;
            }
        } else {
            $_SESSION['loginFailed'] = "User not found";
            header("Location: ../pages/index.php");
            exit;
        }
    } catch (PDOException $e) {
        error_log("Database failed: " . $e->getMessage());
        $_SESSION['loginFailed'] = "An error occurred. Please try again.";
        header("Location: ../pages/index.php");
        exit;
    }
}
?>
