<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Task</title>
</head>
<body>
    <h1>Add New Task</h1>
    <form action="/tasks/add" method="post">
        <label for="name">Task Name:</label>
        <input type="text" id="name" name="Name" required><br><br>

        <label for="description">Description:</label>
        <textarea id="description" name="Description" required></textarea><br><br>

        <label for="skill">Skill Required:</label>
        <input type="text" id="skill" name="SkillRequired" required><br><br>

        <label for="hours">Hours of Work:</label>
        <input type="number" id="hours" name="HoursOfWork" min="1" required><br><br>

        <button type="submit">Add Task</button>
    </form>
    <a href="/tasks">Back to Task List</a>
</body>
</html>
