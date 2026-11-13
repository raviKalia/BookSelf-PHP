<?php
require_once __DIR__ . '/auth.php';
$id = getId();
$book = getBook($pdo, $id);
$errors = [];

// Visiting the page only shows confirmation. POST performs deletion.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check CSRF: cross-site request forgery token before performing deletion. it helps prevent malicious requests from other sites.
    checkToken();
    try {
        $query = $pdo->prepare('DELETE FROM books WHERE id = ?');
        $query->execute([$id]);
        $_SESSION['message'] = 'Book deleted successfully.';
        header('Location: admin.php');
        exit;
    } catch (PDOException $error) {
        error_log($error->getMessage());
        $errors[] = 'Unable to delete the book.';
    }
}
require __DIR__ . '/header.php';
?>
<h2>Delete Book</h2>
<?php require __DIR__ . '/errors.php'; ?>
<p>Delete <strong><?= e($book['title']) ?></strong>?</p>
<form method="post">
    <?php token(); ?>
    <button class="btn btn-danger">Yes, Delete</button>
    <a href="admin.php" class="btn btn-secondary">Cancel</a>
</form>
<?php require __DIR__ . '/footer.php'; ?>
