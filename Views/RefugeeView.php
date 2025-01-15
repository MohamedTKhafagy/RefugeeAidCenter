<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Refugee Management</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Refugee Management</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
<div class="container">
    <h1 class="mt-4 mb-4">Refugee Management</h1>

    <!-- Add New Refugee Button -->
    <div class="mb-3">
    <?php
        $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        echo '<a href="' . $base_url . '/refugees/add" class="btn btn-primary">Add New Refugee</a>';
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
            <?php foreach ($refugees as $refugee): ?>
                <tr>
                    <td><?php echo htmlspecialchars($refugee->getUserId()); ?></td>
                    <td><?php echo htmlspecialchars($refugee->getName()); ?></td>
                    <td><?php echo htmlspecialchars($refugee->getAge()); ?></td>
                    <td><?php echo $refugee->getGender() == 0 ? "Male" : "Female"; ?></td>
                    <td><?php echo htmlspecialchars($refugee->getNationality()); ?></td>
                    <td>
                        <?php $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'); ?>
                        <a href="<?php echo $base_url ?>/refugees/edit?id=<?php echo $refugee->getRefugeeId(); ?>" class="btn btn-warning btn-sm">Update</a>
                        <a href="delete_refugee.php?id=<?php echo $refugee->getUserId(); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this refugee?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>

</html>
