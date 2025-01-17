<?php
require_once "SingletonDB.php";

$db = DbConnection::getInstance();

try {
    // Seed Address Table
    $db->query("
INSERT INTO User (Name, Age, Gender, Address, Phone, Nationality, Type, Email, Preference, IsDeleted)
VALUES ('Ahmed Behairy', 30, 0, NULL, '1234567890', 'Egyptian', 0, 'ahmedbehairy10@gmail.com', NULL, 0);
    ");
    echo "Addresses seeded successfully.\n";

    // Seed User Table
    $db->query("
INSERT INTO Events (name, location, type, max_capacity, current_capacity, date)
VALUES ('Charity Event', 'Cairo', 1, 100, 0, '2025-12-25');
    ");
    echo "Users seeded successfully.\n";

    // Seed Refugee Table
    $db->query("
INSERT INTO Event_Registrations (event_id, user_id, status, is_deleted)
VALUES (1, 1, 'registered', 0);
    ");
    echo "Refugees seeded successfully.\n";

    // Seed Inventory Table
    $db->query("
INSERT INTO User (Name, Age, Gender, Address, Phone, Nationality, Type, Email, Preference, IsDeleted)
VALUES ('Nadin', 30, 0, NULL, '01151332456', 'Egyptian', 0, '20p8103@eng.asu.edu.eg', NULL, 0);
    ");
    echo "Inventory seeded successfully.\n";

    // Seed Requests Table
    $db->query("
INSERT INTO Event_Registrations (event_id, user_id, status, is_deleted)
VALUES (1, 2, 'registered', 0);
    ");
    echo "Requests seeded successfully.\n";

} catch (Exception $e) {
    echo "Error seeding data: " . $e->getMessage() . "\n";
}
?>
