<?php require __DIR__ . '/errors.php'; ?>
<form method="post">
    <?php token(); ?>

    <label for="title" class="form-label">Title</label>
    <input type="text" id="title" name="title" class="form-control mb-3" maxlength="150" value="<?= e($title) ?>" required>

    <label for="author" class="form-label">Author</label>
    <input type="text" id="author" name="author" class="form-control mb-3" maxlength="100" value="<?= e($author) ?>" required>

    <label for="description" class="form-label">Description</label>
    <textarea id="description" name="description" class="form-control mb-3" rows="5" maxlength="10000" required><?= e($description) ?></textarea>

    <label for="image_url" class="form-label">Cover image URL (optional)</label>
    <input type="url" id="image_url" name="image_url" class="form-control mb-3" maxlength="2048" value="<?= e($image) ?>">

    <label for="book_url" class="form-label">Book website URL (optional)</label>
    <input type="url" id="book_url" name="book_url" class="form-control mb-3" maxlength="2048" value="<?= e($link) ?>">

    <button class="btn btn-primary">Save</button>
    <a href="admin.php" class="btn btn-secondary">Cancel</a>
</form>
