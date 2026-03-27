<?php

namespace App\Controllers;

use App\Services\MixService;

class MixController
{
    private MixService $mixService;

    public function __construct()
    {
        $this->mixService = new MixService();
    }

    public function index(array $vars = []): void
    {
        $mixes = $this->mixService->getAllPublicMixes();

        require __DIR__ . '/../Views/mixes/index.php';
    }

    public function show(array $vars = []): void
    {
        $slug = $vars['slug'] ?? '';
        $mix = $this->mixService->getPublicMixBySlug($slug);

        if ($mix === null) {
            $this->renderNotFound('The mix you are looking for does not exist.');
            return;
        }

        $comments = $this->mixService->getCommentsByMixId($mix->mix_id);

        require __DIR__ . '/../Views/mixes/show.php';
    }

    public function storeComment(array $vars = []): void
    {
        $this->requireLoggedIn();

        $slug = $vars['slug'] ?? '';
        $mix = $this->mixService->getPublicMixBySlug($slug);

        if ($mix === null) {
            $this->renderNotFound('You cannot comment because this mix does not exist.');
            return;
        }

        $content = $_POST['content'] ?? '';
        $result = $this->mixService->addComment(
            $mix->mix_id,
            (int) $_SESSION['user']['user_id'],
            $content
        );

        if (($result['success'] ?? false) !== true) {
            $_SESSION['comment_error'] = $result['message'] ?? 'Unable to post comment.';
        }

        header('Location: /mixes/' . urlencode($mix->slug));
        exit;
    }

    public function create(array $vars = []): void
    {
        $this->requireAdmin();

        $artists = $this->mixService->getAllArtists();
        $errorMessage = null;

        $old = [
            'artist_id' => '',
            'title' => '',
            'description' => '',
            'genre' => '',
            'tracklist' => '',
            'media_url' => '',
            'duration' => '',
            'is_featured' => '0',
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $old = [
                'artist_id' => trim($_POST['artist_id'] ?? ''),
                'title' => trim($_POST['title'] ?? ''),
                'description' => trim($_POST['description'] ?? ''),
                'genre' => trim($_POST['genre'] ?? ''),
                'tracklist' => trim($_POST['tracklist'] ?? ''),
                'media_url' => trim($_POST['media_url'] ?? ''),
                'duration' => trim($_POST['duration'] ?? ''),
                'is_featured' => isset($_POST['is_featured']) ? '1' : '0',
            ];

            $result = $this->mixService->createMix($old, (int) $_SESSION['user']['user_id']);

            if (($result['success'] ?? false) === true) {
                header('Location: /mixes/' . $result['slug']);
                exit;
            }

            $errorMessage = $result['message'] ?? 'Unable to create mix.';
        }

        require __DIR__ . '/../Views/admin/create-mix.php';
    }

    public function GetVotes(array $vars = []): void
    {
        header('Content-Type: application/json');

        $slug = $vars['slug'] ?? '';
        $mix = $this->mixService->getPublicMixBySlug($slug);

        if ($mix === null) {
            http_response_code(404);
            echo json_encode(['message' => 'Mix not found']);
            return;
        }

        $counts = $this->mixService->getVoteCountsByMixId($mix->mix_id);

        echo json_encode($counts);
    }

    public function StoreVote(array $vars = []): void
    {
        header('Content-Type: application/json');

        if (!isset($_SESSION['user'])) {
            http_response_code(403);
            echo json_encode(['message' => 'Login required']);
            return;
        }

        $slug = $vars['slug'] ?? '';
        $mix = $this->mixService->getPublicMixBySlug($slug);

        if ($mix === null) {
            http_response_code(404);
            echo json_encode(['message' => 'Mix not found']);
            return;
        }

        $voteType = $_POST['vote_type'] ?? '';

        if ($voteType !== 'like' && $voteType !== 'dislike') {
            http_response_code(400);
            echo json_encode(['message' => 'Invalid vote type']);
            return;
        }

        $result = $this->mixService->saveVote(
            $mix->mix_id,
            (int) $_SESSION['user']['user_id'],
            $voteType
        );

        if (($result['success'] ?? false) !== true) {
            http_response_code(400);
            echo json_encode(['message' => $result['message'] ?? 'Unable to save vote']);
            return;
        }

        $counts = $this->mixService->getVoteCountsByMixId($mix->mix_id);

        echo json_encode([
            'message' => 'Vote saved',
            'counts' => $counts
        ]);
    }

    private function requireAdmin(): void
    {
        if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
            http_response_code(403);
            echo 'Forbidden';
            exit;
        }
    }

    private function requireLoggedIn(): void
    {
        if (!isset($_SESSION['user'])) {
            http_response_code(403);
            echo 'Forbidden';
            exit;
        }
    }

    private function renderNotFound(string $message = 'The requested mix could not be found.'): void
    {
        http_response_code(404);
        $title = 'Mix not found';
        require __DIR__ . '/../Views/errors/page404.php';
    }
}