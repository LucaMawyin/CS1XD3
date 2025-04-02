<?php

try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=mawyinl_db", 
        'root', 
        '0000');

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>