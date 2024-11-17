<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Communication Message</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
            color: #333;
        }

        h1 {
            color: #333;
            text-align: center;
        }

        form {
            max-width: 700px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        label {
            font-size: 16px;
            margin-top: 15px;
            display: block;
        }

        input, textarea, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        textarea {
            resize: vertical;
            min-height: 150px;  
            line-height: 1.6;   
            padding-top: 10px;  
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            padding: 12px;
            font-size: 16px;
            width: 100%;
            border-radius: 4px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .hidden {
            display: none;
        }

        .toggle-label {
            margin-top: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>
"../controllers/CommunicationController.php"
    <h1>Send Communication Message</h1>
   
    <form action= '<?php echo $base_url; ?>/communication/send' method="POST">
        <div class="form-group">
            <label for="MessageBody">Message:</label>
            <textarea name="MessageBody" id="MessageBody" required></textarea>
        </div>

        <div class="form-group">
            <label for="Type">Communication Type:</label>
            <select name="Type" id="Type" required>
                <option value="SMS">SMS</option>
                <option value="Email">Email</option>
            </select>
        </div>

        <div class="form-group hidden" id="smsFields">
            <label for="PhoneNumber" class="toggle-label">Phone Number (for SMS):</label>
            <input type="text" name="PhoneNumber" id="PhoneNumber" placeholder="Enter recipient's phone number" />
        </div>

        <div class="form-group hidden" id="emailFields">
            <label for="Email" class="toggle-label">Email Address:</label>
            <input type="email" name="Email" id="Email" placeholder="Enter recipient's email address" required />
            <label for="Subject" class="toggle-label">Email Subject:</label>
            <input type="text" name="Subject" id="Subject" placeholder="Enter email subject" required />
        </div>

        <div class="form-group">
            <input type="submit" value="Send Message" />
        </div>
    </form>

    <script>
        const typeSelect = document.getElementById('Type');
        const smsFields = document.getElementById('smsFields');
        const emailFields = document.getElementById('emailFields');

        typeSelect.addEventListener('change', function () {
            const value = this.value;

            if (value === 'SMS') {
                smsFields.classList.remove('hidden');
                emailFields.classList.add('hidden');
            } else if (value === 'Email') {
                emailFields.classList.remove('hidden');
                smsFields.classList.add('hidden');
            }
        });
    </script>

</body>
</html>
