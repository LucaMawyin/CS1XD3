<?php

try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=mawyinl_db", 
        'mawyinl', 
        'IsNYpt73!');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create the `wumpus` table if it does not exist
    $sql = "CREATE TABLE IF NOT EXISTS wumpus (
        id INT AUTO_INCREMENT PRIMARY KEY,
        row_num TINYINT NOT NULL CHECK (row_num BETWEEN 1 AND 7),
        column_num TINYINT NOT NULL CHECK (column_num BETWEEN 1 AND 7),
        has_wumpus BOOLEAN NOT NULL DEFAULT 0
    )";
    $pdo->exec($sql);

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>