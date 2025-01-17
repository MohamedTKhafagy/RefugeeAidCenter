<?php
<<<<<<< Updated upstream

namespace RefugeeAidCenter\Proxy;

class SecureUserDataProxy implements UserData
{
    private UserData $realUserData;
    private array $requiredPermissions = [
        'getUserDetails' => 'read_user',
        'getAllUsers' => 'read_all_users',
        'updateUserDetails' => 'update_user',
        'addUser' => 'create_user',
        'deleteUser' => 'delete_user'
    ];

    public function __construct(UserData $realUserData)
    {
        $this->realUserData = $realUserData;
    }

    public function getUserDetails(int $UserId): ?array
    {
        if (!$this->hasPermission($this->requiredPermissions[__FUNCTION__])) {
            return null;
=======
namespace RefugeeAidCenter\Proxy;

class SecureUserDataProxy implements UserData {
    private UserData $realUserData;
    private ?int $currentUserId;
    private array $userRoles = [];
    private $db;

    private const ROLE_ADMIN = 1;
    private const ROLE_MANAGER = 2;
    private const ROLE_USER = 3;

    private array $operationPermissions = [
        'getUserDetails' => [self::ROLE_ADMIN, self::ROLE_MANAGER],
        'getAllUsers' => [self::ROLE_ADMIN],
        'updateUserDetails' => [self::ROLE_ADMIN],
        'addUser' => [self::ROLE_ADMIN],
        'deleteUser' => [self::ROLE_ADMIN]
    ];

    public function __construct(UserData $realUserData, ?int $currentUserId = null) 
    {
        $this->realUserData = $realUserData;
        $this->currentUserId = $currentUserId;
        $this->db = \DbConnection::getInstance();
        $this->loadUserRoles();
    }

    private function loadUserRoles(): void 
    {
        if ($this->currentUserId === null) return;

        $sql = "SELECT role FROM users WHERE id = ?";
        $stmt = $this->db->database_connection->prepare($sql);
        $stmt->bind_param("i", $this->currentUserId);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        
        if ($user) {
            $this->userRoles[] = $user['role'];
        }
    }

    public function hasPermission(string $operation): bool 
    {
        if (!isset($this->operationPermissions[$operation])) {
            return false;
        }

        // Allow users to access their own data
        if ($operation === 'getUserDetails' && 
            $this->currentUserId !== null && 
            isset($this->requestedUserId) && 
            $this->currentUserId === $this->requestedUserId) {
            return true;
        }

        return !empty(array_intersect($this->userRoles, $this->operationPermissions[$operation]));
    }

    public function getUserDetails(int $UserId): ?array 
    {
        $this->requestedUserId = $UserId;
        if (!$this->hasPermission(__FUNCTION__)) {
            throw new \RuntimeException("Access denied");
>>>>>>> Stashed changes
        }
        return $this->realUserData->getUserDetails($UserId);
    }

<<<<<<< Updated upstream
    public function getAllUsers(): array
    {
        if (!$this->hasPermission($this->requiredPermissions[__FUNCTION__])) {
            return [];
=======
    public function getAllUsers(): array 
    {
        if (!$this->hasPermission(__FUNCTION__)) {
            throw new \RuntimeException("Access denied");
>>>>>>> Stashed changes
        }
        return $this->realUserData->getAllUsers();
    }

<<<<<<< Updated upstream
    public function updateUserDetails(int $UserId, array $data): bool
    {
        if (!$this->hasPermission($this->requiredPermissions[__FUNCTION__])) {
            return false;
=======
    public function updateUserDetails(int $UserId, array $data): bool 
    {
        $this->requestedUserId = $UserId;
        if (!$this->hasPermission(__FUNCTION__)) {
            throw new \RuntimeException("Access denied");
>>>>>>> Stashed changes
        }
        return $this->realUserData->updateUserDetails($UserId, $data);
    }

<<<<<<< Updated upstream
    public function addUser(array $data): int|false
    {
        if (!$this->hasPermission($this->requiredPermissions[__FUNCTION__])) {
            return false;
=======
    public function addUser(array $data): int|false 
    {
        if (!$this->hasPermission(__FUNCTION__)) {
            throw new \RuntimeException("Access denied");
>>>>>>> Stashed changes
        }
        return $this->realUserData->addUser($data);
    }

<<<<<<< Updated upstream
    public function deleteUser(int $UserId): bool
    {
        if (!$this->hasPermission($this->requiredPermissions[__FUNCTION__])) {
            return false;
        }
        return $this->realUserData->deleteUser($UserId);
    }

    public function hasPermission(string $operation): bool
    {
        // Implement actual permission checking logic here
        // This could involve checking session, database, or other authentication mechanisms
        return $this->realUserData->hasPermission($operation);
    }
=======
    public function deleteUser(int $UserId): bool 
    {
        $this->requestedUserId = $UserId;
        if (!$this->hasPermission(__FUNCTION__)) {
            throw new \RuntimeException("Access denied");
        }
        return $this->realUserData->deleteUser($UserId);
    }
>>>>>>> Stashed changes
}