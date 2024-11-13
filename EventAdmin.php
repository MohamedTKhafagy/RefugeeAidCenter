<?php
class EventAdmin extends User{
    private array $events=[];
    public function __construct(array $events=[]){
        $this->events = $events;

    }
    public function RegisterEvent(Event $event){
        $this->events[] = $event;
    }
    public function update($message){
        echo "EventAdmin received update: {$message}\n";
    }

    public function getCurrentCapacity($eventId) {
        foreach ($this->events as $event) {
            if ($event->getId() === $eventId) { 
                return $event->getCurrentCapacity();
            }
        }
        return "No Capacity in this event";
    }

    public function getEventById($eventId) {
        foreach ($this->events as $event) {
            if ($event->getId() === $eventId) {
                return $event;
            }
        }
        return "Event not found";
    }

    public function updateEvent($eventId, $newEvent) {
        foreach ($this->events as &$event) { 
            if ($event->getId() === $eventId) {
                $event = $newEvent;
                return "Event updated successfully";
            }
        }
        return "Event not found";
    }
   
     public function deleteEvent($eventId) {
        foreach ($this->events as $event) {
            if ($event->getId() === $eventId) {
                $event->delete();
                return "Event marked as deleted";
            }
        }
        return "Event not found";
    }


}

