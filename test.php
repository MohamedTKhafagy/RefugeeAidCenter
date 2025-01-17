<?php
include_once "Models/RequestModel.php";
include_once "Models/RequestState/DraftState.php";
include_once "Models/RequestState/PendingState.php";
include_once "Models/RequestState/AcceptedState.php";
include_once "Models/RequestState/CompletedState.php";
include_once "Models/RequestState/DeclinedState.php";

try {
    
    echo "Creating a new request...\n";
    $request = new Request(1, 101, "Food Request", "Need food for the family", "Food");

    echo "Initial state: " . $request->getStatus() . "\n";

    
    echo "\nSubmitting the request...\n";
    $request->submit();
    echo "Current state: " . $request->getStatus() . "\n";

    
    echo "\nAccepting the request...\n";
    $request->accept();
    echo "Current state: " . $request->getStatus() . "\n";

    
    echo "\nCompleting the request...\n";
    $request->complete();
    echo "Current state: " . $request->getStatus() . "\n";

    
    echo "\nAttempting an invalid transition...\n";
    $request->submit();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
