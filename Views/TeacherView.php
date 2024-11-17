<!-- views/DonatorView.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Teacher Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
<div class="container">
    <h1>Teacher Details</h1>
    <p><strong>ID:</strong> <?= htmlspecialchars($teacher->getID()) ?></p>
    <p><strong>Name:</strong> <?= htmlspecialchars($teacher->getName()) ?></p>
    <p><strong>Age:</strong> <?= htmlspecialchars($teacher->getAge()) ?></p>
    <p><strong>Gender:</strong> <?= htmlspecialchars($teacher->getGender()) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($teacher->getEmail()) ?></p>
    <p><strong>Type:</strong> <?= htmlspecialchars($teacher->getType()) ?></p>
    <p><strong>Nationality:</strong> <?= htmlspecialchars($teacher->getNationality()) ?></p>
    <p><strong>Address:</strong> <?= htmlspecialchars($teacher->getFullAddress($teacher->getAddress())) ?></p>
    <p><strong>Phone:</strong> <?= htmlspecialchars($teacher->getPhone()) ?></p>
    <p><strong>Subject:</strong> <?= htmlspecialchars($teacher->getSubject()) ?></p>
    <p><strong>Availability:</strong> <?= htmlspecialchars($teacher->getAvailability()) ?></p>
    <p><strong>School:</strong> <?= htmlspecialchars($teacher->getSchool()) ?></p>
</body>

</html>