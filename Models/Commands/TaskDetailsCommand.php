<?php
require_once __DIR__ . '/TaskCommand.php';
require_once __DIR__ . '/../../Models/Task.php';

class TaskDetailsCommand implements TaskCommand
{
    private $task;
    private $oldDetails;
    private $newDetails;

    public function __construct(Task $task, array $newDetails)
    {
        $this->task = $task;
        $this->oldDetails = [
            'name' => $task->getName(),
            'description' => $task->getDescription(),
            'hoursOfWork' => $task->getHoursOfWork(),
            'skillsRequired' => $task->getSkillsRequired()
        ];
        $this->newDetails = $newDetails;
    }

    public function execute()
    {
        $this->task->setName($this->newDetails['name']);
        $this->task->setDescription($this->newDetails['description']);
        $this->task->setHoursOfWork($this->newDetails['hoursOfWork']);
        $this->task->setSkillsRequired($this->newDetails['skillsRequired']);
        return $this->task->save();
    }

    public function undo()
    {
        $this->task->setName($this->oldDetails['name']);
        $this->task->setDescription($this->oldDetails['description']);
        $this->task->setHoursOfWork($this->oldDetails['hoursOfWork']);
        $this->task->setSkillsRequired($this->oldDetails['skillsRequired']);
        return $this->task->save();
    }
}
