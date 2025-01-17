<!-- views/DonatorView.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Doctor Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
<div class="container">
    <h1>Doctor Details</h1>
    <p><strong>ID:</strong> <?= htmlspecialchars($doctor->getID()) ?></p>
    <p><strong>Name:</strong> <?= htmlspecialchars($doctor->getName()) ?></p>
    <p><strong>Age:</strong> <?= htmlspecialchars($doctor->getAge()) ?></p>
    <p><strong>Gender:</strong> <?= htmlspecialchars($doctor->getGender()) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($doctor->getEmail()) ?></p>
    <p><strong>Type:</strong> <?= htmlspecialchars($doctor->getType()) ?></p>
    <p><strong>Nationality:</strong> <?= htmlspecialchars($doctor->getNationality()) ?></p>
    <p><strong>Address:</strong> <?= htmlspecialchars($doctor->getFullAddress($doctor->getAddress())) ?></p>
    <p><strong>Phone:</strong> <?= htmlspecialchars($doctor->getPhone()) ?></p>
    <p><strong>Specialization:</strong> <?= htmlspecialchars($doctor->getSpecialization()) ?></p>
    <p><strong>Availability:</strong> <?= htmlspecialchars($doctor->getAvailability()) ?></p>
    <p><strong>Hospital:</strong> <?= htmlspecialchars($doctor->getHospital()) ?></p>
</body>

</html>