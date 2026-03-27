<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Mix</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-black text-light">
<div class="container py-5">
    <h1 class="mb-4">Submit a Mix</h1>

    <?php if (isset($_SESSION['submission_error'])): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($_SESSION['submission_error']) ?>
        </div>
        <?php unset($_SESSION['submission_error']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['submission_success'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_SESSION['submission_success']) ?>
        </div>
        <?php unset($_SESSION['submission_success']); ?>
    <?php endif; ?>

    <form method="POST" action="/submissions">
        <div class="mb-3">
            <label for="title" class="form-label">Mix title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>

        <div class="mb-3">
            <label for="artist_name" class="form-label">Artist name</label>
            <input type="text" class="form-control" id="artist_name" name="artist_name" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
        </div>

        <div class="mb-3">
            <label for="genre" class="form-label">Genre</label>
            <input type="text" class="form-control" id="genre" name="genre" required>
        </div>

        <div class="mb-4">
            <label for="media_url" class="form-label">Media URL</label>
            <input type="url" class="form-control" id="media_url" name="media_url" required>
        </div>

        <button type="submit" class="btn btn-light">Submit</button>
    </form>
</div>
</body>
</html>