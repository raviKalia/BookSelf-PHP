<?php
    // functions.php contains utility functions for the application.
    require_once __DIR__ . '/functions.php';
    // connection.php establishes a connection to the database using PDO.
    require_once __DIR__ . '/connection.php';
    $id = getId();
    $book = getBook($pdo, $id);
    require __DIR__ . '/header.php';
    ?>
    <h2><?= e($book['title']) ?></h2>

    <?php if ($book['image_url'] !== '' && validUrl($book['image_url'])): ?>
        // Display the book cover image if the image URL is valid and not empty. The referrerpolicy="no-referrer" attribute is used to prevent the browser from sending the referrer header when fetching the image, enhancing privacy.
        <img src="<?= e($book['image_url']) ?>" alt="Cover of <?= e($book['title']) ?>"
            class="img-thumbnail mb-3" width="200" referrerpolicy="no-referrer">
    <?php endif; ?>
        <p>
            <strong>Author:</strong> <?= e($book['author']) ?>
        </p>
        <p class="text-break"><?= nl2br(e($book['description'])) ?></p>

    <?php if ($book['book_url'] !== '' && validUrl($book['book_url'])): ?>
        <p>
            <a href="<?= e($book['book_url']) ?>" target="_blank" rel="noopener noreferrer">
                Visit book website.
            </a>
        </p>
    <?php endif; ?>

    <a href="index.php" class="btn btn-secondary">Back to books</a>

    <?php require __DIR__ . '/footer.php'; ?>
