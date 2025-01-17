<?php
include_once "RequestState.php";

class DeclinedState implements RequestState
{
    public function nextState(Request $request)
    {
        echo "Request is in Declined state; no further transitions allowed.\n";
    }

    public function prevState(Request $request)
    {
        echo "Request is in Declined state; no further transitions allowed.\n";
    }

    public function printCurrentState()
    {
        echo "Current state: Declined\n";
    }
}
?>
