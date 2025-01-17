<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donator Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>



<body>
<?php
    $basePath = dirname($_SERVER['SCRIPT_NAME']);
    ?>
    <nav class="navbar navbar-dark bg-primary p-3">
        <a class="navbar-brand mx-auto text-white">Donator Dashboard</a>
    </nav>

    <div class="container mt-5">
        <div class="row text-center">
            <div class="col-md-4">
                <div class="card shadow-sm p-4">
                    <i class="fas fa-donate fa-3x text-success"></i>
                    <h5 class="mt-3">View Donations</h5>
                    <a href="<?php echo $basePath; ?>/donators/viewDonations" class="btn btn-primary">Go</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm p-4">
                    <i class="fas fa-hand-holding-heart fa-3x text-warning"></i>
                    <h5 class="mt-3">Make a Donation</h5>
                    <a href="<?php echo $basePath; ?>/donations/makeDonation" class="btn btn-success">Go</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm p-4">
                    <i class="fas fa-calendar-alt fa-3x text-danger"></i>
                    <h5 class="mt-3">View Events</h5>
                    <a href="<?php echo $basePath; ?>/events/registration" class="btn btn-danger">Go</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>