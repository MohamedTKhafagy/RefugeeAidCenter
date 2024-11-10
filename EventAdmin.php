<?php
class EventAdmin extends User{
    private $eventAdminId;
    
    private Event $event;
    public function __construct(Event $event){
        $this->event = $event;

    }
    
    public function RegisterEvent(){

    }

}

?>