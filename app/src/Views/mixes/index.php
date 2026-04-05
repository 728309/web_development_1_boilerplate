<?php /** @var MixModel[] $mixes */

use App\Models\MixModel; ?>

<?php
$pageTitle = 'Mixes';
require __DIR__ . '/../Partial-View/header.php';
?>

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

                                <?php if (isset($_SESSION['user']) && ($_SESSION['user']['role'] ?? '') === 'admin'): ?>
                                    <form
                                            method="POST"
                                            action="/admin/mixes/<?= urlencode($mix->slug) ?>/delete"
                                            onsubmit="return confirm('Are you sure you want to delete this mix?');"
                                            class="m-0"
                                    >
                                        <button type="submit" class="btn btn-outline-danger">Delete</button>
                                    </form>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<?php require __DIR__ . '/../Partial-View/footer.php'; ?>
