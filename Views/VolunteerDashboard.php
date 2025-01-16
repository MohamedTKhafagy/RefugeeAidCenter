<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-dark bg-success p-3">
        <a class="navbar-brand mx-auto text-white">Volunteer Dashboard</a>
    </nav>

    <div class="container mt-5">
        <div class="row text-center">
            <div class="col-md-6">
                <div class="card shadow-sm p-4">
                    <i class="fas fa-calendar-check fa-3x text-info"></i>
                    <h5 class="mt-3">View Events</h5>
                    <a href="view_events.php" class="btn btn-primary">Go</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm p-4">
                    <i class="fas fa-tasks fa-3x text-warning"></i>
                    <h5 class="mt-3">View My Tasks</h5>
                    <a href="view_tasks.php" class="btn btn-success">Go</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
