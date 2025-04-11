<?php
session_start();

// Reset session if restart is requested
if (isset($_GET['restart'])) {
    session_unset();
    session_destroy();
    header("Location: index.php"); // Redirect to start fresh
    exit;
}

// Initialize credits if not set
if (!isset($_SESSION['credits'])) {
    $_SESSION['credits'] = 10;
}

// Handle AJAX request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['credits']) || $_SESSION['credits'] <= 0) {
        echo json_encode(['error' => 'No active session or out of credits.']);
        exit;
    }

    if (!isset($_POST['bet']) || $_POST['bet'] < 1 || $_POST['bet'] > $_SESSION['credits']) {
        echo json_encode(['error' => 'Invalid bet amount.']);
        exit;
    }

    $bet = intval($_POST['bet']);
    $_SESSION['credits'] -= $bet;

    $slot1 = rand(1, 7);
    $slot2 = rand(1, 7);
    $slot3 = rand(1, 7);

    $result = "";
    $payout = 0;
    if ($slot1 === $slot2 && $slot2 === $slot3) {
        $result = "Jackpot! All three match!";
        $payout = $bet * 10;
    } elseif ($slot1 === $slot2 || $slot1 === $slot3 || $slot2 === $slot3) {
        $result = "You win! Two match!";
        $payout = $bet * 2;
    } else {
        $result = "Try again!";
    }

    $_SESSION['credits'] += $payout;

    if ($_SESSION['credits'] <= 0) {
        session_unset();
        session_destroy();
        echo json_encode([
            'slot1' => $slot1,
            'slot2' => $slot2,
            'slot3' => $slot3,
            'result' => $result . " You're out of credits!",
            'credits' => 0,
            'payout' => $payout,
            'gameOver' => true
        ]);
        exit;
    }

    echo json_encode([
        'slot1' => $slot1,
        'slot2' => $slot2,
        'slot3' => $slot3,
        'result' => $result,
        'credits' => $_SESSION['credits'],
        'payout' => $payout
    ]);
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" name="viewport" content="width=device-width">
    <title>Slot Machine</title>
    <link rel="stylesheet" href="../../css/global.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
          <img id="slot1" src="images/1.png" alt="Slot 1" style="width:30%; height: 100%;">
          <img id="slot2" src="images/1.png" alt="Slot 2" style="width:30%; height: 100%;">
          <img id="slot3" src="images/1.png" alt="Slot 3" style="width:30%; height: 100%;">
      </div>

      <h2 id="result">Credits: <?php echo isset($_SESSION['credits']) ? $_SESSION['credits'] : 0; ?></h2>

      <form id="bet-form">
          <label for="bet">Enter your bet:</label>
          <input type="number" id="bet" name="bet" min="1" required>
          <button type="submit">Spin</button>
      </form>

      <button id="restart-button" style="display:none; margin-top: 1rem;" onclick="location.href='?restart=true'">Restart Game</button>
  </div>

  <script>
  $(document).ready(function () {
      $('#bet-form').submit(function (event) {
          event.preventDefault();

          var bet = $('#bet').val();

          $.ajax({
              url: '',
              method: 'POST',
              data: { bet: bet },
              dataType: 'json',
              success: function (response) {
                  if (response.error) {
                      alert(response.error);
                  } else {
                      $('#slot1').attr('src', 'images/' + response.slot1 + '.png');
                      $('#slot2').attr('src', 'images/' + response.slot2 + '.png');
                      $('#slot3').attr('src', 'images/' + response.slot3 + '.png');

                      $('#result').text(response.result + ' Credits: ' + response.credits);
                      $('#bet').val('');

                      if (response.gameOver) {
                          $('#bet').prop('disabled', true);
                          $('button[type="submit"]').prop('disabled', true);
                          $('#restart-button').show();
                      }
                  }
              },
              error: function () {
                  alert('Error processing your request.');
              }
          });
      });
  });
  </script>

  <script src="../script.js"></script>

</body>
</html>
