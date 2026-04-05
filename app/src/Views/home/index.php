<?php /** @var MixModel[] $featuredMixes */ ?>

<?php
$pageTitle = 'HomePage';
require __DIR__ . '/../Partial-View/header.php';
?>

<header class="hero-section border-bottom border-secondary-subtle">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-2 col-xl-7">
                <span class="badge rounded-pill hero-pill px-3 py-2 mb-3">Electronic Label Platform</span>
                <h1 class="hero-title mb-3">Mixes, artists, and community in one place.</h1>
                <p class="hero-lead text-secondary mb-4">
                    SK Production Hub presents public releases, artist pages, and community submissions in one place.
                </p>

                <div class="d-flex flex-wrap gap-3">
                    <a class="btn btn-accent btn-lg" href="/mixes">Explore Mixes</a>
                    <a class="btn btn-outline-light btn-lg" href="/mixes">Latest Releases</a>
                </div>
            </div>
        </div>
    </div>
</header>

<section class="section-block py-5 border-bottom border-secondary-subtle">
    <div class="container">
        <div class="row align-items-end g-3 mb-4">
            <div class="col-lg-8">
                <span class="badge rounded-pill section-chip px-3 py-2 mb-3">Featured</span>
                <h2 class="section-title mb-3">Latest Public Mixes</h2>
                <p class="text-secondary mb-0">
                    Recent releases are presented with stronger cards, clearer actions, and better visual rhythm.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a class="btn btn-outline-light" href="/mixes">View All Mixes</a>
            </div>
        </div>

        <?php if (!empty($featuredMixes)): ?>
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                <?php foreach ($featuredMixes as $index => $mix): ?>
                    <div class="col">
                        <article class="card mix-card h-100 border-0">
                            <div class="card-body p-4 d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-center gap-3 mb-3">
                                    <span class="badge rounded-pill genre-badge px-3 py-2">
                                        <?= htmlspecialchars($mix->genre) ?>
                                    </span>
                                    <span class="mix-number">0<?= $index + 1 ?></span>
                                </div>

                                <h3 class="mix-card-title mb-3">
                                    <?= htmlspecialchars($mix->title) ?>
                                </h3>

                                <p class="mix-card-artist text-white mb-2">
                                    By <?= htmlspecialchars($mix->artist_name) ?>
                                </p>

                                <p class="text-secondary mb-4 flex-grow-1">
                                    <?= htmlspecialchars($mix->description) ?>
                                </p>

                                <div class="d-flex flex-wrap gap-2">
                                    <a class="btn btn-accent" href="/mixes/<?= htmlspecialchars($mix->slug) ?>">
                                        View Details
                                    </a>
                                    <a class="btn btn-outline-light" href="<?= htmlspecialchars($mix->media_url) ?>" target="_blank">
                                        Listen
                                    </a>
                                </div>
                            </div>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert empty-state border border-secondary-subtle rounded-4 mb-0" role="alert">
                No featured mixes are available yet.
            </div>
        <?php endif; ?>
    </div>
</section>


<?php require __DIR__ . '/../Partial-View/footer.php'; ?>
