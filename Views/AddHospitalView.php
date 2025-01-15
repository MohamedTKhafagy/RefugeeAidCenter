<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Hospital</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2 class="mt-4 mb-4">Add New Hospital</h2>
    <?php $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'); ?>
    <form action="<?php echo $base_url; ?>/hospitals/add" method="POST">
        <div class="form-group">
            <label for="Name">Hospital Name:</label>
            <input type="text" name="Name" id="Name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="Address">Address:</label>
            <input type="text" name="Address" id="Address" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="Supervisor">Supervisor:</label>
            <input type="text" name="Supervisor" id="Supervisor" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="MaxCapacity">Max Capacity:</label>
            <input type="number" name="MaxCapacity" id="MaxCapacity" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="insuranceType">Insurance Type:</label>
            <select name="insuranceType" id="insuranceType" class="form-control" required>
                <option value="Basic">Basic Insurance</option>
                <option value="Comprehensive">Comprehensive Insurance</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Add Hospital</button>
        <a href="<?php echo $base_url; ?>/hospitals" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>