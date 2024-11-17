<?php
require_once "SingletonDB.php";

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

$db->query("
    CREATE TABLE IF NOT EXISTS Facility (
     Id INT AUTO_INCREMENT PRIMARY KEY,
     Name INT,
     Address INT,
     Type INT,
     IsDeleted INT DEFAULT 0,
     FOREIGN KEY (Address) REFERENCES Address(Id)
);
"); 

$db->query("
    CREATE TABLE IF NOT EXISTS Event (
     Id INT AUTO_INCREMENT PRIMARY KEY,
     Name VARCHAR(255) NOT NULL,
     Location VARCHAR(255),
     Type INT,
     MaxCapacity INT,
     CurrentCapacity INT,
     Date DATETIME,
     Volunteers INT,
     Attendees INT,
     IsDeleted INT DEFAULT 0
);
");

$db->query("
    CREATE TABLE IF NOT EXISTS CommunicationLog (
     Id INT AUTO_INCREMENT PRIMARY KEY,
     Type INT, -- 0: SMS, 1: Email
     Recipient VARCHAR(255),
     Subject VARCHAR(255),
     MessageBody TEXT,
     Status VARCHAR(50),
     SentAt DATETIME DEFAULT CURRENT_TIMESTAMP,
     IsDeleted INT DEFAULT 0
);
");
?>