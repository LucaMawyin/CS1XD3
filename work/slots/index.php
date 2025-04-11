<?php
// Generate three random numbers between 1 and 7
$slot1 = rand(1, 7);
$slot2 = rand(1, 7);
$slot3 = rand(1, 7);

// Determine result
$result = "";
if ($slot1 === $slot2 && $slot2 === $slot3) {
    $result = "Jackpot! All three match!";
} elseif ($slot1 === $slot2 || $slot1 === $slot3 || $slot2 === $slot3) {
    $result = "You win! Two match!";
} else {
    $result = "Try again!";
}
?>

<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8" name="viewport" content="width=device-width">
    <title>Slot Machine</title>
    <link rel="stylesheet" href="../../css/global.css">
    
</head>

<body>

    <div class="header">

        <div class="page-title">
            <h1>Slot Machine</h1>
        </div>

        <nav class="nav-bar">
            <p>|</p>
            <div><a href="../../index.html">Home</a></div>
            <p>|</p>
            <div><a href="../../about.html">About</a></div>
            <p>|</p>
            <div><a href="../../work.html">Work</a></div>
            <p>|</p>
            <div><a href="../../journal.html">Journal</a></div>
            <p>|</p>
            <div><a href="https://cs1xd3.cas.mcmaster.ca/~dovbenys/team/index.html" target="_blank">Team</a></div>
            <p>|</p>
        </nav>

        <div class="logos">
            <a href="https://github.com/LucaMawyin" target="_blank"><img id="github-img" src="../../images/github-dark.png" alt="GitHub"></a>
            <a href="https://www.linkedin.com/in/lucamawyin/" target="_blank"><img src="../../images/linkedin.png" alt="LinkedIn"></a>
            <a href="mailto:lucamawyin@gmail.com"><img src="../../images/gmail.png" alt="Gmail"></a>
        </div>

    </div>

    <nav id="back">
        <div><a href="../../work.html">&lt Go Back</a></div>
    </nav>

    <div class="dropdown">
        <button class="dropbtn"><img src="../../images/burger.png" alt="Menu"></button>
        <nav class="nav-bar" id="dropdown-menu">
            <div><a href="../../index.html">Home</a></div>
            <div><a href="../../about.html">About</a></div>
            <div><a href="../../work.html">Work</a></div>
            <div><a href="../../journal.html">Journal</a></div>
            <div><a href="https://cs1xd3.cas.mcmaster.ca/~dovbenys/team/index.html" target="_blank">Team</a></div>
        </nav>
    </div>

    <div class="content" style="align-items: center;">
        <div>
            <img src="images/<?php echo $slot1; ?>.png" alt="Slot 1" style="width:30%; height: 100%;">
            <img src="images/<?php echo $slot2; ?>.png" alt="Slot 2" style="width:30%; height: 100%;">
            <img src="images/<?php echo $slot3; ?>.png" alt="Slot 3" style="width:30%; height: 100%;">
        </div>

        <h2><?php echo $result; ?></h2>

        <form method="get">
            <button type="submit">Spin Again</button>
        </form>

    </div>

    <script src="../script.js"></script>

</body>

</html>