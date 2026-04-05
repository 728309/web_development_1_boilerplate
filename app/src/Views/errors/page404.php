<?php
$title = $title ?? 'Page not found';
$message = $message ?? 'The page you are looking for does not exist.';
?>
<?php
$pageTitle = 'Error';
require __DIR__ . '/../Partial-View/header.php';
?>

<main class="container py-5">
    <div class="text-center py-5">
        <h1 class="display-5 fw-bold mb-3"><?= htmlspecialchars($title) ?></h1>
        <p class="lead text-secondary mb-4"><?= htmlspecialchars($message) ?></p>
        <a href="/" class="btn btn-light me-2">Home</a>
        <a href="/mixes" class="btn btn-outline-light">Browse mixes</a>
    </div>
</main>

<?php require __DIR__ . '/../Partial-View/footer.php'; ?>