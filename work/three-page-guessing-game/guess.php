<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $min = (int) $_POST['min'];
    $max = (int) $_POST['max'];

    if ($min >= $max) {
        die("Minimum must be less than maximum.");
    }

    // Save range in session
    $_SESSION['min'] = $min;
    $_SESSION['max'] = $max;

    // Generate and store random number if not already stored
    if (!isset($_SESSION['number'])) {
        $_SESSION['number'] = rand($min, $max);
    }
} elseif (!isset($_SESSION['number'])) {
    // If someone visits this page directly without posting data
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Guessing Game - Make a Guess</title>
</head>
<body>
  <h1>Guess the Number between <?= $_SESSION['min'] ?> and <?= $_SESSION['max'] ?></h1>
  <form action="result.php" method="post">
    <label for="guess">Your Guess:</label>
    <input type="number" name="guess" required>
    <button type="submit">Submit Guess</button>
  </form>
</body>
</html>
