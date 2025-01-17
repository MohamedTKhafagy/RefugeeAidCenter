<?php

interface TaskStates
{
    public function nextState(Task $task): void;
    public function previousState(Task $task): void;
    public function getCurrentState(): string;
}
