<?php
include_once "CommunicationStrategy.php";
class Communication implements Subject{
    private $observers = [];
    private CommunicationStrategy $communicationStrategy;
    private $type; //0: SMS, 1:Email
    private $phoneNumber;
    private $email;
    private $subject;
    private $messageBody;

    public function __construct($type, $phoneNumber, $email, $subject, $messageBody){
        $this->type=$type;
        $this->phoneNumber=$phoneNumber;
        $this->email=$email;
        $this->subject = $subject;
        $this->messageBody = $messageBody;
        $this->InitializeCommunicationStrategy();
    }

    public function InitializeCommunicationStrategy(){
        if($this->type==0){
            $this->communicationStrategy = new SMSCommunication($this->phoneNumber, $this->messageBody);
        } else {
            $this->communicationStrategy = new EmailCommunication($this->email, $this->subject, $this->messageBody);
        }
    }

    public function setCommunicationStrategy($communicationStrategy){
        $this->communicationStrategy= $communicationStrategy;
    }

    public function SetPreference(){

    }

    public function ScheduleMessage(Message $message, DateTime $scheduleDate ){
        $currentTime= new DateTime();
        if ($scheduleDate > $currentTime) {
            echo "Message scheduled for " . $scheduleDate->format('Y-m-d H:i:s') . "\n";
        } else {
            throw new InvalidArgumentException("Scheduled date must be in the future.");
        }
    }

    public function Send(){
        $this->communicationStrategy->notify();
        $this->NotifyObservers();
    }

    public function RegisterObserver(Observer $observer){
        $this->observers[]= $observer;
    }

    public function RemoveObserver(Observer $observer){
        $index= array_search($observer, $this->observers, true);
        if($index!=false){
            unset($this->observers[$index]);
            $this->observers= array_values($this->observers);
        }
    }

    public function NotifyObservers(){
        foreach($this->observers as $observer){
            $observer->update("Message sent through " . get_class($this->communicationStrategy ) . "\n");
        }
    }

}





