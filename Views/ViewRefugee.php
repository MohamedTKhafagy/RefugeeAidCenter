<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Refugee</title>
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
            max-width: 500px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
            text-align: center;
        }

        .info-group {
            margin-bottom: 15px;
        }

        .info-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }

        .info-group p {
            margin: 0;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

    </style>
</head>

<body>
    <div class="container">
        <h2>View Refugee</h2>
        <div class="info-group">
            <label for="name">Name:</label>
            <p><?php echo htmlspecialchars($refugee->getName()); ?></p>
        </div>
        <div class="info-group">
            <label for="age">Age:</label>
            <p><?php echo htmlspecialchars($refugee->getAge()); ?></p>
        </div>
        <div class="info-group">
            <label for="gender">Gender:</label>
            <p><?php echo $refugee->getGender() === "0" ? "Male" : "Female"; ?></p>
        </div>
        <div class="info-group">
            <label for="address">Address:</label>
            <p><?php echo htmlspecialchars($refugee->getAddress()); ?></p>
        </div>
        <div class="info-group">
            <label for="phone">Phone:</label>
            <p><?php echo htmlspecialchars($refugee->getPhone()); ?></p>
        </div>
        <div class="info-group">
            <label for="nationality">Nationality:</label>
            <p><?php echo htmlspecialchars($refugee->getNationality()); ?></p>
        </div>
        <div class="info-group">
            <label for="email">Email:</label>
            <p><?php echo htmlspecialchars($refugee->getEmail()); ?></p>
        </div>
        <div class="info-group">
            <label for="passportNumber">Passport Number:</label>
            <p><?php echo htmlspecialchars($refugee->getPassportNumber()); ?></p>
        </div>
        <div class="info-group">
            <label for="preference">Preference:</label>
            <p><?php echo $refugee->getPreference() === "0" ? "Email" : "SMS"; ?></p>
        </div>
    </div>
</body>

</html>
