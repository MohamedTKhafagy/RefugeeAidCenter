<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teachers Management</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="mt-4 mb-4">Teachers Management</h1>
    
    
    <div class="mb-3">
    <?php
        $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        echo '<a href="' . $base_url . '/teachers/add" class="btn btn-primary">Add New Teachers</a>';
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
            <?php foreach ($teachers as $teacher): ?>
                <tr>
                    <td><?php echo htmlspecialchars($teacher->getID()); ?></td>
                    <td><?php echo htmlspecialchars($teacher->getName()); ?></td>
                    <td><?php echo htmlspecialchars($teacher->getGender()); ?></td>
                    <td><?php echo htmlspecialchars($teacher->getAge()); ?></td>
                    <td><?php echo htmlspecialchars($teacher->getNationality()); ?></td>
                    <td>
                        <a href="teachers/edit/<?php echo $teacher->getID(); ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="teachers/delete/<?php echo $teacher->getID(); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this refugee?');">Delete</a>
                        <a href="teachers/view/<?php echo $teacher->getID(); ?>" class="btn btn-primary btn-sm">View</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
