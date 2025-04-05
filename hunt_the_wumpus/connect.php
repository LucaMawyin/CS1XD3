<?php

$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'mawyinl_db';

try {
    $dbh = new PDO('mysql:host=localhost;dbname=mawyinl_db;port=3307',
    'root',
    '');

} catch(Exception $e) {
    die("ERROR: {$e->getMessage()}");
}

?>