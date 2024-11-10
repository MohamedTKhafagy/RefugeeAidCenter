<!-- views/InventoryDetailView.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Inventory Details</title>
</head>

<body>
    <h1>Inventory Details</h1>
    <p><strong>Money:</strong> <?= htmlspecialchars($inventory->getMoney()) ?></p>
    <p><strong>Clothes Quantity:</strong> <?= htmlspecialchars($inventory->getClothesQuantity()) ?></p>
    <p><strong>Food Resources Quantity:</strong> <?= htmlspecialchars($inventory->getFoodResources()) ?></p>
    <a href="index.php">Back to Inventory List</a>
</body>

</html>