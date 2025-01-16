<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Volunteer to Task</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .volunteer-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .volunteer-card:hover {
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .skill-badge {
            background-color: #e9ecef;
            border-radius: 15px;
            padding: 5px 10px;
            margin: 2px;
            display: inline-block;
            font-size: 0.85em;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Assign Volunteer to Task</h2>
            <a href="/RefugeeAidCenter/tasks" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Task List
            </a>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0">Task Details</h5>
            </div>
            <div class="card-body">
                <h6><?= htmlspecialchars($task->getName()) ?></h6>
                <p class="text-muted"><?= htmlspecialchars($task->getDescription()) ?></p>
                <div>
                    <?php foreach ($task->getSkills() as $skill): ?>
                        <span class="skill-badge">
                            <?= htmlspecialchars($skill['name']) ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">Available Volunteers</h5>
            </div>
            <div class="card-body">
                <?php if (empty($volunteers)): ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> No volunteers are currently available.
                    </div>
                <?php else: ?>
                    <form action="/RefugeeAidCenter/tasks/assign/<?= $task->getId() ?>" method="post">
                        <div class="row">
                            <?php foreach ($volunteers as $volunteer): ?>
                                <div class="col-md-6">
                                    <div class="volunteer-card">
                                        <div class="custom-control custom-radio">
                                            <input type="radio"
                                                id="volunteer_<?= $volunteer->getId() ?>"
                                                name="volunteer_id"
                                                value="<?= $volunteer->getId() ?>"
                                                class="custom-control-input">
                                            <label class="custom-control-label" for="volunteer_<?= $volunteer->getId() ?>">
                                                <strong><?= htmlspecialchars($volunteer->getName()) ?></strong>
                                            </label>
                                        </div>
                                        <div class="ml-4 mt-2">
                                            <p class="mb-1">
                                                <i class="fas fa-calendar-alt text-muted"></i>
                                                Available: <?= htmlspecialchars($volunteer->getAvailability()) ?>
                                            </p>
                                            <div class="skills">
                                                <?php foreach ($volunteer->getSkills() as $skill): ?>
                                                    <span class="skill-badge">
                                                        <?= htmlspecialchars($skill['name']) ?>
                                                    </span>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-user-plus"></i> Assign Selected Volunteer
                            </button>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>