<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Refugee Information</title>
</head>

<body>
    <h2>Add Refugee</h2>
    <form action="index.php" method="post">
        <input type="hidden" name="action" value="save">
        <label for="RefugeeID">Refugee ID:</label>
        <input type="text" name="RefugeeID" required><br>
        <label for="PassportNumber">Passport Number:</label>
        <input type="text" name="PassportNumber" required><br>
        <label for="Name">Name:</label>
        <input type="text" name="Name" required><br>
        <label for="Age">Age:</label>
        <input type="text" name="Age" required><br>
        <label for="Gender">Gender:</label>
        <input type="text" name="Gender" required><br>
        <label for="Address">Address:</label>
        <input type="text" name="Address" required><br>
        <label for="Phone">Phone:</label>
        <input type="text" name="Phone" required><br>
        <label for="Nationality">Nationality:</label>
        <input type="text" name="Nationality" required><br>
        <label for="Type">Type:</label>
        <input type="text" name="Type" required><br>
        <label for="Email">Email:</label>
        <input type="text" name="Email" required><br>
        <label for="Preference">Preference:</label>
        <input type="text" name="Preference" required><br>
        <label for="Advisor">Advisor:</label>
        <input type="text" name="Advisor" required><br>
        <label for="Shelter">Shelter:</label>
        <input type="text" name="Shelter" required><br>
        <label for="HealthCare">HealthCare:</label>
        <input type="text" name="HealthCare" required><br>
        <button type="submit">Save Refugee</button>
    </form>

    <h2>Find Refugee</h2>
    <form action="index.php" method="get">
        <input type="hidden" name="action" value="find">
        <label for="id">Refugee ID:</label>
        <input type="text" name="id" required>
        <button type="submit">Find</button>
    </form>

    <?php if (isset($refugee)) { ?>
        <h3>Refugee Details:</h3>
        <p>Name: <?php echo $refugee->Name; ?></p>
        <p>Age: <?php echo $refugee->Age; ?></p>
        <!-- Add more fields as needed -->
    <?php } ?>
</body>

</html>