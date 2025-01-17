<?php
interface Observer {
    public function update($eventData);
}


class UserAdmin {
    private $name;
    public function __construct($name) {
        $this->name = $name;
    }

}

class EventAdmin {
    private $name;
    public function __construct($name) {
        $this->name = $name;
    }

}

class RefugeeAdmin {
    private $name;
    public function __construct($name) {
        $this->name = $name;
    }

}
?>
