<!-- views/InventoryListView.php -->
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
            <th>Inventory ID</th>
            <th>Money</th>
            <th>Clothes Quantity</th>
            <th>Food Resources Quantity</th>
            <th>Details</th>
        </tr>
        <?php foreach ($inventoryItems as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['InventoryID']) ?></td>
                <td><?= htmlspecialchars($item['Money']) ?></td>
                <td><?= htmlspecialchars($item['ClothesQuantity']) ?></td>
                <td><?= htmlspecialchars($item['FoodResourcesQuantity']) ?></td>
                <td><a href="index.php?action=show&inventoryID=<?= urlencode($item['InventoryID']) ?>">View Details</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>