<?php
require_once __DIR__ . "/../SingletonDB.php";
// require_once 'Model/RefugeeModel.php';
// require_once 'Model/AdultModel.php';
class Child extends Refugee {
    private $ChildID;
    private $School; // Reference to School Class
    private $Level; //Reference to the EducationStrategy
    private $Guardian; // Reference to Adult

    public function __construct($Id, $Name, $Age, $Gender, $Address, $Phone, $Nationality, $Type, $Email, $Preference, $RefugeeID, $PassportNumber, $Advisor, $Shelter, $HealthCare, $ChildID, $School, $Level, $Guardian) {
        parent::__construct($Id, $Name, $Age, $Gender, $Address, $Phone, $Nationality, $Type, $Email, $Preference, $RefugeeID, $PassportNumber, $Advisor, $Shelter, $HealthCare);
        $this->ChildID = $ChildID;
        $this->School = $School;
        $this->Level = $Level;
        $this->Guardian = $Guardian;
    }

    public function save() {
        $refugeeId = parent::save();
        if($refugeeId == -1) echo "Error saving refugee.";
        $db = DbConnection::getInstance();
        $query = "INSERT INTO Child (SchoolId, Level, Guardian, RefugeeId) VALUES ('$this->School', '$this->Level', '$this->Guardian', $refugeeId)";
        $db->query($query);
        $sql = "SELECT LAST_INSERT_ID() AS last;";
        $rows = $db->fetchAll($sql);
        $lastId = -1;
        foreach ($rows as $row) {
            $lastId = $row["last"];
        }
        if ($lastId == -1) echo "Error saving child.";
        else {
            $this->ChildID = $lastId;
        }
    }

    public function getSchool() {
        return $this->School;
    }

    public function getLevel() {
        return $this->Level;
    }

    public function getGuardian() {
        return $this->Guardian;
    }

}
?>
