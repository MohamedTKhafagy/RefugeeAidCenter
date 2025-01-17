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
    <h1>Send Communication Message</h1>
   
    <form action="/RefugeeAidCenter/communication/send" method="POST">
    <div class="form-group">
        <label for="EventId">Event:</label>
        <input type="number" name="EventId" id="EventId" placeholder="Enter Event ID" required />
    </div>

    <div class="form-group">
        <label for="MessageBody">Message:</label>
        <textarea name="MessageBody" id="MessageBody" placeholder="Enter the message to be sent" required></textarea>
    </div>

    <div class="form-group" id="subjectField">
        <label for="Subject">Email Subject:</label>
        <input type="text" name="Subject" id="Subject" placeholder="Enter subject for email" />
    </div>

    <div class="form-group">
        <label for="Type">Communication Type:</label>
        <select name="Type" id="Type" required>
            <option value="SMS">SMS</option>
            <option value="Email">Email</option>
        </select>
    </div>

    <div class="form-group">
        <input type="submit" value="Send Message to Event Users" />
    </div>
    </form>

    <script>
        const typeSelect = document.getElementById('Type');
        const subjectField = document.getElementById('subjectField');

        typeSelect.addEventListener('change', function () {
            const value = this.value;

            if (value === 'SMS') {
                subjectField.classList.add('hidden'); // Hide subject field for SMS
            } else if (value === 'Email') {
                subjectField.classList.remove('hidden'); // Show subject field for Email
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            typeSelect.dispatchEvent(new Event('change'));
        });
    </script>

</body>
</html>
