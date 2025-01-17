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
        $userid = $_SESSION['user']['id'];
        if ($data) {
            $request = new Request(
                null,
                $data['RefugeeId'] ?? null,
                $data['Name'] ?? null,
                $data['Description'] ?? null,
                $data['Type'] ?? null,
                $data['Quantity'] ?? null,
                $userid,
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
        $request->submit();
        // $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        // header('Location: ' . $base_url . '/requests/view/' . $id);
    }

    public function completeRequest($id)
    {
        $request = Request::findById($id);
        $request->complete();
        $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        header('Location: ' . $base_url . '/requests/view/' . $id);
    }

    public function declineRequest($id)
    {
        $request = Request::findById($id);
        $request->decline();
        $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        header('Location: ' . $base_url . '/requests/view/' . $id);
    }


    public function acceptRequest($id)
    {

        $request = Request::findById($id);
        $request->accept();
        $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        header('Location: ' . $base_url . '/requests/view/' . $id);
    }


    public function findRequestByIdAdmin()
    {
        // Fetch all requests from the database
        $requests = Request::alladapter();
    
        // Convert rows to an array of associative arrays (if needed)
        if (!is_array($requests)) {
            throw new Exception("Error: Data returned by alladapter is invalid.");
        }
    
        // Use the adapter to convert to JSON
        $adapter = new JSONAdapter();
        try {
            $adapter->ToJSON($requests);
        } catch (Exception $e) {
            echo " Error: " . $e->getMessage();
        }
    
        require 'Views/AdminRequestDetailsView.php';
    }
    
    //

    public function findRequestByIdRefugee()
    {
        session_start();
        $userid = $_SESSION['user']['id'];
        $requests = Request::findByRefugeeId($userid);
        echo renderRefugeeRequestsView($requests);
    }
}
?>







