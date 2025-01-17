<?php
require_once __DIR__ . '/../Models/RequestModel.php';
require_once __DIR__ . '/../Models/Adapter.php';
require_once __DIR__ . '/../Models/InventoryModel.php';
include __DIR__ . '/../Views/RefugeeRequestDetailsView.php';

class RequestController
{
    public function index()
    {
        $requests = Request::all();
        require 'Views/RequestsView.php';
    }

    public function add($data = null)
    {
        session_start();
        $userId = $_SESSION['user']['id']; 
        $db = DbConnection::getInstance();
    

        $refugee = $db->fetchAll("SELECT Id FROM Refugee WHERE UserId = $userId");
        if (empty($refugee)) {
            $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
            header('Location: ' . $base_url . '/requests/create?error=No associated refugee profile found for your account.');
            return;
        }
    
        $refugeeId = $refugee[0]['Id']; 
        $_SESSION['refugeeId'] = $refugeeId; 
    
        if ($data) {

            $request = new Request(
                null,
                $refugeeId,
                $data['Name'] ?? null,
                $data['Description'] ?? null,
                $data['Type'] ?? null,
                $data['Quantity'] ?? null,
                $userId
            );
            $request = $request->save();
            $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
            header('Location: ' . $base_url . '/requests/viewrefugee/' . $request->getId());
        } else {
            require 'Views/CreateRequestView.php';
        }
    }
    
    

    public function submitRequest($id)
    {
        $request = Request::findById($id);
        $request->executeNextState();
    }

    public function nextStateRequest($id)
    {
        $request = Request::findById($id);
    
        $request->executeNextState();

        $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        header('Location: ' . $base_url . '/requests/view/' . $id);
    }

    public function previousStateRequest($id)
{
    $request = Request::findById($id);

    $request->executePrevState();

    $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
    header('Location: ' . $base_url . '/requests/view/' . $id);
}


    public function declineRequest($id)
    {
        $request = Request::findById($id);
    
        if ($request->getStatus() === 'Completed') {
            echo "Error: A completed request cannot be declined.";
            return;
        }
    

        $request->setState(new DeclinedState());
        $request->updateStatus('Declined');
        echo "Request has been manually set to Declined state.\n";
    }

    public function findRequestByIdAdmin()
    {
        $requests = Request::alladapter();

        if (!is_array($requests)) {
            throw new Exception("Error: Data returned by alladapter is invalid.");
        }

        $adapter = new JSONAdapter();
        try {
            $adapter->ToJSON($requests);
        } catch (Exception $e) {
            echo " Error: " . $e->getMessage();
        }

        require 'Views/AdminRequestDetailsView.php';
    }

    public function findRequestByIdRefugee()
    {
        session_start();
        $userId = $_SESSION['user']['id'];
        $requests = Request::findByRefugeeId($userId);
        echo renderRefugeeRequestsView($requests);
    }
}
?>
