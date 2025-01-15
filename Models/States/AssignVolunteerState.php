<?php
require_once 'TaskWizardStates.php';

class AssignVolunteerState implements TaskWizardStates
{
    public function nextState(TaskCreationWizard $wizard): void
    {
        // This is the final state
        $task = $wizard->getTask();
        $task->setStatus('pending');
        $task->save();
    }

    public function previousState(TaskCreationWizard $wizard): void
    {
        $wizard->setState(new AssignEventState());
    }

    public function execute(TaskCreationWizard $wizard): void
    {
        // Logic for assigning volunteer to task
        $task = $wizard->getTask();
        if ($task->getVolunteerId() !== null) {
            $this->nextState($wizard);
        }
    }
}
