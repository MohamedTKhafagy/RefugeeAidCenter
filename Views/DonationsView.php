
<?php
function renderDonationManagementView($donatorsWithDonations) {
    // Start output buffering
    ob_start();
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Donations Management</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1 class="mt-4 mb-4">Donation Management</h1>
    
    
    <!-- Refugee Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Amount</th>
                <th>Type</th>
                <th>Donator</th>
                <th>State</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($donatorsWithDonations as $item): ?>

                <?php
                    $donation = $item['donation'];
                    $donator = $item['donator'];
                    $type = "Money"; 
                    if($donation->getType()==0){
                        $type = "Money";
                    }
                    else if($donation->getType()==1){
                        $type = "Clothes";
                    }
                    else if($donation->getType()==2){
                        $type = "Food Resources";
                    }    
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($donation->getID()); ?></td>
                    <td><?php echo htmlspecialchars($donation->getAmount()); ?></td>
                    <td><?php echo htmlspecialchars($type); ?></td>
                    <td><?php echo htmlspecialchars($donator->getName()); ?></td>
                    <td><?php echo htmlspecialchars($donation->getState()); ?></td>
                    <td>
                        <div class="mb-3">
                         <?php
                            $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
                            echo '<a href="' . $base_url . '/donations/view/'.$donation->getID().'" class="btn btn-primary">View</a>';
                        ?>
                            <!-- Complete Button with Check Icon -->
                            <a href="<?= $base_url . '/donations/complete/' . $donation->getID(); ?>" class="btn btn-success">
                                <i class="fas fa-check"></i> Complete
                            </a>

                            <!-- Fail Button with X Icon -->
                            <a href="<?= $base_url . '/donations/fail/' . $donation->getID(); ?>" class="btn btn-danger">
                                <i class="fas fa-times"></i> Fail
                            </a>

                            <!-- Undo Button with Undo Icon -->
                            <a href="<?= $base_url . '/donations/undo/' . $donation->getID(); ?>" class="btn btn-warning">
                                <i class="fas fa-undo"></i> Undo
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
<?php
    // End output buffering and return the content
    return ob_get_clean();
}