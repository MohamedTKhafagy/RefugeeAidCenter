<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        <h2>Login</h2>
        <?php $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'); ?>
        <form id="loginForm" action="<?php echo $base_url ?>/login/new" method="POST">
            <!-- Common Fields -->
            <div class="form-group">
                <label for="type">User Type:</label>
                <select name="type" id="type" required>
                    <option value="">Select User Type</option>
                    <option value="donator">Donator</option>
                    <option value="refugee">Refugee</option>
                    <option value="volunteer">Volunteer</option>
                </select>
            </div>
            

            <div class="form-group">
                <label for="name">Email:</label>
                <input type="text" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" min="0" required>
            </div>

            <button type="submit">Login</button>
        </form>
        <?php
            if (isset($commonErrors) && !empty($commonErrors)) {
                echo "<ul>";
                foreach ($commonErrors as $error) {
                    echo "<li style='color:red'>$error</li>";
                }
                echo "</ul>";
            }
        ?>
    </div>
</body>

</html>
