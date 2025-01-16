<?php
require_once 'TaskStates.php';
require_once 'InProgressState.php';

class PendingState implements TaskStates
{
    public function nextState(Task $task): void
    {
        $task->setState(new InProgressState());
    }

    public function previousState(Task $task): void
    {
        // Cannot go back from pending state
    }

    public function getCurrentState(): string
    {
        return 'pending';
    }
}
