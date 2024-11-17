<?php
interface Observer {
    public function update($message);
}

class UserAdmin implements Observer {
    private $name;

    public function __construct($name) {
        $this->name = $name;
    }

    public function update($message) {
        echo "{$this->name} received the notification: {$message}\n";
    }
}

class EventAdmin implements Observer {
    private $name;

    public function __construct($name) {
        $this->name = $name;
    }

    public function update($message) {
        echo "{$this->name} received the notification: {$message}\n";
    }
}

class RefugeeAdmin implements Observer {
    private $name;

    public function __construct($name) {
        $this->name = $name;
    }

    public function update($message) {
        echo "{$this->name} received the notification: {$message}\n";
    }
}
?>
