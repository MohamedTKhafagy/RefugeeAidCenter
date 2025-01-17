<?php
function renderEventFormView($event = null)
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
        <title><?= $event ? 'Edit Event' : 'Create New Event' ?></title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    </head>

    <body>
        <div class="container mt-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><?= $event ? 'Edit Event' : 'Create New Event' ?></h2>
                <a href="<?= $baseUrl ?>/events" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Events
                </a>
            </div>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?= $_SESSION['error'] ?>
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            <div class="card">
                <div class="card-body">
                    <form method="post" class="needs-validation" novalidate>
                        <div class="form-group">
                            <label for="name">Event Name</label>
                            <input type="text"
                                class="form-control"
                                id="name"
                                name="name"
                                value="<?= $event ? htmlspecialchars($event->getName()) : '' ?>"
                                required>
                            <div class="invalid-feedback">
                                Please provide an event name.
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="location">Location</label>
                            <input type="text"
                                class="form-control"
                                id="location"
                                name="location"
                                value="<?= $event ? htmlspecialchars($event->getLocation()) : '' ?>"
                                required>
                            <div class="invalid-feedback">
                                Please provide an event location.
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="type">Event Type</label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="">Select Type</option>
                                <option value="0" <?= $event && $event->getType() == 0 ? 'selected' : '' ?>>Health</option>
                                <option value="1" <?= $event && $event->getType() == 1 ? 'selected' : '' ?>>Food</option>
                                <option value="2" <?= $event && $event->getType() == 2 ? 'selected' : '' ?>>Clothing</option>
                                <option value="3" <?= $event && $event->getType() == 3 ? 'selected' : '' ?>>Education</option>
                                <option value="4" <?= $event && $event->getType() == 4 ? 'selected' : '' ?>>Housing</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select an event type.
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="max_capacity">Maximum Capacity</label>
                            <input type="number"
                                class="form-control"
                                id="max_capacity"
                                name="max_capacity"
                                min="1"
                                value="<?= $event ? htmlspecialchars($event->getMaxCapacity()) : '10' ?>"
                                required>
                            <div class="invalid-feedback">
                                Please provide a maximum capacity (minimum 1).
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="date">Event Date</label>
                            <input type="date"
                                class="form-control"
                                id="date"
                                name="date"
                                value="<?= $event ? htmlspecialchars($event->getDate()) : '' ?>"
                                min="<?= date('Y-m-d') ?>"
                                required>
                            <div class="invalid-feedback">
                                Please provide a valid future date.
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> <?= $event ? 'Update Event' : 'Create Event' ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script>
            // Form validation
            (function() {
                'use strict';
                window.addEventListener('load', function() {
                    var forms = document.getElementsByClassName('needs-validation');
                    var validation = Array.prototype.filter.call(forms, function(form) {
                        form.addEventListener('submit', function(event) {
                            if (form.checkValidity() === false) {
                                event.preventDefault();
                                event.stopPropagation();
                            }
                            form.classList.add('was-validated');
                        }, false);
                    });
                }, false);
            })();
        </script>
    </body>

    </html>
<?php
    // End output buffering and return the content
    return ob_get_clean();
}
