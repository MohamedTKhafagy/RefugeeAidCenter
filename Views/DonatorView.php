<!-- views/DonatorView.php -->
<?php
function renderDonatorView($donator) {
    // Start output buffering
    ob_start();
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Donator Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
<div class="container">
    <h1>Donator Details</h1>
    <p><strong>ID:</strong> <?= htmlspecialchars($donator->getID()) ?></p>
    <p><strong>Name:</strong> <?= htmlspecialchars($donator->getName()) ?></p>
    <p><strong>Age:</strong> <?= htmlspecialchars($donator->getAge()) ?></p>
    <p><strong>Gender:</strong> <?= htmlspecialchars($donator->getGender()) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($donator->getEmail()) ?></p>
    <p><strong>Type:</strong> <?= htmlspecialchars($donator->getType()) ?></p>
    <p><strong>Nationality:</strong> <?= htmlspecialchars($donator->getNationality()) ?></p>
    <p><strong>Address:</strong> <?= htmlspecialchars($donator->getFullAddress($donator->getAddress())) ?></p>
    <p><strong>Phone:</strong> <?= htmlspecialchars($donator->getPhone()) ?></p>
    <div class="mb-3">
    <?php
        $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        echo '<a href="' . $base_url . '/donations/makeDonation/' . $donator->getID() . '" class="btn btn-primary">Make a Donation</a>';
        ?>
    </div>
    <div class="mb-3">
    <?php
        $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        echo '<a href="' . $base_url . '/donators/viewDonations/' . $donator->getID() . '" class="btn btn-primary">View Your Donations</a>';
        ?>
    </div>
</div>
</body>

</html>
<?php
    // End output buffering and return the content
    return ob_get_clean();
}