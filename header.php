<?php require_once __DIR__ . '/functions.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Book List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">
    <h1>My Book List</h1>
    <nav class="d-flex flex-wrap gap-3 mb-3" aria-label="Main navigation">
        <a href="index.php">Home</a>
        <a href="about.php">About</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <?php if (($_SESSION['role'] ?? '') === 'admin'): ?>
                <a href="admin.php">Admin</a>
            <?php endif; ?>
            <form action="logout.php" method="post">
                <?php token(); ?>
                <button class="btn btn-sm btn-secondary">Logout</button>
            </form>
        <?php else: ?>
            <a href="signup.php">Signup</a>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </nav>
    <hr>
    <?php if (isset($_SESSION['message'])): ?>
        <p class="alert alert-success"><?= e($_SESSION['message']) ?></p>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
