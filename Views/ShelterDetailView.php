<!-- Views/ShelterDetailView.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Shelter Details</title>
</head>

<body>
    <h1><?= $shelter->getName() ?></h1>
    <p><strong>Address:</strong> <?= $shelter->getAddress() ?></p>
    <p><strong>Supervisor:</strong> <?= $shelter->getSupervisor() ?></p>
    <p><strong>Max Capacity:</strong> <?= $shelter->getMaxCapacity() ?></p>
    <p><strong>Current Capacity:</strong> <?= $shelter->getCurrentCapacity() ?></p>
    <form method="POST" action="index.php">
        <input type="hidden" name="action" value="updateCapacity">
        <input type="hidden" name="ShelterID" value="<?= $shelter->getShelterID() ?>">
        <label for="newCapacity">Update Current Capacity:</label>
        <input type="number" name="newCapacity" id="newCapacity" min="0" max="<?= $shelter->getMaxCapacity() ?>" value="<?= $shelter->getCurrentCapacity() ?>">
        <button type="submit">Update</button>
    </form>
    <a href="index.php">Back to Shelter List</a>
</body>

</html>