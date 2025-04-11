<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mawyinl_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;port=3307", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit;
}

// Fetch all polls
try {
    $polls_stmt = $conn->prepare("SELECT ID, title FROM poll");
    $polls_stmt->execute();
    $polls = $polls_stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching polls: " . $e->getMessage();
    exit;
}

// Handle vote submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['poll_id']) && isset($_POST['option'])) {
    $poll_id = (int)$_POST['poll_id'];
    $option = (int)$_POST['option'];

    if ($poll_id <= 0 || $option < 1 || $option > 4) {
        echo "Error: Invalid poll ID or option.";
        exit;
    }

    try {
        $stmt = $conn->prepare("SELECT * FROM poll WHERE ID = :poll_id");
        $stmt->bindParam(':poll_id', $poll_id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            echo "Error: Poll ID not found.";
            exit;
        }

        $update_stmt = $conn->prepare("UPDATE poll SET vote$option = vote$option + 1 WHERE ID = :poll_id");
        $update_stmt->bindParam(':poll_id', $poll_id, PDO::PARAM_INT);
        $update_stmt->execute();

        echo "Your vote has been recorded successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Poll Voting</title>
</head>
<body>
    <h1>Vote in the Poll</h1>
    <form action="" method="POST">
        <label for="poll_id">Select Poll:</label>
        <select id="poll_id" name="poll_id" required>
            <option value="" disabled selected>Select a Poll</option>
            <?php foreach ($polls as $poll): ?>
                <option value="<?= $poll['ID'] ?>"><?= htmlspecialchars($poll['title']) ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <div id="option-container">

        </div>

        <input type="submit" value="Submit Vote">
    </form>

    <script>
        document.getElementById("poll_id").addEventListener("change", function () {
            const pollId = this.value;
            const container = document.getElementById("option-container");

            if (!pollId) return;

            fetch(`get_poll_options.php?poll_id=${pollId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        container.innerHTML = `<p>Error: ${data.error}</p>`;
                        return;
                    }

                    let html = `<label for="option">Vote for Option:</label>
                                <select id="option" name="option" required>`;
                    for (const [key, value] of Object.entries(data)) {
                        if (value) {
                            html += `<option value="${key.slice(-1)}">${value}</option>`;
                        }
                    }
                    html += `</select><br><br>`;
                    container.innerHTML = html;
                })
                .catch(err => {
                    container.innerHTML = "<p>Error loading options.</p>";
                    console.error(err);
                });
        });
    </script>
</body>
</html>
