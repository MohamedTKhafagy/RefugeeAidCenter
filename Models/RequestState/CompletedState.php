<?php
include_once "RequestState.php";

class CompletedState implements RequestState
{
    public function nextState(Request $request)
    {
        echo "Request is already in the Completed state; no further transitions allowed.\n";
    }

    public function prevState(Request $request)
    {
        throw new Exception("Request is already completed.");
    }

    public function printCurrentState()
    {
        echo "Current state: Completed\n";
    }
}
?>
