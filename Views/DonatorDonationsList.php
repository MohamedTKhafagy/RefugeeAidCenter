
<?php
function renderDonatorDonationsView($donations) {
    // Start output buffering
    ob_start();
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Donations Management</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1 class="mt-4 mb-4">My Donations</h1>
    
    
    <!-- Refugee Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Amount</th>
                <th>Type</th>
                <th>State</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($donations as $donation): ?>

                <?php
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
                    <td><?php echo htmlspecialchars($donation->getState()); ?></td>
                    <td>
                        <div class="mb-3">
                         <?php
                            $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
                            echo '<a href="' . $base_url . '/donations/view/'.$donation->getID().'" class="btn btn-primary">View</a>';
                        ?>
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