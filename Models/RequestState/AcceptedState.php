<?php
include_once "RequestState.php";

class AcceptedState implements RequestState
{
    public function nextState(Request $request)
    {
        if ($request->deductInventory()) {
        $request->setState(new CompletedState());
        $request->updateStatus('Completed');
        echo "Request moved to Completed state.\n";
        }
        else {
            throw new Exception("Insufficient inventory to complete the request.");
        }

    }

    public function prevState(Request $request)
    {
        $request->setState(new PendingState());
        $request->updateStatus('Pending');
        echo "Request moved back to Pending state.\n";
    }

    public function printCurrentState()
    {
        echo "Current state: Accepted\n";
    }
}
?>
