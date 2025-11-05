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
<div style='font-family:Segoe UI, sans-serif; background:#f4f6f8; padding:40px;'>
<div style='max-width:600px; margin:auto; background:#ffffff; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.1); overflow:hidden;'>

  <table style='width:100%; background:#0d47a1; color:#ffffff; padding:20px;'>
      <tr>
          <td style='width:60px; vertical-align:middle;'>
              <img src='https://m-e.bscs3b.com/assets/images/M&E_LOGO_transparent.png' alt='M&E Logo' style='height:50px;'>
          </td>
          <td style='vertical-align:middle; text-align:left; padding-left:10px;'>
              <h1 style='margin:0; font-size:20px;'>M&E Interior Supplies</h1>
              <p style='margin:5px 0 0; font-size:14px;'>Password Reset Request</p>
          </td>
      </tr>
  </table>

  <div style='padding:30px; text-align:center;'>
      <p style='font-size:16px; color:#333;'>Hi <strong>$fname $lname</strong>,</p>
      <p style='font-size:15px; color:#555;'>
          We received a request to reset your password. Click the button below to proceed:
      </p>
      <a href='$resetLink' style='display:inline-block; padding:12px 25px; margin:15px 0; background:#0d47a1; color:#ffffff; border-radius:6px; text-decoration:none; font-weight:bold;'>Reset Password</a>
      <p style='color:#6b7280; font-size:13px; margin-top:20px;'>
          If you didn't request a password reset, you can safely ignore this email. This link will expire in 1 hour.
      </p>
  </div>

  <!-- Footer -->
  <div style='background:#f1f3f5; padding:20px; text-align:center; font-size:12px; color:#777777;'>
      &copy; " . date('Y') . " M&E Interior Supplies Trading. All rights reserved.
  </div>

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
