<?php

class Message{
    private $id;
    private $content;
    private DateTime $scheduleDate;
    private $priority;
    private $recipient;
    private $subject;

    public function __construct($id, $content, $scheduleDate, $priority, $subject, $recipient){
        $this->id = $id;
        $this->content = $content;
        $this->scheduleDate = $scheduleDate;
        $this->priority = $priority;
        $this->subject = $subject;
        $this->recipient = $recipient;
    }

    public function __toString() {
        $scheduled = $this->scheduleDate ? $this->scheduleDate->format('Y-m-d H:i:s') : 'Right Now';
        return "Message to {$this->recipient} | Subject: {$this->subject} | Priority: {$this->priority} | Scheduled: {$scheduled}";
    }
    private function setContent($content){
        $this->content=$content;
    }

    private function getContent(){
        return $this->content;
    }

    private function setPriority($priority){
        $this->priority= $priority;
    }

    private function setRecipient($recipient){
        $this->recipient=$recipient;
    }
    public function getRecipient() {
        return $this->recipient;
    }

    public function getScheduledDate() {
        return $this->scheduleDate;
    }

    public function setScheduleDate(DateTime $scheduleDate) {
        $this->scheduleDate = $scheduleDate;
    }
    public function getSubject() {
        return $this->subject;
    }

    public function setSubject($subject) {
        $this->subject = $subject;
    }

}