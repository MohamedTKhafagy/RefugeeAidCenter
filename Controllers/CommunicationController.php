<?php
include_once "../models/CommunicationModel.php";
include_once "../models/Observer.php";

class CommunicationController {
    public function handleFormSubmit() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $type = $_POST['Type']; // SMS or Email
            $messageBody = $_POST['MessageBody'];
            $phoneNumber = $_POST['PhoneNumber'] ?? null;
            $email = $_POST['Email'] ?? null;
            $subject = $_POST['Subject'] ?? null;

            $communication = new CommunicationModel($type, $messageBody, $phoneNumber, $email, $subject);

            $userAdmin = new UserAdmin("John Doe");
            $eventAdmin = new EventAdmin("Jane Smith");
            $refugeeAdmin = new RefugeeAdmin("Ali Hussein");

            $communication->registerObserver($userAdmin);
            $communication->registerObserver($eventAdmin);
            $communication->registerObserver($refugeeAdmin);

            $communication->send();

            header("Location: ../views/view_messages.php?status=success");
            exit;
        }
    }
}
?>
