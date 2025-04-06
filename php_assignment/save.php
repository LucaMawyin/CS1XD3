<?php

// Connection to db
require 'connect.php';

// Making sure form is proper
if (isset($_POST['username'], $_POST['email'], $_POST['game_status'])) {
    $username = $_POST['username'];
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
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
    $query = "SELECT id, username, wins, losses FROM wumpus_players WHERE email = :email";
    $stmt = $dbh->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // User exists
    if ($user) {

        // Check if username is different
        if ($user['username'] !== $username) {
            $updateQuery = "UPDATE wumpus_players SET username = :username WHERE id = :id";
            $updateStmt = $dbh->prepare($updateQuery);
            $updateStmt->bindParam(':username', $username);
            $updateStmt->bindParam(':id', $user['id']);
            $updateStmt->execute();
        }

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
}

// Current user's data
$currentUserQuery = "SELECT username, wins, losses, last_date_played FROM wumpus_players WHERE email = :email";
$currentUserStmt = $dbh->prepare($currentUserQuery);
$currentUserStmt->bindParam(':email', $email);
$currentUserStmt->execute();
$currentUser = $currentUserStmt->fetch(PDO::FETCH_ASSOC);

// Top 10 players' data
$topPlayersQuery = "SELECT username, email, wins, losses, last_date_played FROM wumpus_players ORDER BY wins DESC LIMIT 10";
$topPlayersStmt = $dbh->prepare($topPlayersQuery);
$topPlayersStmt->execute();
$topPlayers = $topPlayersStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Hunt The Wumpus Leaderboard</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/wumpus.css">
</head>

<body>
    <div id="container">

        <?php if ($currentUser): ?>
            <h1>Your Stats</h1>
            <p><strong>Username:</strong> <?php echo $currentUser['username'] ?></p>
            <p><strong>Wins:</strong> <?php echo $currentUser['wins'] ?></p>
            <p><strong>Losses:</strong> <?php echo $currentUser['losses'] ?></p>
            <p><strong>Last Played:</strong> <?php echo $currentUser['last_date_played'] ?></p>
        <?php else: ?>
            <p>You are not currently logged in to a valid user</p>
        <?php endif; ?>

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
                        <td><?php echo $player['username'] ?></td>
                        <td><?php echo $player['wins'] ?></td>
                        <td><?php echo $player['losses'] ?></td>
                        <td><?php echo $player['last_date_played'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p><a href="index.php">Play Again</a></p>
    </div>
</body>
</html>