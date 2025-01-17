<?php
require_once 'TaskWizardStates.php';
require_once 'AssignEventState.php';

class TaskDetailsState implements TaskWizardStates
{
    public function nextState(TaskCreationWizard $wizard): void
    {
        $wizard->setState(new AssignEventState());
    }

    public function previousState(TaskCreationWizard $wizard): void
    {
        // This is the initial state, no previous state
    }

    public function execute(TaskCreationWizard $wizard): void
    {
        
        $task = $wizard->getTask();
        if (!empty($task->getName()) && !empty($task->getDescription())) {
            $this->nextState($wizard);
        }
    }
}
