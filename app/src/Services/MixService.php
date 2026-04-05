<?php

namespace App\Services;

use App\Exceptions\ValidationException;
use App\Models\MixModel;
use App\Repositories\MixRepository;

class MixService
{
    private MixRepository $mixRepository;

    public function __construct()
    {
        $this->mixRepository = new MixRepository();
    }

    /**
     * @return MixModel[]
     */
    public function getAllPublicMixes(): array
    {
        return $this->mixRepository->getAllPublicMixes();
    }

    public function getPublicMixBySlug(string $slug): ?MixModel
    {
        return $this->mixRepository->getPublicMixBySlug($slug);
    }

    /**
     * @return array<int, array{artist_id:int, stage_name:string}>
     */
    public function getAllArtists(): array
    {
        return $this->mixRepository->getAllArtists();
    }

    /**
     * @throws ValidationException
     */
    public function createMix(array $input, int $createdByUserId): array
    {
        $artistId = (int) ($input['artist_id'] ?? 0);
        $title = trim((string) ($input['title'] ?? ''));
        $description = trim((string) ($input['description'] ?? ''));
        $genre = trim((string) ($input['genre'] ?? ''));
        $tracklist = trim((string) ($input['tracklist'] ?? ''));
        $mediaUrl = trim((string) ($input['media_url'] ?? ''));
        $durationValue = trim((string) ($input['duration'] ?? ''));
        $isFeatured = isset($input['is_featured']) && (string) $input['is_featured'] === '1';

        if ($artistId <= 0 || $title === '' || $description === '' || $genre === '' || $mediaUrl === '') {
            throw new ValidationException('Artist, title, description, genre, and media URL are required.');
        }

        if (!filter_var($mediaUrl, FILTER_VALIDATE_URL)) {
            throw new ValidationException('Please enter a valid media URL.');
        }

        $duration = null;

        if ($durationValue !== '') {
            if (!is_numeric($durationValue) || (int) $durationValue < 0) {
                throw new ValidationException('Duration must be a positive number.');
            }

            $duration = (int) $durationValue;
        }

        $slug = $this->generateUniqueSlug($title);

        $this->mixRepository->createMix(
            $artistId,
            $title,
            $slug,
            $description,
            $genre,
            $tracklist !== '' ? $tracklist : null,
            $mediaUrl,
            $duration,
            $isFeatured,
            $createdByUserId
        );

        return [
            'success' => true,
            'slug' => $slug,
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

    /**
     * @return array<int, array{comment_id:int, username:string, content:string, created_at:string}>
     */
    public function getCommentsByMixId(int $mixId): array
    {
        return $this->mixRepository->getCommentsByMixId($mixId);
    }

    /**
     * @throws ValidationException
     */
    public function addComment(int $mixId, int $userId, string $content): array
    {
        $content = trim($content);

        if ($content === '') {
            throw new ValidationException('Comment cannot be empty.');
        }

        if (mb_strlen($content) > 1000) {
            throw new ValidationException('Comment is too long.');
        }

        $this->mixRepository->createComment($mixId, $userId, $content);

        return [
            'success' => true,
        ];
    }

    public function getVoteCountsByMixId(int $mixId): array
    {
        return $this->mixRepository->getVoteCountsByMixId($mixId);
    }

    /**
     * @throws ValidationException
     */
    public function saveVote(int $mixId, int $userId, string $voteType): array
    {
        if ($voteType !== 'like' && $voteType !== 'dislike') {
            throw new ValidationException('Invalid vote type.');
        }

        $this->mixRepository->saveVote($mixId, $userId, $voteType);

        return [
            'success' => true,
        ];
    }

    /**
     * @throws ValidationException
     */
    public function deleteMixBySlug($slug): void
    {
        $slug = trim($slug);

        if ($slug === '') {
            throw new ValidationException('Invalid mix.');
        }

        $mix = $this->mixRepository->getPublicMixBySlug($slug);

        if ($mix === null) {
            throw new ValidationException('The mix does not exist.');
        }

        $this->mixRepository->deleteVotesByMixId($mix->mix_id);
        $this->mixRepository->deleteCommentsByMixId($mix->mix_id);
        $this->mixRepository->deleteMixById($mix->mix_id);
    }
}
