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
    VolunteerId INT PRIMARY KEY,
    Availability VARCHAR(255) NOT NULL,
    IsDeleted TINYINT(1) DEFAULT 0,
    FOREIGN KEY (VolunteerId) REFERENCES User(Id)
);
");

$db->query("
   CREATE TABLE IF NOT EXISTS Events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    location VARCHAR(255) NOT NULL,
    type INT NOT NULL,
    max_capacity INT NOT NULL,
    current_capacity INT NOT NULL DEFAULT 0,
    date DATE NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    is_deleted TINYINT(1) DEFAULT 0
);
");

$db->query("
   CREATE TABLE IF NOT EXISTS Tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    hours_of_work DECIMAL(5,2) NOT NULL,
    status VARCHAR(50) DEFAULT 'pending',
    event_id INT,
    volunteer_id INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    is_deleted TINYINT(1) DEFAULT 0,
    FOREIGN KEY (volunteer_id) REFERENCES User(Id),
    FOREIGN KEY (event_id) REFERENCES Events(id)
);
");

$db->query("
   CREATE TABLE IF NOT EXISTS SkillCategories (
       id INT AUTO_INCREMENT PRIMARY KEY,
       name VARCHAR(50) NOT NULL UNIQUE,
       description TEXT,
       created_at DATETIME DEFAULT CURRENT_TIMESTAMP
   );
");

$db->query("
   CREATE TABLE IF NOT EXISTS Skills (
       id INT AUTO_INCREMENT PRIMARY KEY,
       name VARCHAR(255) NOT NULL UNIQUE,
       category_id INT,
       description TEXT,
       created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
       FOREIGN KEY (category_id) REFERENCES SkillCategories(id)
   );
");

// Insert default categories
$db->query("
   INSERT IGNORE INTO SkillCategories (name) VALUES 
   ('Medical'),
   ('Teaching'),
   ('Counseling'),
   ('Translation'),
   ('Logistics'),
   ('Fundraising'),
   ('Other');
");

$db->query("
   CREATE TABLE IF NOT EXISTS Task_Skills (
    task_id INT NOT NULL,
    skill_id INT NOT NULL,
    PRIMARY KEY (task_id, skill_id),
    FOREIGN KEY (task_id) REFERENCES Tasks(id) ON DELETE CASCADE,
    FOREIGN KEY (skill_id) REFERENCES Skills(id) ON DELETE CASCADE
);
");

$db->query("
   CREATE TABLE IF NOT EXISTS Volunteer_Skills (
    volunteer_id INT NOT NULL,
    skill_id INT NOT NULL,
    PRIMARY KEY (volunteer_id, skill_id),
    FOREIGN KEY (volunteer_id) REFERENCES Volunteer(VolunteerId) ON DELETE CASCADE,
    FOREIGN KEY (skill_id) REFERENCES Skills(id) ON DELETE CASCADE
);
");

?>
*/