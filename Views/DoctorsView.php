<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Doctors Management</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="mt-4 mb-4">Doctor Management</h1>
    
    
    <div class="mb-3">
    <?php
        $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        echo '<a href="' . $base_url . '/doctors/add" class="btn btn-primary">Add New Doctor</a>';
        ?>
    </div>
    
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Age</th>
                <th>Nationality</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($doctors as $doctor): ?>
                <tr>
                    <td><?php echo htmlspecialchars($doctor->getID()); ?></td>
                    <td><?php echo htmlspecialchars($doctor->getName()); ?></td>
                    <td><?php echo htmlspecialchars($doctor->getGender()); ?></td>
                    <td><?php echo htmlspecialchars($doctor->getAge()); ?></td>
                    <td><?php echo htmlspecialchars($doctor->getNationality()); ?></td>
                    <td>
                        <a href="doctors/edit/<?php echo $doctor->getID(); ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="doctors/delete/<?php echo $doctor->getID(); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this refugee?');">Delete</a>
                        <a href="doctors/view/<?php echo $doctor->getID(); ?>" class="btn btn-primary btn-sm">View</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
