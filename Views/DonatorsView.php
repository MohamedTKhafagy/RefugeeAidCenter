<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Donators Management</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="mt-4 mb-4">Donator Management</h1>
    
    <!-- Add New Refugee Button -->
    <div class="mb-3">
    <?php
        $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        echo '<a href="' . $base_url . '/donators/add" class="btn btn-primary">Add New Donator</a>';
        ?>
    </div>
    
    <!-- Refugee Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Nationality</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($donators as $donator): ?>
                <tr>
                    <td><?php echo htmlspecialchars($donator->getID()); ?></td>
                    <td><?php echo htmlspecialchars($donator->getName()); ?></td>
                    <td><?php echo htmlspecialchars($donator->getGender()); ?></td>
                    <td><?php echo htmlspecialchars($donator->getAge()); ?></td>
                    <td><?php echo htmlspecialchars($donator->getNationality()); ?></td>
                    <td>
                        <a href="donators/edit/<?php echo $donator->getID(); ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="donators/delete/<?php echo $donator->getID(); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this refugee?');">Delete</a>
                        <a href="donators/view/<?php echo $donator->getID(); ?>" class="btn btn-primary btn-sm">View</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
