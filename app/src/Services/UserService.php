<?php

namespace App\Services;

use App\Exceptions\ValidationException;
use App\Models\UserModel;
use App\Repositories\UserRepository;

class UserService
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function attemptLogin(string $email, string $password): ?UserModel
    {
        $email = trim($email);

        $user = $this->userRepository->getUserByEmail($email);

        if ($user === null) {
            return null;
        }

        if (!password_verify($password, $user->password_hash)) {
            return null;
        }

        return $user;
    }

    /**
     * @throws ValidationException
     */
    public function registerUser(string $email, string $username, string $password): array
    {
        $email = trim($email);
        $username = trim($username);

        if ($email === '' || $username === '' || $password === '') {
            throw new ValidationException('All fields are required.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new ValidationException('Please enter a valid email address.');
        }

        if (mb_strlen($username) < 3) {
            throw new ValidationException('Username must be at least 3 characters long.');
        }

        if (mb_strlen($password) < 8) {
            throw new ValidationException('Password must be at least 8 characters long.');
        }

        if ($this->userRepository->getUserByEmail($email) !== null) {
            throw new ValidationException('This email address is already in use.');
        }

        if ($this->userRepository->getUserByUsername($username) !== null) {
            throw new ValidationException('This username is already taken.');
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $userId = $this->userRepository->createUser($email, $username, $passwordHash);

        return [
            'success' => true,
            'user_id' => $userId,
        ];
    }

    public function getUserByEmail(string $email): ?UserModel
    {
        return $this->userRepository->getUserByEmail($email);
    }
}
