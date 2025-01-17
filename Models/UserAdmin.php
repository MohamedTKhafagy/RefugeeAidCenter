<?php
class UserAdmin {
    private $proxy;
    
    public function __construct(UserData $proxy) {
        $this->proxy = $proxy;
    }
    
    // Create new user
    public function createUser($userData): bool {
        $db = DbConnection::getInstance();
        $query = "INSERT INTO User (Name, Age, Gender, Address, Phone, Nationality, Type, Email, Preference) 
                 VALUES (
                    '{$userData['Name']}',
                    {$userData['Age']},
                    {$userData['Gender']},
                    {$userData['Address']},
                    '{$userData['Phone']}',
                    '{$userData['Nationality']}',
                    {$userData['Type']},
                    '{$userData['Email']}',
                    {$userData['Preference']}
                 )";
        return $db->query($query) ? true : false;
    }
    
    // Read user details
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
                 WHERE Id = $userId";
        return $db->query($query) ? true : false;
    }
    
    // Delete user
    public function deleteUser($userId): bool {
        $db = DbConnection::getInstance();
        $query = "DELETE FROM User WHERE Id = $userId";
        return $db->query($query) ? true : false;
    }

    // List all users
    public function listAllUsers(): array {
        $db = DbConnection::getInstance();
        $sql = "SELECT Id, Name, Email, Type FROM User";
        return $db->fetchAll($sql);
    }
}