<?php
include_once "RequestState.php";

class CompletedState implements RequestState
{
    public function submit(Request $request)
    {
        throw new Exception("Cannot submit a request in Completed state.");
    }

    public function accept(Request $request)
    {
        throw new Exception("Cannot accept a request in Completed state.");
    }

    public function complete(Request $request)
    {
        throw new Exception("Request is already completed.");
    }

    public function decline(Request $request)
    {
        throw new Exception("Cannot decline a request in Completed state.");
    }
}
?>
