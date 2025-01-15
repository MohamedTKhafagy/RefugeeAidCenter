<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add New Refugee</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2 class="mt-4 mb-4">Add New Refugee</h2>
        <?php $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'); ?>
        <form action="<?php echo $base_url; ?>/refugees/add" method="POST">
            <!-- Hidden action field -->
            <input type="hidden" name="action" value="save">

            <div class="form-group">
                <label for="RefugeeID">Refugee ID:</label>
                <input type="text" name="Id" id="Id" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="PassportNumber">Passport Number:</label>
                <input type="text" name="PassportNumber" id="PassportNumber" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="Name">Name:</label>
                <input type="text" name="Name" id="Name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="Age">Age:</label>
                <input type="text" name="Age" id="Age" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="Gender">Gender:</label>
                <input type="text" name="Gender" id="Gender" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="Address">Address:</label>
                <input type="text" name="Address" id="Address" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="Phone">Phone:</label>
                <input type="text" name="Phone" id="Phone" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="Nationality">Nationality:</label>
                <input type="text" name="Nationality" id="Nationality" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="Type">Type:</label>
                <input type="text" name="Type" id="Type" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="Email">Email:</label>
                <input type="email" name="Email" id="Email" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="Preference">Preference:</label>
                <input type="text" name="Preference" id="Preference" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="Advisor">Advisor:</label>
                <input type="text" name="Advisor" id="Advisor" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="Shelter">Shelter:</label>
                <input type="text" name="Shelter" id="Shelter" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="HealthCare">HealthCare:</label>
                <input type="text" name="HealthCare" id="HealthCare" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Refugee</button>
            <a href="refugees" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>