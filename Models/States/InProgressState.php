<?php
require_once 'TaskStates.php';
require_once 'Models/States/TaskCompletedState.php';
require_once 'Models/States/TaskPendingState.php';

class InProgressState implements TaskStates
{
    public function nextState(Task $task): void
    {
        $task->setState(new TaskCompletedState());
    }

    public function previousState(Task $task): void
    {
        $task->setState(new TaskPendingState());
    }

    public function getCurrentState(): string
    {
        return 'in_progress';
    }
}
