<?php
include_once "SingletonDB.php";
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
    private $Type; // Type: 'Money', 'Clothes', 'Food'
    private $Status; // Status: 'Draft', 'Pending', 'Accepted', 'Completed', 'Declined'
    private $StatusComment;
    private RequestState $state;

    public function __construct($Id, $RefugeeId, $Name, $Description, $Type, $Status = 'Draft', $StatusComment = null)
    {
        $this->Id = $Id;
        $this->RefugeeId = $RefugeeId;
        $this->Name = $Name;
        $this->Description = $Description;
        $this->Type = $Type;
        $this->Status = $Status;
        $this->StatusComment = $StatusComment;
        $this->setState($Status);
    }

    // Setter methods
    public function setId($Id)
    {
        $this->Id = $Id;
    }

    public function setStatus($Status)
    {
        $this->Status = $Status;
    }

    public function setStatusComment($StatusComment)
    {
        $this->StatusComment = $StatusComment;
    }

    // Getter methods
    public function getId()
    {
        return $this->Id;
    }

    public function getRefugeeId()
    {
        return $this->RefugeeId;
    }

    public function getName()
    {
        return $this->Name;
    }

    public function getDescription()
    {
        return $this->Description;
    }

    public function getType()
    {
        return $this->Type;
    }

    public function getStatus()
    {
        return $this->Status;
    }

    public function getStatusComment()
    {
        return $this->StatusComment;
    }

        // Deduct inventory based on request type
        private function deductInventory()
        {
            $inventory = new Inventory();
    
            switch ($this->Type) {
                case 'Money':
                    $amount = floatval($this->Description); // Assuming `Description` contains the amount for money requests
                    return $inventory->removeMoney($amount);
                case 'Clothes':
                    $quantity = intval($this->Description); // Assuming `Description` contains the quantity for clothes
                    return $inventory->removeClothesQuantity($quantity);
                case 'Food':
                    $quantity = intval($this->Description); // Assuming `Description` contains the quantity for food
                    return $inventory->removeFoodResourceQuantity($quantity);
                default:
                    throw new Exception("Invalid request type.");
            }
        }

    private function setState($status)
    {
        switch ($status) {
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
                throw new Exception("Invalid request state.");
        }
    }

    public function submit()
    {
        $this->state->submit($this);
        $this->setState('Pending'); // Update state dynamically
    }
    
    public function accept()
    {
        $this->state->accept($this);
        $this->setState('Accepted'); // Update state dynamically
    }
    
    public function complete()
    {
        // Attempt to deduct inventory
        if ($this->deductInventory()) {
            $this->state->complete($this);
            $this->setState('Completed'); // Update state dynamically
            echo "Request completed and inventory updated successfully.\n";
        } else {
            throw new Exception("Insufficient inventory to complete the request.");
        }
    }
    
    public function decline()
    {
        $this->state->decline($this);
        $this->setState('Declined'); // Update state dynamically
    }
    

    // Save request to the database
    public function save()
    {
        $db = DbConnection::getInstance();
        $sql = "
            INSERT INTO requests (RefugeeId, Name, Description, Type, Status, StatusComment)
            VALUES ($this->RefugeeId, '$this->Name', '$this->Description', '$this->Type', '$this->Status', '$this->StatusComment')
        ";
        $db->query($sql);
        $sql = "SELECT LAST_INSERT_ID() AS last;";
        $rows = $db->fetchAll($sql);
        foreach ($rows as $row) {
            return self::findById($row["last"]);
        }
    }

    // Find a request by ID
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
                $request["Status"],
                $request["StatusComment"]
            );
        }
    }

    // Get all requests
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
                $request["Status"],
                $request["StatusComment"]
            );
        }
        return $requests ?? [];
    }

    // Get requests by status
    public static function getRequestsByStatus($status)
    {
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
                $request["Status"],
                $request["StatusComment"]
            );
        }
        return $requests ?? [];
    }

    // Update the status of a request
    public function updateStatus($status, $statusComment = null)
    {
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
