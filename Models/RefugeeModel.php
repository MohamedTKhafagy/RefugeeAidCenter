<?php
require_once 'UserModel.php';

class Refugee extends User
{

    private $RefugeeID;
    private $PassportNumber;
    private $Advisor; // Instance of SocialWorker
    private $Shelter; // Instance of Shelter
    private $HealthCare; // Instance of HealthcareStrategy

    private static $file = '../data/refugees.txt'; // Path to text file

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
        // Load existing data
        $data = file_exists(self::$file) ? json_decode(file_get_contents(self::$file), true) : [];

        // Add this refugee's data to the array
        $data[] = [
            "RefugeeID" => $this->RefugeeID,
            "PassportNumber" => $this->PassportNumber,
            "Advisor" => $this->Advisor,
            "Shelter" => $this->Shelter,
            "HealthCare" => $this->HealthCare,
            "Name" => $this->Name,
            "Age" => $this->Age,
            "Gender" => $this->Gender,
            "Address" => $this->Address,
            "Phone" => $this->Phone,
            "Nationality" => $this->Nationality,
            "Type" => $this->Type,
            "Email" => $this->Email,
            "Preference" => $this->Preference
        ];

        // Write the updated data back to the file
        if (file_put_contents(self::$file, json_encode($data, JSON_PRETTY_PRINT))) {
            echo "Refugee saved successfully.";
        } else {
            echo "Error saving refugee.";
        }
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
}
