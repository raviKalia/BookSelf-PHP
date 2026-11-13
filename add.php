<?php
require_once __DIR__ . '/auth.php';

$title = '';
$author = '';
$description = '';
$image = '';
$link = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    checkToken();
    $title = field('title');
    $author = field('author');
    $description = field('description');
    $image = field('image_url');
    $link = field('book_url');
    $errors = bookErrors($title, $author, $description, $image, $link);

    if (empty($errors)) {
        try {
            $query = $pdo->prepare('INSERT INTO books (title, author, description, image_url, book_url) VALUES (?, ?, ?, ?, ?)');
            $query->execute([$title, $author, $description, $image, $link]);
            $_SESSION['message'] = 'Book saved successfully.';
            header('Location: admin.php');
            exit;
        } catch (PDOException $error) {
            error_log($error->getMessage());
            $errors[] = 'Unable to save the book.';
        }
    }
}
require __DIR__ . '/header.php';
?>
<h2>Add Book</h2>
<?php require __DIR__ . '/book_form.php'; ?>
<?php require __DIR__ . '/footer.php'; ?>
