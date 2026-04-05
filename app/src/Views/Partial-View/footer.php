<footer class="site-footer border-top border-secondary-subtle">
    <div class="container py-5">
        <div class="row g-4 g-lg-5">
            <div class="col-lg-5">
                <span class="badge rounded-pill footer-badge px-3 py-2">SK Production Hub</span>
                <h2 class="footer-title mt-3 mb-3">Built for mixes, artists, and submissions.</h2>
                <p class="footer-copy text-secondary mb-4">
                    A dark platform with a cleaner Bootstrap-based structure, made for public releases,
                    artist visibility, and community interaction.
                </p>

                <div class="d-flex flex-wrap gap-2">
                    <a href="/mixes" class="btn btn-accent btn-sm">Browse Mixes</a>
                    <?php if (!isset($_SESSION['user'])): ?>
                        <a href="/register" class="btn btn-outline-light btn-sm">Create Account</a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-6 col-lg-2">
                <h3 class="footer-heading">Navigate</h3>
                <ul class="nav flex-column footer-links">
                    <li class="nav-item"><a href="/">Home</a></li>
                    <li class="nav-item"><a href="/mixes">Mixes</a></li>
                    <?php if (isset($_SESSION['user'])): ?>
                        <li class="nav-item"><a href="/submissions/submit">Submit Mix</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a href="/login">Login to Submit</a></li>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="col-6 col-lg-2">
                <h3 class="footer-heading">Account</h3>
                <ul class="nav flex-column footer-links">
                    <?php if (isset($_SESSION['user'])): ?>
                        <li class="nav-item"><a href="/logout">Logout</a></li>

                        <?php if (($_SESSION['user']['role'] ?? '') === 'admin'): ?>
                            <li class="nav-item"><a href="/admin/create-mix">Create Mix</a></li>
                            <li class="nav-item"><a href="/admin/submissions">Pending</a></li>
                        <?php endif; ?>
                    <?php else: ?>
                        <li class="nav-item"><a href="/login">Login</a></li>
                        <li class="nav-item"><a href="/register">Register</a></li>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="col-lg-3">
                <h3 class="footer-heading">Platform</h3>
                <div class="footer-notes">
                    <p class="mb-2">Curated mix pages with direct media access.</p>
                    <p class="mb-2">Artist-focused webpage.</p>
                </div>
            </div>
        </div>

        <div class="footer-bottom d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mt-4 pt-4">
            <p class="mb-0">&copy; <?= date('Y') ?> SK Production Hub</p>
        </div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
