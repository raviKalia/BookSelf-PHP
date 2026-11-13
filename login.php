<?php
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/connection.php';

$email = '';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    checkToken();
    $email = field('email');
    $password = is_string($_POST['password'] ?? null) ? $_POST['password'] : '';

    // Basic per-session cooldown after repeated failures.
    if (time() < ($_SESSION['blocked_until'] ?? 0)) {
        $errors[] = 'Please wait five minutes before trying again.';
    } else {
        $query = $pdo->prepare('SELECT * FROM users WHERE email = ?');
        $query->execute([$email]);
        $user = $query->fetch();
        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION = ['user_id' => $user['id'], 'role' => $user['role']];
            if ($user['role'] === 'admin') {
                header('Location: admin.php');
            } else {
                header('Location: index.php');
            }
            exit;
        }
        $_SESSION['attempts'] = ($_SESSION['attempts'] ?? 0) + 1;
        if ($_SESSION['attempts'] >= 5) {
            $_SESSION['blocked_until'] = time() + 300;
            $_SESSION['attempts'] = 0;
        }
        $errors[] = 'Incorrect email or password.';
    }
}
require __DIR__ . '/header.php';
?>
<h2>Login</h2>
<?php require __DIR__ . '/errors.php'; ?>
<form method="post">
    <?php token(); ?>
    <label for="email" class="form-label">Email</label>
    <input type="email" id="email" name="email" class="form-control mb-3" maxlength="150" value="<?= e($email) ?>" autocomplete="username" required>
    <label for="password" class="form-label">Password</label>
    <input type="password" id="password" name="password" class="form-control mb-3" autocomplete="current-password" required>
    <button class="btn btn-primary">Login</button>
</form>
<?php require __DIR__ . '/footer.php'; ?>
