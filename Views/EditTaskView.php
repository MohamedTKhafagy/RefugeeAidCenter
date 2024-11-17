<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
</head>
<body>
    <h1>Edit Task</h1>
    <form action="/tasks/update" method="post">
        <input type="hidden" name="Id" value="<?= $task->id ?>">

        <label for="name">Task Name:</label>
        <input type="text" id="name" name="Name" value="<?= htmlspecialchars($task->name) ?>" required><br><br>

        <label for="description">Description:</label>
        <textarea id="description" name="Description" required><?= htmlspecialchars($task->description) ?></textarea><br><br>

        <label for="skill">Skill Required:</label>
        <input type="text" id="skill" name="SkillRequired" value="<?= htmlspecialchars($task->skillRequired) ?>" required><br><br>

        <label for="hours">Hours of Work:</label>
        <input type="number" id="hours" name="HoursOfWork" value="<?= $task->hoursOfWork ?>" min="1" required><br><br>

        <label for="volunteer">Assigned Volunteer ID:</label>
        <input type="number" id="volunteer" name="AssignedVolunteerId" value="<?= $task->assignedVolunteerId ?>"><br><br>

        <button type="submit">Update Task</button>
    </form>
    <a href="/tasks">Back to Task List</a>
</body>
</html>
