<!-- Views/ShelterListView.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Shelter List</title>
</head>

<body>
    <h1>Shelters</h1>
    <table border="1">
        <tr>
            <th>Shelter ID</th>
            <th>Name</th>
            <th>Address</th>
            <th>Supervisor</th>
            <th>Max Capacity</th>
            <th>Current Capacity</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($shelters as $shelter) : ?>
            <tr>
                <td><?= $shelter['ShelterID'] ?></td>
                <td><?= $shelter['Name'] ?></td>
                <td><?= $shelter['Address'] ?></td>
                <td><?= $shelter['Supervisor'] ?></td>
                <td><?= $shelter['MaxCapacity'] ?></td>
                <td><?= $shelter['CurrentCapacity'] ?></td>
                <td><?php $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'); ?>
                    <a href="<?php echo $base_url; ?>/shelters/shelterDetails?ShelterID=<?= $shelter['ShelterID'] ?>">View</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>