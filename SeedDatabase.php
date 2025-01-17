<?php
require_once "SingletonDB.php";

$db = DbConnection::getInstance();

try {
    // Seed Address Table
    // $db->query("
    //     INSERT INTO Address (Name) VALUES
    //     ('City A'), ('City B'), ('City C')
    // ");
    // echo "Addresses seeded successfully.\n";

    // // Seed User Table
    // $db->query("
    //     INSERT INTO User (Name, Age, Gender, Address, Phone, Nationality, Type, Email, Preference) VALUES
    //     ('John Doe', 30, 1, 1, '123456789', 'Country A', 0, 'john.doe@example.com', 1),
    //     ('Jane Smith', 25, 0, 2, '987654321', 'Country B', 1, 'jane.smith@example.com', 0),
    //     ('Ali Khan', 40, 1, 3, '555555555', 'Country C', 1, 'ali.khan@example.com', 1)
    // ");
    // echo "Users seeded successfully.\n";

    // // Seed Refugee Table
    // $db->query("
    //     INSERT INTO Refugee (PassportNumber, Advisor, Shelter, HealthCare, UserId) VALUES
    //     ('A12345', 1, 1, 1, 1),
    //     ('B67890', 2, 2, 2, 2),
    //     ('C54321', 3, 3, 3, 3)
    // ");
    // echo "Refugees seeded successfully.\n";

    // Seed Inventory Table
    // $db->query("
    //     INSERT INTO INVENTORY (Money, ClothesQuantity, FoodResourcesQuantity) VALUES
    //     (10000, 500, 300)
    // ");
    // echo "Inventory seeded successfully.\n";

    // Seed Requests Table
    $db->query("
        INSERT INTO requests (RefugeeId, Name, Description, Type, Quantity, Status, UserId) VALUES
        (1, 'Food Request', 'Requesting food for the family', 'Food', 49, 'Draft',4),
        (1, 'Money Request', 'Financial assistance required', 'Money', 390, 'Accepted',4)
    ");
    echo "Requests seeded successfully.\n";
//     $db->query("
//     ALTER TABLE requests
//     ADD COLUMN UserId INT NOT NULL,
//     ADD CONSTRAINT FK_UserId FOREIGN KEY (UserId) REFERENCES User(Id) ON DELETE CASCADE;
// ");
// echo "Requests seeded successfully.\n";


} catch (Exception $e) {
    echo "Error seeding data: " . $e->getMessage() . "\n";
}
?>
