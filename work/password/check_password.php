<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';

    $errors = [];

    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }
    if (!preg_match('/[A-Z]/', $password)) {
        $errors[] = "Include at least one uppercase letter.";
    }
    if (!preg_match('/[a-z]/', $password)) {
        $errors[] = "Include at least one lowercase letter.";
    }
    if (!preg_match('/\d/', $password)) {
        $errors[] = "Include at least one digit.";
    }
    if (!preg_match('/[^a-zA-Z\d]/', $password)) {
        $errors[] = "Include at least one symbol.";
    }

    if (empty($errors)) {
        echo "OK";
    } else {
        echo implode("\n", $errors);
    }
}
?>
