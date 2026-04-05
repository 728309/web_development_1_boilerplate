<?php

namespace App\Services;

use App\Exceptions\ValidationException;
use App\Repositories\SubmissionRepository;

class SubmissionService
{
    private SubmissionRepository $submissionRepository;

    public function __construct()
    {
        $this->submissionRepository = new SubmissionRepository();
    }

    /**
     * @throws ValidationException
     */
    public function createSubmission(
        int $userId,
        string $title,
        string $artistName,
        string $description,
        string $genre,
        string $mediaUrl
    ): array {
        $title = trim($title);
        $artistName = trim($artistName);
        $description = trim($description);
        $genre = trim($genre);
        $mediaUrl = trim($mediaUrl);

        if ($title === '' || $artistName === '' || $description === '' || $genre === '' || $mediaUrl === '') {
            throw new ValidationException('Please fill in all fields.');
        }

        $this->submissionRepository->createSubmission(
            $userId,
            $title,
            $artistName,
            $description,
            $genre,
            $mediaUrl
        );

        return [
            'success' => true,
        ];
    }

    public function getPendingSubmissions(): array
    {
        return $this->submissionRepository->getPendingSubmissions();
    }

    /**
     * @throws ValidationException
     */
    public function updateSubmissionStatus(int $submissionId, string $status, int $reviewedBy): array
    {
        if ($status !== 'approved' && $status !== 'rejected') {
            throw new ValidationException('Invalid status.');
        }

        if ($submissionId <= 0) {
            throw new ValidationException('Invalid submission id.');
        }

        $this->submissionRepository->updateSubmissionStatus(
            $submissionId,
            $status,
            $reviewedBy
        );

        return [
            'success' => true,
        ];
    }
}
