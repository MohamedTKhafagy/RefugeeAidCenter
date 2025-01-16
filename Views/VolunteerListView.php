<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Refugee Management</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1 class="mt-4 mb-4">Volunteer Management</h1>

        <!-- Add New Volunteer Button -->
        <div class="mb-3">
            <?php
            $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
            echo '<a href="' . $base_url . '/volunteers/add" class="btn btn-primary">Add New Volunteer</a>';
            ?>
        </div>

        <!-- Volunteer Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Volunteer ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Skills</th>
                    <th>Availability</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($volunteers as $volunteer): ?>

                    <tr>
                        <td><?php echo htmlspecialchars($volunteer->getId()); ?></td>
                        <td><?php echo htmlspecialchars($volunteer->getName()); ?></td>
                        <td><?php echo htmlspecialchars($volunteer->getAge()); ?></td>
                        <td><?php echo htmlspecialchars($volunteer->getSkills()); ?></td>
                        <td><?php echo htmlspecialchars($volunteer->getAvailability()); ?></td>
                        <td>
                            <a href="<?php echo $base_url; ?>/volunteers/edit/<?php echo $volunteer->getID(); ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="<?php echo $base_url; ?>/volunteers/delete/<?php echo $volunteer->getID(); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this volunteer?');">Delete</a>
                            <a href="<?php echo $base_url; ?>/volunteers/view/<?php echo $volunteer->getID(); ?>" class="btn btn-primary btn-sm">View</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>