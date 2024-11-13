<?php
//order matters
include_once "SingletonDB.php";
include_once "Subject.php";
include_once "Observer.php";
include_once "Communication.php";
include_once "Message.php";
include_once "Models\UserModel.php";
include_once "Event.php";
include_once "EventAdmin.php";

// SingletonDBTest.php

$db1 = DbConnection::getInstance();
$db2 = DbConnection::getInstance();

if ($db1 === $db2) {
    echo "Singleton pattern works, same instance returned.\n";
} else {
    echo "Different instances returned.\n";
}

// test Message.php

$scheduleDate = new DateTime('2024-11-15 10:00:00');
$message = new Message(1, "This is a test message.", $scheduleDate, "High", "Test Subject", "user@example.com");

echo $message->__toString(); 

// test Event.php and EventAdmin.php

$event = new Event(1, "Charity Event", "Hall A", "Fundraising", 100, 50, new DateTime('2024-11-15 15:00:00'), [], []);

$admin = new EventAdmin();
$admin->RegisterEvent($event);

$newEvent = new Event(1, "Updated Charity Event", "Hall B", "Fundraising", 100, 60, new DateTime('2024-11-16 18:00:00'), [], []);
echo $admin->updateEvent(1, $newEvent); // Should return "Event updated successfully"

echo $admin->deleteEvent(1); // Should return "Event marked as deleted"

// test Communication.php

$smsCommunication = new Communication(0, "1234567890", "", "", "Test SMS message");
$smsCommunication->Send(); // Should output: "Sending SMS to 1234567890 with message: 'Test SMS message'"

$emailCommunication = new Communication(1, "", "test@example.com", "Test Subject", "Test email message");
$emailCommunication->Send(); // Should output: "Sending Email to test@example.com with subject: 'Test Subject' and message: 'Test email message'"


// test ObserverTest.php

$adminObserver = new EventAdmin();

$smsCommunication = new Communication(0, "1234567890", "", "", "Test SMS message");
$smsCommunication->RegisterObserver($adminObserver);

$smsCommunication->Send();

// test userModel.php

$eventAdmin = new EventAdmin();
echo $eventAdmin->getCurrentCapacity(1);