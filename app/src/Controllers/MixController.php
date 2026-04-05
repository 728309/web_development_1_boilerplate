<?php

namespace App\Controllers;

use App\Exceptions\ValidationException;
use App\Services\MixService;

class MixController extends BaseController
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
            $this->renderNotFound('The mix does not exist.');
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
        try {
            $this->mixService->addComment(
                $mix->mix_id,
                (int) $_SESSION['user']['user_id'],
                $content
            );
        } catch (ValidationException $exception) {
            $_SESSION['comment_error'] = $exception->getMessage();
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

        require __DIR__ . '/../Views/admin/create-mix.php';
    }

    public function getVotes(array $vars = []): void
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

    public function storeVote(array $vars = []): void
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

        try {
            $this->mixService->saveVote(
                $mix->mix_id,
                (int) $_SESSION['user']['user_id'],
                $voteType
            );
        } catch (ValidationException $exception) {
            http_response_code(400);
            echo json_encode(['message' => $exception->getMessage()]);
            return;
        }

        $counts = $this->mixService->getVoteCountsByMixId($mix->mix_id);

        echo json_encode([
            'message' => 'Vote saved',
            'counts' => $counts
        ]);
    }

    public function store(array $vars = []): void
    {
        $this->requireAdmin();

        $artists = $this->mixService->getAllArtists();

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

        try {
            $result = $this->mixService->createMix(
                $old,
                (int) $_SESSION['user']['user_id']
            );

            header('Location: /mixes/' . $result['slug']);
            exit;
        } catch (ValidationException $exception) {
            $errorMessage = $exception->getMessage();
        }

        require __DIR__ . '/../Views/admin/create-mix.php';
    }

    public function delete(array $vars = []): void
    {
        $this->requireAdmin();

        $slug = $vars['slug'] ?? '';

        try {
            $this->mixService->deleteMixBySlug($slug);
            $_SESSION['mix_success'] = 'Mix deleted successfully.';
        } catch (ValidationException $exception) {
            $_SESSION['mix_error'] = $exception->getMessage();
        }

        header('Location: /mixes');
        exit;
    }
}
