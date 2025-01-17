<?php
include_once "SingletonDB.php";
include_once "Models/RequestState/RequestState.php";
include_once "Models/RequestState/DraftState.php";
include_once "Models/RequestState/PendingState.php";
include_once "Models/RequestState/AcceptedState.php";
include_once "Models/RequestState/CompletedState.php";
include_once "Models/RequestState/DeclinedState.php";

class Request
{
    private $Id;
    private $RefugeeId;
    private $Name;
    private $Description;
    private $Type; 
    private $Quantity;
    private $UserId;
    private $Status; 

    private $StatusComment;
    private RequestState $state;

    public function __construct($Id, $RefugeeId, $Name, $Description, $Type, $Quantity, $UserId, $Status = 'Draft', $StatusComment = null)
    {
        $this->Id = $Id;
        $this->RefugeeId = $RefugeeId;
        $this->Name = $Name;
        $this->Description = $Description;
        $this->Type = $Type;
        $this->Quantity = $Quantity;
        $this->UserId = $UserId;
        $this->Status = $Status;
        $this->StatusComment = $StatusComment;
        $this->initializeState();
    }

    private function initializeState()
    {
        switch ($this->Status) {
            case 'Draft':
                $this->state = new DraftState();
                break;
            case 'Pending':
                $this->state = new PendingState();
                break;
            case 'Accepted':
                $this->state = new AcceptedState();
                break;
            case 'Completed':
                $this->state = new CompletedState();
                break;
            case 'Declined':
                $this->state = new DeclinedState();
                break;
            default:
                throw new Exception("Invalid initial state: " . $this->Status);
        }
    }

    public function setState(RequestState $state)
    {
        $this->state = $state;
    }

    public function showStatus()
    {
        $this->state->printCurrentState();
    }

    public function executeNextState()
    {
        $this->state->nextState($this);
    }

    public function executePrevState()
    {
        $this->state->prevState($this);
    }

        
        public function getId()
        {
            return $this->Id;
        }
    
        public function setId($id)
        {
            $this->Id = $id;
        }
    
        public function getRefugeeId()
        {
            return $this->RefugeeId;
        }
    
        public function setRefugeeId($refugeeId)
        {
            $this->RefugeeId = $refugeeId;
        }
    
        public function getName()
        {
            return $this->Name;
        }
    
        public function setName($name)
        {
            $this->Name = $name;
        }
    
        public function getDescription()
        {
            return $this->Description;
        }
    
        public function setDescription($description)
        {
            $this->Description = $description;
        }
    
        public function getType()
        {
            return $this->Type;
        }
    
        public function setType($type)
        {
            $this->Type = $type;
        }
    
        public function getQuantity()
        {
            return $this->Quantity;
        }
    
        public function setQuantity($quantity)
        {
            $this->Quantity = $quantity;
        }
    
        public function getUserId()
        {
            return $this->UserId;
        }
    
        public function setUserId($userId)
        {
            $this->UserId = $userId;
        }
    
        public function getStatus()
        {
            return $this->Status;
        }
    
        public function getStatusComment()
        {
            return $this->StatusComment;
        }

    public function deductInventory()
    {
        $inventory = new Inventory();
        switch ($this->Type) {
            case 'Money':
                return $inventory->removeMoney(floatval($this->Quantity));
            case 'Clothes':
                return $inventory->removeClothesQuantity(intval($this->Quantity));
            case 'Food':
                return $inventory->removeFoodResourceQuantity(intval($this->Quantity));
            default:
                throw new Exception("Invalid request type.");
        }
    }
    

    public function save()
    {
        if (empty($this->RefugeeId)) {
            throw new Exception("Invalid RefugeeId: Cannot save a request without a valid RefugeeId.");
        }
    
        $db = DbConnection::getInstance();
        $sql = "
            INSERT INTO requests (RefugeeId, Name, Description, Type, Quantity, UserId, Status, StatusComment)
            VALUES ($this->RefugeeId, '$this->Name', '$this->Description', '$this->Type', '$this->Quantity', '$this->UserId', '$this->Status', '$this->StatusComment')
        ";
        $db->query($sql);
    
        $sql = "SELECT LAST_INSERT_ID() AS last;";
        $rows = $db->fetchAll($sql);
        foreach ($rows as $row) {
            return self::findById($row["last"]);
        }
    }
    

    public static function findById($id)
    {
        $db = DbConnection::getInstance();
        $sql = "SELECT * FROM requests WHERE Id = $id;";
        $rows = $db->fetchAll($sql);
        foreach ($rows as $request) {
            return new self(
                $request["Id"],
                $request["RefugeeId"],
                $request["Name"],
                $request["Description"],
                $request["Type"],
                $request["Quantity"],
                $request["UserId"],
                $request["Status"],
                $request["StatusComment"]
            );
        }
    }

    public static function all()
    {
        $db = DbConnection::getInstance();
        $sql = "SELECT * FROM requests;";
        $rows = $db->fetchAll($sql);
        $requests = [];
        foreach ($rows as $request) {
            $requests[] = new self(
                $request["Id"],
                $request["RefugeeId"],
                $request["Name"],
                $request["Description"],
                $request["Type"],
                $request["Quantity"],
                $request["UserId"],
                $request["Status"],
                $request["StatusComment"]
            );
        }
        return $requests ?? [];
    }


    public static function alladapter()
    {
        $db = DbConnection::getInstance();
        $sql = "SELECT * FROM requests;";
        $rows = $db->fetchAll($sql);
        return $rows ?? [];
    }

    

    public static function getRequestsByStatus($status)
    {//
        $db = DbConnection::getInstance();
        $sql = "SELECT * FROM requests WHERE Status = '$status';";
        $rows = $db->fetchAll($sql);
        $requests = [];
        foreach ($rows as $request) {
            $requests[] = new self(
                $request["Id"],
                $request["RefugeeId"],
                $request["Name"],
                $request["Description"],
                $request["Type"],
                $request["Quantity"],
                $request["UserId"],
                $request["Status"],
                $request["StatusComment"]
            );
        }
        return $requests ?? [];
    }

    public static function findByRefugeeId($id)
    {
        $db = DbConnection::getInstance();
        $sql = "SELECT * FROM requests WHERE UserId = $id;";
        $rows = $db->fetchAll($sql);
        $requests = [];
        foreach ($rows as $request) {
            $requests[] = new self(
                $request["Id"],
                $request["RefugeeId"],
                $request["Name"],
                $request["Description"],
                $request["Type"],
                $request["Quantity"],
                $request["UserId"],
                $request["Status"],
                $request["StatusComment"]
            );
        }
        return $requests ?? [];
    }

    public function updateStatus($status, $statusComment = null)
    {
        $this->Status = $status;
        $this->StatusComment = $statusComment;

        $db = DbConnection::getInstance();
        $sql = "
            UPDATE requests
            SET Status = '$status', StatusComment = '$statusComment'
            WHERE Id = $this->Id
        ";
        $db->query($sql);
    }
}
?>
