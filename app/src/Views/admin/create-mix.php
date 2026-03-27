<?php
/** @var array<int, array{artist_id:int, stage_name:string}> $artists */
/** @var array<string, string> $old */
/** @var string|null $errorMessage */

$artists = $artists ?? [];
$old = $old ?? [];
$errorMessage = $errorMessage ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Mix - SK Production Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg border-bottom border-secondary-subtle">
    <div class="container">
        <a class="navbar-brand fw-bold text-accent" href="/">SK Production Hub</a>
        <div class="d-flex gap-2 align-items-center flex-wrap">
            <a class="btn btn-sm btn-outline-light" href="/">Home</a>
            <a class="btn btn-sm btn-outline-light" href="/mixes">Mixes</a>
            <a class="btn btn-sm btn-accent" href="/admin/create-mix">Create Mix</a>
        </div>
    </div>
</nav>

<main class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="detail-box p-4">
                    <p class="text-accent text-uppercase fw-bold small mb-2">Admin</p>
                    <h1 class="h2 mb-4">Create Mix</h1>

                    <?php if (!empty($errorMessage)): ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($errorMessage) ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="/admin/create-mix">
                        <div class="mb-3">
                            <label for="artist_id" class="form-label">Artist</label>
                            <select class="form-select" id="artist_id" name="artist_id" required>
                                <option value="">Choose an artist</option>

                                <?php foreach ($artists as $artist): ?>
                                    <option
                                        value="<?= htmlspecialchars((string) $artist['artist_id']) ?>"
                                        <?= ($old['artist_id'] ?? '') === (string) $artist['artist_id'] ? 'selected' : '' ?>
                                    >
                                        <?= htmlspecialchars($artist['stage_name']) ?>
                                    </option>
                                <?php endforeach; ?>

                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input
                                type="text"
                                class="form-control"
                                id="title"
                                name="title"
                                value="<?= htmlspecialchars($old['title'] ?? '') ?>"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="genre" class="form-label">Genre</label>
                            <input
                                type="text"
                                class="form-control"
                                id="genre"
                                name="genre"
                                value="<?= htmlspecialchars($old['genre'] ?? '') ?>"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea
                                class="form-control"
                                id="description"
                                name="description"
                                rows="4"
                                required
                            ><?= htmlspecialchars($old['description'] ?? '') ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="tracklist" class="form-label">Tracklist</label>
                            <textarea
                                class="form-control"
                                id="tracklist"
                                name="tracklist"
                                rows="4"
                            ><?= htmlspecialchars($old['tracklist'] ?? '') ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="media_url" class="form-label">Media URL</label>
                            <input
                                type="url"
                                class="form-control"
                                id="media_url"
                                name="media_url"
                                value="<?= htmlspecialchars($old['media_url'] ?? '') ?>"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="duration" class="form-label">Duration in seconds</label>
                            <input
                                type="number"
                                min="0"
                                class="form-control"
                                id="duration"
                                name="duration"
                                value="<?= htmlspecialchars($old['duration'] ?? '') ?>"
                            >
                        </div>

                        <div class="form-check mb-4">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                value="1"
                                id="is_featured"
                                name="is_featured"
                                <?= ($old['is_featured'] ?? '0') === '1' ? 'checked' : '' ?>
                            >
                            <label class="form-check-label" for="is_featured">
                                Mark as featured
                            </label>
                        </div>

                        <button type="submit" class="btn btn-accent w-100">
                            Create Mix
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>
