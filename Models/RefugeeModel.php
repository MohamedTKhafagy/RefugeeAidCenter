<?php
require_once 'Models/UserModel.php';
require_once 'SingeltonDB.php';
class Refugee extends User {

    private $RefugeeID;
    private $PassportNumber;
    private $Advisor; // Instance of SocialWorker
    private $Shelter; // Instance of Shelter
    private $HealthCare; // Instance of HealthcareStrategy

    public function __construct($Id, $Name, $Age, $Gender, $Address, $Phone, $Nationality, $Type, $Email, $Preference, $RefugeeID, $PassportNumber, $Advisor, $Shelter, $HealthCare) {
        parent::__construct($Id, $Name, $Age, $Gender, $Address, $Phone, $Nationality, $Type, $Email, $Preference);
        $this->RefugeeID = $RefugeeID;
        $this->PassportNumber = $PassportNumber;
        $this->Advisor = $Advisor; // Pass an instance of SocialWorker
        $this->Shelter = $Shelter; // Pass an instance of Shelter
        $this->HealthCare = $HealthCare; // Pass an instance of HealthcareStrategy
    }

    public function RegisterEvent() {
        echo "An event has been registered by the Refugee user.";
    }
    public function Update(){
        echo "Updating from the Refugee User class.";
    }
         /*
         This function is to save the Refugee details to the database
        // Save refugee to the database
        public function save() {
            $db = DbConnection::getInstance();
            $conn = $db->database_connect;
    
            $query = "INSERT INTO refugees (RefugeeID, PassportNumber, Advisor, Shelter, Healthcare) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, 'issss', $this->RefugeeID, $this->PassportNumber, $this->Advisor, $this->Shelter, $this->Healthcare);
            
            if (mysqli_stmt_execute($stmt)) {
                echo "Refugee saved successfully.";
            } else {
                echo "Error saving refugee: " . mysqli_error($conn);
            }
    
            mysqli_stmt_close($stmt);
        }
            */

        /*
        This function is to Search the Refugees based on their ID
         // Find a refugee by ID
        public static function findById($id) {
            $db = DbConnection::getInstance();
            $conn = $db->database_connect;

             $query = "SELECT * FROM refugees WHERE RefugeeID = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, 'i', $id);
        
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {
                return new self($row['RefugeeID'], $row['PassportNumber'], $row['Advisor'], $row['Shelter'], $row['Healthcare']);
            }

            mysqli_stmt_close($stmt);
            return null;
    }
            */
}
?>
