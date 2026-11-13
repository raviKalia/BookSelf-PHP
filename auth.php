<?php
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/connection.php';
// check if the user is logged in or not. If not redirect to login page.
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Always check the current user role in MySQL.
$query = $pdo->prepare('SELECT role FROM users WHERE id = ?');
$query->execute([$_SESSION['user_id']]);
$user = $query->fetch();
if (!$user || $user['role'] !== 'admin') {
    http_response_code(403);
    exit('Access denied. Only administrators can open this page.');
}
