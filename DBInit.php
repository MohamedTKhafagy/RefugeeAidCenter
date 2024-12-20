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
     Name  VARCHAR(255),
     Address INT,
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

$db->query("
    CREATE TABLE IF NOT EXISTS Refugee (
        Id INT AUTO_INCREMENT PRIMARY KEY,
        PassportNumber VARCHAR(255),
        Advisor INT,
        Shelter INT,
        HealthCare INT,
        UserId INT,
        FOREIGN KEY (UserId) REFERENCES User(Id) ON DELETE CASCADE,
        FOREIGN KEY (Advisor) REFERENCES User(Id)

    );
");

$db->query("
    CREATE TABLE IF NOT EXISTS Adult (
        Id INT AUTO_INCREMENT PRIMARY KEY,
        Profession VARCHAR(255),
        Education VARCHAR(255),
        RefugeeId INT,
        FOREIGN KEY (RefugeeId) REFERENCES Refugee(Id) ON DELETE CASCADE
    );
    ");

$db->query("
    CREATE TABLE IF NOT EXISTS Child (
        Id INT AUTO_INCREMENT PRIMARY KEY,
        SchoolId INT,
        Level INT,
        Guardian INT,
        RefugeeId INT,
        FOREIGN KEY (RefugeeId) REFERENCES Refugee(Id) ON DELETE CASCADE
    );
");


$db->query("
    CREATE TABLE IF NOT EXISTS adult_family (
        AdultId INT,
        FamilyId INT,
        PRIMARY KEY (AdultId, FamilyId),
        FOREIGN KEY (AdultId) REFERENCES Adult(Id),
        FOREIGN KEY (FamilyId) REFERENCES Refugee(Id)
    );
");

// Volunteer Table (Extends User)
$db->query("
   CREATE TABLE IF NOT EXISTS Volunteer (
    VolunteerId INT PRIMARY KEY, -- Matches User.Id
    Skills ENUM('Medical', 'Teaching', 'Counseling', 'Translation', 'Logistics', 'Fundraising') NOT NULL,
    Availability ENUM('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday') NOT NULL,
    FOREIGN KEY (VolunteerId) REFERENCES User(Id)
);
");
$db->query("
    CREATE TABLE IF NOT EXISTS Task (
        Id INT AUTO_INCREMENT PRIMARY KEY,
        Name VARCHAR(255) NOT NULL,
        Description TEXT,
        SkillRequired VARCHAR(255),
        HoursOfWork INT,
        AssignedVolunteerId INT,
        IsDeleted BOOLEAN DEFAULT 0,
        IsCompleted BOOLEAN DEFAULT 0,
        FOREIGN KEY (AssignedVolunteerId) REFERENCES User(Id)
    );
");
/*

$db->query("
    CREATE TABLE IF NOT EXISTS Facility (
     Id INT AUTO_INCREMENT PRIMARY KEY,
     Name VARCHAR(255) NOT NULL, -- Facility name
     Address INT,
     Type INT,
     IsDeleted INT DEFAULT 0,
     FOREIGN KEY (Address) REFERENCES Address(Id)
);
");
// Shelter Table (Extends Facility)
$db->query("
   CREATE TABLE IF NOT EXISTS Shelter (
    ShelterID INT PRIMARY KEY, -- Matches Facility.Id
    Supervisor INT, -- Supervisor linked to User.Id
    MaxCapacity INT NOT NULL, -- Maximum capacity of the shelter
    CurrentCapacity INT NOT NULL, -- Current occupancy
    FOREIGN KEY (ShelterID) REFERENCES Facility(Id), -- Links Shelter to Facility
    FOREIGN KEY (Supervisor) REFERENCES User(Id) -- Links Supervisor to a User
);
");

?>
*/
?>
