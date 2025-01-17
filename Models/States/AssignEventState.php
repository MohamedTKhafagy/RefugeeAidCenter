<?php
require_once 'TaskWizardStates.php';
require_once 'AssignVolunteerState.php';

class AssignEventState implements TaskWizardStates
{
    public function nextState(TaskCreationWizard $wizard): void
    {
        $wizard->setState(new AssignVolunteerState());
    }

    public function previousState(TaskCreationWizard $wizard): void
    {
        $wizard->setState(new TaskDetailsState());
    }

    public function execute(TaskCreationWizard $wizard): void
    {
        // Logic for assigning event to task
        $task = $wizard->getTask();
        if ($task->getEventId() !== null) {
            $this->nextState($wizard);
        }
    }
}
