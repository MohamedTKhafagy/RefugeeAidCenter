<?php
include_once "../models/CommunicationModel.php";
include_once "../models/Observer.php";

class CommunicationController {
    public function handleFormSubmit($data) {
            $type = $data['Type']; // SMS or Email
            $messageBody = $data['MessageBody'];
            $phoneNumber = $data['PhoneNumber'] ?? null;
            $email = $data['Email'] ?? null;
            $subject = $data['Subject'] ?? null;

            $communication = new CommunicationModel($type, $messageBody, $phoneNumber, $email, $subject);

            $userAdmin = new UserAdmin("John Doe",$communication);
            $eventAdmin = new EventAdmin("Jane Smith",$communication);
            $refugeeAdmin = new RefugeeAdmin("Ali Hussein",$communication);

            $communication->send();

            header("Location: ../views/view_messages.php?status=success");
            exit;

    }
}
?>
