<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Nurses Management</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="mt-4 mb-4">Nurse Management</h1>
    
    <!-- Add New Refugee Button -->
    <div class="mb-3">
    <?php
        $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        echo '<a href="' . $base_url . '/nurses/add" class="btn btn-primary">Add New Nurse</a>';
        ?>
    </div>
    
    <!-- Refugee Table -->
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
            <?php foreach ($nurses as $nurse): ?>
                <tr>
                    <td><?php echo htmlspecialchars($nurse->getID()); ?></td>
                    <td><?php echo htmlspecialchars($nurse->getName()); ?></td>
                    <td><?php echo htmlspecialchars($nurse->getGender()); ?></td>
                    <td><?php echo htmlspecialchars($nurse->getAge()); ?></td>
                    <td><?php echo htmlspecialchars($nurse->getNationality()); ?></td>
                    <td>
                        <a href="nurses/edit/<?php echo $nurse->getID(); ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="nurses/delete/<?php echo $nurse->getID(); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this refugee?');">Delete</a>
                        <a href="nurses/view/<?php echo $nurse->getID(); ?>" class="btn btn-primary btn-sm">View</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
