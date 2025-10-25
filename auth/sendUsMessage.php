<?php
require __DIR__ . '/../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
  function sendUsMessage($name, $email, $subject, $message){
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
        $mail->addAddress('ezratessalith@gmail.com','M&E Admin');
        $mail->addReplyTo($email,$fname.' '.$lname);
        $mail->addCC($email);
        $mail->Subject= "New Quick Message: " . htmlspecialchars($subject);
        $mail->isHTML(true);

        $mail->Body = "
<div style='
  font-family: \"Segoe UI\", Tahoma, sans-serif;
  background: #f3f4f6;
  padding: 35px;
'>
  <div style='
    max-width: 620px;
    margin: auto;
    background: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.08);
    overflow: hidden;
  '>
    <!-- Header -->
    <div style='
      background: linear-gradient(90deg, #4169E1, #5A7CFA);
      color: white;
      padding: 25px 30px;
      text-align: center;
    '>
      <h2 style='margin: 0; font-size: 24px; font-weight: 600;'>📨 New Quick Message</h2>
      <p style='margin: 8px 0 0; font-size: 14px; opacity: 0.9;'>M&E Interior Supplies Trading</p>
    </div>

    <div style='padding: 30px; color: #111827;'>
      <p style='font-size: 16px; margin-bottom: 15px;'>
        You’ve received a new <strong style='color:#4169E1;'>Quick Message</strong> from:
      </p>

      <div style='
        background: #f9fafb;
        padding: 15px 20px;
        border-radius: 8px;
        border-left: 4px solid #4169E1;
        margin-bottom: 25px;
      '>
        <p style='margin: 0; font-size: 15px; line-height: 1.5;'>
          <strong>Name:</strong> {$name}<br>
          <strong>Email:</strong> {$email}
        </p>
      </div>

      <div style='
        border-top: 1px solid #e5e7eb;
        border-bottom: 1px solid #e5e7eb;
        padding: 15px 0;
        margin-bottom: 25px;
      '>
        <p style='font-size: 15px; margin: 0;'>
          <strong>Subject:</strong> " . htmlspecialchars($subject) . "
        </p>
      </div>

      <p style='font-size: 15px; font-weight: 600; margin-bottom: 10px;'>Message:</p>
      <div style='
        background: #f9fafb;
        padding: 18px;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        font-size: 14.5px;
        line-height: 1.7;
        white-space: pre-line;
      '>" . nl2br(htmlspecialchars($message)) . "</div>

      <p style='
        font-size: 13px;
        color: #6b7280;
        margin-top: 30px;
        text-align: center;
      '>
        Please reply directly to this email to respond to the sender.
      </p>
    </div>

    <div style='
      background: #f9fafb;
      padding: 15px;
      text-align: center;
      font-size: 12.5px;
      color: #6b7280;
      border-top: 1px solid #e5e7eb;
    '>
      &copy; " . date('Y') . " <strong>M&E Interior Supplies Trading</strong><br>
      This message was sent automatically from your M&E customer portal.
    </div>
  </div>
</div>";


        $mail->AltBody = "New custom request from {$name} ({$email}): {$message}";
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
