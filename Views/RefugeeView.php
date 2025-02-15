<?php
function renderRefugeeListView($refugees, $rIterator)
{
    $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
    
    ob_start();
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Refugee Management</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <title>Refugee Management</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>

    <body>
        <div class="container">
            <h1 class="mt-4 mb-4">Refugee Management</h1>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Nationality</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($refugees->isEmpty()) { ?>
                        <td>No Avaialbile Refugees</td>
                        <?php
                    } else {
                        while ($rIterator->hasNext()) {
                            $refugee = $rIterator->next();
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($refugee->getRefugeeId()); ?></td>
                                <td><?php echo htmlspecialchars($refugee->getName()); ?></td>
                                <td><?php echo htmlspecialchars($refugee->getAge()); ?></td>
                                <td><?php echo $refugee->getGender() == 0 ? "Male" : "Female"; ?></td>
                                <td><?php echo htmlspecialchars($refugee->getNationality()); ?></td>
                                <td>
                                    <?php $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'); ?>
                                    <a href="<?php echo $base_url ?>/refugees/editRefugee?id=<?php echo $refugee->getRefugeeId(); ?>" class="btn btn-warning btn-sm">Update</a>
                                    <a href="<?php echo $base_url ?>/refugees/delete/<?php echo $refugee->getRefugeeId(); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this refugee?');">Delete</a>
                                    <a href="<?php echo $base_url ?>/refugees/view/<?php echo $refugee->getRefugeeId(); ?>" class="btn btn-primary btn-sm">View</a>
                                </td>
                            </tr>
                    <?php }
                    } ?>
                </tbody>
            </table>
        </div>
    </body>

    </html>
<?php
    
    return ob_get_clean();
}
