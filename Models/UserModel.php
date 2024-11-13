<?php

abstract class User implements Observer {
    private $Id;
    private $Name;
    private $Age;
    private $Gender;
    private $Address;
    private $Phone;
    private $Nationality;
    private $Type;
    private $Email;
    private $Preference;



    abstract public function RegisterEvent(Event $event);

}