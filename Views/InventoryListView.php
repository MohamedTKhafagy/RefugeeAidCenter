
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Inventory List</title>
</head>

<body>
    <h1>Inventory List</h1>
    <table border="1">
        <tr>
            <th>Money</th>
            <th>Clothes Quantity</th>
            <th>Food Resources Quantity</th>
            <th>Details</th>
        </tr>
        <?php foreach ($inventoryItems as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['Money']) ?></td>
                <td><?= htmlspecialchars($item['ClothesQuantity']) ?></td>
                <td><?= htmlspecialchars($item['FoodResourcesQuantity']) ?></td>
                <td><?php $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'); ?>
                    <a href="<?php echo $base_url; ?>/inventory/inventorydetails">View Details</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>