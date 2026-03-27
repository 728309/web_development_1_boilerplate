<?php

namespace App\Services;

use App\Repositories\SubmissionRepository;

class SubmissionService
{
    private SubmissionRepository $submissionRepository;

    public function __construct()
    {
        $this->submissionRepository = new SubmissionRepository();
    }

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
            return [
                'success' => false,
                'message' => 'Please fill in all fields.',
            ];
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
}