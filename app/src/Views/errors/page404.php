<?php
$title = $title ?? 'Page not found';
$message = $message ?? 'The page you are looking for does not exist.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>
<body class="bg-black text-light">
<nav class="navbar navbar-expand-lg border-bottom border-secondary">
    <div class="container">
        <a class="navbar-brand text-light" href="/">SK Production Hub</a>
        <div>
            <a href="/mixes" class="btn btn-outline-light btn-sm">Back to mixes</a>
        </div>
    </div>
</nav>

<main class="container py-5">
    <div class="text-center py-5">
        <h1 class="display-5 fw-bold mb-3"><?= htmlspecialchars($title) ?></h1>
        <p class="lead text-secondary mb-4"><?= htmlspecialchars($message) ?></p>
        <a href="/" class="btn btn-light me-2">Home</a>
        <a href="/mixes" class="btn btn-outline-light">Browse mixes</a>
    </div>
</main>
</body>
</html>