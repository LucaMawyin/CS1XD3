<?php

// Connection to db
require 'connect.php';

// Making sure form is proper
if (isset($_POST['username'], $_POST['email'], $_POST['game_status'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $gameStatus = $_POST['game_status'];
    
    // Determining wins and losses
    if ($gameStatus == 1) {
        $wins = 1;
        $losses = 0;
    } else {
        $wins = 0;
        $losses = 1;
    }

    // Check if user exists
    $query = "SELECT id, wins, losses FROM wumpus_players WHERE email = :email OR username = :username";
    $stmt = $dbh->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // User exists
    if ($user) {
        
        // Update wins and losses
        $newWins = $user['wins'] + $wins;
        $newLosses = $user['losses'] + $losses;

        $updateQuery = "UPDATE wumpus_players SET wins = :wins, losses = :losses, last_date_played = CURRENT_TIMESTAMP WHERE id = :id";
        $updateStmt = $dbh->prepare($updateQuery);
        $updateStmt->bindParam(':wins', $newWins);
        $updateStmt->bindParam(':losses', $newLosses);
        $updateStmt->bindParam(':id', $user['id']);
        
        $updateStmt->execute();
    }
    
    // User does not exist
    else {
        $query = "INSERT INTO wumpus_players (username, email, wins, losses, last_date_played) 
                  VALUES (:username, :email, :wins, :losses, CURRENT_TIMESTAMP)";
        $stmt = $dbh->prepare($query);

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':wins', $wins);
        $stmt->bindParam(':losses', $losses);

        $stmt->execute();
    }
} else {
    echo "Please fill out the form.";
}

$topPlayersQuery = "SELECT username, email, wins, losses, last_date_played FROM wumpus_players ORDER BY wins DESC LIMIT 10";
$topPlayersStmt = $dbh->prepare($topPlayersQuery);
$topPlayersStmt->execute();
$topPlayers = $topPlayersStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Hunt The Wumpus Leaderboard</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/wumpus.css">
</head>

<body>
    <div id="container">
        <h1>Wumpus Leaderboard</h1>

        <h2>Top 10 Players</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Wins</th>
                    <th>Losses</th>
                    <th>Date Played</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($topPlayers as $player): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($player['username']); ?></td>
                        <td><?php echo htmlspecialchars($player['wins']); ?></td>
                        <td><?php echo htmlspecialchars($player['losses']); ?></td>
                        <td><?php echo htmlspecialchars($player['last_date_played']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p><a href="index.php">Play Again</a></p>
    </div>
</body>
</html>