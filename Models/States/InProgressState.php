<?php
require_once 'TaskStates.php';
require_once 'CompletedState.php';
require_once 'PendingState.php';

class InProgressState implements TaskStates
{
    public function nextState(Task $task): void
    {
        $task->setState(new CompletedState());
    }

    public function previousState(Task $task): void
    {
        $task->setState(new PendingState());
    }

    public function getCurrentState(): string
    {
        return 'in_progress';
    }
}
