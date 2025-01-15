<?php
require_once __DIR__ . '/../Models/RefugeeModel.php';
// require_once __DIR__ . '/../Models/VolunteerModel.php';
require_once __DIR__ . "/RegisterService.php";


class RefugeeController
{

    public function index()
    {
        $refugees = Refugee::all();
        require 'Views/RefugeeView.php';
    }

    public function add($data = null)
    {
        $workers = [];
        require 'Views/AddRefugeeView.php';
    }

    public function edit($data = null)
    {
        if ($data) {
            $refugee = Refugee::findById($data['id']);
            require 'Views/EditRefugeeView.php';
        } else {
            $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
            header('Location: ' . $base_url . '/refugees');
        }
    }

    public function update($data) {
        $registerService = new RegisterService();
        $commonErrors = $registerService->validateUserData($data, true);
        $strategy = $registerService->getRegisterationStrategy("adult");
        $specificErrors = $strategy->validate($data);
        $errors = array_merge($commonErrors, $specificErrors);
        if (!empty($errors)) {
            $refugee = Refugee::findById($data['id']);
            require 'Views/EditRefugeeView.php';
            return;
        }
        $refugee = Refugee::findById($data['id']);
        $refugee->update($data);
        $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        header('Location: ' . $base_url . '/refugees');
    }

    public function delete($id) {
        $refugee = Refugee::findById($id);
        $refugee->delete();
        $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        header('Location: ' . $base_url . '/refugees');
    }

    public function view($id)
    {
        $refugee = Refugee::findById($id);
        require 'Views/ViewRefugee.php';
    }

    public function saveRefugee($data)
    {
        $refugee = new Refugee(
            $data['Id'],
            $data['Name'],
            $data['Age'],
            $data['Gender'],
            $data['Address'],
            $data['Phone'],
            $data['Nationality'],
            $data['Type'],
            $data['Email'],
            $data['Preference'],
            $data['PassportNumber'],
            $data['Advisor'],
            $data['Shelter'],
            $data['HealthCare']
        );
        $refugee->save();
    }

    public function findRefugeeById($id)
    {
        $refugee = Refugee::findById($id);
        require 'Views/RefugeeView.php';
    }
}
