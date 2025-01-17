<?php
include_once "Models/RequestModel.php";
include_once "Models/RequestState/DraftState.php";
include_once "Models/RequestState/PendingState.php";
include_once "Models/RequestState/AcceptedState.php";
include_once "Models/RequestState/CompletedState.php";
include_once "Models/RequestState/DeclinedState.php";

try {
    // Step 1: Create a new request in the Draft state
    echo "Creating a new request...\n";
    $request = new Request(1, 101, "Food Request", "Need food for the family", "Food");

    echo "Initial state: " . $request->getStatus() . "\n";

    // Step 2: Submit the request (transition to Pending)
    echo "\nSubmitting the request...\n";
    $request->submit();
    echo "Current state: " . $request->getStatus() . "\n";

    // Step 3: Accept the request (transition to Accepted)
    echo "\nAccepting the request...\n";
    $request->accept();
    echo "Current state: " . $request->getStatus() . "\n";

    // Step 4: Complete the request (transition to Completed)
    echo "\nCompleting the request...\n";
    $request->complete();
    echo "Current state: " . $request->getStatus() . "\n";

    // Step 5: Attempt an invalid transition (e.g., submit after completion)
    echo "\nAttempting an invalid transition...\n";
    $request->submit();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
