<?php

abstract class User{
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



    abstract public function RegisterEvent();
    abstract public function Update();

}