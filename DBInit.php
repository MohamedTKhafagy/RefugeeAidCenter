<?php
require_once "SingletonDB.php";
//This file is to create the tables if running for the first time 
$db = DbConnection::getInstance();

$db->query("
   CREATE TABLE IF NOT EXISTS Address (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(30),
    ParentId INT,
    FOREIGN KEY (ParentId) REFERENCES Address(Id)
); 
");
$db->query("
   CREATE TABLE IF NOT EXISTS User (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255) NOT NULL,
    Age INT,
    Gender INT,
    Address INT,
    Phone VARCHAR(20),
    Nationality VARCHAR(30),
    Type INT, 
    Email VARCHAR(255) UNIQUE,
    Preference INT,
    IsDeleted INT DEFAULT 0,
    FOREIGN KEY (Address) REFERENCES Address(Id)
); 
");
$db->query("
   CREATE TABLE IF NOT EXISTS Donation (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Amount INT,
    Type INT,
    DirectedTo INT,
    Collection INT,
    Currency INT
);
");

$db->query("
    CREATE TABLE IF NOT EXISTS DonatorDonation (
     DonatorId INT NOT NULL,
     DonationId INT NOT NULL,
     PRIMARY KEY (DonatorId, DonationId),
     FOREIGN KEY (DonatorId) REFERENCES User(Id),
     FOREIGN KEY (DonationId) REFERENCES Donation(Id)
);
");
$db->query("
    CREATE TABLE IF NOT EXISTS INVENTORY (
     Money INT NOT NULL,
     ClothesQuantity INT NOT NULL,
     FoodResourcesQuantity INT NOT NULL
);
");  

// Modified Facility table to use VARCHAR for Name
$db->query("
    CREATE TABLE IF NOT EXISTS Facility (
     Id INT AUTO_INCREMENT PRIMARY KEY,
     Name VARCHAR(255),  
     Address INT,  
     Type INT,
     IsDeleted INT DEFAULT 0
);
"); 

$db->query("
    CREATE TABLE IF NOT EXISTS HOSPITAL (
     HospitalId INT NOT NULL PRIMARY KEY,
     MaxCapacity INT,
     CurrentCapacity INT,
     insuranceType INT,
     Supervisor VARCHAR(255), 
     FOREIGN KEY (HospitalId) REFERENCES Facility(Id)
);
");

$db->query("
    CREATE TABLE user_roles (
    user_id INT,
    role VARCHAR(50),
    PRIMARY KEY (user_id, role),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

");
$db->query("
    CREATE TABLE permissions (
    role VARCHAR(50),
    permission VARCHAR(50),
    granted BOOLEAN,
    PRIMARY KEY (role, permission)
);
");

?>