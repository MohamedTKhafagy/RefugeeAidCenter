<?php

require_once'Models/RefugeeModel.php';
require_once 'SingeltonDB.php';
class Adult extends Refugee {
    private $AdultID;
    private $Profession;
    private $Education;
    private $Family = []; // Array of Refugee IDs 

    public function __construct($Id, $Name, $Age, $Gender, $Address, $Phone, $Nationality, $Type, $Email, $Preference, $RefugeeID, $PassportNumber, $Advisor, $Shelter, $HealthCare, $AdultID, $Profession, $Education, $Family = []) {
        parent::__construct($Id, $Name, $Age, $Gender, $Address, $Phone, $Nationality, $Type, $Email, $Preference, $RefugeeID, $PassportNumber, $Advisor, $Shelter, $HealthCare);
        $this->AdultID = $AdultID;
        $this->Profession = $Profession;
        $this->Education = $Education;
        $this->Family = $Family;
    }
    /*
    This functions is to save the parent information into the database with the ID later used to be a key in the child table.

    // Save adult to the database
    public function save() {
        $db = DbConnection::getInstance();
        $conn = $db->database_connect;

        $query = "INSERT INTO adults (AdultID, Profession, Education) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'iss', $this->AdultID, $this->Profession, $this->Education);

        if (mysqli_stmt_execute($stmt)) {
            echo "Adult saved successfully.";
        } else {
            echo "Error saving adult: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    }
        */
}
?>
