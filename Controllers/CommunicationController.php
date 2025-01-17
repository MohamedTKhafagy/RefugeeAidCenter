<?php
include_once __DIR__ . '/../Models/CommunicationModel.php';
include_once __DIR__ . '/../Models/Observer.php';
require_once __DIR__ . '/../MailerFacade.php';
require_once __DIR__ . '/../SMSFacade.php';
require_once __DIR__ . '/../Models/CommunicationStrategy.php';

class CommunicationController {
    public function notifyEventUsers($eventId, $subject, $message) {
        try {
            $communicationModel = new CommunicationModel();
            $communicationModel->notifyEventObservers($eventId, $subject, $message);
            echo "Notifications sent successfully!";
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function handleFormSubmit($data) {
        $type = $data['Type'] ?? null;
        $messageBody = $data['MessageBody'] ?? null;
        $eventId = $data['EventId'] ?? null;
        $email = $data['Email'] ?? null;
        $phoneNumber = $data['PhoneNumber'] ?? null;
        $subject = $data['Subject'] ?? 'Default Subject';

        if (!$type || !$messageBody) {
            die("Type and Message Body are required.");
        }

        try {
            $commStrategy = new CommunicationContext();

            if ($eventId) {
                if ($type === 'Email') {
                    $communicationModel = new CommunicationModel();
                    $communicationModel->notifyEventObservers($eventId, $subject, $messageBody);
                } elseif ($type === 'SMS') {
                    echo "SMS functionality for event notifications is not yet implemented.";
                }
            } else {
                if ($type === 'Email') {
                    if (!$email) {
                        throw new Exception("Email address is required for single user notification.");
                    }
                    $commStrategy->setStrategy(new EmailCommunication($email, $subject, $messageBody));
                } elseif ($type === 'SMS') {
                    if (!$phoneNumber) {
                        throw new Exception("Phone number is required for single user notification.");
                    }
                    $commStrategy->setStrategy(new SMSCommunication($phoneNumber, $messageBody));
                }

                $commStrategy->executeStrategy();
            }

            header("Location: ../Views/view_messages.php?status=success");
            exit;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}


?>
