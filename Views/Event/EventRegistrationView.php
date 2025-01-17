<?php

function renderEventRegistrationView($events, $userId, $registeredEvents = [])
{
    $baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
    $success = isset($_SESSION['success']) ? $_SESSION['success'] : '';
    $error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
    unset($_SESSION['success'], $_SESSION['error']);

    // Start output buffering
    ob_start();
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Event Registration</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <style>
            .event-card {
                transition: transform 0.2s;
                margin-bottom: 20px;
            }

            .event-card:hover {
                transform: translateY(-5px);
            }

            .capacity-badge {
                position: absolute;
                top: 10px;
                right: 10px;
            }

            .event-date {
                color: #6c757d;
                font-size: 0.9rem;
            }

            .registered-badge {
                position: absolute;
                top: 10px;
                left: 10px;
                background-color: #28a745;
            }
        </style>
    </head>

    <body class="bg-light">
        <div class="container mt-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Available Events</h2>
            </div>

            <?php if ($success): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <?php
            $isLoggedIn = isset($_SESSION['user']) && isset($_SESSION['user']['id']);
            if (!$isLoggedIn):
            ?>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    Please <a href="<?= $baseUrl ?>/login" class="alert-link">log in</a> to register for events.
                </div>
            <?php endif; ?>

            <div class="row">
                <?php foreach ($events as $event): ?>
                    <div class="col-md-4">
                        <div class="card event-card">
                            <?php if ($isLoggedIn && in_array($event->getId(), $registeredEvents)): ?>
                                <span class="badge badge-success registered-badge">Registered</span>
                            <?php endif; ?>

                            <span class="badge badge-info capacity-badge">
                                <?= htmlspecialchars($event->getCurrentCapacity()) ?>/<?= htmlspecialchars($event->getMaxCapacity()) ?> Participants
                            </span>

                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($event->getName()) ?></h5>
                                <p class="card-text event-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <?= htmlspecialchars(date('F j, Y', strtotime($event->getDate()))) ?>
                                </p>
                                <p class="card-text">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <?= htmlspecialchars($event->getLocation()) ?>
                                </p>

                                <?php if (!$isLoggedIn): ?>
                                    <a href="<?= $baseUrl ?>/login" class="btn btn-primary btn-block">
                                        <i class="fas fa-sign-in-alt"></i> Log in to Register
                                    </a>
                                <?php else: ?>
                                    <?php if (!in_array($event->getId(), $registeredEvents)): ?>
                                        <?php if ($event->getCurrentCapacity() < $event->getMaxCapacity()): ?>
                                            <form action="<?= $baseUrl ?>/events/register" method="post">
                                                <input type="hidden" name="event_id" value="<?= $event->getId() ?>">
                                                <button type="submit" class="btn btn-primary btn-block">
                                                    <i class="fas fa-check"></i> Register
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <button class="btn btn-secondary btn-block" disabled>
                                                <i class="fas fa-ban"></i> Event Full
                                            </button>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <form action="<?= $baseUrl ?>/events/unregister" method="post">
                                            <input type="hidden" name="event_id" value="<?= $event->getId() ?>">
                                            <button type="submit" class="btn btn-danger btn-block">
                                                <i class="fas fa-times"></i> Cancel Registration
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>

    </html>
<?php
    // End output buffering and return the content
    return ob_get_clean();
}
