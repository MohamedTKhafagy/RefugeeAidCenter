<?php
include_once "RequestState.php";

class DraftState implements RequestState
{
    public function submit(Request $request)
    {
        $request->updateStatus('Pending');
        $request->setState('Pending');
        echo "Request submitted and is now in Pending state.\n";
    }

    public function accept(Request $request)
    {
        throw new Exception("Cannot accept a request in Draft state.");
    }

    public function complete(Request $request)
    {
        throw new Exception("Cannot complete a request in Draft state.");
    }

    public function decline(Request $request)
    {
        throw new Exception("Cannot decline a request in Draft state.");
    }
}
?>
