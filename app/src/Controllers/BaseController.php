<?php

namespace App\Controllers;

class BaseController
{
    protected function requireLoggedIn(): void
    {
        if (!isset($_SESSION['user'])) {
            http_response_code(403);
            echo 'Forbidden';
            exit;
        }
    }

    protected function requireAdmin(): void
    {
        if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
            http_response_code(403);
            echo 'Forbidden';
            exit;
        }
    }

    protected function renderNotFound(
        string $title = 'Page not found',
        string $message = 'The page you requested does not exist.'
    ): void {
        http_response_code(404);
        require __DIR__ . '/../Views/errors/page404.php';
    }
}