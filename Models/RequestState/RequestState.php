<?php

interface RequestState
{
    public function submit(Request $request);
    public function accept(Request $request);
    public function complete(Request $request);
    public function decline(Request $request);
}

?>
