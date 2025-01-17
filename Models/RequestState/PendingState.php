<?php
include_once "RequestState.php";

class PendingState implements RequestState
{
    public function nextState(Request $request)
    {
        $request->setState(new AcceptedState());
        $request->updateStatus('Accepted');
        echo "Request moved to Accepted state.\n";
    }

    public function prevState(Request $request)
    {
        $request->setState(new DraftState());
        $request->updateStatus('Draft');
        echo "Request moved back to Draft state.\n";
    }

    public function printCurrentState()
    {
        echo "Current state: Pending\n";
    }
}
?>
