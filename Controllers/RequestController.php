<?php
require_once __DIR__ . '/../Models/RequestModel.php';
require_once __DIR__ . '/../Models/InventoryModel.php';

class RequestController
{
    public function index()
    {
        $requests = Request::all();
        require 'Views/RequestsView.php';
    }

    public function add($data = null)
    {
        if ($data) {
            $request = new Request(
                null,
                $data['RefugeeId'] ?? null,
                $data['Name'] ?? null,
                $data['Description'] ?? null,
                $data['Type'] ?? null
            );
            $request = $request->save();
            $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
            header('Location: ' . $base_url . '/requests/view/' . $request->getId());
        } else {
            require 'Views/CreateRequestView.php';
        }
    }

    public function submitRequest($id)
    {
        $request = Request::findById($id);
        $request->submit();
        $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        header('Location: ' . $base_url . '/requests/view/' . $id);
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


    public function findRequestById($id)
    {
        $request = Request::findById($id);
        require 'Views/RequestDetailsView.php';
    }
}
?>
