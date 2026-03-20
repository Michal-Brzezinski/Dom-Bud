<?php

namespace App\Repositories;

use PDO;
use App\Models\Admin;

class AdminRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findByEmail(string $email): ?Admin
    {
        $stmt = $this->pdo->prepare('SELECT * FROM admins WHERE email = :email LIMIT 1');
        $stmt->execute([':email' => $email]);

        $row = $stmt->fetch();

        return $row ? new Admin($row) : null;
    }

    public function findById(int $id): ?Admin
    {
        $stmt = $this->pdo->prepare('SELECT * FROM admins WHERE id = :id LIMIT 1');
        $stmt->execute([':id' => $id]);

        $row = $stmt->fetch();

        return $row ? new Admin($row) : null;
    }

    public function create(string $email, string $password): Admin
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->pdo->prepare(
            'INSERT INTO admins (email, password) VALUES (:email, :password)'
        );

        $stmt->execute([
            ':email' => $email,
            ':password' => $hash
        ]);

        return $this->findById((int)$this->pdo->lastInsertId());
    }
}
