<?php
// Start the session before displaying HTML.
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.use_strict_mode', '1');
    session_set_cookie_params([
        'httponly' => true,
        'samesite' => 'Lax',
        'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
    ]);
    session_start();
}

// Escape text before displaying it in HTML.
function e($text)
{
    return htmlspecialchars((string) $text, ENT_QUOTES, 'UTF-8');
}

// Read and trim a text field.
function field($name)
{
    if (!is_string($_POST[$name] ?? null)) {
        return '';
    }
    return trim($_POST[$name]);
}

// Print a token to protect form submissions.
function token()
{
    if (empty($_SESSION['token'])) {
        $_SESSION['token'] = bin2hex(random_bytes(32));
    }
    echo '<input type="hidden" name="token" value="' . e($_SESSION['token']) . '">';
}

// Check that the submitted form belongs to this session.
function checkToken()
{
    $submittedToken = $_POST['token'] ?? '';
    if (!is_string($submittedToken) || empty($_SESSION['token'])
        || !hash_equals($_SESSION['token'], $submittedToken)) {
        http_response_code(403);
        exit('Invalid form. Refresh the page and try again.');
    }
}

// Accept an empty optional URL or a complete HTTP/HTTPS URL.
function validUrl($url)
{
    if ($url === '') {
        return true;
    }
    $scheme = strtolower((string) parse_url($url, PHP_URL_SCHEME));
    return strlen($url) <= 2048
        && filter_var($url, FILTER_VALIDATE_URL)
        && in_array($scheme, ['http', 'https'], true);
}

// Validate the fields shared by add and edit.
function bookErrors($title, $author, $description, $image, $link)
{
    $errors = [];
    if ($title === '' || strlen($title) > 150) {
        $errors[] = 'Enter a title of up to 150 bytes.';
    }
    if ($author === '' || strlen($author) > 100) {
        $errors[] = 'Enter an author of up to 100 bytes.';
    }
    if ($description === '' || strlen($description) > 10000) {
        $errors[] = 'Enter a description of up to 10,000 bytes.';
    }
    if (!validUrl($image)) {
        $errors[] = 'Enter a valid HTTP/HTTPS cover image URL.';
    }
    if (!validUrl($link)) {
        $errors[] = 'Enter a valid HTTP/HTTPS book website URL.';
    }
    return $errors;
}

// Validate the ID in a details, edit or delete URL.
function getId()
{
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT,
        ['options' => ['min_range' => 1]]);
    if (!$id) {
        http_response_code(404);
        exit('Book not found.');
    }
    return $id;
}

// Fetch one book using a prepared statement.
function getBook($pdo, $id)
{
    $query = $pdo->prepare('SELECT * FROM books WHERE id = ?');
    $query->execute([$id]);
    $book = $query->fetch();
    if (!$book) {
        http_response_code(404);
        exit('Book not found.');
    }
    return $book;
}
