<?php
require_once "iIterator.php";

class UserIterator implements iIterator {
    private $users = [];
    private $position = 0;

    public function __construct(array $users) {
        $this->users = $users;
    }

    public function hasNext(): bool {
        return $this->position < count($this->users);
    }

    public function next() {
        if ($this->hasNext()) {
            return $this->users[$this->position++];
        }
        return null;
    }

    public function remove() {
        if ($this->position > 0 && $this->position <= count($this->users)) {
            array_splice($this->users, $this->position - 1, 1);
            $this->position--;
        }
    }
}
?>