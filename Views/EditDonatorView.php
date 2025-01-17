<?php
function renderEditDonatorView($donator) {
    // Start output buffering
    ob_start();
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Donator</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2 class="mt-4 mb-4">Edit Donator</h2>
    <?php $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'); ?>
    <form action="<?php echo $base_url; ?>/donators/editDonator" method="POST">
        <!-- Hidden action field -->
        <input type="hidden" name="action" value="save">
        
        <div class="form-group">
            <label for="ID">ID:</label>
            <input readonly type="text" name="Id" id="Id" value="<?php echo htmlspecialchars($donator->getID()); ?>" class="form-control" required>
        </div>
        

        <div class="form-group">
            <label for="Name">Name:</label>
            <input type="text" value="<?php echo htmlspecialchars($donator->getName()); ?>" name="Name" id="Name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="Age">Age:</label>
            <input type="text" value="<?php echo htmlspecialchars($donator->getAge()); ?>" name="Age" id="Age" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="Gender">Gender:</label>
            <select name="Gender" id="Gender" class="form-control" required>
                <option value="0">Male</option>
                <option value="1">Female</option>
            </select>
            <script>
            document.getElementById('Gender').value = "<?php echo htmlspecialchars($donator->getGender()); ?>"; // Dynamically set to "Email"
            </script>
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
            <script>
            document.getElementById('Address').value = "<?php echo htmlspecialchars($donator->getAddress()); ?>"; // Dynamically set to "Email"
            </script>
        </div>

        <div class="form-group">
            <label for="Phone">Phone:</label>
            <input type="text" value="<?php echo htmlspecialchars($donator->getPhone()); ?>" name="Phone" id="Phone" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="Nationality">Nationality:</label>
            <input type="text" value="<?php echo htmlspecialchars($donator->getNationality()); ?>" name="Nationality" id="Nationality" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="Type">Type:</label>
            <input readonly type="text" value="Donator" name="Type" id="Type" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="Email">Email:</label>
            <input type="email" value="<?php echo htmlspecialchars($donator->getEmail()); ?>" name="Email" id="Email" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="Preference">Preference:</label>
           <select name="Preference" id="Preference" class="form-control" required>
                <option value="0">Email</option>
                <option value="1">SMS</option>
            </select>
            <script>
            document.getElementById('Preference').value = "<?php echo htmlspecialchars($donator->getPreference()); ?>"; // Dynamically set to "Email"
            </script>
        </div>

        
        <button type="submit" class="btn btn-primary">Edit Donator</button>
        <a href="donators" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
<?php
    // End output buffering and return the content
    return ob_get_clean();
}