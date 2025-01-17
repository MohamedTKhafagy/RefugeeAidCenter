<?php 
class SecureUserDataProxy implements UserData {
    private $userModel;
    private $admin;
    
    public function __construct(User $userModel, UserAdmin $admin) {
        $this->userModel = $userModel;
        $this->admin = $admin;
    }
    
    // Verify if the admin has proper access
    private function verifyAdminAccess(): bool {
        return $this->admin->checkAccess();
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
            $user = $this->retrieveRealData($userId);
            if ($user !== null) {
                return $user->displayInfo();
            }
        }
        return "Access Denied: Insufficient permissions to view user details.";
    }
}
