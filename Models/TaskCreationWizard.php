<?php
require_once 'Commands/TaskCommand.php';

class TaskCreationWizard
{
    private $commandHistory = [];
    private $undoneCommands = [];

    public function executeCommand(TaskCommand $command)
    {
        if ($command->execute()) {
            $this->commandHistory[] = $command;
            // Clear undone commands when a new command is executed
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
