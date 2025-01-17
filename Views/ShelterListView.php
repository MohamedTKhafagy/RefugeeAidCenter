<!-- Views/ShelterListView.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Shelter List</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1 class="my-4">Shelters</h1>
        <!-- Add New Volunteer Button -->
        <div class="mb-3">
            <?php
            $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
            echo '<a href="' . $base_url . '/shelters/add" class="btn btn-primary">Add New Shelter</a>';
            ?>
        </div>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Shelter ID</th>
                    <th>Name</th>
                    <th>Supervisor</th>
                    <th>Max Capacity</th>
                    <th>Current Capacity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($shelters as $shelter) : ?>
                    <tr>

                        <td><?php echo htmlspecialchars($shelter->getId()); ?></td>
                        <td><?php echo htmlspecialchars($shelter->getName()); ?></td>

                        <td>
                            <?php
                            foreach ($volunteers as $supervisor) {
                                if ($supervisor->getId() == $shelter->getSupervisor()) {
                                    echo htmlspecialchars($supervisor->getName());
                                    break;
                                }
                            }
                            ?>
                        </td>

                        <td><?php echo htmlspecialchars($shelter->getMaxCapacity()); ?></td>
                        <td><?php echo htmlspecialchars($shelter->getCurrentCapacity()); ?></td>
                        <td>
                            <a href="<?php echo $base_url; ?>/shelters/edit/<?php echo $shelter->getID(); ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="<?php echo $base_url; ?>/shelters/delete/<?php echo $shelter->getID(); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this refugee?');">Delete</a>
                            <a href="<?php echo $base_url; ?>/shelters/view/<?php echo $shelter->getID(); ?>" class="btn btn-primary btn-sm">View</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>