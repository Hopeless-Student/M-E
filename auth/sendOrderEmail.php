<?php
require __DIR__ . '/../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

function sendOrderEmail($email, $fname, $lname, $orderNumber, $final_amount, $payment_method){
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

        $mail->isHTML(true);
        $mail->Subject = "Order Confirmation - $orderNumber";

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
                    <p style='margin:5px 0 0; font-size:14px;'>Order Confirmation</p>
                </td>
            </tr>
        </table>

        <div style='padding:30px;'>
            <p style='font-size:16px; color:#333;'>Hi <strong>$fname $lname</strong>,</p>
            <p style='font-size:15px; color:#555;'>
                Thank you for your purchase! Your order has been received and is being processed. Here are the details:
            </p>

            <table style='width:100%; margin:20px 0; border-collapse:collapse;'>
                <tr>
                    <td style='padding:8px; border-bottom:1px solid #e0e0e0; font-weight:bold;'>Order Number</td>
                    <td style='padding:8px; border-bottom:1px solid #e0e0e0;'>$orderNumber</td>
                </tr>
                <tr>
                    <td style='padding:8px; border-bottom:1px solid #e0e0e0; font-weight:bold;'>Amount</td>
                    <td style='padding:8px; border-bottom:1px solid #e0e0e0;'>₱" . number_format($final_amount, 2) . "</td>
                </tr>
                <tr>
                    <td style='padding:8px; border-bottom:1px solid #e0e0e0; font-weight:bold;'>Payment Method</td>
                    <td style='padding:8px; border-bottom:1px solid #e0e0e0;'>$payment_method</td>
                </tr>
            </table>

            <p style='font-size:14px; color:#555;'>
                Order status will be updated on your account once your order has been shipped. We appreciate your trust in M&E Interior Supplies Trading.
            </p>

            <div style='text-align:center; margin-top:30px;'>
                <a href='{$_ENV['APP_URL']}/pages/index.php' style='display:inline-block; padding:12px 25px; background:#0d47a1; color:#ffffff; border-radius:6px; text-decoration:none; font-weight:bold;'>Visit Our Store</a>
            </div>
        </div>

        <!-- Footer -->
        <div style='background:#f1f3f5; padding:20px; text-align:center; font-size:12px; color:#777;'>
            &copy; " . date('Y') . " M&E Interior Supplies Trading. All rights reserved.
        </div>

    </div>
</div>
";


        $mail->AltBody = "Hi $fname $lname, your order $orderNumber has been received. Amount: ₱" . number_format($final_amount,2) . ". Payment Method: $payment_method.";

        return $mail->send();

    } catch (\Exception $e) {
        error_log("Mailer Exception: " . $e->getMessage());
        return false;
    }
}
?>
