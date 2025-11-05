<?php
require __DIR__ . '/../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

function sendForgotPassword($email, $fname, $lname, $token){
    try {
        $mail = new PHPMailer(true);

        
        $mail->isSMTP();
        $mail->SMTPDebug = SMTP::DEBUG_OFF;
        $mail->Host       = $_ENV['SMTP_HOST'];
        $mail->Port       = $_ENV['SMTP_PORT'];
        $mail->SMTPSecure = $_ENV['SMTP_SECURE'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $_ENV['SMTP_USER'];
        $mail->Password   = $_ENV['SMTP_PASS'];

        $mail->setFrom($_ENV['SMTP_USER'], 'M&E Interior Supplies Trading');
        $mail->addAddress($email, "$fname $lname");

        $mail->isHTML(true);
        $mail->Subject = "Reset Your Password";

        $resetLink = $_ENV['APP_URL'] . "/auth/reset-password.php?token=$token";

        $mail->Body = "
        <div style='font-family:Segoe UI,sans-serif; background:#f3f4f6; padding:35px;'>
            <div style='max-width:600px; margin:auto; background:#fff; border-radius:10px; padding:30px; text-align:center;'>
                <h2 style='color:#0d47a1;'>Reset Your Password</h2>
                <p style='color:#333; font-size:15px;'>
                    Hi $fname $lname,<br>
                    We received a request to reset your password. Click the button below to proceed:
                </p>
                <a href='$resetLink' style='display:inline-block; padding:12px 25px; margin:15px 0; background:#0d47a1; color:#fff; border-radius:6px; text-decoration:none; font-weight:600;'>Reset Password</a>
                <p style='color:#6b7280; font-size:13px; margin-top:20px;'>
                    If you didn't request a password reset, you can safely ignore this email. This link will expire in 1 hour.
                </p>
                <p style='font-size:12px; color:#999; margin-top:30px;'>&copy; " . date('Y') . " M&E Interior Supplies Trading</p>
            </div>
        </div>
        ";

        $mail->AltBody = "Hi $fname $lname, copy and paste this link to reset your password: $resetLink";

        return $mail->send();

    } catch (\Exception $e) {
        error_log("Mailer Exception: " . $e->getMessage());
        return false;
    }
}
?>
