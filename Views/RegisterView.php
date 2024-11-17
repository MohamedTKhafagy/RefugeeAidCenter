<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
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

        .days {
            display: flex;
            justify-content: space-between;
        }

        .day {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 5px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-right: 5px;
            background-color: #f0f0f0;
        }

        .form-group .day input {
            margin-left: 5px;
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
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required>
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
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="passportNumber">Passport Number:</label>
                <input type="text" id="passportNumber" name="passportNumber">
            </div>
            
            <!-- Refugee-Specific Fields -->
            <div id="refugeeFields" class="hidden">
                <div class="form-group">
                    <label for="profession">Profession:</label>
                    <input type="text" id="profession" name="profession">
                </div>
                <div class="form-group">
                    <label for="education">Education:</label>
                    <input type="text" id="education" name="education">
                </div>
            </div>

            <!-- Volunteer-Specific Fields -->
            <div id="volunteerFields" class="hidden">
                <div class="form-group">
                    <label>Availability:</label>
                    <div class="days">
                        <div class="day">
                            <label for="Saturday">Sat</label>
                            <input type="checkbox" name="availability" id="Saturday" value="Saturday">
                        </div>
                        <div class="day">
                            <label for="Sunday">Sun</label>
                            <input type="checkbox" name="availability" id="Sunday" value="Sunday">
                        </div>
                        <div class="day">
                            <label for="Monday">Mon</label>
                            <input type="checkbox" name="availability" id="Monday" value="Monday">
                        </div>
                        <div class="day">
                            <label for="Tuesday">Tue</label>
                            <input type="checkbox" name="availability" id="Tuesday" value="Tuesday">
                        </div>
                        <div class="day">
                            <label for="Wednesday">Wed</label>
                            <input type="checkbox" name="availability" id="Wednesday" value="Wednesday">
                        </div>
                        <div class="day">
                            <label for="Thursday">Thu</label>
                            <input type="checkbox" name="availability" id="Thursday" value="Thursday">
                        </div>
                        <div class="day">
                            <label for="Friday">Fri</label>
                            <input type="checkbox" name="availability" id="Friday" value="Friday">
                        </div>
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

            console.log(type);

            if (type === "refugee") {
                if (passportNumber.value.trim() === "") {
                    alert("Passport Number is required for Refugees.");
                    passportNumber.focus();
                    return false;
                }
            }

            const checkboxes = document.querySelectorAll('#volunteerFields input[type="checkbox"]');
            if (type === "volunteer" && !Array.from(checkboxes).some(checkbox => checkbox.checked)) {
                alert("Please select at least one availability day for Volunteers.");
                return false;
            }

            return true;
        }
    </script>
</body>

</html>
