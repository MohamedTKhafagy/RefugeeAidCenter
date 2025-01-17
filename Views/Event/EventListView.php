<?php
require_once __DIR__ . '/EventHelpers.php';

function renderEventListView($events)
{
    $baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');

    // Start output buffering
    ob_start();
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Events</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <style>
            .event-card {
                transition: transform 0.2s;
            }

            .event-card:hover {
                transform: translateY(-5px);
            }

            .event-type {
                position: absolute;
                top: 10px;
                right: 10px;
                padding: 5px 10px;
                border-radius: 15px;
                font-size: 0.8em;
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
        </style>
    </head>

    <body>
        <div class="container mt-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Events</h2>
                <a href="<?= $baseUrl ?>/events/add" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Create New Event
                </a>
            </div>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?= $_SESSION['success'] ?>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?= $_SESSION['error'] ?>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <div class="row">
                <?php if (empty($events)): ?>
                    <div class="col-12">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> No events found.
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($events as $event): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card event-card h-100">
                                <div class="card-body">
                                    <span class="event-type event-type-<?= htmlspecialchars($event->getType()) ?>">
                                        <?= getEventTypeName($event->getType()) ?>
                                    </span>
                                    <h5 class="card-title"><?= htmlspecialchars($event->getName()) ?></h5>
                                    <p class="card-text">
                                        <i class="far fa-calendar-alt"></i>
                                        <?= htmlspecialchars($event->getDate()) ?>
                                        <br>
                                        <i class="fas fa-map-marker-alt"></i>
                                        <?= htmlspecialchars($event->getLocation()) ?>
                                        <br>
                                        <i class="fas fa-users"></i>
                                        Capacity: <?= htmlspecialchars($event->getCurrentCapacity()) ?>/<?= htmlspecialchars($event->getMaxCapacity()) ?>
                                    </p>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <div class="btn-group w-100">
                                        <a href="<?= $baseUrl ?>/events/details/<?= $event->getId() ?>"
                                            class="btn btn-outline-primary">
                                            <i class="fas fa-info-circle"></i> Details
                                        </a>
                                        <a href="<?= $baseUrl ?>/events/edit/<?= $event->getId() ?>"
                                            class="btn btn-outline-secondary">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <button type="button"
                                            class="btn btn-outline-danger"
                                            onclick="confirmDelete(<?= $event->getId() ?>)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
            function confirmDelete(eventId) {
                if (confirm('Are you sure you want to delete this event?')) {
                    window.location.href = '<?= $baseUrl ?>/events/delete/' + eventId;
                }
            }
        </script>
    </body>

    </html>
<?php
    // End output buffering and return the content
    return ob_get_clean();
}
