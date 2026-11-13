<?php
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/connection.php';

$name = '';
$email = '';
$errors = [];

// Process the submitted form before showing HTML.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    checkToken();
    $name = field('name');
    $email = field('email');
    $password = is_string($_POST['password'] ?? null) ? $_POST['password'] : '';

    if ($name === '' || strlen($name) > 100) {
        $errors[] = 'Enter a name of up to 100 bytes.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 150) {
        $errors[] = 'Enter a valid email address.';
    }
    if (strlen($password) < 12 || strlen($password) > 72) {
        $errors[] = 'Password must contain 12–72 bytes.';
    }

    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        try {
            $query = $pdo->prepare('INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)');
            $query->execute([$name, $email, $hashedPassword, 'user']);
            $_SESSION['message'] = 'Account created. Please log in.';
            header('Location: login.php');
            exit;
        } catch (PDOException $error) {
            if ($error->getCode() === '23000') {
                $errors[] = 'This email is already registered.';
            } else {
                error_log($error->getMessage());
                $errors[] = 'Registration failed. Please try again.';
            }
        }
    }
}
require __DIR__ . '/header.php';
?>
<h2>Signup</h2>
<?php require __DIR__ . '/errors.php'; ?>
<form method="post">
    <?php token(); ?>
    <label for="name" class="form-label">Name</label>
    <input id="name" name="name" class="form-control mb-3" maxlength="100" value="<?= e($name) ?>" autocomplete="name" required>
    <label for="email" class="form-label">Email</label>
    <input type="email" id="email" name="email" class="form-control mb-3" maxlength="150" value="<?= e($email) ?>" autocomplete="email" required>
    <label for="password" class="form-label">Password (12–72 bytes)</label>
    <input type="password" id="password" name="password" class="form-control mb-3" minlength="12" maxlength="72" autocomplete="new-password" required>
    <button class="btn btn-primary">Signup</button>
</form>
<?php require __DIR__ . '/footer.php'; ?>
