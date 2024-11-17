<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List</title>
</head>
<body>
    <h1>Task List</h1>
    <?php if (!empty($tasks)): ?>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Skill Required</th>
                <th>Hours of Work</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($tasks as $task): ?>
<tr>
    <td><?= htmlspecialchars($task['Id']) ?></td>
    <td><?= htmlspecialchars($task['Name']) ?></td>
    <td><?= htmlspecialchars($task['Description']) ?></td>
    <td><?= htmlspecialchars($task['SkillRequired']) ?></td>
    <td><?= htmlspecialchars($task['HoursOfWork']) ?></td>
    <td>
        <a href="/tasks/edit/<?= $task['Id'] ?>">Edit</a> |
        <a href="/tasks/delete/<?= $task['Id'] ?>">Delete</a> |
        <a href="/tasks/assign/<?= $task['Id'] ?>">Assign Volunteer</a> |
        <a href="/tasks/complete/<?= $task['Id'] ?>">Mark as Completed</a>
    </td>
</tr>
<?php endforeach; ?>

        </tbody>
    </table>
<?php else: ?>
    <p>No tasks found.</p>
<?php endif; ?>

</body>
</html>
