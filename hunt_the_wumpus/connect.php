<?php

$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'mawyinl_db';

$conn = new mysqli($host, $username, $password, $dbname, 3307);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>