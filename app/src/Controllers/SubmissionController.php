<?php

namespace App\Controllers;

use App\Services\SubmissionService;

class SubmissionController
{
    private SubmissionService $submissionService;

    public function __construct()
    {
        $this->submissionService = new SubmissionService();
    }

    public function create(array $vars = []): void
    {
        $this->requireLoggedIn();
        require __DIR__ . '/../Views/submissions/submit.php';
    }

    public function store(array $vars = []): void
    {
        $this->requireLoggedIn();

        $result = $this->submissionService->createSubmission(
            (int) $_SESSION['user']['user_id'],
            $_POST['title'] ?? '',
            $_POST['artist_name'] ?? '',
            $_POST['description'] ?? '',
            $_POST['genre'] ?? '',
            $_POST['media_url'] ?? ''
        );

        if (($result['success'] ?? false) !== true) {
            $_SESSION['submission_error'] = $result['message'] ?? 'Unable to send submission.';
            header('Location: /submissions/submit.php');
            exit;
        }

        $_SESSION['submission_success'] = 'Your mix was submitted for review.';
        header('Location: /submissions/create');
        exit;
    }

    private function requireLoggedIn(): void
    {
        if (!isset($_SESSION['user'])) {
            http_response_code(403);
            echo 'Forbidden';
            exit;
        }
    }
}