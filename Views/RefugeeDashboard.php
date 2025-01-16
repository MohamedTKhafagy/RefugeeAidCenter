<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refugee Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-dark bg-danger p-3">
        <a class="navbar-brand mx-auto text-white">Refugee Dashboard</a>
    </nav>

    <div class="container mt-5">
        <div class="row text-center">
            <div class="col-md-4">
                <div class="card shadow-sm p-4">
                    <i class="fas fa-paper-plane fa-3x text-primary"></i>
                    <h5 class="mt-3">Make a Request</h5>
                    <a href="make_request.php" class="btn btn-primary">Go</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm p-4">
                    <i class="fas fa-list fa-3x text-success"></i>
                    <h5 class="mt-3">View My Requests</h5>
                    <a href="view_requests.php" class="btn btn-success">Go</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm p-4">
                    <i class="fas fa-calendar-alt fa-3x text-warning"></i>
                    <h5 class="mt-3">View Events</h5>
                    <a href="view_events.php" class="btn btn-danger">Go</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
