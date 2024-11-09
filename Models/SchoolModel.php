<?php
include_once 'FacilityClassModel.php';

class School extends Facility
{
    private $SchoolID;
    private $AvailableBeds;
    private static $file = __DIR__ . '/../data/school.txt';

    public function __construct($SchoolID, $Address, $Name, $AvailableBeds)
    {
        $this->SchoolID = $SchoolID;
        $this->Address = $Address;
        $this->Name = $Name;
        $this->AvailableBeds = $AvailableBeds;
    }

    public function Admit()
    {
        if ($this->AvailableBeds > 0) {
            $this->AvailableBeds--;
            $this->save();
        }
    }

    public function getSchoolID()
    {
        return $this->SchoolID;
    }

    public function setName($Name)
    {
        $this->Name = $Name;
        $this->save();
    }

    public function setAddress($Address)
    {
        $this->Address = $Address;
        $this->save();
    }

    public function setAvailableBeds($AvailableBeds)
    {
        $this->AvailableBeds = $AvailableBeds;
        $this->save();
    }

    public function getName()
    {
        return $this->Name;
    }

    public function getAddress()
    {
        return $this->Address;
    }

    public function getAvailableBeds()
    {
        return $this->AvailableBeds;
    }

    // Load all schools from file
    public static function getAll()
    {
        if (file_exists(self::$file)) {
            return json_decode(file_get_contents(self::$file), true);
        }
        return [];
    }

    // Find a specific school by ID
    public static function findById($SchoolID)
    {
        $schools = self::getAll();
        foreach ($schools as $school) {
            if ($school['SchoolID'] == $SchoolID) {
                return new self(
                    $school['SchoolID'],
                    $school['Address'],
                    $school['Name'],
                    $school['AvailableBeds']
                );
            }
        }
        return null;
    }

    // Save school data
    public function save()
    {
        $schools = self::getAll();
        $schools = array_filter($schools, fn($s) => $s['SchoolID'] !== $this->SchoolID);

        $schools[] = [
            "SchoolID" => $this->SchoolID,
            "Name" => $this->Name,
            "Address" => $this->Address,
            "AvailableBeds" => $this->AvailableBeds,
        ];

        file_put_contents(self::$file, json_encode($schools, JSON_PRETTY_PRINT));
    }
}
