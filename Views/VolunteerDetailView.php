<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Volunteer Details</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Volunteer Details</h1>
        <?php $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'); ?>
        <div class="card">
            <div class="card-body">
                <p><strong>ID:</strong> <?php echo $volunteer->getId(); ?></p>
                <p><strong>Name:</strong> <?php echo $volunteer->getName(); ?></p>
                <p><strong>Age:</strong> <?php echo $volunteer->getAge(); ?></p>
                <p><strong>Gender:</strong> <?php echo $volunteer->getGender() == 0 ? 'Male' : 'Female'; ?></p>
                <p><strong>Address:</strong> <?php echo $volunteer->getFullAddress($volunteer->getAddress()) ?></p>
                <p><strong>Phone:</strong> <?php echo $volunteer->getPhone(); ?></p>
                <p><strong>Nationality:</strong> <?php echo $volunteer->getNationality(); ?></p>
                <p><strong>Email:</strong> <?php echo $volunteer->getEmail(); ?></p>
                <p><strong>Skills:</strong> <?php echo $volunteer->getSkills(); ?></p>
                <p><strong>Availability:</strong> <?php echo $volunteer->getAvailability(); ?></p>
                <a href="<?php echo $base_url; ?>/volunteers" class="btn btn-primary mt-3">Back to List</a>
            </div>
        </div>
    </div>
</body>

</html>