<?php

require_once "FacilityClassModel.php";

class Hospital extends Facility{
    private $HospitalID;
    private $Supervisor;
    private $MaxCapacity;
    private $CurrentCapacity;
    private static $file = __DIR__ . '/../data/hospitals.txt';

    public function __construct($Name,$Address,$Supervisor,$MaxCapacity,$CurrentCapacity)
    {
        $this->HospitalID = uniqid();
        $this->Name = $Name;
        $this->Address = $Address;
        $this->CurrentCapacity = $CurrentCapacity;
        $this->MaxCapacity = $MaxCapacity;
        $this->Supervisor= $Supervisor;
    }

    public function Assign(){
        if($this->CurrentCapacity<$this->MaxCapacity){
            $this->CurrentCapacity++;
        }
    }

    public function setMaxCapacity($MaxCapacity){
        $this->MaxCapacity = $MaxCapacity;
    }
    public function setSupervisor($Supervisor){
        $this->Supervisor = $Supervisor;
    }
    public function setName($Name){
        $this->Name = $Name;
    }
    public function setAddress($Address){
        $this->Address = $Address;
    }
    public function setCurrentCapacity($CurrentCapacity){
        if($CurrentCapacity>$this->MaxCapacity){
            return false;
        }
        else{
            $this->CurrentCapacity = $CurrentCapacity;
        }
    }


    public function getName(){
        return $this->Name;
    }
    public function getSupervisor(){
        return $this->Supervisor;
    }
    public function getAddress(){
        return $this->Address;
    }
    public function getCurrentCapacity(){
        return $this->CurrentCapacity;
    }
    public function getMaxCapacity(){
        return $this->MaxCapacity;
    }
    public function getID(){
        return $this->HospitalID;
    }

    public function save() {
        // Load existing data
        $data = file_exists(self::$file) ? json_decode(file_get_contents(self::$file), true) : [];

        // Add this refugee's data to the array
        $data[] = [
            'HospitalID' => $this->HospitalID,
            'Name' => $this->Name,
            'Address' => $this->Address,
            'Supervisor' => $this->Supervisor,
            'MaxCapacity' => $this->MaxCapacity,
            'CurrentCapacity' => $this->CurrentCapacity
        ];

        // Write the updated data back to the file
        if (file_put_contents(self::$file, json_encode($data, JSON_PRETTY_PRINT))) {
            echo "Hospital saved successfully.";
        } else {
            echo "Error saving Hospital.";
        }
    }

    public static function all()
    {
        // Load the file data
        if (file_exists(self::$file)) {
            $data = json_decode(file_get_contents(self::$file), true);

            // Create an array of Refugee instances
            $hospitals = [];
            foreach ($data as $hospital) {
                $hospitals[] = new self(
                    $hospital['Name'],
                    $hospital['Address'],
                    $hospital['Supervisor'],
                    $hospital['MaxCapacity'],
                    $hospital['CurrentCapacity']
                );
            }
        }
        return $hospitals ?? [];
    }
}
