<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .container {
            margin: 50px 0;
            background-color: #ffffff;
            width: 100%;
            height: 100%;
            max-width: 500px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .hidden {
            display: none;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .skill-entry {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>User Registration</h2>
        <?php $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'); ?>
        <form id="registrationForm" action="<?php echo $base_url ?>/register/new" method="POST" onsubmit="return validateForm()">
            <!-- Common Fields -->
            <div class="form-group">
                <label for="type">User Type:</label>
                <select name="type" id="type" required onchange="toggleFields()">
                    <option value="">Select User Type</option>
                    <option value="donator">Donator</option>
                    <option value="refugee">Refugee</option>
                    <option value="volunteer">Volunteer</option>
                </select>
            </div>

            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="age">Age:</label>
                <input type="number" id="age" name="age" min="0" required>
            </div>

            <div class="form-group">
                <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                    <option value="">Select Gender</option>
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

            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" required placeholder="10 digits">
            </div>

            <div class="form-group">
                <label for="nationality">Nationality:</label>
                <input type="text" id="nationality" name="nationality" required>
            </div>


            <div class="form-group">
                <label for="passportNumber">Passport Number:</label>
                <input type="text" id="passportNumber" name="passportNumber">
            </div>

            <div class="form-group">
                <label for="preference">Preference:</label>
                <select name="preference" id="preference" class="form-control" required>
                    <option value="0">Email</option>
                    <option value="1">SMS</option>
                </select>
            </div>

            <!-- Refugee-Specific Fields -->
            <div id="refugeeFields" class="hidden">
                <div class="form-group">
                    <label for="profession">Profession:</label>
                    <select name="profession" id="profession" class="form-control" required>
                        <option value="farmer">Farmer</option>
                        <option value="tailor">Tailor</option>
                        <option value="carpenter">Carpenter</option>
                        <option value="cook">Cook</option>
                        <option value="driver">Driver</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="education">Education:</label>
                    <select name="education" id="education" class="form-control" required>
                        <option value="none">No Formal Education</option>
                        <option value="primary">Primary School</option>
                        <option value="secondary">Secondary School</option>
                        <option value="vocational">Vocational Training</option>
                        <option value="bachelor">Bachelor's Degree</option>
                    </select>
                </div>
            </div>

            <!-- Volunteer-Specific Fields -->
            <div id="volunteerFields" class="hidden">
                <div class="form-group">
                    <label>Skills:</label>
                    <div id="skillsContainer">
                        <div class="skill-entry">
                            <div class="row">
                                <div class="col-md-10">
                                    <select name="skills[]" class="form-control">
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
            </div>

            <button type="submit">Register</button>
        </form>
        <?php
        if (isset($errors) && !empty($errors)) {
            echo "<ul>";
            foreach ($errors as $error) {
                echo "<li style='color:red'>$error</li>";
            }
            echo "</ul>";
        }
        ?>
    </div>

    <script>
        function toggleFields() {
            const type = document.getElementById("type").value;
            document.getElementById("refugeeFields").classList.toggle("hidden", type !== "refugee");
            document.getElementById("volunteerFields").classList.toggle("hidden", type !== "volunteer");
        }

        function validateForm() {
            const type = document.getElementById("type").value;
            const passportNumber = document.getElementById("passportNumber");

            if (type === "refugee") {
                if (passportNumber.value.trim() === "") {
                    alert("Passport Number is required for Refugees.");
                    passportNumber.focus();
                    return false;
                }
            }

            return true;
        }

        // Add skill functionality
        document.getElementById('addSkill').addEventListener('click', function() {
            const container = document.getElementById('skillsContainer');
            const newSkill = container.children[0].cloneNode(true);

            // Clear selections in the new element
            newSkill.querySelectorAll('select').forEach(select => select.selectedIndex = 0);

            // Add remove button functionality
            newSkill.querySelector('.remove-skill').addEventListener('click', function() {
                this.closest('.skill-entry').remove();
            });

            container.appendChild(newSkill);
        });

        // Add remove functionality to the initial skill entry
        document.querySelector('.remove-skill').addEventListener('click', function() {
            if (document.querySelectorAll('.skill-entry').length > 1) {
                this.closest('.skill-entry').remove();
            }
        });
    </script>
</body>

</html>