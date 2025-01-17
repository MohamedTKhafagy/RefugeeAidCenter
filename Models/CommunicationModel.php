<?php
include_once "CommunicationStrategy.php";
include_once "Observer.php";
include_once "Subject.php";

class CommunicationModel implements Subject {
    private $observers = [];
    private $communicationStrategy;
    private $type;
    private $messageBody;
    private $phoneNumber;
    private $email;
    private $subject;

    public function __construct($type, $messageBody, $phoneNumber = null, $email = null, $subject = null) {
        $this->type = $type;
        $this->messageBody = $messageBody;
        $this->phoneNumber = $phoneNumber;
        $this->email = $email;
        $this->subject = $subject;
        $this->initializeCommunicationStrategy();
    }

    private function initializeCommunicationStrategy() {
        if ($this->type == 'SMS') {
            $this->communicationStrategy = new SMSCommunication($this->phoneNumber, $this->messageBody);
        } else if ($this->type == 'Email') {
            $this->communicationStrategy = new EmailCommunication($this->email, $this->subject, $this->messageBody);
        }
    }

    public function send() {
        $this->communicationStrategy->notify();
        $this->notifyObservers();
    }

    public function registerObserver(Observer $observer) {
        $this->observers[] = $observer;
    }

    public function removeObserver(Observer $observer) {
        $index = array_search($observer, $this->observers, true);
        if ($index !== false) {
            unset($this->observers[$index]);
        }
    }

    public function notifyObservers() {
        foreach ($this->observers as $observer) {
            $observer->update("Message sent via " . get_class($this->communicationStrategy));
        }
    }
}
?>
