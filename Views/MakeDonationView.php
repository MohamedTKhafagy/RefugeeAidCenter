<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Make Donation</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2 class="mt-4 mb-4">Make a Donation</h2>
    <?php $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/'); ?>
    <form action="<?php echo $base_url; ?>/donations/makeDonation" method="POST">
        
        <input type="hidden" name="action" value="save">

        

        <div class="form-group">
            <label for="Amount">Amount:</label>
            <input type="text" name="Amount" id="Amount" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="Type">Type:</label>
            <select name="Type" id="Type" class="form-control" required>
                <option value="0">Money</option>
                <option value="1">Clothes</option>
                <option value="2">Food Resources</option>
            </select>
        </div>

        <div class="form-group">
            <label for="DirectedTo">Directed To:</label>
            <select name="DirectedTo" id="DirectedTo" class="form-control" required>
                <option value="0">Hospital</option>
                <option value="1">School</option>
                <option value="2">Shelter</option>
            </select>
        </div>

        <div class="form-group">
            <label for="CollectionFee">Add Collection Fee:</label>
            <select name="CollectionFee" id="CollectionFee" class="form-control" required>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>

        <div class="form-group">
            <label for="currency">Currency:</label>
            <select name="currency" id="currency" class="form-control" required>
                <option value="0">EGP</option>
                <option value="1">USD</option>
                <option value="2">GBP</option>
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary">Make Donation</button>
        <a href="donators" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
