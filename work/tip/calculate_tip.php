<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Tip Summary</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php
            function is_valid_credit_card($cc) {
                return preg_match('/^\d{16}$/', $cc);
            }

            if (
                isset($_POST['server'], $_POST['email'], $_POST['confirm_email'], $_POST['amount'], $_POST['tip'], $_POST['cc']) &&
                !empty($_POST['server']) &&
                !empty($_POST['email']) &&
                !empty($_POST['confirm_email']) &&
                !empty($_POST['amount']) &&
                !empty($_POST['tip']) &&
                !empty($_POST['cc'])
            ) {
                $server = htmlspecialchars(trim($_POST['server']));
                $email = trim($_POST['email']);
                $confirm_email = trim($_POST['confirm_email']);
                $amount = floatval($_POST['amount']);
                $tip_percent = intval($_POST['tip']);
                $cc = preg_replace('/\s+/', '', $_POST['cc']);

                if ($email !== $confirm_email) {
                    echo "<h3>Error: Emails do not match.</h3>";
                    exit;
                }

                if ($amount < 0 || $tip_percent < 0) {
                    echo "<h3>Error: Amount and Tip must be non-negative.</h3>";
                    exit;
                }

                if (!is_valid_credit_card($cc)) {
                    echo "<h3>Error: Credit card number must be exactly 16 digits.</h3>";
                    exit;
                }

                $tip_amount = $amount * ($tip_percent / 100);
                $total = $amount + $tip_amount;

                echo "<h2>Bill Summary</h2>";
                echo "<p><strong>Server:</strong> $server</p>";
                echo "<p><strong>Customer Email:</strong> $email</p>";
                echo "<p><strong>Original Amount:</strong> $" . number_format($amount, 2) . "</p>";
                echo "<p><strong>Tip ({$tip_percent}%):</strong> $" . number_format($tip_amount, 2) . "</p>";
                echo "<p><strong>Total Amount:</strong> $" . number_format($total, 2) . "</p>";
            } else {
                echo "<h3>Error: Missing or incomplete form data.</h3>";
            }
        ?>
    </div>
</body>
</html>