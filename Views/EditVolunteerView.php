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
                <select name="Gender" id="Gender" class="form-control" required>
                    <option value="0">Male</option>
                    <option value="1">Female</option>
                </select>
                <script>
                    document.getElementById('Gender').value = "<?php echo htmlspecialchars($volunteer->getGender()); ?>";
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
                    document.getElementById('Address').value = "<?php echo htmlspecialchars($volunteer->getAddress()); ?>";
                </script>
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
                <input readonly type="text" value="Volunteer" name="Type" id="Type" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="Email">Email:</label>
                <input type="email" value="<?php echo htmlspecialchars($volunteer->getEmail()); ?>" name="Email" id="Email" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="Preference">Preference:</label>
                <select name="Preference" id="Preference" class="form-control" required>
                    <option value="0">Email</option>
                    <option value="1">SMS</option>
                </select>
                <script>
                    document.getElementById('Preference').value = "<?php echo htmlspecialchars($volunteer->getPreference()); ?>";
                </script>
            </div>

            <!-- <div class="form-group">
                <label for="Skills">Skills:</label>
                <input type="text" name="Skills" id="Skills" value="<?php echo htmlspecialchars($volunteer->getSkills()); ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="Availability">Availability:</label>
                <input type="text" name="Availability" id="Availability" value="<?php echo htmlspecialchars($volunteer->getAvailability()); ?>" class="form-control" required> -->
            <!-- </div> -->

            <div class="form-group">
                <label>Skills:</label>
                <div id="skillsContainer">
                    <?php
                    $skills = $volunteer->getSkills();
                    if (empty($skills)) {
                        // Show one empty skill entry if no skills exist
                    ?>
                        <div class="skill-entry mb-2">
                            <div class="row">
                                <div class="col-md-6">
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
                                <div class="col-md-4">
                                    <select name="proficiency_levels[]" class="form-control" required>
                                        <option value="Beginner">Beginner</option>
                                        <option value="Intermediate">Intermediate</option>
                                        <option value="Advanced">Advanced</option>
                                        <option value="Expert">Expert</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger btn-sm remove-skill">Remove</button>
                                </div>
                            </div>
                        </div>
                        <?php
                    } else {
                        foreach ($skills as $skill) {
                        ?>
                            <div class="skill-entry mb-2">
                                <div class="row">
                                    <div class="col-md-6">
                                        <select name="skills[]" class="form-control" required>
                                            <option value="">Select a skill</option>
                                            <option value="Medical" <?php echo $skill['category'] == 'Medical' ? 'selected' : ''; ?>>Medical</option>
                                            <option value="Teaching" <?php echo $skill['category'] == 'Teaching' ? 'selected' : ''; ?>>Teaching</option>
                                            <option value="Counseling" <?php echo $skill['category'] == 'Counseling' ? 'selected' : ''; ?>>Counseling</option>
                                            <option value="Translation" <?php echo $skill['category'] == 'Translation' ? 'selected' : ''; ?>>Translation</option>
                                            <option value="Logistics" <?php echo $skill['category'] == 'Logistics' ? 'selected' : ''; ?>>Logistics</option>
                                            <option value="Fundraising" <?php echo $skill['category'] == 'Fundraising' ? 'selected' : ''; ?>>Fundraising</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select name="proficiency_levels[]" class="form-control" required>
                                            <option value="Beginner" <?php echo $skill['proficiency_level'] == 'Beginner' ? 'selected' : ''; ?>>Beginner</option>
                                            <option value="Intermediate" <?php echo $skill['proficiency_level'] == 'Intermediate' ? 'selected' : ''; ?>>Intermediate</option>
                                            <option value="Advanced" <?php echo $skill['proficiency_level'] == 'Advanced' ? 'selected' : ''; ?>>Advanced</option>
                                            <option value="Expert" <?php echo $skill['proficiency_level'] == 'Expert' ? 'selected' : ''; ?>>Expert</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger btn-sm remove-skill">Remove</button>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
                <button type="button" class="btn btn-secondary btn-sm mt-2" id="addSkill">Add Another Skill</button>
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
                <script>
                    document.getElementById('Availability').value = "<?php echo htmlspecialchars($volunteer->getAvailability()); ?>";
                </script>
            </div>

            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="<?php echo $base_url; ?>/volunteers" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script>
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