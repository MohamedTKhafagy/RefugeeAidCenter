<?php

require_once __DIR__ . '/../Proxy/SecureUserDataProxy.php';
require_once __DIR__ . '/UserModel.php';

use RefugeeAidCenter\Proxy\SecureUserDataProxy;

class UserAdmin
{
    private SecureUserDataProxy $secureUserDataProxy;

    public function __construct(User $user)
    {
        $this->secureUserDataProxy = new SecureUserDataProxy($user);
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