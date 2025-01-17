<?php

interface RequestState
{
    public function nextState(Request $request);
    public function prevState(Request $request);
    public function printCurrentState();
}

?>

