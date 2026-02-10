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
        $mail->SMTPSecure = $this->config['smtp_secure'] === 'tls' ? PHPMailer::ENCRYPTION_STARTTLS : PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = $this->config['smtp_port'];

        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer'       => false,
                'verify_peer_name'  => false,
                'allow_self_signed' => true,
            ],
        ];

        $mail->setFrom($this->config['mail_from'], $this->config['mail_from_name']);
        $mail->addReplyTo($email, $name);

        foreach ($this->config['mail_to'] as $recipient) {
            $mail->addAddress($recipient['email'], $recipient['name']);
        }

        $mail->isHTML(false);
        $mail->Subject = "Wiadomość z formularza kontaktowego DOM-BUD";
        $mail->Body    = "Imię i nazwisko: {$name}\nEmail: {$email}\n\nWiadomość:\n{$message}";

        return $mail->send();
    }
}
