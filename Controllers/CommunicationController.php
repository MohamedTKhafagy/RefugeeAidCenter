<?php
include_once __DIR__ . '/../Models/CommunicationModel.php';
include_once __DIR__ . '/../Models/Observer.php';
require_once __DIR__ . '/../MailerFacade.php';
require_once __DIR__ . '/../SMSFacade.php';

class CommunicationController {
    public function notifyEventUsers($eventId, $subject, $message) {
        try {
            // Create a CommunicationModel instance and notify all event users
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

        // Validate required inputs
        if (!$type || !$messageBody) {
            die("Type and Message Body are required.");
        }

        try {
            $communicationModel = new CommunicationModel();

            if ($eventId) {
                // Notify all users registered for the event
                if ($type === 'Email') {
                    $communicationModel->notifyEventObservers($eventId, $subject, $messageBody);
                } elseif ($type === 'SMS') {
                    echo "SMS functionality for event notifications is not yet implemented.";
                }
            } else {
                // Notify a single user
                if ($type === 'Email') {
                    if (!$email) {
                        throw new Exception("Email address is required for single user notification.");
                    }
                    $mailer = new MailerFacade();
                    $mailer->sendEmail($email, $subject, $messageBody);
                } elseif ($type === 'SMS') {
                    if (!$phoneNumber) {
                        throw new Exception("Phone number is required for single user notification.");
                    }
                    $sms = new SMSFacade();
                    $sms->sendSMS($phoneNumber, $messageBody);
                }
            }

            header("Location: ../Views/view_messages.php?status=success");
            exit;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

// Handle direct form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new CommunicationController();
    $controller->handleFormSubmit($_POST);
} else {
    echo "Invalid request method.";
}
?>
