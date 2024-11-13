<?php
require_once 'UserModel.php';
require_once __DIR__ . '/../DB.php';

class Refugee extends User
{


    protected $RefugeeID;
    protected $PassportNumber;
    protected $Advisor; // Instance of SocialWorker
    protected $Shelter; // Instance of Shelter
    protected $HealthCare; // Instance of HealthcareStrategy

    private static $file = __DIR__ . '/../data/refugees.txt'; // Path to text file

    public function __construct($Id, $Name, $Age, $Gender, $Address, $Phone, $Nationality, $Type, $Email, $Preference, $RefugeeID, $PassportNumber, $Advisor, $Shelter, $HealthCare)
    {
        parent::__construct($Id, $Name, $Age, $Gender, $Address, $Phone, $Nationality, $Type, $Email, $Preference);
        $this->RefugeeID = $RefugeeID;
        $this->PassportNumber = $PassportNumber;
        $this->Advisor = $Advisor; // Pass an instance of SocialWorker
        $this->Shelter = $Shelter; // Pass an instance of Shelter
        $this->HealthCare = $HealthCare; // Pass an instance of HealthcareStrategy
    }


    public function RegisterEvent()
    {
        echo "An event has been registered by the Refugee user.";
    }

    public function Update()
    {
        echo "Updating from the Refugee User class.";
    }

    // Save refugee details to the text file (JSON format)
    public function save()
    {
        $parentId = parent::save();
        if ($parentId == -1) echo "Error saving refugee: Parent data not saved.";
        return DB::save($this->getProperties(["userId" => $parentId]), "/data/refugees.txt", "RefugeeID");
    }

    private function getProperties($newProperty = null)
    {
        $properties = [
            "RefugeeID" => $this->RefugeeID,
            "PassportNumber" => $this->PassportNumber,
            "Advisor" => $this->Advisor,
            "Shelter" => $this->Shelter,
            "HealthCare" => $this->HealthCare
        ];

        if ($newProperty) {
            $properties = array_merge($properties, $newProperty);
        }

        return $properties;
    }

    // Find a refugee by ID from the text file
    public static function findById($id)
    {
        // Load the file data
        if (file_exists(self::$file)) {
            $data = json_decode(file_get_contents(self::$file), true);

            // Search for the refugee by ID
            foreach ($data as $refugee) {
                if ($refugee['RefugeeID'] == $id) {
                    // Create a new Refugee instance with the found data
                    return new self(
                        $refugee['Id'] ?? null,
                        $refugee['Name'] ?? null,
                        $refugee['Age'] ?? null,
                        $refugee['Gender'] ?? null,
                        $refugee['Address'] ?? null,
                        $refugee['Phone'] ?? null,
                        $refugee['Nationality'] ?? null,
                        $refugee['Type'] ?? null,
                        $refugee['Email'] ?? null,
                        $refugee['Preference'] ?? null,
                        $refugee['RefugeeID'],
                        $refugee['PassportNumber'],
                        $refugee['Advisor'],
                        $refugee['Shelter'],
                        $refugee['HealthCare']
                    );
                }
            }
        }
        return null;
    }

    public static function all()
    {
        $refugeesData = DB::all("/data/refugees.txt");
        foreach ($refugeesData as $refugee) {
            $userDate = DB::findById("/data/users.txt", $refugee['userId'], "Id");
            $refugees[] = new self(
                $userDate['Id'] ?? null,
                $userDate['Name'] ?? null,
                $userDate['Age'] ?? null,
                $userDate['Gender'] ?? null,
                $userDate['Address'] ?? null,
                $userDate['Phone'] ?? null,
                $userDate['Nationality'] ?? null,
                $userDate['Type'] ?? null,
                $userDate['Email'] ?? null,
                $userDate['Preference'] ?? null,
                $refugee['RefugeeID'],
                $refugee['PassportNumber'],
                $refugee['Advisor'],
                $refugee['Shelter'],
                $refugee['HealthCare']
            );
        }
        return $refugees;
    }
}
