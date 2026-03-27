<?php

namespace App\Services;

use App\Models\UserModel;
use App\Repositories\UserRepository;

class UserService
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new userRepository();
    }

    public function attemptLogin(string $email, string $password): ?UserModel
    {
        $user = $this->userRepository->getUserByEmail($email);

        if ($user === null) {
            return null;
        }

        if (!password_verify($password, $user->password_hash)) {
            return null;
        }

        return $user;
    }

    public function registerUser(string $email, string $username, string $password): array
    {
        $email = trim($email);
        $username = trim($username);

        if ($email === '' || $username === '' || $password === '') {
            return [
                'success' => false,
                'message' => 'All fields are required.',
            ];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return [
                'success' => false,
                'message' => 'Please enter a valid email address.',
            ];
        }

        if (mb_strlen($username) < 3) {
            return [
                'success' => false,
                'message' => 'Username must be at least 3 characters long.',
            ];
        }

        if (mb_strlen($password) < 8) {
            return [
                'success' => false,
                'message' => 'Password must be at least 8 characters long.',
            ];
        }

        if ($this->userRepository->getUserByEmail($email) !== null) {
            return [
                'success' => false,
                'message' => 'This email address is already in use.',
            ];
        }

        if ($this->userRepository->getUserByUsername($username) !== null) {
            return [
                'success' => false,
                'message' => 'This username is already taken.',
            ];
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