<?php
require_once 'FacilityClassModel.php';
require_once 'DBInit.php';

class Shelter extends Facility
{
    public $Supervisor;
    public $MaxCapacity;
    public $CurrentCapacity;

    public function __construct($ShelterID, $Name, $Address, $Supervisor, $MaxCapacity, $CurrentCapacity)
    {
        $this->ID = (int)$ShelterID;
        $this->Name = $Name;
        $this->Address = $Address;
        $this->Type = 0; // 0 for Shelter
        $this->Supervisor = $Supervisor;
        $this->MaxCapacity = (int)$MaxCapacity;
        $this->CurrentCapacity = (int)$CurrentCapacity;
    }

    public function assign()
    {
        if ($this->CurrentCapacity < $this->MaxCapacity) {
            $this->CurrentCapacity++;
            $this->save();
            return true;
        }
        return false;
    }

    public function save()
    {
        $db = DbConnection::getInstance();
        try {
            $sql = "
            INSERT INTO Facility (Name, Address, Type, IsDeleted)
            VALUES ('$this->Name', '$this->Address', 0, 0)
            ";
            $db->query($sql);

            $sql = "SELECT LAST_INSERT_ID() AS last;";
            $rows = $db->fetchAll($sql);
            foreach ($rows as $row) {
                $facilityId = $row["last"];
            }

            $sql = "
            INSERT INTO Shelter (ShelterID, Supervisor, MaxCapacity, CurrentCapacity)
            VALUES ($facilityId, '$this->Supervisor', $this->MaxCapacity, $this->CurrentCapacity)
            ";
            $db->query($sql);

            return $this->findById($facilityId);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function findById($ShelterID)
    {
        $db = DbConnection::getInstance();
        $sql = "SELECT f.Id AS FacilityID, f.Name, f.Address, s.Supervisor, s.MaxCapacity, s.CurrentCapacity 
                FROM Facility f 
                JOIN Shelter s ON f.Id = s.ShelterID 
                WHERE f.Id = $ShelterID AND f.IsDeleted = 0;";
        $rows = $db->fetchAll($sql);
        foreach ($rows as $shelter) {
            return new self(
                $shelter["FacilityID"],
                $shelter["Name"],
                $shelter["Address"],
                $shelter["Supervisor"],
                $shelter["MaxCapacity"],
                $shelter["CurrentCapacity"]
            );
        }
        return null;
    }

    public static function all()
    {
        $db = DbConnection::getInstance();
        $sql = "SELECT f.Id AS FacilityID, f.Name, f.Address, s.Supervisor, s.MaxCapacity, s.CurrentCapacity 
                FROM Facility f 
                JOIN Shelter s ON f.Id = s.ShelterID 
                WHERE f.IsDeleted = 0;";
        $rows = $db->fetchAll($sql);
        $shelters = [];
        foreach ($rows as $shelter) {
            $shelters[] = new self(
                $shelter["FacilityID"],
                $shelter["Name"],
                $shelter["Address"],
                $shelter["Supervisor"],
                $shelter["MaxCapacity"],
                $shelter["CurrentCapacity"]
            );
        }
        return $shelters ?? [];
    }

    public static function editById($ShelterID, $shelter)
    {
        $db = DbConnection::getInstance();
        try {
            $sql = "UPDATE Facility
            SET 
            Name = '$shelter->Name',
            Address = '$shelter->Address'
            WHERE Id = $ShelterID;";
            $db->query($sql);

            $sql = "UPDATE Shelter
            SET 
            Supervisor = '$shelter->Supervisor',
            MaxCapacity = $shelter->MaxCapacity,
            CurrentCapacity = $shelter->CurrentCapacity
            WHERE ShelterID = $ShelterID;";
            $db->query($sql);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function deleteById($ShelterID)
    {
        $db = DbConnection::getInstance();
        $sql = "UPDATE Facility
        SET
        IsDeleted = 1
        WHERE Id = $ShelterID;";
        $db->query($sql);
    }

    // Getter and Setter methods
    public function getSupervisor()
    {
        return $this->Supervisor;
    }

    public function setSupervisor($Supervisor)
    {
        $this->Supervisor = $Supervisor;
    }

    public function getMaxCapacity()
    {
        return $this->MaxCapacity;
    }

    public function setMaxCapacity($MaxCapacity)
    {
        $this->MaxCapacity = $MaxCapacity;
        $this->save();
    }

    public function getCurrentCapacity()
    {
        return $this->CurrentCapacity;
    }

    public function setCurrentCapacity($CurrentCapacity)
    {
        if ($CurrentCapacity <= $this->MaxCapacity) {
            $this->CurrentCapacity = $CurrentCapacity;
            $this->save();
            return true;
        }
        return false;
    }
}
