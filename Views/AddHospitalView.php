<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Refugee</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2 class="mt-4 mb-4">Add New Hospital</h2>
    <?php $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'); ?>
    <form action="/hospitals/add" method="POST">
        <!-- Hidden action field -->
        <input type="hidden" name="action" value="save">

        <div class="form-group">
            <label for="PassportNumber">Hospital Name:</label>
            <input type="text" name="Name" id="Name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="Name">Address:</label>
            <input type="text" name="Address" id="NaAddressme" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="Age">Supervisor:</label>
            <input type="text" name="Supervisor" id="Supervisor" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="Gender">Max Capacity:</label>
            <input type="text" name="MaxCapacity" id="MaxCapacity" class="form-control" required>
        </div>

        <div class="form-group">
        <label for="insuranceType">Insurance Type</label>
        <input type="text" name="insuranceType" class="form-control" placeholder="Enter Insurance Type">
        </div>
        
        <button type="submit" class="btn btn-primary">Add Hospital</button>
        <a href="hospitals" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
