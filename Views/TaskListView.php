<?php if (!empty($tasks)): ?>
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Skill Required</th>
                <th>Hours of Work</th>
                <th>Assigned Volunteer</th>
                <th>Is Completed</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($tasks as $task): ?>
            <tr>
                <td><?= htmlspecialchars($task->id) ?></td>
                <td><?= htmlspecialchars($task->name) ?></td>
                <td><?= htmlspecialchars($task->description) ?></td>
                <td><?= htmlspecialchars($task->skillRequired) ?></td>
                <td><?= htmlspecialchars($task->hoursOfWork) ?></td>
                <td><?= htmlspecialchars($task->assignedVolunteerId ?? 'Not Assigned') ?></td>
                <td><?= $task->isCompleted ? 'Yes' : 'No' ?></td>
                <td>
                    <a href="/tasks/edit/<?= $task->id ?>">Edit</a> |
                    <a href="/tasks/delete/<?= $task->id ?>">Delete</a> |
                    <a href="/tasks/assign/<?= $task->id ?>">Assign Volunteer</a> |
                    <a href="/tasks/complete/<?= $task->id ?>">Mark as Completed</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    
<?php else: ?>
    <p>No tasks found.</p>
<?php endif; ?>
