<?php
interface CommunicationStrategy {
    public function notify();
}

class EmailCommunication implements CommunicationStrategy {
    private $email;
    private $subject;
    private $messageBody;

    public function __construct($email, $subject, $messageBody) {
        $this->email = $email;
        $this->subject = $subject;
        $this->messageBody = $messageBody;
    }

    public function notify() {
        echo "Sending Email to {$this->email} with subject: '{$this->subject}' and message: '{$this->messageBody}'\n";
    }
}

class SMSCommunication implements CommunicationStrategy {
    private $phoneNumber;
    private $messageBody;

    public function __construct($phoneNumber, $messageBody) {
        $this->phoneNumber = $phoneNumber;
        $this->messageBody = $messageBody;
    }

    public function notify() {
        echo "Sending SMS to {$this->phoneNumber} with message: '{$this->messageBody}'\n";
    }
}
?>
