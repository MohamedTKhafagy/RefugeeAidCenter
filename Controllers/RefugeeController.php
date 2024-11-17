<?php
require_once __DIR__ . '/../Models/RefugeeModel.php';


class RefugeeController
{

    public function index()
    {
        $refugees = Refugee::all();
        require 'Views/RefugeeView.php';
    }

    public function add($data = null)
    {
        if ($data) {
            $this->saveRefugee($data);
            $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
            header('Location: ' . $base_url . '/refugees');
        }
        else {
            require 'Views/AddRefugeeView.php';
        }
    }

    public function edit($data = null) {
        if($data) {
            $refugee = Refugee::findById($data['id']);
            require 'Views/EditRefugeeView.php';
        }
        else {
            $base_url = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
            header('Location: ' . $base_url . '/refugees');
        }
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
            $data['RefugeeID'],
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

?>