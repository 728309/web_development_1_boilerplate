<?php

namespace App\Models;

class UserModel
{
    public int $user_id;
    public string $email;
    public string $username;
    public string $password_hash;
    public string $role;
    public string $created_at;
    public string $updated_at;

    public static function fromArray(array $row): self
    {
        $user = new self();

        $user->user_id = (int) $row['user_id'];
        $user->email = (string) $row['email'];
        $user->username = (string) $row['username'];
        $user->password_hash = (string) $row['password_hash'];
        $user->role = (string) $row['role'];
        $user->created_at = (string) $row['created_at'];
        $user->updated_at = (string) $row['updated_at'];

        return $user;
    }
}