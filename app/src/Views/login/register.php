<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SK Production Hub</title>
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
            <a class="btn btn-sm btn-outline-light" href="/login">Login</a>
        </div>
    </div>
</nav>

<main class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="detail-box p-4">
                    <p class="text-accent text-uppercase fw-bold small mb-2">Create Account</p>
                    <h1 class="h2 mb-4">Register</h1>

                    <?php if (!empty($errorMessage)): ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($errorMessage) ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="/register">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input
                                type="email"
                                class="form-control"
                                id="email"
                                name="email"
                                value="<?= htmlspecialchars($oldEmail ?? '') ?>"
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input
                                type="text"
                                class="form-control"
                                id="username"
                                name="username"
                                value="<?= htmlspecialchars($oldUsername ?? '') ?>"
                                required
                            >
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <input
                                type="password"
                                class="form-control"
                                id="password"
                                name="password"
                                required
                            >
                        </div>

                        <button type="submit" class="btn btn-accent w-100">Create account</button>
                    </form>

                    <div class="mt-4 text-secondary small">
                        Already have an account?
                        <a href="/login" class="text-accent">Login here</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>