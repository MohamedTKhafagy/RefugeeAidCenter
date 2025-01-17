<?php
require_once 'Subject.php';
require_once 'Observer.php';
require_once 'EmailNotifier.php';

class CommunicationModel implements Subject {
    private $observers = []; // List of user observers

    public function RegisterObserver(Observer $observer) {
        $this->observers[] = $observer;
    }

    public function RemoveObserver(Observer $observer) {
        $index = array_search($observer, $this->observers, true);
        if ($index !== false) {
            unset($this->observers[$index]);
        }
    }

    public function NotifyObservers($eventData) {
        $subject = $eventData['subject'];
        $message = $eventData['message'];
        $recipients = $eventData['recipients'];

        $mailer = new MailerFacade();
        foreach ($recipients as $email) {
            $mailer->sendEmail($email, $subject, $message);
        }
    }

    public function loadObserversForEvent($eventId) {
        $db = DbConnection::getInstance();
        $eventId = $db->escape($eventId);

        $sql = "
            SELECT u.email
            FROM Event_Registrations er
            JOIN User u ON er.user_id = u.id
            WHERE er.event_id = '$eventId' AND er.is_deleted = 0
        ";
        $result = $db->query($sql);
        if (!$result) {
            throw new Exception("Error fetching event user emails.");
        }

        $emails = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $emails[] = $row['email'];
        }

        return $emails;
    }

    public function notifyEventObservers($eventId, $subject, $message) {
        $recipients = $this->loadObserversForEvent($eventId);

        $eventData = [
            'subject' => $subject,
            'message' => $message,
            'recipients' => $recipients,
        ];

        $this->NotifyObservers($eventData);
    }
}
?>
