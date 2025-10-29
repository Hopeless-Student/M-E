<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Get configured PHPMailer instance
 * @return PHPMailer
 */
function getMailer() {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = $_ENV['SMTP_HOST'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $_ENV['SMTP_USER'];
        $mail->Password   = $_ENV['SMTP_PASS'];
        $mail->SMTPSecure = $_ENV['SMTP_SECURE'];
        $mail->Port       = 587;

        // Sender info
        $mail->setFrom($_ENV['SMTP_USER'], 'M & E Team');
        $mail->addReplyTo($_ENV['SMTP_USER'], 'M & E Support');

        // Options
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        return $mail;

    } catch (Exception $e) {
        error_log("Mailer configuration error: {$mail->ErrorInfo}");
        throw $e;
    }
}

/**
 * Send email using template
 * @param string $to Recipient email
 * @param string $toName Recipient name
 * @param string $subject Email subject
 * @param string $body Email body (HTML or plain text)
 * @param array $attachments Optional attachments
 * @return bool Success status
 */
function sendEmail($to, $toName, $subject, $body, $attachments = []) {
    try {
        $mail = getMailer();

        // Recipients
        $mail->addAddress($to, $toName);

        // Content
        $mail->Subject = $subject;
        $mail->Body    = nl2br($body); // Convert line breaks to <br> tags
        $mail->AltBody = strip_tags($body); // Plain text version

        // Attachments
        foreach ($attachments as $attachment) {
            if (isset($attachment['path']) && file_exists($attachment['path'])) {
                $mail->addAttachment(
                    $attachment['path'],
                    $attachment['name'] ?? basename($attachment['path'])
                );
            }
        }

        $mail->send();
        return true;

    } catch (Exception $e) {
        error_log("Email send error: {$mail->ErrorInfo}");
        return false;
    }
}

/**
 * Replace template variables with actual values
 * @param string $template Template content with {{variables}}
 * @param array $variables Key-value pairs for replacement
 * @return string Processed template
 */
function processTemplate($template, $variables) {
    foreach ($variables as $key => $value) {
        $template = str_replace("{{" . $key . "}}", $value, $template);
    }

    // Remove any unreplaced variables
    $template = preg_replace('/\{\{[a-zA-Z_]+\}\}/', '', $template);

    return $template;
}
