<?php

class Shelter extends Facility
{
    private $ShelterID;
    private $Supervisor;
    private $MaxCapacity;
    private $CurrentCapacity;

    private static $file = __DIR__ . '/../data/shelters.txt';

    public function __construct($ShelterID, $Name, $Address, $Supervisor, $MaxCapacity, $CurrentCapacity)
    {
        $this->ShelterID = $ShelterID;
        $this->Name = $Name;
        $this->Address = $Address;
        $this->Supervisor = $Supervisor;
        $this->MaxCapacity = $MaxCapacity;
        $this->CurrentCapacity = $CurrentCapacity;
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

    // Save or update the shelter data in the text file
    public function save()
    {
        // Load existing data
        $data = file_exists(self::$file) ? json_decode(file_get_contents(self::$file), true) : [];

        // Remove any existing entry with the same ShelterID
        $data = array_filter($data, function ($shelter) {
            return $shelter['ShelterID'] !== $this->ShelterID;
        });

        // Add the current shelter data
        $data[] = [
            "ShelterID" => $this->ShelterID,
            "Name" => $this->Name,
            "Address" => $this->Address,
            "Supervisor" => $this->Supervisor,
            "MaxCapacity" => $this->MaxCapacity,
            "CurrentCapacity" => $this->CurrentCapacity,
        ];

        // Write updated data back to the file
        file_put_contents(self::$file, json_encode($data, JSON_PRETTY_PRINT));
    }

    // Static method to get all shelters from the text file
    public static function getAll()
    {
        if (file_exists(self::$file)) {
            return json_decode(file_get_contents(self::$file), true);
        }
        return [];
    }

    // Static method to find a shelter by ID
    public static function findById($ShelterID)
    {
        $shelters = self::getAll();
        foreach ($shelters as $shelter) {
            if ($shelter['ShelterID'] == $ShelterID) {
                return new self(
                    $shelter['ShelterID'],
                    $shelter['Name'],
                    $shelter['Address'],
                    $shelter['Supervisor'],
                    $shelter['MaxCapacity'],
                    $shelter['CurrentCapacity']
                );
            }
        }
        return null;
    }

    // Getter and Setter methods
    public function getShelterID()
    {
        return $this->ShelterID;
    }

    public function getName()
    {
        return $this->Name;
    }

    public function getSupervisor()
    {
        return $this->Supervisor;
    }

    public function getAddress()
    {
        return $this->Address;
    }

    public function getCurrentCapacity()
    {
        return $this->CurrentCapacity;
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
