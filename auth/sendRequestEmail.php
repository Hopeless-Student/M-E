<?php
require __DIR__ . '/../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
  function sendRequestEmail($email, $fname, $lname, $subject, $message, $request_type){
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
        $mail->Subject= "New {$request_type}: " . htmlspecialchars($subject);
        $mail->isHTML(true);

        $mail->Body = "
  <div style='
    font-family: \"Segoe UI\", Tahoma, sans-serif;
    background: #f3f4f6;
    padding: 30px;
  '>
    <div style='
      max-width: 600px;
      margin: auto;
      background: #ffffff;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
      overflow: hidden;
    '>
      <div style='
        background: linear-gradient(90deg, #4169E1, #6C8BFF);
        color: white;
        padding: 20px 25px;
        text-align: center;
      '>
        <h2 style='margin: 0; font-size: 22px;'>📩 New Customer Request</h2>
        <p style='margin: 5px 0 0; font-size: 14px;'>M&E Interior Supplies Trading</p>
      </div>

      <div style='padding: 25px; color: #111827;'>
        <p style='font-size: 16px;'>
          You’ve received a new <strong style='color:#4169E1;'>{$request_type}</strong> from:
        </p>

        <div style='
          background: #f9fafb;
          padding: 15px 20px;
          border-radius: 8px;
          margin-bottom: 20px;
          border-left: 4px solid #4169E1;
        '>
          <p style='margin: 0; font-size: 15px;'>
            <strong>Name:</strong> {$fname} {$lname}<br>
            <strong>Email:</strong> {$email}
          </p>
        </div>

        <p style='font-size: 15px;'><strong>Subject:</strong> " . htmlspecialchars($subject) . "</p>
        <p style='font-size: 15px; margin-bottom: 10px;'><strong>Message:</strong></p>
        <div style='
          background: #f9fafb;
          padding: 15px;
          border-radius: 8px;
          border: 1px solid #e5e7eb;
          font-size: 14px;
          line-height: 1.6;
          white-space: pre-line;
        '>" . nl2br(htmlspecialchars($message)) . "</div>

        <p style='font-size: 13px; color: #6b7280; margin-top: 25px; text-align:center;'>
          This message was sent automatically from your M&E customer portal.
        </p>
      </div>

      <div style='
        background: #f3f4f6;
        padding: 15px;
        text-align: center;
        font-size: 12px;
        color: #6b7280;
      '>
        &copy; " . date('Y') . " M&E Interior Supplies Trading. All rights reserved.
      </div>
    </div>
  </div>";

        $mail->AltBody = "New custom request from {$fname} {$lname} ({$email}): {$message}";
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
