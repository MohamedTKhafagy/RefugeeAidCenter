<?php
class Event
{

    private $id;
    private $name;
    private $location;
    private $type;
    private $maxCapacity;
    private $currentCapacity;
    private $date;
    private $volunteers;
    private $attendees;
    public $is_deleted = 0;

    public function __construct($id, $name, $location, $type, $maxCapacity, $currentCapacity, $date, $volunteers, $attendees)
    {
        $this->id = $id;
        $this->name = $name;
        $this->location = $location;
        $this->type = $type;
        $this->maxCapacity = $maxCapacity;
        $this->currentCapacity = $currentCapacity;
        $this->date = $date;
        $this->volunteers = $volunteers;
        $this->attendees = $attendees;
    }

    public function getId()
    {
        return $this->id;
    }

    public function changeDate($changedDate)
    {
        $this->date = $changedDate;
    }

    public function getAttendees()
    {
        return $this->attendees;
    }

    public function getCurrentCapacity()
    {
        return $this->currentCapacity;
    }

    public function delete()
    {
        $this->is_deleted = 1;
    }
}
