<?php
// Database configuration
$dbConfig = [
    'host' => 'localhost',
    'dbname' => 'student',
    'user' => 'root',
    'password' => '123',
];

try {
    $conn = new PDO(
        "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']}",
        $dbConfig['user'],
        $dbConfig['password']
    );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
