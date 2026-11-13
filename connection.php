<?php
// infinityfree credentials for database connections:
$host = 'sql207.infinityfree.com';
$port = '3306';
$database = 'if0_43411821_bookself';
$username = 'if0_43411821';
$password = 'Rkmay2001';

// local credentials for database connections:
try {
    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$database;charset=utf8mb4",
        $username,
        $password,
        [
        // pdo attributes to throw exceptions on errors, return associative arrays, and disable emulated prepared statements.
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} 
catch (PDOException $error) {
    error_log($error->getMessage());
    exit('Database connection failed. Check connection.php.');
}
