<?php
require_once 'UserModel.php';

class Volunteer extends User
{
    private $VolunteerID;
    private $Skills;
    private $Availability;
    private $AssignedEvents; // Events that the volunteer is part of


    private static $file = __DIR__ . '/../data/volunteers.txt'; // Path to text file

    public function __construct($Id, $Name, $Age, $Gender, $Address, $Phone, $Nationality, $Type, $Email, $Preference, $VolunteerID, $Skills, $Availability, $AssignedEvents = [])
    {
        parent::__construct($Id, $Name, $Age, $Gender, $Address, $Phone, $Nationality, $Type, $Email, $Preference);
        $this->VolunteerID = $VolunteerID;
        $this->Skills = $Skills;
        $this->Availability = $Availability;
        $this->AssignedEvents = $AssignedEvents;
    }

    public function RegisterEvent()
    {
        echo "Volunteer has registered for an event.";
    }

    public function Update()
    {
        echo "Updating volunteer information.";
    }


    // Getter for Skills
    public function getSkills()
    {
        return $this->Skills;
    }

    // Getter for Availability
    public function getAvailability()
    {
        return $this->Availability;
    }

    // Getter for AssignedEvents
    public function getAssignedEvents()
    {
        return $this->AssignedEvents;
    }

    // Save volunteer details to the text file (JSON format)
    public function save()
    {
        // Load existing data
        $data = file_exists(self::$file) ? json_decode(file_get_contents(self::$file), true) : [];

        // Add this volunteer's data to the array
        $data[] = [
            "Id" => $this->Id,
            "VolunteerID" => $this->VolunteerID,
            "Skills" => $this->Skills,
            "Availability" => $this->Availability,
            "AssignedEvents" => $this->AssignedEvents,
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
            echo "Volunteer saved successfully.";
        } else {
            echo "Error saving volunteer.";
        }
    }

    // Find a volunteer by ID from the text file
    public static function findById($id)
    {
        if (file_exists(self::$file)) {
            $data = json_decode(file_get_contents(self::$file), true);

            foreach ($data as $volunteer) {
                if ($volunteer['VolunteerID'] == $id) {
                    return new self(
                        $volunteer['Id'] ?? null,
                        $volunteer['Name'] ?? null,
                        $volunteer['Age'] ?? null,
                        $volunteer['Gender'] ?? null,
                        $volunteer['Address'] ?? null,
                        $volunteer['Phone'] ?? null,
                        $volunteer['Nationality'] ?? null,
                        $volunteer['Type'] ?? null,
                        $volunteer['Email'] ?? null,
                        $volunteer['Preference'] ?? null,
                        $volunteer['VolunteerID'],
                        $volunteer['Skills'],
                        $volunteer['Availability'],
                        $volunteer['AssignedEvents'] ?? []
                    );
                }
            }
        }
        return null;
    }

    // Get all volunteers from the text file
    public static function all()
    {
        if (file_exists(self::$file)) {
            $data = json_decode(file_get_contents(self::$file), true);

            $volunteers = [];
            foreach ($data as $volunteer) {
                $volunteers[] = new self(
                    $volunteer['Id'] ?? null,
                    $volunteer['Name'] ?? null,
                    $volunteer['Age'] ?? null,
                    $volunteer['Gender'] ?? null,
                    $volunteer['Address'] ?? null,
                    $volunteer['Phone'] ?? null,
                    $volunteer['Nationality'] ?? null,
                    $volunteer['Type'] ?? null,
                    $volunteer['Email'] ?? null,
                    $volunteer['Preference'] ?? null,
                    $volunteer['VolunteerID'],
                    $volunteer['Skills'],
                    $volunteer['Availability'],
                    $volunteer['AssignedEvents'] ?? []
                );
            }
            return $volunteers;
        }
        return [];
    }


    public static function editById($id, $volunteer)
    {
        // Load the file data
        if (file_exists(self::$file)) {
            $data = json_decode(file_get_contents(self::$file), true);
            // Loop through the data and update the volunteer with the matching ID
            foreach ($data as &$vol) {
                if ($vol['VolunteerID'] == $id) {
                    $vol['Id'] = $volunteer->getId();
                    $vol['Name'] = $volunteer->getName();
                    $vol['Age'] = $volunteer->getAge();
                    $vol['Gender'] = $volunteer->getGender();
                    $vol['Address'] = $volunteer->getAddress();
                    $vol['Phone'] = $volunteer->getPhone();
                    $vol['Nationality'] = $volunteer->getNationality();
                    $vol['Type'] = $volunteer->getType();
                    $vol['Email'] = $volunteer->getEmail();
                    $vol['Preference'] = $volunteer->getPreference();
                    $vol['VolunteerID'] = $volunteer->getVolunteerID();
                    $vol['Skills'] = $volunteer->getSkills();
                    $vol['Availability'] = $volunteer->getAvailability();
                    $vol['AssignedEvents'] = $volunteer->getAssignedEvents();
                    break;
                }
            }

            // Save the updated data back to the file
            file_put_contents(self::$file, json_encode($data, JSON_PRETTY_PRINT));

            return true; // Indicate success
        }

        return false; // File does not exist or operation failed
    }

    public static function deleteById($id)
    {
        // Load the file data
        if (file_exists(self::$file)) {
            $data = json_decode(file_get_contents(self::$file), true);

            // Filter out the volunteer with the matching ID
            $data = array_filter($data, function ($vol) use ($id) {
                return $vol['VolunteerID'] != $id;
            });

            // Save the updated data back to the file
            file_put_contents(self::$file, json_encode(array_values($data), JSON_PRETTY_PRINT));

            return true; // Indicate success
        }

        return false; // File does not exist or operation failed
    }
}
