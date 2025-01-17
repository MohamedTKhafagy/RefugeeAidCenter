<?php
class UserAdmin {
    private $accessLevel;
    private $proxy;
    
    public function __construct(int $accessLevel) {
        $this->accessLevel = $accessLevel;
    }
    
    public function setProxy(UserData $proxy) {
        $this->proxy = $proxy;
    }
    
    // CRUD Operations
    public function createUser($userData): bool {
        if ($this->checkAccess()) {
            // Implementation for creating user
            return true;
        }
        return false;
    }
    
    public function readUser($userId): string {
        return $this->proxy->displayUserDetails($userId);
    }
    
    public function updateUser($userId, $userData): bool {
        if ($this->checkAccess()) {
            // Implementation for updating user
            return true;
        }
        return false;
    }
    
    public function deleteUser($userId): bool {
        if ($this->checkAccess()) {
            // Implementation for deleting user
            return true;
        }
        return false;
    }
    
    // Check if admin has required access level
    public function checkAccess(): bool {
        return $this->accessLevel >= 3; // Assuming 3 is minimum required level
    }
}