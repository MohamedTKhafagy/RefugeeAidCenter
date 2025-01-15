<?php
require_once 'Commands/TaskCommand.php';
require_once 'States/TaskWizardStates.php';
require_once 'States/TaskDetailsState.php';
require_once 'Task.php';

class TaskCreationWizard
{
    private $commandHistory = [];
    private $undoneCommands = [];
    private $currentState;
    private $task;

    public function __construct()
    {
        $this->currentState = new TaskDetailsState();
        $this->task = new Task(null, '', '', 0, '');
    }

    public function setState(TaskWizardStates $state): void
    {
        $this->currentState = $state;
    }

    public function getTask(): Task
    {
        return $this->task;
    }

    public function setTask(Task $task): void
    {
        $this->task = $task;
    }

    public function nextState(): void
    {
        $this->currentState->nextState($this);
    }

    public function previousState(): void
    {
        $this->currentState->previousState($this);
    }

    public function executeState(): void
    {
        $this->currentState->execute($this);
    }

    public function executeCommand(TaskCommand $command)
    {
        if ($command->execute()) {
            $this->commandHistory[] = $command;
            $this->undoneCommands = [];
            return true;
        }
        return false;
    }

    public function undo()
    {
        if (empty($this->commandHistory)) {
            return false;
        }

        $command = array_pop($this->commandHistory);
        if ($command->undo()) {
            $this->undoneCommands[] = $command;
            return true;
        }
        return false;
    }

    public function redo()
    {
        if (empty($this->undoneCommands)) {
            return false;
        }

        $command = array_pop($this->undoneCommands);
        if ($command->execute()) {
            $this->commandHistory[] = $command;
            return true;
        }
        return false;
    }

    public function getCommandHistory()
    {
        return $this->commandHistory;
    }
}
