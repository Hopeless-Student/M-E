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
      <div style='font-family:Arial, sans-serif; padding:20px; max-width:500px;margin:auto;border:1px solid #eee;padding:30px;border-radius:10px;background:#f9f9f9;'>
        <h2 style='color:#6C63FF;'>🚀 Welcome to MasterMind 😛!</h2>
        <p>You're almost there! Click the button below to verify your email:</p>
        <a href='$verifylink' style='
          display:inline-block;
          margin-top:15px;
          padding:10px 20px;
          background-color:#6C63FF;
          color:white;
          text-decoration:none;
          border-radius:5px;'>Verify Email Address</a>
        <p style='font-size:12px;color:gray;margin-top:30px;'>If you didn't request this, just ignore the email.</p>
      </div>";
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
