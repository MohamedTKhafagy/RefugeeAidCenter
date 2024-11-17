<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    include_once "controllers/CommunicationController.php";
    $controller = new CommunicationController();
    $controller->handleFormSubmit();
} else {
    include_once "views/SendMessageView.php";
}
?>
