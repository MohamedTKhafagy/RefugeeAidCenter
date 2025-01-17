<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Requests Management</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h1 class="mt-4 mb-4">Requests Management</h1>

    <?php
    require_once __DIR__ . '/../Models/RequestModel.php';
    
    $requests = Request::all();
    ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Type</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($requests as $request): ?>
                <tr>
                    <td><?php echo htmlspecialchars($request->getId()); ?></td>
                    <td><?php echo htmlspecialchars($request->getName()); ?></td>
                    <td><?php echo htmlspecialchars($request->getType()); ?></td>
                    <td><?php echo htmlspecialchars($request->getQuantity()); ?></td>
                    <td><?php echo htmlspecialchars($request->getStatus()); ?></td>
                    <td>
                        <?php
                        $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
                        ?>
<td>
    <?php
    $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
    ?>
    <a href="<?php echo $base_url; ?>/requests/view/<?php echo $request->getId(); ?>" class="btn btn-info">View</a>
    <a href="<?php echo $base_url; ?>/requests/submit/<?php echo $request->getId(); ?>" class="btn btn-secondary">Next State</a>
    <a href="<?php echo $base_url; ?>/requests/decline/<?php echo $request->getId(); ?>" class="btn btn-danger">Decline</a>
    <a href="<?php echo $base_url; ?>/requests/previous/<?php echo $request->getId(); ?>" class="btn btn-warning">Previous State</a>
</td>

                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
