<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check if a status query parameter is set
$status = $_GET['status'] ?? '';

// Display a message based on the status
if ($status === 'success') {
    $message = "Message sent successfully!";
} elseif ($status === 'error') {
    $message = "There was an error sending the message. Please try again.";
} else {
    $message = "No message status available.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 20px;
            text-align: center;
        }
        .message-container {
            margin: 50px auto;
            padding: 20px;
            max-width: 600px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .success {
            color: green;
        }
        .error {
            color: red;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
        }
        a:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="message-container">
        <h1 class="<?= $status === 'success' ? 'success' : 'error' ?>">
            <?= htmlspecialchars($message) ?>
        </h1>
        <a href="/RefugeeAidCenter/communication">Send Another Message</a>
    </div>
</body>
</html>
