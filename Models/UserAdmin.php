<?php

require_once __DIR__ . '/../Proxy/SecureUserDataProxy.php';
require_once __DIR__ . '/UserModel.php';

use RefugeeAidCenter\Proxy\SecureUserDataProxy;

class UserAdmin
{
    private SecureUserDataProxy $secureUserDataProxy;

  // Added the current user ID to the constructor so we can track it for later use 
    public function __construct(User $user, int $currentUserId)
    {
    $this->secureUserDataProxy = new SecureUserDataProxy($user, $currentUserId);
    }

    public function getUserDetails(int $UserId): ?array
    {
        return $this->secureUserDataProxy->getUserDetails($UserId);
    }

    public function getAllUsers(): array
    {
        return $this->secureUserDataProxy->getAllUsers();
    }

    public function updateUserDetails(int $UserId, array $data): bool
    {
        return $this->secureUserDataProxy->updateUserDetails($UserId, $data);
    }

    public function addUser(array $data): int|false
    {
        return $this->secureUserDataProxy->addUser($data);
    }

    public function deleteUser(int $UserId): bool
    {
        return $this->secureUserDataProxy->deleteUser($UserId);
    }
}