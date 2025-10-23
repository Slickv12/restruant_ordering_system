<?php
session_start();
$message = isset($_SESSION['message']) ? $_SESSION['message'] : "No payment details found.";
unset($_SESSION['message']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Confirmation</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="confirmation-container">
        <h2><?= $message; ?></h2>
        <a href="user/user_dashboard.php">Go to Dashboard</a>
    </div>
</body>
</html>
