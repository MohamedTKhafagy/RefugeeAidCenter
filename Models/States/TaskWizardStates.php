<?php

interface TaskWizardStates
{
    public function nextState(TaskCreationWizard $wizard): void;
    public function previousState(TaskCreationWizard $wizard): void;
    public function execute(TaskCreationWizard $wizard): void;
}
