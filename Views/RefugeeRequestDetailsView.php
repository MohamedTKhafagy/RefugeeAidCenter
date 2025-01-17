<?php
$base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Request Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="mt-4 mb-4">Request Details</h1>

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <td><?php echo htmlspecialchars($request->getId()); ?></td>
        </tr>
        <tr>
            <th>Name</th>
            <td><?php echo htmlspecialchars($request->getName()); ?></td>
        </tr>
        <tr>
            <th>Description</th>
            <td><?php echo htmlspecialchars($request->getDescription()); ?></td>
        </tr>
        <tr>
            <th>Type</th>
            <td><?php echo htmlspecialchars($request->getType()); ?></td>
        </tr>
        <tr>
            <th>Quantity</th>
            <td><?php echo htmlspecialchars($request->getQuantity()); ?></td>
        </tr>
        <tr>
            <th>Status</th>
            <td><?php echo htmlspecialchars($request->getStatus()); ?></td>
        </tr>
    </table>

    <div class="mt-4">
        <a href="<?php echo $base_url; ?>/requests/submit/<?php echo $request->getId(); ?>" class="btn btn-warning">Submit</a>
    </div>
</div>
</body>
</html>
