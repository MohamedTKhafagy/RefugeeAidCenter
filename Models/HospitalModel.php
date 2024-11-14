<?php

require_once "FacilityClassModel.php";
require_once "HealthcareStrategy.php";

class Hospital extends Facility{
    private $healthcareStrategy; // New property for strategy
    private $HospitalID;
    private $Supervisor;
    private $MaxCapacity;
    private $CurrentCapacity = null;

    private $insuranceType = 'N/A' ; //Variable for insurance type (will be assigned using strategy function assign hospital) 
    private static $file = __DIR__ . '/../data/hospitals.txt';

    public function __construct($Name,$Address,$Supervisor,$MaxCapacity,$CurrentCapacity,$insuranceType = 'basic')
    {
        $this->HospitalID = uniqid();
        $this->Name = $Name;
        $this->Address = $Address;
        $this->CurrentCapacity = $CurrentCapacity;
        $this->MaxCapacity = $MaxCapacity;
        $this->Supervisor= $Supervisor;
        $this->insuranceType = $insuranceType; // It has a basic default value
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
    public function setCurrentCapacity($CurrentCapacity) {
        if ($CurrentCapacity > $this->MaxCapacity) {
            throw new Exception("Current capacity exceeds maximum capacity.");
        } elseif ($CurrentCapacity < 0) {
            throw new Exception("Current capacity cannot be negative.");
        } else {
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
    public function getInsuranceType() {
        return $this->insuranceType;
    }

    public function setInsuranceType($insuranceType) {
        $this->insuranceType = $insuranceType;
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
            'CurrentCapacity' => $this->CurrentCapacity,
            'InsuranceType' => $this->insuranceType
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
                    $hospital['CurrentCapacity'],
                    $hospital['insuranceType']
                );
            }
        }
        return $hospitals ?? [];
    }
    public function setHealthcareStrategy(HealthcareStrategy $strategy) {
        $this->healthcareStrategy = $strategy;
    }
    
    public function getHealthcareStrategy() {
        return $this->healthcareStrategy;
    }
    
    public function assignWithStrategy() {
        if ($this->CurrentCapacity < $this->MaxCapacity) {
            $this->CurrentCapacity++;
            if ($this->healthcareStrategy) {
                $this->healthcareStrategy->AssignHospital($this);
            } else {
                echo "No healthcare strategy assigned for this hospital.\n";
            }
        } else {
            echo "Hospital capacity reached. Cannot assign more.\n";
        }
    }
}
