<?php

function renderAddVolunteerView()
{
    $baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
    $error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
    unset($_SESSION['error']);

    // Start output buffering
    ob_start();
?>
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

            <?php if ($error): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($error) ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <form action="<?= $baseUrl ?>/volunteers/add" method="POST">
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

                <div class="form-group">
                    <label>Skills:</label>
                    <div id="skillsContainer">
                        <div class="skill-entry">
                            <div class="row">
                                <div class="col-md-10">
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
                                    <button type="button" class="btn btn-danger btn-block remove-skill">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary btn-sm mt-2" id="addSkill">Add Another Skill</button>
                </div>

                <div class="form-group">
                    <label>Availability:</label>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="sunday" name="Availability[]" value="Sunday">
                        <label class="custom-control-label" for="sunday">Sunday</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="monday" name="Availability[]" value="Monday">
                        <label class="custom-control-label" for="monday">Monday</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="tuesday" name="Availability[]" value="Tuesday">
                        <label class="custom-control-label" for="tuesday">Tuesday</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="wednesday" name="Availability[]" value="Wednesday">
                        <label class="custom-control-label" for="wednesday">Wednesday</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="thursday" name="Availability[]" value="Thursday">
                        <label class="custom-control-label" for="thursday">Thursday</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="friday" name="Availability[]" value="Friday">
                        <label class="custom-control-label" for="friday">Friday</label>
                    </div>
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="saturday" name="Availability[]" value="Saturday">
                        <label class="custom-control-label" for="saturday">Saturday</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Add Volunteer</button>
                <a href="<?= $baseUrl ?>/volunteers" class="btn btn-secondary">Cancel</a>
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
<?php
    // Return the buffered content
    return ob_get_clean();
}
?>