<?php
session_start();

if (!isset($_SESSION['number'])) {
    header("Location: index.php");
    exit;
}

$guess = isset($_POST['guess']) ? (int) $_POST['guess'] : null;
$correct = $_SESSION['number'];
?>
<!DOCTYPE html>
<html>
<head>
  <title>Guessing Game - Result</title>
</head>
<body>
  <?php if ($guess === $correct): ?>
    <h1>Correct! The number was <?= $correct ?>.</h1>
    <?php session_destroy(); ?>
    <a href="index.php">Play Again</a>
  <?php else: ?>
    <h1>❌ Wrong! <?= $guess ?> is not the correct number.</h1>
    <p>Try again!</p>
    <form action="result.php" method="post">
      <label for="guess">Your Guess:</label>
      <input type="number" name="guess" required>
      <button type="submit">Guess Again</button>
    </form>
  <?php endif; ?>
</body>
</html>
