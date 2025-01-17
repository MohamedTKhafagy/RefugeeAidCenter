<?php

class UserAdmin {
    private $proxy;
    
    public function __construct(UserData $proxy) {
        $this->proxy = $proxy;
    }
    
    // Create new user
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
    
    // Read user details (excluding deleted users)
    public function readUser($userId): string {
        return $this->proxy->displayUserDetails($userId);
    }
    
    // Update user
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
    
    // Soft delete user
    public function deleteUser($userId): bool {
        $db = DbConnection::getInstance();
        $query = "UPDATE User SET IsDeleted = 1 WHERE Id = $userId";
        return $db->query($query) ? true : false;
    }

    // List all active users
    public function listAllUsers(): array {
        $db = DbConnection::getInstance();
        $sql = "SELECT u.Id, u.Name, u.Email, u.Type, u.Phone, u.Age, u.Gender, 
                       a.Name as AddressName 
                FROM User u 
                LEFT JOIN Address a ON u.Address = a.Id 
                WHERE u.IsDeleted = 0";
        return $db->fetchAll($sql);
    }
}