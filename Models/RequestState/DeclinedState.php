<?php
include_once "RequestState.php";

class DeclinedState implements RequestState
{
    public function submit(Request $request)
    {
        throw new Exception("Cannot submit a request in Declined state.");
    }

    public function accept(Request $request)
    {
        throw new Exception("Cannot accept a request in Declined state.");
    }

    public function complete(Request $request)
    {
        throw new Exception("Cannot complete a request in Declined state.");
    }

    public function decline(Request $request)
    {
        throw new Exception("Request is already declined.");
    }
}
?>
