<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Volunteer</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

    <div class="container">
        <h2 class="mt-4 mb-4">Edit Volunteer</h2>
        <?php $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'); ?>
        <form action="<?php echo $base_url; ?>/volunteers/editVolunteer" method="POST">
            <!-- Hidden action field -->
            <input type="hidden" name="action" value="save">

            <div class="form-group">
                <label for="ID">ID:</label>
                <input readonly type="text" name="Id" id="Id" value="<?php echo htmlspecialchars($volunteer->getID()); ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="Name">Name:</label>
                <input type="text" value="<?php echo htmlspecialchars($volunteer->getName()); ?>" name="Name" id="Name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="Age">Age:</label>
                <input type="text" value="<?php echo htmlspecialchars($volunteer->getAge()); ?>" name="Age" id="Age" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="Gender">Gender:</label>
                <input type="text" value="<?php echo htmlspecialchars($volunteer->getGender()); ?>" name="Gender" id="Gender" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="Address">Address:</label>
                <input type="text" value="<?php echo htmlspecialchars($volunteer->getAddress()); ?>" name="Address" id="Address" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="Phone">Phone:</label>
                <input type="text" value="<?php echo htmlspecialchars($volunteer->getPhone()); ?>" name="Phone" id="Phone" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="Nationality">Nationality:</label>
                <input type="text" value="<?php echo htmlspecialchars($volunteer->getNationality()); ?>" name="Nationality" id="Nationality" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="Type">Type:</label>
                <input readonly type="text" value="<?php echo htmlspecialchars($volunteer->getType()); ?>" name="Type" id="Type" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="Email">Email:</label>
                <input type="email" value="<?php echo htmlspecialchars($volunteer->getEmail()); ?>" name="Email" id="Email" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="Preference">Preference:</label>
                <input type="text" value="<?php echo htmlspecialchars($volunteer->getPreference()); ?>" name="Preference" id="Preference" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="Skills">Skill:</label>
                <input type="text" value="<?php echo htmlspecialchars($volunteer->getSkills()); ?>" name="Skills" id="Skills" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="Availability">Availability:</label>
                <select name="Availability" id="Availability" class="form-control" required>
                    <option value="Full-time" <?php echo $volunteer->getAvailability() == 'Full-time' ? 'selected' : ''; ?>>Full-time</option>
                    <option value="Part-time" <?php echo $volunteer->getAvailability() == 'Part-time' ? 'selected' : ''; ?>>Part-time</option>
                    <option value="Weekends" <?php echo $volunteer->getAvailability() == 'Weekends' ? 'selected' : ''; ?>>Weekends</option>
                    <option value="Evenings" <?php echo $volunteer->getAvailability() == 'Evenings' ? 'selected' : ''; ?>>Evenings</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Edit Volunteer</button>
            <a href="<?php echo $base_url; ?>/volunteers" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>