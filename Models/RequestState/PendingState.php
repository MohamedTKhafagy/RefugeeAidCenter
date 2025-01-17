<?php
include_once "RequestState.php";

class PendingState implements RequestState
{
    public function submit(Request $request)
    {
        throw new Exception("Request is already submitted.");
    }

    public function accept(Request $request)
    {
        $request->setStatus('Accepted');
        $request->updateStatus('Accepted');
        echo "Request accepted and is now in Accepted state.\n";
    }

    public function complete(Request $request)
    {
        throw new Exception("Cannot complete a request in Pending state.");
    }

    public function decline(Request $request)
    {
        $request->setStatus('Declined');
        $request->updateStatus('Declined');
        echo "Request declined and is now in Declined state.\n";
    }
}
?>
