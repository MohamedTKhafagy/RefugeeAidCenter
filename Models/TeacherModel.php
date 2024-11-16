<?php

class Teacher extends User{
    private $TeacherID;
    private $Subject;
    private $School;
    private $Availability;

    public function __construct($Id, $Name, $Age, $Gender, $Address, $Phone, $Nationality, $Type, $Email, $Preference, $TeacherID, $Subject, $Availability, $School)
    {
        parent::__construct($Id, $Name, $Age, $Gender, $Address, $Phone, $Nationality, $Type, $Email, $Preference);
        $this->TeacherID = $TeacherID;
        $this->Subject = $Subject;
        $this->Availability = $Availability;
        $this->School = $School;
    }

    public function setTeacherID ($TeacherID){
        $this->TeacherID = $TeacherID;
    }
    public function setSubject($Subject){
        $this->Subject = $Subject;
    }
    public function setAvailability($Availability){
        $this->Availability = $Availability;
    }
    public function setSchool($School){
        $this->School = $School;
    }

    public function getTeacherID (){
        return $this->TeacherID;
    }
    public function getAvailability(){
        return $this->Availability;
    }
    public function getSubject(){
        return $this->Subject;
    }
    public function getSchool(){
        return $this->School;
    }

    public function RegisterEvent()
    {
        // to be implemented
    }
    public function Update()
    {
        // to be implemented
    }

}

