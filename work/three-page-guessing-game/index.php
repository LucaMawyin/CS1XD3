<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Guessing Game - Choose Range</title>
</head>
<body>
  <h1>Enter a Number Range</h1>
  <form action="guess.php" method="post">
    <label for="min">Minimum:</label>
    <input type="number" name="min" required>
    <label for="max">Maximum:</label>
    <input type="number" name="max" required>
    <button type="submit">Start Game</button>
  </form>
</body>
</html>