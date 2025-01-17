<?php

interface TaskCommand
{
    public function execute();
    public function undo();
}
