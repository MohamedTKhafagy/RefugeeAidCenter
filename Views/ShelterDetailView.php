<!-- Views/ShelterDetailView.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Shelter Details</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4"><?= $shelter->getName() ?></h1>
        <div class="card">
            <div class="card-body">
                <p><strong>Address:</strong> <?= $shelter->getAddress() ?></p>
                <p><strong>Supervisor:</strong> <?= $shelter->getSupervisor() ?></p>
                <p><strong>Max Capacity:</strong> <?= $shelter->getMaxCapacity() ?></p>
                <p><strong>Current Capacity:</strong> <?= $shelter->getCurrentCapacity() ?></p>
                <form method="POST" action="index.php" class="mt-3">
                    <input type="hidden" name="action" value="updateCapacity">
                    <input type="hidden" name="ShelterID" value="<?= $shelter->getShelterID() ?>">
                    <div class="form-group">
                        <label for="newCapacity">Update Current Capacity:</label>
                        <input type="number" name="newCapacity" id="newCapacity" class="form-control" min="0" max="<?= $shelter->getMaxCapacity() ?>" value="<?= $shelter->getCurrentCapacity() ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
                <a href="index.php" class="btn btn-secondary mt-3">Back to Shelter List</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>