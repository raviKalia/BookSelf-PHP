<?php
require_once __DIR__ . '/auth.php';

$id = getId();
$book = getBook($pdo, $id);
// Fill the form with the existing values.
$title = $book['title'];
$author = $book['author'];
$description = $book['description'];
$image = $book['image_url'];
$link = $book['book_url'];
$errors = [];

// if the form is submitted, validate the input and update the book in the database.

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
            $query = $pdo->prepare('UPDATE books SET title = ?, author = ?, description = ?, image_url = ?, book_url = ? WHERE id = ?');
            // Execute the prepared statement with the updated book details and the book ID to update the record in the database.
            $query->execute([$title, $author, $description, $image, $link, $id]);
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
<h2>Edit Book</h2>
<?php require __DIR__ . '/book_form.php'; ?>
<?php require __DIR__ . '/footer.php'; ?>
