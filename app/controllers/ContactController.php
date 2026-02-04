<?php

namespace App\Controllers;

use App\Services\Mailer;

class ContactController
{
    private static ?ContactController $instance = null;
    private array $config;
    private Mailer $mailer;

    private function __construct()
    {
        $this->config = require __DIR__ . '/../config/config.php';
        $this->mailer = new Mailer($this->config);
    }

    public static function getInstance(): ContactController
    {
        if (self::$instance === null) {
            self::$instance = new ContactController();
        }
        return self::$instance;
    }

    public function handle(): void
    {
        $name    = trim($_POST["name"] ?? "");
        $email   = trim($_POST["email"] ?? "");
        $message = trim($_POST["message"] ?? "");

        $errors = [];

        if (strlen($name) < 3) {
            $errors[] = "Imię i nazwisko musi mieć co najmniej 3 znaki.";
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Podaj poprawny adres e-mail.";
        }
        if (strlen($message) < 10) {
            $errors[] = "Wiadomość musi mieć co najmniej 10 znaków.";
        }

        if (!empty($errors)) {
            header("Location: /contact.php?status=error&msg=" . urlencode(implode(" ", $errors)));
            exit;
        }

        if ($this->mailer->sendContactMessage($name, $email, $message)) {
            header("Location: /contact.php?status=ok&msg=email_sent");
        } else {
            header("Location: /contact.php?status=error&msg=delivery_error");
        }
    }
}
