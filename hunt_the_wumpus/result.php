<?php
// result.php

require 'connect.php'; // Include DB connection

// Get the row and column from the URL
$row = isset($_GET['row']) ? (int)$_GET['row'] : 0;
$column = isset($_GET['column']) ? (int)$_GET['column'] : 0;

// Basic validation
if ($row < 1 || $row > 7 || $column < 1 || $column > 7) {
    die("Invalid coordinates.");
}

// Query the database to check for Wumpus at given location
$query = "SELECT has_wumpus FROM wumpus WHERE row_num = :row AND column_num = :column";
$stmt = $dbh->prepare($query);
$stmt->bindParam(':row', $row);
$stmt->bindParam(':column', $column);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$hasWumpus = $result && $result['has_wumpus'];

?>
<!DOCTYPE html>
<html>

<head>
    <title>Hunt The Wumpus Results</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/wumpus.css">
</head>

<body>
    <div id="container">

        <h1>Hunt the Wumpus!</h1>
        <?php if ($hasWumpus): ?>
            <p>You found the Wumpus!</p>
        <?php elseif ($result): ?>
            <p>You did not find the Wumpus</p>
        <?php else: ?>
            <p>This cell doesn't exist</p>
        <?php endif; ?>

        <form id="info" method="post" action="save.php">
            <input type="hidden" name="game_status" value="<?php echo $hasWumpus ? 1 : 0; ?>">

            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required pattern="^[^@]+@[^@]+\.[^@]+$" title='Please enter a valid email'>

            <input type="submit" value="Submit">
        </form>
    </div>
</body>

</html>