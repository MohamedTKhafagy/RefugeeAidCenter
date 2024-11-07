<?php
require_once 'SingeltonDB.php';
require_once 'Model/RefugeeModel.php';
require_once 'Model/AdultModel.php';
class Child extends Refugee {
    private $ChildID;
    private $School; // Reference to School Class
    private $Level; //Reference to the EducationStrategy
    private $Guardian; // Reference to Adult

    public function __construct($Id, $Name, $Age, $Gender, $Address, $Phone, $Nationality, $Type, $Email, $Preference, $RefugeeID, $PassportNumber, $Advisor, $Shelter, $HealthCare, $ChildID, $School, $Level, $Guardian) {
        $this->ChildID = $ChildID;
        $this->School = $School;
        $this->Level = $Level;
        $this->Guardian = $Guardian;
    }

    /*
     // Save child to the database
     public function save() {
        $db = DbConnection::getInstance();
        $conn = $db->database_connect;

        $query = "INSERT INTO children (ChildID, School, Level, GuardianID) VALUES (?, ?,1, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'issi', $this->ChildID, $this->School, $this->Level, $this->Guardian->getAdultID());

        if (mysqli_stmt_execute($stmt)) {
            echo "Child saved successfully.";
        } else {
            echo "Error saving child: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    }

    // Set Guardian
    public function setGuardian(Adult $guardian) {
        $this->Guardian = $guardian;
    }

    public function getGuardian() {
        return $this->Guardian;
    }
        */
}
?>
