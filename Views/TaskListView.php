<?php
require_once __DIR__ . '/../Event.php';
require_once __DIR__ . '/../DBInit.php';

class TaskListView
{
    private $tasks;
    private $baseUrl;

    public function __construct($tasks)
    {
        $this->tasks = $tasks;
        $this->baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
    }

    public function render()
    {
        ob_start();
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <title>Task List</title>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
            <style>
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

                .status-in_progress {
                    background-color: #b8daff;
                    color: #004085;
                }

                .status-completed {
                    background-color: #c3e6cb;
                    color: #155724;
                }

                .action-buttons .btn {
                    margin-right: 5px;
                }

                .skill-badge {
                    background-color: #e9ecef;
                    padding: 3px 8px;
                    border-radius: 12px;
                    margin: 2px;
                    display: inline-block;
                    font-size: 0.85em;
                }
            </style>
        </head>

        <body>
            <div class="container mt-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Task Management</h2>
                    <a href="<?= $this->baseUrl ?>/tasks/wizard" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Create New Task
                    </a>
                </div>

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> <?= htmlspecialchars($_SESSION['success']) ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($_SESSION['error']) ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <?php if (!empty($this->tasks)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Associated Event</th>
                                    <th>Skills Required</th>
                                    <th>Hours</th>
                                    <th>Assigned To</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($this->tasks as $task): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($task->getId()) ?></td>
                                        <td><?= htmlspecialchars($task->getName()) ?></td>
                                        <td>
                                            <?php
                                            $eventId = $task->getEventId();
                                            if ($eventId) {
                                                $db = DbConnection::getInstance();
                                                $sql = "SELECT * FROM Events WHERE id = ? AND is_deleted = 0";
                                                $result = $db->fetchAll($sql, [$eventId]);

                                                if (!empty($result)) {
                                                    $eventData = $result[0];
                                                    $event = new Event(
                                                        $eventData['id'],
                                                        $eventData['name'],
                                                        $eventData['location'],
                                                        $eventData['type'],
                                                        $eventData['max_capacity'],
                                                        $eventData['current_capacity'],
                                                        $eventData['date'],
                                                        [], // volunteers array
                                                        []  // attendees array
                                                    );
                                                    echo '<a href="' . $this->baseUrl . '/events/details/' . $event->getId() . '">' .
                                                        htmlspecialchars($event->getName()) . '</a>';
                                                } else {
                                                    echo '<span class="text-muted">Event not found</span>';
                                                }
                                            } else {
                                                echo '<span class="text-muted">No event assigned</span>';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $skills = $task->getSkills();
                                            foreach ($skills as $skill) {
                                                echo '<span class="skill-badge">' . htmlspecialchars($skill['name']) . '</span>';
                                            }
                                            ?>
                                        </td>
                                        <td><?= htmlspecialchars($task->getHoursOfWork()) ?> hrs</td>
                                        <td>
                                            <?php
                                            $volunteerId = $task->getVolunteerId();
                                            if ($volunteerId) {
                                                $volunteerName = $task->getVolunteerName();
                                                echo htmlspecialchars($volunteerName) . ' (#' . htmlspecialchars($volunteerId) . ')';
                                            } else {
                                                echo '<span class="text-muted">Unassigned</span>';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <span class="task-status status-<?= htmlspecialchars($task->getStatus()) ?>">
                                                <?= ucfirst(htmlspecialchars($task->getStatus())) ?>
                                            </span>
                                        </td>
                                        <td class="action-buttons">
                                            <a href="<?= $this->baseUrl ?>/tasks/edit/<?= $task->getId() ?>" class="btn btn-sm btn-info" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <?php if (!$task->getVolunteerId()): ?>
                                                <a href="<?= $this->baseUrl ?>/tasks/assign/<?= $task->getId() ?>" class="btn btn-sm btn-success" title="Assign Volunteer">
                                                    <i class="fas fa-user-plus"></i>
                                                </a>
                                            <?php elseif ($task->getStatus() !== 'completed'): ?>
                                                <a href="<?= $this->baseUrl ?>/tasks/unassign/<?= $task->getId() ?>" class="btn btn-sm btn-warning" title="Unassign Volunteer" onclick="return confirm('Are you sure you want to unassign the volunteer from this task?');">
                                                    <i class="fas fa-user-minus"></i>
                                                </a>
                                            <?php endif; ?>
                                            <?php if ($task->getStatus() === 'in_progress'): ?>
                                                <a href="<?= $this->baseUrl ?>/tasks/complete/<?= $task->getId() ?>" class="btn btn-sm btn-primary" title="Mark as Completed">
                                                    <i class="fas fa-check"></i>
                                                </a>
                                            <?php endif; ?>
                                            <button type="button" class="btn btn-sm btn-danger" title="Delete"
                                                onclick="taskManager.confirmDelete(<?= $task->getId() ?>)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> No tasks found. Click the "Create New Task" button to add a task.
                    </div>
                <?php endif; ?>
            </div>

            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Confirm Delete</h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete this task?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <a href="#" id="confirmDelete" class="btn btn-danger">Delete</a>
                        </div>
                    </div>
                </div>
            </div>

            <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
            <script>
                class TaskListManager {
                    constructor(baseUrl) {
                        this.baseUrl = baseUrl;
                        this.initializeEventListeners();
                    }

                    confirmDelete(taskId) {
                        $('#confirmDelete').attr('href', this.baseUrl + '/tasks/delete/' + taskId);
                        $('#deleteModal').modal('show');
                    }

                    initializeEventListeners() {
                        // Add any additional event listeners here
                    }
                }

                
                const taskManager = new TaskListManager('<?= $this->baseUrl ?>');
            </script>
        </body>

        </html>
<?php
        return ob_get_clean();
    }
}


?>