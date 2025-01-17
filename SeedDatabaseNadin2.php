<?php
require_once "SingletonDB.php";

$db = DbConnection::getInstance();

try {
    // Seed Address Table
    $db->query("
INSERT INTO User (Name, Age, Gender, Address, Phone, Nationality, Type, Email, Preference, IsDeleted)
VALUES ('Ahmed Wael', 30, 0, NULL, '1234567890', 'Egyptian', 8, 'medopc2625@gmail.com', NULL, 0);
    ");
    echo "Addresses seeded successfully.\n";

    // Seed User Table
    $db->query("
INSERT INTO Events (name, location, type, max_capacity, current_capacity, date)
VALUES ('Birthday Event', 'Cairo', 1, 100, 0, '2025-12-25');
    ");
    echo "Users seeded successfully.\n";

    // Seed Refugee Table
    $db->query("
INSERT INTO Event_Registrations (event_id, user_id, status, is_deleted)
VALUES (2, 3, 'registered', 0);
    ");
    echo "Refugees seeded successfully.\n";

    // Seed Inventory Table

} catch (Exception $e) {
    echo "Error seeding data: " . $e->getMessage() . "\n";
}
?>
