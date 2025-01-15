<?php
require_once 'TaskStates.php';
require_once 'CompletedState.php';
require_once 'PendingState.php';

class InProgressState implements TaskStates
{
    public function nextState(Task $task): void
    {
        $task->setState(new CompletedState());
        $task->setStatus('completed');
    }

    public function previousState(Task $task): void
    {
        $task->setState(new PendingState());
        $task->setStatus('pending');
    }

    public function getCurrentState(): string
    {
        return 'in_progress';
    }
}
