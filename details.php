<?php
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/connection.php';
$id = getId();
$book = getBook($pdo, $id);
require __DIR__ . '/header.php';
?>
<h2><?= e($book['title']) ?></h2>
<?php if ($book['image_url'] !== '' && validUrl($book['image_url'])): ?>
    <img src="<?= e($book['image_url']) ?>" alt="Cover of <?= e($book['title']) ?>"
        class="img-thumbnail mb-3" width="200" referrerpolicy="no-referrer">
<?php endif; ?>
<p><strong>Author:</strong> <?= e($book['author']) ?></p>
<p class="text-break"><?= nl2br(e($book['description'])) ?></p>
<?php if ($book['book_url'] !== '' && validUrl($book['book_url'])): ?>
    <p>
        <a href="<?= e($book['book_url']) ?>" target="_blank" rel="noopener noreferrer">
            Visit book website.
        </a>
    </p>
<?php endif; ?>
<a href="index.php">Back to books</a>
<?php require __DIR__ . '/footer.php'; ?>
