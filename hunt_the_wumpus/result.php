<?php
include "connect.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Hunt The Wumpus Results</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/wumpus.css">
</head>

<body>
    <div id="container">
        <h1>Hunt the Wumpus!</h1>

        <?php

        $row = isset($_GET['row']) ? (int)$_GET['row'] : 0;
        $column = isset($_GET['column']) ? (int)$_GET['column'] : 0;

        // Valid row and column
        if ($row >= 1 && $row <= 7 && $column >= 1 && $column <= 7) {

            // Preparing SQL query
            $query = "SELECT has_wumpus FROM wumpus WHERE row_num = ? AND column_num = ?";

            // Creating and executing statement
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $row, $column);
            $stmt->execute();

            // Creating a variable to hold the result
            $stmt->bind_result($has_wumpus);

            // Getting result
            $stmt->fetch();
            if ($has_wumpus) {
                echo "<h2>You found the Wumpus at ($row, $column)</h2>";
            } else {
                echo "<h2>No Wumpus at ($row, $column)</h2>";
            }

            $stmt->close();
        } 
        
        // Invalid row or column redirects to home page
        else {
            header("Location: index.php");
            exit();
        }

        $conn->close();
        ?>
    </div>
</body>

</html>
