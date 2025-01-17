<?php
require_once __DIR__ . '/EventHelpers.php';

function renderEventDetailsView($event, $tasks)
{
    $baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');

    
    ob_start();
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Event Details - <?= htmlspecialchars($event->getName()) ?></title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <style>
            .event-type {
                display: inline-block;
                padding: 5px 15px;
                border-radius: 15px;
                font-size: 0.9em;
                margin-bottom: 20px;
            }

            .event-type-0 {
                background-color: #e3f2fd;
                color: #1565c0;
            }

            .event-type-1 {
                background-color: #f1f8e9;
                color: #558b2f;
            }

            .event-type-2 {
                background-color: #fce4ec;
                color: #c2185b;
            }

            .event-type-3 {
                background-color: #fff3e0;
                color: #ef6c00;
            }

            .event-type-4 {
                background-color: #e8eaf6;
                color: #3949ab;
            }

            .task-status {
                padding: 5px 10px;
                border-radius: 15px;
                font-size: 0.9em;
                font-weight: 500;
            }

            .status-pending {
                background-color: #ffeeba;
                color: #856404;
            }

            .status-assigned {
                background-color: #b8daff;
                color: #004085;
            }

            .status-completed {
                background-color: #c3e6cb;
                color: #155724;
            }
        </style>
    </head>

    <body>
        <div class="container mt-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Event Details</h2>
                <div>
                    <a href="<?= $baseUrl ?>/events/edit/<?= $event->getId() ?>" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit Event
                    </a>
                    <a href="<?= $baseUrl ?>/events" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Events
                    </a>
                </div>
            </div>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?= $_SESSION['success'] ?>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <span class="event-type event-type-<?= htmlspecialchars($event->getType()) ?>">
                                <?= getEventTypeName($event->getType()) ?>
                            </span>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong><i class="far fa-calendar-alt"></i> Date:</strong>
                                </div>
                                <div class="col-md-8">
                                    <?= htmlspecialchars($event->getDate()) ?>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <strong><i class="fas fa-map-marker-alt"></i> Location:</strong>
                                </div>
                                <div class="col-md-8">
                                    <?= htmlspecialchars($event->getLocation()) ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <strong><i class="fas fa-users"></i> Capacity:</strong>
                                </div>
                                <div class="col-md-8">
                                    <?= htmlspecialchars($event->getCurrentCapacity()) ?>/<?= htmlspecialchars($event->getMaxCapacity()) ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="mb-0">Associated Tasks</h4>
                                <a href="<?= $baseUrl ?>/tasks/wizard" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Add Task
                                </a>
                            </div>

                            <?php if (empty($tasks)): ?>
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> No tasks are associated with this event.
                                </div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Task Name</th>
                                                <th>Hours</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($tasks as $task): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($task->getName()) ?></td>
                                                    <td><?= htmlspecialchars($task->getHoursOfWork()) ?></td>
                                                    <td>
                                                        <span class="task-status status-<?= strtolower($task->getStatus()) ?>">
                                                            <?= htmlspecialchars($task->getStatus()) ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="<?= $baseUrl ?>/tasks/edit/<?= $task->getId() ?>"
                                                                class="btn btn-sm btn-outline-secondary">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <button type="button"
                                                                class="btn btn-sm btn-outline-danger"
                                                                onclick="confirmDeleteTask(<?= $task->getId() ?>)">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Quick Stats</h5>
                            <div class="mb-3">
                                <strong>Total Tasks:</strong> <?= count($tasks) ?>
                            </div>
                            <div class="mb-3">
                                <strong>Available Capacity:</strong>
                                <?= $event->getMaxCapacity() - $event->getCurrentCapacity() ?> spots
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
            function confirmDeleteTask(taskId) {
                if (confirm('Are you sure you want to delete this task?')) {
                    window.location.href = '<?= $baseUrl ?>/tasks/delete/' + taskId;
                }
            }
        </script>
    </body>

    </html>
<?php
    // End output buffering and return the content
    return ob_get_clean();
}
