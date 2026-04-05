<?php
$pageTitle = 'Pending Submissions';
require __DIR__ . '/../Partial-View/header.php';
?>

<div class="container py-5">
    <h1 class="mb-4">Pending Submissions</h1>

    <?php if (empty($submissions)): ?>
        <div class="alert alert-secondary">
            No pending submissions found.
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($submissions as $submission): ?>
                <div class="col-12">
                    <div class="card bg-dark text-light border-secondary">
                        <div class="card-body">
                            <h2 class="h4 mb-3">
                                <?= htmlspecialchars($submission['title']) ?>
                            </h2>

                            <p class="mb-2">
                                <strong>Artist:</strong>
                                <?= htmlspecialchars($submission['artist_name']) ?>
                            </p>

                            <p class="mb-2">
                                <strong>Genre:</strong>
                                <?= htmlspecialchars($submission['genre']) ?>
                            </p>

                            <p class="mb-2">
                                <strong>Media URL:</strong>
                                <?= htmlspecialchars($submission['media_url']) ?>
                            </p>

                            <p class="mb-2">
                                <strong>Description:</strong><br>
                                <?= nl2br(htmlspecialchars($submission['description'])) ?>
                            </p>

                            <p class="mb-0 text-secondary">
                                Submitted at: <?= htmlspecialchars($submission['created_at']) ?>
                            </p>

                            <div class="d-flex gap-2 mt-3">
                                <form method="POST" action="/admin/submissions/<?= $submission['submission_id'] ?>/approve">
                                    <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                </form>

                                <form method="POST" action="/admin/submissions/<?= $submission['submission_id'] ?>/reject">
                                    <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

<?php require __DIR__ . '/../Partial-View/footer.php'; ?>