<?php
function renderEditRefugeeView($refugee, $errors = [])
{
    $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
    // Start output buffering
    ob_start();
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Refugee</title>
        <style>
            * {
                box-sizing: border-box;
            }

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
            <h2>Edit Refugee</h2>
            <form id="registrationForm" action="<?php echo $base_url ?>/refugees/edit" method="POST" onsubmit="return validateForm()">
                <input type="hidden" name="id" value="<?php echo $refugee->getRefugeeId() ?>">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo $refugee->getName() ?>" required>
                </div>

                <div class="form-group">
                    <label for="age">Age:</label>
                    <input type="number" id="age" name="age" min="0" value="<?php echo $refugee->getAge() ?>" required>
                </div>

                <div class="form-group">
                    <label for="gender">Gender:</label>
                    <select id="gender" name="gender" required>
                        <option value="">Select Gender</option>
                        <option value="0" <?= $refugee->getGender() === '0' ? 'selected' : '' ?>>Male</option>
                        <option value="1" <?= $refugee->getGender() === '1' ? 'selected' : '' ?>>Female</option>
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
                    <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" required value="<?php echo $refugee->getPhone() ?>" placeholder="10 digits">
                </div>

                <div class="form-group">
                    <label for="nationality">Nationality:</label>
                    <input type="text" id="nationality" name="nationality" value="<?php echo $refugee->getNationality() ?>" required>
                </div>

                <div class="form-group">
                    <label for="passportNumber">Passport Number:</label>
                    <input type="text" id="passportNumber" name="passportNumber" value="<?php echo $refugee->getPassportNumber() ?>">
                </div>

                <div class="form-group">
                    <label for="preference">Preference:</label>
                    <select name="preference" id="preference" class="form-control" required>
                        <option value="0">Email</option>
                        <option value="1">SMS</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="profession">Profession:</label>
                    <select name="profession" id="profession" class="form-control" required>
                        <option value="farmer" <?php echo ($refugee->getProfession() == 'farmer') ? 'selected' : ''; ?>>Farmer</option>
                        <option value="tailor" <?php echo ($refugee->getProfession() == 'tailor') ? 'selected' : ''; ?>>Tailor</option>
                        <option value="carpenter" <?php echo ($refugee->getProfession() == 'carpenter') ? 'selected' : ''; ?>>Carpenter</option>
                        <option value="cook" <?php echo ($refugee->getProfession() == 'cook') ? 'selected' : ''; ?>>Cook</option>
                        <option value="driver" <?php echo ($refugee->getProfession() == 'driver') ? 'selected' : ''; ?>>Driver</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="education">Education:</label>
                    <select name="education" id="education" class="form-control" required>
                        <option value="none" <?php echo ($refugee->getEducation() == 'none') ? 'selected' : ''; ?>>No Formal Education</option>
                        <option value="primary" <?php echo ($refugee->getEducation() == 'primary') ? 'selected' : ''; ?>>Primary School</option>
                        <option value="secondary" <?php echo ($refugee->getEducation() == 'secondary') ? 'selected' : ''; ?>>Secondary School</option>
                        <option value="vocational" <?php echo ($refugee->getEducation() == 'vocational') ? 'selected' : ''; ?>>Vocational Training</option>
                        <option value="bachelor" <?php echo ($refugee->getEducation() == 'bachelor') ? 'selected' : ''; ?>>Bachelor's Degree</option>
                    </select>
                </div>



                <button type="submit">Edit</button>
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
        </script>
    </body>

    </html>
<?php
    // End output buffering and return the content
    return ob_get_clean();
}
