<?php

namespace App\Controllers;

use App\Services\Mailer;

class ContactController
{
    private array $config;
    private Mailer $mailer;

    public function __construct()
    {
        $this->config = require __DIR__ . '/../Config/config.php';
        $this->mailer = new Mailer($this->config);
    }

    public function showForm(): void
    {
        require __DIR__ . '/../Views/contact.view.php';
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
            // POPRAWKA: Użyj url() zamiast /kontakt
            header("Location: " . url('kontakt') . "?status=error&msg=" . urlencode(implode(" ", $errors)));
            exit;
        }

        if ($this->mailer->sendContactMessage($name, $email, $message)) {
            // POPRAWKA: Użyj url() zamiast /kontakt
            header("Location: " . url('kontakt') . "?status=ok");
        } else {
            // POPRAWKA: Użyj url() zamiast /kontakt
            header("Location: " . url('kontakt') . "?status=error");
        }
    }
}
