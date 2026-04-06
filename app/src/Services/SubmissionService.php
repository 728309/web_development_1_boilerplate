<?php

namespace App\Services;

use App\Exceptions\ValidationException;
use App\Repositories\SubmissionRepository;
use App\Repositories\MixRepository;

class SubmissionService
{
    private SubmissionRepository $submissionRepository;
    private MixRepository $mixRepository;

    public function __construct()
    {
        $this->submissionRepository = new SubmissionRepository();
        $this->mixRepository = new MixRepository();
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

        if ($status === 'approved') {
            $submission = $this->submissionRepository->getSubmissionById($submissionId);

            if ($submission === null) {
                throw new ValidationException('Submission not found.');
            }

            $artistName = trim((string) ($submission['artist_name'] ?? ''));
            $title = trim((string) ($submission['title'] ?? ''));
            $description = trim((string) ($submission['description'] ?? ''));
            $genre = trim((string) ($submission['genre'] ?? ''));
            $mediaUrl = trim((string) ($submission['media_url'] ?? ''));
            $submittedByUserId = (int) ($submission['user_id'] ?? 0);

            if ($artistName === '' || $title === '' || $description === '' || $genre === '' || $mediaUrl === '') {
                throw new ValidationException('Submission data is incomplete.');
            }

            $artist = $this->mixRepository->getArtistByStageName($artistName);

            if ($artist === null) {
                $artistId = $this->mixRepository->createArtist($artistName);
            } else {
                $artistId = (int) $artist['artist_id'];
            }

            $slug = $this->generateUniqueSlug($title);

            $this->mixRepository->createMix(
                $artistId,
                $title,
                $slug,
                $description,
                $genre,
                null,
                $mediaUrl,
                null,
                false,
                $submittedByUserId
            );
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

    private function generateUniqueSlug(string $title): string
    {
        $baseSlug = $this->slugify($title);
        $slug = $baseSlug;
        $counter = 2;

        while ($this->mixRepository->slugExists($slug)) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    private function slugify(string $text): string
    {
        $text = strtolower(trim($text));
        $text = str_replace(' ', '-', $text);
        $text = str_replace(["'", '"', ",", ".", "!", "?", ":", ";", "/"], '', $text);

        return $text !== '' ? $text : 'mix';
    }
}
