<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Volunteer Details</title>
</head>

<body>
    <h1>Volunteer Details</h1>
    <p><strong>ID:</strong> <?php echo $volunteer->getId(); ?></p>
    <p><strong>Name:</strong> <?php echo $volunteer->getName(); ?></p>
    <p><strong>Age:</strong> <?php echo $volunteer->getAge(); ?></p>
    <p><strong>Gender:</strong> <?php echo $volunteer->getGender(); ?></p>
    <p><strong>Address:</strong> <?php echo $volunteer->getAddress(); ?></p>
    <p><strong>Phone:</strong> <?php echo $volunteer->getPhone(); ?></p>
    <p><strong>Nationality:</strong> <?php echo $volunteer->getNationality(); ?></p>
    <p><strong>Email:</strong> <?php echo $volunteer->getEmail(); ?></p>
    <p><strong>Skills:</strong> <?php echo $volunteer->getSkills(); ?></p>
    <p><strong>Availability:</strong> <?php echo $volunteer->getAvailability(); ?></p>
    <a href="volunteers">Back to List</a>
</body>

</html>