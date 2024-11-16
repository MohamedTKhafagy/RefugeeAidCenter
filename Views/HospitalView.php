<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Refugee Management</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="mt-4 mb-4">Hospitals Management</h1>
    
    <!-- Add New Refugee Button -->
    <div class="mb-3">
    <?php
        $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        echo '<a href="' . $base_url . '/hospitals/add" class="btn btn-primary">Add New Hospital</a>';
        ?>
    </div>
    
    <!-- Refugee Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Supervisor</th>
                <th>Address</th>
                <th>Capacity</th>
                <th>Max Capacity</th>
                <th>Insurance Type</th> <!-- New Column -->
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($hospitals as $hospital): ?>
                <tr>
                    <td><?php echo htmlspecialchars($hospital->getName()); ?></td>
                    <td><?php echo htmlspecialchars($hospital->getSupervisor()); ?></td>
                    <td><?php echo htmlspecialchars($hospital->getAddress()); ?></td>
                    <td><?php echo htmlspecialchars($hospital->getCurrentCapacity()); ?></td>
                    <td><?php echo htmlspecialchars($hospital->getMaxCapacity()); ?></td>
                    <td><?php echo htmlspecialchars($hospital->getInsuranceType() ?? 'Not Specified'); ?></td>
                    <td>
                      <?php 
                         $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
                        ?>
                        <a href="<?php echo $base_url . '/hospitals/update?id=' . $hospital->getID(); ?>" 
                        class="btn btn-warning btn-sm">Update</a>
                        <a href="<?php echo $base_url . '/hospitals/delete?id=' . $hospital->getID(); ?>" 
                        class="btn btn-danger btn-sm" 
                        onclick="return confirm('Are you sure you want to delete this hospital?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
