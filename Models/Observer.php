<?php
interface Observer {
    public function update($message);
}

/*class UserAdmin implements Observer {
    private $name;
    private  Subject $Subject;
    public function __construct($name,Subject $Subject) {
        $this->name = $name;
        $this->Subject->RegisterObserver($this);
    }

    public function update($message) {
        echo "{$this->name} received the notification: {$message}\n";
    }
}*/

class EventAdmin implements Observer {
    private $name;
    private  Subject $Subject;
    public function __construct($name,Subject $Subject) {
        $this->name = $name;
        $this->Subject->RegisterObserver($this);
    }

    public function update($message) {
        echo "{$this->name} received the notification: {$message}\n";
    }
}

class RefugeeAdmin implements Observer {
    private $name;
    private  Subject $Subject;
    public function __construct($name,Subject $Subject) {
        $this->name = $name;
        $this->Subject->RegisterObserver($this);
    }

    public function update($message) {
        echo "{$this->name} received the notification: {$message}\n";
    }
}
?>
