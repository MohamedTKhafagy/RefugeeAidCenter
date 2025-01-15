<?php
require_once 'TaskStates.php';
require_once 'InProgressState.php';

class CompletedState implements TaskStates
{
    public function nextState(Task $task): void
    {
        // This is the final state
    }

    public function previousState(Task $task): void
    {
        $task->setState(new InProgressState());
        $task->setStatus('in_progress');
    }

    public function getCurrentState(): string
    {
        return 'completed';
    }
}
