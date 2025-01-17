<?php
include_once "RequestState.php";

class AcceptedState implements RequestState
{
    public function submit(Request $request)
    {
        throw new Exception("Cannot submit a request in Accepted state.");
    }

    public function accept(Request $request)
    {
        throw new Exception("Request is already accepted.");
    }

    public function complete(Request $request)
    {
        if ($request->deductInventory()) {
            $request->updateStatus('Completed');
            $request->setState('Completed');
            echo "Request completed and inventory updated successfully.\n";
        } else {
            throw new Exception("Insufficient inventory to complete the request.");
        }
    }

    public function decline(Request $request)
    {
        throw new Exception("Cannot decline a request in Accepted state.");
    }
}
?>
