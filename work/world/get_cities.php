<?php
$host = 'localhost';
$db   = 'mawyinl_db';
$user = 'root';
$pass = '';

$dsn = "mysql:host=$host;dbname=$db;port=3307";

try {
    $pdo = new PDO($dsn, $user, $pass);

    $min = isset($_GET['min']) ? (int)$_GET['min'] : 0;
    $max = isset($_GET['max']) ? (int)$_GET['max'] : 10000000;

    $sql = "
        SELECT 
            City.Name AS city_name, 
            City.District, 
            City.Population AS city_population,
            Country.Name AS country_name,
            Country.Region,
            Country.SurfaceArea,
            Country.LifeExpectancy
        FROM City
        JOIN Country ON City.CountryCode = Country.Code
        WHERE City.Population BETWEEN ? AND ?
        ORDER BY City.Population DESC
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$min, $max]);
    $cities = $stmt->fetchAll();

    echo json_encode($cities);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
