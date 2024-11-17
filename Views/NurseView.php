<!-- views/DonatorView.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Nurse Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
<div class="container">
    <h1>Nurse Details</h1>
    <p><strong>ID:</strong> <?= htmlspecialchars($nurse->getID()) ?></p>
    <p><strong>Name:</strong> <?= htmlspecialchars($nurse->getName()) ?></p>
    <p><strong>Age:</strong> <?= htmlspecialchars($nurse->getAge()) ?></p>
    <p><strong>Gender:</strong> <?= htmlspecialchars($nurse->getGender()) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($nurse->getEmail()) ?></p>
    <p><strong>Type:</strong> <?= htmlspecialchars($nurse->getType()) ?></p>
    <p><strong>Nationality:</strong> <?= htmlspecialchars($nurse->getNationality()) ?></p>
    <p><strong>Address:</strong> <?= htmlspecialchars($nurse->getFullAddress($nurse->getAddress())) ?></p>
    <p><strong>Phone:</strong> <?= htmlspecialchars($nurse->getPhone()) ?></p>
    <p><strong>Specialization:</strong> <?= htmlspecialchars($nurse->getSpecialization()) ?></p>
    <p><strong>Availability:</strong> <?= htmlspecialchars($nurse->getAvailability()) ?></p>
    <p><strong>Hospital:</strong> <?= htmlspecialchars($nurse->getHospital()) ?></p>
</body>

</html>