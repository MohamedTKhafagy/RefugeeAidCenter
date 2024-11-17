<?php

require_once "FacilityClassModel.php";
require_once "HealthcareStrategy.php";

class Hospital extends Facility {
    private $healthcareStrategy;
    private $HospitalID;
    private $Supervisor;
    private $MaxCapacity;
    private $CurrentCapacity;
    private $insuranceType;
    private static $file = __DIR__ . '/../data/hospitals.txt';

    public function __construct($name, $address, $supervisor, $maxCapacity, $currentCapacity = 0) {
        $this->Name = $name;
        $this->Address = $address;
        $this->Supervisor = $supervisor;
        $this->MaxCapacity = $maxCapacity;
        $this->CurrentCapacity = $currentCapacity;
        $this->HospitalID = uniqid('HOSP_'); // Generate ID on creation
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
    public function setID($id) {
        $this->HospitalID = $id;
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
    /*public function getCurrentCapacity(){
        return $this->CurrentCapacity;
    }*/
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

    public static function getById($id) {
        if (!file_exists(self::$file)) {
            return null;
        }

        $fileContent = file_get_contents(self::$file);
        if (!$fileContent) {
            return null;
        }

        $data = json_decode($fileContent, true);
        if (!$data) {
            error_log("Failed to decode JSON data from file");
            return null;
        }

        foreach ($data as $hospitalData) {
            if ($hospitalData['HospitalID'] === $id) {
                // Create new hospital instance
                $hospital = new self(
                    $hospitalData['Name'],
                    $hospitalData['Address'],
                    $hospitalData['Supervisor'],
                    $hospitalData['MaxCapacity'],
                    $hospitalData['CurrentCapacity'] ?? 0
                );
                
                // Set additional properties
                $hospital->HospitalID = $hospitalData['HospitalID'];
                $hospital->insuranceType = $hospitalData['InsuranceType'] ?? 'Not Set';
                
                return $hospital;
            }
        }
        
        error_log("Hospital not found with ID: " . $id);
        return null;
    }

    public function save() {
        try {
            if (!file_exists(self::$file)) {
                file_put_contents(self::$file, json_encode([]));
            }

            $fileContent = file_get_contents(self::$file);
            $data = json_decode($fileContent, true) ?: [];

            $hospitalData = [
                'HospitalID' => $this->HospitalID,
                'Name' => $this->Name,
                'Address' => $this->Address,
                'Supervisor' => $this->Supervisor,
                'MaxCapacity' => $this->MaxCapacity,
                'CurrentCapacity' => $this->CurrentCapacity ?? 0,
                'InsuranceType' => $this->insuranceType ?? 'Not Set'
            ];

            $found = false;
            foreach ($data as $key => $item) {
                if ($item['HospitalID'] === $this->HospitalID) {
                    $data[$key] = $hospitalData;
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                if (!$this->HospitalID) {
                    $this->HospitalID = uniqid('HOSP_');
                    $hospitalData['HospitalID'] = $this->HospitalID;
                }
                $data[] = $hospitalData;
            }

            $success = file_put_contents(self::$file, json_encode($data, JSON_PRETTY_PRINT));
            if ($success === false) {
                throw new Exception("Failed to write to file");
            }

            return true;
        } catch (Exception $e) {
            error_log("Error saving hospital: " . $e->getMessage());
            return false;
        }
    }


    // Fixed getCurrentCapacity method
    public function getCurrentCapacity() {
        return $this->CurrentCapacity ?? 0; // Return 0 if null
    }



    public static function all() {
        if (file_exists(self::$file)) {
            $data = json_decode(file_get_contents(self::$file), true) ?: [];
            
            $hospitals = [];
            foreach ($data as $hospital) {
                // Create new hospital instance without insurance type in constructor
                $newHospital = new self(
                    $hospital['Name'],
                    $hospital['Address'],
                    $hospital['Supervisor'],
                    $hospital['MaxCapacity'],
                    $hospital['CurrentCapacity'] ?? 0
                );
                
                // Set the ID and insurance type after creation
                $newHospital->HospitalID = $hospital['HospitalID'];
                $newHospital->insuranceType = $hospital['InsuranceType'] ?? 'Not Set';
                
                $hospitals[] = $newHospital;
            }
            return $hospitals;
        }
        return [];
    }
// Updated method to handle strategy assignment
    public function setHealthcareStrategy(HealthcareStrategy $strategy) {
    $this->healthcareStrategy = $strategy;
    $this->insuranceType = $strategy instanceof BasicInsurance ? 'Basic' : 'Comprehensive';
    $this->save(); // Save the changes to file
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
    // Add this to your Hospital class constructor or in a init method
public static function initStorage() {
    self::$file = __DIR__ . '/../data/hospitals.txt';
    $dir = dirname(self::$file);
    
    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }
    
    if (!file_exists(self::$file)) {
        file_put_contents(self::$file, json_encode([]));
    }
    
    chmod(self::$file, 0666);
}

    // Add these debug methods
    public static function debugFileContents() {
        if (file_exists(self::$file)) {
            $content = file_get_contents(self::$file);
            error_log("File contents: " . $content);
            return json_decode($content, true);
        }
        return null;
    }

    public static function validateFileStructure() {
        if (!file_exists(self::$file)) {
            error_log("Hospital data file does not exist");
            return false;
        }

        $content = file_get_contents(self::$file);
        if (!$content) {
            error_log("Hospital data file is empty");
            return false;
        }

        $data = json_decode($content, true);
        if ($data === null) {
            error_log("Invalid JSON in hospital data file");
            return false;
        }

        return true;
    }
}

