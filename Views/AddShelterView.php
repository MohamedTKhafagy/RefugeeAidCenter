<?php $base_url = 'http://localhost/RefugeeAidCenter'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Shelter</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1 class="mt-5">Add New Shelter</h1>
        <form action="<?php echo $base_url; ?>/shelters/add" method="POST" class="mt-4">

            <!-- Hidden action field -->
            <input type="hidden" name="action" value="save">

            <div class="form-group">
                <label for="Name">Name:</label>
                <input type="text" id="Name" name="Name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="Address">Address:</label>
                <select name="Address" id="Address" class="form-control" required>
                    <option value="4">Madinet Nasr</option>
                    <option value="5">Masr Al Gadida</option>
                    <option value="6">New Cairo</option>
                    <option value="7">Sheikh Zayed</option>
                    <option value="8">Abbaseya</option>
                </select>
            </div>
            <!-- <?php var_dump($volunteers); ?>
            <div class="form-group">
                <label for="Supervisor">Supervisor:</label>
                <input type="text" id="Supervisor" name="Supervisor" class="form-control" required>
            </div> -->
            <div class="form-group">
                <label for="Supervisor">Supervisor:</label>
                <select name="Supervisor" id="Supervisor" class="form-control" required>
                    <?php foreach ($volunteers as $volunteer): ?>
                        <option value="<?php echo $volunteer->getID(); ?>"><?php echo $volunteer->getName(); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="MaxCapacity">Max Capacity:</label>
                <input type="number" id="MaxCapacity" name="MaxCapacity" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="CurrentCapacity">Current Capacity:</label>
                <input type="number" id="CurrentCapacity" name="CurrentCapacity" class="form-control" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Add Shelter</button>
                <a href="<?php echo $base_url; ?>/shelters" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>