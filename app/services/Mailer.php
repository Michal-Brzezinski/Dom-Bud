<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    private array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function sendContactMessage(string $name, string $email, string $message): bool
    {
        $mail = new PHPMailer(true);

        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';

        $mail->isSMTP();
        $mail->Host       = $this->config['smtp_host'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $this->config['smtp_user'];
        $mail->Password   = $this->config['smtp_pass'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        $mail->setFrom($this->config['mail_from'], $this->config['mail_from_name']);
        $mail->addReplyTo($email, $name);

        foreach ($this->config['mail_to'] as $recipient) {
            $mail->addAddress($recipient['email'], $recipient['name']);
        }

        $mail->isHTML(false);
        $mail->Subject = "Wiadomość z formularza kontaktowego Dom-Bud";
        $mail->Body    = "Imię i nazwisko: {$name}\nEmail: {$email}\n\nWiadomość:\n{$message}";

        return $mail->send();
    }
}
