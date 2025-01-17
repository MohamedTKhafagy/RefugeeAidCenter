<?php
require_once 'Models/States/TaskStates.php';
require_once 'Models/States/InProgressState.php';

class TaskCompletedState implements TaskStates
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
