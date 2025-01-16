<!-- views/DonatorView.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Social Worker Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
<div class="container">
    <h1>Social Worker Details</h1>
    <p><strong>ID:</strong> <?= htmlspecialchars($socialWorker->getID()) ?></p>
    <p><strong>Name:</strong> <?= htmlspecialchars($socialWorker->getName()) ?></p>
    <p><strong>Age:</strong> <?= htmlspecialchars($socialWorker->getAge()) ?></p>
    <p><strong>Gender:</strong> <?= htmlspecialchars($socialWorker->getGender()) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($socialWorker->getEmail()) ?></p>
    <p><strong>Type:</strong> <?= htmlspecialchars($socialWorker->getType()) ?></p>
    <p><strong>Nationality:</strong> <?= htmlspecialchars($socialWorker->getNationality()) ?></p>
    <p><strong>Address:</strong> <?= htmlspecialchars($socialWorker->getFullAddress($socialWorker->getAddress())) ?></p>
    <p><strong>Phone:</strong> <?= htmlspecialchars($socialWorker->getPhone()) ?></p>
    <p><strong>Availability:</strong> <?= htmlspecialchars($socialWorker->getAvailability()) ?></p>
    <p><strong>School:</strong> <?= htmlspecialchars($socialWorker->getShelter()) ?></p>
</body>

</html>