<?php
interface CommunicationStrategy {
    public function notify();
}


class EmailCommunication implements CommunicationStrategy {
    private $email;
    private $subject;
    private $message;

    public function __construct($email, $subject, $message) {
        $this->email = $email;
        $this->subject = $subject;
        $this->message = $message;
    }

    public function notify() {
        $mailer = new MailerFacade();
        $mailer->sendEmail($this->email, $this->subject, $this->message);
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
