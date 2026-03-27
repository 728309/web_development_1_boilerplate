<?php /** @var MixModel[] $featuredMixes */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SK Production Hub</title>
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

<header class="hero-section d-flex align-items-center">
    <div class="container">
        <div class="hero-content">
            <p class="hero-kicker text-accent text-uppercase fw-bold mb-2">Electronic Label Platform</p>
            <h1 class="display-3 fw-bold mb-3">Sound. Identity. Community.</h1>
            <p class="lead text-secondary mb-4">
                SK Production Hub is a dark, modern platform for showcasing mixes, artists,
                and community submissions in one place.
            </p>
            <div class="d-flex gap-3 flex-wrap">
                <a class="btn btn-accent btn-lg" href="/mixes">Explore Mixes</a>
                <a class="btn btn-outline-light btn-lg" href="/mixes">Latest Releases</a>
            </div>
        </div>
    </div>
</header>

<section class="py-5 border-top border-secondary-subtle">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <div class="info-box p-4 h-100">
                    <h2 class="h5 text-accent">Curated Mixes</h2>
                    <p class="mb-0 text-secondary">
                        Discover public releases with artist information, genre, and direct media links.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box p-4 h-100">
                    <h2 class="h5 text-accent">Artist Showcase</h2>
                    <p class="mb-0 text-secondary">
                        Highlight artists and build a label-style platform inspired by modern music collectives.
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="info-box p-4 h-100">
                    <h2 class="h5 text-accent">Community Driven</h2>
                    <p class="mb-0 text-secondary">
                        Support submissions, comments, and voting through a real CMS-style PHP application.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 border-top border-secondary-subtle">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div>
                <p class="text-accent text-uppercase fw-bold small mb-1">Featured</p>
                <h2 class="mb-0">Latest Public Mixes</h2>
            </div>
            <a class="btn btn-outline-light" href="/mixes">View all mixes</a>
        </div>

        <div class="row g-4">
            <?php foreach ($featuredMixes as $mix): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 text-light">
                        <div class="card-body">
                            <p class="text-uppercase small text-accent fw-bold mb-2">
                                <?= htmlspecialchars($mix->genre) ?>
                            </p>

                            <h3 class="h4 mb-2">
                                <?= htmlspecialchars($mix->title) ?>
                            </h3>

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
</section>

<section class="py-5 border-top border-secondary-subtle">
    <div class="container text-center">
        <p class="text-accent text-uppercase fw-bold small mb-2">About</p>
        <h2 class="mb-3">A music platform built as a CMS project</h2>
        <p class="text-secondary mx-auto about-text">
            This website is designed as a PHP MVC application with a database-backed structure
            for mixes, artists, comments, votes, and submissions.
        </p>
    </div>
</section>
</body>
</html>
