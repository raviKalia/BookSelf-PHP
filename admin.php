<?php
require_once __DIR__ . '/auth.php';
$query = $pdo->prepare('SELECT * FROM books ORDER BY id DESC');
$query->execute();
$books = $query->fetchAll();
require __DIR__ . '/header.php';
?>
<h2>Admin Panel</h2>
<a href="add.php" class="btn btn-primary mb-3">Add Book</a>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead><tr><th>Title</th><th>Author</th><th>Actions</th></tr></thead>
        <tbody>
            <?php foreach ($books as $book): ?>
                <tr>
                    <td><?= e($book['title']) ?></td>
                    <td><?= e($book['author']) ?></td>
                    <td>
                        <a href="edit.php?id=<?= e($book['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete.php?id=<?= e($book['id']) ?>" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php if (empty($books)): ?><p>No books yet.</p><?php endif; ?>
<?php require __DIR__ . '/footer.php'; ?>
