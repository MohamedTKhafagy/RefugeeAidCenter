<?php
require_once 'Commands/TaskCommand.php';
require_once 'States/TaskWizardStates.php';
require_once 'States/TaskDetailsState.php';
require_once 'States/AssignEventState.php';
require_once 'Task.php';

class TaskCreationWizard
{
    private $commandHistory = [];
    private $undoneCommands = [];
    private $currentState;
    private $task;
    private static $instance = null;
    private $currentStep = 1;
    private $totalSteps = 3; // Details -> Event -> Review

    private function __construct()
    {
        $this->currentState = new TaskDetailsState();
        $this->task = new Task('', '', 0, 'pending');
        $this->loadFromSession();
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function setState(TaskWizardStates $state): void
    {
        $this->currentState = $state;
        $this->saveToSession();
    }

    public function getTask(): Task
    {
        return $this->task;
    }

    public function setTask(Task $task): void
    {
        $this->task = $task;
        $this->saveToSession();
    }

    public function getCurrentStep(): int
    {
        return $this->currentStep;
    }

    public function getTotalSteps(): int
    {
        return $this->totalSteps;
    }

    public function nextState(): void
    {
        $this->currentState->nextState($this);
        $this->currentStep = min($this->currentStep + 1, $this->totalSteps);
        $this->saveToSession();
    }

    public function previousState(): void
    {
        $this->currentState->previousState($this);
        $this->currentStep = max($this->currentStep - 1, 1);
        $this->saveToSession();
    }

    public function executeState(): void
    {
        $this->currentState->execute($this);
        $this->saveToSession();
    }

    public function executeCommand(TaskCommand $command)
    {
        if ($command->execute()) {
            $this->commandHistory[] = $command;
            $this->undoneCommands = [];
            $this->saveToSession();
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
            $this->saveToSession();
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
            $this->saveToSession();
            return true;
        }
        return false;
    }

    public function getCommandHistory()
    {
        return $this->commandHistory;
    }

    public function getCurrentState(): TaskWizardStates
    {
        return $this->currentState;
    }

    private function saveToSession()
    {
        $_SESSION['task_wizard'] = [
            'current_step' => $this->currentStep,
            'task_data' => [
                'id' => $this->task->getId(),
                'name' => $this->task->getName(),
                'description' => $this->task->getDescription(),
                'hoursOfWork' => $this->task->getHoursOfWork(),
                'status' => $this->task->getStatus(),
                'eventId' => $this->task->getEventId(),
                'skills' => $this->task->getSkills()
            ]
        ];
    }

    private function loadFromSession()
    {
        if (isset($_SESSION['task_wizard'])) {
            $data = $_SESSION['task_wizard'];
            $this->currentStep = $data['current_step'];

            if (isset($data['task_data'])) {
                $taskData = $data['task_data'];
                $this->task = new Task(
                    $taskData['name'],
                    $taskData['description'],
                    $taskData['hoursOfWork'],
                    $taskData['status'],
                    $taskData['eventId'],
                    null,
                    $taskData['id']
                );

                if (!empty($taskData['skills'])) {
                    foreach ($taskData['skills'] as $skill) {
                        $this->task->addSkill($skill['id']);
                    }
                }
            }
        }
    }

    public function reset()
    {
        $this->task = new Task('', '', 0, 'pending');
        $this->currentStep = 1;
        $this->currentState = new TaskDetailsState();
        $this->commandHistory = [];
        $this->undoneCommands = [];
        unset($_SESSION['task_wizard']);
    }
}
