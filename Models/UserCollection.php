<?php
require_once "Collection.php";
require_once "UserIterator.php";

class UserCollection implements Collections {
    private $users = [];

    public function addUser($user) {
        $this->users[] = $user;
    }

    public function removeUser($user) {
        $this->users = array_filter($this->users, fn($u) => $u !== $user);
    }

    public function createIterator(): iIterator {
        return new UserIterator($this->users);
    }
}
?>