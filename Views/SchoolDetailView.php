<!-- views/SchoolDetailView.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>School Details</title>
</head>

<body>
    <h1>School Details</h1>
    <p><strong>School ID:</strong> <?= htmlspecialchars($school->getSchoolID()) ?></p>
    <p><strong>Name:</strong> <?= htmlspecialchars($school->getName()) ?></p>
    <p><strong>Address:</strong> <?= htmlspecialchars($school->getAddress()) ?></p>
    <p><strong>Available Beds:</strong> <?= htmlspecialchars($school->getAvailableBeds()) ?></p>
    <a href="index.php">Back to School List</a>
</body>

</html>