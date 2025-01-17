<?php
$base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create New Request</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="mt-4 mb-4">Create New Request</h1>

    <form method="POST" action="<?php echo $base_url; ?>/requests/add">
        <div class="form-group">
            <label for="refugeeId">Refugee ID</label>
            <input type="number" class="form-control" id="refugeeId" name="RefugeeId" required>
        </div>
        <div class="form-group">
            <label for="name">Request Name</label>
            <input type="text" class="form-control" id="name" name="Name" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="Description" required></textarea>
        </div>
        <div class="form-group">
            <label for="type">Request Type</label>
            <select class="form-control" id="type" name="Type" required>
                <option value="Money">Money</option>
                <option value="Clothes">Clothes</option>
                <option value="Food">Food</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit Request</button>
    </form>
</div>
</body>
</html>
