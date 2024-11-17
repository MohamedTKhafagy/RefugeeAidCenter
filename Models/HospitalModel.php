<?php

require_once "FacilityClassModel.php";
require_once "HealthcareStrategy.php";
require_once "SingletonDB.php";

class Hospital extends Facility {
    private $healthcareStrategy;
    private $Supervisor;
    private $MaxCapacity;
    private $CurrentCapacity;
    private $insuranceType;

    public function __construct($Id,$name, $address, $type, $supervisor, $maxCapacity, $currentCapacity = 0) {
        parent::__construct($Id,$name, $address,$type);
        $this->Supervisor = $supervisor;
        $this->MaxCapacity = $maxCapacity;
        $this->CurrentCapacity = $currentCapacity;
    }

    // Basic getters and setters remain unchanged
    public function Assign() {
        if($this->CurrentCapacity < $this->MaxCapacity) {
            $this->CurrentCapacity++;
        }
    }

    public function setMaxCapacity($MaxCapacity) {
        $this->MaxCapacity = $MaxCapacity;
    }

    public function setSupervisor($Supervisor) {
        $this->Supervisor = $Supervisor;
    }

    public function setName($Name) {
        $this->Name = $Name;
    }

    public function setAddress($Address) {
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

    public function getName() {
        return $this->Name;
    }

    public function getSupervisor() {
        return $this->Supervisor;
    }

    public function getAddress() {
        return $this->Address;
    }

    public function getMaxCapacity() {
        return $this->MaxCapacity;
    }

    public function getID() {
        return $this->ID;
    }

    public function getInsuranceType() {
        return $this->insuranceType == 0 ? 'Basic' : 'Comprehensive';
    }

    public function setInsuranceType($type) {
        $this->insuranceType = strtolower($type) === 'basic' ? 0 : 1;
    }

    public function getCurrentCapacity() {
        return $this->CurrentCapacity ?? 0;
    }

    // Database operations
    public static function findById($id) {
        $db = DbConnection::getInstance();
        $query = "SELECT f.Id AS Id, 
                    f.Name AS Name,
                    f.Address AS Address,
                    h.MaxCapacity AS MaxCapacity,
                    h.CurrentCapacity AS CurrentCapacity,
                    h.Supervisor AS Supervisor,
                    h.insuranceType AS InsuranceType 
                 FROM Facility f 
                 JOIN HOSPITAL h ON f.Id = h.HospitalId 
                 WHERE f.Id=$id ;";  // Only show non-deleted hospitals
        
        $result = $db->fetchAll($query);

        foreach ($result as $row) {
            $hospital = new self(
                $row["Id"],
                $row['Name'],
                $row['Address'],
                1,
                $row['Supervisor'],
                $row['MaxCapacity'],
                $row['CurrentCapacity']
            );
            $hospital->insuranceType = $row['InsuranceType'];
             
            return $hospital;
        }
        
        }

    public static function updateById($id, $hospital) {
        $db = DbConnection::getInstance();
        
        // Update Facility table
        $facilitySQL = "UPDATE Facility 
                       SET Name = '$hospital->Name', Address = $hospital->Address
                       WHERE Id = $id;";
        $db->query($facilitySQL);               
        
        // Update Hospital table
        $hospital->insuranceType == 'Basic' ? 0 : 1;
        $hospitalSQL = "UPDATE Hospital 
                       SET MaxCapacity = $hospital->MaxCapacity, CurrentCapacity = $hospital->CurrentCapacity, 
                           insuranceType = $hospital->insuranceType, Supervisor = '$hospital->Supervisor' 
                       WHERE HospitalId = $id;";

        $db->query($hospitalSQL);               

        
    }

    public function save() {
        $db = DbConnection::getInstance();
        
        // First insert into Facility table
        $facilitySQL = "INSERT INTO Facility (Name, Address, Type, IsDeleted) 
                       VALUES ('$this->Name', $this->Address, 1, 0)";
        $db->query($facilitySQL);

        $sql ="SELECT LAST_INSERT_ID() AS last;";
        $rows=$db->fetchAll($sql);
        foreach($rows as $row){
            $this->ID=$row['last'];
            break;
        }
        $this->insuranceType == 'Basic' ? 0 : 1;
        
        // Then insert into Hospital table
        $hospitalSQL = "INSERT INTO Hospital (HospitalId, MaxCapacity, CurrentCapacity, 
                                           insuranceType, Supervisor) 
                       VALUES ($this->ID,$this->MaxCapacity,$this->CurrentCapacity,$this->insuranceType,'$this->Supervisor')";
        $db->query($hospitalSQL);
    }
    
    
    
    public static function all() {
            $db = DbConnection::getInstance();
            $query = "SELECT 
                        f.Id AS Id, 
                        f.Name AS Name,
                        f.Address AS Address,
                        h.MaxCapacity AS MaxCapacity,
                        h.CurrentCapacity AS CurrentCapacity,
                        h.Supervisor AS Supervisor,
                        h.insuranceType AS InsuranceType
                    FROM 
                        Facility f 
                    JOIN 
                        HOSPITAL h ON f.Id = h.HospitalId 
                    WHERE 
                        f.IsDeleted = 0;";  
            
            $result = $db->fetchAll($query);
            $hospitals = [];
            
            foreach ($result as $row) {
                $hospital = new self(
                    $row["Id"],
                    $row['Name'],
                    $row['Address'],
                    1,
                    $row['Supervisor'],
                    $row['MaxCapacity'],
                    $row['CurrentCapacity']
                );
                $hospital->insuranceType = $row['InsuranceType'];

                $hospitals[] = $hospital;
            }
            
            return $hospitals ?? [];
        
    }
    

    public static function deletebyId($id) {
            $db = DbConnection::getInstance();
            $query = "UPDATE Facility SET IsDeleted = 1 WHERE Id = $id ;";
            $db->query($query);               
        }

    // Strategy pattern methods
    public function setHealthcareStrategy(HealthcareStrategy $strategy) {
        $this->healthcareStrategy = $strategy;
        $this->insuranceType = $strategy instanceof BasicInsurance ? 'Basic' : 'Comprehensive';
        $this->save();
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