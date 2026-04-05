<?php

namespace App\Repositories;

use App\Models\UserModel;
use PDO;

class UserRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO(
            'mysql:host=mysql;dbname=sk_production_hub;charset=utf8mb4',
            'developer',
            'secret123'
        );

        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    public function getUserByEmail(string $email): ?UserModel
    {
        $sql = '
            SELECT
                user_id,
                email,
                username,
                password_hash,
                role,
                created_at,
                updated_at
            FROM users
            WHERE email = :email
            LIMIT 1
        ';

        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            ':email' => $email,
        ]);

        $row = $statement->fetch();

        if ($row === false) {
            return null;
        }

        return UserModel::fromArray($row);
    }

    public function getUserByUsername(string $username): ?UserModel
    {
        $sql = '
            SELECT
                user_id,
                email,
                username,
                password_hash,
                role,
                created_at,
                updated_at
            FROM users
            WHERE username = :username
            LIMIT 1
        ';

        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            ':username' => $username,
        ]);

        $row = $statement->fetch();

        if ($row === false) {
            return null;
        }

        return UserModel::fromArray($row);
    }

    public function createUser(string $email, string $username, string $passwordHash): int
    {
        $sql = '
            INSERT INTO users (
                email,
                username,
                password_hash,
                role
            ) VALUES (
                :email,
                :username,
                :password_hash,
                :role
            )
        ';

        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            ':email' => $email,
            ':username' => $username,
            ':password_hash' => $passwordHash,
            ':role' => 'user',
        ]);

        return (int) $this->pdo->lastInsertId();
    }
}