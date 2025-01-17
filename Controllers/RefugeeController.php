<?php
require_once __DIR__ . '/../Models/RefugeeModel.php';
require_once __DIR__ . "/RegisterService.php";
require_once __DIR__ . '/../Views/ViewRefugee.php';
require_once __DIR__ . '/../Views/AddRefugeeView.php';
require_once __DIR__ . '/../Views/EditRefugeeView.php';
require_once __DIR__ . '/../Views/RefugeeView.php';

class RefugeeController
{
    public function index()
    {
        $refugees = Refugee::all();
        $rIterator = $refugees->createIterator();
        echo renderRefugeeListView($refugees, $rIterator);
    }

    public function add($data = null)
    {
        $workers = [];
        echo renderAddRefugeeView($workers);
    }

    public function edit($data = null)
    {
        if ($data) {
            $refugee = Refugee::findById($data['id']);
            echo renderEditRefugeeView($refugee);
        } else {
            $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
            header('Location: ' . $base_url . '/refugees');
        }
    }

    public function update($data)
    {
        $registerService = new RegisterService();
        $commonErrors = $registerService->validateUserData($data, true);
        $strategy = RegistrationFactory::createStrategy('refugee', $data);
        $specificErrors = $strategy->validate();
        $errors = array_merge($commonErrors, $specificErrors);
        if (!empty($errors)) {
            $refugee = Refugee::findById($data['id']);
            echo renderEditRefugeeView($refugee, $errors);
            return;
        }
        $refugee = Refugee::findById($data['id']);
        $refugee->update($data);
        $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        header('Location: ' . $base_url . '/refugees');
    }

    public function delete($id)
    {
        $refugee = Refugee::findById($id);
        $refugee->delete();
        $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        header('Location: ' . $base_url . '/refugees');
    }

    public function view($id)
    {
        $refugee = Refugee::findById($id);
        echo renderRefugeeView($refugee);
    }

    public function findRefugeeById($id)
    {
        $refugee = Refugee::findById($id);
        echo renderRefugeeView($refugee);
    }
}
