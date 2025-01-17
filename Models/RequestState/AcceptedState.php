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
        $request->setStatus('Completed');
        $request->updateStatus('Completed');
        echo "Request completed and is now in Completed state.\n";
    }

    public function decline(Request $request)
    {
        throw new Exception("Cannot decline a request in Accepted state.");
    }
}
?>
