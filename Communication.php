<?php
include_once "CommunicationStrategy.php";
class Communication implements CommunicationSubject{
    private CommunicationStrategy $communicationStrategy;
    private $type; //0: SMS, 1:Email
    private $phoneNumber;
    private $email;

    public function __construct($type, $phoneNumber, $email){
        $this->type=$type;
        $this->phoneNumber=$phoneNumber;
        $this->email=$email;
        $this->InitializeCommunicationStrategy();
    }

    public function InitializeCommunicationStrategy(){
        if($this->type==0){
            $this->communicationStrategy= new SMSCommunication($this->phoneNumber);
        } else {
            $this->communicationStrategy= new EmailCommunication($this->email);
        }
    }

    public function setCommunicationStrategy($communicationStrategy){
        $this->communicationStrategy= $communicationStrategy;
    }

    public function SetPreference(){

    }

    public function ScheduleMessage(Message $message, DateTime $scheduleDate ){
        $currentTime= new DateTime();
        if($scheduleDate> $currentTime){
            
        }
    }

    public function Send(){

    }

    public function RegisterObserver(){

    }

    public function RemoveObserver(){

    }

    public function NotifyObserver(){
        $this->communicationStrategy->notify();
    }

}
