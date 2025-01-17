<?php
function renderRefugeeRequestsView($requests) {
    ob_start();
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Requests</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1 class="mt-4 mb-4">My Requests</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Type</th>
                <th>Quantity</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($requests as $request): ?>
                <tr>
                    <td><?php echo htmlspecialchars($request->getId()); ?></td>
                    <td><?php echo htmlspecialchars($request->getName()); ?></td>
                    <td><?php echo htmlspecialchars($request->getDescription()); ?></td>
                    <td><?php echo htmlspecialchars($request->getType()); ?></td>
                    <td><?php echo htmlspecialchars($request->getQuantity()); ?></td>
                    <td><?php echo htmlspecialchars($request->getStatus()); ?></td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
<?php
    return ob_get_clean();
}
?>
