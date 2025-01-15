<?php
require_once 'TaskStates.php';
require_once 'InProgressState.php';

class PendingState implements TaskStates
{
    public function nextState(Task $task): void
    {
        $task->setState(new InProgressState());
        $task->setStatus('in_progress');
    }

    public function previousState(Task $task): void
    {
        // This is the initial state
    }

    public function getCurrentState(): string
    {
        return 'pending';
    }
}
