<?php /** @var MixModel[] $mixes */

use App\Models\MixModel; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mixes - SK Production Hub</title>
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

            <?php if (isset($_SESSION['user']) && ($_SESSION['user']['role'] ?? '') === 'admin'): ?>
                <a class="btn btn-sm btn-outline-light" href="/admin/create-mix">Create Mix</a>
            <?php endif; ?>

            <?php if (isset($_SESSION['user'])): ?>
                <span class="text-secondary small">
                    <?= htmlspecialchars($_SESSION['user']['username']) ?>
                </span>
                <a class="btn btn-sm btn-accent" href="/logout">Logout</a>
            <?php else: ?>
                <a class="btn btn-sm btn-outline-light" href="/register">Register</a>
                <a class="btn btn-sm btn-accent" href="/login">Login</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<header class="py-5 border-bottom border-secondary-subtle">
    <div class="container">
        <h1 class="display-5 fw-bold">Public Mixes</h1>
        <p class="text-secondary mb-0">A dark label-style overview of the latest public releases.</p>
    </div>
</header>

<main class="py-5">
    <div class="container">
        <div class="row g-4">
            <?php foreach ($mixes as $mix): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 text-light">
                        <div class="card-body">
                            <p class="text-uppercase small text-accent fw-bold mb-2">
                                <?= htmlspecialchars($mix->genre) ?>
                            </p>

                            <h2 class="h4 mb-2">
                                <?= htmlspecialchars($mix->title) ?>
                            </h2>

                            <p class="mb-2 text-secondary">
                                By <?= htmlspecialchars($mix->artist_name) ?>
                            </p>

                            <p class="mb-3">
                                <?= htmlspecialchars($mix->description) ?>
                            </p>
                                    <div class="d-flex gap-2 flex-wrap">
                                        <a class="btn btn-accent" href="/mixes/<?= htmlspecialchars($mix->slug) ?>">
                                            View Details
                                        </a>

                                        <a class="btn btn-outline-light" href="<?= htmlspecialchars($mix->media_url) ?>" target="_blank">
                                            Listen
                                        </a>
                                    </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>
</body>
</html>
