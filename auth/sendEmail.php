<?php
require __DIR__ . '/../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
  function sendVerificationToEmail($email, $fname, $lname, $token){
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

        // $mail->SMTPOptions = [
        // 'ssl' => [
        //     'verify_peer' => false,
        //     'verify_peer_name' => false,
        //     'allow_self_signed' => true
        //   ]
        // ];

        $mail->setFrom($_ENV['SMTP_USER'], 'M&E Interior Supplies Trading');
        $mail->addAddress($email,$fname.' '.$lname);
        $mail->Subject= "Verify Your Email";
        $mail->isHTML(true);

        $verifylink = $_ENV['APP_URL'] . "/auth/verify.php?email=$email&token=$token";
        $mail->Body = "
<div style='font-family:Segoe UI, sans-serif; background:#f4f6f8; padding:40px;'>
    <div style='max-width:600px; margin:auto; background:#ffffff; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.1); overflow:hidden;'>

        <!-- Header -->
        <div style='background:#0d47a1; color:#fff; padding:20px; text-align:center; display:flex; align-items:center; justify-content:center;'>
            <img src='https://m-e.bscs3b.com/assets/images/M&E_LOGO_transparent.png' alt='M&E Logo' style='height:40px; margin-right:10px;'>
            <div>
                <h1 style='margin:0; font-size:22px;'>M&E Interior Supplies</h1>
                <p style='margin:5px 0 0; font-size:14px;'>Verify Your Email</p>
            </div>
        </div>

        <!-- Body -->
        <div style='padding:30px; color:#111827; text-align:center;'>
            <p style='font-size:16px;'>Hi <strong>$fname $lname</strong>,</p>
            <p style='font-size:15px; color:#555555;'>
                Welcome! Please verify your email to complete your registration.
            </p>
            <a href='$verifylink' style='display:inline-block; margin-top:20px; padding:12px 25px; background:#0d47a1; color:#ffffff; border-radius:6px; text-decoration:none; font-weight:bold;'>
                Verify Email Address
            </a>
            <p style='font-size:13px; color:#6b7280; margin-top:20px;'>
                If you didn't request this, just ignore this email.
            </p>
        </div>

        <!-- Footer -->
        <div style='background:#f1f3f5; padding:20px; text-align:center; font-size:12px; color:#777777;'>
            &copy; " . date('Y') . " M&E Interior Supplies Trading. All rights reserved.
        </div>

    </div>
</div>
";
        $mail->AltBody = "Hello $fname! Copy and paste this link to verify your email: $verifylink";
        if(!$mail->send()){
          error_log("Mailer Error: " . $mail->ErrorInfo);
           return false;
        } else {
          return true;
        }
      } catch (\Exception $e) {
        error_log("Mailer Exception: " . $e->getMessage());
        return false;
      }


  }

 ?>
