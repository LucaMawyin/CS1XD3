<?php

// Connect to db
require 'connect.php';

// Longest if statement ever
// Redirect back home if any post parameters are wrong
if (!(isset($_GET['row']) && isset($_GET['column'])) || 
    (isset($_GET['row']) && isset($_GET['column'])) && 
    (
        (int)$_GET['row'] < 1 || (int)$_GET['row'] > 7 || 
        (int)$_GET['column'] < 1 || (int)$_GET['column'] > 7
    )) {
    header('Location: index.php');
    exit;
}

// Get row and column (default to 1 if not set)
$row = (int)$_GET['row'];
$column = (int)$_GET['column'];

// Check db at coords
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
            <h2>You found the Wumpus!</h2>
        <?php elseif ($result): ?>
            <h2>You did not find the Wumpus</h2>
        <?php else: ?>
            <h2>This cell doesn't exist. You lose</h2>
        <?php endif; ?>

        <form id="info" method="post" action="save.php">
            <input type="hidden" name="game_status" value="<?php echo $hasWumpus ?>">

            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required pattern="^[^@]+@[^@]+\.[^@]+$" title='Please enter a valid email'>

            <input type="submit" value="Submit">
        </form>
    </div>
</body>

</html>