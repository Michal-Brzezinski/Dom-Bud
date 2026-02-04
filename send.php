<?php

require __DIR__ . '/vendor/PHPMailer/src/Exception.php';
require __DIR__ . '/vendor/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/vendor/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$config = require __DIR__ . '/config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name    = trim($_POST["name"] ?? "");
    $email   = trim($_POST["email"] ?? "");
    $message = trim($_POST["message"] ?? "");

    $errors = [];

    if (empty($name) || strlen($name) < 3) {
        $errors[] = "Imię i nazwisko musi mieć co najmniej 3 znaki.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Podaj poprawny adres e-mail.";
    }
    if (empty($message) || strlen($message) < 10) {
        $errors[] = "Wiadomość musi mieć co najmniej 10 znaków.";
    }

    if (!empty($errors)) {
        $msg = implode(" ", $errors);
        header("Location: contact.php?status=error&msg=" . urlencode($msg));
        exit;
    }

    try {
        $mail = new PHPMailer(true);
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';
        $mail->isSMTP();
        $mail->Host       = $config['smtp_host'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $config['smtp_user'];
        $mail->Password   = $config['smtp_pass'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // SSL
        $mail->Port       = 465;

        // Nadawca
        $mail->setFrom($config['mail_from'], $config['mail_from_name']);

        // Reply-To od użytkownika
        $mail->addReplyTo($email, $name);

        // Odbiorca (Ty)
        foreach ($config['mail_to'] as $recipient) {
            $mail->addAddress($recipient['email'], $recipient['name']);
        }

        // Treść
        $mail->isHTML(false);
        $mail->Subject = "Wiadomość z formularza kontaktowego Dom-Bud";
        $mail->Body    = "Imię i nazwisko: {$name}\nEmail: {$email}\n\nWiadomość:\n{$message}";

        $mail->send();
        header("Location: contact.php?status=ok&msg=" . urlencode("e-mail has been sent."));
    } catch (Exception $e) {
        header("Location: contact.php?status=error&msg=" . urlencode("delivery error: {$mail->ErrorInfo}"));
    }
}
