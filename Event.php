<?php
class Event{
    private $id;
    private $name;
    private $location;
    private $type;
    private $maxCapacity;
    private $currentCapacity;
    private $date;
    private $volunteers;
    private $attendees;
    public function __construct($id, $name, $location,$type, $maxCapacity,$currentCapacity, $date, $volunteers, $attendees){
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
    public function changeDate(){
        //date
    }
    
}


?>