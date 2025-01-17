<?php
include_once "RequestState.php";

class DraftState implements RequestState
{
    public function nextState(Request $request)
    {
        $request->setState(new PendingState());
        $request->updateStatus('Pending');
        echo "Request moved to Pending state.\n";
    }

    public function prevState(Request $request)
    {
        echo "This is the initial state; cannot move back further.\n";
    }

    public function printCurrentState()
    {
        echo "Current state: Draft\n";
    }
}
?>
