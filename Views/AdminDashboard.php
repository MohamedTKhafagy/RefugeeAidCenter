<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark p-3">
        <a class="navbar-brand mx-auto text-white">Admin Dashboard</a>
    </nav>

    <div class="container mt-5">
        <div class="row text-center">
            <div class="col-md-4">
                <div class="card shadow-sm p-4">
                    <i class="fas fa-users fa-3x text-primary"></i>
                    <h5 class="mt-3">Manage Users</h5>
                    <a href="manage_users.php" class="btn btn-primary">Go</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm p-4">
                    <i class="fas fa-calendar-alt fa-3x text-warning"></i>
                    <h5 class="mt-3">Manage Events</h5>
                    <a href="manage_events.php" class="btn btn-warning">Go</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm p-4">
                    <i class="fas fa-clipboard-list fa-3x text-success"></i>
                    <h5 class="mt-3">Manage Tasks</h5>
                    <a href="manage_tasks.php" class="btn btn-success">Go</a>
                </div>
            </div>
        </div>

        <div class="row text-center mt-4">
            <div class="col-md-6">
                <div class="card shadow-sm p-4">
                    <i class="fas fa-donate fa-3x text-danger"></i>
                    <h5 class="mt-3">Modify Donations</h5>
                    <a href="modify_donations.php" class="btn btn-danger">Go</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm p-4">
                    <i class="fas fa-tasks fa-3x text-info"></i>
                    <h5 class="mt-3">Modify Requests</h5>
                    <a href="modify_requests.php" class="btn btn-info">Go</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
