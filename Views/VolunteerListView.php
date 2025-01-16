<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Refugee Management</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .has-assigned-tasks {
            background-color: #fff3cd;
        }

        .tooltip-icon {
            color: #6c757d;
            cursor: help;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="mt-4 mb-4">Volunteer Management</h1>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $_SESSION['error'] ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $_SESSION['success'] ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <!-- Add New Volunteer Button -->
        <div class="mb-3">
            <?php
            $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
            echo '<a href="' . $base_url . '/volunteers/add" class="btn btn-primary">Add New Volunteer</a>';
            ?>
        </div>

        <!-- Volunteer Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Volunteer ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Skills</th>
                    <th>Availability</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($volunteers as $volunteer):
                    // Check if volunteer has assigned tasks
                    $db = DbConnection::getInstance();
                    $sql = "SELECT COUNT(*) as count FROM Tasks WHERE volunteer_id = ? AND is_deleted = 0";
                    $result = $db->fetchAll($sql, [$volunteer->getId()]);
                    $hasAssignedTasks = $result[0]['count'] > 0;
                ?>
                    <tr class="<?= $hasAssignedTasks ? 'has-assigned-tasks' : '' ?>">
                        <td><?php echo htmlspecialchars($volunteer->getId()); ?></td>
                        <td>
                            <?php echo htmlspecialchars($volunteer->getName()); ?>
                            <?php if ($hasAssignedTasks): ?>
                                <i class="fas fa-tasks tooltip-icon ml-1" data-toggle="tooltip" title="Has assigned tasks"></i>
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($volunteer->getAge()); ?></td>
                        <td><?php
                            $skills = $volunteer->getSkills();
                            $skillDisplay = [];
                            foreach ($skills as $skill) {
                                $skillDisplay[] = htmlspecialchars($skill['name']);
                            }
                            echo implode(', ', $skillDisplay);
                            ?></td>
                        <td><?php echo htmlspecialchars($volunteer->getAvailability()); ?></td>
                        <td>
                            <a href="<?php echo $base_url; ?>/volunteers/edit/<?php echo $volunteer->getID(); ?>" class="btn btn-warning btn-sm">Edit</a>
                            <?php if ($hasAssignedTasks): ?>
                                <button class="btn btn-danger btn-sm" disabled title="Cannot delete: Has assigned tasks">Delete</button>
                            <?php else: ?>
                                <a href="<?php echo $base_url; ?>/volunteers/delete/<?php echo $volunteer->getID(); ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this volunteer?');">Delete</a>
                            <?php endif; ?>
                            <a href="<?php echo $base_url; ?>/volunteers/view/<?php echo $volunteer->getID(); ?>" class="btn btn-primary btn-sm">View</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</body>

</html>