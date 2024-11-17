<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Volunteer</title>
</head>
<body>
    <h1>Assign Volunteer to Task</h1>
    <form action="/tasks/assign" method="post">
        <input type="hidden" name="TaskId" value="<?= $taskId ?>">

        <label for="volunteer">Volunteer ID:</label>
        <input type="number" id="volunteer" name="VolunteerId" required><br><br>

        <button type="submit">Assign Volunteer</button>
    </form>
    <a href="/tasks">Back to Task List</a>
</body>
</html>
