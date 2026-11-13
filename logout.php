<?php
require_once __DIR__ . '/functions.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    exit('Use the Logout button.');
}
checkToken();
$_SESSION = [];
$cookie = session_get_cookie_params();
setcookie(session_name(), '', [
    'expires' => time() - 3600,
    'path' => $cookie['path'],
    'domain' => $cookie['domain'],
    'secure' => $cookie['secure'],
    'httponly' => true,
    'samesite' => 'Lax'
]);
session_destroy();
header('Location: login.php');
exit;
