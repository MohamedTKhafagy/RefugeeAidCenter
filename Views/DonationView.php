<!-- views/DonationView.php -->
<?php
function renderDonationView($donation, $donator, $Invoice) {
    // Start output buffering
    ob_start();
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Donation Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <h1>Donation Details</h1>
    <p><strong>This donation has an ID of:</strong> <?= htmlspecialchars($donation->getID()) ?></p>
    <p><strong>This donation was made by:</strong> <?= htmlspecialchars($donator->getName()) ?></p>
    <p><strong>Donator Id:</strong> <?= htmlspecialchars($donator->getID()) ?></p>
    <p><strong>Invoice:</strong> <?= htmlspecialchars($Invoice) ?></p>
</body>

</html>

<?php
    // End output buffering and return the content
    return ob_get_clean();
}