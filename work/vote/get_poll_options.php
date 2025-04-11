<?php
if (!isset($_GET['poll_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Missing poll_id']);
    exit;
}

$poll_id = (int)$_GET['poll_id'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mawyinl_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;port=3307", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare("SELECT option1, option2, option3, option4 FROM poll WHERE ID = :poll_id");
    $stmt->bindParam(':poll_id', $poll_id, PDO::PARAM_INT);
    $stmt->execute();

    $options = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$options) {
        echo json_encode(['error' => 'Poll not found']);
    } else {
        echo json_encode($options);
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
