<?php
include "connect.php"; // Connect to the database

// Number of Wumpuses to generate
$num_wumpuses = 5;

// Get the clicked cell coordinates from URL
if (isset($_GET['row']) && isset($_GET['column'])) {
    $row = intval($_GET['row']);
    $column = intval($_GET['column']);

    // Check if a Wumpus is in the selected cell
    $stmt = $pdo->prepare("SELECT has_wumpus FROM wumpus WHERE row_num = ? AND column_num = ?");
    $stmt->execute([$row, $column]);
    $cell = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cell) {
        if ($cell['has_wumpus']) {
            echo "<h2>You found the Wumpus! 💀</h2>";
        } else {
            echo "<h2>No Wumpus here! Keep searching. 👀</h2>";
        }
    } else {
        echo "<h2>Invalid cell!</h2>";
    }
} else {
    echo "<h2>Error: No row/column provided.</h2>";
}
?>