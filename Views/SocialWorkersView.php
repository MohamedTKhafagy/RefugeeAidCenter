<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>social Workers Management</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="mt-4 mb-4">Social Workers Management</h1>
    
    <!-- Add New Refugee Button -->
    <div class="mb-3">
    <?php
        $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        echo '<a href="' . $base_url . '/socialWorkers/add" class="btn btn-primary">Add New Social Worker</a>';
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
            <?php foreach ($socialWorkers as $socialWorker): ?>
                <tr>
                    <td><?php echo htmlspecialchars($socialWorker->getID()); ?></td>
                    <td><?php echo htmlspecialchars($socialWorker->getName()); ?></td>
                    <td><?php echo htmlspecialchars($socialWorker->getGender()); ?></td>
                    <td><?php echo htmlspecialchars($socialWorker->getAge()); ?></td>
                    <td><?php echo htmlspecialchars($socialWorker->getNationality()); ?></td>
                    <td>
                        <a href="socialWorkers/edit/<?php echo $socialWorker->getID(); ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="socialWorkers/delete/<?php echo $socialWorker->getID(); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this Social Worker?');">Delete</a>
                        <a href="socialWorkers/view/<?php echo $socialWorker->getID(); ?>" class="btn btn-primary btn-sm">View</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
