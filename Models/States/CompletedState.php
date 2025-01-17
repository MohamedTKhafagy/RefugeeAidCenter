<?php
require_once 'TaskStates.php';
require_once 'InProgressState.php';

class CompletedState implements TaskStates
{
    public function nextState(Task $task): void
    {
        // Cannot progress from completed state
    }

    public function previousState(Task $task): void
    {
        $task->setState(new InProgressState());
    }

    public function getCurrentState(): string
    {
        return 'completed';
    }
}
