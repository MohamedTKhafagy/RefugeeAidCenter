<!-- views/DonationView.php -->
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
    <div class="mb-3">
    <?php
        $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        echo '<a href="' . $base_url . '/donations" class="btn btn-primary">Go to Donations List</a>';
    ?>
    </div>
</body>

</html>