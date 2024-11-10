<?php
interface CommunicationStrategy{
    public function notify();

}

class EmailCommunication implements CommunicationStrategy {
    private $email;
    public function __construct($email) {
        $this->email = $email;
    }
    public function notify() {
        // Send an email to the user
    }
}


class SMSCommunication implements CommunicationStrategy {
    private $phoneNumber;
    public function __construct($phoneNumber){
        $this->phoneNumber= $phoneNumber;
    }
    
    public function notify(){
        // Send SMS notification
    }
}

