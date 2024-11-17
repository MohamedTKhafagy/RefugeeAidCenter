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
<<<<<<< HEAD
     Name  VARCHAR(255),
     Address INT,
=======
     Name VARCHAR(255),  
     Address INT,  
>>>>>>> origin/Osama
     Type INT,
     IsDeleted INT DEFAULT 0
);
");
$db->query("
    CREATE TABLE IF NOT EXISTS Hospital (
     HospitalId INT NOT NULL PRIMARY KEY,
     MaxCapacity INT,
     CurrentCapacity INT,
     insuranceType INT,
     Supervisor INT NOT NULL,
     FOREIGN KEY (HospitalId) REFERENCES Facility(Id),
     FOREIGN KEY (Supervisor) REFERENCES User(Id)
);
");
$db->query("
    CREATE TABLE IF NOT EXISTS School (
     SchoolId INT NOT NULL PRIMARY KEY,
     MaxCapacity INT,
     CurrentCapacity INT,
     Supervisor INT NOT NULL,
     FOREIGN KEY (SchoolId) REFERENCES Facility(Id),
     FOREIGN KEY (Supervisor) REFERENCES User(Id)
);
");
$db->query("
    CREATE TABLE IF NOT EXISTS Shelter (
     ShelterId INT NOT NULL PRIMARY KEY,
     MaxCapacity INT,
     CurrentCapacity INT,
     Supervisor INT NOT NULL,
     FOREIGN KEY (ShelterId) REFERENCES Facility(Id),
     FOREIGN KEY (Supervisor) REFERENCES User(Id)
);
");
$db->query("
    CREATE TABLE IF NOT EXISTS Doctor (
     Id INT PRIMARY KEY,
     Specialization VARCHAR(255),
     Availability INT,
     Hospital INT,
     FOREIGN KEY (Id) REFERENCES User(Id),
     FOREIGN KEY (HOSPITAL) REFERENCES Hospital(HospitalId)
);
");
$db->query("
    CREATE TABLE IF NOT EXISTS Nurse (
     Id INT PRIMARY KEY,
     Specialization VARCHAR(255),
     Availability INT,
     Hospital INT,
     FOREIGN KEY (Id) REFERENCES User(Id),
     FOREIGN KEY (Hospital) REFERENCES Hospital(HospitalId)
);
");
$db->query("
    CREATE TABLE IF NOT EXISTS Teacher (
     Id INT PRIMARY KEY,
     Subject VARCHAR(255),
     Availability INT,
     School INT,
     FOREIGN KEY (Id) REFERENCES User(Id),
     FOREIGN KEY (School) REFERENCES School(SchoolId)
);
");
$db->query("
    CREATE TABLE IF NOT EXISTS SocialWorker (
     Id INT PRIMARY KEY,
     Availability INT,
     Shelter INT,
     FOREIGN KEY (Id) REFERENCES User(Id),
     FOREIGN KEY (Shelter) REFERENCES Shelter(ShelterId)
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

?>