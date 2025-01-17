<?php

class AdminUser {
    private $proxy;
    
    public function __construct(UserData $proxy) {
        $this->proxy = $proxy;
    }
    
    
    public function createUser($userData): bool {
        $db = DbConnection::getInstance();
        $query = "INSERT INTO User (Name, Age, Gender, Address, Phone, Nationality, Type, Email, Preference, IsDeleted) 
                 VALUES (
                    '{$userData['Name']}',
                    {$userData['Age']},
                    {$userData['Gender']},
                    {$userData['Address']},
                    '{$userData['Phone']}',
                    '{$userData['Nationality']}',
                    {$userData['Type']},
                    '{$userData['Email']}',
                    {$userData['Preference']},
                    0
                 )";
        return $db->query($query) ? true : false;
    }
    
    
    public function readUser($userId): string {
        return $this->proxy->displayUserDetails($userId);
    }
    
    
    public function updateUser($userId, $userData): bool {
        $db = DbConnection::getInstance();
        $query = "UPDATE User SET 
                    Name = '{$userData['Name']}',
                    Age = {$userData['Age']},
                    Gender = {$userData['Gender']},
                    Address = {$userData['Address']},
                    Phone = '{$userData['Phone']}',
                    Nationality = '{$userData['Nationality']}',
                    Type = {$userData['Type']},
                    Email = '{$userData['Email']}',
                    Preference = {$userData['Preference']}
                 WHERE Id = $userId AND IsDeleted = 0";
        return $db->query($query) ? true : false;
    }
    
    
    public function deleteUser($userId): bool {
        $db = DbConnection::getInstance();
        $query = "UPDATE User SET IsDeleted = 1 WHERE Id = $userId";
        return $db->query($query) ? true : false;
    }

    
    public function listAllUsers(): array {
        $db = DbConnection::getInstance();
        $sql = "SELECT u.Id, u.Name, u.Email, u.Type, u.Phone, u.Age, u.Gender, 
                       a.Name as AddressName 
                FROM User u 
                LEFT JOIN Address a ON u.Address = a.Id 
                WHERE u.IsDeleted = 0";
        return $db->fetchAll($sql);
    }

      
      public function listAllEvents(): array {
        $db = DbConnection::getInstance();
        $sql = "SELECT * FROM Events WHERE is_deleted = 0";
        return $db->fetchAll($sql);
    }

    public function updateEvent($eventId, $data): bool {
        $db = DbConnection::getInstance();
        $query = "UPDATE Events SET 
                    name = '{$data['name']}',
                    location = '{$data['location']}',
                    type = {$data['type']},
                    max_capacity = {$data['max_capacity']},
                    date = '{$data['date']}'
                 WHERE id = $eventId";
        return $db->query($query) ? true : false;
    }

    
    public function listAllTasks(): array {
        $db = DbConnection::getInstance();
        $sql = "SELECT t.*, u.Name as VolunteerName 
                FROM Tasks t 
                LEFT JOIN User u ON t.volunteer_id = u.Id 
                WHERE t.is_deleted = 0";
        return $db->fetchAll($sql);
    }

    public function updateTask($taskId, $data): bool {
        $db = DbConnection::getInstance();
        // $query = "UPDATE Tasks SET 
        //             name = '{$data['Name']}',
        //             description = '{$data['Description']}',
        //             SkillRequired = '{$data['SkillRequired']}',
        //             HoursOfWork = {$data['HoursOfWork']},
        //             AssignedVolunteerId = {$data['AssignedVolunteerId']},
        //             IsCompleted = {$data['IsCompleted']}
        //          WHERE Id = $taskId";
        $query = "UPDATE Tasks SET 
        name = ?, 
        description = ?, 
        hours_of_work = ?,
        status = ?,
        event_id = ?,
        volunteer_id = ?
        WHERE id = ?";
        return $db->query($query) ? true : false;
    }

    
    public function listAllDonations(): array {
        $db = DbConnection::getInstance();
        $sql = "SELECT d.*, u.Name as DonorName 
                FROM Donation d 
                LEFT JOIN User u ON d.DirectedTo = u.Id";
        return $db->fetchAll($sql);
    }

    public function updateDonation($donationId, $data): bool {
        $db = DbConnection::getInstance();
        $query = "UPDATE Donation SET 
                    Amount = {$data['Amount']},
                    Type = {$data['Type']},
                    DirectedTo = {$data['DirectedTo']},
                    Collection = {$data['Collection']},
                    Currency = {$data['Currency']}
                 WHERE Id = $donationId";
        return $db->query($query) ? true : false;
    }
    public function getUserById($userId) {
        $db = DbConnection::getInstance();
        $sql = "SELECT * FROM User WHERE Id = $userId AND IsDeleted = 0";
        $result = $db->fetchAll($sql);
        return $result[0] ?? null;
    }

    public function getEventById($eventId) {
        $db = DbConnection::getInstance();
        $sql = "SELECT * FROM Events WHERE id = $eventId AND is_deleted = 0";
        $result = $db->fetchAll($sql);
        return $result[0] ?? null;
    }

    public function getTaskById($taskId) {
        $db = DbConnection::getInstance();
        $sql = "SELECT * FROM Task WHERE Id = $taskId AND IsDeleted = 0";
        $result = $db->fetchAll($sql);
        return $result[0] ?? null;
    }

    public function getDonationById($donationId) {
        $db = DbConnection::getInstance();
        $sql = "SELECT * FROM Donation WHERE Id = $donationId";
        $result = $db->fetchAll($sql);
        return $result[0] ?? null;
    }

    public function getVolunteers() {
        $db = DbConnection::getInstance();
        $sql = "SELECT Id, Name FROM User WHERE Type = 2 AND IsDeleted = 0"; // Type 2 for volunteers
        return $db->fetchAll($sql);
    }
    
}
