<?php 
class SecureUserDataProxy implements UserData {
    private $userModel;
    
    public function __construct(User $userModel) {
        $this->userModel = $userModel;
    }
    
     // Check if current user is admin (type = 8)
     private function verifyAdminAccess(): bool {
        return $this->userModel->getType() == 8;
    }
    
    // Retrieve the actual user data if access is granted
    private function retrieveRealData($userId): ?User {
        if ($this->verifyAdminAccess()) {
            return $this->userModel;
        }
        return null;
    }
    
    // Implementation of the interface method with access control
    public function displayUserDetails($userId): string {
        if ($this->verifyAdminAccess()) {
            $db = DbConnection::getInstance();
            $sql = "SELECT * FROM User WHERE Id = $userId";
            $result = $db->fetchAll($sql);
            
            if (!empty($result)) {
                $userData = $result[0];
                return "User Details: \nName: {$userData['Name']}\n" .
                       "Age: {$userData['Age']}\n" .
                       "Email: {$userData['Email']}\n" .
                       "Phone: {$userData['Phone']}";
            }
            return "User not found";
        }
        return "Access Denied: Only administrators can view user details.";
    }
    public function deleteUser(int $userId): bool {
        if ($this->verifyAdminAccess()) {
            $db = DbConnection::getInstance();
            $sql = "UPDATE User SET isDeleted = 1 WHERE Id = $userId";
            return $db->query($sql);
        }
        return false;
    }
}
