<?php

namespace App\Controllers;

use App\Exceptions\ValidationException;
use App\Services\SubmissionService;

class SubmissionController extends BaseController
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

        try {
            $this->submissionService->createSubmission(
                (int) $_SESSION['user']['user_id'],
                $_POST['title'] ?? '',
                $_POST['artist_name'] ?? '',
                $_POST['description'] ?? '',
                $_POST['genre'] ?? '',
                $_POST['media_url'] ?? ''
            );

            $_SESSION['submission_success'] = 'Your mix was submitted for review.';
        } catch (ValidationException $exception) {
            $_SESSION['submission_error'] = $exception->getMessage();
        }

        header('Location: /submissions/submit');
        exit;
    }

    public function adminIndex(array $vars = []): void
    {
        $this->requireAdmin();

        $submissions = $this->submissionService->getPendingSubmissions();

        require __DIR__ . '/../Views/admin/submissions.php';
    }

    public function approve(array $vars = []): void
    {
        $this->requireAdmin();

        $submissionId = (int) ($vars['id'] ?? 0);

        try {
            $this->submissionService->updateSubmissionStatus(
                $submissionId,
                'approved',
                (int) $_SESSION['user']['user_id']
            );

            $_SESSION['submission_success'] = 'Submission approved successfully.';
        } catch (ValidationException $exception) {
            $_SESSION['submission_error'] = $exception->getMessage();
        }

        header('Location: /admin/submissions');
        exit;
    }

    public function reject(array $vars = []): void
    {
        $this->requireAdmin();

        $submissionId = (int) ($vars['id'] ?? 0);

        try {
            $this->submissionService->updateSubmissionStatus(
                $submissionId,
                'rejected',
                (int) $_SESSION['user']['user_id']
            );

            $_SESSION['submission_success'] = 'Submission rejected successfully.';
        } catch (ValidationException $exception) {
            $_SESSION['submission_error'] = $exception->getMessage();
        }

        header('Location: /admin/submissions');
        exit;
    }
}
