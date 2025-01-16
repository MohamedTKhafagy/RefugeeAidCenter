<?php
include_once __DIR__ . '/../Models/CommunicationModel.php';
include_once __DIR__ . '/../Models/Observer.php';
require_once __DIR__ . '/../MailerFacade.php';



class CommunicationController {
    // public function handleFormSubmit($data) {
    //         $type = $data['Type']; // SMS or Email
    //         $messageBody = $data['MessageBody'];
    //         $phoneNumber = $data['PhoneNumber'] ?? null;
    //         $email = $data['Email'] ?? null;
    //         $subject = $data['Subject'] ?? null;

    //         $communication = new CommunicationModel($type, $messageBody, $phoneNumber, $email, $subject);

    //         $userAdmin = new UserAdmin("John Doe",$communication);
    //         $eventAdmin = new EventAdmin("Jane Smith",$communication);
    //         $refugeeAdmin = new RefugeeAdmin("Ali Hussein",$communication);

    //         $communication->send();

    //         header("Location: ../views/view_messages.php?status=success");
    //         exit;

    // }

    public function handleFormSubmit($data) {
        $type = $data['Type']; // SMS or Email
        $messageBody = $data['MessageBody'] ?? null;
        $phoneNumber = $data['PhoneNumber'] ?? null;
        $email = $data['Email'] ?? null;
        $subject = $data['Subject'] ?? 'Default Subject';

        // Validate required fields
        if (!$messageBody || $type === 'Email' && (!$email || !$subject)) {
            echo "Invalid input. Please fill in all required fields.";
            return;
        }

        if ($type === 'Email') {
            // Use MailerFacade to send the email
            try {
                $mailer = new MailerFacade();
                $mailer->sendEmail($email, $subject, $messageBody);

                // Optionally, log the email sending success
                echo "Email sent successfully to {$email}.";
            } catch (Exception $e) {
                echo "Error sending email: " . $e->getMessage();
                return;
            }
        } elseif ($type === 'SMS') {
            // Handle SMS logic if needed
            echo "SMS sending is not yet implemented.";
        } else {
            echo "Unsupported communication type.";
            return;
        }

        // Redirect after successful operation
        header("Location: ../Views/view_messages.php?status=success");
        exit;
    }
}


?>
