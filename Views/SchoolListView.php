<!-- views/SchoolListView.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>School List</title>
</head>

<body>
    <h1>School List</h1>
    <table border="1">
        <tr>
            <th>School ID</th>
            <th>Name</th>
            <th>Address</th>
            <th>Available Beds</th>
            <th>Details</th>
        </tr>
        <?php foreach ($schools as $school): ?>
            <tr>
                <td><?= htmlspecialchars($school['SchoolID']) ?></td>
                <td><?= htmlspecialchars($school['Name']) ?></td>
                <td><?= htmlspecialchars($school['Address']) ?></td>
                <td><?= htmlspecialchars($school['AvailableBeds']) ?></td>

                <td><?php $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'); ?>
                    <a href="<?php echo $base_url; ?>/schools/schoolDetails?SchoolID=<?= $school['SchoolID'] ?>">View</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>