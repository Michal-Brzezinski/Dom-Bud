<?php

namespace App\Models;

class Admin
{
    public int $id;
    public string $email;
    public string $password;
    public string $created_at;

    public function __construct(array $data)
    {
        $this->id = (int)$data['id'];
        $this->email = $data['email'];
        $this->password = $data['password'];
        $this->created_at = $data['created_at'];
    }
}
