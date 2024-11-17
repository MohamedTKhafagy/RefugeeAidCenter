<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add New Volunteer</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2 class="mt-4 mb-4">Add New Volunteer</h2>
        <?php $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'); ?>
        <form action="<?php echo $base_url; ?>/volunteers/add" method="POST">
            <!-- Hidden action field -->
            <input type="hidden" name="action" value="save">

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
                <select name="Gender" id="Gender" class="form-control" required>
                    <option value="0">Male</option>
                    <option value="1">Female</option>
                </select>
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
                <input readonly type="text" name="Type" id="Type" value="Volunteer" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="Email">Email:</label>
                <input type="email" name="Email" id="Email" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="Preference">Preference:</label>
                <select name="Preference" id="Preference" class="form-control" required>
                    <option value="0">Email</option>
                    <option value="1">SMS</option>
                </select>
            </div>

            <!-- <div class="form-group">
                <label for="Skills">Skills:</label>
                <input type="text" name="Skills" id="Skills" class="form-control" required>
            </div> -->
            <!-- <div class="form-group">
                <label for="Availability">Availability:</label>
                <input type="text" name="Availability" id="Availability" class="form-control" required>
            </div> -->
            <div class="form-group">
                <label for="Skills">Skills:</label>
                <select name="Skills" id="Skills" class="form-control" required>
                    <option value="Medical">Medical</option>
                    <option value="Teaching">Teaching</option>
                    <option value="Counseling">Counseling</option>
                    <option value="Translation">Translation</option>
                    <option value="Logistics">Logistics</option>
                    <option value="Fundraising">Fundraising</option>
                </select>
            </div>


            <div class="form-group">
                <label for="Availability">Availability:</label>
                <select name="Availability" id="Availability" class="form-control" required>

                    <option value="Monday">Monday</option>

                    <option value="Tuesday">Tuesday</option>

                    <option value="Wednesday">Wednesday</option>

                    <option value="Thursday">Thursday</option>

                    <option value="Friday">Friday</option>

                    <option value="Saturday">Saturday</option>

                    <option value="Sunday">Sunday</option>

                </select>

            </div>

            <button type="submit" class="btn btn-primary">Add Volunteer</button>
            <a href="<?php echo $base_url; ?>/volunteers" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>