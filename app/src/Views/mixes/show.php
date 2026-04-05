<?php /** @var MixModel $mix */

use App\Models\MixModel; ?>
<?php
$pageTitle = 'ShowPage';
require __DIR__ . '/../Partial-View/header.php';
?>

<header class="py-5 border-bottom border-secondary-subtle">
    <div class="container">
        <p class="text-accent text-uppercase fw-bold small mb-2">
            <?= htmlspecialchars($mix->genre) ?>
        </p>
        <h1 class="display-5 fw-bold mb-2">
            <?= htmlspecialchars($mix->title) ?>
        </h1>
        <p class="text-secondary mb-0">
            By <?= htmlspecialchars($mix->artist_name) ?>
        </p>
    </div>
</header>

<?php if (isset($_SESSION['user']) && ($_SESSION['user']['role'] ?? '') === 'admin'): ?>
    <form
            method="POST"
            action="/admin/mixes/<?= urlencode($mix->slug) ?>/delete"
            onsubmit="return confirm('Are you sure you want to delete this mix?');"
            class="mt-3"
    >
        <button type="submit" class="btn btn-outline-danger w-100">Delete Mix</button>
    </form>
<?php endif; ?>

<?php if (!empty($mix->media_url)): ?>
        <div class="mt-4">
            <?php if (str_contains($mix->media_url, 'soundcloud.com')): ?>
                <iframe
                        width="100%"
                        height="166"
                        scrolling="no"
                        frameborder="no"
                        allow="autoplay"
                        src="https://w.soundcloud.com/player/?url=<?= urlencode($mix->media_url) ?>&color=%23ff7a1a&auto_play=false&hide_related=false&show_comments=false&show_user=true&show_reposts=false&show_teaser=true">
                </iframe>
            <?php else: ?>
                <a class="btn btn-outline-light" href="<?= htmlspecialchars($mix->media_url) ?>" target="_blank">
                    Listen
                </a>
            <?php endif; ?>
        </div>
    <?php endif; ?>

<main class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="detail-box p-4 mb-4">
                    <h2 class="h4 mb-3">Description</h2>
                    <p><?= nl2br(htmlspecialchars($mix->description)) ?></p>
                    <h2 class="h4 mt-4 mb-3">Tracklist</h2>
                    <p>
                        <?= $mix->tracklist !== null && $mix->tracklist !== ''
                                ? nl2br(htmlspecialchars($mix->tracklist))
                                : 'No tracklist available yet.' ?>
                    </p>
                </div>

                <div class="detail-box p-4">
                    <h2 class="h4 mb-4">Comments</h2>

                    <?php if (!empty($_SESSION['comment_error'])): ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($_SESSION['comment_error']) ?>
                        </div>
                        <?php unset($_SESSION['comment_error']); ?>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['user'])): ?>
                        <form method="post" action="/mixes/<?= htmlspecialchars($mix->slug) ?>/comments" class="mb-4">
                            <div class="mb-3">
                                <label for="content" class="form-label">Leave a comment</label>
                                <textarea
                                        class="form-control"
                                        id="content"
                                        name="content"
                                        rows="4"
                                        required
                                ></textarea>
                            </div>
                            <button type="submit" class="btn btn-accent">Post Comment</button>
                        </form>
                    <?php else: ?>
                        <div class="alert alert-secondary">
                            Please <a href="/login" class="text-accent">log in</a> to post a comment.
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($comments)): ?>
                        <div class="d-flex flex-column gap-3">
                            <?php foreach ($comments as $comment): ?>
                                <div class="comment-box p-3">
                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
                                        <strong><?= htmlspecialchars($comment['username']) ?></strong>
                                        <span class="text-secondary small">
                                            <?= htmlspecialchars($comment['created_at']) ?>
                                        </span>
                                    </div>
                                    <p class="mb-0">
                                        <?= nl2br(htmlspecialchars($comment['content'])) ?>
                                    </p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-secondary mb-0">No comments yet.</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-lg-4">
                <div
                        class="detail-box p-4 h-100"
                        id="vote-box"
                        data-vote-url="/api/mixes/<?= urlencode($mix->slug) ?>/votes"
                >


                    <h2 class="h5 mb-3">Vote</h2>

                    <p class="mb-2">
                        Likes: <span id="like-count">0</span>
                    </p>

                    <p class="mb-3">
                        Dislikes: <span id="dislike-count">0</span>
                    </p>
                        <?php if (isset($_SESSION['user'])): ?>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-accent" id="like-button">Like</button>
                                <button type="button" class="btn btn-outline-light" id="dislike-button">Dislike</button>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-secondary mb-0">
                                Please <a href="/login" class="text-accent">log in</a> to vote.
                            </div>
                        <?php endif; ?>
                    <p id="vote-message" class="mt-2 small text-light"></p>

                    <h2 class="h5 mb-3">Mix Info</h2>

                    <p class="mb-2">
                        <strong>Artist:</strong>
                        <?= htmlspecialchars($mix->artist_name) ?>
                    </p>

                    <p class="mb-2">
                        <strong>Genre:</strong>
                        <?= htmlspecialchars($mix->genre) ?>
                    </p>

                    <p class="mb-4">
                        <strong>Duration:</strong>
                        <?= $mix->duration !== null ? htmlspecialchars((string) $mix->duration) . ' seconds' : 'Unknown' ?>
                    </p>

                    <a class="btn btn-accent w-100" href="<?= htmlspecialchars($mix->media_url) ?>" target="_blank">
                        Listen Now
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="/assets/js/vote_system.js"></script>

<?php require __DIR__ . '/../Partial-View/footer.php'; ?>