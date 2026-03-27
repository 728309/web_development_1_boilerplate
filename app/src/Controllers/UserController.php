<?php


namespace App\Controllers;

use App\Services\UserService;

class UserController
{
    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function login(array $vars = []): void
    {
        $errorMessage = null;
        $oldEmail = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            $oldEmail = $email;

            $user = $this->userService->attemptLogin($email, $password);

            if ($user !== null) {
                $_SESSION['user'] = [
                    'user_id' => $user->user_id,
                    'email' => $user->email,
                    'username' => $user->username,
                    'role' => $user->role,
                ];

                session_regenerate_id(true);
                header('Location: /');
                exit;
            }

            $errorMessage = 'Invalid email or password.';
        }

        require __DIR__ . '/../Views/login/login.php';
    }

    public function register(array $vars = []): void
    {
        $errorMessage = null;
        $oldEmail = '';
        $oldUsername = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            $oldEmail = $email;
            $oldUsername = $username;

            $result = $this->userService->registerUser($email, $username, $password);

            if (($result['success'] ?? false) === true) {
                $user = $this->userService->getUserByEmail($email);

                if ($user !== null) {
                    $_SESSION['user'] = [
                        'user_id' => $user->user_id,
                        'email' => $user->email,
                        'username' => $user->username,
                        'role' => $user->role,
                    ];

                    session_regenerate_id(true);
                }

                header('Location: /');
                exit;
            }

            $errorMessage = $result['message'] ?? 'Registration failed.';
        }

        require __DIR__ . '/../Views/login/register.php';
    }
    public function logout(array $vars = []): void
    {
        unset($_SESSION['user']);
        session_regenerate_id(true);

        header('Location: /');
        exit;
    }
}