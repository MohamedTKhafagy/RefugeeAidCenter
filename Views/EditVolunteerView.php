<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Volunteer</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .btn-toolbar {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .skill-entry {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .form-group label {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="mt-4 mb-4">Edit Volunteer</h2>
        <?php $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'); ?>
        <?php
        if (isset($errors) && !empty($errors)) {
            echo "<ul>";
            foreach ($errors as $error) {
                echo "<li style='color:red'>$error</li>";
            }
            echo "</ul>";
        }
        ?>
        <form action="<?php echo $base_url; ?>/volunteers/editVolunteer" method="POST" class="mb-4">
            <!-- Hidden action field -->
            <input type="hidden" name="action" value="save">

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="ID">ID:</label>
                        <input readonly type="text" name="Id" id="Id" value="<?php echo htmlspecialchars($volunteer->getID()); ?>" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="Name">Name:</label>
                        <input type="text" value="<?php echo htmlspecialchars($volunteer->getName()); ?>" name="name" id="Name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="Age">Age:</label>
                        <input type="number" value="<?php echo htmlspecialchars($volunteer->getAge()); ?>" name="age" id="Age" class="form-control" required min="18" max="100">
                    </div>

                    <div class="form-group">
                        <label for="Gender">Gender:</label>
                        <select name="gender" id="Gender" class="form-control" required>
                            <option value="0">Male</option>
                            <option value="1">Female</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="Address">Address:</label>
                        <select name="address" id="Address" class="form-control" required>
                            <option value="4">Madinet Nasr</option>
                            <option value="5">Masr Al Gadida</option>
                            <option value="6">New Cairo</option>
                            <option value="7">Sheikh Zayed</option>
                            <option value="8">Abbaseya</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="Phone">Phone:</label>
                        <input type="tel" value="<?php echo htmlspecialchars($volunteer->getPhone()); ?>" name="phone" id="Phone" class="form-control" required pattern="[0-9]{10}">
                    </div>

                    <div class="form-group">
                        <label for="Nationality">Nationality:</label>
                        <input type="text" value="<?php echo htmlspecialchars($volunteer->getNationality()); ?>" name="nationality" id="Nationality" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="Type">Type:</label>
                        <input readonly type="text" value="Volunteer" name="type" id="Type" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="Email">Email:</label>
                        <input type="email" value="<?php echo htmlspecialchars($volunteer->getEmail()); ?>" name="Email" id="Email" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="preference">Contact Preference:</label>
                        <select name="preference" id="Preference" class="form-control" required>
                            <option value="0">Email</option>
                            <option value="1">SMS</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Skills:</label>
                <div id="skillsContainer">
                    <?php
                    $skills = $volunteer->getSkills();
                    if (empty($skills)) {
                    ?>
                        <div class="skill-entry">
                            <div class="row">
                                <div class="col-md-10">
                                    <label class="small">Skill:</label>
                                    <select name="skills[]" class="form-control" required>
                                        <option value="">Select a skill</option>
                                        <option value="Medical">Medical</option>
                                        <option value="Teaching">Teaching</option>
                                        <option value="Counseling">Counseling</option>
                                        <option value="Translation">Translation</option>
                                        <option value="Logistics">Logistics</option>
                                        <option value="Fundraising">Fundraising</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="small">&nbsp;</label>
                                    <button type="button" class="btn btn-danger btn-block remove-skill">Remove</button>
                                </div>
                            </div>
                        </div>
                        <?php
                    } else {
                        foreach ($skills as $skill) {
                        ?>
                            <div class="skill-entry">
                                <div class="row">
                                    <div class="col-md-10">
                                        <label class="small">Skill:</label>
                                        <select name="skills[]" class="form-control" required>
                                            <option value="">Select a skill</option>
                                            <option value="Medical" <?= $skill['name'] == 'Medical' ? 'selected' : ''; ?>>Medical</option>
                                            <option value="Teaching" <?= $skill['name'] == 'Teaching' ? 'selected' : ''; ?>>Teaching</option>
                                            <option value="Counseling" <?= $skill['name'] == 'Counseling' ? 'selected' : ''; ?>>Counseling</option>
                                            <option value="Translation" <?= $skill['name'] == 'Translation' ? 'selected' : ''; ?>>Translation</option>
                                            <option value="Logistics" <?= $skill['name'] == 'Logistics' ? 'selected' : ''; ?>>Logistics</option>
                                            <option value="Fundraising" <?= $skill['name'] == 'Fundraising' ? 'selected' : ''; ?>>Fundraising</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="small">&nbsp;</label>
                                        <button type="button" class="btn btn-danger btn-block remove-skill">Remove</button>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
                <button type="button" class="btn btn-secondary mt-2" id="addSkill">Add Another Skill</button>
            </div>

            <div class="form-group">
                <label>Availability:</label>
                <?php
                $availableDays = explode(', ', $volunteer->getAvailability());
                $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                foreach ($days as $day):
                ?>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox"
                            class="custom-control-input"
                            id="<?= strtolower($day) ?>"
                            name="Availability[]"
                            value="<?= $day ?>"
                            <?= in_array($day, $availableDays) ? 'checked' : '' ?>>
                        <label class="custom-control-label" for="<?= strtolower($day) ?>"><?= $day ?></label>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="btn-toolbar">
                <button type="submit" class="btn btn-primary mr-2">Save Changes</button>
                <a href="<?php echo $base_url; ?>/volunteers" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

    <script>
        // Set initial values from PHP
        document.getElementById('Gender').value = "<?php echo htmlspecialchars($volunteer->getGender()); ?>";
        document.getElementById('Address').value = "<?php echo htmlspecialchars($volunteer->getAddress()); ?>";
        document.getElementById('Preference').value = "<?php echo htmlspecialchars($volunteer->getPreference()); ?>";
        // document.getElementById('Availability').value = "<?php echo htmlspecialchars($volunteer->getAvailability()); ?>";

        document.getElementById('addSkill').addEventListener('click', function() {
            const container = document.getElementById('skillsContainer');
            const skillEntries = container.querySelectorAll('.skill-entry');
            const newSkill = skillEntries[0].cloneNode(true);

            // Clear selections in the new element
            newSkill.querySelectorAll('select').forEach(select => select.selectedIndex = 0);

            // Add remove button functionality
            newSkill.querySelector('.remove-skill').addEventListener('click', function() {
                this.closest('.skill-entry').remove();
            });

            container.appendChild(newSkill);
        });

        // Add remove functionality to all existing skill entries
        document.querySelectorAll('.remove-skill').forEach(button => {
            button.addEventListener('click', function() {
                if (document.querySelectorAll('.skill-entry').length > 1) {
                    this.closest('.skill-entry').remove();
                }
            });
        });
    </script>
</body>

</html>