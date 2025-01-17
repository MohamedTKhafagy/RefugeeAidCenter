<?php

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
        }
        return $this->realUserData->getUserDetails($UserId);
    }

    public function getAllUsers(): array
    {
        if (!$this->hasPermission($this->requiredPermissions[__FUNCTION__])) {
            return [];
        }
        return $this->realUserData->getAllUsers();
    }

    public function updateUserDetails(int $UserId, array $data): bool
    {
        if (!$this->hasPermission($this->requiredPermissions[__FUNCTION__])) {
            return false;
        }
        return $this->realUserData->updateUserDetails($UserId, $data);
    }

    public function addUser(array $data): int|false
    {
        if (!$this->hasPermission($this->requiredPermissions[__FUNCTION__])) {
            return false;
        }
        return $this->realUserData->addUser($data);
    }

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
}