<?php
$pageTitle = $pageTitle ?? 'SK Production Hub';
$currentPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$isHome = $currentPath === '/';
$isMixes = strpos($currentPath, '/mixes') === 0;
$isSubmit = strpos($currentPath, '/submissions') === 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
            rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css?v=2">
</head>
<body class="page-shell" data-bs-theme="dark">
<nav class="navbar navbar-expand-lg navbar-dark sticky-top border-bottom site-navbar">
    <div class="container">
        <a class="navbar-brand" href="/">SK Production Hub</a>

        <button
                class="navbar-toggler border-0 shadow-none"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#siteNav"
                aria-controls="siteNav"
                aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="siteNav">
            <ul class="navbar-nav mx-lg-auto mb-3 mb-lg-0 gap-lg-2">
                <li class="nav-item">
                    <a href="/" class="nav-link<?= $isHome ? ' active' : '' ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a href="/mixes" class="nav-link<?= $isMixes ? ' active' : '' ?>">Mixes</a>
                </li>
                <?php if (isset($_SESSION['user'])): ?>
                    <li class="nav-item">
                        <a href="/submissions/submit" class="nav-link<?= $isSubmit ? ' active' : '' ?>">Submit Mix</a>
                    </li>
                <?php endif; ?>
            </ul>

            <div class="d-flex flex-column flex-lg-row gap-2 align-items-stretch align-items-lg-center">
                <?php if (isset($_SESSION['user'])): ?>
                    <?php if (($_SESSION['user']['role'] ?? '') === 'admin'): ?>
                        <a href="/admin/create-mix" class="btn btn-light btn-sm">Create Mix</a>
                        <a href="/admin/submissions" class="btn btn-warning btn-sm">Pending</a>
                    <?php endif; ?>

                    <a href="/logout" class="btn btn-outline-light btn-sm">Logout</a>
                <?php else: ?>
                    <a href="/login" class="btn btn-outline-light btn-sm">Login</a>
                    <a href="/register" class="btn btn-accent btn-sm">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
