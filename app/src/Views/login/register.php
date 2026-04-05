<?php
$pageTitle = 'RegisterPage';
require __DIR__ . '/../Partial-View/header.php';
?>

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

<?php require __DIR__ . '/../Partial-View/footer.php'; ?>