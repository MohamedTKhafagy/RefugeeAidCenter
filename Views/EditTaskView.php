<?php
// Check if the task is passed and exists
if (isset($task)) :
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link rel="stylesheet" href="/path/to/your/styles.css"> <!-- Update the path to your CSS file -->
</head>
<body>
    <h1>Edit Task</h1>

    <!-- Check for any error messages -->
    <?php if (isset($errorMessage)) : ?>
        <div class="error-message">
            <?= htmlspecialchars($errorMessage) ?>
        </div>
    <?php endif; ?>

    <!-- Form for editing the task -->
    <form action="/tasks/update/<?= $task->id ?>" method="POST">
    <input type="hidden" name="Id" value="<?= htmlspecialchars($task->id) ?>">

    <label for="Name">Task Name:</label>
    <input type="text" id="Name" name="Name" value="<?= htmlspecialchars($task->name) ?>" required>

    <label for="Description">Description:</label>
    <textarea id="Description" name="Description" required><?= htmlspecialchars($task->description) ?></textarea>

    <label for="SkillRequired">Skill Required:</label>
    <input type="text" id="SkillRequired" name="SkillRequired" value="<?= htmlspecialchars($task->skillRequired) ?>" required>

    <label for="HoursOfWork">Hours of Work:</label>
    <input type="number" id="HoursOfWork" name="HoursOfWork" value="<?= htmlspecialchars($task->hoursOfWork) ?>" required>

    <label for="AssignedVolunteerId">Assigned Volunteer ID:</label>
    <input type="number" id="AssignedVolunteerId" name="AssignedVolunteerId" value="<?= htmlspecialchars($task->assignedVolunteerId) ?>">

    <label for="IsCompleted">Completed:</label>
    <input type="checkbox" id="IsCompleted" name="IsCompleted" value="1" <?= $task->isCompleted ? 'checked' : '' ?>>

    <button type="submit">Update Task</button>
</form>


    <br>
    <a href="/tasks">Back to Task List</a>
</body>
</html>

<?php
else :
    // If task is not found, show a message
    echo "<p>Task not found.</p>";
endif;
?>
