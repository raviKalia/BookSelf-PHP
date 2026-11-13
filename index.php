<?php
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/connection.php';

$query = $pdo->prepare('SELECT * FROM books ORDER BY id DESC');
$query->execute();
$books = $query->fetchAll();
require __DIR__ . '/header.php';
?>
<h2>Available Books</h2>
<div class="row">
    <?php foreach ($books as $book): ?>
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <?php if ($book['image_url'] !== '' && validUrl($book['image_url'])): ?>
                    <img src="<?= e($book['image_url']) ?>" alt="Cover of <?= e($book['title']) ?>"
                        class="card-img-top object-fit-contain" height="220" loading="lazy" referrerpolicy="no-referrer">
                <?php endif; ?>
                <div class="card-body">
                    <h3 class="h5"><?= e($book['title']) ?></h3>
                    <p>Author: <?= e($book['author']) ?></p>
                    <a href="details.php?id=<?= e($book['id']) ?>" class="btn btn-primary btn-sm">Details</a>
                    <?php if ($book['book_url'] !== '' && validUrl($book['book_url'])): ?>
                        <a href="<?= e($book['book_url']) ?>" class="btn btn-outline-secondary btn-sm"
                            target="_blank" rel="noopener noreferrer">Book website</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php if (empty($books)): ?>
    <p>No books have been added yet.</p>
<?php endif; ?>
<?php require __DIR__ . '/footer.php'; ?>
