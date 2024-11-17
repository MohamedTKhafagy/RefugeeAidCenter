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
        <?php $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'); ?>
        <form id="registrationForm" action="<?php echo $base_url ?>/register/newAdmin" method="POST" onsubmit="return validateForm()">
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
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" value="<?php echo $refugee->getAddress() ?>" required>
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
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $refugee->getEmail() ?>" required>
            </div>

            <div class="form-group">
                <label for="passportNumber">Passport Number:</label>
                <input type="text" id="passportNumber" name="passportNumber" value="<?php echo $refugee->getPassportNumber() ?>">
            </div>

            <div id="adultFields" class="hidden">
                <div class="form-group">
                    <label for="profession">Profession:</label>
                    <input type="text" id="profession" name="profession"">
                </div>
                <div class="form-group">
                    <label for="education">Education:</label>
                    <input type="text" id="education" name="education">
                </div>
                <div class="form-group family">
                    <div style="display:flex;margin-bottom:10px;">
                        <label>Family:</label>
                        <button type="button" onclick="addFamily()" style="width:20px;height:20px;padding:0;border-radius:50%;margin-left:10px;">+</button>
                    </div>
                    <div id="family_members"></div>
                    <!-- <input type="text" id="family" name="family"> -->
                </div>
            </div>

            <div id="childFields" class="hidden">
                <div class="form-group">
                    <label for="school">School:</label>
                    <input type="text" id="school" name="school">
                </div>
                <div class="form-group">
                    <label for="level">Level:</label>
                    <input type="text" id="level" name="level">
                </div>
                <div class="form-group">
                    <label for="guardian">Guardian:</label>
                    <input type="text" id="guardian" name="guardian">
                </div>
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
        function toggleFields() {
            const type = document.getElementById("type").value;
            document.getElementById("adultFields").classList.toggle("hidden", type !== "adult");
            document.getElementById("childFields").classList.toggle("hidden", type !== "child");
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

        function addFamily() {
            const familyMembers = document.getElementById("family_members");
            const input = document.createElement("input");
            input.type = "text";
            input.name = "family[]";
            input.placeholder = "Family Member ID";
            input.style.marginBottom = "10px";
            familyMembers.appendChild(input);
        }
    </script>
</body>

</html>