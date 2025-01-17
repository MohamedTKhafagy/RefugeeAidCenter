<?php
<<<<<<< Updated upstream

namespace RefugeeAidCenter\Proxy;

interface UserData
{
    /**
     * Get User details by ID
     * @param int $userId
     * @return array|null
     */
    public function getUserDetails(int $UserId): ?array;

    /**
     * Get all Users
     * @return array
     */
    public function getAllUsers(): array;

    /**
     * Update User details
     * @param int $UserId
     * @param array $data
     * @return bool
     */
    public function updateUserDetails(int $UserId, array $data): bool;

    /**
     * Add new User
     * @param array $data
     * @return int|false
     */
    public function addUser(array $data): int|false;

    /**
     * Delete User
     * @param int $UserId
     * @return bool
     */
    public function deleteUser(int $UserId): bool;

    /**
     * Check if user has permission for operation
     * @param string $operation
     * @return bool
     */
    public function hasPermission(string $operation): bool;
}
=======
// 1. UserData.php (Interface)
namespace RefugeeAidCenter\Proxy;

interface UserData {
    public function getUserDetails(int $UserId): ?array;
    public function getAllUsers(): array;
    public function updateUserDetails(int $UserId, array $data): bool;
    public function addUser(array $data): int|false;
    public function deleteUser(int $UserId): bool;
    public function hasPermission(string $operation): bool;
}
>>>>>>> Stashed changes
